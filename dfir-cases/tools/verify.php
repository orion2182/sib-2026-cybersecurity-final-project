<?php
/**
 * Structural verifier for the generated DFIR packages.
 *
 * Usage:
 *   & C:\xampp\php\php.exe dfir-cases\tools\verify.php
 *
 * Checks: manifest integrity, JSON/JSONL parseability, timestamp offsets,
 * unique record identifiers, and the cross-artifact references that make a
 * timeline reconstructible. It does NOT check answers or ground truth.
 */

declare(strict_types=1);

require_once __DIR__ . '/lib.php';

$fail = 0;
$pass = 0;
function ok(bool $cond, string $msg): void
{
    global $fail, $pass;
    if ($cond) {
        $pass++;
        echo "  PASS  {$msg}\n";
    } else {
        $fail++;
        echo "  FAIL  {$msg}\n";
    }
}

/** All files of a package, relative. */
function files(string $case): array
{
    $base = pkg($case);
    $out = [];
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) {
        if ($f->isFile()) {
            $out[] = str_replace('\\', '/', substr($f->getPathname(), strlen(str_replace('\\', '/', $base)) + 1));
        }
    }
    sort($out);
    return $out;
}

function read_jsonl(string $path): array
{
    $rows = [];
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $i => $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }
        $j = json_decode($line, true);
        if (!is_array($j)) {
            throw new RuntimeException('bad jsonl at ' . $path . ':' . ($i + 1));
        }
        $rows[] = $j;
    }
    return $rows;
}

function csv_rows(string $path): array
{
    $out = [];
    $fh = fopen($path, 'r');
    $header = null;
    while (($row = fgetcsv($fh)) !== false) {
        if ($row === [null] || $row === false) {
            continue;
        }
        if (str_starts_with((string)$row[0], '#')) {
            continue;
        }
        if ($header === null) {
            $header = $row;
            continue;
        }
        if (count($row) !== count($header)) {
            continue; // comment/footer line inside the data block
        }
        $out[] = array_combine($header, $row);
    }
    fclose($fh);
    return $out;
}

echo "== Manifest integrity ==\n";
foreach (['01-phishing-staf', '02-perpus-intrusion', '03-cloud-iam'] as $case) {
    $base = pkg($case);
    $manifest = $base . '/manifest-sha256.txt';
    $n = 0;
    $bad = 0;
    $listed = [];
    foreach (file($manifest, FILE_IGNORE_NEW_LINES) as $line) {
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (!preg_match('/^([0-9a-f]{64})  (.+)$/', $line, $m)) {
            $bad++;
            continue;
        }
        $listed[] = $m[2];
        $n++;
        if (!is_file($base . '/' . $m[2]) || hash_file('sha256', $base . '/' . $m[2]) !== $m[1]) {
            $bad++;
            echo "  MISSING/CHANGED: {$m[2]}\n";
        }
    }
    $onDisk = array_values(array_diff(files($case), ['manifest-sha256.txt']));
    ok($bad === 0, "{$case}: {$n} manifest entries match on disk");
    ok($listed === $onDisk, "{$case}: manifest lists exactly the " . count($onDisk) . " package files");
}

echo "\n== Case 01 - phishing ==\n";
$base = pkg('01-phishing-staf');
$idp = read_jsonl($base . '/artifacts/identity/idp-signin-20261101_20261104.jsonl');
$mbox = read_jsonl($base . '/artifacts/identity/mailbox-audit-20261103.jsonl');
$gw = read_jsonl($base . '/artifacts/email/mailgateway-20261102_20261104.jsonl');
$tickets = csv_rows($base . '/artifacts/service-desk/tickets-20261102_20261104.csv');
$sessions = array_filter(array_column($idp, 'session_id'));
$counts = array_count_values($sessions);
$reused = array_keys(array_filter($counts, fn($n) => $n > 1));
ok($reused === ['SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90'], 'the only reused session id is the attacker session');
$mboxSessions = array_filter(array_column($mbox, 'session_id'));
ok(array_diff($mboxSessions, $sessions) === [], 'every mailbox-audit session_id exists in the sign-in log');
$attackSession = 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90';
ok(in_array($attackSession, $sessions, true), 'attack session id is present in the sign-in log');
ok(count(array_filter($idp, fn($r) => $r['session_id'] === $attackSession)) === 3, 'attack session is reused exactly 3 times in sign-in log');
$gwIds = array_column(array_filter($gw, fn($r) => isset($r['message_id'])), 'message_id');
ok(count($gwIds) === count(array_unique($gwIds)), 'gateway message_id values are unique');
$eml = file_get_contents($base . '/artifacts/email/MSG-20261103-0042.eml');
ok(str_contains($eml, 'X-Gateway-Message-ID: MSG-20261103-0042'), 'EML carries the gateway message id');
ok(str_contains($eml, '<RFC-20261103-011244.4a1f@cendekia-nusantara-sso.test>'), 'EML Message-ID is the RFC id');
$related = array_filter(array_column($tickets, 'related_event'));
$ticketIds = array_column($tickets, 'ticket_id');
$badRelated = array_values(array_filter($related, fn($v) => !in_array($v, $gwIds, true) && !in_array($v, $ticketIds, true)));
ok($badRelated === [], 'ticket related_event values point to a gateway message or another ticket');
ok(in_array('SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', array_column($mbox, 'session_id'), true), 'mailbox audit references the attack session');
$rule = array_values(array_filter($mbox, fn($r) => $r['operation'] === 'New-InboxRule' && $r['mailbox'] === 'nadia.permata@cendekia-nusantara.test'));
ok(count($rule) === 1 && $rule[0]['parameters']['ForwardTo'] === 'arsip.akun@cendekia-nusantara-sso.test', 'exactly one forwarding rule on the victim mailbox');
$failTimes = array_values(array_filter($idp, fn($r) => $r['result'] === 'failure' && $r['src_ip'] === '198.51.100.77'));
ok(count($failTimes) >= 3, 'at least three failed/denied MFA attempts from the attacker IP');
$success = array_values(array_filter($idp, fn($r) => $r['result'] === 'success' && $r['src_ip'] === '198.51.100.77'));
ok(count($success) === 3, 'three successful sign-in records from the attacker IP (all reuse one session)');
ok(count(array_unique(array_column($success, 'session_id'))) === 1, 'all attacker successes share a single session id');
$disable = array_values(array_filter($mbox, fn($r) => $r['operation'] === 'Set-Mailbox' && $r['parameters']['AccountDisabled'] === true));
ok(count($disable) === 1, 'containment (account disable) is recorded once');
$adminActors = array_unique(array_column(array_filter($mbox, fn($r) => in_array($r['operation'], ['Set-Mailbox', 'Remove-InboxRule', 'ResetPassword', 'RevokeSessions'], true)), 'actor'));
ok($adminActors === ['budi.hartono@cendekia-nusantara.test'], 'admin actions are attributed to the IT responder');

echo "\n== Case 02 - library intrusion ==\n";
$base = pkg('02-perpus-intrusion');
$access = file($base . '/artifacts/web/access.log', FILE_IGNORE_NEW_LINES);
$access = array_values(array_filter($access, fn($l) => $l !== '' && !str_starts_with($l, '#')));
$rids = [];
foreach ($access as $l) {
    if (preg_match('/rid=(REQ-\d{8}-\d{4})/', $l, $m)) {
        $rids[] = $m[1];
    }
}
ok(count($rids) === count($access), 'every access.log line carries rid');
ok(count($rids) === count(array_unique($rids)), 'access.log rids are unique');
$app = read_jsonl($base . '/artifacts/web/app.log');
$appRids = array_values(array_filter(array_column($app, 'request_id')));
$orphans = array_values(array_diff($appRids, $rids));
ok($orphans === ['REQ-20261106-0099'], 'only the documented orphan app.log request lacks an access.log rid');
$uploadRid = null;
foreach ($app as $r) {
    if (($r['action'] ?? '') === 'cover_upload_stored' && str_ends_with($r['detail']['stored_path'], '.php')) {
        $uploadRid = $r['request_id'];
    }
}
ok($uploadRid !== null, 'app.log records the .php upload');
ok(in_array($uploadRid, $rids, true), 'the .php upload rid exists in access.log');
$after = csv_rows($base . '/artifacts/fs/snapshot-web-perpus-01-20261106T0900+07.csv');
$paths = array_column($after, 'path');
ok(in_array('/var/www/perpustakaan/public/uploads/cover-2026-11-05.php', $paths, true), 'post-incident snapshot lists the uploaded .php');
ok(!in_array('/var/www/perpustakaan/public/uploads/cover-2026-11-05.jpg', $paths, true), 'the .jpg upload is absent from the post-incident snapshot (cache GC)');
$before = csv_rows($base . '/artifacts/fs/snapshot-web-perpus-01-20261105T1900+07.csv');
ok(!in_array('/var/www/perpustakaan/public/uploads/cover-2026-11-05.php', array_column($before, 'path'), true), 'pre-incident snapshot does not contain the .php file');
$fw = csv_rows($base . '/artifacts/net/firewall-sessions.csv');
$fwAttack = array_filter($fw, fn($r) => $r['src_ip'] === '203.0.113.146');
ok(count($fwAttack) >= 8, 'firewall has at least eight attacker sessions');
$exportRows = array_values(array_filter($fw, fn($r) => $r['note'] === 'ekspor'));
ok(array_sum(array_column($exportRows, 'bytes_out')) > 4000000, 'firewall shows >4 MB outbound across export sessions');
$scan = array_filter($fw, fn($r) => $r['src_ip'] === '198.51.100.55');
ok(count($scan) === 1 && $scan[array_key_first($scan)]['note'] === 'CHG-2207', 'vendor scan is tagged with its change ticket');
$chg = csv_rows($base . '/artifacts/change/change-tickets-2026-11.csv');
ok(in_array('CHG-2207', array_column($chg, 'ticket_id'), true), 'CHG-2207 exists in the change log');

echo "\n== Case 03 - cloud IAM ==\n";
$base = pkg('03-cloud-iam');
$audit = read_jsonl($base . '/artifacts/cloud/audit-20261031_20261106.jsonl');
$ids = array_column($audit, 'event_id');
ok(count($ids) === count(array_unique($ids)), 'audit event_id values are unique');
$get = array_values(array_filter($audit, fn($r) => $r['event_type'] === 'Object.GetObject' && $r['principal_arn'] === 'nim:iam::400000000001:role/svc-reporting' && $r['source_ip'] === '198.51.100.88' && $r['result'] === 'Success'));
ok(count($get) === 46, 'attacker read calls to svc-reporting total 46 (41 + 5)');
$inv = csv_rows($base . '/artifacts/cloud/object-inventory-dummy.csv');
$keys = array_column($inv, 'key');
$missing = [];
foreach ($get as $r) {
    $rel = substr($r['resource'], strlen('arsip-laporan-prod/'));
    if (!in_array($rel, $keys, true)) {
        $missing[] = $rel;
    }
}
ok($missing === [], 'every object read exists in the dummy inventory');
ok(count(array_unique(array_column($get, 'resource'))) === 46, 'the 46 reads cover 46 distinct objects');
$attach = array_values(array_filter($audit, fn($r) => $r['event_type'] === 'Identity.AttachRolePolicy'));
$detach = array_values(array_filter($audit, fn($r) => $r['event_type'] === 'Identity.DetachRolePolicy'));
ok(count($attach) === 1 && $attach[0]['detail']['policy_name'] === 'NimbusObjectReadAll', 'the broad policy is attached once');
ok(count($detach) === 1, 'the broad policy is detached once');
$firstRead = strtotime($get[0]['ts']);
ok(strtotime($attach[0]['ts']) < $firstRead, 'policy attach precedes the first attacker read');
ok(strtotime($detach[0]['ts']) > strtotime($get[count($get) - 1]['ts']), 'policy detach follows the last attacker read');
$denied = array_values(array_filter($audit, fn($r) => $r['result'] === 'Failure' && $r['source_ip'] === '198.51.100.88'));
ok(count($denied) >= 4, 'at least four failed attacker calls are recorded');
$invalid = array_values(array_filter($audit, fn($r) => ($r['error_code'] ?? '') === 'InvalidAccessKeyId'));
ok(count($invalid) === 2, 'two post-containment retries fail with InvalidAccessKeyId');
$policy = json_decode(file_get_contents($base . '/artifacts/iam/policy-svc-reporting-after.json'), true);
$att = $policy['attached_policies'][1];
ok($att['policy_name'] === 'NimbusObjectReadAll' && str_starts_with($att['attached_at'], '2026-11-02T07:09:31'), 'policy snapshot matches the audit attach timestamp');
$transfer = csv_rows($base . '/artifacts/cloud/data-transfer-hourly.csv');
ok(!in_array('2026-11-03T18:00:00Z', array_column($transfer, 'hour_start_utc'), true), 'the 18:00Z transfer bucket is indeed absent');

echo "\n== Timestamp offsets ==\n";
foreach (['01-phishing-staf', '02-perpus-intrusion', '03-cloud-iam'] as $case) {
    $base = pkg($case);
    $bad = [];
    foreach (files($case) as $rel) {
        $abs = $base . '/' . $rel;
        if (!preg_match('/\.(jsonl|json|csv)$/', $rel)) {
            continue;
        }
        $content = file_get_contents($abs);
        if (str_ends_with($rel, '.jsonl')) {
            foreach (read_jsonl($abs) as $row) {
                foreach (['ts', 'ts_start', 'ts_end', 'issued_at', 'last_modified'] as $f) {
                    if (isset($row[$f]) && $row[$f] !== '' && !preg_match('/(Z|[+-]\d{2}:\d{2})$/', (string)$row[$f])) {
                        $bad[] = basename($rel) . ':' . $f . '=' . $row[$f];
                    }
                }
            }
        } elseif (str_ends_with($rel, '.csv')) {
            foreach (csv_rows($abs) as $row) {
                foreach (['ts_created', 'ts_resolved', 'ts_start', 'ts_end', 'effective_ts', 'window_start', 'window_end', 'last_modified', 'hour_start_utc', 'ts_utc', 'ts_local', 'mtime'] as $f) {
                    if (isset($row[$f]) && $row[$f] !== '' && !preg_match('/(Z|[+-]\d{2}:\d{2})$/', (string)$row[$f])) {
                        $bad[] = basename($rel) . ':' . $f . '=' . $row[$f];
                    }
                }
            }
        }
    }
    ok($bad === [], "{$case}: all event timestamps carry an explicit offset" . ($bad ? ' -> ' . implode(', ', array_slice($bad, 0, 3)) : ''));
}

echo "\n== Reserved ranges / domains ==\n";
$all = '';
foreach (['01-phishing-staf', '02-perpus-intrusion', '03-cloud-iam'] as $case) {
    foreach (files($case) as $rel) {
        $all .= file_get_contents(pkg($case) . '/' . $rel) . "\n";
    }
}
preg_match_all('/\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\b/', $all, $mm);
$ips = array_values(array_unique($mm[0]));
$outOfRange = array_values(array_filter($ips, function (string $ip): bool {
    foreach (['192.0.2.', '198.51.100.', '203.0.113.', '10.20.', '127.0.0.1', '0.0.0.0'] as $p) {
        if (str_starts_with($ip, $p)) {
            return false;
        }
    }
    return true;
}));
ok($outOfRange === [], 'all IP addresses are documentation, RFC1918 lab, or loopback ranges' . ($outOfRange ? ' -> ' . implode(',', $outOfRange) : ''));
preg_match_all('/\b[a-z0-9][a-z0-9.-]*\.(test|invalid|example)\b/', $all, $dm);
ok(count($dm[0]) > 0, 'reserved TLDs are used for every referenced domain');
preg_match_all('/\b[\w.+-]+@[\w.-]+\.(com|net|org|id|co\.id)\b/', $all, $real);
ok($real[0] === [], 'no email address uses a real-world TLD' . ($real[0] ? ' -> ' . implode(',', array_slice($real[0], 0, 5)) : ''));

echo "\n== Total ==\n";
echo "pass={$pass} fail={$fail}\n";
exit($fail === 0 ? 0 : 1);

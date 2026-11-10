<?php
declare(strict_types=1);

/**
 * Build a small, inert PCAP and SQLite evidence prototype for the DFIR binary
 * artifact decision. Output stays instructor-only.
 *
 * Usage: php tools/build-binary-prototype.php
 */

$repoRoot = dirname(__DIR__);
$outDir = dirname($repoRoot) . '/instructor-private/dfir/optional-binary';
if (!is_dir($outDir)) {
    mkdir($outDir, 0777, true);
}

function ip_checksum(string $data): int
{
    $sum = 0;
    $len = strlen($data);
    for ($i = 0; $i < $len; $i += 2) {
        $word = unpack('n', substr($data, $i, 2))[1];
        $sum += $word;
    }
    while ($sum >> 16) {
        $sum = ($sum & 0xFFFF) + ($sum >> 16);
    }
    return ~$sum & 0xFFFF;
}

function ip4(string $src, string $dst, int $proto, string $payload, int $id): string
{
    $total = 20 + strlen($payload);
    $header = pack('C', 0x45) . pack('C', 0) . pack('n', $total) . pack('n', $id)
        . pack('n', 0x4000) . pack('C', 64) . pack('C', $proto) . pack('n', 0)
        . inet_pton($src) . inet_pton($dst);
    $checksum = ip_checksum($header);
    $header = substr($header, 0, 10) . pack('n', $checksum) . substr($header, 12);
    return $header . $payload;
}

function ethernet(string $payload, int $etherType = 0x0800): string
{
    $dst = hex2bin('020000000002');
    $src = hex2bin('020000000001');
    return $dst . $src . pack('n', $etherType) . $payload;
}

function dns_query(int $id, string $name, string $answerIp = ''): string
{
    $flags = $answerIp === '' ? 0x0100 : 0x8180;
    $header = pack('n', $id) . pack('n', $flags) . pack('n', 1) . pack('n', $answerIp === '' ? 0 : 1)
        . pack('n', 0) . pack('n', 0);
    $qname = '';
    foreach (explode('.', $name) as $label) {
        $qname .= chr(strlen($label)) . $label;
    }
    $qname .= "\0";
    $question = $qname . pack('n', 1) . pack('n', 1);
    $answer = '';
    if ($answerIp !== '') {
        $answer = "\xC0\x0C" . pack('n', 1) . pack('n', 1) . pack('N', 60)
            . pack('n', 4) . inet_pton($answerIp);
    }
    return $header . $question . $answer;
}

function udp(int $sport, int $dport, string $payload): string
{
    $len = 8 + strlen($payload);
    return pack('n', $sport) . pack('n', $dport) . pack('n', $len) . pack('n', 0) . $payload;
}

function tcp_syn(int $sport, int $dport, int $seq): string
{
    return pack('n', $sport) . pack('n', $dport) . pack('N', $seq) . pack('N', 0)
        . pack('C', 0x50) . pack('C', 0x02) . pack('n', 64240) . pack('n', 0) . pack('n', 0);
}

$pcap = pack('V', 0xa1b2c3d4) . pack('n', 2) . pack('n', 4)
    . pack('V', 0) . pack('V', 0) . pack('V', 65535) . pack('V', 1);
$frameIndex = 0;
$append = static function (string $frame, int $sec, int $usec) use (&$pcap, &$frameIndex): void {
    $frameIndex++;
    $pcap .= pack('V', $sec) . pack('V', $usec) . pack('V', strlen($frame)) . pack('V', strlen($frame)) . $frame;
};

$queryName = 'sync-a1b2c3.telemetry-sink.example';
$answerIp = '203.0.113.90';
$base = 1793491200; // 2026-11-01T00:00:00Z, fixed for reproducibility

$q = dns_query(0x1234, $queryName);
$append(ethernet(ip4('198.51.100.64', '198.51.100.53', 17, udp(53000, 53, $q), 1)), $base, 100000);
$r = dns_query(0x1234, $queryName, $answerIp);
$append(ethernet(ip4('198.51.100.53', '198.51.100.64', 17, udp(53, 53000, $r), 2)), $base, 120000);
$syn = tcp_syn(51000, 443, 1000);
$append(ethernet(ip4('198.51.100.64', $answerIp, 6, $syn, 3)), $base, 150000);

$pcapPath = $outDir . '/beacon-slice.pcap';
file_put_contents($pcapPath, $pcap);

// SQLite evidence slice.
$dbPath = $outDir . '/beacon-events.sqlite';
if (is_file($dbPath)) {
    unlink($dbPath);
}
$pdo = new PDO('sqlite:' . $dbPath);
$pdo->exec('CREATE TABLE dns_events (event_id TEXT PRIMARY KEY, ts_utc TEXT, host TEXT, query TEXT, answer TEXT)');
$stmt = $pdo->prepare('INSERT INTO dns_events VALUES (?,?,?,?,?)');
for ($i = 0; $i < 6; $i++) {
    $stmt->execute([
        sprintf('SOC3-T-%04d', 7 + $i * 2),
        gmdate('Y-m-d\TH:i:s\Z', $base + $i * 300),
        'WS-0501',
        $queryName,
        $answerIp,
    ]);
}

printf("PCAP:   %s (%d bytes, %d frames)\n", $pcapPath, filesize($pcapPath), $frameIndex);
printf("SQLite: %s (%d rows)\n", $dbPath, (int) $pdo->query('SELECT COUNT(*) FROM dns_events')->fetchColumn());

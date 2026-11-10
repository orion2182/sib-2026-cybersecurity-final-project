<?php
declare(strict_types=1);

/**
 * Verify the optional binary prototype without external forensic tools.
 * Usage: php tools/verify-binary.php
 */

$repoRoot = realpath(dirname(__DIR__));
$dir = $repoRoot . '/../instructor-private/dfir/optional-binary';
$pcapPath = $dir . '/beacon-slice.pcap';
$dbPath = $dir . '/beacon-events.sqlite';
$errors = [];

if (!is_file($pcapPath)) {
    $errors[] = 'pcap missing';
} else {
    $data = (string) file_get_contents($pcapPath);
    if (strlen($data) < 24) {
        $errors[] = 'pcap too short';
    } else {
        $magic = unpack('V', substr($data, 0, 4))[1];
        if ($magic !== 0xa1b2c3d4) {
            $errors[] = 'bad pcap magic';
        }
        $offset = 24;
        $frames = 0;
        $dnsSeen = false;
        $destSeen = false;
        while ($offset + 16 <= strlen($data)) {
            $rec = unpack('Vsec/Vusec/Vincl/Vorig', substr($data, $offset, 16));
            $offset += 16;
            if ($offset + $rec['incl'] > strlen($data)) {
                $errors[] = 'truncated frame';
                break;
            }
            $frame = substr($data, $offset, $rec['incl']);
            $offset += $rec['incl'];
            $frames++;
            if (str_contains($frame, 'telemetry-sink')) {
                $dnsSeen = true;
            }
            if (str_contains($frame, inet_pton('203.0.113.90'))) {
                $destSeen = true;
            }
        }
        if ($frames !== 3) {
            $errors[] = "expected 3 frames, got $frames";
        }
        if (!$dnsSeen) {
            $errors[] = 'DNS query name not found in frames';
        }
        if (!$destSeen) {
            $errors[] = 'destination address not found in frames';
        }
        echo 'PCAP: frames=' . $frames
            . ' dns=' . ($dnsSeen ? 'yes' : 'no')
            . ' dest=' . ($destSeen ? 'yes' : 'no') . "\n";
    }
}

if (!is_file($dbPath)) {
    $errors[] = 'sqlite missing';
} else {
    $pdo = new PDO('sqlite:' . $dbPath, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $count = (int) $pdo->query('SELECT COUNT(*) FROM dns_events')->fetchColumn();
    $distinct = (int) $pdo->query('SELECT COUNT(DISTINCT query) FROM dns_events')->fetchColumn();
    if ($count !== 6) {
        $errors[] = "expected 6 sqlite rows, got $count";
    }
    echo "SQLite: rows=$count distinct_queries=$distinct\n";
}

if ($errors) {
    fwrite(STDERR, "BINARY PROTOTYPE FAILED\n");
    foreach ($errors as $error) {
        fwrite(STDERR, "  - $error\n");
    }
    exit(1);
}
echo "BINARY PROTOTYPE OK\n";
exit(0);

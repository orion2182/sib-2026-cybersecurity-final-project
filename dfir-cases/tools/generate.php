<?php
/**
 * Generator for the three synthetic DFIR participant evidence packages.
 *
 * Usage (from the repository root, PowerShell):
 *   & C:\xampp\php\php.exe dfir-cases\tools\generate.php
 *
 * Output: dfir-cases/01-phishing-staf, 02-perpus-intrusion, 03-cloud-iam
 * including a fresh manifest-sha256.txt per package.
 *
 * This script contains only participant-visible synthetic data. Instructor
 * answer keys live outside the public repository (instructor-private/dfir/).
 */

declare(strict_types=1);

require_once __DIR__ . '/lib.php';
require_once __DIR__ . '/case-01-phishing.php';
require_once __DIR__ . '/case-02-perpus.php';
require_once __DIR__ . '/case-03-cloud.php';

$cases = [
    'build_case_01',
    'build_case_02',
    'build_case_03',
];

foreach ($cases as $fn) {
    $fn();
    echo "built: {$fn}\n";
}

foreach (['01-phishing-staf', '02-perpus-intrusion', '03-cloud-iam'] as $c) {
    $s = package_stats($c);
    printf("%-20s files=%-3d bytes=%d (%.1f KB)\n", $c, $s['files'], $s['bytes'], $s['bytes'] / 1024);
}

<?php
/**
 * Shared helpers for the synthetic DFIR evidence-package generator.
 *
 * Scope: builds participant packages only (dfir-cases/<case>/).
 * Instructor keys are NOT generated here on purpose: the generator lives in a
 * public repository, so it must never contain ground truth or answer keys.
 *
 * All data is synthetic. Reserved documentation IP ranges, .test domains,
 * fictional organisations and non-functional placeholder payloads only.
 */

declare(strict_types=1);

const REPO_ROOT = __DIR__ . '/../..';

/** Absolute path of a package file. */
function pkg(string $case, string $rel = ''): string
{
    $base = REPO_ROOT . '/dfir-cases/' . $case;
    return $rel === '' ? $base : $base . '/' . ltrim($rel, '/');
}

/** Write a file, creating parent directories, normalising to LF. */
function put(string $path, string $content): void
{
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
        throw new RuntimeException('cannot create ' . $dir);
    }
    $content = str_replace("\r\n", "\n", $content);
    if (!str_ends_with($content, "\n")) {
        $content .= "\n";
    }
    if (file_put_contents($path, $content) === false) {
        throw new RuntimeException('cannot write ' . $path);
    }
}

/** RFC4180-ish CSV row. */
function csv_row(array $cols): string
{
    $out = [];
    foreach ($cols as $c) {
        $c = (string)$c;
        if ($c === '' || preg_match('/[",\n\r]/', $c)) {
            $out[] = '"' . str_replace('"', '""', $c) . '"';
        } else {
            $out[] = $c;
        }
    }
    return implode(',', $out);
}

/** One JSON object per line, ordered keys preserved, slashes unescaped. */
function jline(array $v): string
{
    return json_encode($v, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION) . "\n";
}

/** Pretty JSON document. */
function jdoc(array $v): string
{
    return json_encode($v, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
}

/**
 * Deterministic pseudo-hash for files that are described by the evidence
 * package but intentionally not shipped (host acquisitions). The value is a
 * real SHA-256 of a seed string, so it is well-formed, but it is a *recorded*
 * acquisition value and cannot be recomputed from the package.
 */
function rec_hash(string $seed): string
{
    return hash('sha256', 'DFIR-SYNTHETIC-RECORDED::' . $seed);
}

/** Real SHA-256 of a package file's bytes. */
function file_hash(string $path): string
{
    return hash_file('sha256', $path);
}

/**
 * Write manifest-sha256.txt over every file in the package except the
 * manifest itself, using sha256sum-compatible "<hash>  <relpath>" lines.
 */
function write_manifest(string $case): int
{
    $base = pkg($case);
    $files = [];
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $f) {
        /** @var SplFileInfo $f */
        if (!$f->isFile()) {
            continue;
        }
        $abs = str_replace('\\', '/', $f->getPathname());
        $rel = substr($abs, strlen(str_replace('\\', '/', $base)) + 1);
        if ($rel === 'manifest-sha256.txt') {
            continue;
        }
        $files[$rel] = file_hash($abs);
    }
    ksort($files, SORT_STRING);
    $lines = "# manifest-sha256.txt - SHA-256 of every file in this package\n";
    $lines .= "# format: <lowercase sha256><two spaces><relative/path>\n";
    $lines .= "# verify from the package root: see evidence/README.md\n";
    foreach ($files as $rel => $hash) {
        $lines .= $hash . '  ' . $rel . "\n";
    }
    put($base . '/manifest-sha256.txt', $lines);
    return count($files);
}

/** Count files (excluding manifest) and total bytes for reporting. */
function package_stats(string $case): array
{
    $base = pkg($case);
    $n = 0;
    $bytes = 0;
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $f) {
        if ($f->isFile()) {
            $n++;
            $bytes += $f->getSize();
        }
    }
    return ['files' => $n, 'bytes' => $bytes];
}

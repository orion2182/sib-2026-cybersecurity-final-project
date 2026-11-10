# Register dan Verifikasi Bukti

## 1. Prinsip

1. Folder paket adalah master baca-saja.
2. Analisis dilakukan pada salinan kerja.
3. Setiap perpindahan dicatat: siapa, kapan (offset), dari mana, ke mana,
   dan mengapa.
4. Hash membuktikan integritas berkas dalam paket, bukan kebenaran isi.

## 2. Verifikasi manifest

Format: `<sha256 huruf kecil><dua spasi><path relatif>`. Baris `#` komentar.

```powershell
$root = (Get-Location).Path
$n = 0; $bad = 0
Get-Content .\manifest-sha256.txt |
  Where-Object { $_ -notmatch '^#' -and $_.Trim() -ne '' } |
  ForEach-Object {
    $p = $_ -split '  ', 2
    $h = (Get-FileHash -Algorithm SHA256 -LiteralPath (Join-Path $root $p[1])).Hash.ToLower()
    $n++
    if ($h -ne $p[0]) { $bad++; "MISMATCH: $($p[1])" }
  }
"checked=$n mismatches=$bad"
```

Jika ada `MISMATCH`, hentikan analisis dan laporkan ke mentor.

## 3. Register bukti

Gunakan `evidence-register-template.csv` dengan kolom: `item_id`,
`file_path`, `sha256_original`, `acquired_at`, `received_from`, `custodian`,
`storage_location`, `sha256_working_copy`, `verification_result`, `notes`.

Untuk kasus ini, tandai juga:

- `credential_in_package`: `no` (secret tidak disertakan).
- `object_content_in_package`: `no` (hanya metadata).

## 4. Batas yang harus dinyatakan

- Retensi audit 35 hari; periode sebelumnya tidak dapat diklaim.
- Bucket transfer 2026-11-03T18:00Z hilang.
- `ListObjects` ??? `GetObject`; keduanya harus dibedakan di laporan.
- Ketiadaan rekaman bukan bukti ketiadaan peristiwa.

# Register dan Verifikasi Bukti

## 1. Prinsip

1. Folder paket adalah master baca-saja.
2. Analisis dilakukan pada salinan kerja.
3. Setiap perpindahan bukti dicatat: siapa, kapan (dengan offset), dari mana,
   ke mana, dan mengapa.
4. Hash membuktikan integritas berkas dalam paket, bukan kebenaran isi.

## 2. Verifikasi manifest

Format: `<sha256 huruf kecil><dua spasi><path relatif>`. Baris `#` komentar.
Jalankan dari akar paket:

```powershell
$root = (Get-Location).Path
$n = 0; $bad = 0
Get-Content .\manifest-sha256.txt |
  Where-Object { $_.Trim() -ne '' -and $_ -notmatch '^#' } |
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

Gunakan `evidence-register-template.csv`. Isi minimal: `item_id`,
`file_path`, `sha256_original`, `acquired_at`, `received_from`, `custodian`,
`storage_location`, `sha256_working_copy`, `verification_result`, `notes`.

**Penting untuk kasus ini:** beberapa berkas yang tercatat di snapshot tidak
disertakan dalam paket. Tandai sebagai `not_in_package` dengan alasan, dan
jangan mengarang hash.

## 4. Batas yang harus dinyatakan

- Berkas di `artifacts/fs/uploads/` adalah ekscerpt, bukan byte asli.
- Kolom `sha256_original` pada snapshot tidak dapat dihitung ulang.
- Tidak ada log query basis data dan tidak ada image disk.
- Ketiadaan rekaman bukan bukti ketiadaan peristiwa.

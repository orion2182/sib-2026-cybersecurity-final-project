# Cara Membuka dan Memverifikasi Paket (Windows)

Tidak perlu Docker, Python, atau akun awan. Semua artefak adalah teks/JSON.

## 1. Salinan kerja

1. Salin folder `03-cloud-iam` ke `C:\DFIR\kerja\03-cloud-iam`.
2. Simpan folder asli sebagai master baca-saja.
3. Jangan mengedit berkas master.

## 2. Verifikasi hash

Buka PowerShell di akar paket:

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

Hasil benar: `mismatches=0`.

## 3. Membaca artefak

| Jenis | Cara aman |
| --- | --- |
| `.jsonl` | VS Code; satu baris = satu peristiwa |
| `.json` | VS Code; format document |
| `.csv` | Excel: Data > Dari Teks/CSV |
| `.txt` | VS Code |

Jangan memanggil endpoint API apa pun dan jangan memakai identifier kunci
dalam paket; semuanya contoh yang tidak valid.

## 4. Mencari peristiwa

```powershell
Select-String -Path .\artifacts\cloud\audit-20261031_20261106.jsonl -Pattern '198\.51\.100\.88'
Select-String -Path .\artifacts\cloud\audit-20261031_20261106.jsonl -Pattern 'NimbusObjectReadAll'
```

## 5. Zona waktu

Audit memakai UTC; tiket dan catatan perubahan memakai WIB. Baca
`artifacts/SOURCE-TIME-AND-CONVENTIONS.md`.

## 6. Batas penting

Retensi audit 35 hari, satu bucket transfer data hilang, dan isi objek tidak
disertakan. Catat batas ini di register bukti.

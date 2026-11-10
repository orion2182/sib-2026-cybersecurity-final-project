# Cara Membuka dan Memverifikasi Paket (Windows)

Tidak perlu Docker, Python, atau server web. Semua artefak adalah teks.

## 1. Salinan kerja

1. Salin folder `02-perpus-intrusion` ke `C:\DFIR\kerja\02-perpus-intrusion`.
2. Simpan folder asli sebagai master baca-saja.
3. Jangan mengedit berkas master.

## 2. Verifikasi hash

Buka PowerShell di akar paket:

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

Hasil benar: `mismatches=0`.

## 3. Membaca artefak

| Jenis | Cara aman |
| --- | --- |
| `.log` | VS Code / Notepad++; word wrap aktif |
| `.jsonl` | Satu baris = satu rekaman |
| `.csv` | Excel: Data > Dari Teks/CSV; atau VS Code |
| `.json` | VS Code; format document |
| `.txt` | VS Code |

Jangan mengeksekusi berkas di `artifacts/fs/uploads/`. Berkas itu ekscerpt
teks, bukan kode yang dijalankan.

## 4. Mencari `rid` dan korelasi

```powershell
Select-String -Path .\artifacts\web\app.log -Pattern 'REQ-20261105-0023'
Select-String -Path .\artifacts\web\access.log -Pattern 'REQ-20261105-0023'
```

## 5. Zona waktu

`access.log` memakai WIB, `firewall-sessions.csv` memakai UTC. Baca
`artifacts/SOURCE-TIME-AND-CONVENTIONS.md`; jangan menormalkan timestamp di
berkas asli.

## 6. Batas penting

Beberapa berkas yang tercatat di snapshot tidak disertakan (arsip 146 MB,
berkas `.php` asli). Itu disengaja. Catat pada register bukti.

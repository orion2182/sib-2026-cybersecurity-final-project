# Cara Membuka dan Memverifikasi Paket (Windows)

Paket ini **tidak** memerlukan Docker, Python, atau server. Semua berkas adalah
teks/JSON/CSV yang dapat dibuka dengan editor biasa.

## 1. Siapkan salinan kerja

1. Ekstrak/salin folder `01-phishing-staf` ke `C:\DFIR\kerja\01-phishing-staf`.
2. Pertahankan folder asli di tempat terpisah sebagai **master**.
3. Jangan mengedit berkas di folder master. Semua catatan ditulis di salinan.

## 2. Verifikasi hash (wajib, sebelum analisis)

Buka PowerShell di dalam folder paket, lalu jalankan:

```powershell
$ErrorActionPreference = 'Stop'
$root = (Get-Location).Path
$bad = 0; $n = 0
Get-Content .\manifest-sha256.txt |
  Where-Object { $_ -notmatch '^#' -and $_.Trim() -ne '' } |
  ForEach-Object {
    $parts = $_ -split '  ', 2
    $expect = $parts[0]
    $rel    = $parts[1]
    $actual = (Get-FileHash -Algorithm SHA256 -LiteralPath (Join-Path $root $rel)).Hash.ToLower()
    $n++
    if ($actual -ne $expect) { $bad++; Write-Output "MISMATCH $rel" }
  }
Write-Output "files=$n mismatches=$bad"
```

Hasil yang benar: `mismatches=0`. Catat jumlah berkas dan waktu verifikasi
pada register bukti.

Untuk satu berkas:

```powershell
Get-FileHash -Algorithm SHA256 .\artifacts\email\MSG-20261103-0042.eml
```

## 3. Membaca artefak

| Jenis | Cara aman |
| --- | --- |
| `.md` | VS Code, Notepad++, atau aplikasi Markdown |
| `.jsonl` | VS Code; satu baris = satu rekaman JSON |
| `.json` | VS Code; gunakan fitur format dokumen |
| `.csv` | Excel (Impor Data, pemisah koma) atau VS Code |
| `.eml` | Buka sebagai teks di VS Code; **jangan** klik tautan di dalamnya |
| `.log` | VS Code; aktifkan word wrap |

Jangan mengeksekusi, membuka, atau menghubungi URL/IP apa pun di dalam paket.
Tautan dan alamat hanya untuk analisis.

## 4. Tips analisis tanpa Python

- Urutkan JSONL dengan Excel: impor sebagai teks, pisahkan kolom dengan tanda
  baca, lalu sortir berdasarkan kolom `ts`.
- Gunakan `Select-String` untuk mencari ID:

```powershell
Select-String -Path .\artifacts\identity\*.jsonl -Pattern 'SID-3f81c2a4'
```

- Hitung baris:

```powershell
(Get-Content .\artifacts\email\mailgateway-20261102_20261104.jsonl).Count
```

## 5. Zona waktu

Baca `artifacts/SOURCE-TIME-AND-CONVENTIONS.md` lebih dahulu. Jangan
menormalkan timestamp di berkas asli; buat kolom konversi terpisah.

## 6. Yang dikumpulkan

Lihat `student-card.md` (format bukti) dan `evidence/README.md` (register
bukti). Simpan versi berkas kerja Anda beserta hash-nya.

# Panduan Mahasiswa — GRC-1 Layanan Konseling Mahasiswa

Panduan ini hanya memakai alat yang sudah ada di Windows. **Tidak perlu Docker, Python, server, atau instalasi tambahan.**

---

## 1. Yang Anda butuhkan

| Alat | Bagaimana mendapatkannya |
| --- | --- |
| Windows 10/11 | — |
| PowerShell 5.1 | Sudah tersedia (Start → ketik `PowerShell`) |
| Editor teks | Notepad (bawaan) atau Visual Studio Code (opsional) |
| Pembaca Markdown | VS Code, atau pratinjau di GitHub |
| Pembaca PDF | Peramban (Edge/ Chrome) |

> Jika memakai VS Code, tekan `Ctrl+Shift+V` untuk melihat pratinjau Markdown.

## 2. Struktur folder

```
01-konseling/
├── 00-organisasi.md
├── README-mahasiswa.md        ← Anda di sini
├── manifest-sha256.txt
├── 01-dossier/                10 dokumen awal
├── 02-inject/                 inject-1.md, inject-2.md
├── 03-templates/              7 template kerja
├── 04-tasks/                  student-card.md
└── 05-rubric/                 participant-rubric.md
```

## 3. Urutan kerja

| Tanggal | Yang dibaca/ dikerjakan | Gerbang |
| --- | --- | --- |
| 20 Nov | `00-organisasi.md` + `01-dossier/01`–`04` | — |
| 21–23 Nov | `01-dossier/05`–`10`, kartu mahasiswa Q1–Q2 | **G0** |
| 24–27 Nov | Peta data, risk register, Q3–Q4 | **G1** |
| 30 Nov–2 Des | BIA, RTO/RPO, Q5–Q7 | **G2** |
| 3 Des 10.00 | **Baru buka** `02-inject/inject-1.md` | — |
| 3–8 Des | Memo inject 1, Q8–Q10 | **G3** |
| 9 Des 09.00 | **Baru buka** `02-inject/inject-2.md` | — |
| 9–11 Des | Tabletop, memo inject 2, Q11 | **G4** |
| 14–18 Des | Rencana 30/60/90, executive brief, Q12 | **G5** |
| 21–23 Des | Presentasi | — |

**Jangan membuka file inject sebelum tanggalnya.** Latihan ini menguji revisi keputusan, bukan kecepatan membaca.

## 4. Langkah teknis di Windows

### 4.1 Membuka folder

```powershell
cd "C:\path\ke\grc-tabletops\01-konseling"
Get-ChildItem -Recurse | Select-Object FullName
```

### 4.2 Membuat folder kerja

```powershell
New-Item -ItemType Directory -Force -Path ".\submission" | Out-Null
Copy-Item ".\03-templates\risk-register.md" ".\submission\risk-register.md"
```

Ulangi untuk template lain, lalu ganti nama sesuai daftar di `04-tasks/student-card.md`.

### 4.3 Mengedit tanpa VS Code

```powershell
notepad ".\submission\risk-register.md"
```

Simpan dengan `Ctrl+S`. Pastikan ekstensi tetap `.md` (pilih "All Files" jika Notepad menambahkan `.txt`).

### 4.4 Mencari kata di seluruh dokumen

```powershell
Select-String -Path ".\01-dossier\*.md" -Pattern "retensi" | Select-Object Filename,LineNumber,Line
```

### 4.5 Menghitung jumlah baris tabel (memeriksa kelengkapan)

```powershell
(Get-Content ".\submission\risk-register.md" | Select-String "^\| R-").Count
```

## 5. Memverifikasi manifest

Manifest memuat SHA-256 setiap berkas peserta. Untuk memeriksa bahwa berkas tidak berubah/ rusak:

```powershell
$root = "C:\path\ke\grc-tabletops\01-konseling"
Get-Content "$root\manifest-sha256.txt" | ForEach-Object {
    if ($_ -match '^([0-9a-f]{64})\s+(.+)$') {
        $expected = $matches[1]
        $file = Join-Path $root $matches[2]
        if (Test-Path $file) {
            $actual = (Get-FileHash -Algorithm SHA256 $file).Hash.ToLower()
            if ($actual -eq $expected) { "OK   $($matches[2])" }
            else { "BEDA $($matches[2])" }
        } else { "HILANG $($matches[2])" }
    }
}
```

Jika muncul `BEDA` atau `HILANG`, jangan mengubah berkas sendiri — laporkan ke mentor.

## 6. Cara mengisi template

1. **Jangan menghapus baris petunjuk** sampai dokumen selesai; hapus di versi final.
2. **Satu baris tabel = satu item.** Jangan menggabungkan dua risiko dalam satu baris.
3. **Isi kolom bukti.** Jika bukti belum ada, tulis `belum ada` — itu temuan, bukan kegagalan.
4. **Gunakan label F/A/U** pada klaim yang belum pasti.
5. **Tulis angka dengan satuan** (Rp, jam, orang).
6. **Jangan mengosongkan kolom pemilik.** Jika belum ditetapkan, tulis usulan jabatan.

## 7. Format penyerahan

```
submission/
├── risk-register.md
├── data-map.md
├── bia.md
├── rto-rpo.md
├── memo-inject-1.md
├── memo-inject-2.md
├── continuity-plan.md
├── executive-brief.md
└── slide.pdf  (atau slide.md)
```

Buat arsip:

```powershell
Compress-Archive -Path ".\submission\*" -DestinationPath ".\GRC1-<nama-kelompok>.zip" -Force
```

## 8. Etika dan keamanan

- Semua data dalam paket ini **sintetis**. Jangan menambahkan data pribadi nyata, tangkapan layar nyata, atau nama organisasi nyata.
- Jangan menghubungi vendor fiktif atau mengirim surel ke domain yang disebut.
- Jangan mengunggah paket ke layanan publik tanpa izin mentor.
- Jika Anda menemukan kekeliruan dalam dokumen kasus, catat sebagai temuan — bukan alasan berhenti.

## 9. Bantuan cepat

| Masalah | Solusi |
| --- | --- |
| Markdown tampil sebagai teks | Buka dengan VS Code atau unggah ke GitHub |
| `Get-FileHash` tidak dikenal | Pastikan PowerShell 5.1, bukan Command Prompt |
| Berkas tersimpan `.md.txt` | Simpan ulang dengan "All Files" dan nama berakhiran `.md` |
| Manifest tidak cocok | Jangan edit berkas asli; salin dulu ke `submission/` |
| Waktu habis saat tabletop | Tulis keputusan terbaik + daftar ketidakpastian |

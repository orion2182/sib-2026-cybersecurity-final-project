# Panduan Mahasiswa — GRC-2 Pendaftaran dan Pembayaran Kampus

Panduan ini hanya memakai alat yang sudah ada di Windows. **Tidak perlu Docker, Python, server, atau instalasi tambahan.**

---

## 1. Yang Anda butuhkan

| Alat | Keterangan |
| --- | --- |
| Windows 10/11 | — |
| PowerShell 5.1 | Bawaan (Start → `PowerShell`) |
| Notepad atau VS Code | Untuk mengedit Markdown |
| Peramban | Untuk membaca PDF dan pratinjau |

## 2. Struktur folder

```
02-pendaftaran/
├── 00-organisasi.md
├── README-mahasiswa.md        ← Anda di sini
├── manifest-sha256.txt
├── 01-dossier/                10 dokumen awal
├── 02-inject/                 inject-1.md (dua bagian), inject-2.md
├── 03-templates/              7 template
├── 04-tasks/                  student-card.md
└── 05-rubric/                 participant-rubric.md
```

## 3. Urutan kerja

| Tanggal | Yang dikerjakan | Gerbang |
| --- | --- | --- |
| 20 Nov | `00-organisasi.md`, dossier 01–04 | — |
| 21–23 Nov | dossier 05–10, Q1–Q2 | **G0** |
| 24–27 Nov | Peta data, risk register, Q3–Q4 | **G1** |
| 30 Nov–2 Des | BIA, RTO/RPO, Q5–Q7 | **G2** |
| 3 Des 09.30 | **Inject 1 Bagian A** | — |
| 3 Des 13.00 | **Inject 1 Bagian B** | — |
| 4 Des 16.00 | Memo 1A dan 1B | **G3** |
| 9 Des 09.00 | **Inject 2** | — |
| 9–11 Des | Tabletop, memo 2, Q11 | **G4** |
| 14–18 Des | Rencana 30/60/90, executive brief, Q12 | **G5** |
| 21–23 Des | Presentasi | — |

> Bagian A dan B pada Inject 1 **sengaja dipisah**. Jangan membuka Bagian B lebih awal — urutan keputusan adalah bagian dari penilaian.

## 4. Langkah teknis

### 4.1 Masuk ke folder

```powershell
cd "C:\path\ke\grc-tabletops\02-pendaftaran"
Get-ChildItem -Recurse | Select-Object FullName
```

### 4.2 Menyiapkan folder kerja

```powershell
New-Item -ItemType Directory -Force -Path ".\submission" | Out-Null
Copy-Item ".\03-templates\*.md" ".\submission\"
```

Lalu ganti nama sesuai daftar di `04-tasks/student-card.md` (mis. `memo-inject-1a.md`).

### 4.3 Mengedit

```powershell
notepad ".\submission\bia.md"
```

Simpan dengan `Ctrl+S`, pastikan ekstensi tetap `.md`.

### 4.4 Menghitung sendiri (tanpa Python)

PowerShell dapat dipakai sebagai kalkulator:

```powershell
# waktu restore dalam jam
$gb = 900; $mbps = 28
[math]::Round(($gb * 1024) / $mbps / 3600, 2)

# nilai transaksi tertahan
2400 * 4100000
```

Tulis hasil dan asumsi di lembar kerja, bukan hanya angkanya.

### 4.5 Mencari angka di dossier

```powershell
Select-String -Path ".\01-dossier\*.md" -Pattern "2.400|1.900|640" | Select-Object Filename,LineNumber,Line
```

## 5. Memverifikasi manifest

```powershell
$root = "C:\path\ke\grc-tabletops\02-pendaftaran"
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

Jika ada `BEDA`/`HILANG`, laporkan ke mentor; jangan mengubah berkas asli.

## 6. Cara mengisi template

1. Jangan menghapus baris petunjuk sampai final.
2. Satu baris = satu item.
3. Isi kolom bukti; tulis `belum ada` bila tidak ada.
4. Beri label F/A/U.
5. Tulis satuan (Rp, jam, orang).
6. Jangan biarkan kolom pemilik kosong.

## 7. Penyerahan

```
submission/
├── risk-register.md
├── data-map.md
├── bia.md
├── rto-rpo.md
├── memo-inject-1a.md
├── memo-inject-1b.md
├── memo-inject-2.md
├── continuity-plan.md
├── executive-brief.md
└── slide.pdf (atau slide.md)
```

```powershell
Compress-Archive -Path ".\submission\*" -DestinationPath ".\GRC2-<nama-kelompok>.zip" -Force
```

## 8. Etika

- Semua data sintetis. Jangan menambahkan data nyata.
- Jangan menghubungi vendor fiktif.
- Jangan mengunggah paket ke publik tanpa izin.
- Temuan atas kekeliruan dokumen adalah bagian dari nilai, bukan alasan berhenti.

## 9. Bantuan cepat

| Masalah | Solusi |
| --- | --- |
| Markdown tampil sebagai teks | Buka dengan VS Code/ GitHub |
| `Get-FileHash` tidak dikenal | Pastikan PowerShell, bukan CMD |
| Berkas menjadi `.md.txt` | Simpan dengan "All Files" |
| Bingung urutan inject | Ikuti jam pada nama berkas, jangan acak |
| Waktu tabletop habis | Tulis keputusan + daftar ketidakpastian |

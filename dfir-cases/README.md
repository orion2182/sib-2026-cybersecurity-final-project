# Paket Bukti DFIR (Sintetis) - SIB 2026

Tiga paket bukti statis untuk tiga kelompok tema **Digital Forensics &
Incident Response**. Semua data sintetis: organisasi fiktif, domain `.test`,
alamat IP dari rentang dokumentasi RFC 5737, tanpa malware aktif, tanpa akun
nyata, dan tanpa data pribadi nyata.

| Paket | Kasus | Organisasi fiktif |
| --- | --- | --- |
| `01-phishing-staf/` | Phishing akun staf dan penyalahgunaan sesi SSO | Yayasan Cendekia Nusantara |
| `02-perpus-intrusion/` | Intrusi aplikasi perpustakaan dan ekspor data | Universitas Cakrawala Nusantara |
| `03-cloud-iam/` | Penyalahgunaan identitas layanan di penyedia awan fiktif | Yayasan Arsip Digital Bahari |

## Status rilis (jujur)

- Paket artefak: **dibangun dan lolos verifikasi struktur otomatis**
  (`tools/verify.php`, 51 pemeriksaan) per 10 November 2026.
- Manifest SHA-256: **diverifikasi ulang, nol ketidaksesuaian**.
- Kunci instruktur: tersedia terpisah di `instructor-private/dfir/`
  (di luar repository publik, tidak boleh dibagikan).
- **Pilot buta belum dijalankan.** Kesetaraan tingkat kesulitan antar kasus
  belum terkalibrasi. Jangan menyebut paket "siap uji" sebelum pilot selesai
  dan catatan revisi pilot ditambahkan.

## Struktur paket peserta

```
01-phishing-staf/
  MANDATE.md                      surat penugasan, lingkup, batasan, tenggat
  student-card.md                 situasi, tujuan, Q1-Q12, petunjuk konsep
  README-mahasiswa.md             langkah Windows + verifikasi hash
  manifest-sha256.txt             hash setiap berkas (format sha256sum)
  artifacts/                      artefak bukti + indeks + catatan waktu
  baseline/                       aktivitas normal pembanding
  evidence/README.md              cara verifikasi + register bukti
  evidence/evidence-register-template.csv
```

Semua paket < 150 KB. Tidak perlu Docker, Python, atau layanan apa pun.

## Membuat ulang paket

Dari akar repository (Windows, PowerShell):

```powershell
& C:\xampp\php\php.exe dfir-cases\tools\generate.php
```

Generator menulis ulang `artifacts/`, `baseline/`, dokumen peserta, dan
`manifest-sha256.txt`. Generator **tidak** memuat kunci jawaban.

## Memverifikasi paket

```powershell
& C:\xampp\php\php.exe dfir-cases\tools\verify.php
```

Pemeriksaan mencakup: integritas manifest, kelengkapan daftar berkas,
parseability JSON/JSONL, offset zona waktu pada setiap timestamp, keunikan ID,
keterkaitan lintas artefak (sesi, `rid`, objek, tiket), serta penggunaan
rentang IP/domain yang diizinkan.

Verifikasi manual per paket (juga ditulis di `README-mahasiswa.md`):

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

## Aturan pembagian

1. Berikan **hanya satu** paket ke kelompok yang ditugaskan.
2. Jangan pernah menyerahkan `instructor-private/`, `MENTOR-KEY.md`, atau
   `answer-key.json`. Ketiganya memuat ground truth.
3. Jangan menambahkan berkas dari kasus lain ke paket yang sama; beberapa
   indikator (mis. `Cendekia`) akan saling mencemari.
4. Catat versi paket yang dibagikan (hash manifest) pada berita acara kelas.

## Batas yang diketahui

- Data 100% sintetis; tidak boleh dikutip sebagai temuan dunia nyata.
- Tidak ada image disk/memori, tidak ada log query basis data, dan tidak ada
  kunci rahasia awan di paket mana pun.
- Setiap paket memiliki minimal satu artefak yang sengaja tidak lengkap
  (celah retensi, ekscerpt tersanitasi, atau agregat yang hilang) agar peserta
  harus menyatakan ketidakpastian.

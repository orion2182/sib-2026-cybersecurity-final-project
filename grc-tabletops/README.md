# GRC, Privasi, dan Business Continuity — Paket Tabletop 2026

Direktori ini memuat **dua kasus tabletop berbasis dokumen** untuk tema GRC, privasi, dan kelangsungan layanan pada Final Project Cyber Security SIB 2026.

| Kode | Kasus | Organisasi fiktif | Penekanan keputusan |
| --- | --- | --- | --- |
| `01-konseling` | Layanan konseling mahasiswa | Universitas Cendekia Arunika (UCA) | Privasi data kesehatan mental, retensi, vendor dan subprosesor, kelangsungan hotline krisis |
| `02-pendaftaran` | Pendaftaran dan pembayaran kampus | Politeknik Nusa Bahari (PNB) | Ketersediaan layanan kritis, BIA, RTO/RPO, kegagalan vendor pembayaran, tekanan kalender akademik |

## Prinsip paket

- **Analisis dokumen dan tabletop.** Tidak ada pemindaian, eksploitasi, Docker, server, atau kredensial.
- **Sintetis penuh.** Seluruh organisasi, orang, nomor, kontrak, dan insiden adalah fiktif. Tidak ada data pribadi nyata.
- **Sengaja tidak lengkap.** Beberapa dokumen saling bertentangan. Mengidentifikasi pertentangan itu bagian dari tugas.
- **Dua inject per kasus.** Inject pertama membuka fakta baru yang mengubah pilihan yang dapat diterima; inject kedua mencabut asumsi pemulihan/kepatuhan yang tersisa.
- **Tidak ada satu jawaban benar.** Yang dinilai adalah keterlacakan keputusan terhadap bukti, trade-off yang dinyatakan, dan risiko sisa yang diterima secara sadar.

## Kalender tetap

| Tanggal | Tahap |
| --- | --- |
| 20–23 Nov 2026 | Mandat, stakeholder, aset, asumsi; **G0** |
| 24–27 Nov 2026 | Peta data, risk register awal; **G1** |
| 30 Nov–2 Des 2026 | Privasi, BIA, draf RTO/RPO; **G2** |
| 3–8 Des 2026 | **Inject 1** dibuka; revisi opsi; **G3** |
| 9–11 Des 2026 | **Inject 2** + tabletop pimpinan; **G4** |
| 14–18 Des 2026 | Rencana 30/60/90 hari; gladi 16–18 Des; **G5** |
| 21–23 Des 2026 | Presentasi dan pengujian |

## Cara memakai

1. Buka folder kasus yang ditugaskan.
2. Baca `README-mahasiswa.md` (langkah Windows, tanpa Docker/Python).
3. Baca `00-organisasi.md`, lalu seluruh `01-dossier/`.
4. Kerjakan `04-tasks/student-card.md` memakai `03-templates/`.
5. Buka `02-inject/inject-1.md` hanya pada tanggal yang tertera. Jangan membaca lebih awal.
6. Serahkan paket sesuai daftar di kartu mahasiswa dan verifikasi `manifest-sha256.txt`.

> Catatan rilis: paket ini adalah **bahan latihan analitis**, bukan pendapat hukum. Rujukan pasal harus diperiksa ulang terhadap teks resmi sebelum presentasi. Lihat `07-catatan-hukum.md` pada kunci instruktur (tidak dibagikan ke peserta).

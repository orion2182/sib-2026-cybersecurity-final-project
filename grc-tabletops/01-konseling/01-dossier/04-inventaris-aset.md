# 04 — Inventaris Aset Informasi

**Dokumen:** inventaris aset UPT-LPK dan UPT TIK (gabungan), 28 Oktober 2026
**Metode:** wawancara + pemindaian daftar akun (bukan pemindaian kerentanan)
**Skala:** K/I/A = Kerahasiaan / Integritas / Ketersediaan, 1 (rendah) – 5 (kritis)

---

## 1. Aset aplikasi dan data

| ID | Aset | Jenis | Lokasi | Pemilik | K | I | A | Catatan |
| --- | --- | --- | --- | --- | :-: | :-: | :-: | --- |
| A-01 | SIPKON (aplikasi) | SaaS | Hening Cloud, Jakarta | Kepala UPT-LPK | 4 | 5 | 5 | Aplikasi inti pencatatan |
| A-02 | Basis data SIPKON (180 GB) | Data | Hening Cloud | Kepala UPT-LPK | 5 | 5 | 5 | Termasuk catatan klinis |
| A-03 | Bucket Nimbus (640 GB) | Data | Singapura | UPT TIK | 5 | 4 | 4 | Lampiran, ekspor chat |
| A-04 | Modul analitik chat | Layanan | Hening Cloud | UPT TIK | 5 | 4 | 2 | Retensi 13 bulan |
| A-05 | Rekaman hotline | Data | Panggilan Aman | Kepala UPT-LPK | 5 | 4 | 3 | 90 hari |
| A-06 | Ringkasan hotline (PDF) | Data | Surel kampus | Admin UPT | 5 | 3 | 3 | Kata sandi via WhatsApp |
| A-07 | Forum Teman Sebaya | Aplikasi | Server kampus (VM-14) | UPT TIK | 4 | 3 | 3 | Tanpa jadwal retensi |
| A-08 | Kertas intake | Fisik | Lemari ruang tunggu | Admin UPT | 5 | 2 | 2 | Kunci dipegang 4 admin |
| A-09 | Ekspor XLSX laporan | Data | Surel pribadi konselor | Konselor | 4 | 3 | 2 | Tidak terkendali |
| A-10 | Log akses aplikasi | Data | Hening Cloud | UPT TIK | 3 | 4 | 3 | 30 hari, tanpa log baca |
| A-11 | Daftar akun & kata sandi | Data | Spreadsheet tim IT | UPT TIK | 5 | 5 | 4 | Lihat A-15 |

## 2. Aset infrastruktur dan akun

| ID | Aset | Lokasi | Pemilik | K | I | A | Catatan |
| --- | --- | --- | --- | :-: | :-: | :-: | --- |
| A-12 | SSO kampus | Server kampus | UPT TIK | 5 | 5 | 5 | MFA hanya untuk 3 akun admin |
| A-13 | 9 laptop konselor | Bawa pulang | UPT-LPK | 4 | 4 | 3 | BitLocker aktif di 5 dari 9 |
| A-14 | 4 workstation admin | Ruang UPT | UPT-LPK | 4 | 4 | 3 | Layar tidak terkunci otomatis |
| A-15 | Akun bersama `konselor01` | SIPKON | UPT-LPK | 5 | 5 | 3 | Dipakai 3 orang; tanpa jejak individu |
| A-16 | Akun dukungan vendor | SIPKON | Hening Cloud | UPT TIK | 5 | 5 | 3 | Dapat "impersonate" dengan tiket |
| A-17 | Jaringan kampus | Kampus | UPT TIK | 3 | 4 | 5 | Tanpa jalur redundan |
| A-18 | Cadangan harian vendor | Hening Cloud | Hening Cloud | 4 | 4 | 4 | 7 hari, region sama, belum diuji |
| A-19 | UPS ruang server | Kampus | UPT TIK | 2 | 2 | 4 | Baterai 3 tahun, belum diganti |

## 3. Dependensi antar-aset

```
A-12 SSO ──► A-01 SIPKON ──► A-02 DB
                  │
                  ├──► A-03 Nimbus ──► A-04 analitik
                  └──► A-06 surel ──► A-09 ekspor XLSX

A-05 hotline ──► A-06 surel (manual, kata sandi via WhatsApp)
A-07 forum ──► A-12 SSO
A-15 akun bersama ──► A-01 SIPKON (jalur akses utama admin)
```

**Titik tunggal kegagalan yang terlihat:**
1. A-15: seluruh admin memakai satu akun. Jika kata sandi berubah, semua admin terkunci; jika bocor, tidak ada atribusi.
2. A-12: SSO tanpa MFA untuk 9 konselor.
3. A-05: tidak ada nomor hotline cadangan.
4. A-03: penyimpanan di luar negeri tanpa persetujuan subprosesor.

## 4. Klasifikasi data yang dipakai (tidak konsisten)

| Sumber | Istilah klasifikasi | Cakupan |
| --- | --- | --- |
| Kebijakan PDP 2023 | "Publik / Internal / Rahasia" | Tidak memetakan data kesehatan secara eksplisit |
| SOP UPT 2024 | "Biasa / Sensitif" | Menyebut "data psikologis = sensitif" tanpa definisi |
| Kebijakan TI 2022 | "Tingkat 1–4" | Berbasis sistem, bukan data |
| Praktik harian | "jangan disebar" | Tidak terukur |

**Konsekuensi:** tidak ada dasar konsisten untuk menentukan kontrol, retensi, atau kewajiban pemberitahuan.

## 5. Aset yang tidak tercatat

- 3 kandar eksternal di ruang admin (isi tidak diketahui).
- 1 grup WhatsApp "Konselor UCA" (14 anggota) berisi tangkapan layar jadwal.
- 1 akun Google Forms pribadi milik admin untuk survei kepuasan.
- 2 printer multifungsi dengan penyimpanan internal.

## 6. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Aset mana yang **paling** menentukan keselamatan pengguna, dan apakah peringkat K/I/A mencerminkan itu?
- Aset mana yang tidak memiliki pemilik yang jelas?
- Kontrol apa yang paling murah untuk menutup titik tunggal kegagalan A-15 dan A-12?

# 04 — Inventaris Aset dan Kapasitas

**Dokumen:** inventaris aset UPT TIK, 28 Oktober 2026
**Skala:** K/I/A = Kerahasiaan / Integritas / Ketersediaan, 1–5

---

## 1. Aset aplikasi dan data

| ID | Aset | Jenis | Lokasi | Pemilik | K | I | A | Catatan |
| --- | --- | --- | --- | --- | :-: | :-: | :-: | --- |
| B-01 | SIPMA (aplikasi) | Web app | Awan Cakrawala, Jakarta | DAA | 4 | 5 | 5 | 2 VM aplikasi |
| B-02 | Basis data SIPMA | PostgreSQL 900 GB | Awan Cakrawala | DAA | 4 | 5 | 5 | Satu instance |
| B-03 | Berkas unggahan pendaftar | PDF/JPG 1,4 TB | NAS kampus | DAA | 4 | 4 | 3 | Tanpa enkripsi tingkat berkas |
| B-04 | SIAKAD | Aplikasi | Server kampus | DAA | 4 | 5 | 4 | Terpisah dari SIPMA |
| B-05 | NAS cadangan | 4 TB | Ruang server kampus | UPT TIK | 4 | 4 | 4 | **Gedung yang sama** |
| B-06 | HSM (kunci enkripsi) | Perangkat | Kantor SDN | UPT TIK | 5 | 5 | 5 | Kunci tidak di tangan PNB |
| B-07 | Spreadsheet rekonsiliasi | XLSX | Shared drive | Biro Keuangan | 4 | 4 | 3 | Diakses 40 orang |
| B-08 | Laptop loket (4 unit) | Perangkat | Loket registrasi | DAA | 3 | 3 | 3 | Tanpa enkripsi di 2 unit |
| B-09 | Flashdisk loket (3 unit) | Media | Loket | DAA | 4 | 3 | 2 | Isi tidak tercatat |
| B-10 | Grup WhatsApp panitia | Kanal | Ponsel pribadi | Tidak ada | 4 | 2 | 3 | 40 anggota |

## 2. Aset infrastruktur

| ID | Aset | Kapasitas | Lokasi | Catatan |
| --- | --- | --- | --- | --- |
| B-11 | VM aplikasi | 4 vCPU, 16 GB | Awan Cakrawala | 1 region |
| B-12 | VM basis data | 8 vCPU, 64 GB | Awan Cakrawala | Tanpa replika |
| B-13 | Bandwidth backup | **28 MB/detik efektif** | Kampus ↔ cloud | Diukur Sep 2025 |
| B-14 | UPS ruang server | 30 menit | Kampus | Baterai 4 tahun |
| B-15 | Jaringan kampus | 1 jalur ISP | Kampus | Tanpa redundansi |
| B-16 | SSO kampus | — | Kampus | Tanpa MFA untuk staf |

## 3. Perhitungan pemulihan (dari angka yang ada)

| Skenario | Ukuran | Kecepatan | Waktu transfer murni | Ditambah deteksi + keputusan + verifikasi | Realistis? |
| --- | ---: | ---: | ---: | ---: | --- |
| Restore penuh B-02 | 900 GB | 28 MB/s | ±9,1 jam | +2 jam | **> 11 jam** |
| Restore penuh B-03 | 1,4 TB | 28 MB/s | ±13,9 jam | +2 jam | **> 15 jam** |
| Restore sebagian (1 tabel) | 20 GB | 28 MB/s | ±12 menit | +1 jam | ±1,5 jam |

**Perhitungan:** 900 GB = 921.600 MB; 921.600 ÷ 28 = 32.914 detik ≈ 9,1 jam. Tunjukkan perhitungan Anda sendiri bila memakai asumsi berbeda.

**Implikasi:** RTO 4 jam untuk seluruh sistem **tidak mungkin** dengan bandwidth dan mekanisme saat ini, bahkan tanpa gangguan lain.

## 4. Titik tunggal kegagalan

| # | Titik | Dampak | Alternatif saat ini |
| --- | --- | --- | --- |
| 1 | Satu VM basis data | Seluruh registrasi berhenti | Tidak ada replika |
| 2 | NAS di gedung yang sama | Backup hilang bersama insiden gedung | Tidak ada off-site |
| 3 | HSM dikelola vendor | Pemulihan bergantung pihak ketiga | Tidak ada escrow di PNB |
| 4 | Satu jalur ISP | Loket tidak dapat mengakses | Tidak ada |
| 5 | Satu analis sistem | Tidak ada yang paham integrasi | Dokumentasi minim |
| 6 | Webhook PayLoka | Status pembayaran tidak sinkron | Rekonsiliasi manual |

## 5. Kapasitas cadangan saat ini

| Pertanyaan | Jawaban |
| --- | --- |
| Frekuensi backup penuh | Harian 02.00 |
| Retensi | 7 hari (NAS), 3 hari (snapshot cloud) |
| Lokasi | Kampus (NAS) + region sama (snapshot) |
| Uji restore terakhir | 12 Sep 2025 — gagal pada 40% (file WAL hilang) |
| Backup log transaksi (binlog) | 2 hari |
| Enkripsi backup | Ya, kunci di HSM SDN |
| Verifikasi integritas otomatis | Tidak ada |
| Pemberitahuan kegagalan backup | Surel ke 1 alamat; 3 kegagalan berturut-turut tidak pernah terdeteksi |

## 6. Aset yang tidak tercatat

- 6 kotak surel pribadi staf admisi berisi berkas pendaftar.
- 2 laptop pribadi yang dipakai WFH.
- 1 akun cloud pribadi untuk mengirim berkas besar.
- 3 flashdisk tanpa label.
- 12 tangkapan layar tagihan di grup WhatsApp.

## 7. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Aset mana yang **harus** pulih dalam 4 jam agar proses registrasi tidak berhenti total?
- Apakah mungkin mencapai RTO 4 jam tanpa mengubah arsitektur? Buktikan dengan hitungan.
- Apa yang harus dilakukan agar backup tidak hilang bersama gedung?
- Apa yang harus dilakukan agar pemulihan tidak bergantung pada satu vendor kunci?

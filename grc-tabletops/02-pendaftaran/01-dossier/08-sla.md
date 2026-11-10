# 08 — SLA Vendor dan Target Internal

**Dokumen:** kompilasi SLA, 1 November 2026

---

## 1. PayLoka

| Parameter | Nilai | Catatan |
| --- | --- | --- |
| Uptime | 99,9%/bulan | ±43 menit; tidak ada kompensasi otomatis |
| Waktu konfirmasi transaksi | < 5 menit (klaim) | Tidak diukur oleh PNB |
| Ketersediaan portal | 99,5% | Status page publik |
| Ledger | 7 hari di portal | Di luar itu: permintaan khusus 5 hari kerja |
| Laporan harian | H+1 pukul 12.00 | Terlambat untuk tenggat 23.59 |
| Notifikasi gangguan | Surel ke 2 kontak | Tidak ada jaminan waktu |
| Batas tanggung jawab | 3× biaya bulanan | ± Rp 60 juta |
| Penghentian | 30 hari pemberitahuan | Tanpa kewajiban migrasi |

## 2. Bank Arunika Sejahtera

| Parameter | Nilai | Catatan |
| --- | --- | --- |
| File rekonsiliasi | 06.00 setiap hari | 2 keterlambatan 1 hari pada 2026 |
| Format | CSV melalui portal | Retensi portal 30 hari |
| Koreksi transaksi | 3 hari kerja | Tidak dapat dipercepat |
| Kontak | Call center umum | Tidak ada account manager |

## 3. PT Sandi Data Nusantara

| Parameter | Nilai | Catatan |
| --- | --- | --- |
| Pemulihan data | 5 hari kerja | **Tidak sesuai RTO apa pun yang wajar** |
| Eskalasi darurat | Persetujuan kantor pusat | Waktu tidak dijamin |
| Uji pemulihan | Setahun sekali atas permintaan | Tidak pernah diminta |
| Respons P1 | 4 jam | Hanya untuk sistem yang dikelola |
| Batas tanggung jawab | 6× biaya bulanan | ± Rp 90 juta |

## 4. Awan Cakrawala

| Parameter | Nilai |
| --- | --- |
| Uptime | 99,95% |
| Snapshot | Harian, retensi 3 hari, region sama |
| Respons P1 | 30 menit |
| Region kedua | Tersedia, biaya tambahan |

## 5. Target internal

| Layanan | Target | Sumber | Realitas |
| --- | --- | --- | --- |
| Registrasi daring | 99,5% pada masa puncak | BCP 2023 | Tidak diukur |
| RTO seluruh sistem | 4 jam | BCP 2023 | Tidak mungkin (lihat `04-inventaris-aset.md`) |
| RPO | 1 jam | BCP 2023 | Backup harian; binlog 2 hari |
| Penyelesaian keluhan pembayaran | 3 hari | SOP | Rata-rata 9 hari |
| Koreksi status setelah bukti bayar | 1 hari | praktik | 3–5 hari |
| Pemberitahuan gangguan ke mahasiswa | "segera" | tidak ada | Tidak ada kanal |

**Ketidaksesuaian utama:** RPO 1 jam tidak dapat dicapai dengan backup harian dan binlog 2 hari tanpa mekanisme tambahan. RTO 4 jam tidak dapat dicapai dengan restore 9,1 jam.

## 6. Cara menguji klaim

| Pertanyaan | Bukti |
| --- | --- |
| Apakah 99,9% pernah dilanggar? | Laporan PayLoka 6 bulan: 99,94%; 99,71%; 99,98% |
| Apakah ada kompensasi? | Tidak ada |
| Apakah restore pernah berhasil penuh? | Tidak ada catatan |
| Berapa lama koreksi status nyata? | 9 hari rata-rata (keluhan 2026) |

## 7. Pertanyaan yang harus dijawab tim (bukan jawaban)

- SLA mana yang **tidak mungkin** dipenuhi, dan bagaimana mengomunikasikannya?
- Apakah target internal perlu diturunkan agar jujur, atau kemampuan yang harus dinaikkan?
- Apa yang harus dimasukkan ke kontrak berikutnya agar RTO/RPO dapat dipertahankan?

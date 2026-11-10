# 06 — Kontrol Saat Ini

**Dokumen:** penilaian mandiri, 31 Oktober 2026
**Skala:** 0 = tidak ada, 1 = ad hoc, 2 = terdokumentasi, 3 = diterapkan dan diuji

---

## 1. Ketersediaan dan pemulihan

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| A-1 | Backup harian | 2 | Jadwal 02.00 | Tanpa verifikasi integritas |
| A-2 | Backup off-site | 0 | — | NAS di gedung yang sama |
| A-3 | Uji restore berkala | 0 | 1 kali (Sep 2025), gagal | Tidak diulang |
| A-4 | Replika basis data | 0 | — | Satu instance |
| A-5 | Situs cadangan (DR) | 0 | — | Tidak ada |
| A-6 | Pemantauan kegagalan backup | 1 | Surel ke 1 alamat | 3 kegagalan berturut tidak terdeteksi |
| A-7 | BCP yang diuji | 0 | Dokumen 2023 | Tidak pernah diuji |
| A-8 | Prosedur manual resmi | 0 | — | Hanya praktik tidak resmi |
| A-9 | Nomor/ kanal cadangan | 0 | — | Tidak ada |
| A-10 | RTO/RPO berbasis pengukuran | 0 | "4 jam" tanpa dasar | Tidak dapat dipertahankan |

## 2. Akses dan perubahan

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| B-1 | MFA untuk admin | 0 | — | Hanya kata sandi |
| B-2 | Akun unik | 2 | 3 admin SIPMA | 1 akun dipakai bersama analis dan vendor |
| B-3 | Pemisahan tugas | 1 | Staf keuangan dapat mengubah status | Tidak ada persetujuan kedua |
| B-4 | Pencatatan perubahan data | 1 | Log 30 hari | Tidak mencakup perubahan langsung di DB |
| B-5 | Pencabutan akses | 1 | Manual | 4 mantan panitia masih di grup WhatsApp |
| B-6 | Pengelolaan akses vendor | 1 | Tiket | Tanpa persetujuan per sesi |

## 3. Data dan privasi

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| C-1 | Klasifikasi data | 0 | — | Tidak ada |
| C-2 | Minimisasi data | 0 | 24 field formulir | Penghasilan orang tua untuk semua pendaftar |
| C-3 | Enkripsi basis data | 2 | Diklaim cloud | Kunci tidak dikelola PNB |
| C-4 | Enkripsi berkas unggahan | 0 | — | PDF dapat dibaca siapa pun dengan akses NAS |
| C-5 | DLP/ kontrol ekspor | 0 | — | Spreadsheet bebas diunduh |
| C-6 | Penghapusan terjadwal | 0 | — | Tidak ada |
| C-7 | Register pemusnahan | 0 | — | Tidak ada |
| C-8 | Prosedur hak subjek data | 1 | Surel ke DPO | Tanpa SLA, tanpa formulir |
| C-9 | Aturan data untuk proses manual | 0 | — | Tidak ada |
| C-10 | Pelatihan privasi | 0 | — | Tidak ada sejak 2024 |

## 4. Vendor

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| D-1 | DPA dengan PayLoka | 1 | Kontrak | Tanpa kewajiban ledger > 7 hari |
| D-2 | DPA dengan SDN | 1 | Kontrak | Tanpa SLA pemulihan yang memadai |
| D-3 | Pemantauan SLA | 1 | Status page | Tidak ada laporan formal |
| D-4 | Rencana keluar vendor | 0 | — | Tidak ada |
| D-5 | Audit vendor | 0 | — | Kuesioner saja |

## 5. Insiden

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| E-1 | Rencana respons insiden | 1 | Dokumen TI 2023 | Tidak mencakup pembayaran |
| E-2 | Ambang eskalasi | 0 | — | Tidak ada |
| E-3 | Playbook komunikasi | 0 | — | Tidak ada |
| E-4 | Pencatatan insiden | 1 | Tiket | Insiden pembayaran dicatat sebagai "gangguan" |
| E-5 | Pelajaran pasca-insiden | 0 | — | Tidak ada |

## 6. Ringkasan

| Kelompok | Rata-rata | Catatan |
| --- | :-: | --- |
| Ketersediaan | 0,4 | Tidak ada kemampuan pemulihan yang terbukti |
| Akses | 1,0 | MFA tidak ada; akun bersama |
| Data/ privasi | 0,4 | Data tersebar di saluran tidak resmi |
| Vendor | 0,6 | Ketergantungan tinggi, jaminan rendah |
| Insiden | 0,4 | Tidak siap menghadapi tenggat |

## 7. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Kontrol mana yang **wajib** ada sebelum 11 Desember 2026, dan mana yang boleh setelahnya?
- Apakah ada kontrol murah yang mengurangi dampak lebih besar daripada biaya DR site?
- Kontrol mana yang harus dimiliki PNB sendiri, bukan diserahkan ke vendor?

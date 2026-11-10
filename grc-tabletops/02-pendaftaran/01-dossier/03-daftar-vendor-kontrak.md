# 03 — Daftar Vendor dan Ringkasan Kontrak

**Dokumen:** ringkasan kontrak oleh Biro Keuangan dan Biro Hukum, 30 Oktober 2026
**Catatan:** seluruh nama, nilai, dan klausul adalah fiktif.

---

## 1. Portofolio vendor

| Vendor | Layanan | Data | Nilai/tahun | Jangka waktu | Kritikalitas |
| --- | --- | --- | ---: | --- | --- |
| PT PayLoka Nusantara | Payment gateway | Identitas pembayar, tagihan, transaksi | Rp 240.000.000 | 1 Feb 2026–31 Jan 2027 | **Tinggi** |
| Bank Arunika Sejahtera | Virtual account, rekonsiliasi | Nama, nomor VA, transaksi | Rp 96.000.000 (biaya layanan) | 1 Jan–31 Des 2026 | **Tinggi** |
| PT Sandi Data Nusantara (SDN) | Backup, HSM, dukungan server | Seluruh basis data, kunci enkripsi | Rp 180.000.000 | 1 Apr 2026–31 Mar 2027 | **Tinggi** |
| Awan Cakrawala | IaaS (satu region) | Seluruh data aplikasi | Rp 168.000.000 | 1 Jan–31 Des 2026 | Tinggi |
| PT Pesan Cepat | SMS gateway | Nomor HP, isi pesan | Rp 36.000.000 | 1 Jun 2026–31 Mei 2027 | Sedang |

**Total:** Rp 720.000.000/tahun, dari anggaran operasional TI. Pagu program kelangsungan (Rp 320.000.000) terpisah.

## 2. PT PayLoka Nusantara

| Klausul | Isi (parafrase) | Konsekuensi |
| --- | --- | --- |
| 2.1 Peran | Prosesor untuk data pembayaran | Tetap pengendali untuk data merchant |
| 3.2 SLA | 99,9% uptime bulanan | 43 menit/bulan; tanpa kompensasi otomatis |
| 3.4 Notifikasi gangguan | Status page publik + surel ke 2 kontak | Tidak ada kewajiban memberi data transaksi terperinci |
| 4.1 Ledger | "Merchant dapat mengakses riwayat transaksi 7 hari secara mandiri melalui portal. Data historis di luar 7 hari hanya tersedia melalui permintaan ekspor khusus (5 hari kerja)." | **Ketergantungan pada ekspor khusus; tidak ada akses mandiri jangka panjang** |
| 4.3 Rekonsiliasi | "PayLoka menyediakan laporan harian paling lambat H+1 pukul 12.00." | Terlambat untuk tenggat 23.59 |
| 5.2 Duplikasi | "Merchant bertanggung jawab memastikan idempotensi permintaan." | Risiko duplikasi dibebankan ke PNB |
| 6.1 Batas tanggung jawab | **3× biaya bulanan** | ± Rp 60 juta |
| 7.2 Penghentian | Pemberitahuan 30 hari | Tidak ada kewajiban migrasi data |
| 8.1 Audit | Kuesioner tahunan | Tanpa kunjungan |

**Catatan Biro Keuangan:** integrasi saat ini mengirim ulang notifikasi otomatis setiap 15 menit sampai menerima status 200. Tidak ada pencatatan ID transaksi unik di sisi SIPMA sebelum 2025.

## 3. Bank Arunika Sejahtera

| Butir | Keterangan |
| --- | --- |
| Peran | Pengendali terpisah untuk rekening; mitra untuk file rekonsiliasi |
| File rekonsiliasi | Dikirim 06.00 setiap hari, format CSV, melalui portal bank |
| Keterlambatan | 2 kali dalam 2026 (masing-masing 1 hari) |
| Koreksi | Permintaan koreksi manual 3 hari kerja |
| Retensi file di portal | 30 hari |
| Kontak darurat | Hanya call center umum, bukan account manager |

## 4. PT Sandi Data Nusantara (SDN)

| Klausul | Isi | Konsekuensi |
| --- | --- | --- |
| 2.1 Lingkup | Mengelola NAS, jadwal backup, HSM, dukungan Level 2 | Ketergantungan pada satu penyedia |
| 3.3 Kunci enkripsi | "Kunci cadangan disimpan dalam HSM yang dikelola SDN; pemulihan memerlukan persetujuan tertulis." | **Kontrol kunci berada di vendor** |
| 3.5 Pemulihan | "Permintaan pemulihan diproses dalam 5 hari kerja." | Tidak sesuai RTO 4 jam |
| 3.6 Eskalasi | "Persetujuan pemulihan darurat memerlukan verifikasi dari kantor pusat." | Waktu tidak dijamin |
| 4.2 Uji | "Uji pemulihan dilakukan setahun sekali atas permintaan pelanggan." | Tidak pernah diminta |
| 5.1 Batas tanggung jawab | 6× biaya bulanan | ± Rp 90 juta |

## 5. Awan Cakrawala

| Butir | Keterangan |
| --- | --- |
| Region | Jakarta saja; opsi region kedua tersedia (biaya tambahan) |
| SLA | 99,95% |
| Snapshot | Harian, retensi 3 hari, disimpan di region yang sama |
| Dukungan | Tiket; respons 30 menit untuk P1 |
| Catatan | Snapshot bukan pengganti backup logis; tidak diuji |

## 6. PT Pesan Cepat

| Butir | Keterangan |
| --- | --- |
| Layanan | SMS notifikasi pembayaran dan pengumuman |
| Data | Nomor HP dan isi pesan |
| SLA | 98% terkirim < 5 menit |
| Insiden | Tidak ada kewajiban notifikasi |

## 7. Ketergantungan berantai

```
SIPMA ──► Awan Cakrawala (VM, snapshot)
   │
   ├──► SDN (NAS, backup, HSM)  ◄── kunci enkripsi
   ├──► PayLoka (webhook, ledger 7 hari)
   ├──► Bank (file 06.00)
   └──► Pesan Cepat (SMS)

Rantai terlemah: SIPMA + SDN + PayLoka
Jika salah satu gagal, registrasi tidak dapat diselesaikan otomatis.
```

## 8. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Klausul mana yang membuat RTO 4 jam **mustahil** dipenuhi?
- Siapa yang menanggung kerugian jika mahasiswa ditagih dua kali?
- Apakah PNB memiliki hak untuk mendapatkan data transaksi setelah 7 hari?
- Apa yang harus dinegosiasikan sebelum kontrak berikutnya, dan apa yang harus disiapkan jika negosiasi gagal?

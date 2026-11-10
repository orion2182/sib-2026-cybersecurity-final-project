# 07 — Batas Anggaran dan Daftar Harga Opsi

**Dokumen:** pagu program kelangsungan layanan TA 2026/2027
**Disusun oleh:** Biro Keuangan, 3 November 2026

---

## 1. Pagu

| Butir | Nilai |
| --- | ---: |
| Pagu program kelangsungan layanan | **Rp 320.000.000** |
| Sudah terpakai | Rp 0 |
| Sisa yang dapat dialokasikan | **Rp 320.000.000** |
| Belanja vendor operasional (di luar pagu) | Rp 720.000.000/tahun |
| Dana darurat yang dapat diajukan (persetujuan Direktur) | maksimum Rp 80.000.000, satu kali |
| Batas waktu penyerapan | 31 Desember 2026 |

**Aturan:**
1. Harga di bawah adalah penawaran indikatif; tidak boleh diasumsikan turun.
2. Biaya berulang harus dinyatakan; anggaran tahun berikutnya belum tentu tersedia.
3. Setiap opsi harus terkait risiko bernomor.
4. Opsi yang tidak didanai dicatat sebagai risiko yang diterima.

## 2. Daftar opsi

| Kode | Opsi | Biaya | Sifat | Waktu siap | Menutup |
| --- | --- | ---: | --- | --- | --- |
| P-01 | Situs cadangan (DR) region kedua, 1 tahun | Rp 240.000.000 | berulang | 10 minggu | A-5, A-4 |
| P-02 | Backup off-site (objek, retensi 30 hari) | Rp 85.000.000 | berulang | 3 minggu | A-2 |
| P-03 | Uji restore penuh + perbaikan prosedur | Rp 25.000.000 | sekali | 2 minggu | A-3, A-6 |
| P-04 | MFA untuk 40 staf | Rp 30.000.000 | sekali + Rp 4 jt/tahun | 6 minggu | B-1 |
| P-05 | Replika basis data baca (read replica) | Rp 96.000.000 | berulang | 6 minggu | A-4 |
| P-06 | Kit registrasi manual (4 loket, 3 hari) | Rp 40.000.000 | sekali | 1 minggu | A-8, A-9 |
| P-07 | Alat rekonsiliasi pembayaran (idempotensi, ledger) | Rp 60.000.000 | sekali + Rp 12 jt/tahun | 8 minggu | B-3, duplikasi |
| P-08 | Konsultan BCP + BIA | Rp 70.000.000 | sekali | 8 minggu | A-7, A-10 |
| P-09 | Redesain escrow kunci enkripsi | Rp 35.000.000 | sekali | 6 minggu | B-6 (kunci) |
| P-10 | Tabletop + pelatihan prosedur manual | Rp 15.000.000 | berulang/tahun | 3 minggu | A-7, A-8 |
| P-11 | SMS blast darurat (paket 50.000 pesan) | Rp 12.000.000 | sekali | 1 minggu | komunikasi |
| P-12 | Kanal pembayaran cadangan (VA bank kedua) | Rp 110.000.000 | berulang | 12 minggu | ketergantungan PayLoka |
| P-13 | Kebijakan dan prosedur privasi proses manual | Rp 18.000.000 | sekali | 4 minggu | C-9 |
| P-14 | Enkripsi berkas unggahan (kunci sendiri) | Rp 45.000.000 | sekali | 7 minggu | C-4 |
| P-15 | Log audit 12 bulan + pemantauan | Rp 32.000.000 | berulang/tahun | 5 minggu | B-4 |
| P-16 | Klasifikasi data + minimisasi formulir | Rp 24.000.000 | sekali | 5 minggu | C-1, C-2 |

## 3. Contoh kombinasi (bukan rekomendasi)

| Kombinasi | Total | Yang tidak tercakup |
| --- | ---: | --- |
| P-02 + P-03 + P-06 + P-10 + P-11 | Rp 177.000.000 | DR, MFA, rekonsiliasi |
| P-01 + P-06 | Rp 280.000.000 | Backup off-site, MFA, privasi manual |
| P-04 + P-07 + P-13 + P-16 | Rp 132.000.000 | Semua kapasitas pemulihan |

## 4. Biaya yang belum ada penawarannya

- Kerugian akibat mahasiswa tidak dapat mengikuti ujian (tidak dapat dihitung sebagai biaya langsung).
- Biaya refund/ kompensasi duplikasi pembayaran.
- Biaya komunikasi krisis (call center tambahan, pengumuman).
- Biaya hukum jika ada gugatan.
- Biaya lembur 60 jam/hari selama proses manual (hitung sendiri dari asumsi upah).

## 5. Aturan rekomendasi

1. Setiap rupiah harus terkait risiko.
2. Tunjukkan apa yang **tidak** dibeli.
3. Jika inject menambah kebutuhan, tunjukkan reallokasi.
4. Jangan mengasumsikan dana darurat tersedia tanpa persetujuan.

## 6. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Apa dua pembelian yang paling menurunkan **dampak** (bukan kemungkinan)?
- Apakah DR site layak dibandingkan backup off-site + prosedur manual?
- Pembelian mana yang berguna hanya jika kontrol lain sudah ada?

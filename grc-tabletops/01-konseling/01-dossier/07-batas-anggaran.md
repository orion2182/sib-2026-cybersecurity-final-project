# 07 — Batas Anggaran dan Daftar Harga Opsi

**Dokumen:** pagu program privasi & keamanan informasi TA 2026/2027
**Disusun oleh:** Biro Keuangan, 2 November 2026
**Sifat:** angka fiktif; harga adalah estimasi vendor yang sudah dikumpulkan UPT TIK

---

## 1. Pagu

| Butir | Nilai |
| --- | ---: |
| Pagu program privasi & keamanan (satu tahun) | **Rp 180.000.000** |
| Sudah terpakai per 1 Nov 2026 | Rp 8.500.000 (pelatihan Agustus 2025 dialihkan) |
| **Sisa yang dapat dialokasikan** | **Rp 171.500.000** |
| Belanja vendor layanan (di luar pagu ini) | Rp 168.000.000/tahun |
| Biaya darurat yang dapat diajukan (harus disetujui Rektor) | maksimum Rp 60.000.000, satu kali |

**Aturan pagu:**
1. Tidak boleh melebihi Rp 171.500.000 tanpa persetujuan Rektor dan revisi anggaran.
2. Setiap opsi harus punya pemilik, tanggal selesai, dan bukti selesai.
3. Biaya berulang (lisensi tahunan) harus dinyatakan sebagai berulang, bukan sekali bayar.
4. Opsi yang tidak didanai harus tetap dicatat sebagai **risiko yang diterima**, bukan dihapus dari daftar.

## 2. Daftar opsi

| Kode | Opsi | Biaya | Sifat | Waktu | Menutup celah |
| --- | --- | ---: | --- | --- | --- |
| O-01 | Konsultan DPIA untuk layanan konseling | Rp 45.000.000 | sekali | 6 minggu | G-4, G-3 |
| O-02 | Audit keamanan vendor (on-site, 5 hari) | Rp 60.000.000 | sekali | 4 minggu | V-1, V-4 |
| O-03 | MFA + SSO untuk 9 konselor dan 4 admin | Rp 35.000.000 | sekali + Rp 6 jt/tahun | 8 minggu | AC-1, AC-2 |
| O-04 | Akun unik + penghapusan akun bersama | Rp 12.000.000 | sekali | 3 minggu | AC-1, AC-5 |
| O-05 | Pencatatan akses baca (audit log 12 bulan) | Rp 28.000.000 | berulang/tahun | 6 minggu | AC-4, A-10 |
| O-06 | Otomasi retensi + register pemusnahan | Rp 40.000.000 | sekali | 10 minggu | D-6, D-7, G-6 |
| O-07 | DLP untuk ekspor dan surel | Rp 75.000.000 | sekali + Rp 15 jt/tahun | 12 minggu | D-5, A-09 |
| O-08 | Redundansi hotline (nomor cadangan + agen kedua) | Rp 65.000.000 | berulang/tahun | 6 minggu | A-05, kontinuitas |
| O-09 | Prosedur + kotak surat permintaan subjek data | Rp 9.000.000 | sekali | 4 minggu | G-7, IR-3 |
| O-10 | Pelatihan privasi + phishing (2 gelombang) | Rp 18.000.000 | berulang/tahun | 8 minggu | G-8 |
| O-11 | Uji restore dan uji tabletop kontinuitas | Rp 15.000.000 | berulang/tahun | 4 minggu | V-5, G-9 |
| O-12 | Migrasi keluar dari vendor (ekspor + alat baru) | Rp 55.000.000 | sekali | 12 minggu | V-6, A-03 |
| O-13 | Enkripsi 4 laptop yang belum terenkripsi | Rp 4.000.000 | sekali | 1 minggu | AC-7 |
| O-14 | Kunci enkripsi dikelola sendiri (BYOK) | Rp 50.000.000 | sekali + Rp 10 jt/tahun | 10 minggu | D-1 |
| O-15 | Klasifikasi data dan daftar kegiatan pemrosesan | Rp 22.000.000 | sekali | 6 minggu | D-4, G-3 |

## 3. Contoh kombinasi yang mungkin (bukan rekomendasi)

Tabel ini hanya menunjukkan bahwa pagu memaksa pilihan. Jangan menyalinnya sebagai jawaban.

| Kombinasi | Total | Yang tidak tercakup |
| --- | ---: | --- |
| O-01 + O-03 + O-04 + O-13 + O-09 | Rp 105.000.000 | Audit vendor, DLP, redundansi hotline |
| O-02 + O-08 + O-11 + O-13 | Rp 144.000.000 | DPIA, retensi, MFA |
| O-06 + O-12 + O-05 | Rp 123.000.000 | Semua kontrol akses dasar |

## 4. Biaya yang tidak ada di daftar

Beberapa kebutuhan tidak memiliki penawaran karena belum pernah diminta:

- biaya notifikasi insiden (cetak, call center tambahan, pemantauan reputasi);
- biaya pendampingan hukum untuk pengaduan mahasiswa;
- biaya forensik independen;
- biaya rujukan tambahan ke klinik mitra bila kapasitas internal turun;
- biaya lembur admin untuk proses manual.

Tim harus **memperkirakan** biaya ini dan menyatakan asumsinya, atau menyatakan bahwa biaya tidak diketahui dan menjadi risiko.

## 5. Aturan yang harus dipatuhi dalam rekomendasi

1. Setiap opsi yang dipilih harus terkait ke minimal satu risiko bernomor di risk register.
2. Setiap opsi yang **tidak** dipilih harus muncul di kolom "risiko yang diterima" pada memo keputusan, dengan pemilik.
3. Jika inject menambah kebutuhan mendesak, tunjukkan **dari mana** dana diambil (reallokasi, bukan asumsi tambahan).
4. Jangan mengasumsikan harga bisa turun tanpa bukti.

## 6. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Apa tiga pembelian yang memberi penurunan risiko terbesar per rupiah, dan mengapa?
- Pembelian mana yang **tidak** berguna jika kontrol dasar (akun unik, MFA) belum ada?
- Jika muncul kebutuhan mendesak Rp 40.000.000, opsi mana yang Anda tunda?

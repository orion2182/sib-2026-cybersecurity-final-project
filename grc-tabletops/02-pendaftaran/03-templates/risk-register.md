# Template — Risk Register

**Kasus:** GRC-2 Pendaftaran dan Pembayaran Kampus
**Tim:** ____________________  **Versi:** ____  **Tanggal:** __________

> Satu baris = satu risiko. Risiko bukan "kontrol yang belum ada".

---

## 1. Skala

**Kemungkinan (K):**

| Nilai | Label | Arti operasional |
| :-: | --- | --- |
| 1 | Jarang | Belum pernah; tidak ada pemicu |
| 2 | Mungkin | Pernah di institusi lain; pemicu ada |
| 3 | Cukup sering | Pernah terjadi di PNB dalam 3 tahun |
| 4 | Sering | Beberapa kali per tahun |
| 5 | Hampir pasti | Terjadi pada setiap periode puncak |

**Dampak (D):**

| Nilai | Label | Contoh |
| :-: | --- | --- |
| 1 | Minimal | Gangguan < 30 menit; tanpa dampak akademik |
| 2 | Kecil | Gangguan < 2 jam; dapat diselesaikan manual |
| 3 | Sedang | Sebagian mahasiswa terlambat registrasi; koreksi manual |
| 4 | Besar | Ratusan mahasiswa kehilangan hak KRS; data pribadi terekspos; notifikasi wajib |
| 5 | Sangat besar | Ribuan mahasiswa terdampak; sanksi/ gugatan; kerugian > Rp 1 miliar |

**Skor = K × D.** Tetapkan ambang prioritas dan tulis alasannya.

## 2. Register

| ID | Risiko (sebab–akibat) | Proses/ aset | K | D | Skor | Pemilik | Kontrol saat ini | Celah | Bukti | Perlakuan | Opsi anggaran | Risiko sisa | Status |
| --- | --- | --- | :-: | :-: | :-: | --- | --- | --- | --- | --- | --- | :-: | --- |
| R-01 | | | | | | | | | | | | | |
| R-02 | | | | | | | | | | | | | |
| R-03 | | | | | | | | | | | | | |
| R-04 | | | | | | | | | | | | | |
| R-05 | | | | | | | | | | | | | |
| R-06 | | | | | | | | | | | | | |
| R-07 | | | | | | | | | | | | | |
| R-08 | | | | | | | | | | | | | |
| R-09 | | | | | | | | | | | | | |
| R-10 | | | | | | | | | | | | | |

## 3. Contoh penulisan

| Salah | Benar |
| --- | --- |
| "Backup tidak diuji" | "Jika backup tidak dapat dipulihkan saat gangguan, maka status pembayaran 5 hari hilang, yang mengakibatkan mahasiswa yang sudah membayar tercatat tidak terdaftar." |
| "Vendor gagal" | "Jika PayLoka berhenti tanpa migrasi, maka 1.900 transaksi tidak dapat direkonsiliasi, yang mengakibatkan duplikasi tagihan dan keluhan massal." |

## 4. Tiga risiko prioritas

| Peringkat | ID | Alasan | Dampak jika tidak ditangani dalam 7 hari |
| :-: | --- | --- | --- |
| 1 | | | |
| 2 | | | |
| 3 | | | |

## 5. Perlakuan

| ID | Perlakuan | Tindakan | Pemilik | Tenggat | Bukti selesai | Biaya |
| --- | --- | --- | --- | --- | --- | ---: |
| | | | | | | |

## 6. Perubahan setelah inject

| ID | Skor sebelum | Skor sesudah | Fakta pemicu | Keputusan ulang |
| --- | :-: | :-: | --- | --- |
| | | | | |

## 7. Daftar periksa

- [ ] Ada risiko yang berdampak **akademik** (bukan hanya finansial/ TI).
- [ ] Ada risiko yang berdampak pada **data pribadi**.
- [ ] Ada risiko yang berasal dari **proses manual**.
- [ ] Setiap risiko punya pemilik jabatan.
- [ ] Setiap skor merujuk bukti atau asumsi berlabel.
- [ ] Risiko yang diterima muncul di memo keputusan.

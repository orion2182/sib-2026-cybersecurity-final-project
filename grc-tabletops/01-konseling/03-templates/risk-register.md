# Template — Risk Register

**Kasus:** GRC-1 Layanan Konseling Mahasiswa
**Tim:** ____________________  **Versi:** ____  **Tanggal:** __________

> Isi setiap kolom. Jangan menilai risiko sebelum menuliskan buktinya. Satu baris = satu risiko, bukan satu kontrol.

---

## 1. Skala penilaian (pakai konsisten)

**Kemungkinan (K):**

| Nilai | Label | Arti operasional |
| :-: | --- | --- |
| 1 | Jarang | Belum pernah terjadi; tidak ada pemicu yang terlihat |
| 2 | Mungkin | Pernah terjadi di organisasi lain; pemicu ada |
| 3 | Cukup sering | Pernah terjadi di organisasi ini dalam 2 tahun |
| 4 | Sering | Terjadi beberapa kali per tahun |
| 5 | Hampir pasti | Terjadi sekarang atau berulang setiap bulan |

**Dampak (D):**

| Nilai | Label | Contoh untuk kasus ini |
| :-: | --- | --- |
| 1 | Minimal | Tidak ada data pribadi terdampak; layanan normal |
| 2 | Kecil | Gangguan < 1 jam; data internal terbatas |
| 3 | Sedang | Data kesehatan beberapa orang terekspos; sesi tertunda 1 hari |
| 4 | Besar | Data kesehatan puluhan orang; hotline tidak berfungsi; pemberitahuan wajib |
| 5 | Sangat besar | Risiko keselamatan jiwa; data ratusan orang; sanksi/ gugatan |

**Skor = K × D.** Rentang 1–25. Tentukan sendiri ambang prioritas (mis. ≥15 tinggi) dan **tuliskan alasannya**.

## 2. Register

| ID | Risiko (pernyataan sebab–akibat) | Aset/ proses | K | D | Skor | Pemilik risiko | Kontrol saat ini | Celah | Bukti (dokumen) | Perlakuan yang diusulkan | Opsi anggaran | Risiko sisa | Status |
| --- | --- | --- | :-: | :-: | :-: | --- | --- | --- | --- | --- | --- | :-: | --- |
| R-01 | | | | | | | | | | | | | |
| R-02 | | | | | | | | | | | | | |
| R-03 | | | | | | | | | | | | | |
| R-04 | | | | | | | | | | | | | |
| R-05 | | | | | | | | | | | | | |
| R-06 | | | | | | | | | | | | | |
| R-07 | | | | | | | | | | | | | |
| R-08 | | | | | | | | | | | | | |

## 3. Panduan menulis pernyataan risiko

Gunakan pola: **"Jika [sebab], maka [peristiwa], yang mengakibatkan [dampak pada subjek data/organisasi]."**

| Salah | Benar |
| --- | --- |
| "Vendor tidak aman" | "Jika subprosesor menyimpan lampiran tanpa konfigurasi akses yang benar, maka catatan konseling dapat diakses publik, yang mengakibatkan pengungkapan data kesehatan dan kewajiban pemberitahuan." |
| "Tidak ada MFA" | "Jika akun bersama dipakai tanpa MFA, maka pihak yang tidak berhak dapat membaca rekam 4.780 mahasiswa tanpa terdeteksi." |

## 4. Tiga risiko prioritas

| Peringkat | ID | Mengapa dipilih | Apa yang akan terjadi dalam 30 hari jika tidak ditangani |
| :-: | --- | --- | --- |
| 1 | | | |
| 2 | | | |
| 3 | | | |

## 5. Perlakuan risiko

Untuk setiap risiko prioritas, pilih satu atau lebih: **hindari / kurangi / alihkan / terima**. Jika memilih "terima", sebutkan siapa yang menyetujui dan atas dasar apa.

| ID | Perlakuan | Tindakan konkret | Pemilik | Tenggat | Bukti selesai | Biaya |
| --- | --- | --- | --- | --- | --- | ---: |
| | | | | | | |

## 6. Risiko yang berubah setelah inject

| ID | Sebelum inject (skor) | Setelah inject (skor) | Apa yang berubah | Keputusan ulang |
| --- | :-: | :-: | --- | --- |
| | | | | |

## 7. Daftar periksa mutu

- [ ] Setiap risiko punya pemilik yang bernama jabatan, bukan "tim".
- [ ] Setiap skor merujuk bukti (dokumen/ fakta/ asumsi berlabel).
- [ ] Ada minimal satu risiko yang berkaitan dengan **keselamatan** pengguna, bukan hanya data.
- [ ] Ada minimal satu risiko yang berkaitan dengan **vendor/subprosesor**.
- [ ] Ada minimal satu risiko yang berkaitan dengan **retensi/penghapusan**.
- [ ] Risiko yang tidak ditangani muncul kembali di memo keputusan sebagai risiko sisa.

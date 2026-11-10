# Template — Business Impact Analysis (4 jam / 1 hari / 3 hari)

**Kasus:** GRC-2 Pendaftaran dan Pembayaran Kampus
**Tim:** ____________________  **Tanggal:** __________

> BIA harus menjelaskan siapa yang kehilangan apa, bukan hanya sistem mana yang mati.

---

## 1. Titik waktu

| Titik | Konteks kasus ini |
| --- | --- |
| **4 jam** | Satu pagi puncak pembayaran; 380 transaksi/jam tertahan |
| **1 hari** | Melewati satu siklus rekonsiliasi bank (06.00) |
| **3 hari** | Melewati tenggat 11 Desember; dampak menjadi akademik dan permanen |

## 2. Proses kritis

| ID | Proses | Volume | 4 jam | 1 hari | 3 hari | Dapat dipulihkan? |
| --- | --- | ---: | --- | --- | --- | --- |
| B-01 | Pembayaran UKT | 380/jam | | | | |
| B-02 | Pencatatan status registrasi | 2.400/hari | | | | |
| B-03 | Rekonsiliasi bank | 1 file/hari | | | | |
| B-04 | Verifikasi beasiswa | 380 total | | | | |
| B-05 | Pendaftaran mahasiswa baru | 3.100 total | | | | |
| B-06 | Pengisian KRS | 14.300 | | | | |
| B-07 | Pelaporan PDDikti | 2/semester | | | | |

## 3. Dampak per dimensi

| Dimensi | 4 jam | 1 hari | 3 hari | Bukti/ asumsi |
| --- | --- | --- | --- | --- |
| **Akademik** (hak KRS/ ujian) | | | | |
| **Keuangan** (Rp) | | | | |
| **Data pribadi** | | | | |
| **Kepercayaan mahasiswa** | | | | |
| **Kepatuhan/ regulasi** | | | | |
| **Beban staf** | | | | |

**Perhitungan yang harus ditunjukkan:**
- nilai transaksi tertahan = jumlah transaksi × rata-rata UKT;
- jam staf manual = jumlah transaksi ÷ transaksi per jam per loket;
- biaya lembur = jam × tarif (nyatakan asumsi);
- biaya rujukan/ kompensasi bila ada.

## 4. Dampak yang tidak dapat dipulihkan

| Kejadian | Mengapa tidak dapat dipulihkan | Pencegahan |
| --- | --- | --- |
| Mahasiswa kehilangan hak ujian | Kalender akademik tidak dapat diubah | |
| Data pribadi tersebar di WhatsApp | Tidak dapat ditarik | |
| Bukti transaksi hilang saat vendor berhenti | Tidak dapat direkonstruksi | |
| Kepercayaan pendaftar baru | Berpengaruh ke angkatan berikutnya | |

## 5. Prioritas pemulihan

| Peringkat | Proses | Alasan | RTO | RPO |
| :-: | --- | --- | --- | --- |
| 1 | | | | |
| 2 | | | | |
| 3 | | | | |
| 4 | | | | |

## 6. Asumsi

| # | Asumsi | Dasar | Jika salah |
| --- | --- | --- | --- |
| A-1 | | | |
| A-2 | | | |
| A-3 | | | |

## 7. Daftar periksa

- [ ] Dampak akademik dinyatakan terpisah dari finansial.
- [ ] Ada perhitungan, bukan hanya label.
- [ ] Ada dampak data pribadi pada proses manual.
- [ ] Ada minimal satu dampak permanen.
- [ ] Prioritas pemulihan mempertimbangkan tenggat 11 Desember.

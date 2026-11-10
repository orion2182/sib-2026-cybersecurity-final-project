# Template — Business Impact Analysis (4 jam / 1 hari / 3 hari)

**Kasus:** GRC-1 Layanan Konseling Mahasiswa
**Tim:** ____________________  **Tanggal:** __________

> BIA bukan daftar sistem. BIA menjelaskan apa yang **berhenti** bagi pengguna ketika layanan berhenti, dan apa yang tidak dapat dipulihkan setelahnya.

---

## 1. Definisi titik waktu

| Titik | Arti | Yang harus dinilai |
| --- | --- | --- |
| **4 jam** | Gangguan singkat dalam satu shift | Antrean, panggilan tak terjawab, pekerjaan tertunda |
| **1 hari** | Gangguan melewati satu siklus harian | Sesi batal, eskalasi krisis, kepercayaan |
| **3 hari** | Gangguan yang mengubah cara kerja | Kapasitas, keselamatan, kepatuhan, reputasi |

Isi kolom dengan **besaran**, bukan kata "tinggi/rendah" saja. Jika angka tidak ada, tulis asumsi dan cara memperkirakannya.

## 2. Proses kritis

| ID | Proses | Pengguna/ volume harian | 4 jam | 1 hari | 3 hari | Dapat dipulihkan? | Ketergantungan |
| --- | --- | ---: | --- | --- | --- | --- | --- |
| B-01 | Hotline krisis | 3 panggilan/hari (puncak 9) | | | | | Panggilan Aman, psikolog jaga |
| B-02 | Sesi konseling terjadwal | 50/hari (puncak 96) | 8–20 tertunda | 50 tertunda | 150 tertunda | Ya, dengan catatan kertas | SIPKON, konselor |
| B-03 | Chat konseling | 90–180 sesi/hari | | | | | SIPKON, Nimbus |
| B-04 | Pencatatan rekam sesi | 50–96/hari | | | | | SIPKON |
| B-05 | Rujukan klinik | 1–2/hari | | | | | surel, klinik |
| B-06 | Forum sebaya | 40 posting/hari | | | | | server kampus |
| B-07 | Pelaporan manajemen | bulanan | | | | | SIPKON |

## 3. Dampak per dimensi

| Dimensi | 4 jam | 1 hari | 3 hari | Bukti/ asumsi |
| --- | --- | --- | --- | --- |
| **Keselamatan pengguna** | | | | |
| **Klinis** (kualitas perawatan) | | | | |
| **Keuangan** (Rp) | | | | |
| **Kepatuhan** (kewajiban hukum) | | | | |
| **Reputasi/ kepercayaan** | | | | |
| **Operasional staf** | | | | |

**Catatan keuangan yang harus dihitung:**
- biaya rujukan tambahan (Rp 350.000 per rujukan);
- jam lembur admin dan konselor (Rp 85.000/jam);
- biaya saluran cadangan;
- potensi kompensasi/gugatan (nyatakan asumsi, jangan mengarang angka pasti).

## 4. Dampak yang tidak dapat dipulihkan

| Kejadian | Mengapa tidak dapat dipulihkan | Pencegahan |
| --- | --- | --- |
| Panggilan krisis tidak terjawab | Kesempatan intervensi hilang | |
| Catatan sesi hilang permanen | Riwayat klinis tidak dapat direkonstruksi | |
| Data terekspos publik | Tidak dapat "ditarik kembali" | |
| Kepercayaan mahasiswa turun | Butuh waktu lama dan bukti perilaku | |

## 5. Prioritas pemulihan

Urutkan proses berdasarkan **dampak**, bukan berdasarkan kemudahan teknis.

| Peringkat | Proses | Alasan | RTO yang diusulkan | RPO yang diusulkan |
| :-: | --- | --- | --- | --- |
| 1 | | | | |
| 2 | | | | |
| 3 | | | | |
| 4 | | | | |

## 6. Asumsi yang dipakai

| # | Asumsi | Dasar | Jika asumsi salah, apa yang berubah |
| --- | --- | --- | --- |
| A-1 | | | |
| A-2 | | | |
| A-3 | | | |

## 7. Daftar periksa mutu

- [ ] Ada dampak keselamatan yang dinyatakan terpisah dari dampak finansial.
- [ ] Angka volume konsisten dengan dossier.
- [ ] Setiap angka yang dikarang diberi label asumsi.
- [ ] Ada minimal satu dampak yang tidak dapat dipulihkan.
- [ ] Prioritas pemulihan tidak sama dengan urutan modul aplikasi.

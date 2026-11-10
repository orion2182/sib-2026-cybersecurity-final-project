# 08 — Perjanjian Tingkat Layanan (SLA)

**Dokumen:** kompilasi SLA vendor dan target internal, 31 Oktober 2026
**Catatan:** tidak ada satu SLA internal yang ditandatangani untuk layanan "Ruang Aman". Kolom "target internal" adalah praktik yang diakui secara lisan.

---

## 1. SLA PT Hening Cloud (SIPKON)

| Parameter | Nilai kontraktual | Kenyataan/ catatan |
| --- | --- | --- |
| Ketersediaan bulanan | 99,5% | Tidak ada laporan independen; 99,5% = 3,6 jam gangguan/bulan |
| Respons P1 | 4 jam | Diukur sejak tiket dibuat, bukan sejak gangguan |
| Resolusi P1 | 8 jam | Tidak ada sanksi |
| RTO | 8 jam | Tidak pernah diuji |
| RPO | 24 jam | Cadangan harian 02.00 |
| Notifikasi insiden | 72 jam setelah konfirmasi | "Konfirmasi" tidak didefinisikan |
| Pemeliharaan terjadwal | Maksimum 4 jam/bulan, pemberitahuan 48 jam | Boleh pada jam kerja |
| Kredit layanan | 5% biaya bulanan per kejadian | Maksimum 1 bulan |
| Dukungan | Jam kerja 08.00–17.00; P1 24/7 lewat telepon | Nomor hanya untuk 2 staf UPT TIK |

**Perhitungan sederhana:** 99,5% dari 30 hari = 3,6 jam. Jika gangguan terjadi pada jam sibuk (96 sesi/hari = 4 sesi/jam), 3,6 jam berarti ±14 sesi tertunda. Jika gangguan terjadi pada malam hari, dampaknya kecil — kecuali pada chat yang dipakai 24/7.

## 2. SLA PT Panggilan Aman (hotline)

| Parameter | Nilai kontraktual | Kenyataan/ catatan |
| --- | --- | --- |
| Ketersediaan | 95% (tidak didefinisikan per bulan) | Tidak jelas apa artinya |
| Waktu jawab | 95% panggilan < 60 detik | Tidak ada laporan kepatuhan |
| Eskalasi ke psikolog jaga | 15 menit | Diuji 2 kali (2025), keduanya > 25 menit |
| Perekaman | 100% panggilan | Tidak ada verifikasi |
| Retensi rekaman | 90 hari | Tanpa dasar tertulis dari UCA |
| Gangguan | Panggilan dialihkan ke voicemail | **Tidak dapat diterima untuk jalur krisis** |
| Notifikasi insiden | 5 hari kerja | Terlalu lambat |
| Sanksi | Tidak ada | |

## 3. Target internal (lisan, tidak terdokumentasi)

| Layanan | Target | Sumber | Kesenjangan |
| --- | --- | --- | --- |
| Hotline dijawab | < 30 detik | "kesepakatan lama" | Tidak ada SLA vendor yang mendukung |
| Sesi pertama untuk risiko tinggi | < 48 jam | praktik | Tidak ada kapasitas cadangan |
| Sesi pertama untuk risiko rendah | < 10 hari | praktik | Rata-rata 6,4 hari |
| Permintaan akses data | 14 hari | kebiasaan admin | Kewajiban hukum lebih ketat (periksa sendiri) |
| Permintaan hapus | "secepatnya" | tidak ada | Tidak ada prosedur |
| Pemberitahuan insiden | "segera" | tidak ada | Tidak ada ambang, template, atau penanggung jawab |

## 4. Ketidaksesuaian yang terlihat

1. **Target internal hotline (< 30 detik) lebih ketat daripada SLA vendor (< 60 detik).** Tidak ada dasar kontraktual untuk menuntut 30 detik.
2. **Permintaan subjek data 14 hari** kemungkinan melebihi batas waktu yang diatur undang-undang untuk jenis permintaan tertentu. Tim harus memeriksa teks resmi dan menghitung sendiri.
3. **RTO 8 jam vendor** tidak berlaku untuk hotline, yang dikelola vendor berbeda tanpa RTO.
4. **Notifikasi 72 jam** dari vendor hanya menyisakan waktu sangat sedikit bagi UCA untuk memenuhi kewajiban pemberitahuannya sendiri.
5. **Tidak ada SLA untuk forum** dan untuk proses manual (kertas).

## 5. Cara menguji klaim SLA

Tim tidak boleh menghubungi vendor. Sebagai gantinya, nilai:

| Pertanyaan | Bukti yang tersedia |
| --- | --- |
| Apakah uptime 99,5% pernah dilanggar? | Laporan bulanan vendor (3 bulan terakhir): 99,6%; 99,2%; 99,7% |
| Apakah ada kompensasi yang pernah dibayar? | Tidak ada catatan |
| Apakah RTO 8 jam realistis? | Tidak ada uji restore; ukuran data 640 GB; kecepatan ekspor tidak diketahui |
| Apakah 72 jam cukup? | Waktu deteksi internal tidak diketahui |

## 6. Pertanyaan yang harus dijawab tim (bukan jawaban)

- SLA mana yang **tidak mendukung** kebutuhan keselamatan, dan bagaimana menutupnya tanpa menunggu kontrak baru?
- Apakah RTO 8 jam dapat dipertahankan sebagai janji kepada pimpinan? Bukti apa yang diperlukan untuk mengklaimnya?
- Apa yang harus diubah dalam kontrak berikutnya agar kewajiban pemberitahuan UCA dapat dipenuhi?

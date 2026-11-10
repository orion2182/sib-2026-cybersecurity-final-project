# 01 — Deskripsi Layanan "Ruang Aman"

**Dokumen:** deskripsi layanan dan proses bisnis
**Pemilik:** Kepala UPT-LPK
**Versi:** 2.1, 14 Oktober 2026
**Sifat:** ringkasan operasional, bukan prosedur lengkap

---

## 1. Perjalanan pengguna

### 1.1 Konseling individual

1. **Akses awal.** Mahasiswa membuka `ruangaman.uca.ac.id`, mengisi formulir intake (nama, NIM, kontak, fakultas, keluhan utama, riwayat konseling sebelumnya, preferensi konselor).
2. **Triase.** Admin memeriksa formulir, memberi kategori risiko (rendah/sedang/tinggi), dan menjadwalkan sesi.
3. **Sesi.** Konselor mencatat ringkasan sesi pada sistem (format SOAP ringkas), menandai faktor risiko, dan menetapkan rencana tindak lanjut.
4. **Tindak lanjut.** Sesi lanjutan, rujukan ke klinik mitra, atau penutupan kasus.
5. **Penutupan.** Status kasus ditutup; rekam tetap tersimpan sesuai jadwal retensi (lihat `05-jadwal-retensi.md`).

### 1.2 Hotline krisis 24/7

1. Penelepon diarahkan ke nomor 0800-1-ARUNIKA (fiktif), dijawab agen PT Panggilan Aman.
2. Agen mengikuti skrip triase krisis dan dapat menghubungkan ke psikolog jaga UCA dalam 15 menit.
3. Semua panggilan direkam; ringkasan panggilan dikirim ke UPT-LPK melalui surel terenkripsi (kata sandi dikirim terpisah via WhatsApp).
4. Panggilan yang memerlukan tindakan segera dieskalasi ke Tim Siaga Kampus dan/atau layanan gawat darurat.

### 1.3 Forum "Teman Sebaya"

Moderator (2 mahasiswa terlatih + 1 konselor) meninjau laporan. Posting dapat memuat cerita kesehatan mental. Tidak ada klasifikasi data, tidak ada jadwal retensi, dan tidak ada mekanisme penghapusan atas permintaan.

## 2. Volume dan jam sibuk

| Metrik | Nilai | Sumber |
| --- | ---: | --- |
| Mahasiswa terlayani 2025/2026 | 4.780 | laporan tahunan UPT |
| Sesi individual | 12.400 | sistem (SIPKON) |
| Sesi puncak per hari | 96 | rata-rata 3 hari tersibuk |
| Sesi chat puncak per hari | 180 | log vendor |
| Panggilan hotline | 1.050/tahun | vendor |
| Panggilan jam 22.00–06.00 | 38% | vendor |
| Rujukan klinik | 320/tahun | surat rujukan |
| Waktu tunggu rata-rata | 6,4 hari | sistem |
| Waktu tunggu kasus risiko tinggi | 1,2 hari | sistem |

**Periode kritis:** pekan ujian (Desember dan Mei). Pada Desember 2025, permintaan sesi naik 47% dibanding rata-rata bulanan.

## 3. Orang dan kapasitas

| Peran | Jumlah | Catatan |
| --- | ---: | --- |
| Psikolog klinis | 2 | Supervisi, kasus risiko tinggi |
| Konselor | 9 | 3 paruh waktu; 2 belum menyelesaikan pelatihan privasi |
| Admin | 4 | Membuka akses, menjadwalkan, mengunggah dokumen |
| Moderator forum | 3 | 2 mahasiswa, 1 konselor |
| Psikolog jaga (on-call) | 4 | Di luar jam kerja, berbasis panggilan |

**Kapasitas cadangan:** tidak ada. Jika 2 konselor tidak tersedia, waktu tunggu naik melebihi 14 hari dan kasus risiko tinggi mulai dialihkan ke klinik mitra dengan biaya per rujukan.

## 4. Dependensi

| Dependensi | Jenis | Dampak jika gagal | Catatan |
| --- | --- | --- | --- |
| SIPKON (SaaS Hening Cloud) | Aplikasi inti | Tidak bisa mencatat sesi, riwayat tidak terbaca | Kontrak berakhir 31 Des 2026 |
| Nimbus Object Storage | Penyimpanan lampiran | Lampiran/ekspor chat tidak dapat diakses | Subprosesor di Singapura |
| Hotline Panggilan Aman | Kanal krisis | Penelepon krisis tidak terlayani | Tidak ada nomor cadangan |
| SSO kampus | Autentikasi | Konselor tidak dapat masuk | Akun bersama masih dipakai |
| Surel kampus | Notifikasi | Ringkasan panggilan tertunda | Kata sandi arsip via WhatsApp |
| Klinik Sehat Jiwa | Rujukan | Kasus tinggi menumpuk | Pengendali data terpisah |
| Jaringan kampus | Konektivitas | Chat/video berhenti | Tidak ada jalur cadangan |

## 5. Kebutuhan layanan saat gangguan

Pernyataan pemilik proses (wawancara 22 Okt 2026, ringkas):

> "Kalau sistem mati sehari, kami masih bisa konseling tatap muka dengan catatan kertas. Yang tidak boleh mati adalah hotline. Kalau hotline mati, orang bisa meninggal. Tapi catatan kertas juga berisiko: siapa yang menyimpan, di mana, dan kapan dimusnahkan?"

**Implikasi yang harus diuji tim:**
- Apakah "catatan kertas" sudah punya prosedur, lokasi aman, dan jadwal pemusnahan?
- Apa yang terjadi pada riwayat kasus aktif jika SIPKON tidak dapat diakses selama 3 hari?
- Apakah hotline punya nomor cadangan yang sudah diumumkan ke mahasiswa?

## 6. Hal yang tidak tercatat

Dokumen ini tidak memuat:
- daftar resmi kegiatan pemrosesan dan dasar hukumnya;
- klasifikasi data per field;
- perjanjian tingkat layanan internal untuk hotline;
- rencana kontinjensi yang pernah diuji;
- daftar subprosesor yang disetujui.

Ketiadaan ini adalah bagian dari kasus, bukan kelalaian penulisan.

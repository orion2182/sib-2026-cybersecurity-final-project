# 00 — Organisasi, Layanan, dan Tata Kelola

**Kasus:** GRC-1 Layanan Konseling Mahasiswa
**Organisasi:** Universitas Cendekia Arunika (UCA), Kota Arunika
**Badan penyelenggara:** Yayasan Cendekia Arunika (YCA)
**Tanggal paket:** 10 November 2026
**Status:** seluruh isi fiktif dan sintetis. Tidak ada data pribadi nyata.

> Dokumen ini adalah titik masuk. Dokumen lain di `01-dossier/` saling melengkapi dan **sengaja** memuat ketidaksesuaian. Jangan menganggap satu dokumen lebih benar dari yang lain tanpa bukti.

---

## 1. Profil organisasi

| Butir | Keterangan |
| --- | --- |
| Nama | Universitas Cendekia Arunika (UCA) |
| Badan hukum | Yayasan Cendekia Arunika (YCA), akta fiktif No. 41/2019 |
| Lokasi | Kampus Utama, Kota Arunika (fiktif); 1 kampus cabang |
| Mahasiswa aktif | 11.200 (2026/2027) |
| Fakultas | 3 (Psikologi & Pendidikan; Teknologi; Sosial-Ekonomi) |
| Pegawai | 640 (termasuk 118 dosen) |
| Anggaran tahunan | Rp 412 miliar (fiktif) |
| Anggaran TI | Rp 21 miliar/tahun |
| Anggaran program privasi & keamanan informasi | **Rp 180 juta/tahun** (lihat `07-batas-anggaran.md`) |

## 2. Layanan yang menjadi lingkup kasus

**UPT Layanan Psikologi dan Konseling (UPT-LPK)**, dengan nama layanan publik **"Ruang Aman"**.

| Layanan | Saluran | Jam | Pengguna 2025/2026 | Catatan |
| --- | --- | --- | --- | --- |
| Konseling individual | Tatap muka, chat, video | 08.00–20.00 WIB | 4.780 mahasiswa, 12.400 sesi | 68% sesi lewat chat |
| Konseling kelompok | Tatap muka | 2 sesi/minggu | 340 mahasiswa | Catatan agregat, bukan per orang |
| Hotline krisis 24/7 | Telepon (dikelola vendor) | 24 jam | 1.050 panggilan | Rujukan langsung ke psikolog jaga |
| Rujukan klinik mitra | Surat rujukan elektronik | Sesuai janji | 320 rujukan | Klinik adalah pengendali data terpisah |
| Forum "Teman Sebaya" | Web komunitas termoderasi | 24 jam | 2.100 anggota | Posting dapat memuat data kesehatan |
| Konten edukasi | Situs & media sosial | — | — | Bukan data pribadi |

**Mengapa layanan ini kritis:** hotline krisis adalah jalur eskalasi untuk risiko keselamatan jiwa. Gangguan yang hanya "mengganggu" pada layanan lain dapat menjadi **bahaya fisik** di sini. Ini harus tercermin dalam BIA dan RTO, bukan hanya dalam narasi.

## 3. Struktur dan peran

| Peran | Nama (fiktif) | Tanggung jawab relevan |
| --- | --- | --- |
| Rektor | Dr. Aruna Wisesa | Pemilik risiko tertinggi; menyetujui risiko sisa |
| Wakil Rektor Kemahasiswaan | Dra. Mila Prasetya | Sponsor layanan; pemilik anggaran UPT-LPK |
| Kepala UPT-LPK | Bima Sanjaya, M.Psi. | Pemilik proses konseling; pemilik data operasional |
| Koordinator Konselor | Rani Kusuma, M.Psi. | Jadwal, supervisi, akses rekam sesi |
| Pejabat Fungsi PDP ("DPO") | Toga Halim, S.H. | Ditunjuk 1 Sep 2026; **rangkap jabatan** Kepala Biro Hukum; belum punya staf |
| Kepala UPT TIK | Yusuf Ardan | Infrastruktur, akun, integrasi vendor |
| Analis Keamanan Informasi | (kosong sejak Mei 2026) | Tidak ada pemilik kontrol teknis harian |
| Kepala Biro Hukum | Toga Halim, S.H. | Kontrak, litigation hold, kepatuhan |
| Komisi Etik Penelitian & Layanan | 5 anggota | Menangani pengaduan etik mahasiswa |
| Vendor utama | PT Hening Cloud Nusantara | SaaS rekam konseling, chat, video |
| Subprosesor vendor | Nimbus Object Storage Pte. Ltd. (Singapura) | Penyimpanan objek (lampiran, ekspor chat) |
| Vendor hotline | PT Panggilan Aman | Call center 24/7, perekaman panggilan |
| Mitra klinik | Klinik Sehat Jiwa Arunika | Penerima rujukan; pengendali terpisah |

## 4. Tata kelola saat ini

| Elemen | Kondisi per November 2026 | Bukti |
| --- | --- | --- |
| Kebijakan PDP | Ada, versi 2023, belum diperbarui setelah UU 27/2022 berlaku penuh | `06-kontrol-saat-ini.md` |
| Penilaian dampak (DPIA) | Belum pernah dilakukan untuk konseling | tidak ada dokumen |
| Daftar kegiatan pemrosesan | Tidak ada | tidak ada dokumen |
| Komite risiko | Tidak ada; risiko dibahas ad hoc di rapat WR | notulen tidak tersedia |
| Manajemen vendor | Checklist due diligence informal, tanpa audit | `03-daftar-vendor-kontrak.md` |
| Pelatihan privasi | 1 kali (Agu 2025), kehadiran 46% | daftar hadir |
| Uji kelangsungan layanan | Belum pernah | tidak ada dokumen |
| Saluran pengaduan | Email ke DPO; tidak ada SLA internal | `08-sla.md` |

## 5. Mandat untuk tim peserta

Wakil Rektor Kemahasiswaan membentuk **Tim Penasihat Risiko** pada 20 November 2026 dengan mandat:

1. Menilai risiko privasi, vendor, dan kelangsungan layanan "Ruang Aman".
2. Merekomendasikan prioritas kontrol yang **dapat dijalankan** dengan pagu anggaran yang ada.
3. Menyiapkan bahan keputusan untuk Rektor, termasuk risiko sisa yang harus disetujui tertulis.
4. Meninjau ulang rekomendasi setiap kali fakta baru muncul (inject).

**Batas mandat:** tim tidak boleh menghubungi vendor, tidak mengubah sistem, dan tidak memberi nasihat hukum final. Tim bekerja dari dokumen.

## 6. Fakta vs asumsi

Setiap klaim dalam laporan akhir harus diberi label salah satu:

| Label | Arti |
| --- | --- |
| **F** | Fakta — tertulis di dokumen dossier dan dapat dikutip |
| **A** | Asumsi — diisi tim karena dokumen tidak memuat; harus dinyatakan terbuka |
| **U** | Belum diketahui — perlu konfirmasi ke pemilik proses/vendor, dan menjadi action item |

Contoh: "12.400 sesi (F)"; "60% sesi memuat catatan klinis (A)"; "apakah vendor menghapus ekspor chat setelah 24 bulan (U)".

## 7. Dokumen dalam paket ini

| Dokumen | Isi |
| --- | --- |
| `01-dossier/01-deskripsi-layanan.md` | Proses bisnis, volume, ketergantungan |
| `01-dossier/02-peta-data.md` | Aliran data dan lokasi penyimpanan (rekonstruksi) |
| `01-dossier/03-daftar-vendor-kontrak.md` | 4 vendor, kutipan klausul, celah |
| `01-dossier/04-inventaris-aset.md` | Aset informasi dan dependensi |
| `01-dossier/05-jadwal-retensi.md` | 4 sumber retensi yang saling bertentangan |
| `01-dossier/06-kontrol-saat-ini.md` | Kontrol dan celah |
| `01-dossier/07-batas-anggaran.md` | Pagu dan daftar harga opsi |
| `01-dossier/08-sla.md` | SLA vendor dan target internal |
| `01-dossier/09-riwayat-insiden.md` | 4 insiden yang tidak ditindaklanjuti |
| `01-dossier/10-contoh-pemberitahuan-privasi.md` | Pemberitahuan privasi yang bermasalah |
| `02-inject/inject-1.md` | Dibuka 3 Desember 2026 |
| `02-inject/inject-2.md` | Dibuka 9 Desember 2026 |
| `03-templates/` | 7 template kerja |
| `04-tasks/student-card.md` | Situasi, aturan, Q1–Q12, deliverables |
| `05-rubric/participant-rubric.md` | Rubrik publik |

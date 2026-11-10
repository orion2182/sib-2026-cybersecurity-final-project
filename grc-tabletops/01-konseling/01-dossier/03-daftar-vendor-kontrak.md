# 03 — Daftar Vendor dan Ringkasan Kontrak

**Dokumen:** ringkasan kontrak oleh Biro Hukum, 30 Oktober 2026
**Catatan:** kutipan di bawah adalah **parafrase** dari kontrak fiktif. Tidak ada kontrak nyata yang dirujuk.

---

## 1. Ringkasan portofolio vendor

| Vendor | Layanan | Data yang disentuh | Nilai kontrak/tahun | Jangka waktu | Kritikalitas |
| --- | --- | --- | ---: | --- | --- |
| PT Hening Cloud Nusantara | SaaS rekam konseling, chat, video | Seluruh data konseling kecuali rekaman hotline | Rp 96.000.000 | 1 Jan–31 Des 2026 (opsi perpanjangan belum ditandatangani) | Tinggi |
| Nimbus Object Storage Pte. Ltd. | Penyimpanan objek (subprosesor Hening) | Lampiran, ekspor chat | Rp 18.000.000 (ditagih lewat Hening) | mengikuti Hening | Tinggi |
| PT Panggilan Aman | Call center hotline 24/7 + perekaman | Nomor penelepon, isi panggilan, ringkasan | Rp 54.000.000 | 1 Mar 2026–28 Feb 2027 | **Sangat tinggi (keselamatan)** |
| Klinik Sehat Jiwa Arunika | Penerima rujukan | Surat rujukan, identitas, ringkasan klinis | per rujukan (Rp 350.000) | tanpa kontrak payung | Sedang |

**Total belanja vendor:** Rp 168.000.000/tahun, dibayar dari **anggaran operasional** UPT-LPK dan UPT TIK. Angka ini **tidak** termasuk pagu program privasi & keamanan Rp 180.000.000 (lihat `07-batas-anggaran.md`), yang khusus dipakai untuk kontrol baru. Konsekuensinya: biaya menjalankan layanan dan biaya mengendalikannya berasal dari dua kantong berbeda, dan yang kedua jauh lebih kecil.

## 2. PT Hening Cloud Nusantara

### 2.1 Kutipan klausul relevan

| Klausul | Isi (parafrase) | Konsekuensi |
| --- | --- | --- |
| 2.1 Peran | Hening bertindak sebagai prosesor atas nama UCA | Menetapkan pembagian tanggung jawab |
| 2.4 Subprosesor | "Hening dapat menunjuk afiliasi atau penyedia pihak ketiga untuk mendukung layanan." | **Tidak ada kewajiban persetujuan tertulis UCA** |
| 2.6 Lokasi data | "Data dapat diproses di fasilitas yang dikelola Hening atau afiliasinya." | Lokasi tidak dirinci; Nimbus di Singapura |
| 3.2 Keamanan | "Hening menerapkan langkah keamanan yang wajar sesuai praktik industri." | Standar tidak terukur, tanpa acuan sertifikasi |
| 4.1 Notifikasi insiden | "Hening akan memberitahukan insiden yang berdampak pada data pelanggan dalam **72 jam** setelah konfirmasi." | Jendela 72 jam menyisakan 0 jam untuk kewajiban 3×24 jam jika konfirmasi internal lambat |
| 4.3 Audit | "Pelanggan dapat melakukan audit melalui **kuesioner tahunan**. Audit di lokasi tidak tersedia." | Tidak ada verifikasi independen |
| 5.1 SLA | 99,5% uptime bulanan; respons P1 4 jam; resolusi 8 jam | Lihat `08-sla.md` |
| 6.2 Backup | "Cadangan harian disimpan 7 hari pada region yang sama." | Tidak ada salinan off-site; tidak ada uji restore |
| 7.1 Pengembalian data | "Pada pengakhiran, pelanggan dapat mengekspor data dalam format **JSON proprietary** dalam 14 hari." | Format tidak portabel; 14 hari terlalu singkat untuk 640 GB |
| 7.3 Penghapusan | "Hening menghapus data dalam 30 hari setelah ekspor." | Tidak ada sertifikat penghapusan |
| 8.1 Batas tanggung jawab | "Tanggung jawab Hening terbatas pada **12× biaya bulanan**." | Maksimum ± Rp 96 juta — jauh di bawah potensi kerugian |
| 9.2 Perubahan | "Hening dapat mengubah fitur dengan pemberitahuan 30 hari." | Perubahan tujuan pemrosesan bisa terjadi tanpa persetujuan |

### 2.2 Fakta tambahan

- DPA (perjanjian pemrosesan data) ditandatangani 2024, **sebelum** UU 27/2022 berlaku penuh.
- Tidak ada daftar subprosesor dalam lampiran kontrak.
- Tidak ada kewajiban pemberitahuan perubahan subprosesor.
- Tidak ada klausul bantuan pemenuhan hak subjek data (akses, penghapusan).
- Tidak ada klausul lokasi penyimpanan atau transfer lintas negara.

## 3. Nimbus Object Storage Pte. Ltd.

| Butir | Keterangan |
| --- | --- |
| Peran | Subprosesor Hening; menyimpan objek (lampiran, ekspor chat) |
| Lokasi | Singapura (region `ap-southeast-1`) |
| Perjanjian langsung dengan UCA | Tidak ada |
| Persetujuan tertulis UCA | Tidak ada bukti |
| Kontrol yang diklaim | Enkripsi at-rest AES-256, akses berbasis token |
| Informasi yang tersedia | Hanya halaman status publik dan satu lampiran FAQ |

**Pertanyaan terbuka:** apakah UCA pernah menerima pemberitahuan penunjukan Nimbus? Berdasarkan korespondensi 2024, Hening menyebut "penyimpanan objek pihak ketiga" tanpa nama dan lokasi.

## 4. PT Panggilan Aman

| Klausul | Isi | Konsekuensi |
| --- | --- | --- |
| Peran | Prosesor untuk perekaman dan ringkasan; **pengendali** untuk data agen sendiri | Dua peran harus dipisahkan |
| Perekaman | Semua panggilan direkam, disimpan 90 hari | Tidak ada dasar retensi tertulis dari UCA |
| Akses | Supervisor vendor dapat mendengarkan rekaman untuk "quality assurance" | Pemrosesan untuk tujuan vendor |
| Notifikasi insiden | 5 hari kerja | Terlalu lambat untuk kewajiban pemberitahuan |
| Kontinuitas | "Panggilan dialihkan ke voicemail bila sistem gangguan." | **Voicemail bukan jalur krisis yang aman** |
| SLA | 95% panggilan dijawab < 60 detik | Tidak ada sanksi |

## 5. Klinik Sehat Jiwa Arunika

- Menerima surat rujukan berisi identitas dan ringkasan klinis.
- **Bukan prosesor.** Klinik menentukan tujuan pemrosesan sendiri (terapi, rekam medis).
- Tidak ada perjanjian bersama pengendali (joint controller) dan tidak ada perjanjian transfer.
- UCA tidak tahu berapa lama klinik menyimpan salinan rujukan.

## 6. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Klausul mana yang **bertentangan langsung** dengan kewajiban UU 27/2022, dan mana yang hanya "lemah"?
- Siapa yang harus memberi persetujuan atas subprosesor, dan apa yang terjadi bila persetujuan tidak pernah ada?
- Apakah batas tanggung jawab 12× biaya bulanan dapat diterima untuk data kesehatan?
- Apa yang harus disiapkan **sebelum** 31 Desember 2026 jika kontrak tidak diperpanjang?

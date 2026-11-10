# INJECT 2 — Permintaan Penghapusan, Penahanan Bukti, dan Penghentian Vendor

**Buka dokumen ini hanya pada: Rabu, 9 Desember 2026, pukul 09.00 WIB**
**Jangan membaca lebih awal.**
**Durasi pengerjaan:** 75–90 menit, dilanjutkan sesi tabletop pimpinan pada 10–11 Desember 2026.

---

## 1. Tiga dokumen yang tiba hampir bersamaan

### 1.1 Surat permintaan penghapusan (09.02 WIB)

**Dari:** Mahasiswa A (identitas disamarkan: `MHS-2023-0471`, perempuan, 20 tahun, semester 5)
**Kepada:** Rektor; DPO; Kepala UPT-LPK

> Saya meminta seluruh data pribadi saya dihapus, termasuk:
> - formulir intake dan seluruh catatan sesi konseling sejak Oktober 2024;
> - transkrip chat dengan konselor;
> - lampiran hasil tes psikologi;
> - catatan kehadiran dan riwayat penjadwalan.
>
> Saya tidak lagi mempercayai layanan ini setelah insiden yang saya baca di media mahasiswa. Saya tidak ingin data kesehatan mental saya tersimpan di kampus atau di vendor mana pun.
>
> Mohon konfirmasi tertulis atas penghapusan paling lambat 3×24 jam sejak surat ini saya kirim.
>
> Hormat saya,
> MHS-2023-0471

**Catatan admin:** mahasiswa ini memiliki 3 sesi aktif dengan konselor Rani Kusuma; status risiko sedang; ia juga anggota forum Teman Sebaya dengan 46 posting.

### 1.2 Memo penahanan bukti (09.14 WIB)

**Dari:** Kepala Biro Hukum
**Kepada:** UPT-LPK; UPT TIK; DPO
**Subjek:** Litigation hold — pengaduan etik dan ancaman gugatan

> Sehubungan dengan pengaduan yang diajukan MHS-2023-0471 kepada Komisi Etik pada 8 Desember 2026 dan pernyataan kuasa hukumnya tentang rencana gugatan ganti rugi, diminta:
> 1. **Jangan menghapus** rekam konseling yang terkait MHS-2023-0471 dan 4 mahasiswa lain yang disebut dalam pengaduan.
> 2. Amankan log, korespondensi, dan catatan akses sejak 1 September 2026.
> 3. Jangan memberi tahu pihak luar mengenai penahanan ini selain yang diperlukan.
>
> Penahanan berlaku sampai ada pencabutan tertulis.

**Catatan:** surat permintaan penghapusan dan memo ini tiba **12 menit** berjarak. Keduanya tidak saling merujuk.

### 1.3 Pemberitahuan penghentian layanan vendor (09.40 WIB)

**Dari:** Direktur PT Hening Cloud Nusantara
**Kepada:** Rektor; Biro Hukum; UPT TIK

> Kami memberitahukan bahwa Hening Cloud diakuisisi dan akan menghentikan operasi layanan pada **31 Desember 2026**. Sejak 15 Desember 2026, tim dukungan hanya menangani penutupan.
>
> Ketentuan yang berlaku:
> - ekspor data tersedia dalam format JSON proprietary, maksimum 14 hari sejak permintaan;
> - proses ekspor memerlukan keterlibatan tim teknis kami yang kapasitasnya terbatas pada Desember;
> - **pemulihan dari cadangan tidak dapat dijamin** selama proses migrasi akuisisi; perkiraan ketersediaan cadangan: 30 hari;
> - data akan dihapus 30 hari setelah ekspor, tanpa sertifikat.
>
> Kami menyesalkan ketidaknyamanan ini.

**Catatan Biro Hukum:** kontrak berakhir 31 Desember 2026 dan **tidak** memuat kewajiban perpanjangan atau masa transisi.

## 2. Fakta baru (yang belum ada di dossier maupun Inject 1)

| # | Fakta | Dampak |
| --- | --- | --- |
| F9 | Ada permintaan penghapusan dari subjek data untuk seluruh rekam | Benturan dengan kewajiban retensi dan penahanan bukti |
| F10 | Ada penahanan bukti tertulis untuk 5 mahasiswa, termasuk pemohon | Penghapusan menyeluruh tidak dapat dilakukan sekarang |
| F11 | Pemohon masih dalam perawatan aktif (risiko sedang) | Ada pertimbangan keselamatan dan keberlanjutan layanan |
| F12 | Vendor berhenti 31 Des 2026; ekspor 14 hari; 640 GB | Risiko kehilangan data dan kapasitas |
| F13 | Restore cadangan tidak dijamin ±30 hari | Asumsi RPO/RTO sebelumnya gugur |
| F14 | Penghapusan oleh vendor tanpa sertifikat | Tidak dapat dibuktikan |
| F15 | Pengaduan etik sudah diajukan dan ada ancaman gugatan | Kebutuhan bukti meningkat, bukan menurun |

## 3. Ketegangan yang harus diselesaikan

1. **Hak penghapusan vs penahanan bukti.** Keduanya memiliki dasar. Yang menentukan adalah cakupan, durasi, dan bagaimana pemohon diberi tahu tanpa mengungkap strategi hukum.
2. **Penghapusan vs keselamatan.** Menghapus seluruh rekam dapat menghilangkan informasi yang dibutuhkan konselor jika mahasiswa kembali dalam kondisi krisis.
3. **Penghapusan vs kewajiban retensi.** Beberapa jenis rekam mungkin wajib disimpan; yang lain tidak.
4. **Keluar dari vendor vs kelangsungan layanan.** Ekspor 640 GB dalam 14 hari sementara hotline dan sesi tetap berjalan.
5. **Transparansi vs kerahasiaan.** Pemberitahuan insiden tidak boleh memuat informasi yang membahayakan proses hukum, tetapi tidak boleh menyesatkan.

## 4. Keputusan yang diminta

| Kode | Keputusan | Harus memuat |
| --- | --- | --- |
| D2.1 | Tanggapan atas permintaan penghapusan | Cakupan yang dihapus, yang ditahan, dasar, tenggat, cara konfirmasi |
| D2.2 | Cakupan penahanan bukti | Rekam mana, sampai kapan, siapa yang boleh mengakses |
| D2.3 | Apakah data pemohon dipisahkan (segregated) dari layanan umum | Cara teknis dan kontrolnya |
| D2.4 | Rencana ekspor dan migrasi sebelum 31 Desember | Format, urutan prioritas, verifikasi |
| D2.5 | Rencana layanan 15 Desember–15 Januari tanpa dukungan vendor | Kanal, alat sementara, pencatatan, retensi |
| D2.6 | Komunikasi ke pemohon dan ke 214 mahasiswa terdampak | Pesan, saluran, juru bicara |
| D2.7 | Risiko sisa yang disetujui Rektor secara tertulis | Daftar + pemilik + tanggal tinjau |

## 5. Petunjuk waktu dan alur tabletop

| Waktu | Aktivitas | Peran |
| --- | --- | --- |
| 09.00–09.15 | Membaca tiga dokumen | Semua |
| 09.15–09.40 | Menyusun urutan tindakan (mana yang tidak boleh ditunda) | Analis |
| 09.40–10.20 | Menyelesaikan D2.1–D2.3 (penghapusan vs penahanan) | Penasihat privasi + hukum |
| 10.20–11.00 | Menyelesaikan D2.4–D2.5 (exit dan kontinuitas) | Pemilik layanan + TI |
| 11.00–11.30 | Menyusun pesan ke pemohon dan ke mahasiswa terdampak | Komunikasi |
| 11.30–12.00 | Menetapkan risiko sisa dan meminta persetujuan | Pimpinan (peran) |
| 10–11 Des | Sesi tabletop pimpinan 90 menit | Seluruh peran |

**Aturan:** keputusan harus dapat dijelaskan dalam 3 kalimat kepada Rektor, dan setiap keputusan harus menyebut **apa yang tidak dilakukan** beserta alasannya.

## 6. Peran yang harus diisi dalam tabletop

| Peran | Tanggung jawab dalam sesi |
| --- | --- |
| Rektor (pemilik risiko) | Menyetujui atau menolak risiko sisa |
| Kepala UPT-LPK | Menjaga keberlanjutan layanan dan keselamatan |
| DPO | Menilai kewajiban privasi dan pemberitahuan |
| Kepala Biro Hukum | Penahanan bukti, kontrak, komunikasi hukum |
| Kepala UPT TIK | Ekspor, akun, cadangan, alat sementara |
| Konselor senior | Dampak klinis dari penghapusan/pembatasan |
| Perwakilan mahasiswa | Keterbacaan dan keadilan komunikasi |

Jika anggota tim kurang, satu orang boleh memegang dua peran, tetapi **konflik kepentingan harus dinyatakan**.

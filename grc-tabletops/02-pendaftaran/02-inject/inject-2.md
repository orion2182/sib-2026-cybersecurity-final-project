# INJECT 2 — Pemulihan Dicabut, Vendor Berhenti, Tenggat Tidak Berubah

**Buka dokumen ini hanya pada: Rabu, 9 Desember 2026, pukul 09.00 WIB**
**Jangan membaca lebih awal.**
**Durasi:** 90 menit, dilanjutkan tabletop pimpinan 10–11 Desember 2026.

---

## 1. Empat dokumen yang tiba pagi ini

### 1.1 SDN — pemulihan tidak dapat dilakukan (08.12 WIB)

> Yth. Bapak/Ibu,
>
> Menindaklanjuti permohonan pemulihan tanggal 3 Desember 2026, kami sampaikan bahwa pelepasan kunci cadangan HSM memerlukan verifikasi dari kantor pusat kami di luar negeri. Verifikasi tersebut baru dapat diselesaikan pada **20 Desember 2026**.
>
> Dengan demikian, **pemulihan dari backup tidak dapat dilakukan sebelum 20 Desember 2026**. Kami menyarankan agar Bapak/Ibu menggunakan sumber data lain yang tersedia.
>
> Kami menyesalkan keterlambatan ini.

### 1.2 Bank — dana sudah didebit, tidak diposting (08.30 WIB)

> Dari rekonsiliasi 3–8 Desember, kami menemukan **640 transaksi** yang dana nasabahnya sudah didebit dari rekening mahasiswa tetapi tidak memiliki pasangan tagihan di sistem Bapak/Ibu.
>
> Koreksi dapat dilakukan melalui pengajuan per transaksi. Waktu proses 3 hari kerja per batch, maksimum 50 transaksi per batch. Kami tidak dapat melakukan koreksi massal tanpa dasar tagihan yang valid.

### 1.3 PayLoka — penghentian layanan (08.45 WIB)

> Kami memberitahukan bahwa PT PayLoka Nusantara akan menghentikan layanan pada **31 Desember 2026** karena proses restrukturisasi. Layanan tetap berjalan sampai tanggal tersebut, namun tidak ada jaminan kualitas.
>
> Kami tidak menyediakan migrasi data otomatis. Tampilan mandiri di portal tetap tersedia sampai 31 Desember 2026, sedangkan **permintaan ekspor data historis hanya dilayani sampai tanggal tersebut**. Setelah 31 Desember 2026, data tidak dapat diakses lagi.

### 1.4 Senat Akademik — tenggat tidak berubah (08.55 WIB)

> Rapat Senat 9 Desember 2026 memutuskan bahwa tenggat registrasi **tetap 11 Desember 2026 pukul 23.59**. Perpanjangan tidak dimungkinkan karena memengaruhi kalender ujian dan akreditasi.
>
> Mahasiswa yang belum menyelesaikan kewajiban pembayaran sampai tenggat akan dicatat sebagai tidak terdaftar. Koreksi setelah tanggal tersebut memerlukan keputusan Dekan per kasus.

## 2. Fakta baru

| # | Fakta | Dampak |
| --- | --- | --- |
| H1 | Pemulihan backup tidak tersedia sebelum 20 Desember | **Kemampuan restore dicabut**; data 28 Nov–3 Des tidak dapat dipulihkan dari backup |
| H2 | 640 mahasiswa didebit tanpa posting | Kewajiban finansial dan kepercayaan |
| H3 | Koreksi bank maksimum 50 transaksi per batch, 3 hari kerja | 640 transaksi = ±13 batch = ±39 hari kerja |
| H4 | PayLoka berhenti 31 Desember; riwayat hilang setelahnya | Kehilangan bukti transaksi |
| H5 | Gateway pengganti paling cepat 5 Januari 2027 | Tidak ada solusi otomatis sebelum tenggat |
| H6 | Tenggat 11 Desember tidak dapat diubah | Tekanan waktu ekstrem (2 hari) |
| H7 | Koreksi status setelah tenggat butuh keputusan Dekan per kasus | Risiko akademik bagi mahasiswa |
| H8 | Pemberitahuan insiden data manual belum diputuskan | Kewajiban mungkin sudah lewat tenggat |

## 3. Ketegangan yang harus diselesaikan

1. **Tenggat tetap vs keadilan.** Mahasiswa yang sudah membayar tetapi tidak tercatat akan kehilangan hak. Siapa yang menanggung akibatnya?
2. **Manual vs privasi.** Proses manual adalah satu-satunya jalan, tetapi saluran yang dipakai sebelumnya justru menjadi sumber insiden.
3. **Refund vs koreksi.** Mengembalikan dana lebih cepat, tetapi menambah beban bank dan risiko salah sasaran.
4. **Bukti transaksi vs penghentian vendor.** Riwayat PayLoka hilang 31 Desember; harus diekspor sebelum itu.
5. **Transparansi vs kepanikan.** Pengumuman yang salah dapat memicu penarikan massal atau keresahan.
6. **RTO/RPO baru vs janji lama.** Target lama tidak dapat dipertahankan; siapa yang mengubah dan bagaimana mengomunikasikannya?

## 4. Keputusan yang diminta

| Kode | Keputusan | Harus memuat |
| --- | --- | --- |
| D2.1 | RTO/RPO revisi untuk registrasi dan pembayaran | Angka, dasar, layanan yang tidak dijamin |
| D2.2 | Desain proses manual 9–11 Desember | Lokasi, data minimum, otorisasi, pengawasan, pemusnahan |
| D2.3 | Penanganan 640 transaksi | Urutan, bukti, komunikasi, siapa yang menanggung |
| D2.4 | Kebijakan refund/ kompensasi duplikasi | Kriteria, waktu, otorisasi |
| D2.5 | Ekspor bukti transaksi sebelum 31 Desember | Format, pemilik, verifikasi |
| D2.6 | Pemberitahuan insiden data manual | Audiens, isi, tenggat, juru bicara |
| D2.7 | Rencana kontinjensi 12 Des–7 Jan | Kanal, rekonsiliasi, sumber daya |
| D2.8 | Risiko sisa yang disetujui Direktur | Daftar, pemilik, tanggal tinjau |

## 5. Alur tabletop 10–11 Desember

| Sesi | Durasi | Fokus | Keluaran |
| --- | ---: | --- | --- |
| 1 | 20 menit | Membaca dan menyusun kronologi | Linimasa 3–9 Des |
| 2 | 25 menit | Menetapkan RTO/RPO dan cakupan manual | D2.1, D2.2 |
| 3 | 25 menit | Menyelesaikan 640 transaksi dan refund | D2.3, D2.4 |
| 4 | 20 menit | Ekspor bukti dan rencana 12 Des–7 Jan | D2.5, D2.7 |
| 5 | 20 menit | Pemberitahuan dan risiko sisa | D2.6, D2.8 |

**Peran wajib:** Direktur (pemilik risiko), WD Akademik, Kepala DAA, Kepala Biro Keuangan, Kepala UPT TIK, DPO, Kepala Layanan Mahasiswa, perwakilan mahasiswa.

## 6. Pertanyaan yang harus dijawab lisan dalam 60 detik

1. Apa satu keputusan yang tidak boleh salah hari ini?
2. Siapa yang paling dirugikan oleh keputusan itu, dan apa kompensasinya?
3. Apa yang akan Anda lakukan berbeda jika pemulihan tersedia besok?

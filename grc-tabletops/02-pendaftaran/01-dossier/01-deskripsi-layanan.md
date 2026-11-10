# 01 — Deskripsi Layanan: Registrasi dan Pembayaran

**Dokumen:** deskripsi proses dan ketergantungan
**Pemilik:** Direktorat Akademik dan Admisi (DAA)
**Versi:** 3.0, 20 Oktober 2026

---

## 1. Proses registrasi ulang (mahasiswa lama)

| Langkah | Aktivitas | Sistem | Waktu | Pemilik |
| :-: | --- | --- | --- | --- |
| 1 | Mahasiswa masuk ke SIPMA dengan NIM dan kata sandi | SIPMA, SSO | kapan saja | DAA |
| 2 | Sistem menampilkan tagihan UKT (termasuk keringanan/ beasiswa) | SIPMA, modul keuangan | kapan saja | Biro Keuangan |
| 3 | Mahasiswa memilih metode bayar (virtual account bank atau kanal PayLoka) | SIPMA, PayLoka, Bank | kapan saja | Biro Keuangan |
| 4 | Pembayaran diproses; notifikasi dikirim ke SIPMA | PayLoka webhook | < 5 menit (klaim) | PayLoka |
| 5 | Status registrasi berubah menjadi "terdaftar" | SIPMA | otomatis | DAA |
| 6 | Mahasiswa mengisi KRS | SIAKAD | 14–18 Des | DAA |
| 7 | Rekonsiliasi harian dengan file bank | Bank, spreadsheet | 06.00 | Biro Keuangan |

**Titik lemah yang diketahui staf (tetapi tidak tertulis dalam prosedur):**
- Langkah 4 bergantung pada webhook. Jika webhook gagal, status tetap "belum bayar" walaupun uang sudah masuk.
- Tidak ada mekanisme idempotensi yang terdokumentasi; pengiriman ulang notifikasi dapat membuat dua catatan pembayaran.
- Rekonsiliasi dilakukan manual di spreadsheet, bukan di sistem.

## 2. Proses pendaftaran mahasiswa baru (Gelombang 1)

| Langkah | Aktivitas | Data yang dikumpulkan |
| :-: | --- | --- |
| 1 | Pendaftaran akun | Nama, surel, nomor HP, kata sandi |
| 2 | Formulir biodata | NIK, tempat/tanggal lahir, alamat, asal sekolah, nama orang tua |
| 3 | Unggah berkas | Ijazah, rapor, foto, kartu keluarga, bukti penghasilan orang tua |
| 4 | Pilihan program studi | 2 pilihan |
| 5 | Pembayaran biaya pendaftaran | Rp 250.000 (kanal PayLoka) |
| 6 | Verifikasi berkas | Oleh 6 staf admisi |
| 7 | Pengumuman | Surel dan SMS |

**Catatan:** data penghasilan orang tua dikumpulkan untuk semua pendaftar, walaupun hanya dipakai untuk jalur beasiswa. Tidak ada penjelasan mengapa data itu diperlukan pada tahap pendaftaran.

## 3. Volume dan beban puncak

| Metrik | Nilai | Sumber |
| --- | ---: | --- |
| Mahasiswa aktif | 14.300 | SIAKAD |
| Pembayar UKT | 9.850 | Biro Keuangan |
| Transaksi puncak per hari | 2.400 | log PayLoka (Nov 2025) |
| Transaksi per jam pada puncak | 380 | log PayLoka |
| Pendaftar Gelombang 1 | 3.100 | DAA |
| Pembayaran pendaftaran | 1.250 | DAA |
| Berkas beasiswa | 380 | Biro Keuangan |
| Panggilan call center per hari | 400 (puncak) | Unit Layanan Mahasiswa |
| Nilai transaksi rata-rata | Rp 4.100.000 | Biro Keuangan |

**Beban kerja manual bila sistem mati:** diperkirakan 60 jam staf tambahan per hari (4 loket × 2 shift × 7,5 jam) untuk 2.400 transaksi. Angka ini asumsi DAA, belum pernah diukur.

## 4. Dependensi

| Dependensi | Jenis | Dampak jika gagal | Ketergantungan lain |
| --- | --- | --- | --- |
| SIPMA (aplikasi) | Inti | Registrasi berhenti | SSO, DB, PayLoka |
| Basis data SIPMA (900 GB) | Inti | Riwayat tagihan dan status hilang | NAS, MSP |
| PayLoka | Pembayaran | Tidak ada konfirmasi otomatis | Webhook, ledger |
| Bank Arunika Sejahtera | VA dan rekonsiliasi | Dana masuk tanpa status | File harian 06.00 |
| PT Sandi Data Nusantara | Backup, HSM | Tidak dapat memulihkan data | Kunci enkripsi |
| Awan Cakrawala | IaaS | Server tidak tersedia | Satu region |
| SSO kampus | Autentikasi | Semua pengguna terkunci | — |
| SMS gateway | Notifikasi | Mahasiswa tidak tahu status | — |
| Jaringan kampus | Konektivitas | Loket tidak bisa mengakses | — |

## 5. Kebutuhan layanan saat gangguan (wawancara)

> "Kami pernah punya spreadsheet manual. Tapi isinya NIK dan status beasiswa, dan diedarkan lewat WhatsApp. Sampai sekarang tidak ada aturan apa yang boleh dicatat saat manual." — Kepala Unit Layanan Mahasiswa, 23 Okt 2026

> "Kalau sistem mati sehari, kami bisa minta mahasiswa bayar di bank dan bawa bukti. Tapi mencocokkan 2.400 bukti dengan 2.400 tagihan secara manual butuh tiga hari." — Kepala Biro Keuangan, 23 Okt 2026

> "Target 4 jam itu ada di dokumen lama. Saya tidak tahu dari mana angkanya." — Kepala UPT TIK, 24 Okt 2026

## 6. Prosedur manual yang ada (tidak resmi)

| Elemen | Kondisi |
| --- | --- |
| Formulir | Tidak ada baku; memakai kertas kosong atau spreadsheet |
| Data yang dicatat | NIM, nama, jumlah bayar, nomor bukti transfer, **kadang NIK** |
| Penyimpanan | Laptop loket, flashdisk, grup WhatsApp panitia |
| Verifikasi | Dicocokkan manual dengan mutasi bank |
| Pemusnahan | "Dihapus kalau sudah selesai" |
| Akses | Seluruh panitia (40 orang, termasuk mahasiswa relawan) |

## 7. Hal yang tidak tercatat

- Daftar resmi proses bisnis dan pemiliknya.
- BIA dan RTO/RPO yang diukur.
- Prosedur manual yang disetujui dan diuji.
- Aturan privasi untuk proses manual.
- Rencana komunikasi kepada mahasiswa saat gangguan.
- Perjanjian tingkat layanan internal untuk registrasi.

## 8. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Proses mana yang **harus** berlanjut dalam 4 jam pertama, dan mana yang boleh menunggu 3 hari?
- Apa yang membuat proses manual berbahaya bagi mahasiswa, dan bagaimana menguranginya?
- Siapa yang berwenang memutuskan "registrasi tetap dianggap sah" saat sistem mati?

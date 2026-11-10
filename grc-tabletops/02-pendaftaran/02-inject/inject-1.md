# INJECT 1 — Gangguan Puncak Registrasi dan Temuan Data Manual

**Buka dokumen ini hanya pada: Kamis, 3 Desember 2026**
**Dua bagian diberikan terpisah. Jangan membaca Bagian B sebelum pukul 13.00.**
**Durasi pengerjaan:** 45 menit per bagian.

> Aturan: bagian A dan B sengaja tidak diberikan bersamaan. Sequencing adalah bagian dari penilaian.

---

# BAGIAN A — dibuka 09.30 WIB

## A.1 Catatan waktu

| Waktu | Peristiwa |
| --- | --- |
| 08.38 | Lonjakan transaksi (perkiraan 380/jam) |
| 08:40 | SIPMA mengembalikan galat 500 pada semua halaman |
| 08:44 | Tim TI menemukan volume basis data berstatus "corrupt" |
| 08:52 | Upaya restart gagal; layanan tidak dapat diakses |
| 09:05 | Upaya restore dari backup 02.00 dimulai |
| 09:20 | Restore berhenti pada 61%; checksum gagal |
| 09:25 | Ditemukan backup 29 Nov–2 Des gagal senyap ("disk penuh") |
| 09:28 | Backup terakhir yang utuh: **28 November 2026, 02.00** |

## A.2 Fakta baru

| # | Fakta | Dampak |
| --- | --- | --- |
| G1 | Basis data korup; aplikasi tidak dapat dijalankan | Registrasi daring berhenti total |
| G2 | Backup 02.00 rusak (gagal checksum 61%) | Tidak ada titik pulih untuk 3 Des |
| G3 | Backup 29 Nov–2 Des gagal senyap | Titik pulih terakhir = 28 Nov (5 hari) |
| G4 | Binlog 2 hari ikut hilang (satu array) | Transaksi 1–2 Des tidak dapat direkonstruksi dari log |
| G5 | Restore penuh 900 GB pada 28 MB/s ≈ 9,1 jam + verifikasi | Waktu pemulihan aktual harus dihitung dari angka ini |
| G6 | PayLoka melaporkan 1.900 transaksi berstatus "pending/unknown" sejak 00.00 | Risiko duplikasi dan salah tagih |
| G7 | Portal PayLoka hanya menampilkan agregat; ledger 7 hari | Rekonsiliasi per transaksi terbatas |
| G8 | Call center menerima ±400 panggilan/jam | Kapasitas 4 loket tidak memadai |
| G9 | Bank hanya menyediakan file harian 06.00 | Tidak ada data real-time |
| G10 | Tidak ada prosedur manual resmi | Setiap loket berimprovisasi |

## A.3 Potongan komunikasi vendor (apa adanya)

**PayLoka, 09.22:**
> "Kami melihat 1.900 transaksi pada rentang 00.00–08.40 dengan status belum final. Sistem kami tidak dapat memastikan status per transaksi sampai rekonsiliasi harian. Mohon jangan mengirim ulang permintaan pembayaran."

**SDN, 09.26:**
> "Pemulihan dari backup memerlukan persetujuan kantor pusat untuk pelepasan kunci HSM. Waktu proses normal 5 hari kerja. Kami sedang mengajukan eskalasi."

**Awan Cakrawala, 09.27:**
> "Snapshot harian tersedia, tetapi hanya 3 hari terakhir dan berada di region yang sama. Snapshot tidak menggantikan backup logis."

## A.4 Keputusan Bagian A

| Kode | Keputusan | Tenggat internal |
| --- | --- | --- |
| D1.1 | Apakah registrasi dilanjutkan manual? Dalam skala apa? | ... |
| D1.2 | Data minimum apa yang boleh dicatat pada proses manual? | ... |
| D1.3 | Bagaimana mencegah duplikasi pembayaran bagi 1.900 transaksi? | ... |
| D1.4 | Apa yang dikomunikasikan ke mahasiswa dalam 2 jam pertama? | ... |
| D1.5 | Apakah RTO/RPO yang dijanjikan direvisi? Menjadi berapa? | ... |
| D1.6 | Siapa yang berwenang menyatakan pembayaran "sah" saat sistem mati? | ... |

---

# BAGIAN B — dibuka 13.00 WIB

## B.1 Fakta baru

| # | Fakta | Dampak |
| --- | --- | --- |
| G11 | Sebuah tangkapan layar beredar di grup WhatsApp "Panitia Registrasi" (40 anggota, 28 di antaranya mahasiswa relawan) | Data pribadi tersebar |
| G12 | File yang tersebar: `rekap-manual-02des.xlsx`, 2.400 baris | Skala besar |
| G13 | Kolom: NIM, nama, nominal UKT, status bayar, **NIK**, **status disabilitas**, **status beasiswa** | Termasuk data spesifik |
| G14 | File dibuat 2 Des 2026 pukul 21.10 oleh staf keuangan untuk persiapan puncak | Bukan akibat gangguan |
| G15 | Salah satu relawan melaporkan ponselnya hilang pada 2 Des pukul 23.00 | Kemungkinan akses tanpa hak |
| G16 | Tidak ada catatan siapa mengunduh atau meneruskan file | Tidak dapat menentukan cakupan |
| G17 | 640 mahasiswa sudah didebit di bank tetapi status di SIPMA tidak pernah terbarui | Dana masuk tanpa pengakuan |
| G18 | DPO baru mengetahui kejadian ini pada 13.00 | Keterlambatan deteksi ±14 jam |

## B.2 Keputusan Bagian B

| Kode | Keputusan | Tenggat internal |
| --- | --- | --- |
| D1.7 | Apakah peristiwa ini merupakan kegagalan pelindungan data pribadi yang wajib diberitahukan? | ... |
| D1.8 | Siapa yang diberi tahu: 2.400 mahasiswa, hanya yang berisiko, atau pemberitahuan umum? | ... |
| D1.9 | Isi pemberitahuan dan saluran apa yang dipakai | ... |
| D1.10 | Tindakan segera terhadap file, grup, dan perangkat yang hilang | ... |
| D1.11 | Apakah proses manual dihentikan sampai ada aturan privasi? | ... |
| D1.12 | Sumber dana untuk notifikasi dan penguatan | ... |

## B.3 Petunjuk waktu (fasilitator)

| Waktu | Aktivitas | Keluaran |
| --- | --- | --- |
| 09.30–09.45 | Membaca Bagian A; menyusun urutan tindakan | Daftar 5 tindakan pertama |
| 09.45–10.15 | Menetapkan cakupan manual dan data minimum | D1.1, D1.2 |
| 10.15–10.45 | Merancang kontrol anti-duplikasi dan otorisasi | D1.3, D1.6 |
| 10.45–11.00 | Menyusun pesan 2 jam pertama | D1.4 |
| 11.00–11.15 | Merevisi RTO/RPO | D1.5 |
| 13.00–13.20 | Membaca Bagian B; menilai kewajiban pemberitahuan | D1.7 |
| 13.20–13.50 | Menentukan audiens dan isi pemberitahuan | D1.8, D1.9 |
| 13.50–14.10 | Menetapkan tindakan containment dan keputusan proses manual | D1.10, D1.11 |
| 14.10–14.30 | Menetapkan biaya dan pemilik | D1.12 |
| 4 Des 16.00 | Serahkan memo revisi 1 | Memo 2 halaman |

**Aturan:** jangan menunggu hasil forensik. Tulis apa yang belum diketahui dan siapa yang harus mengonfirmasi.

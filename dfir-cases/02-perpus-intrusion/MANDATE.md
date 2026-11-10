# Surat Penugasan Insiden - DFIR-2

**Klasifikasi paket:** SIMULASI / DATA SINTETIS
**Nomor mandat:** UCN-IR-2026-1106-02
**Penerbit (fiktif):** Kepala Pusat Teknologi Informasi, Universitas Cakrawala Nusantara (UCN)
**Penerima:** Tim DFIR eksternal (kelompok peserta DFIR-2)
**Tanggal mandat:** 6 November 2026, 10:30 WIB (UTC+07:00)
**Batas penyerahan laporan:** 18 Desember 2026, 23:59 WIB

## 1. Organisasi

Universitas Cakrawala Nusantara (UCN) adalah universitas fiktif dengan lima fakultas. Pusat Teknologi
Informasi mengelola layanan akademik, termasuk Perpustakaan Digital
`perpustakaan.ucn.test`. Seluruh host, akun, domain, dan data dalam paket ini sintetis.
Domain latihan: `ucn.test`.

Layanan yang relevan:

| Komponen | Nilai | Catatan |
| --- | --- | --- |
| Aplikasi | Perpustakaan Digital v4.8.2 (PHP) | Katalog, unggah sampul, ekspor CSV |
| Host | `web-perpus-01` | VM Linux, IP internal `10.20.4.11` |
| Alamat publik | `192.0.2.45` | NAT ke `web-perpus-01` port 443 |
| Basis data | `perpus_prod` | Log query umum **tidak** diaktifkan |
| Berkas unggahan | `/var/www/perpustakaan/public/uploads/` | Staging unggahan 2 jam |
| Ekspor | `/var/www/perpustakaan/storage/exports/` | Cache ekspor sementara |
| Pencadangan | `/var/backups/` | Cron harian 23:05 WIB |

## 2. Insiden yang dilaporkan

Pada 6 November 2026 pukul 08:03 WIB, pustakawan melaporkan bahwa beberapa
sampul buku tidak tampil dan halaman katalog sesekali memuat galat. Pemeriksaan
awal menemukan berkas tak dikenal di direktori unggahan dan lonjakan ukuran
log. Layanan tidak dimatikan; snapshot direktori diambil pada 6 November 2026
pukul 09:00 WIB dan paket dibekukan pada pukul 09:30 WIB.

## 3. Ruang lingkup mandat

**Termasuk:**

1. Host `web-perpus-01`: log akses web, log galat, log aplikasi, dan snapshot
   direktori terpilih (bukan image disk penuh).
2. Sesi jaringan yang tercatat oleh firewall untuk 5-6 November 2026.
3. Berkas yang dibuat/diubah di direktori unggahan, ekspor, dan pencadangan.
4. Audit konfigurasi aplikasi dan tiket perubahan yang terkait.
5. Data katalog dan data anggota **sebatas yang tercatat di log**; basis data
   tidak disertakan.

**Tidak termasuk (jangan diklaim):**

- Image disk/memori, dump basis data, dan isi tabel anggota.
- Host lain, layanan SIAKAD, dan jaringan fakultas.
- Uji aktif, pemindaian, atau koneksi ke alamat IP/domain dalam paket.

## 4. Batasan

- Bukti statis dan sintetis. Tidak ada layanan yang berjalan.
- Jangan mengubah berkas asli; bekerja pada salinan.
- Berkas yang disertakan sebagai ekscerpt teks tidak identik byte-per-byte
  dengan berkas asli di host. Baca `artifacts/SOURCE-TIME-AND-CONVENTIONS.md`.
- Semua timestamp asli dipertahankan; konversi ditulis pada kolom terpisah.
- Log query basis data tidak tersedia. Setiap klaim tentang isi tabel harus
  dinyatakan sebagai keterbatasan, bukan fakta.

## 5. Pertanyaan investigasi utama (ringkas)

1. Jalur masuk mana yang paling didukung bukti, dan request mana yang
   mendahului perubahan berkas?
2. Berkas dan konfigurasi mana yang berubah, dan bagaimana integritasnya
   dibuktikan?
3. Apakah ada bukti akses lanjutan, atau hanya indikasi awal? Di mana batas
   dampak yang belum dapat dipastikan?

Rincian dua belas pertanyaan ada pada `student-card.md`.

## 6. Keluaran yang diminta

Register bukti dan verifikasi hash, kronologi, matriks hipotesis, laporan
insiden, ringkasan eksekutif, dan slide. Format bukti diatur pada
`student-card.md` dan `evidence/README.md`.

## 7. Kontak (fiktif)

- Pemilik insiden: Kepala Pusat Teknologi Informasi, `pti@ucn.test`
- Koordinator teknis: `admin.perpus@ucn.test`
- Vendor aplikasi: `support@vendor-nusantara.test`

# Surat Penugasan Insiden - DFIR-1

**Klasifikasi paket:** SIMULASI / DATA SINTETIS
**Nomor mandat:** YCN-IR-2026-1103-01
**Penerbit (fiktif):** Kepala Unit Keamanan Informasi, Yayasan Cendekia Nusantara (YCN)
**Penerima:** Tim DFIR eksternal (kelompok peserta DFIR-1)
**Tanggal mandat:** 3 November 2026, 11:00 WIB (UTC+07:00)
**Batas penyerahan laporan:** 18 Desember 2026, 23:59 WIB

## 1. Organisasi

Yayasan Cendekia Nusantara (YCN) adalah yayasan pendidikan fiktif yang mengelola tiga kampus di Jawa.
Seluruh sistem, akun, host, alamat IP, dan domain dalam paket ini sintetis.
Domain operasional yang dipakai dalam latihan: `cendekia-nusantara.test`. Tidak ada sistem
nyata, kredensial nyata, atau data pribadi nyata di dalam paket.

Layanan yang relevan:

| Layanan | Nama internal | Keterangan |
| --- | --- | --- |
| SSO kampus | GerbangID, tenant `ycn-prod` | Login tunggal untuk surel, SIAKAD, dan berbagi berkas |
| Surel | MailGate + Exchange-like `mail.cendekia-nusantara.test` | Gateway mencatat metadata pesan, bukan isi |
| Berbagi berkas | `drive.cendekia-nusantara.test` | Tidak termasuk cakupan mandat ini |
| Perangkat staf | `WS-AKD-014` | Laptop Windows milik Staf Direktorat Akademik |

## 2. Insiden yang dilaporkan

Pada 3 November 2026 pukul 09:38 WIB, seorang staf Direktorat Akademik
melaporkan ke meja bantuan bahwa ia menerima notifikasi masuk yang tidak ia
kenali, lalu tidak dapat mengakses surel. Tim TI menonaktifkan akun pada
pukul 09:44 WIB dan melakukan reset kredensial. Manajemen meminta analisis
independen atas paket bukti yang telah dibekukan (frozen) pada
3 November 2026 pukul 14:00 WIB.

> Catatan provenance: tiket meja bantuan diekspor terpisah pada
> 4 November 2026 pukul 09:00 WIB dan ditambahkan ke paket. Berkas lain
> dibekukan 3 November 2026 pukul 14:00 WIB.

## 3. Ruang lingkup mandat

**Termasuk:**

1. Akun `nadia.permata@cendekia-nusantara.test` (ID `USR-10442`) dan sesi SSO yang terkait.
2. Kotak surat pribadi akun tersebut dan kotak surat bersama
   `keuangan@cendekia-nusantara.test` yang dapat diakses akun itu.
3. Host `WS-AKD-014` dan riwayat peramban/EDR-nya pada 2-4 November 2026.
4. Metadata gateway surel untuk periode 20 Oktober - 4 November 2026.
5. Tiket meja bantuan yang terkait insiden ini.

**Tidak termasuk (jangan diklaim):**

- Host lain, akun lain, dan sistem SIAKAD/keuangan di luar kotak surat bersama.
- Isi berkas di `drive.cendekia-nusantara.test` dan perangkat seluler pribadi staf.
- Uji aktif terhadap infrastruktur mana pun. Paket ini statis.

## 4. Batasan

- Bukti bersifat **statis dan sintetis**. Jangan memindai, menghubungi, atau
  membuka alamat IP/domain yang tercantum. Tidak ada layanan yang berjalan.
- Jangan mengubah berkas asli. Bekerja pada salinan; asli tetap baca-saja.
- Jangan menambahkan data dari luar paket. Setiap klaim harus menunjuk
  berkas dan ID rekaman di dalam paket.
- Setiap timestamp asli harus dipertahankan apa adanya. Konversi zona waktu
  ditulis pada kolom terpisah.
- Tidak ada akses ke penyedia identitas, gateway, atau EDR secara langsung;
  hanya ekspor yang tersedia di paket.

## 5. Pertanyaan investigasi utama (ringkas)

1. Kapan akses tidak sah dimulai dan bukti mana yang menetapkannya?
2. Akun dan aset mana yang benar-benar terdampak, dan mana yang belum terbukti?
3. Tindakan pengamanan dan pemulihan apa yang menjaga bukti sekaligus
   memulihkan layanan?

Rincian dua belas pertanyaan ada pada `student-card.md`.

## 6. Keluaran yang diminta

Register bukti dan verifikasi hash, kronologi, matriks hipotesis, laporan
insiden, ringkasan eksekutif, dan slide. Format bukti diatur pada
`student-card.md` dan `evidence/README.md`.

## 7. Kontak (fiktif)

- Pemilik insiden: Kepala Unit Keamanan Informasi, `keamanan@cendekia-nusantara.test`
- Koordinator teknis: `budi.hartono@cendekia-nusantara.test`
- Jam kerja mandat: 08:00-17:00 WIB, Senin-Jumat

> Paket ini adalah alat latihan. Jangan menganggap temuan di sini sebagai
> penilaian atas sistem nyata mana pun.

# Surat Penugasan Insiden - DFIR-3

**Klasifikasi paket:** SIMULASI / DATA SINTETIS
**Nomor mandat:** YADB-IR-2026-1104-03
**Penerbit (fiktif):** Kepala Tata Kelola Data, Yayasan Arsip Digital Bahari (YADB)
**Penerima:** Tim DFIR eksternal (kelompok peserta DFIR-3)
**Tanggal mandat:** 4 November 2026, 16:00 WIB (UTC+07:00)
**Batas penyerahan laporan:** 18 Desember 2026, 23:59 WIB

## 1. Organisasi

Yayasan Arsip Digital Bahari (YADB) adalah yayasan fiktif yang mengelola arsip digital lembaga pendidikan.
Akun penyedia awan fiktif **NimbusCloud** bernomor `400000000001` dengan region
`ap-southeast-9`. Seluruh identitas, kunci akses, bucket, objek, dan peristiwa
audit dalam paket ini sintetis. Tidak ada akun awan nyata yang dapat diakses.

Lingkungan yang relevan:

| Komponen | Nilai | Catatan |
| --- | --- | --- |
| Akun | `400000000001` | Lingkungan produksi |
| Identitas layanan | `svc-reporting` | Menjalankan laporan bulanan |
| Identitas layanan | `svc-backup` | Rotasi pencadangan |
| Identitas layanan | `svc-analytics` | Membaca aset publik |
| Bucket utama | `arsip-laporan-prod` | Arsip laporan, akses terbatas |
| Bucket publik | `arsip-publik` | Aset situs, dapat dibaca publik |
| Bucket cadangan | `arsip-backup-prod` | Rotasi 30 hari |
| Audit | `NimbusCloud Audit Trail` | Retensi ekspor 35 hari |

## 2. Insiden yang dilaporkan

Pada 4 November 2026 pukul 14:20 WIB, tim keamanan menerima pemberitahuan
otomatis tentang lonjakan `GetObject` pada bucket `arsip-laporan-prod` dari alamat IP
di luar rentang organisasi. Pemeriksaan awal menunjukkan kemungkinan
penyalahgunaan kredensial identitas layanan; penyebab dan cakupannya belum
dipastikan. Kunci dinonaktifkan pada pukul 15:44 WIB. Paket audit diekspor
dan dibekukan pada
pukul 16:00 WIB.

## 3. Ruang lingkup mandat

**Termasuk:**

1. Peristiwa audit NimbusCloud untuk 31 Oktober - 6 November 2026 (UTC).
2. Snapshot kebijakan IAM sebelum dan sesudah perubahan 2 November 2026.
3. Inventaris identitas, kunci akses, dan status kunci.
4. Daftar objek dummy di bucket terdampak.
5. Catatan perubahan izin dan tiket perubahan terkait.
6. Ringkasan transfer data per jam (agregat).

**Tidak termasuk (jangan diklaim):**

- Isi objek (semua objek adalah dummy dan tidak disertakan).
- Akun awan lain, lingkungan pengembangan, dan penyedia identitas kampus.
- Uji aktif, pemanggilan API, atau koneksi ke endpoint mana pun.
- Kunci rahasia (`secret access key`) tidak disertakan dalam paket.

## 4. Batasan

- Bukti statis dan sintetis. Tidak ada API yang dapat dipanggil.
- Identifier kunci akses bersifat contoh dan tidak valid.
- Retensi audit terbatas; periode sebelum 1 Oktober 2026 tidak tersedia.
- Agregat transfer data memiliki satu bucket jam yang hilang; lihat
  `artifacts/SOURCE-TIME-AND-CONVENTIONS.md`.
- Semua timestamp audit dalam UTC; tiket dan catatan perubahan dalam WIB.

## 5. Pertanyaan investigasi utama (ringkas)

1. Perubahan izin apa yang mendahului akses objek, dan siapa yang
   menyetujuinya?
2. Panggilan audit mana yang menunjukkan objek dummy benar-benar dibaca atau
   diubah, dan mana yang gagal?
3. Identitas dan rentang waktu mana yang dapat dibuktikan, serta data dummy
   apa yang mungkin terpapar?

Rincian dua belas pertanyaan ada pada `student-card.md`.

## 6. Keluaran yang diminta

Register bukti dan verifikasi hash, kronologi, matriks hipotesis, laporan
insiden, ringkasan eksekutif, dan slide. Format bukti diatur pada
`student-card.md` dan `evidence/README.md`.

## 7. Kontak (fiktif)

- Pemilik insiden: Kepala Tata Kelola Data, `tata.kelola@arsipbahari.test`
- Koordinator teknis: `dewi.analis@arsipbahari.test`
- Pemilik aplikasi: `tim.reporting@arsipbahari.test`

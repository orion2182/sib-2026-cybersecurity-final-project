# Baseline Aktivitas Normal

Baseline menggambarkan pola layanan sebelum 5 November 2026. Gunakan untuk
membandingkan volume, komposisi route, dan ukuran ekspor, bukan untuk
menyatakan bahwa suatu request sah.

## Isi

| Berkas | Periode | Keterangan |
| --- | --- | --- |
| `access-summary-20261022_20261104.csv` | 2026-10-22 s.d. 2026-11-04 | Agregat harian log akses |
| `app-request-mix-20261104.json` | 2026-11-04 | Komposisi route dan ukuran ekspor normal |

## Cara memakai

1. Bandingkan jumlah request `PUT /api/v1/covers/upload` per hari. Baseline
   menunjukkan unggahan normal berasal dari akun admin melalui sesi web,
   bukan dari klien tanpa sesi.
2. Bandingkan ukuran ekspor katalog. Ekspor rutin berkisar 110-130 KB;
   ekspor `scope=all` tidak muncul di baseline.
3. Bandingkan distribusi 4xx. Pemindaian vendor menaikkan 404 secara tajam
   dalam jendela pendek; itu pola yang berbeda dari eksploitasi.

## Batas

- Baseline hanya 14 hari dan hanya ringkasan, bukan log mentah.
- Baseline tidak memuat data 5 November 2026 sehingga lonjakan hari itu harus
  dibandingkan dengan hari-hari sebelumnya.
- Tidak ada baseline body request; ukuran unggahan normal diambil dari
  agregat.

# Baseline Aktivitas Normal

Baseline menjelaskan pola normal agar tim dapat membedakan penggunaan sah
dan tidak sah. Baseline **tidak** membuktikan bahwa suatu panggilan sah.

## Isi

| Berkas | Periode | Keterangan |
| --- | --- | --- |
| `audit-baseline-20261001_20261031.jsonl` | 2026-10-01 s.d. 2026-10-31 | Sampel pola bulanan per identitas |
| `usage-summary-svc-reporting.csv` | 2026-10-01 s.d. 2026-10-31 | Agregat harian svc-reporting |

## Cara memakai

1. Untuk `svc-reporting`, catat: alamat IP sumber, jam, prefix objek,
   jumlah `GetObject` per sesi, dan ada/tidaknya panggilan tulis.
2. Bandingkan dengan sesi 3-4 November 2026. Perhatikan kombinasi alamat IP,
   user agent, dan cakupan prefix.
3. Untuk `svc-backup`, perhatikan bahwa `DeleteObject` memang terjadi setiap
   hari pukul 03:00Z sebagai bagian retensi.
4. Untuk `svc-analytics`, perhatikan bahwa akses dari `203.0.113.20` adalah
   pola normal aset publik, bukan akses ke bucket laporan.

## Batas

- Baseline hanya 31 hari dan hanya sampel, bukan seluruh peristiwa.
- Retensi ekspor 35 hari; periode sebelum 1 Oktober 2026 tidak tersedia.
- Baseline tidak memuat nilai token atau isi objek.

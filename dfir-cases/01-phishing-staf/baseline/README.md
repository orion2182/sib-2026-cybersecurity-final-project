# Baseline Aktivitas Normal

Baseline disediakan agar tim dapat mengatakan "menyimpang", bukan sekadar
"tampak aneh". Baseline **bukan** bukti bahwa suatu peristiwa sah; baseline
hanya menggambarkan pola pembanding.

## Isi

| Berkas | Periode | Keterangan |
| --- | --- | --- |
| `idp-signin-baseline-20261020_20261102.jsonl` | 2026-10-20 s.d. 2026-11-02 | Sign-in SSO akun terkait dan tiga rekan satu unit |
| `mailgateway-summary-baseline-20261020_20261102.csv` | 2026-10-20 s.d. 2026-11-02 | Agregat harian gateway |

## Cara memakai

1. Filter baseline untuk akun yang sama, lalu bandingkan: alamat IP sumber,
   `device_id`, `device_trust`, metode autentikasi, jam (UTC), hasil, dan
   `geo`.
2. Hitung ambang sederhana, misalnya jumlah percobaan gagal per akun per jam.
3. Untuk gateway, bandingkan volume dan verdict harian. Lonjakan satu pesan
   `dmarc=none` dari domain baru mungkin tidak terlihat pada agregat; itu
   sebabnya metadata per pesan juga disediakan.

## Batas baseline

- Hanya 14 hari dan empat akun. Jangan menggeneralisasi ke seluruh organisasi.
- Baseline tidak memuat jam di luar hari kerja untuk akun ini, sehingga
  aktivitas malam tidak otomatis berarti jahat.
- Tidak ada data perangkat seluler; sign-in dari perangkat tak terdaftar
  tidak dapat dibandingkan dengan pola perangkat seluler.

# Zona Waktu, Konvensi ID, dan Batas Artefak

## 1. Zona waktu sumber

| Artefak | Zona waktu sumber | Format | Catatan |
| --- | --- | --- | --- |
| `web/access.log` | WIB (UTC+07:00) | Apache `dd/Mon/yyyy:HH:mm:ss +0700` | Jam host |
| `web/error.log` | WIB (UTC+07:00) | `dd-Mon-yyyy HH:mm:ss +0700` | Jam host |
| `web/app.log` | WIB (UTC+07:00) | ISO 8601 `+07:00` | Jam host |
| `net/firewall-sessions.csv` | UTC | ISO 8601 `Z` | Jam firewall |
| Snapshot direktori | WIB (UTC+07:00) | ISO 8601 `+07:00` | mtime berkas |
| Audit konfigurasi | WIB (UTC+07:00) | ISO 8601 `+07:00` | Waktu berlaku perubahan |
| Tiket | WIB (UTC+07:00) | ISO 8601 `+07:00` | Jam sistem tiket |
| Baseline | WIB (UTC+07:00) | ISO 8601 `+07:00` | Agregat |

Konversi: WIB = UTC+07:00, tanpa daylight saving time. Firewall memakai UTC,
sehingga satu request yang sama muncul 7 jam lebih awal di firewall.

## 2. Konvensi ID

| Awalan | Arti | Muncul di |
| --- | --- | --- |
| `REQ-YYYYMMDD-NNNN` | ID request aplikasi | `access.log`, `app.log`, `error.log` |
| `FS-YYYYMMDD-NNNN` | ID sesi firewall | `firewall-sessions.csv` |
| `CHG-YYYY-NNNN` | Tiket perubahan | tiket, audit konfigurasi |
| `INC-YYYYMMDD-NNN` | Tiket insiden | tiket, laporan |
| `SNAP-...` | ID snapshot | header snapshot |

`rid` pada `access.log` sama dengan `request_id` pada `app.log`. Nama host,
path, dan alamat IP konsisten antar artefak.

Alamat IP publik berasal dari rentang dokumentasi RFC 5737:
`192.0.2.0/24`, `198.51.100.0/24`, `203.0.113.0/24`. Domain berakhiran `.test`.

## 3. Batas integritas (penting)

- Berkas di `artifacts/fs/uploads/` adalah **ekscerpt teks yang disanitasi**,
  bukan byte asli dari host. Hash di manifest adalah hash ekscerpt.
- Kolom `sha256_original` pada snapshot adalah nilai yang **direkam saat
  akuisisi** dan tidak dapat dihitung ulang dari paket.
- Beberapa berkas tercatat di snapshot tetapi tidak disertakan (mis. arsip
  pencadangan 146 MB). Ketidaksesuaian ini disengaja dan harus dinyatakan
  dalam register bukti.

## 4. Batas lain

- Log query basis data tidak diaktifkan; tidak ada bukti tingkat baris.
- `access.log` tidak mencatat body request maupun body respons.
- `app.log` mencatat metadata dan jumlah baris, bukan isi data.
- Snapshot hanya mencakup direktori terpilih dan hanya dua titik waktu.
- Tidak ada image disk/memori.

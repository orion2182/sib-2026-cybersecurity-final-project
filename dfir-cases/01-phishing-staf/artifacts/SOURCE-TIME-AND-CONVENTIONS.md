# Zona Waktu, Konvensi ID, dan Batas Artefak

## 1. Zona waktu sumber

| Artefak | Zona waktu sumber | Format timestamp | Catatan |
| --- | --- | --- | --- |
| Gateway surel | WIB (UTC+07:00) | `YYYY-MM-DDThh:mm:ss+07:00` | Jam peralatan gateway |
| Surel (`.eml`) | WIB (UTC+07:00) | RFC 5322 dengan offset | Header `Date` |
| SSO GerbangID | UTC | `YYYY-MM-DDThh:mm:ssZ` | Ekspor penyedia identitas |
| Audit kotak surat | UTC | `YYYY-MM-DDThh:mm:ssZ` | Ekspor audit Exchange-like |
| Riwayat peramban | WIB (UTC+07:00) | `YYYY-MM-DDThh:mm:ss+07:00` | Jam host |
| EDR | WIB (UTC+07:00) | `YYYY-MM-DDThh:mm:ss+07:00` | Jam host, disinkronkan NTP |
| Meja bantuan | WIB (UTC+07:00) | `YYYY-MM-DDThh:mm:ss+07:00` | Jam sistem tiket |
| Baseline sign-in | UTC | `YYYY-MM-DDThh:mm:ssZ` | Ekspor penyedia identitas |

WIB tidak mengenal daylight saving time. Konversi WIB -> UTC adalah
`kurangi 7 jam`; UTC -> WIB adalah `tambah 7 jam`.

**Peringatan:** dua artefak dengan peristiwa yang sama dapat menunjukkan jam
yang berbeda 7 jam. Itu bukan kontradiksi, melainkan perbedaan zona waktu
sumber. Jangan menormalkan timestamp di berkas asli.

## 2. Konvensi ID

| Awalan | Arti | Muncul di |
| --- | --- | --- |
| `MSG-YYYYMMDD-NNNN` | ID pesan internal gateway | gateway, tiket |
| `RFC-<...>` | `Message-ID` RFC 5322 | `.eml`, gateway |
| `IDP-YYYYMMDD-NNNN` | ID peristiwa sign-in | log sign-in, tiket |
| `SID-<uuid>` | ID sesi SSO | log sign-in, audit kotak surat |
| `MBOX-YYYYMMDD-NNNN` | ID rekaman audit kotak surat | audit kotak surat |
| `EDR-YYYYMMDD-NNNN` | ID peristiwa EDR | EDR |
| `VIS-<n>` | ID kunjungan peramban | riwayat peramban |
| `INC-YYYYMMDD-NNN` | ID tiket insiden | tiket, laporan |

Nama host, akun, dan alamat IP konsisten antar artefak. Alamat IP publik
berasal dari rentang dokumentasi (RFC 5737): `192.0.2.0/24`,
`198.51.100.0/24`, `203.0.113.0/24`. Semua domain berakhiran `.test`.

## 3. Batas yang diketahui

- Isi pesan hanya tersedia untuk pesan yang disertakan sebagai `.eml`.
  Gateway menyimpan metadata, bukan isi.
- Ekspor gateway mencakup 2-4 November 2026, tetapi segmen
  `2026-11-03 09:16:00-09:20:07 WIB` hilang saat rotasi log dan tidak dapat
  direkonstruksi. Rekaman pada jendela itu harus dianggap tidak tersedia.
- Audit kotak surat mencatat operasi tingkat item, bukan unduhan lampiran
  per byte.
- EDR tidak merekam isi halaman web, hanya proses, DNS, dan koneksi.
- Tidak ada image memori atau disk penuh dalam paket ini.

## 4. Integritas

Hash pada `manifest-sha256.txt` dihitung atas berkas di dalam paket.
Hash yang tercatat di dalam artefak (mis. `sha256` proses EDR) adalah nilai
yang direkam saat akuisisi dan tidak dapat dihitung ulang dari paket.

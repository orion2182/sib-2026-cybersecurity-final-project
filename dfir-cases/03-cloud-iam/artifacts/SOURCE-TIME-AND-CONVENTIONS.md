# Zona Waktu, Konvensi ID, dan Batas Artefak

## 1. Zona waktu sumber

| Artefak | Zona waktu sumber | Format | Catatan |
| --- | --- | --- | --- |
| `cloud/audit-*.jsonl` | UTC | ISO 8601 `Z` | Audit Trail penyedia |
| `cloud/token-issuance-truncated.jsonl` | UTC | ISO 8601 `Z` | Layanan token |
| `cloud/data-transfer-hourly.csv` | UTC | ISO 8601 `Z` | Agregat penyedia |
| `cloud/object-inventory-dummy.csv` | UTC | ISO 8601 `Z` | Metadata objek |
| `iam/*.json` | UTC | ISO 8601 `Z` | Snapshot konfigurasi |
| `governance/*.csv` | WIB (UTC+07:00) | ISO 8601 `+07:00` | Jam sistem tiket |
| Baseline | UTC | ISO 8601 `Z` | Ekspor audit |

WIB = UTC+07:00 tanpa daylight saving time. Peristiwa yang sama akan muncul
7 jam lebih lambat bila dinyatakan dalam WIB.

## 2. Konvensi ID

| Awalan | Arti | Muncul di |
| --- | --- | --- |
| `EVT-...` | ID peristiwa audit | audit, kronologi |
| `REQ-...` | ID permintaan penyedia | audit, token |
| `AROL-...` | ID peran IAM | audit, inventaris, kebijakan |
| `AIDA-...` | ID pengguna IAM | audit, inventaris |
| `NKEY-...` | ID kunci akses internal | audit, inventaris |
| `CHG-YYYY-NNNN` | Tiket perubahan | tiket, catatan IaC |
| `ntk_...` | ID token (dipotong) | log token |

Kunci akses `AKNIMBUS7Q2EXAMPLE` adalah **contoh yang tidak valid** dan tidak dapat
dipakai di penyedia mana pun. `secret access key` tidak disertakan.

Alamat IP berasal dari rentang dokumentasi RFC 5737. Domain berakhiran `.test`.

## 3. Batas yang diketahui

- Retensi ekspor audit 35 hari; peristiwa sebelum 2026-10-01 tidak tersedia.
- `data-transfer-hourly.csv` kehilangan satu bucket jam (18:00Z, 3 November)
  karena kegagalan agregasi. Tidak ada pengganti.
- Log token hanya memuat ID token yang dipotong dan metadata; tidak memuat
  nilai token. Kolom `scopes` adalah izin efektif dari kebijakan yang berlaku,
  dan baris dengan `result=denied` berarti penerbitan token ditolak.
- Objek di bucket adalah dummy; isi objek tidak disertakan dan tidak memiliki
  data pribadi nyata.
- Snapshot kebijakan adalah dua titik waktu, bukan riwayat lengkap.

## 4. Integritas

Hash pada `manifest-sha256.txt` berlaku untuk berkas di dalam paket.
`etag_dummy` pada inventaris objek adalah nilai sintetis yang menjelaskan
objek dummy, bukan ETag penyedia nyata.

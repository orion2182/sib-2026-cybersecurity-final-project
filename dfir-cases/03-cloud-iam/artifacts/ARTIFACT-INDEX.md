# Indeks Artefak

| Berkas | Rekaman | Cakupan waktu | Sumber |
| --- | ---: | --- | --- |
| `cloud/audit-20261031_20261106.jsonl` | lihat berkas | 2026-10-31 s.d. 2026-11-06 (UTC) | Audit Trail |
| `cloud/object-inventory-dummy.csv` | 48 baris (46 dummy + 2 aset lain) | snapshot 2026-11-06 02:00Z | Metadata bucket |
| `cloud/token-issuance-truncated.jsonl` | 12 token | 2026-11-02 s.d. 2026-11-04 | Layanan token |
| `cloud/data-transfer-hourly.csv` | 9 baris | 2026-11-03 s.d. 2026-11-04 | Agregat penyedia |
| `iam/policy-svc-reporting-before.json` | 1 kebijakan | efektif 2026-06-02 | Snapshot IAM |
| `iam/policy-svc-reporting-after.json` | 2 kebijakan | efektif 2026-11-02 | Snapshot IAM |
| `iam/identity-inventory.json` | 8 identitas | snapshot 2026-11-06 | Snapshot IAM |
| `governance/iac-change-log-2026-11.csv` | 6 baris | November 2026 | Pipeline IaC |
| `governance/change-tickets-2026-11.csv` | 6 tiket | November 2026 | Meja layanan |
| `repository/reporting-tools-commit-8f21c0a.diff.txt` | 1 commit | 2026-10-28 | Repositori publik |

Catatan provenance:

- Audit diekspor dari penyedia dan dibekukan 2026-11-04 16:00 WIB.
- Snapshot IAM diambil 2026-11-06 09:00 WIB; bukan riwayat penuh.
- Diff commit diambil dari repositori publik internal yang dibuka untuk
  pemeriksaan; rahasia disanitasi.

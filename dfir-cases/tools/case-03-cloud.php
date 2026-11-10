<?php
/**
 * Case 03 - Penyalahgunaan identitas cloud simulasi (Yayasan Arsip Digital Bahari).
 * Participant-visible files only. Fictional provider "NimbusCloud".
 */

declare(strict_types=1);

require_once __DIR__ . '/lib.php';

function build_case_03(): void
{
    $c = '03-cloud-iam';
    $base = pkg($c);

    $org = 'Yayasan Arsip Digital Bahari (YADB)';
    $dom = 'arsipbahari.test';
    $acct = '400000000001';
    $region = 'ap-southeast-9';
    $bucket = 'arsip-laporan-prod';
    $attackerIp = '198.51.100.88';
    $officeIp = '192.0.2.76';
    $vmIp = '192.0.2.18';
    $cdnIp = '203.0.113.20';
    $keyId = 'AKNIMBUS7Q2EXAMPLE';
    $roleArn = 'nim:iam::' . $acct . ':role/svc-reporting';
    $roleId = 'AROL-7c31d0e2';
    $uaCli = 'nimbus-cli/2.4.1 nim-sdk-php/3.1.0';
    $uaAgent = 'nimbus-agent/1.14.2';

    // ------------------------------------------------------------------ MANDATE
    put($base . '/MANDATE.md', <<<MD
# Surat Penugasan Insiden - DFIR-3

**Klasifikasi paket:** SIMULASI / DATA SINTETIS
**Nomor mandat:** YADB-IR-2026-1104-03
**Penerbit (fiktif):** Kepala Tata Kelola Data, {$org}
**Penerima:** Tim DFIR eksternal (kelompok peserta DFIR-3)
**Tanggal mandat:** 4 November 2026, 16:00 WIB (UTC+07:00)
**Batas penyerahan laporan:** 18 Desember 2026, 23:59 WIB

## 1. Organisasi

{$org} adalah yayasan fiktif yang mengelola arsip digital lembaga pendidikan.
Akun penyedia awan fiktif **NimbusCloud** bernomor `{$acct}` dengan region
`{$region}`. Seluruh identitas, kunci akses, bucket, objek, dan peristiwa
audit dalam paket ini sintetis. Tidak ada akun awan nyata yang dapat diakses.

Lingkungan yang relevan:

| Komponen | Nilai | Catatan |
| --- | --- | --- |
| Akun | `{$acct}` | Lingkungan produksi |
| Identitas layanan | `svc-reporting` | Menjalankan laporan bulanan |
| Identitas layanan | `svc-backup` | Rotasi pencadangan |
| Identitas layanan | `svc-analytics` | Membaca aset publik |
| Bucket utama | `{$bucket}` | Arsip laporan, akses terbatas |
| Bucket publik | `arsip-publik` | Aset situs, dapat dibaca publik |
| Bucket cadangan | `arsip-backup-prod` | Rotasi 30 hari |
| Audit | `NimbusCloud Audit Trail` | Retensi ekspor 35 hari |

## 2. Insiden yang dilaporkan

Pada 4 November 2026 pukul 14:20 WIB, tim keamanan menerima pemberitahuan
otomatis tentang lonjakan `GetObject` pada bucket `{$bucket}` dari alamat IP
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

- Pemilik insiden: Kepala Tata Kelola Data, `tata.kelola@{$dom}`
- Koordinator teknis: `dewi.analis@{$dom}`
- Pemilik aplikasi: `tim.reporting@{$dom}`
MD);

    // -------------------------------------------------------------- STUDENT CARD
    put($base . '/student-card.md', <<<MD
# Kartu Peserta - DFIR-3: Penyalahgunaan Identitas Cloud

**Kasus:** identitas layanan mengakses objek di luar pola normal
**Organisasi (fiktif):** {$org}
**Paket:** `dfir-cases/{$c}/`
**Batas laporan:** 18 Desember 2026, 23:59 WIB

## Situasi

Sebuah identitas layanan (`svc-reporting`) tiba-tiba membaca banyak objek di
bucket arsip laporan dari alamat IP luar. Ada indikasi kredensial identitas
itu dipakai dari luar organisasi, tetapi sumber kebocoran belum dipastikan.
Anda harus memisahkan perubahan izin yang disengaja, penggunaan kredensial
yang tidak sah, dan aktivitas normal identitas lain; lalu menetapkan batas
dampak atas objek dummy.

## Tujuan

1. Menetapkan perubahan izin yang mendahului akses dan siapa yang
   menyetujuinya.
2. Menentukan panggilan audit mana yang benar-benar berhasil membaca atau
   mengubah objek, dan mana yang ditolak.
3. Menetapkan identitas dan rentang waktu yang dapat dibuktikan.
4. Menyatakan data dummy apa yang mungkin terpapar dan apa yang belum pasti.

## Artefak yang tersedia

| Berkas | Isi |
| --- | --- |
| `artifacts/cloud/audit-20261031_20261106.jsonl` | Audit Trail (UTC) |
| `artifacts/cloud/object-inventory-dummy.csv` | Daftar objek dummy |
| `artifacts/cloud/token-issuance-truncated.jsonl` | Penerbitan token (rahasia disanitasi) |
| `artifacts/cloud/data-transfer-hourly.csv` | Agregat transfer per jam |
| `artifacts/iam/policy-svc-reporting-before.json` | Kebijakan sebelum |
| `artifacts/iam/policy-svc-reporting-after.json` | Kebijakan sesudah |
| `artifacts/iam/identity-inventory.json` | Identitas, kunci, status |
| `artifacts/governance/iac-change-log-2026-11.csv` | Riwayat perubahan IaC |
| `artifacts/governance/change-tickets-2026-11.csv` | Tiket perubahan |
| `artifacts/repository/reporting-tools-commit-8f21c0a.diff.txt` | Diff commit publik |
| `baseline/` | Pola akses normal |
| `artifacts/SOURCE-TIME-AND-CONVENTIONS.md` | Zona waktu, ID, batas |
| `artifacts/ARTIFACT-INDEX.md` | Indeks dan provenance |

## Pertanyaan (Q1-Q12)

**Q1.** Nyatakan mandat, sistem/akun yang tercakup, dan tiga pertanyaan
investigasi yang akan Anda jawab. Sertakan batas klaim.

**Q2.** Berapa artefak yang Anda terima, berapa hash asli dan hash salinan
kerja, dan siapa memegang bukti pada tiap tahap? Tunjukkan hasil verifikasi.

**Q3.** Artefak mana yang paling relevan dan mana yang mungkin pengalih?
Jelaskan dasar prioritas dengan menunjuk `event_id` atau tiket.

**Q4.** Ajukan dua hipotesis bersaing tentang penyebab akses. Bukti apa yang
membedakan, dan mana yang Anda terima?

**Q5.** Susun lima peristiwa awal dalam urutan waktu WIB, lengkap dengan waktu
sumber, zona waktu, dan tingkat kepastian.

**Q6.** Perubahan izin apa yang mendahului akses objek? Siapa pelakunya, kapan
efektif, dan apa cakupannya?

**Q7.** Panggilan audit mana yang menunjukkan objek dummy benar-benar dibaca
atau diubah? Sebutkan `event_id`, objek, hasil, dan ukuran.

**Q8.** Identitas dan rentang waktu mana yang dapat dibuktikan? Pisahkan yang
terbukti dari yang diasumsikan.

**Q9.** Apa containment segera yang menjaga bukti, dan apa konsekuensi
operasionalnya? Urutkan tindakan.

**Q10.** Data dummy apa yang terbukti dan mungkin terpapar? Bukti tambahan apa
yang diperlukan sebelum memperluas klaim?

**Q11.** Tulis kronologi final. Sertakan sedikitnya satu alternatif yang Anda
tolak beserta alasannya.

**Q12.** Usulkan eradikasi dan pemulihan, pemilik tindakan, verifikasi setelah
pemulihan, serta dua perbaikan proses.

## Petunjuk konsep (bukan jawaban)

- Kebijakan yang terlampir dan kebijakan yang berlaku bisa berbeda; periksa
  keduanya dan waktu efektifnya.
- `ListObjects` mengungkap nama objek, `GetObject` mengungkap isi. Keduanya
  berbeda dampak.
- Kode hasil `AccessDenied` adalah bukti percobaan, bukan bukti keberhasilan.
- Identitas layanan tidak memakai MFA; kunci jangka panjang adalah risiko.
- Agregat per jam dapat memiliki celah; jangan mengisi celah dengan asumsi.
- Retensi audit membatasi klaim tentang periode sebelumnya.

## Format bukti yang diminta

| Klaim | Berkas | ID rekaman | Waktu sumber | Waktu WIB | Kepastian |
| --- | --- | --- | --- | --- | --- |

Aturan:

1. Setiap klaim menunjuk berkas **dan** ID rekaman (`event_id`, `ticket_id`,
   `key_id`, nama objek).
2. Waktu sumber ditulis persis (dengan offset/Z); kolom WIB adalah konversi.
3. Kepastian: **Tinggi**, **Sedang**, **Rendah**, dengan alasan singkat.
4. Klaim yang tidak dapat dibuktikan masuk bagian "Ketidakpastian".

## Keluaran

Register bukti + verifikasi hash, timeline, matriks hipotesis, laporan
insiden (maks. 8 halaman), ringkasan eksekutif (maks. 1 halaman), dan slide.
MD);

    // ------------------------------------------------------ SOURCE TIME / INDEX
    put($base . '/artifacts/SOURCE-TIME-AND-CONVENTIONS.md', <<<MD
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

Kunci akses `{$keyId}` adalah **contoh yang tidak valid** dan tidak dapat
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
MD);

    put($base . '/artifacts/ARTIFACT-INDEX.md', <<<MD
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
MD);

    // ---------------------------------------------------------- AUDIT EVENTS
    $ev = [];
    $n = 0;
    $mk = function (string $ts, string $type, array $o) use (&$ev, &$n, $acct, $region, $roleArn, $roleId, $keyId, $vmIp): void {
        $n++;
        $base = [
            'event_id' => sprintf('EVT-2026110%d-%04d', 0, $n),
            'ts' => $ts,
            'account' => $acct,
            'region' => $region,
            'event_type' => $type,
            'principal_arn' => $roleArn,
            'principal_id' => $roleId,
            'access_key_id' => $keyId,
            'source_ip' => $vmIp,
            'user_agent' => 'nimbus-agent/1.14.2',
        ];
        $ev[] = array_merge($base, $o);
    };

    // Baseline noise inside the audited window: other identities.
    $ev[] = ['event_id' => 'EVT-20261031-0001', 'ts' => '2026-10-31T01:00:04Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.GetCallerIdentity', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-reporting', 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => 'REQ-9c01a1', 'resource' => '', 'detail' => ['session' => 'cron-laporan-bulanan']];
    $ev[] = ['event_id' => 'EVT-20261031-0002', 'ts' => '2026-10-31T01:00:11Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.GetObject', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-reporting', 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => 'REQ-9c01a2', 'resource' => 'arsip-laporan-prod/laporan-bulanan/dummy-rekap-2026-10.csv', 'detail' => ['bytes_out' => 14210]];
    $ev[] = ['event_id' => 'EVT-20261031-0003', 'ts' => '2026-10-31T03:00:02Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.ListObjects', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-backup', 'principal_id' => 'AROL-2f90aa71', 'access_key_id' => 'AKNIMBUSBU4EXAMPLE', 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => 'REQ-9c01b1', 'resource' => 'arsip-backup-prod', 'detail' => ['keys_returned' => 128, 'prefix' => '']];
    $ev[] = ['event_id' => 'EVT-20261031-0004', 'ts' => '2026-10-31T03:00:44Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.DeleteObject', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-backup', 'principal_id' => 'AROL-2f90aa71', 'access_key_id' => 'AKNIMBUSBU4EXAMPLE', 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => 'REQ-9c01b2', 'resource' => 'arsip-backup-prod/retensi/expired-2026-09-30.tar', 'detail' => ['deleted_by' => 'retention-30d']];

    // Policy change, 2 Nov.
    $ev[] = ['event_id' => 'EVT-20261102-0005', 'ts' => '2026-11-02T07:09:31Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.AttachRolePolicy', 'principal_arn' => 'nim:iam::' . $acct . ':user/dewi.analis', 'principal_id' => 'AIDA-0a41bb93', 'access_key_id' => 'AKNIMBUSHU5EXAMPLE', 'source_ip' => $officeIp, 'user_agent' => 'nimbus-console/2026.10', 'result' => 'Success', 'request_id' => 'REQ-7d22c1', 'resource' => 'nim:iam::' . $acct . ':role/svc-reporting', 'detail' => ['policy_arn' => 'nim:iam::' . $acct . ':policy/NimbusObjectReadAll', 'policy_name' => 'NimbusObjectReadAll', 'ticket' => 'CHG-2211', 'mfa' => true]];
    $ev[] = ['event_id' => 'EVT-20261102-0006', 'ts' => '2026-11-02T07:10:02Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.GetRole', 'principal_arn' => 'nim:iam::' . $acct . ':user/dewi.analis', 'principal_id' => 'AIDA-0a41bb93', 'access_key_id' => 'AKNIMBUSHU5EXAMPLE', 'source_ip' => $officeIp, 'user_agent' => 'nimbus-console/2026.10', 'result' => 'Success', 'request_id' => 'REQ-7d22c2', 'resource' => 'nim:iam::' . $acct . ':role/svc-reporting', 'detail' => ['attached_policy_count' => 2]];

    // Normal nightly run of svc-reporting (baseline-like, inside window).
    $ev[] = ['event_id' => 'EVT-20261103-0007', 'ts' => '2026-11-03T01:00:03Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.GetCallerIdentity', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-reporting', 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => 'REQ-8e33d1', 'resource' => '', 'detail' => ['session' => 'cron-laporan-bulanan']];
    for ($i = 1; $i <= 8; $i++) {
        $ev[] = ['event_id' => sprintf('EVT-20261103-%04d', 7 + $i), 'ts' => sprintf('2026-11-03T01:00:%02dZ', 6 + $i), 'account' => $acct, 'region' => $region, 'event_type' => 'Object.GetObject', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-reporting', 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => sprintf('REQ-8e33d%d', 1 + $i), 'resource' => 'arsip-laporan-prod/laporan-bulanan/dummy-rekap-2026-10-part' . $i . '.csv', 'detail' => ['bytes_out' => 12000 + ($i * 311)]];
    }
    // svc-analytics reads public bucket from CDN origin (normal).
    $ev[] = ['event_id' => 'EVT-20261103-0016', 'ts' => '2026-11-03T05:12:20Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.GetObject', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-analytics', 'principal_id' => 'AROL-5c02ff18', 'access_key_id' => 'AKNIMBUSA67EXAMPLE', 'source_ip' => $cdnIp, 'user_agent' => 'nimbus-sdk-js/2.9.0', 'result' => 'Success', 'request_id' => 'REQ-8e33e1', 'resource' => 'arsip-publik/situs/logo-header.svg', 'detail' => ['bytes_out' => 4210]];

    // Attack session 1, 3 Nov.
    $ev[] = ['event_id' => 'EVT-20261103-0017', 'ts' => '2026-11-03T18:22:44Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.GetCallerIdentity', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Success', 'request_id' => 'REQ-b1a0c1', 'resource' => '', 'detail' => ['note' => 'first recorded use of this key from outside 192.0.2.0/24']];
    $ev[] = ['event_id' => 'EVT-20261103-0018', 'ts' => '2026-11-03T18:22:58Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.ListObjects', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Success', 'request_id' => 'REQ-b1a0c2', 'resource' => $bucket, 'detail' => ['prefix' => 'laporan-2027/', 'keys_returned' => 46, 'max_keys' => 1000]];
    $ev[] = ['event_id' => 'EVT-20261103-0019', 'ts' => '2026-11-03T18:23:02Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.HeadObject', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Success', 'request_id' => 'REQ-b1a0c3', 'resource' => $bucket . '/laporan-2027/dummy-laporan-keuangan-2027-0001.csv', 'detail' => ['content_length' => 12480]];

    // 41 successful reads, interleaved with one partial read.
    $t = new DateTimeImmutable('2026-11-03T18:23:10Z');
    $read = 0;
    $partialEventAdded = false;
    for ($i = 1; $i <= 41; $i++) {
        $ts = $t->modify('+' . (($i - 1) * 41) . ' seconds')->format('Y-m-d\TH:i:s\Z');
        $obj = sprintf('%s/laporan-2027/dummy-laporan-keuangan-2027-%04d.csv', $bucket, $i);
        $partial = ($i === 26);
        $ev[] = ['event_id' => sprintf('EVT-20261103-%04d', 19 + $i), 'ts' => $ts, 'account' => $acct, 'region' => $region, 'event_type' => 'Object.GetObject', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Success', 'http_status' => $partial ? 206 : 200, 'request_id' => sprintf('REQ-b1a1%02d', $i), 'resource' => $obj, 'detail' => array_filter(['bytes_out' => 9000 + ($i * 97), 'range' => $partial ? 'bytes=0-8191' : null, 'content_type' => 'text/csv'])];
        $read++;
        if ($partial && !$partialEventAdded) {
            $partialEventAdded = true;
        }
    }
    // Failed write / delete attempts.
    $ev[] = ['event_id' => 'EVT-20261103-0061', 'ts' => '2026-11-03T18:44:20Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.PutObject', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Failure', 'error_code' => 'AccessDenied', 'request_id' => 'REQ-b1a2c1', 'resource' => $bucket . '/laporan-2027/_staging/index.html', 'detail' => ['bytes_in' => 2210]];
    $ev[] = ['event_id' => 'EVT-20261103-0062', 'ts' => '2026-11-03T18:58:04Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.DeleteObject', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Failure', 'error_code' => 'AccessDenied', 'request_id' => 'REQ-b1a3c1', 'resource' => $bucket . '/laporan-2027/dummy-laporan-keuangan-2027-0002.csv', 'detail' => ['note' => 'read-only policy']];
    $ev[] = ['event_id' => 'EVT-20261103-0063', 'ts' => '2026-11-03T19:05:12Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.GetRole', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Failure', 'error_code' => 'AccessDenied', 'request_id' => 'REQ-b1a4c1', 'resource' => 'nim:iam::' . $acct . ':role/svc-reporting', 'detail' => ['required_permission' => 'iam:GetRole']];

    // Nightly backup (normal, 4 Nov 03:00Z).
    $ev[] = ['event_id' => 'EVT-20261104-0064', 'ts' => '2026-11-04T03:00:02Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.ListObjects', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-backup', 'principal_id' => 'AROL-2f90aa71', 'access_key_id' => 'AKNIMBUSBU4EXAMPLE', 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => 'REQ-c2b1d1', 'resource' => 'arsip-backup-prod', 'detail' => ['keys_returned' => 130, 'prefix' => '']];
    $ev[] = ['event_id' => 'EVT-20261104-0065', 'ts' => '2026-11-04T03:00:51Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.DeleteObject', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-backup', 'principal_id' => 'AROL-2f90aa71', 'access_key_id' => 'AKNIMBUSBU4EXAMPLE', 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => 'REQ-c2b1d2', 'resource' => 'arsip-backup-prod/retensi/expired-2026-10-04.tar', 'detail' => ['deleted_by' => 'retention-30d']];
    $ev[] = ['event_id' => 'EVT-20261104-0066', 'ts' => '2026-11-04T03:00:52Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.DeleteObject', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-backup', 'principal_id' => 'AROL-2f90aa71', 'access_key_id' => 'AKNIMBUSBU4EXAMPLE', 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => 'REQ-c2b1d3', 'resource' => 'arsip-backup-prod/retensi/expired-2026-10-05.tar', 'detail' => ['deleted_by' => 'retention-30d']];

    // Attack session 2, 4 Nov.
    $ev[] = ['event_id' => 'EVT-20261104-0067', 'ts' => '2026-11-04T02:10:33Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.ListObjects', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Success', 'request_id' => 'REQ-c2c0a1', 'resource' => $bucket, 'detail' => ['prefix' => 'laporan-2027/', 'keys_returned' => 46]];
    for ($i = 1; $i <= 5; $i++) {
        $ev[] = ['event_id' => sprintf('EVT-20261104-%04d', 67 + $i), 'ts' => sprintf('2026-11-04T02:11:%02dZ', ($i * 7)), 'account' => $acct, 'region' => $region, 'event_type' => 'Object.GetObject', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Success', 'request_id' => sprintf('REQ-c2c0b%d', $i), 'resource' => sprintf('%s/laporan-2027/dummy-laporan-keuangan-2027-%04d.csv', $bucket, 41 + $i), 'detail' => ['bytes_out' => 9000 + ((41 + $i) * 97)]];
    }
    $ev[] = ['event_id' => 'EVT-20261104-0074', 'ts' => '2026-11-04T02:14:50Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.PutObject', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Failure', 'error_code' => 'AccessDenied', 'request_id' => 'REQ-c2c0c1', 'resource' => $bucket . '/laporan-2027/readme.txt', 'detail' => ['bytes_in' => 1180]];

    // Containment: detach policy, disable key.
    $ev[] = ['event_id' => 'EVT-20261104-0075', 'ts' => '2026-11-04T08:40:19Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.DetachRolePolicy', 'principal_arn' => 'nim:iam::' . $acct . ':user/dewi.analis', 'principal_id' => 'AIDA-0a41bb93', 'access_key_id' => 'AKNIMBUSHU5EXAMPLE', 'source_ip' => $officeIp, 'user_agent' => 'nimbus-console/2026.10', 'result' => 'Success', 'request_id' => 'REQ-d3a1b1', 'resource' => 'nim:iam::' . $acct . ':role/svc-reporting', 'detail' => ['policy_arn' => 'nim:iam::' . $acct . ':policy/NimbusObjectReadAll', 'ticket' => 'CHG-2214', 'mfa' => true]];
    $ev[] = ['event_id' => 'EVT-20261104-0076', 'ts' => '2026-11-04T08:44:05Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.UpdateAccessKey', 'principal_arn' => 'nim:iam::' . $acct . ':user/dewi.analis', 'principal_id' => 'AIDA-0a41bb93', 'access_key_id' => 'AKNIMBUSHU5EXAMPLE', 'source_ip' => $officeIp, 'user_agent' => 'nimbus-console/2026.10', 'result' => 'Success', 'request_id' => 'REQ-d3a1b2', 'resource' => 'nim:iam::' . $acct . ':access-key/' . $keyId, 'detail' => ['status' => 'Inactive', 'reason' => 'CHG-2214']];
    $ev[] = ['event_id' => 'EVT-20261104-0077', 'ts' => '2026-11-04T09:20:31Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.GetCallerIdentity', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-reporting', 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Failure', 'error_code' => 'InvalidAccessKeyId', 'request_id' => 'REQ-d3a2c1', 'resource' => '', 'detail' => ['note' => 'retry after key disable']];
    $ev[] = ['event_id' => 'EVT-20261104-0078', 'ts' => '2026-11-04T09:21:02Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.GetObject', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $attackerIp, 'user_agent' => $uaCli, 'result' => 'Failure', 'error_code' => 'InvalidAccessKeyId', 'request_id' => 'REQ-d3a2c2', 'resource' => $bucket . '/laporan-2027/dummy-laporan-keuangan-2027-0001.csv', 'detail' => []];
    // Data owner reviews access after containment.
    $ev[] = ['event_id' => 'EVT-20261106-0079', 'ts' => '2026-11-06T01:30:12Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.ListObjects', 'principal_arn' => 'nim:iam::' . $acct . ':user/dewi.analis', 'principal_id' => 'AIDA-0a41bb93', 'access_key_id' => 'AKNIMBUSHU5EXAMPLE', 'source_ip' => $officeIp, 'user_agent' => 'nimbus-console/2026.10', 'result' => 'Success', 'request_id' => 'REQ-e4a1c1', 'resource' => $bucket, 'detail' => ['prefix' => 'laporan-2027/', 'keys_returned' => 46, 'purpose' => 'post-incident inventory']];

    usort($ev, fn($a, $b) => strcmp($a['ts'], $b['ts']));
    // Re-number after sort so event_id order matches time order.
    foreach ($ev as $i => $e) {
        $ev[$i]['event_id'] = sprintf('EVT-%s-%04d', (new DateTimeImmutable($e['ts']))->format('Ymd'), $i + 1);
    }
    $body = '';
    foreach ($ev as $r) {
        $body .= jline($r);
    }
    put($base . '/artifacts/cloud/audit-20261031_20261106.jsonl', $body);

    // -------------------------------------------------------- OBJECT INVENTORY
    $inv = csv_row(['bucket', 'key', 'size_bytes', 'last_modified', 'storage_class', 'classification', 'etag_dummy', 'note']) . "\n";
    for ($i = 1; $i <= 46; $i++) {
        $inv .= csv_row([
            $bucket,
            sprintf('laporan-2027/dummy-laporan-keuangan-2027-%04d.csv', $i),
            9000 + ($i * 97),
            sprintf('2026-10-%02dT02:00:00Z', 10 + ($i % 18)),
            'standard',
            'DUMMY',
            substr(hash('sha256', 'etag-dummy-' . $i), 0, 32),
            'Objek dummy untuk latihan; tidak memuat data nyata',
        ]) . "\n";
    }
    $inv .= csv_row(['arsip-publik', 'situs/logo-header.svg', 4210, '2026-09-14T04:20:00Z', 'standard', 'PUBLIC', substr(hash('sha256', 'etag-pub-1'), 0, 32), 'Aset publik']) . "\n";
    $inv .= csv_row(['arsip-backup-prod', 'retensi/backup-2026-11-03.tar', 2201440, '2026-11-03T03:00:44Z', 'archive', 'DUMMY', substr(hash('sha256', 'etag-bak-1'), 0, 32), 'Cadangan dummy']) . "\n";
    put($base . '/artifacts/cloud/object-inventory-dummy.csv', $inv);

    // -------------------------------------------------------------- TOKEN LOG
    $tok = [
        ['ntk_7c41a9...e7f1', '2026-11-02T07:09:35Z', 'nim:iam::' . $acct . ':user/dewi.analis', $officeIp, 3600, ['iam:AttachRolePolicy'], 'console', 'interactive'],
        ['ntk_1a02bb...9c4d', '2026-11-03T01:00:01Z', $roleArn, $vmIp, 3600, ['s3:GetObject'], 'cron-laporan-bulanan', 'service'],
        ['ntk_44de10...2a11', '2026-11-03T05:12:18Z', 'nim:iam::' . $acct . ':role/svc-analytics', $cdnIp, 900, ['s3:GetObject'], 'cdn-origin', 'service'],
        ['ntk_b1a0c1...6f02', '2026-11-03T18:22:40Z', $roleArn, $attackerIp, 3600, ['s3:GetObject', 's3:ListBucket'], 'nimbus-cli', 'access_key'],
        ['ntk_b1a1c9...7710', '2026-11-03T18:40:12Z', $roleArn, $attackerIp, 3600, ['s3:GetObject'], 'nimbus-cli', 'access_key'],
        ['ntk_b1a3d0...0c55', '2026-11-03T18:57:50Z', $roleArn, $attackerIp, 3600, ['s3:GetObject'], 'nimbus-cli', 'access_key'],
        ['ntk_c2c0a0...aa31', '2026-11-04T02:10:29Z', $roleArn, $attackerIp, 3600, ['s3:GetObject', 's3:ListBucket'], 'nimbus-cli', 'access_key'],
        ['ntk_c2c0b7...d1e9', '2026-11-04T02:12:44Z', $roleArn, $attackerIp, 3600, ['s3:GetObject'], 'nimbus-cli', 'access_key'],
        ['ntk_d3a1b1...4b07', '2026-11-04T08:40:15Z', 'nim:iam::' . $acct . ':user/dewi.analis', $officeIp, 3600, ['iam:DetachRolePolicy'], 'console', 'interactive'],
        ['ntk_d3a2c1...88fe', '2026-11-04T09:20:28Z', $roleArn, $attackerIp, 3600, [], 'nimbus-cli', 'access_key', 'denied'],
        ['ntk_e4a1c0...10ab', '2026-11-06T01:30:08Z', 'nim:iam::' . $acct . ':user/dewi.analis', $officeIp, 3600, ['s3:ListBucket'], 'console', 'interactive'],
        ['ntk_9f02de...c7a2', '2026-11-04T03:00:04Z', 'nim:iam::' . $acct . ':role/svc-backup', $vmIp, 3600, ['s3:DeleteObject'], 'cron-backup', 'service'],
    ];
    $body = '';
    foreach ($tok as $t) {
        $body .= jline([
            'token_id_truncated' => $t[0],
            'issued_at' => $t[1],
            'principal_arn' => $t[2],
            'source_ip' => $t[3],
            'ttl_seconds' => $t[4],
            'scopes' => $t[5],
            'client' => $t[6],
            'credential_type' => $t[7],
            'secret' => '[REDACTED-IN-PACKAGE]',
            'result' => $t[8] ?? 'issued',
            'note' => 'Nilai token dan secret tidak disertakan; hanya metadata.',
        ]);
    }
    put($base . '/artifacts/cloud/token-issuance-truncated.jsonl', $body);

    // ------------------------------------------------------------ TRANSFER CSV
    $tr = csv_row(['hour_start_utc', 'principal_arn', 'bucket', 'requests', 'bytes_out', 'bytes_in', 'note']) . "\n";
    $tr .= csv_row(['2026-11-03T01:00:00Z', $roleArn, $bucket, 8, 107196, 0, 'cron laporan bulanan']) . "\n";
    $tr .= csv_row(['2026-11-03T19:00:00Z', $roleArn, $bucket, 2, 0, 0, 'penolakan tulis/hapus']) . "\n";
    $tr .= csv_row(['2026-11-04T02:00:00Z', $roleArn, $bucket, 7, 66340, 1180, 'termasuk percobaan tulis']) . "\n";
    $tr .= csv_row(['2026-11-04T03:00:00Z', 'nim:iam::' . $acct . ':role/svc-backup', 'arsip-backup-prod', 3, 0, 0, 'rotasi retensi']) . "\n";
    $tr .= csv_row(['2026-11-04T08:00:00Z', 'nim:iam::' . $acct . ':user/dewi.analis', $bucket, 2, 0, 0, 'containment']) . "\n";
    $tr .= csv_row(['2026-11-06T01:00:00Z', 'nim:iam::' . $acct . ':user/dewi.analis', $bucket, 1, 0, 0, 'inventaris pasca-insiden']) . "\n";
    $tr .= "# CATATAN: bucket jam 2026-11-03T18:00:00Z tidak tersedia karena kegagalan agregasi ekspor; tidak ada nilai pengganti.\n";
    put($base . '/artifacts/cloud/data-transfer-hourly.csv', $tr);

    // ------------------------------------------------------------------ POLICIES
    $before = [
        'policy_name' => 'NimbusReportingRead',
        'policy_arn' => 'nim:iam::' . $acct . ':policy/NimbusReportingRead',
        'version' => 'v3',
        'effective_from' => '2026-06-02T01:00:00Z',
        'attached_to' => ['nim:iam::' . $acct . ':role/svc-reporting'],
        'statement' => [
            [
                'sid' => 'ReadMonthlyReports',
                'effect' => 'Allow',
                'action' => ['s3:GetObject'],
                'resource' => ['arn:nim:s3:::arsip-laporan-prod/laporan-bulanan/*'],
            ],
            [
                'sid' => 'ListMonthlyPrefix',
                'effect' => 'Allow',
                'action' => ['s3:ListBucket'],
                'resource' => ['arn:nim:s3:::arsip-laporan-prod'],
                'condition' => ['StringLike' => ['s3:prefix' => ['laporan-bulanan/*']]],
            ],
        ],
        'note' => 'Snapshot diambil dari konfigurasi yang berlaku 2026-10-31.',
    ];
    put($base . '/artifacts/iam/policy-svc-reporting-before.json', jdoc($before));

    $after = [
        'snapshot_ts' => '2026-11-06T02:00:00Z',
        'role' => $roleArn,
        'attached_policies' => [
            [
                'policy_name' => 'NimbusReportingRead',
                'policy_arn' => 'nim:iam::' . $acct . ':policy/NimbusReportingRead',
                'attached_at' => '2026-06-02T01:00:00Z',
                'attached_by' => 'system-bootstrap',
            ],
            [
                'policy_name' => 'NimbusObjectReadAll',
                'policy_arn' => 'nim:iam::' . $acct . ':policy/NimbusObjectReadAll',
                'attached_at' => '2026-11-02T07:09:31Z',
                'attached_by' => 'dewi.analis',
                'ticket' => 'CHG-2211',
                'detached_at' => '2026-11-04T08:40:19Z',
                'statement' => [
                    [
                        'sid' => 'ReadAllReports',
                        'effect' => 'Allow',
                        'action' => ['s3:GetObject'],
                        'resource' => ['arn:nim:s3:::arsip-laporan-prod/*'],
                    ],
                    [
                        'sid' => 'ListAllReports',
                        'effect' => 'Allow',
                        'action' => ['s3:ListBucket'],
                        'resource' => ['arn:nim:s3:::arsip-laporan-prod'],
                    ],
                ],
            ],
        ],
        'note' => 'Kebijakan kedua berlaku 2026-11-02 07:09:31Z sampai 2026-11-04 08:40:19Z.',
    ];
    put($base . '/artifacts/iam/policy-svc-reporting-after.json', jdoc($after));

    $ids = [
        'snapshot_ts' => '2026-11-06T02:00:00Z',
        'account' => $acct,
        'users' => [
            ['user_name' => 'dewi.analis', 'user_id' => 'AIDA-0a41bb93', 'mfa' => true, 'last_activity' => '2026-11-06T01:30:12Z', 'groups' => ['cloud-admins']],
            ['user_name' => 'tim.reporting', 'user_id' => 'AIDA-6b12cd07', 'mfa' => true, 'last_activity' => '2026-11-05T04:12:00Z', 'groups' => ['reporting-dev']],
            ['user_name' => 'audit.mutu', 'user_id' => 'AIDA-77c0ee12', 'mfa' => false, 'last_activity' => '2026-09-18T03:00:00Z', 'groups' => ['readonly-audit']],
        ],
        'roles' => [
            [
                'role_name' => 'svc-reporting',
                'role_id' => $roleId,
                'purpose' => 'Laporan bulanan otomatis',
                'trust' => 'instance-profile:vm-reporting-01',
                'mfa_required' => false,
                'access_keys' => [
                    ['key_id' => $keyId, 'key_internal_id' => 'NKEY-01', 'created_at' => '2026-06-02T00:40:00Z', 'last_used_at' => '2026-11-04T09:21:02Z', 'status' => 'Inactive', 'created_by' => 'dewi.analis'],
                ],
            ],
            [
                'role_name' => 'svc-backup',
                'role_id' => 'AROL-2f90aa71',
                'purpose' => 'Rotasi pencadangan',
                'trust' => 'instance-profile:vm-backup-01',
                'mfa_required' => false,
                'access_keys' => [
                    ['key_id' => 'AKNIMBUSBU4EXAMPLE', 'key_internal_id' => 'NKEY-02', 'created_at' => '2026-03-11T02:00:00Z', 'last_used_at' => '2026-11-06T02:00:04Z', 'status' => 'Active', 'created_by' => 'dewi.analis'],
                ],
            ],
            [
                'role_name' => 'svc-analytics',
                'role_id' => 'AROL-5c02ff18',
                'purpose' => 'Aset publik situs',
                'trust' => 'instance-profile:vm-cdn-origin',
                'mfa_required' => false,
                'access_keys' => [
                    ['key_id' => 'AKNIMBUSA67EXAMPLE', 'key_internal_id' => 'NKEY-03', 'created_at' => '2026-05-20T02:00:00Z', 'last_used_at' => '2026-11-06T00:12:44Z', 'status' => 'Active', 'created_by' => 'dewi.analis'],
                ],
            ],
        ],
        'notes' => [
            'Tidak ada secret access key dalam snapshot ini.',
            'Identitas layanan tidak mendukung MFA pada penyedia ini.',
        ],
    ];
    put($base . '/artifacts/iam/identity-inventory.json', jdoc($ids));

    // ------------------------------------------------------------- GOVERNANCE
    $iac = [
        ['IAC-2026-1102-01', '2026-11-02T07:09:28Z', '2026-11-02T14:09:28+07:00', 'attach_role_policy', 'svc-reporting', 'NimbusObjectReadAll', 'CHG-2211', 'dewi.analis', 'apply sukses'],
        ['IAC-2026-1102-02', '2026-11-02T07:09:31Z', '2026-11-02T14:09:31+07:00', 'policy_effective', 'svc-reporting', 'NimbusObjectReadAll', 'CHG-2211', 'pipeline', 'efektif di penyedia'],
        ['IAC-2026-1104-01', '2026-11-04T08:40:19Z', '2026-11-04T15:40:19+07:00', 'detach_role_policy', 'svc-reporting', 'NimbusObjectReadAll', 'CHG-2214', 'dewi.analis', 'apply sukses'],
        ['IAC-2026-1104-02', '2026-11-04T08:44:05Z', '2026-11-04T15:44:05+07:00', 'deactivate_access_key', $keyId, '-', 'CHG-2214', 'dewi.analis', 'apply sukses'],
        ['IAC-2026-1105-01', '2026-11-05T03:10:00Z', '2026-11-05T10:10:00+07:00', 'set_bucket_policy', $bucket, 'deny-non-corporate-ip', 'CHG-2215', 'dewi.analis', 'menunggu review'],
        ['IAC-2026-1106-01', '2026-11-06T01:00:00Z', '2026-11-06T08:00:00+07:00', 'create_access_key', 'svc-reporting', 'NKEY-04', 'CHG-2216', 'dewi.analis', 'kunci baru untuk rotasi'],
    ];
    $body = csv_row(['iac_id', 'ts_utc', 'ts_local', 'operation', 'target', 'parameter', 'change_ref', 'actor', 'result']) . "\n";
    foreach ($iac as $r) {
        $body .= csv_row($r) . "\n";
    }
    put($base . '/artifacts/governance/iac-change-log-2026-11.csv', $body);

    $tk = [
        ['CHG-2211', 'change', '2026-11-02T06:40:00+07:00', 'tim.reporting@' . $dom, 'Lampirkan NimbusObjectReadAll ke svc-reporting untuk migrasi laporan 2027', 'approved', 'Disetujui; berlaku 14:09 WIB; review 7 hari', '2026-11-02T14:09:31+07:00', 'dewi.analis', 'Alasan: migrasi arsip laporan 2027; bersifat sementara'],
        ['CHG-2209', 'change', '2026-11-01T10:00:00+07:00', 'dewi.analis', 'Aktifkan kebijakan retensi 30 hari arsip-backup-prod', 'approved', 'Berlaku 2026-11-01 12:00 WIB', '2026-11-01T12:00:00+07:00', 'dewi.analis', 'Rotasi otomatis 03:00Z setiap hari'],
        ['CHG-2214', 'change', '2026-11-04T15:05:00+07:00', 'tata.kelola@' . $dom, 'Containment: cabut kebijakan dan nonaktifkan kunci svc-reporting', 'approved', 'Darurat; berlaku 15:40 WIB', '2026-11-04T15:44:05+07:00', 'dewi.analis', 'Termasuk pencabutan kebijakan pada 15:40 WIB'],
        ['CHG-2215', 'change', '2026-11-05T09:30:00+07:00', 'dewi.analis', 'Batasi bucket arsip-laporan-prod ke rentang IP korporat', 'pending', 'Menunggu review keamanan', '', 'dewi.analis', 'Belum diterapkan; perlu uji dampak ke job pelaporan'],
        ['CHG-2216', 'change', '2026-11-06T07:40:00+07:00', 'dewi.analis', 'Rotasi kunci svc-reporting (kunci baru NKEY-04)', 'approved', 'Kunci baru dibuat 08:00 WIB', '2026-11-06T08:00:00+07:00', 'dewi.analis', 'Kunci lama sudah Inactive'],
        ['INC-2026-1104-002', 'incident', '2026-11-04T14:20:00+07:00', 'sistem-monitor@' . $dom, 'Lonjakan GetObject dari IP luar pada bucket arsip-laporan-prod', 'open', 'Eskalasi ke DFIR; paket dibekukan 16:00 WIB', '', 'tata.kelola', 'Ambang: 20 GetObject/jam dari luar 192.0.2.0/24'],
    ];
    $body = csv_row(['ticket_id', 'type', 'ts_created', 'requester', 'summary', 'status', 'resolution', 'ts_resolved', 'owner', 'note']) . "\n";
    foreach ($tk as $r) {
        $body .= csv_row($r) . "\n";
    }
    put($base . '/artifacts/governance/change-tickets-2026-11.csv', $body);

    // ------------------------------------------------------------- SOURCE LEAK
    put($base . '/artifacts/repository/reporting-tools-commit-8f21c0a.diff.txt', <<<TXT
commit 8f21c0a4d1e2b3f4907a1c2d3e4f5061728394a5
Author: reporting-bot <reporting-bot@{$dom}>
Date:   Wed Oct 28 09:14:02 2026 +0700
Subject: chore(config): add production environment template

diff --git a/config/prod.env b/config/prod.env
new file mode 100644
index 0000000..3f9c2a1
--- /dev/null
+++ b/config/prod.env
@@ -0,0 +1,9 @@
+# Konfigurasi produksi - JANGAN DI-COMMIT
+NIMBUS_REGION={$region}
+NIMBUS_ACCOUNT={$acct}
+NIMBUS_ACCESS_KEY_ID={$keyId}
+NIMBUS_SECRET_ACCESS_KEY=[REDACTED-IN-PACKAGE]
+NIMBUS_BUCKET={$bucket}
+REPORT_PREFIX=laporan-bulanan/
+REPORT_CRON=0 1 * * *
+LOG_LEVEL=info

Catatan paket:
- Repositori `git.{$dom}/reporting-tools` berstatus **publik** sejak
  2026-10-28 dan diakses oleh 14 akun eksternal sebelum insiden.
- Nilai `NIMBUS_SECRET_ACCESS_KEY` disanitasi saat pembuatan paket. Nilai
  aslinya tidak disertakan dan tidak dapat dipulihkan dari paket ini.
- Commit ini tidak dihapus sampai 2026-11-04 15:58 WIB.
TXT);

    // ---------------------------------------------------------------- BASELINE
    put($base . '/baseline/README.md', <<<MD
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
4. Untuk `svc-analytics`, perhatikan bahwa akses dari `{$cdnIp}` adalah
   pola normal aset publik, bukan akses ke bucket laporan.

## Batas

- Baseline hanya 31 hari dan hanya sampel, bukan seluruh peristiwa.
- Retensi ekspor 35 hari; periode sebelum 1 Oktober 2026 tidak tersedia.
- Baseline tidak memuat nilai token atau isi objek.
MD);

    $bl = [];
    $n = 0;
    for ($d = 1; $d <= 31; $d++) {
        $day = sprintf('2026-10-%02d', $d);
        $dow = (int)(new DateTimeImmutable($day))->format('N');
        if ($dow >= 6) {
            continue;
        }
        $n++;
        $bl[] = ['event_id' => sprintf('EVT-BL-%04d', $n), 'ts' => $day . 'T01:00:03Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Identity.GetCallerIdentity', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => sprintf('REQ-bl-%03d-a', $n), 'resource' => '', 'detail' => ['session' => 'cron-laporan-bulanan']];
        $bl[] = ['event_id' => sprintf('EVT-BL-%04d', $n + 500), 'ts' => $day . 'T01:00:09Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.GetObject', 'principal_arn' => $roleArn, 'principal_id' => $roleId, 'access_key_id' => $keyId, 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => sprintf('REQ-bl-%03d-b', $n), 'resource' => 'arsip-laporan-prod/laporan-bulanan/dummy-rekap-' . $day . '.csv', 'detail' => ['bytes_out' => 11000 + ($d * 211)]];
        $bl[] = ['event_id' => sprintf('EVT-BL-%04d', $n + 900), 'ts' => $day . 'T03:00:02Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.ListObjects', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-backup', 'principal_id' => 'AROL-2f90aa71', 'access_key_id' => 'AKNIMBUSBU4EXAMPLE', 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => sprintf('REQ-bl-%03d-c', $n), 'resource' => 'arsip-backup-prod', 'detail' => ['keys_returned' => 120 + $d]];
        $bl[] = ['event_id' => sprintf('EVT-BL-%04d', $n + 1200), 'ts' => $day . 'T03:00:44Z', 'account' => $acct, 'region' => $region, 'event_type' => 'Object.DeleteObject', 'principal_arn' => 'nim:iam::' . $acct . ':role/svc-backup', 'principal_id' => 'AROL-2f90aa71', 'access_key_id' => 'AKNIMBUSBU4EXAMPLE', 'source_ip' => $vmIp, 'user_agent' => $uaAgent, 'result' => 'Success', 'request_id' => sprintf('REQ-bl-%03d-d', $n), 'resource' => 'arsip-backup-prod/retensi/expired-' . $day . '.tar', 'detail' => ['deleted_by' => 'retention-30d']];
    }
    usort($bl, fn($a, $b) => strcmp($a['ts'], $b['ts']));
    $body = '';
    foreach ($bl as $r) {
        $body .= jline($r);
    }
    put($base . '/baseline/audit-baseline-20261001_20261031.jsonl', $body);

    $body = csv_row(['window_start', 'window_end', 'get_object_calls', 'list_calls', 'put_calls', 'delete_calls', 'distinct_source_ips', 'max_calls_per_hour', 'note']) . "\n";
    for ($d = 1; $d <= 31; $d++) {
        $day = sprintf('2026-10-%02d', $d);
        $dow = (int)(new DateTimeImmutable($day))->format('N');
        if ($dow >= 6) {
            continue;
        }
        $body .= csv_row([$day . 'T00:00:00Z', $day . 'T23:59:59Z', 8, 1, 0, 0, 1, 8, 'cron laporan bulanan']) . "\n";
    }
    put($base . '/baseline/usage-summary-svc-reporting.csv', $body);

    // ----------------------------------------------------------- README FILES
    put($base . '/README-mahasiswa.md', <<<MD
# Cara Membuka dan Memverifikasi Paket (Windows)

Tidak perlu Docker, Python, atau akun awan. Semua artefak adalah teks/JSON.

## 1. Salinan kerja

1. Salin folder `{$c}` ke `C:\\DFIR\\kerja\\{$c}`.
2. Simpan folder asli sebagai master baca-saja.
3. Jangan mengedit berkas master.

## 2. Verifikasi hash

Buka PowerShell di akar paket:

```powershell
\$root = (Get-Location).Path
\$n = 0; \$bad = 0
Get-Content .\\manifest-sha256.txt |
  Where-Object { \$_ -notmatch '^#' -and \$_.Trim() -ne '' } |
  ForEach-Object {
    \$p = \$_ -split '  ', 2
    \$h = (Get-FileHash -Algorithm SHA256 -LiteralPath (Join-Path \$root \$p[1])).Hash.ToLower()
    \$n++
    if (\$h -ne \$p[0]) { \$bad++; "MISMATCH: \$(\$p[1])" }
  }
"checked=\$n mismatches=\$bad"
```

Hasil benar: `mismatches=0`.

## 3. Membaca artefak

| Jenis | Cara aman |
| --- | --- |
| `.jsonl` | VS Code; satu baris = satu peristiwa |
| `.json` | VS Code; format document |
| `.csv` | Excel: Data > Dari Teks/CSV |
| `.txt` | VS Code |

Jangan memanggil endpoint API apa pun dan jangan memakai identifier kunci
dalam paket; semuanya contoh yang tidak valid.

## 4. Mencari peristiwa

```powershell
Select-String -Path .\\artifacts\\cloud\\audit-20261031_20261106.jsonl -Pattern '198\\.51\\.100\\.88'
Select-String -Path .\\artifacts\\cloud\\audit-20261031_20261106.jsonl -Pattern 'NimbusObjectReadAll'
```

## 5. Zona waktu

Audit memakai UTC; tiket dan catatan perubahan memakai WIB. Baca
`artifacts/SOURCE-TIME-AND-CONVENTIONS.md`.

## 6. Batas penting

Retensi audit 35 hari, satu bucket transfer data hilang, dan isi objek tidak
disertakan. Catat batas ini di register bukti.
MD);

    put($base . '/evidence/README.md', <<<MD
# Register dan Verifikasi Bukti

## 1. Prinsip

1. Folder paket adalah master baca-saja.
2. Analisis dilakukan pada salinan kerja.
3. Setiap perpindahan dicatat: siapa, kapan (offset), dari mana, ke mana,
   dan mengapa.
4. Hash membuktikan integritas berkas dalam paket, bukan kebenaran isi.

## 2. Verifikasi manifest

Format: `<sha256 huruf kecil><dua spasi><path relatif>`. Baris `#` komentar.

```powershell
\$root = (Get-Location).Path
\$n = 0; \$bad = 0
Get-Content .\\manifest-sha256.txt |
  Where-Object { \$_ -notmatch '^#' -and \$_.Trim() -ne '' } |
  ForEach-Object {
    \$p = \$_ -split '  ', 2
    \$h = (Get-FileHash -Algorithm SHA256 -LiteralPath (Join-Path \$root \$p[1])).Hash.ToLower()
    \$n++
    if (\$h -ne \$p[0]) { \$bad++; "MISMATCH: \$(\$p[1])" }
  }
"checked=\$n mismatches=\$bad"
```

Jika ada `MISMATCH`, hentikan analisis dan laporkan ke mentor.

## 3. Register bukti

Gunakan `evidence-register-template.csv` dengan kolom: `item_id`,
`file_path`, `sha256_original`, `acquired_at`, `received_from`, `custodian`,
`storage_location`, `sha256_working_copy`, `verification_result`, `notes`.

Untuk kasus ini, tandai juga:

- `credential_in_package`: `no` (secret tidak disertakan).
- `object_content_in_package`: `no` (hanya metadata).

## 4. Batas yang harus dinyatakan

- Retensi audit 35 hari; periode sebelumnya tidak dapat diklaim.
- Bucket transfer 2026-11-03T18:00Z hilang.
- `ListObjects` ??? `GetObject`; keduanya harus dibedakan di laporan.
- Ketiadaan rekaman bukan bukti ketiadaan peristiwa.
MD);

    $reg = csv_row(['item_id', 'file_path', 'sha256_original', 'acquired_at', 'received_from', 'custodian', 'storage_location', 'sha256_working_copy', 'verification_result', 'notes']) . "\n";
    $reg .= csv_row(['E-001', 'artifacts/cloud/audit-20261031_20261106.jsonl', '', '2026-11-20T09:00:00+07:00', 'Mentor DFIR (fiktif)', '', '', '', 'isi setelah verifikasi']) . "\n";
    put($base . '/evidence/evidence-register-template.csv', $reg);

    write_manifest($c);
}

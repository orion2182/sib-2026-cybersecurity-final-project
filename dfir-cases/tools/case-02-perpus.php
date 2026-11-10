<?php
/**
 * Case 02 - Intrusi aplikasi perpustakaan (Universitas Cakrawala Nusantara).
 * Participant-visible files only.
 */

declare(strict_types=1);

require_once __DIR__ . '/lib.php';

function apache_ts(string $iso): string
{
    return (new DateTimeImmutable($iso))->format('d/M/Y:H:i:s O');
}

function build_case_02(): void
{
    $c = '02-perpus-intrusion';
    $base = pkg($c);

    $org = 'Universitas Cakrawala Nusantara (UCN)';
    $dom = 'ucn.test';
    $appHost = 'perpustakaan.' . $dom;
    $host = 'web-perpus-01';
    $internalIp = '10.20.4.11';
    $publicIp = '192.0.2.45';
    $attacker = '203.0.113.146';
    $scanner = '198.51.100.55';
    $adminIp = '10.20.9.20';

    $uaCurl = 'curl/8.4.0';
    $uaFirefox = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:128.0) Gecko/20100101 Firefox/128.0';
    $uaChrome = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.127 Safari/537.36';
    $uaScan = 'NimbusScan/3.2 (authorized-assessment; contact=security@vendor-nusantara.test)';

    // ------------------------------------------------------------------ MANDATE
    put($base . '/MANDATE.md', <<<MD
# Surat Penugasan Insiden - DFIR-2

**Klasifikasi paket:** SIMULASI / DATA SINTETIS
**Nomor mandat:** UCN-IR-2026-1106-02
**Penerbit (fiktif):** Kepala Pusat Teknologi Informasi, {$org}
**Penerima:** Tim DFIR eksternal (kelompok peserta DFIR-2)
**Tanggal mandat:** 6 November 2026, 10:30 WIB (UTC+07:00)
**Batas penyerahan laporan:** 18 Desember 2026, 23:59 WIB

## 1. Organisasi

{$org} adalah universitas fiktif dengan lima fakultas. Pusat Teknologi
Informasi mengelola layanan akademik, termasuk Perpustakaan Digital
`{$appHost}`. Seluruh host, akun, domain, dan data dalam paket ini sintetis.
Domain latihan: `{$dom}`.

Layanan yang relevan:

| Komponen | Nilai | Catatan |
| --- | --- | --- |
| Aplikasi | Perpustakaan Digital v4.8.2 (PHP) | Katalog, unggah sampul, ekspor CSV |
| Host | `{$host}` | VM Linux, IP internal `{$internalIp}` |
| Alamat publik | `{$publicIp}` | NAT ke `{$host}` port 443 |
| Basis data | `perpus_prod` | Log query umum **tidak** diaktifkan |
| Berkas unggahan | `/var/www/perpustakaan/public/uploads/` | Staging unggahan 2 jam |
| Ekspor | `/var/www/perpustakaan/storage/exports/` | Cache ekspor sementara |
| Pencadangan | `/var/backups/` | Cron harian 23:05 WIB |

## 2. Insiden yang dilaporkan

Pada 6 November 2026 pukul 08:03 WIB, pustakawan melaporkan bahwa beberapa
sampul buku tidak tampil dan halaman katalog sesekali memuat galat. Pemeriksaan
awal menemukan berkas tak dikenal di direktori unggahan dan lonjakan ukuran
log. Layanan tidak dimatikan; snapshot direktori diambil pada 6 November 2026
pukul 09:00 WIB dan paket dibekukan pada pukul 09:30 WIB.

## 3. Ruang lingkup mandat

**Termasuk:**

1. Host `{$host}`: log akses web, log galat, log aplikasi, dan snapshot
   direktori terpilih (bukan image disk penuh).
2. Sesi jaringan yang tercatat oleh firewall untuk 5-6 November 2026.
3. Berkas yang dibuat/diubah di direktori unggahan, ekspor, dan pencadangan.
4. Audit konfigurasi aplikasi dan tiket perubahan yang terkait.
5. Data katalog dan data anggota **sebatas yang tercatat di log**; basis data
   tidak disertakan.

**Tidak termasuk (jangan diklaim):**

- Image disk/memori, dump basis data, dan isi tabel anggota.
- Host lain, layanan SIAKAD, dan jaringan fakultas.
- Uji aktif, pemindaian, atau koneksi ke alamat IP/domain dalam paket.

## 4. Batasan

- Bukti statis dan sintetis. Tidak ada layanan yang berjalan.
- Jangan mengubah berkas asli; bekerja pada salinan.
- Berkas yang disertakan sebagai ekscerpt teks tidak identik byte-per-byte
  dengan berkas asli di host. Baca `artifacts/SOURCE-TIME-AND-CONVENTIONS.md`.
- Semua timestamp asli dipertahankan; konversi ditulis pada kolom terpisah.
- Log query basis data tidak tersedia. Setiap klaim tentang isi tabel harus
  dinyatakan sebagai keterbatasan, bukan fakta.

## 5. Pertanyaan investigasi utama (ringkas)

1. Jalur masuk mana yang paling didukung bukti, dan request mana yang
   mendahului perubahan berkas?
2. Berkas dan konfigurasi mana yang berubah, dan bagaimana integritasnya
   dibuktikan?
3. Apakah ada bukti akses lanjutan, atau hanya indikasi awal? Di mana batas
   dampak yang belum dapat dipastikan?

Rincian dua belas pertanyaan ada pada `student-card.md`.

## 6. Keluaran yang diminta

Register bukti dan verifikasi hash, kronologi, matriks hipotesis, laporan
insiden, ringkasan eksekutif, dan slide. Format bukti diatur pada
`student-card.md` dan `evidence/README.md`.

## 7. Kontak (fiktif)

- Pemilik insiden: Kepala Pusat Teknologi Informasi, `pti@{$dom}`
- Koordinator teknis: `admin.perpus@{$dom}`
- Vendor aplikasi: `support@vendor-nusantara.test`
MD);

    // -------------------------------------------------------------- STUDENT CARD
    put($base . '/student-card.md', <<<MD
# Kartu Peserta - DFIR-2: Intrusi Aplikasi Perpustakaan

**Kasus:** perubahan berkas dan request HTTP mencurigakan pada layanan web
**Organisasi (fiktif):** {$org}
**Paket:** `dfir-cases/{$c}/`
**Batas laporan:** 18 Desember 2026, 23:59 WIB

## Situasi

Perpustakaan Digital kampus menampilkan galat dan kehilangan beberapa sampul
buku. Admin menemukan berkas tak dikenal di direktori unggahan. Layanan tetap
hidup; snapshot direktori dan ekspor log diambil pagi berikutnya. Anda harus
menentukan jalur masuk yang paling didukung bukti, rentang perubahan, dan
batas dampak yang belum dapat dipastikan.

## Tujuan

1. Menyusun rangkaian request dan peristiwa sistem yang mendahului perubahan
   berkas.
2. Menetapkan berkas/konfigurasi yang berubah beserta bukti integritasnya.
3. Memisahkan aktivitas vendor, cron, dan pengunjung sah dari aktivitas
   penyerang.
4. Menyatakan dengan tepat apa yang tidak dapat dibuktikan dari paket ini.

## Artefak yang tersedia

| Berkas | Isi |
| --- | --- |
| `artifacts/web/access.log` | Log akses web (combined + `rid`) |
| `artifacts/web/error.log` | Log galat PHP |
| `artifacts/web/app.log` | Log aplikasi terstruktur (JSONL) |
| `artifacts/net/firewall-sessions.csv` | Sesi jaringan terpilih |
| `artifacts/fs/snapshot-...-20261105T1900+07.csv` | Snapshot direktori sebelum |
| `artifacts/fs/snapshot-...-20261106T0900+07.csv` | Snapshot direktori sesudah |
| `artifacts/fs/uploads/` | Ekscerpt berkas yang ditemukan |
| `artifacts/config/config-audit-{$host}.csv` | Audit konfigurasi |
| `artifacts/change/change-tickets-2026-11.csv` | Tiket perubahan & insiden |
| `baseline/` | Ringkasan aktivitas normal |
| `artifacts/SOURCE-TIME-AND-CONVENTIONS.md` | Zona waktu, ID, batas |
| `artifacts/ARTIFACT-INDEX.md` | Indeks dan provenance |

## Pertanyaan (Q1-Q12)

**Q1.** Nyatakan mandat, sistem yang tercakup, dan tiga pertanyaan investigasi
yang akan Anda jawab. Sertakan batas klaim.

**Q2.** Berapa artefak yang Anda terima, berapa hash asli dan hash salinan
kerja, dan siapa memegang bukti pada tiap tahap? Tunjukkan hasil verifikasi.

**Q3.** Artefak mana yang paling relevan dan mana yang mungkin pengalih?
Jelaskan prioritas dengan menunjuk rekaman (request, sesi, atau tiket).

**Q4.** Ajukan dua hipotesis bersaing tentang jalur masuk. Bukti apa yang
membedakan, dan mana yang Anda terima?

**Q5.** Susun lima peristiwa awal dalam urutan waktu WIB, lengkap dengan waktu
sumber, zona waktu, dan tingkat kepastian.

**Q6.** Rangkaian request dan log apa yang mendahului perubahan berkas?
Tunjukkan `rid`, metode, path, status, dan waktu.

**Q7.** Berkas dan konfigurasi mana yang berubah? Sebutkan bukti integritas
(hash, ukuran, mtime) dan batasnya.

**Q8.** Apakah ada bukti akses lanjutan (ekspor, unduhan, koneksi keluar),
atau hanya indikasi awal? Bedakan yang terbukti dari yang mungkin.

**Q9.** Apa containment segera yang menjaga bukti, dan apa konsekuensi
operasionalnya? Urutkan tindakan.

**Q10.** Apa dampak yang terbukti, apa yang masih mungkin, dan bukti tambahan
apa yang diperlukan sebelum memperluas klaim?

**Q11.** Tulis kronologi final. Sertakan sedikitnya satu alternatif yang Anda
tolak beserta alasannya.

**Q12.** Usulkan eradikasi dan pemulihan, pemilik tindakan, verifikasi setelah
pemulihan, serta dua perbaikan proses.

## Petunjuk konsep (bukan jawaban)

- Korelasikan `rid` antara `access.log` dan `app.log`; jangan hanya mencocokkan
  jam.
- Ukuran respons pada log akses adalah ukuran body yang dikirim, bukan bukti
  isi data.
- Snapshot direktori menunjukkan keadaan, bukan riwayat lengkap; berkas yang
  dihapus sebelum snapshot tidak akan terlihat.
- Tiket perubahan dapat menjelaskan aktivitas yang tampak mencurigakan.
- Retensi cache dan cron dapat membuat berkas muncul/hilang tanpa aktor jahat.
- Tidak adanya log query bukan bukti tidak ada pembacaan basis data.

## Format bukti yang diminta

| Klaim | Berkas | ID rekaman | Waktu sumber | Waktu WIB | Kepastian |
| --- | --- | --- | --- | --- | --- |

Aturan:

1. Setiap klaim menunjuk berkas **dan** ID rekaman (`rid`, `session_id`,
   `audit_id`, `ticket_id`, path snapshot).
2. Waktu sumber ditulis persis (dengan offset); kolom WIB adalah konversi.
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
MD);

    put($base . '/artifacts/ARTIFACT-INDEX.md', <<<MD
# Indeks Artefak

| Berkas | Rekaman | Cakupan waktu | Sumber |
| --- | ---: | --- | --- |
| `web/access.log` | lihat berkas | 2026-11-05 18:00 s.d. 2026-11-06 09:05 WIB | Apache |
| `web/error.log` | lihat berkas | 2026-11-05 22:38 s.d. 2026-11-06 08:02 WIB | PHP |
| `web/app.log` | lihat berkas | 2026-11-05 22:31 s.d. 2026-11-06 08:41 WIB | Aplikasi |
| `net/firewall-sessions.csv` | lihat berkas | 2026-11-05 11:02Z s.d. 2026-11-06 01:20Z | Firewall |
| `fs/snapshot-{$host}-20261105T1900+07.csv` | lihat berkas | keadaan 2026-11-05 19:00 WIB | Agen host |
| `fs/snapshot-{$host}-20261106T0900+07.csv` | lihat berkas | keadaan 2026-11-06 09:00 WIB | Agen host |
| `fs/uploads/cover-2026-11-05.php.txt` | 1 ekscerpt | ditemukan 2026-11-06 08:20 WIB | Sanitasi |
| `config/config-audit-{$host}.csv` | 12 baris | 2026-10-28 s.d. 2026-11-06 | Manajemen konfigurasi |
| `change/change-tickets-2026-11.csv` | 7 tiket | November 2026 | Meja layanan |

Catatan provenance:

- Ekspor diambil dari host hidup; urutan baris mengikuti waktu penulisan log.
- Log disalin apa adanya, termasuk baris yang saling bertentangan.
- Tidak ada artefak yang diubah setelah pembekuan 2026-11-06 09:30 WIB.
MD);

    // ------------------------------------------------------- REQUEST DEFINITIONS
    $defs = [];
    $add = function (string $key, string $iso, string $ip, string $method, string $path, int $status, int $bytes, string $ua, float $rt) use (&$defs): void {
        $defs[] = ['key' => $key, 'iso' => $iso, 'ip' => $ip, 'method' => $method, 'path' => $path, 'status' => $status, 'bytes' => $bytes, 'ua' => $ua, 'rt' => $rt];
    };

    // Rutin, malam sebelumnya.
    $add('pub_catalog', '2026-11-05T18:02:11+07:00', '192.0.2.88', 'GET', '/', 200, 18422, $uaFirefox, 0.121);
    $add('pub_search', '2026-11-05T18:14:39+07:00', '192.0.2.88', 'GET', '/catalog?q=manajemen', 200, 24110, $uaFirefox, 0.208);
    $add('adm_dash', '2026-11-05T19:05:02+07:00', $adminIp, 'GET', '/admin/dashboard', 200, 31204, $uaChrome, 0.344);
    $add('pub_book', '2026-11-05T20:12:31+07:00', '192.0.2.141', 'GET', '/catalog/9786020000111', 200, 12880, $uaChrome, 0.098);
    $add('pub_css', '2026-11-05T20:31:07+07:00', '192.0.2.141', 'GET', '/assets/app.css', 200, 40122, $uaChrome, 0.012);

    // Jendela asesmen vendor terotorisasi 20:58-21:19 (CHG-2207).
    $scan = [
        ['2026-11-05T20:58:14+07:00', '/admin/config.php', 404, 512],
        ['2026-11-05T21:01:02+07:00', '/.env', 404, 512],
        ['2026-11-05T21:04:47+07:00', '/backup.zip', 404, 512],
        ['2026-11-05T21:07:19+07:00', '/phpinfo.php', 404, 512],
        ['2026-11-05T21:09:55+07:00', '/uploads/../config/database.yml', 404, 512],
        ['2026-11-05T21:12:36+07:00', '/api/v1/covers/upload', 405, 221],
        ['2026-11-05T21:15:08+07:00', '/server-status', 404, 512],
        ['2026-11-05T21:17:41+07:00', '/wp-login.php', 404, 512],
        ['2026-11-05T21:18:50+07:00', '/catalog?q=%27%20OR%201%3D1--', 200, 18220],
        ['2026-11-05T21:19:41+07:00', '/api/v1/members/export', 403, 198],
    ];
    foreach ($scan as $i => $s) {
        $add('scan_' . $i, $s[0], $scanner, 'GET', $s[1], $s[2], $s[3], $uaScan, 0.031);
    }

    $add('adm_covers', '2026-11-05T21:52:18+07:00', $adminIp, 'GET', '/admin/covers', 200, 48210, $uaChrome, 0.411);
    $add('pub_stat', '2026-11-05T21:58:03+07:00', '192.0.2.77', 'GET', '/catalog?q=statistika', 200, 19920, $uaFirefox, 0.188);

    // Rekon dan eksploitasi.
    $add('atk_recon', '2026-11-05T22:31:12+07:00', $attacker, 'GET', '/catalog?q=test', 200, 18740, $uaCurl, 0.152);
    $add('atk_list', '2026-11-05T22:32:40+07:00', $attacker, 'GET', '/api/v1/covers?limit=500', 200, 96044, $uaCurl, 0.301);
    $add('atk_up_jpg', '2026-11-05T22:34:20+07:00', $attacker, 'PUT', '/api/v1/covers/upload', 201, 412, $uaCurl, 0.288);
    $add('atk_options', '2026-11-05T22:35:02+07:00', $attacker, 'OPTIONS', '/api/v1/covers/upload', 200, 184, $uaCurl, 0.004);
    $add('atk_getupload', '2026-11-05T22:36:44+07:00', $attacker, 'GET', '/api/v1/covers/upload', 405, 221, $uaCurl, 0.002);
    $add('atk_up_php', '2026-11-05T22:37:58+07:00', $attacker, 'PUT', '/api/v1/covers/upload', 201, 418, $uaCurl, 0.274);
    $add('atk_getshell', '2026-11-05T22:38:12+07:00', $attacker, 'GET', '/uploads/cover-2026-11-05.php', 200, 34, $uaCurl, 0.007);
    $add('atk_shell1', '2026-11-05T22:39:41+07:00', $attacker, 'POST', '/uploads/cover-2026-11-05.php', 200, 34, $uaCurl, 0.011);
    $add('atk_shell2', '2026-11-05T22:40:55+07:00', $attacker, 'POST', '/uploads/cover-2026-11-05.php', 200, 34, $uaCurl, 0.009);
    $add('atk_export1', '2026-11-05T22:44:02+07:00', $attacker, 'GET', '/catalog/export?format=csv&scope=all', 200, 4312990, $uaCurl, 12.884);
    $add('atk_members', '2026-11-05T22:46:10+07:00', $attacker, 'GET', '/api/v1/members/export', 403, 198, $uaCurl, 0.014);
    $add('atk_export2', '2026-11-05T22:49:33+07:00', $attacker, 'GET', '/catalog/export?format=csv&scope=all&offset=5000', 200, 2140880, $uaCurl, 7.402);
    $add('atk_root', '2026-11-05T22:53:21+07:00', $attacker, 'GET', '/', 200, 18422, $uaCurl, 0.120);

    $add('cron_health', '2026-11-05T23:05:04+07:00', '127.0.0.1', 'GET', '/healthz', 200, 41, 'curl/7.81.0', 0.008);
    $add('pub_fisika', '2026-11-05T23:41:19+07:00', '192.0.2.201', 'GET', '/catalog?q=fisika', 200, 20110, $uaFirefox, 0.172);

    // Pagi berikutnya.
    $add('adm_covers2', '2026-11-06T07:58:52+07:00', $adminIp, 'GET', '/admin/covers', 200, 47990, $uaChrome, 0.402);
    $add('adm_covererr', '2026-11-06T08:02:14+07:00', $adminIp, 'GET', '/admin/covers?page=2', 500, 1120, $uaChrome, 0.884);
    $add('adm_logs', '2026-11-06T08:03:40+07:00', $adminIp, 'GET', '/admin/logs', 200, 61200, $uaChrome, 0.512);
    $add('adm_getshell', '2026-11-06T08:20:09+07:00', $adminIp, 'GET', '/uploads/cover-2026-11-05.php', 200, 34, $uaChrome, 0.006);
    $add('adm_maint', '2026-11-06T08:41:27+07:00', $adminIp, 'POST', '/admin/maintenance', 200, 880, $uaChrome, 0.233);
    $add('pub_catalog2', '2026-11-06T09:05:11+07:00', '192.0.2.60', 'GET', '/catalog', 200, 18220, $uaFirefox, 0.131);

    // Urutkan kronologis, lalu beri rid per tanggal.
    usort($defs, fn($a, $b) => strcmp($a['iso'], $b['iso']));
    $seq = [];
    $R = [];
    foreach ($defs as $i => $d) {
        $day = substr($d['iso'], 0, 10) === '2026-11-06' ? '20261106' : '20261105';
        $seq[$day] = ($seq[$day] ?? 0) + 1;
        $rid = sprintf('REQ-%s-%04d', $day, $seq[$day]);
        $defs[$i]['rid'] = $rid;
        $R[$d['key']] = $rid;
    }

    $log = "# Software: Apache/2.4.58 (Ubuntu)  Server: {$appHost}  LogFormat: combined+rt+rid\n";
    foreach ($defs as $d) {
        $log .= sprintf(
            '%s - - [%s] "%s %s HTTP/1.1" %d %d "-" "%s" rt=%.3f rid=%s',
            $d['ip'],
            apache_ts($d['iso']),
            $d['method'],
            $d['path'],
            $d['status'],
            $d['bytes'],
            $d['ua'],
            $d['rt'],
            $d['rid']
        ) . "\n";
    }
    put($base . '/artifacts/web/access.log', $log);

    // ------------------------------------------------------------------ APP LOG
    $app = [];
    $app[] = ['ts' => '2026-11-05T22:31:12+07:00', 'level' => 'info', 'request_id' => $R['atk_recon'], 'route' => '/catalog', 'method' => 'GET', 'status' => 200, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'catalog_search', 'detail' => ['query' => 'test', 'rows' => 20], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:32:40+07:00', 'level' => 'info', 'request_id' => $R['atk_list'], 'route' => '/api/v1/covers', 'method' => 'GET', 'status' => 200, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'cover_list', 'detail' => ['limit' => 500, 'returned' => 500], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:34:20+07:00', 'level' => 'info', 'request_id' => $R['atk_up_jpg'], 'route' => '/api/v1/covers/upload', 'method' => 'PUT', 'status' => 201, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'cover_upload_stored', 'detail' => ['declared_mime' => 'image/jpeg', 'declared_size' => 64211, 'original_filename' => 'cover-2026-11-05.jpg', 'stored_path' => '/var/www/perpustakaan/public/uploads/cover-2026-11-05.jpg', 'validation' => 'client_header_only', 'auth_required' => false], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:35:02+07:00', 'level' => 'debug', 'request_id' => $R['atk_options'], 'route' => '/api/v1/covers/upload', 'method' => 'OPTIONS', 'status' => 200, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'cors_preflight', 'detail' => ['allow' => 'GET,POST,PUT', 'auth_required' => false], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:36:44+07:00', 'level' => 'warning', 'request_id' => $R['atk_getupload'], 'route' => '/api/v1/covers/upload', 'method' => 'GET', 'status' => 405, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'method_not_allowed', 'detail' => ['allowed' => ['PUT']], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:37:58+07:00', 'level' => 'info', 'request_id' => $R['atk_up_php'], 'route' => '/api/v1/covers/upload', 'method' => 'PUT', 'status' => 201, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'cover_upload_stored', 'detail' => ['declared_mime' => 'image/jpeg', 'declared_size' => 1188, 'original_filename' => 'cover-2026-11-05.php', 'stored_path' => '/var/www/perpustakaan/public/uploads/cover-2026-11-05.php', 'validation' => 'client_header_only', 'auth_required' => false], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:38:12+07:00', 'level' => 'info', 'request_id' => $R['atk_getshell'], 'route' => '/uploads/cover-2026-11-05.php', 'method' => 'GET', 'status' => 200, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'static_upload_served', 'detail' => ['bytes' => 34, 'handler' => 'php-fpm'], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:39:41+07:00', 'level' => 'warning', 'request_id' => $R['atk_shell1'], 'route' => '/uploads/cover-2026-11-05.php', 'method' => 'POST', 'status' => 200, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'upload_script_invoked', 'detail' => ['bytes_out' => 34, 'param_names' => ['c']], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:40:55+07:00', 'level' => 'warning', 'request_id' => $R['atk_shell2'], 'route' => '/uploads/cover-2026-11-05.php', 'method' => 'POST', 'status' => 200, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'upload_script_invoked', 'detail' => ['bytes_out' => 34, 'param_names' => ['c']], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:41:07+07:00', 'level' => 'info', 'request_id' => $R['atk_shell2'], 'route' => 'filesystem', 'method' => '-', 'status' => 0, 'user_id' => null, 'actor' => 'php-fpm', 'action' => 'file_created', 'detail' => ['path' => '/var/www/perpustakaan/storage/exports/.cache-9f1.php', 'bytes' => 2049, 'owner' => 'www-data'], 'client_ip' => null, 'ua' => null];
    $app[] = ['ts' => '2026-11-05T22:44:02+07:00', 'level' => 'info', 'request_id' => $R['atk_export1'], 'route' => '/catalog/export', 'method' => 'GET', 'status' => 200, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'catalog_export', 'detail' => ['format' => 'csv', 'scope' => 'all', 'rows' => 12480, 'bytes' => 4312990, 'fields' => ['isbn', 'title', 'author', 'call_number', 'internal_note', 'acquisition_price']], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:46:10+07:00', 'level' => 'warning', 'request_id' => $R['atk_members'], 'route' => '/api/v1/members/export', 'method' => 'GET', 'status' => 403, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'authorization_denied', 'detail' => ['required_role' => 'pustakawan', 'reason' => 'no_session'], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T22:49:33+07:00', 'level' => 'info', 'request_id' => $R['atk_export2'], 'route' => '/catalog/export', 'method' => 'GET', 'status' => 200, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'catalog_export', 'detail' => ['format' => 'csv', 'scope' => 'all', 'offset' => 5000, 'rows' => 6200, 'bytes' => 2140880, 'fields' => ['isbn', 'title', 'author', 'call_number', 'internal_note', 'acquisition_price']], 'client_ip' => $attacker, 'ua' => $uaCurl];
    $app[] = ['ts' => '2026-11-05T23:05:00+07:00', 'level' => 'info', 'request_id' => null, 'route' => 'cron', 'method' => '-', 'status' => 0, 'user_id' => null, 'actor' => 'cron', 'action' => 'backup_rotate_start', 'detail' => ['job' => 'perpus-backup', 'target' => '/var/backups/perpus-2026-11-05.tar.gz', 'source' => ['/var/www/perpustakaan', '/etc/perpustakaan']], 'client_ip' => null, 'ua' => null];
    $app[] = ['ts' => '2026-11-05T23:07:18+07:00', 'level' => 'info', 'request_id' => null, 'route' => 'cron', 'method' => '-', 'status' => 0, 'user_id' => null, 'actor' => 'cron', 'action' => 'backup_rotate_done', 'detail' => ['job' => 'perpus-backup', 'target' => '/var/backups/perpus-2026-11-05.tar.gz', 'bytes' => 153092096, 'duration_ms' => 138220], 'client_ip' => null, 'ua' => null];
    $app[] = ['ts' => '2026-11-05T23:40:00+07:00', 'level' => 'info', 'request_id' => null, 'route' => 'cron', 'method' => '-', 'status' => 0, 'user_id' => null, 'actor' => 'cron', 'action' => 'upload_cache_gc', 'detail' => ['job' => 'upload-cache-gc', 'retention_hours' => 2, 'deleted' => 0], 'client_ip' => null, 'ua' => null];
    $app[] = ['ts' => '2026-11-06T01:12:44+07:00', 'level' => 'error', 'request_id' => 'REQ-20261106-0099', 'route' => '/uploads/cover-2026-11-05.php', 'method' => 'POST', 'status' => 500, 'user_id' => null, 'actor' => 'anonymous', 'action' => 'php_fatal', 'detail' => ['error' => 'Call to undefined function ucn_exec()', 'file' => '/var/www/perpustakaan/public/uploads/cover-2026-11-05.php', 'line' => 3], 'client_ip' => $attacker, 'ua' => $uaCurl, 'note' => 'tidak ada pasangan rid di access.log: koneksi diputus sebelum baris akses ditulis'];
    $app[] = ['ts' => '2026-11-06T02:00:03+07:00', 'level' => 'info', 'request_id' => null, 'route' => 'cron', 'method' => '-', 'status' => 0, 'user_id' => null, 'actor' => 'cron', 'action' => 'upload_cache_gc', 'detail' => ['job' => 'upload-cache-gc', 'retention_hours' => 2, 'deleted' => 1, 'deleted_paths' => ['/var/www/perpustakaan/public/uploads/cover-2026-11-05.jpg']], 'client_ip' => null, 'ua' => null];
    $app[] = ['ts' => '2026-11-06T07:58:52+07:00', 'level' => 'info', 'request_id' => $R['adm_covers2'], 'route' => '/admin/covers', 'method' => 'GET', 'status' => 200, 'user_id' => 'USR-ADM-07', 'actor' => 'admin.perpus', 'action' => 'admin_cover_list', 'detail' => ['page' => 1], 'client_ip' => $adminIp, 'ua' => $uaChrome];
    $app[] = ['ts' => '2026-11-06T08:02:14+07:00', 'level' => 'error', 'request_id' => $R['adm_covererr'], 'route' => '/admin/covers', 'method' => 'GET', 'status' => 500, 'user_id' => 'USR-ADM-07', 'actor' => 'admin.perpus', 'action' => 'render_error', 'detail' => ['error' => 'Undefined array key "cover_path"', 'affected_rows' => 37], 'client_ip' => $adminIp, 'ua' => $uaChrome];
    $app[] = ['ts' => '2026-11-06T08:20:09+07:00', 'level' => 'info', 'request_id' => $R['adm_getshell'], 'route' => '/uploads/cover-2026-11-05.php', 'method' => 'GET', 'status' => 200, 'user_id' => 'USR-ADM-07', 'actor' => 'admin.perpus', 'action' => 'static_upload_served', 'detail' => ['bytes' => 34, 'handler' => 'php-fpm'], 'client_ip' => $adminIp, 'ua' => $uaChrome];
    $app[] = ['ts' => '2026-11-06T08:41:27+07:00', 'level' => 'warning', 'request_id' => $R['adm_maint'], 'route' => '/admin/maintenance', 'method' => 'POST', 'status' => 200, 'user_id' => 'USR-ADM-07', 'actor' => 'admin.perpus', 'action' => 'maintenance_mode_enabled', 'detail' => ['scope' => 'uploads_readonly'], 'client_ip' => $adminIp, 'ua' => $uaChrome];
    $body = '';
    foreach ($app as $r) {
        $body .= jline($r);
    }
    put($base . '/artifacts/web/app.log', $body);

    // ---------------------------------------------------------------- ERROR LOG
    $err = '';
    $err .= '[05-Nov-2026 22:38:12 +0700] PHP Notice:  Undefined index: HTTP_X_FORWARDED_FOR in /var/www/perpustakaan/app/Http/Middleware/ClientIp.php on line 41' . "\n";
    $err .= '[05-Nov-2026 22:38:12 +0700] PHP Warning:  Cannot modify header information - headers already sent by (output started at /var/www/perpustakaan/public/uploads/cover-2026-11-05.php:1) in /var/www/perpustakaan/public/uploads/cover-2026-11-05.php on line 2' . "\n";
    $err .= '[05-Nov-2026 22:39:41 +0700] PHP Warning:  Cannot modify header information - headers already sent by (output started at /var/www/perpustakaan/public/uploads/cover-2026-11-05.php:1) in /var/www/perpustakaan/public/uploads/cover-2026-11-05.php on line 2' . "\n";
    $err .= '[05-Nov-2026 22:40:55 +0700] PHP Warning:  Cannot modify header information - headers already sent by (output started at /var/www/perpustakaan/public/uploads/cover-2026-11-05.php:1) in /var/www/perpustakaan/public/uploads/cover-2026-11-05.php on line 2' . "\n";
    $err .= '[05-Nov-2026 22:44:09 +0700] PHP Warning:  fopen(/var/www/perpustakaan/storage/exports/export-12480.csv): Failed to open stream: Permission denied in /var/www/perpustakaan/app/Exports/CatalogExport.php on line 88' . "\n";
    $err .= '[05-Nov-2026 22:49:36 +0700] PHP Deprecated:  Optional parameter $flags declared before required parameter $context is implicitly treated as a required parameter in /var/www/perpustakaan/vendor/league/csv/src/Writer.php on line 112' . "\n";
    $err .= '[06-Nov-2026 01:12:44 +0700] PHP Fatal error:  Uncaught Error: Call to undefined function ucn_exec() in /var/www/perpustakaan/public/uploads/cover-2026-11-05.php:3' . "\n";
    $err .= '[06-Nov-2026 01:12:44 +0700] Stack trace:' . "\n";
    $err .= '#0 {main}' . "\n";
    $err .= '  thrown in /var/www/perpustakaan/public/uploads/cover-2026-11-05.php on line 3' . "\n";
    $err .= '[06-Nov-2026 08:02:14 +0700] PHP Warning:  Undefined array key "cover_path" in /var/www/perpustakaan/resources/views/admin/covers.blade.php on line 57' . "\n";
    $err .= '[06-Nov-2026 08:02:14 +0700] PHP Warning:  Trying to access array offset on value of type null in /var/www/perpustakaan/resources/views/admin/covers.blade.php on line 57' . "\n";
    put($base . '/artifacts/web/error.log', $err);

    // ------------------------------------------------------------- FIREWALL CSV
    $fw = [
        ['FS-20261105-0701', '2026-11-05T11:02:11Z', '2026-11-05T11:02:13Z', '192.0.2.88', $publicIp, 443, 'tcp', 2841, 18422, 'allow', 'publik'],
        ['FS-20261105-0702', '2026-11-05T13:58:14Z', '2026-11-05T14:19:41Z', $scanner, $publicIp, 443, 'tcp', 31140, 18820, 'allow', 'CHG-2207'],
        ['FS-20261105-0703', '2026-11-05T14:52:18Z', '2026-11-05T14:52:19Z', $adminIp, $internalIp, 443, 'tcp', 4220, 48210, 'allow', 'admin'],
        ['FS-20261105-0704', '2026-11-05T15:12:31Z', '2026-11-05T15:12:32Z', '192.0.2.141', $publicIp, 443, 'tcp', 900, 12880, 'allow', 'publik'],
        ['FS-20261105-0705', '2026-11-05T15:31:12Z', '2026-11-05T15:31:13Z', $attacker, $publicIp, 443, 'tcp', 862, 18740, 'allow', 'rekon'],
        ['FS-20261105-0706', '2026-11-05T15:32:40Z', '2026-11-05T15:32:41Z', $attacker, $publicIp, 443, 'tcp', 902, 96044, 'allow', 'rekon'],
        ['FS-20261105-0707', '2026-11-05T15:34:20Z', '2026-11-05T15:34:21Z', $attacker, $publicIp, 443, 'tcp', 65211, 412, 'allow', 'unggah-1'],
        ['FS-20261105-0708', '2026-11-05T15:37:58Z', '2026-11-05T15:37:59Z', $attacker, $publicIp, 443, 'tcp', 1490, 418, 'allow', 'unggah-2'],
        ['FS-20261105-0709', '2026-11-05T15:38:12Z', '2026-11-05T15:38:13Z', $attacker, $publicIp, 443, 'tcp', 388, 34, 'allow', 'akses-unggahan'],
        ['FS-20261105-0710', '2026-11-05T15:39:41Z', '2026-11-05T15:39:42Z', $attacker, $publicIp, 443, 'tcp', 512, 34, 'allow', 'akses-unggahan'],
        ['FS-20261105-0711', '2026-11-05T15:44:02Z', '2026-11-05T15:44:15Z', $attacker, $publicIp, 443, 'tcp', 912, 4331204, 'allow', 'ekspor'],
        ['FS-20261105-0712', '2026-11-05T15:46:10Z', '2026-11-05T15:46:11Z', $attacker, $publicIp, 443, 'tcp', 440, 198, 'allow', 'ekspor-ditolak'],
        ['FS-20261105-0713', '2026-11-05T15:49:33Z', '2026-11-05T15:49:41Z', $attacker, $publicIp, 443, 'tcp', 640, 2140880, 'allow', 'ekspor'],
        ['FS-20261105-0714', '2026-11-05T15:52:31Z', '2026-11-05T15:52:32Z', $attacker, $publicIp, 22, 'tcp', 120, 0, 'deny', 'ssh'],
        ['FS-20261105-0715', '2026-11-05T16:05:04Z', '2026-11-05T16:05:05Z', '127.0.0.1', $internalIp, 80, 'tcp', 200, 41, 'allow', 'healthz'],
        ['FS-20261105-0716', '2026-11-05T16:41:19Z', '2026-11-05T16:41:20Z', '192.0.2.201', $publicIp, 443, 'tcp', 2400, 20110, 'allow', 'publik'],
        ['FS-20261105-0717', '2026-11-05T19:07:18Z', '2026-11-05T19:07:19Z', $internalIp, '192.0.2.9', 443, 'tcp', 1240, 880, 'allow', 'backup-offsite'],
        ['FS-20261106-0801', '2026-11-06T00:58:52Z', '2026-11-06T00:58:53Z', $adminIp, $internalIp, 443, 'tcp', 3300, 47990, 'allow', 'admin'],
        ['FS-20261106-0802', '2026-11-06T01:20:09Z', '2026-11-06T01:20:10Z', $adminIp, $internalIp, 443, 'tcp', 900, 34, 'allow', 'admin'],
    ];
    $body = csv_row(['session_id', 'ts_start', 'ts_end', 'src_ip', 'dst_ip', 'dst_port', 'proto', 'bytes_in', 'bytes_out', 'action', 'note']) . "\n";
    foreach ($fw as $r) {
        $body .= csv_row($r) . "\n";
    }
    put($base . '/artifacts/net/firewall-sessions.csv', $body);

    // --------------------------------------------------------------- SNAPSHOTS
    $snapCols = ['path', 'type', 'size_bytes', 'mtime', 'sha256_original', 'owner', 'mode', 'note'];
    $before = [
        ['/var/www/perpustakaan/', 'dir', '', '2026-11-05T19:00:00+07:00', '', 'www-data', '0755', 'akar aplikasi'],
        ['/var/www/perpustakaan/public/uploads/', 'dir', '', '2026-11-05T18:55:12+07:00', '', 'www-data', '0755', 'direktori unggahan'],
        ['/var/www/perpustakaan/public/uploads/cover-9786020000111.jpg', 'file', '84211', '2026-10-28T10:12:44+07:00', rec_hash('/var/www/perpustakaan/public/uploads/cover-9786020000111.jpg|84211'), 'www-data', '0644', 'sampul'],
        ['/var/www/perpustakaan/public/uploads/cover-9786020000222.jpg', 'file', '91002', '2026-10-30T14:31:02+07:00', rec_hash('/var/www/perpustakaan/public/uploads/cover-9786020000222.jpg|91002'), 'www-data', '0644', 'sampul'],
        ['/var/www/perpustakaan/storage/exports/', 'dir', '', '2026-11-05T17:02:11+07:00', '', 'www-data', '0750', 'cache ekspor'],
        ['/var/www/perpustakaan/storage/exports/export-12479.csv', 'file', '120422', '2026-11-05T17:02:11+07:00', rec_hash('export-12479.csv|120422'), 'www-data', '0640', 'ekspor terjadwal'],
        ['/var/www/perpustakaan/storage/logs/laravel-2026-11-05.log', 'file', '884120', '2026-11-05T18:59:59+07:00', rec_hash('laravel-2026-11-05.log|884120'), 'www-data', '0640', 'log aplikasi'],
        ['/var/www/perpustakaan/config/app.php', 'file', '3120', '2026-10-28T09:00:00+07:00', rec_hash('config/app.php|3120|2026-10-28'), 'root', '0644', 'konfigurasi'],
        ['/var/www/perpustakaan/.env', 'file', '1410', '2026-10-28T09:00:00+07:00', rec_hash('.env|1410'), 'root', '0600', 'rahasia aplikasi'],
        ['/var/backups/', 'dir', '', '2026-11-04T23:07:20+07:00', '', 'root', '0700', 'pencadangan'],
        ['/var/backups/perpus-2026-11-04.tar.gz', 'file', '149880832', '2026-11-04T23:07:20+07:00', rec_hash('perpus-2026-11-04.tar.gz|149880832'), 'root', '0600', 'cron'],
    ];
    $body = "# snapshot_id=SNAP-20261105-1900; host={$host}; taken_at=2026-11-05T19:00:00+07:00; collector=host-agent 2.1; scope=/var/www/perpustakaan,/var/backups\n";
    $body .= csv_row($snapCols) . "\n";
    foreach ($before as $r) {
        $body .= csv_row($r) . "\n";
    }
    put($base . '/artifacts/fs/snapshot-' . $host . '-20261105T1900+07.csv', $body);

    $after = [
        ['/var/www/perpustakaan/', 'dir', '', '2026-11-06T08:41:27+07:00', '', 'www-data', '0755', 'akar aplikasi'],
        ['/var/www/perpustakaan/public/uploads/', 'dir', '', '2026-11-06T08:20:09+07:00', '', 'www-data', '0755', 'direktori unggahan'],
        ['/var/www/perpustakaan/public/uploads/cover-9786020000111.jpg', 'file', '84211', '2026-10-28T10:12:44+07:00', rec_hash('/var/www/perpustakaan/public/uploads/cover-9786020000111.jpg|84211'), 'www-data', '0644', 'sampul'],
        ['/var/www/perpustakaan/public/uploads/cover-9786020000222.jpg', 'file', '91002', '2026-10-30T14:31:02+07:00', rec_hash('/var/www/perpustakaan/public/uploads/cover-9786020000222.jpg|91002'), 'www-data', '0644', 'sampul'],
        ['/var/www/perpustakaan/public/uploads/cover-2026-11-05.php', 'file', '1188', '2026-11-05T22:37:58+07:00', rec_hash('/var/www/perpustakaan/public/uploads/cover-2026-11-05.php|1188'), 'www-data', '0644', 'ditemukan saat triage; tidak disertakan sebagai kode'],
        ['/var/www/perpustakaan/storage/exports/', 'dir', '', '2026-11-06T02:00:03+07:00', '', 'www-data', '0750', 'cache ekspor'],
        ['/var/www/perpustakaan/storage/exports/export-12479.csv', 'file', '120422', '2026-11-05T17:02:11+07:00', rec_hash('export-12479.csv|120422'), 'www-data', '0640', 'ekspor terjadwal'],
        ['/var/www/perpustakaan/storage/exports/.cache-9f1.php', 'file', '2049', '2026-11-05T22:41:07+07:00', rec_hash('/var/www/perpustakaan/storage/exports/.cache-9f1.php|2049'), 'www-data', '0644', 'tersembunyi; tidak disertakan'],
        ['/var/www/perpustakaan/storage/logs/laravel-2026-11-05.log', 'file', '991204', '2026-11-05T23:59:59+07:00', rec_hash('laravel-2026-11-05.log|991204'), 'www-data', '0640', 'log aplikasi'],
        ['/var/www/perpustakaan/storage/logs/laravel-2026-11-06.log', 'file', '212044', '2026-11-06T08:41:27+07:00', rec_hash('laravel-2026-11-06.log|212044'), 'www-data', '0640', 'log aplikasi'],
        ['/var/www/perpustakaan/config/app.php', 'file', '3120', '2026-10-28T09:00:00+07:00', rec_hash('config/app.php|3120|2026-10-28'), 'root', '0644', 'tidak berubah'],
        ['/var/www/perpustakaan/.env', 'file', '1410', '2026-10-28T09:00:00+07:00', rec_hash('.env|1410'), 'root', '0600', 'tidak berubah'],
        ['/var/backups/', 'dir', '', '2026-11-05T23:07:18+07:00', '', 'root', '0700', 'pencadangan'],
        ['/var/backups/perpus-2026-11-05.tar.gz', 'file', '153092096', '2026-11-05T23:07:18+07:00', rec_hash('perpus-2026-11-05.tar.gz|153092096'), 'root', '0600', 'cron; tidak disertakan'],
    ];
    $body = "# snapshot_id=SNAP-20261106-0900; host={$host}; taken_at=2026-11-06T09:00:00+07:00; collector=host-agent 2.1; scope=/var/www/perpustakaan,/var/backups\n";
    $body .= csv_row($snapCols) . "\n";
    foreach ($after as $r) {
        $body .= csv_row($r) . "\n";
    }
    put($base . '/artifacts/fs/snapshot-' . $host . '-20261106T0900+07.csv', $body);

    // ------------------------------------------------------ UPLOAD EXCERPT FILE
    put($base . '/artifacts/fs/uploads/cover-2026-11-05.php.txt', <<<TXT
SYNTHETIC EVIDENCE EXCERPT - NOT EXECUTABLE CODE
================================================

Berkas asli di host : /var/www/perpustakaan/public/uploads/cover-2026-11-05.php
Ukuran asli          : 1188 byte
mtime asli (WIB)     : 2026-11-05T22:37:58+07:00
sha256 asli          : lihat kolom sha256_original pada snapshot 2026-11-06
Peran di paket       : ekscerpt teks, bukan byte asli

Catatan sanitasi:
Isi asli tidak disertakan dalam paket ini. Yang tersedia hanya metadata dan
potongan perilaku yang tercatat di access.log, app.log, dan error.log.
Jangan mengeksekusi berkas ini dalam bentuk apa pun.

Petunjuk analisis yang tersedia dari log (bukan dari isi berkas):
- Server menyimpan berkas dengan nama yang ditentukan pengunggah.
- Validasi tipe hanya memakai header Content-Type dari klien.
- Berkas .php dapat diakses langsung melalui /uploads/.
TXT);

    // --------------------------------------------------------- CONFIG AUDIT
    $cfg = [
        ['CFG-001', '2026-10-28T09:00:00+07:00', 'app', 'app.debug', 'false', 'true', 'CHG-2199', 'admin.perpus', 'Debug diaktifkan saat troubleshooting; tidak dikembalikan'],
        ['CFG-002', '2026-10-28T09:00:00+07:00', 'app', 'app.env', 'production', 'production', 'CHG-2199', 'admin.perpus', 'Tidak berubah'],
        ['CFG-003', '2026-10-28T09:00:00+07:00', 'php', 'expose_php', 'On', 'On', 'CHG-2199', 'admin.perpus', 'Nilai default image'],
        ['CFG-004', '2026-10-28T09:00:00+07:00', 'upload', 'upload.max_size_mb', '5', '5', 'CHG-2199', 'admin.perpus', 'Tidak berubah'],
        ['CFG-005', '2026-10-28T09:00:00+07:00', 'upload', 'upload.allowed_extensions', 'jpg,jpeg,png', 'jpg,jpeg,png,pdf', 'CHG-2207', 'vendor-nusantara', 'Perluasan untuk e-book sampul PDF'],
        ['CFG-006', '2026-10-28T09:00:00+07:00', 'upload', 'upload.validate_mime', 'client_header', 'client_header', 'CHG-2199', 'admin.perpus', 'Tidak berubah; validasi hanya header klien'],
        ['CFG-007', '2026-10-28T09:00:00+07:00', 'upload', 'upload.require_auth', 'false', 'false', 'CHG-2199', 'admin.perpus', 'Endpoint unggah publik untuk integrasi kiosk'],
        ['CFG-008', '2026-10-28T09:00:00+07:00', 'catalog', 'catalog.export_public', 'true', 'true', 'CHG-2199', 'admin.perpus', 'Ekspor katalog publik untuk integrasi OPAC'],
        ['CFG-009', '2026-10-28T09:00:00+07:00', 'catalog', 'catalog.export_fields', 'isbn,title,author', 'isbn,title,author,call_number,internal_note,acquisition_price', 'CHG-2199', 'admin.perpus', 'Ditambah untuk kebutuhan audit internal'],
        ['CFG-010', '2026-10-28T09:00:00+07:00', 'upload', 'upload.cache_gc_hours', '2', '2', 'CHG-2199', 'admin.perpus', 'Retensi staging unggahan (jam)'],
        ['CFG-011', '2026-11-05T20:00:00+07:00', 'maintenance', 'maintenance.window', 'none', 'vendor-2026-11', 'CHG-2207', 'vendor-nusantara', 'Jendela asesmen vendor 20:00-22:00'],
        ['CFG-012', '2026-11-06T08:41:27+07:00', 'maintenance', 'uploads.readonly', 'false', 'true', 'INC-2026-1106-003', 'admin.perpus', 'Mitigasi sementara saat triage'],
    ];
    $body = csv_row(['audit_id', 'effective_ts', 'scope', 'key', 'value_before', 'value_after', 'change_ref', 'changed_by', 'note']) . "\n";
    foreach ($cfg as $r) {
        $body .= csv_row($r) . "\n";
    }
    put($base . '/artifacts/config/config-audit-' . $host . '.csv', $body);

    // ------------------------------------------------------------- TICKETS
    $tk = [
        ['CHG-2199', 'change', '2026-10-27T15:00:00+07:00', 'admin.perpus', 'Perubahan konfigurasi ekspor katalog dan debug', 'approved', 'Diterapkan 2026-10-28 09:00 WIB', '2026-10-28T09:00:00+07:00', 'CAB-PTI', 'Menambah kolom ekspor untuk audit inventaris'],
        ['CHG-2207', 'change', '2026-11-01T09:30:00+07:00', 'vendor-nusantara', 'Jendela pemeliharaan vendor: pemindaian terotorisasi dan penyesuaian unggahan', 'approved', 'Diterapkan 2026-11-05 20:00-22:00 WIB', '2026-11-05T22:00:00+07:00', 'CAB-PTI', 'Pemindai: 198.51.100.55; kontak security@vendor-nusantara.test; penyesuaian allowlist ekstensi'],
        ['CHG-2210', 'change', '2026-11-02T11:00:00+07:00', 'admin.perpus', 'Rotasi retensi pencadangan 14 hari', 'approved', 'Diterapkan 2026-11-03 23:00 WIB', '2026-11-03T23:05:00+07:00', 'CAB-PTI', 'Cron perpus-backup tetap 23:05 WIB'],
        ['INC-2026-1106-003', 'incident', '2026-11-06T08:03:12+07:00', 'admin.perpus', 'Sampul buku hilang dan halaman katalog error', 'open', 'Mitigasi sementara: unggahan read-only', '2026-11-06T08:41:27+07:00', 'PTI', 'Ditemukan berkas tak dikenal di /uploads'],
        ['REQ-2026-1105-014', 'request', '2026-11-05T14:20:00+07:00', 'pustakawan1@' . $dom, 'Permintaan ekspor katalog lengkap untuk audit', 'closed', 'Disetujui; dijalankan manual 2026-11-05 17:02 WIB', '2026-11-05T17:02:11+07:00', 'PTI', 'Ekspor sah 120 KB, bukan 4 MB'],
        ['INC-2026-1105-002', 'incident', '2026-11-05T21:22:00+07:00', 'vendor-nusantara', 'Pemindaian selesai; 2 temuan rendah', 'closed', 'Laporan vendor dikirim 2026-11-06', '2026-11-06T09:00:00+07:00', 'CAB-PTI', 'Temuan: banner PHP, cookie tanpa HttpOnly'],
        ['INC-2026-1106-004', 'incident', '2026-11-06T09:12:00+07:00', 'pti@' . $dom, 'Permintaan analisis forensik independen', 'open', 'Paket dibekukan 09:30 WIB', '2026-11-06T09:30:00+07:00', 'PTI', 'Mandat UCN-IR-2026-1106-02'],
    ];
    $body = csv_row(['ticket_id', 'type', 'ts_created', 'requester', 'summary', 'status', 'resolution', 'ts_resolved', 'owner', 'note']) . "\n";
    foreach ($tk as $r) {
        $body .= csv_row($r) . "\n";
    }
    put($base . '/artifacts/change/change-tickets-2026-11.csv', $body);

    // ---------------------------------------------------------------- BASELINE
    put($base . '/baseline/README.md', <<<MD
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
MD);

    $body = csv_row(['window_start', 'window_end', 'requests', 'status_2xx', 'status_4xx', 'status_5xx', 'uploads', 'export_bytes', 'unique_client_ips', 'note']) . "\n";
    $rows = [
        ['2026-10-22', 8420, 7980, 402, 38, 3, 121400, 214],
        ['2026-10-23', 9012, 8501, 470, 41, 5, 118200, 231],
        ['2026-10-26', 10244, 9702, 498, 44, 6, 130400, 268],
        ['2026-10-27', 9880, 9344, 492, 44, 2, 122900, 255],
        ['2026-10-28', 10412, 9870, 501, 41, 7, 128800, 271],
        ['2026-10-29', 9930, 9402, 487, 41, 4, 119700, 249],
        ['2026-10-30', 9711, 9188, 480, 43, 3, 124100, 242],
        ['2026-11-02', 10588, 10020, 521, 47, 5, 131200, 280],
        ['2026-11-03', 10344, 9788, 508, 48, 4, 117800, 262],
        ['2026-11-04', 10120, 9581, 497, 42, 3, 126600, 258],
    ];
    foreach ($rows as $r) {
        $body .= csv_row([$r[0] . 'T00:00:00+07:00', $r[0] . 'T23:59:59+07:00', $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], 'Agregat harian']) . "\n";
    }
    put($base . '/baseline/access-summary-20261022_20261104.csv', $body);

    $mix = [
        'baseline_date' => '2026-11-04',
        'window_start' => '2026-11-04T00:00:00+07:00',
        'window_end' => '2026-11-04T23:59:59+07:00',
        'source' => 'agregasi access.log harian, log mentah tidak disertakan',
        'routes' => [
            ['route' => '/', 'requests' => 3120, 'p95_ms' => 180],
            ['route' => '/catalog', 'requests' => 4012, 'p95_ms' => 240],
            ['route' => '/catalog/{isbn}', 'requests' => 1840, 'p95_ms' => 190],
            ['route' => '/assets/*', 'requests' => 902, 'p95_ms' => 20],
            ['route' => '/admin/*', 'requests' => 140, 'p95_ms' => 520],
            ['route' => '/api/v1/covers', 'requests' => 62, 'p95_ms' => 310],
            ['route' => '/api/v1/covers/upload', 'requests' => 3, 'p95_ms' => 480],
            ['route' => '/catalog/export', 'requests' => 4, 'p95_ms' => 900],
        ],
        'export_profile' => [
            'typical_bytes_min' => 112000,
            'typical_bytes_max' => 132000,
            'typical_scope' => 'public',
            'max_rows_observed' => 400,
        ],
        'upload_profile' => [
            'typical_source' => 'sesi admin dari 10.20.9.20',
            'typical_declared_mime' => ['image/jpeg', 'image/png'],
            'typical_size_bytes' => [40000, 120000],
            'php_uploads_observed' => 0,
        ],
        'user_agent_mix' => [
            ['family' => 'Firefox', 'share' => 0.46],
            ['family' => 'Chrome', 'share' => 0.38],
            ['family' => 'Safari', 'share' => 0.13],
            ['family' => 'curl', 'share' => 0.01],
        ],
    ];
    put($base . '/baseline/app-request-mix-20261104.json', jdoc($mix));

    // ----------------------------------------------------------- README FILES
    put($base . '/README-mahasiswa.md', <<<MD
# Cara Membuka dan Memverifikasi Paket (Windows)

Tidak perlu Docker, Python, atau server web. Semua artefak adalah teks.

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
  Where-Object { \$_.Trim() -ne '' -and \$_ -notmatch '^#' } |
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
| `.log` | VS Code / Notepad++; word wrap aktif |
| `.jsonl` | Satu baris = satu rekaman |
| `.csv` | Excel: Data > Dari Teks/CSV; atau VS Code |
| `.json` | VS Code; format document |
| `.txt` | VS Code |

Jangan mengeksekusi berkas di `artifacts/fs/uploads/`. Berkas itu ekscerpt
teks, bukan kode yang dijalankan.

## 4. Mencari `rid` dan korelasi

```powershell
Select-String -Path .\\artifacts\\web\\app.log -Pattern 'REQ-20261105-0023'
Select-String -Path .\\artifacts\\web\\access.log -Pattern 'REQ-20261105-0023'
```

## 5. Zona waktu

`access.log` memakai WIB, `firewall-sessions.csv` memakai UTC. Baca
`artifacts/SOURCE-TIME-AND-CONVENTIONS.md`; jangan menormalkan timestamp di
berkas asli.

## 6. Batas penting

Beberapa berkas yang tercatat di snapshot tidak disertakan (arsip 146 MB,
berkas `.php` asli). Itu disengaja. Catat pada register bukti.
MD);

    put($base . '/evidence/README.md', <<<MD
# Register dan Verifikasi Bukti

## 1. Prinsip

1. Folder paket adalah master baca-saja.
2. Analisis dilakukan pada salinan kerja.
3. Setiap perpindahan bukti dicatat: siapa, kapan (dengan offset), dari mana,
   ke mana, dan mengapa.
4. Hash membuktikan integritas berkas dalam paket, bukan kebenaran isi.

## 2. Verifikasi manifest

Format: `<sha256 huruf kecil><dua spasi><path relatif>`. Baris `#` komentar.
Jalankan dari akar paket:

```powershell
\$root = (Get-Location).Path
\$n = 0; \$bad = 0
Get-Content .\\manifest-sha256.txt |
  Where-Object { \$_.Trim() -ne '' -and \$_ -notmatch '^#' } |
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

Gunakan `evidence-register-template.csv`. Isi minimal: `item_id`,
`file_path`, `sha256_original`, `acquired_at`, `received_from`, `custodian`,
`storage_location`, `sha256_working_copy`, `verification_result`, `notes`.

**Penting untuk kasus ini:** beberapa berkas yang tercatat di snapshot tidak
disertakan dalam paket. Tandai sebagai `not_in_package` dengan alasan, dan
jangan mengarang hash.

## 4. Batas yang harus dinyatakan

- Berkas di `artifacts/fs/uploads/` adalah ekscerpt, bukan byte asli.
- Kolom `sha256_original` pada snapshot tidak dapat dihitung ulang.
- Tidak ada log query basis data dan tidak ada image disk.
- Ketiadaan rekaman bukan bukti ketiadaan peristiwa.
MD);

    $reg = csv_row(['item_id', 'file_path', 'sha256_original', 'acquired_at', 'received_from', 'custodian', 'storage_location', 'sha256_working_copy', 'verification_result', 'notes']) . "\n";
    $reg .= csv_row(['E-001', 'artifacts/web/access.log', '', '2026-11-20T09:00:00+07:00', 'Mentor DFIR (fiktif)', '', '', '', 'isi setelah verifikasi']) . "\n";
    $reg .= csv_row(['E-002', 'artifacts/fs/uploads/cover-2026-11-05.php (asli di host)', 'lihat snapshot FS', '2026-11-20T09:00:00+07:00', 'Mentor DFIR (fiktif)', '', '', 'not_in_package', 'ekscerpt teks saja; hash asli tidak dapat dihitung ulang']) . "\n";
    put($base . '/evidence/evidence-register-template.csv', $reg);

    write_manifest($c);
}

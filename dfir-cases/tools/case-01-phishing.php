<?php
/**
 * Case 01 - Phishing akun staf (Yayasan Cendekia Nusantara).
 * Generates participant-visible files only. No ground truth, no answers.
 */

declare(strict_types=1);

require_once __DIR__ . '/lib.php';

function build_case_01(): void
{
    $c = '01-phishing-staf';
    $base = pkg($c);

    $org   = 'Yayasan Cendekia Nusantara (YCN)';
    $dom   = 'cendekia-nusantara.test';
    $idp   = 'sso.cendekia-nusantara.test';
    $victim = 'nadia.permata@' . $dom;
    $victimId = 'USR-10442';
    $host  = 'WS-AKD-014';
    $dev   = 'DEV-7c41a9';
    $campusIp = '192.0.2.20';
    $attackerIp = '198.51.100.77';
    $lookalike = 'cendekia-nusantara-sso.test';

    $uaChrome = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.127 Safari/537.36';
    $uaEdge   = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.6478.127 Safari/537.36 Edg/126.0.2592.87';

    // ------------------------------------------------------------------ MANDATE
    put($base . '/MANDATE.md', <<<MD
# Surat Penugasan Insiden - DFIR-1

**Klasifikasi paket:** SIMULASI / DATA SINTETIS
**Nomor mandat:** YCN-IR-2026-1103-01
**Penerbit (fiktif):** Kepala Unit Keamanan Informasi, {$org}
**Penerima:** Tim DFIR eksternal (kelompok peserta DFIR-1)
**Tanggal mandat:** 3 November 2026, 11:00 WIB (UTC+07:00)
**Batas penyerahan laporan:** 18 Desember 2026, 23:59 WIB

## 1. Organisasi

{$org} adalah yayasan pendidikan fiktif yang mengelola tiga kampus di Jawa.
Seluruh sistem, akun, host, alamat IP, dan domain dalam paket ini sintetis.
Domain operasional yang dipakai dalam latihan: `{$dom}`. Tidak ada sistem
nyata, kredensial nyata, atau data pribadi nyata di dalam paket.

Layanan yang relevan:

| Layanan | Nama internal | Keterangan |
| --- | --- | --- |
| SSO kampus | GerbangID, tenant `ycn-prod` | Login tunggal untuk surel, SIAKAD, dan berbagi berkas |
| Surel | MailGate + Exchange-like `mail.{$dom}` | Gateway mencatat metadata pesan, bukan isi |
| Berbagi berkas | `drive.{$dom}` | Tidak termasuk cakupan mandat ini |
| Perangkat staf | `{$host}` | Laptop Windows milik Staf Direktorat Akademik |

## 2. Insiden yang dilaporkan

Pada 3 November 2026 pukul 09:38 WIB, seorang staf Direktorat Akademik
melaporkan ke meja bantuan bahwa ia menerima notifikasi masuk yang tidak ia
kenali, lalu tidak dapat mengakses surel. Tim TI menonaktifkan akun pada
pukul 09:44 WIB dan melakukan reset kredensial. Manajemen meminta analisis
independen atas paket bukti yang telah dibekukan (frozen) pada
3 November 2026 pukul 14:00 WIB.

> Catatan provenance: tiket meja bantuan diekspor terpisah pada
> 4 November 2026 pukul 09:00 WIB dan ditambahkan ke paket. Berkas lain
> dibekukan 3 November 2026 pukul 14:00 WIB.

## 3. Ruang lingkup mandat

**Termasuk:**

1. Akun `{$victim}` (ID `{$victimId}`) dan sesi SSO yang terkait.
2. Kotak surat pribadi akun tersebut dan kotak surat bersama
   `keuangan@{$dom}` yang dapat diakses akun itu.
3. Host `{$host}` dan riwayat peramban/EDR-nya pada 2-4 November 2026.
4. Metadata gateway surel untuk periode 20 Oktober - 4 November 2026.
5. Tiket meja bantuan yang terkait insiden ini.

**Tidak termasuk (jangan diklaim):**

- Host lain, akun lain, dan sistem SIAKAD/keuangan di luar kotak surat bersama.
- Isi berkas di `drive.{$dom}` dan perangkat seluler pribadi staf.
- Uji aktif terhadap infrastruktur mana pun. Paket ini statis.

## 4. Batasan

- Bukti bersifat **statis dan sintetis**. Jangan memindai, menghubungi, atau
  membuka alamat IP/domain yang tercantum. Tidak ada layanan yang berjalan.
- Jangan mengubah berkas asli. Bekerja pada salinan; asli tetap baca-saja.
- Jangan menambahkan data dari luar paket. Setiap klaim harus menunjuk
  berkas dan ID rekaman di dalam paket.
- Setiap timestamp asli harus dipertahankan apa adanya. Konversi zona waktu
  ditulis pada kolom terpisah.
- Tidak ada akses ke penyedia identitas, gateway, atau EDR secara langsung;
  hanya ekspor yang tersedia di paket.

## 5. Pertanyaan investigasi utama (ringkas)

1. Kapan akses tidak sah dimulai dan bukti mana yang menetapkannya?
2. Akun dan aset mana yang benar-benar terdampak, dan mana yang belum terbukti?
3. Tindakan pengamanan dan pemulihan apa yang menjaga bukti sekaligus
   memulihkan layanan?

Rincian dua belas pertanyaan ada pada `student-card.md`.

## 6. Keluaran yang diminta

Register bukti dan verifikasi hash, kronologi, matriks hipotesis, laporan
insiden, ringkasan eksekutif, dan slide. Format bukti diatur pada
`student-card.md` dan `evidence/README.md`.

## 7. Kontak (fiktif)

- Pemilik insiden: Kepala Unit Keamanan Informasi, `keamanan@{$dom}`
- Koordinator teknis: `budi.hartono@{$dom}`
- Jam kerja mandat: 08:00-17:00 WIB, Senin-Jumat

> Paket ini adalah alat latihan. Jangan menganggap temuan di sini sebagai
> penilaian atas sistem nyata mana pun.
MD);

    // -------------------------------------------------------------- STUDENT CARD
    put($base . '/student-card.md', <<<MD
# Kartu Peserta - DFIR-1: Phishing Akun Staf

**Kasus:** akses tidak sah ke akun staf dan penyalahgunaan sesi SSO
**Organisasi (fiktif):** {$org}
**Paket:** `dfir-cases/{$c}/`
**Batas laporan:** 18 Desember 2026, 23:59 WIB

## Situasi

Seorang staf Direktorat Akademik melaporkan notifikasi masuk yang tidak
dikenali pada 3 November 2026 pagi. Tim TI menonaktifkan akun dan mereset
kredensial pada hari yang sama. Anda menerima paket bukti yang dibekukan
pukul 14:00 WIB. Tugas Anda bukan menebak satu indikator, melainkan
merekonstruksi apa yang terjadi, menetapkan batas dampak, dan mengusulkan
respons yang proporsional.

## Tujuan

1. Menetapkan kapan akses tidak sah dimulai, dengan bukti yang dapat
   ditunjuk per rekaman.
2. Memisahkan aktivitas sah, jebakan pengalih, dan aktivitas penyerang.
3. Menetapkan akun/aset yang terbukti terdampak dan yang masih belum pasti.
4. Menyusun kronologi yang dapat dipertahankan dan rencana pemulihan.

## Artefak yang tersedia

| Berkas | Isi |
| --- | --- |
| `artifacts/email/MSG-20261103-0042.eml` | Pesan surel lengkap dengan header |
| `artifacts/email/mailgateway-20261102_20261104.jsonl` | Metadata gateway surel |
| `artifacts/identity/idp-signin-20261101_20261104.jsonl` | Log sign-in SSO |
| `artifacts/identity/mailbox-audit-20261103.jsonl` | Audit kotak surat |
| `artifacts/endpoint/{$host}-browser-history.json` | Riwayat peramban |
| `artifacts/endpoint/{$host}-edr-20261103.jsonl` | Telemetri EDR |
| `artifacts/service-desk/tickets-20261102_20261104.csv` | Tiket meja bantuan |
| `baseline/` | Aktivitas normal pembanding |
| `artifacts/SOURCE-TIME-AND-CONVENTIONS.md` | Zona waktu dan konvensi ID |
| `artifacts/ARTIFACT-INDEX.md` | Indeks dan batas tiap artefak |

## Pertanyaan (Q1-Q12)

**Q1.** Nyatakan mandat, sistem/akun yang tercakup, dan tiga pertanyaan
investigasi yang akan Anda jawab. Sertakan batas klaim.

**Q2.** Berapa artefak yang Anda terima, berapa hash asli dan hash salinan
kerja, dan siapa memegang bukti pada tiap tahap? Tunjukkan hasil verifikasi.

**Q3.** Artefak mana yang paling relevan untuk rantai insiden, dan mana yang
paling mungkin merupakan pengalih? Jelaskan dasar prioritas Anda dengan
menunjuk rekaman tertentu.

**Q4.** Ajukan dua hipotesis yang saling bersaing tentang penyebab akses tidak
sah. Bukti apa yang membedakan keduanya, dan hipotesis mana yang Anda terima?

**Q5.** Susun lima peristiwa awal dalam urutan waktu WIB. Sertakan waktu
sumber, zona waktu sumber, dan tingkat kepastian tiap peristiwa.

**Q6.** Email, URL, dan indikator sesi apa yang menghubungkan pesan dengan
tindakan pengguna? Tunjukkan rantai dari pesan ke sesi SSO.

**Q7.** Sign-in mana yang menyimpang dari baseline akun ini? Bandingkan
setidaknya IP, perangkat, metode autentikasi, jam, dan hasil.

**Q8.** Artefak endpoint mana yang mendukung atau menyangkal aktivitas
pasca-login di host? Sebutkan bukti yang tidak ada dan artinya.

**Q9.** Apa containment segera yang menjaga bukti, dan apa konsekuensi
operasionalnya? Urutkan tindakan dan jelaskan trade-off-nya.

**Q10.** Apa dampak yang terbukti, apa yang masih mungkin, dan bukti tambahan
apa yang diperlukan sebelum memperluas klaim?

**Q11.** Tulis kronologi final. Sertakan sedikitnya satu alternatif yang Anda
tolak beserta alasannya.

**Q12.** Usulkan eradikasi dan pemulihan, pemilik tindakan, verifikasi setelah
pemulihan, serta dua perbaikan proses.

## Petunjuk konsep (bukan jawaban)

- Metadata gateway tidak sama dengan isi pesan; periksa header dan tautan.
- Baseline diperlukan untuk mengatakan "menyimpang", bukan sekadar "aneh".
- Sesi SSO dapat dipakai ulang dari alamat IP lain; cocokkan `session_id`
  antar artefak, bukan hanya nama pengguna.
- Audit kotak surat mencatat operasi dan parameter, tetapi belum tentu
  mencatat setiap byte yang keluar dari organisasi.
- Tidak adanya bukti di satu artefak bukan bukti tidak adanya peristiwa;
  nyatakan batas tersebut secara eksplisit.
- WIB adalah UTC+07:00 dan tidak mengenal daylight saving time.

## Format bukti yang diminta

Untuk setiap klaim, tulis baris tabel:

| Klaim | Berkas | ID rekaman | Waktu sumber | Waktu WIB | Kepastian |
| --- | --- | --- | --- | --- | --- |

Aturan:

1. Setiap klaim harus menunjuk berkas **dan** ID rekaman (mis. `event_id`,
   `message_id`, `audit_id`, `ticket_id`, `visit_id`).
2. Waktu sumber ditulis persis seperti di artefak (termasuk offset).
   Kolom WIB adalah hasil konversi, bukan pengganti.
3. Kepastian memakai tiga tingkat: **Tinggi**, **Sedang**, **Rendah**,
   dengan alasan singkat.
4. Klaim yang tidak dapat dibuktikan masuk ke bagian "Ketidakpastian" dengan
   bukti tambahan yang dibutuhkan.

## Keluaran

Register bukti + verifikasi hash, timeline, matriks hipotesis, laporan
insiden (maks. 8 halaman), ringkasan eksekutif (maks. 1 halaman), dan slide.
MD);

    // ------------------------------------------------------ SOURCE TIME / INDEX
    put($base . '/artifacts/SOURCE-TIME-AND-CONVENTIONS.md', <<<MD
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
MD);

    $index = <<<MD
# Indeks Artefak

| Berkas | Rekaman | Cakupan waktu | Sumber |
| --- | ---: | --- | --- |
| `email/MSG-20261103-0042.eml` | 1 pesan | 2026-11-03 08:12 WIB | Arsip surel |
| `email/mailgateway-20261102_20261104.jsonl` | lihat berkas | 2026-11-02 s.d. 2026-11-04 | Ekspor gateway |
| `identity/idp-signin-20261101_20261104.jsonl` | lihat berkas | 2026-11-01 s.d. 2026-11-04 | Ekspor SSO |
| `identity/mailbox-audit-20261103.jsonl` | lihat berkas | 2026-11-03 | Ekspor audit |
| `endpoint/{$host}-browser-history.json` | lihat berkas | 2026-11-02 s.d. 2026-11-03 | Profil peramban |
| `endpoint/{$host}-edr-20261103.jsonl` | lihat berkas | 2026-11-03 | EDR |
| `service-desk/tickets-20261102_20261104.csv` | 6 tiket | 2026-11-02 s.d. 2026-11-04 | Meja bantuan |

Catatan provenance:

- Semua artefak adalah ekspor statis yang dibekukan 2026-11-03 14:00 WIB,
  kecuali tiket yang diekspor 2026-11-04 09:00 WIB.
- Tidak ada artefak yang diubah setelah pembekuan.
- Artefak tidak saling menggantikan; masing-masing memiliki batas.
MD;
    put($base . '/artifacts/ARTIFACT-INDEX.md', $index);

    // ------------------------------------------------------------------- EML
    $eml = <<<EML
Return-Path: <it-support@{$lookalike}>
Received: from mx1.{$lookalike} (mx1.{$lookalike} [198.51.100.77])
 by gw-in-02.mailgate.ycn.internal with ESMTPS id 4fJ2kL91xZ
 for <{$victim}>; Tue, 3 Nov 2026 08:12:44 +0700
Received: from app03.{$lookalike} (app03.{$lookalike} [198.51.100.77])
 by mx1.{$lookalike} with ESMTP id 2cQ7pR40aa
 for <{$victim}>; Tue, 3 Nov 2026 01:12:41 +0000
DKIM-Signature: v=1; a=rsa-sha256; c=relaxed/relaxed; d={$lookalike};
 s=mail2026; t=1793668361; bh=SYNTHETICBhEXAMPLE0000000000000000000000000000=;
 h=From:To:Subject:Date:Message-ID; b=SYNTHETICsignatureNOTREAL0000000000000000
X-Gateway-Message-ID: MSG-20261103-0042
X-Gateway-Verdict: delivered
Authentication-Results: gw-in-02.mailgate.ycn.internal;
 spf=pass smtp.mailfrom=it-support@{$lookalike};
 dkim=pass header.d={$lookalike};
 dmarc=none header.from={$lookalike}
From: "Layanan TI Kampus" <it-support@{$lookalike}>
To: {$victim}
Reply-To: helpdesk@{$lookalike}
Subject: [Tindakan Diperlukan] Verifikasi ulang akses SSO Anda sebelum 3 Nov 2026 12:00
Date: Tue, 3 Nov 2026 08:12:39 +0700
Message-ID: <RFC-20261103-011244.4a1f@{$lookalike}>
MIME-Version: 1.0
Content-Type: multipart/alternative;
 boundary="b1_9f2c4e7a"
X-Mailer: PHP/8.1.2
X-Priority: 1

--b1_9f2c4e7a
Content-Type: text/plain; charset="utf-8"
Content-Transfer-Encoding: quoted-printable

Yth. Bapak/Ibu,

Sehubungan dengan pemeliharaan SSO kampus pada 3 November 2026, seluruh
staf diminta melakukan verifikasi ulang akun. Akun yang belum diverifikasi
sebelum pukul 12.00 WIB akan dinonaktifkan sementara.

Verifikasi sekarang:
https://sso.{$lookalike}/verify?u=nadia.permata%40{$dom}&c=YCN

Jika Anda tidak merasa meminta verifikasi, abaikan pesan ini.

Hormat kami,
Layanan TI Kampus
--b1_9f2c4e7a
Content-Type: text/html; charset="utf-8"
Content-Transfer-Encoding: quoted-printable

<html><body style=3D"font-family:Arial,sans-serif">
<p>Yth. Bapak/Ibu,</p>
<p>Sehubungan dengan pemeliharaan SSO kampus pada 3 November 2026, seluruh
staf diminta melakukan verifikasi ulang akun. Akun yang belum diverifikasi
sebelum pukul 12.00 WIB akan dinonaktifkan sementara.</p>
<p><a href=3D"https://sso.{$lookalike}/verify?u=3Dnadia.permata%40{$dom}&amp;c=3DYCN"
 style=3D"background:#0b5;color:#fff;padding:10px 18px;text-decoration:none">
Verifikasi Sekarang</a></p>
<p style=3D"color:#777;font-size:11px">Layanan TI Kampus - pesan otomatis,
jangan dibalas.</p>
</body></html>
--b1_9f2c4e7a--
EML;
    put($base . '/artifacts/email/MSG-20261103-0042.eml', $eml);

    // --------------------------------------------------------- MAIL GATEWAY
    $gw = [];
    $gw[] = ['gw_event_id' => 'GW-20261102-0701', 'ts' => '2026-11-02T07:55:02+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261102-0101', 'rfc_message_id' => '<RFC-20261102-005502.11ac@' . $dom . '>', 'from' => 'pengumuman@' . $dom, 'from_ip' => '192.0.2.31', 'to' => ['all-staff@' . $dom], 'subject' => 'Jadwal Pemeliharaan SSO 3 November 2026', 'verdict' => 'delivered', 'spf' => 'pass', 'dkim' => 'pass', 'dmarc' => 'pass', 'action' => 'none', 'size_bytes' => 48120, 'attachment_count' => 0, 'url_count' => 2, 'url_verdict' => 'internal_domain'];
    $gw[] = ['gw_event_id' => 'GW-20261102-1411', 'ts' => '2026-11-02T14:20:11+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261102-0118', 'rfc_message_id' => '<RFC-20261102-142003.77b1@keamanan.' . $dom . '>', 'from' => 'simulasi@keamanan.' . $dom, 'from_ip' => '192.0.2.40', 'to' => [$victim, 'sari.dewi@' . $dom, 'agus.pratama@' . $dom], 'subject' => '[LATIHAN KEAMANAN] Uji kebiasaan login Anda minggu ini', 'verdict' => 'delivered', 'spf' => 'pass', 'dkim' => 'pass', 'dmarc' => 'pass', 'action' => 'allowlist:awareness_campaign', 'size_bytes' => 22410, 'attachment_count' => 0, 'url_count' => 1, 'url_verdict' => 'internal_domain', 'header_x_awareness_campaign' => 'SIM-2026-11'];
    $gw[] = ['gw_event_id' => 'GW-20261102-1502', 'ts' => '2026-11-02T15:02:39+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261102-0121', 'rfc_message_id' => '<RFC-20261102-150233.902e@vendor-contoh.test>', 'from' => 'invoice@vendor-contoh.test', 'from_ip' => '203.0.113.9', 'to' => ['keuangan@' . $dom], 'subject' => 'Invoice INV-2026-1188 November', 'verdict' => 'delivered', 'spf' => 'pass', 'dkim' => 'pass', 'dmarc' => 'pass', 'action' => 'none', 'size_bytes' => 182004, 'attachment_count' => 1, 'url_count' => 0, 'url_verdict' => 'n/a'];
    $gw[] = ['gw_event_id' => 'GW-20261102-1611', 'ts' => '2026-11-02T16:11:20+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261102-0126', 'rfc_message_id' => '<RFC-20261102-161100.3c7d@promo.example-bonus.invalid>', 'from' => 'promo@example-bonus.invalid', 'from_ip' => '203.0.113.210', 'to' => ['all-staff@' . $dom], 'subject' => 'Bonus akhir tahun untuk staf', 'verdict' => 'blocked', 'spf' => 'fail', 'dkim' => 'none', 'dmarc' => 'fail', 'action' => 'quarantine_rule:PHISH-0021', 'size_bytes' => 90211, 'attachment_count' => 1, 'url_count' => 4, 'url_verdict' => 'blocked_list'];
    $gw[] = ['gw_event_id' => 'GW-20261103-0812', 'ts' => '2026-11-03T08:12:44+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261103-0042', 'rfc_message_id' => '<RFC-20261103-011244.4a1f@' . $lookalike . '>', 'from' => 'it-support@' . $lookalike, 'from_ip' => $attackerIp, 'to' => [$victim], 'subject' => '[Tindakan Diperlukan] Verifikasi ulang akses SSO Anda sebelum 3 Nov 2026 12:00', 'verdict' => 'delivered', 'spf' => 'pass', 'dkim' => 'pass', 'dmarc' => 'none', 'action' => 'none', 'size_bytes' => 8412, 'attachment_count' => 0, 'url_count' => 1, 'url_verdict' => 'unrated:domain_age_3d'];
    $gw[] = ['gw_event_id' => 'GW-20261103-0813', 'ts' => '2026-11-03T08:13:02+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261103-0043', 'rfc_message_id' => '<RFC-20261103-011244.9b02@' . $lookalike . '>', 'from' => 'it-support@' . $lookalike, 'from_ip' => $attackerIp, 'to' => ['sari.dewi@' . $dom], 'subject' => '[Tindakan Diperlukan] Verifikasi ulang akses SSO Anda sebelum 3 Nov 2026 12:00', 'verdict' => 'delivered', 'spf' => 'pass', 'dkim' => 'pass', 'dmarc' => 'none', 'action' => 'none', 'size_bytes' => 8409, 'attachment_count' => 0, 'url_count' => 1, 'url_verdict' => 'unrated:domain_age_3d'];
    $gw[] = ['gw_event_id' => 'GW-20261103-0821', 'ts' => '2026-11-03T08:21:14+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261103-0047', 'rfc_message_id' => '<RFC-20261103-012109.c001@perpustakaan.' . $dom . '>', 'from' => 'notifikasi@perpustakaan.' . $dom, 'from_ip' => '192.0.2.33', 'to' => [$victim], 'subject' => 'Pengingat pengembalian buku', 'verdict' => 'delivered', 'spf' => 'pass', 'dkim' => 'pass', 'dmarc' => 'pass', 'action' => 'none', 'size_bytes' => 15330, 'attachment_count' => 0, 'url_count' => 1, 'url_verdict' => 'internal_domain'];
    $gw[] = ['gw_event_id' => 'GW-20261103-0840', 'ts' => '2026-11-03T08:40:15+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261103-0051', 'rfc_message_id' => '<RFC-20261103-084008.7f10@' . $dom . '>', 'from' => 'komunikasi@' . $dom, 'from_ip' => '192.0.2.31', 'to' => ['all-staff@' . $dom], 'subject' => 'Buletin internal November 2026', 'verdict' => 'delivered', 'spf' => 'pass', 'dkim' => 'pass', 'dmarc' => 'pass', 'action' => 'none', 'size_bytes' => 61002, 'attachment_count' => 0, 'url_count' => 6, 'url_verdict' => 'internal_domain'];
    $gw[] = ['record_type' => 'export_metadata', 'gw_event_id' => 'GW-EXPORT-HEADER', 'ts' => '2026-11-03T09:21:00+07:00', 'window_start' => '2026-11-02T00:00:00+07:00', 'window_end' => '2026-11-04T23:59:59+07:00', 'note' => 'Rotasi log 2026-11-03 09:20:07 WIB. Segmen 2026-11-03 09:16:00-09:20:07 WIB hilang saat rotasi (berkas segmen rusak) dan tidak dapat direkonstruksi dari arsip dingin.', 'exported_by' => 'gateway-admin'];
    $gw[] = ['gw_event_id' => 'GW-20261103-0922', 'ts' => '2026-11-03T09:22:10+07:00', 'direction' => 'outbound', 'message_id' => 'MSG-20261103-0060', 'rfc_message_id' => '<RFC-20261103-092205.2aa1@' . $dom . '>', 'from' => 'sari.dewi@' . $dom, 'from_ip' => '192.0.2.21', 'to' => ['ar@vendor-contoh.test'], 'subject' => 'Re: Invoice INV-2026-1188 November', 'verdict' => 'delivered', 'spf' => 'pass', 'dkim' => 'pass', 'dmarc' => 'pass', 'action' => 'none', 'size_bytes' => 74210, 'attachment_count' => 1, 'url_count' => 0, 'url_verdict' => 'n/a'];
    $gw[] = ['gw_event_id' => 'GW-20261103-1002', 'ts' => '2026-11-03T10:02:31+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261103-0070', 'rfc_message_id' => '<RFC-20261103-025501.5d33@files.example-share.invalid>', 'from' => 'share@files.example-share.invalid', 'from_ip' => '203.0.113.91', 'to' => ['agus.pratama@' . $dom], 'subject' => 'Dokumen rapat (ZIP)', 'verdict' => 'blocked', 'spf' => 'fail', 'dkim' => 'none', 'dmarc' => 'fail', 'action' => 'blocked_attachment:ZIP', 'size_bytes' => 211477, 'attachment_count' => 1, 'url_count' => 1, 'url_verdict' => 'blocked_list'];
    $gw[] = ['gw_event_id' => 'GW-20261104-0658', 'ts' => '2026-11-04T06:58:12+07:00', 'direction' => 'inbound', 'message_id' => 'MSG-20261104-0012', 'rfc_message_id' => '<RFC-20261104-065804.81c2@' . $lookalike . '>', 'from' => 'it-support@' . $lookalike, 'from_ip' => $attackerIp, 'to' => ['budi.hartono@' . $dom], 'subject' => 'Verifikasi ulang akses SSO (pengingat)', 'verdict' => 'blocked', 'spf' => 'pass', 'dkim' => 'fail', 'dmarc' => 'none', 'action' => 'blocked_rule:BLK-1103-01', 'size_bytes' => 8390, 'attachment_count' => 0, 'url_count' => 1, 'url_verdict' => 'blocked_list'];
    $body = '';
    foreach ($gw as $r) {
        $body .= jline($r);
    }
    put($base . '/artifacts/email/mailgateway-20261102_20261104.jsonl', $body);

    // ------------------------------------------------------------- SSO SIGN-IN
    $si = [];
    $mk = function (string $id, string $ts, string $user, string $uid, string $app, string $method, string $result, string $reason, string $ip, string $geo, string $device, string $trust, ?string $sid, string $req, string $ua) use ($dom): array {
        return ['event_id' => $id, 'ts' => $ts, 'tenant' => 'ycn-prod', 'user' => $user, 'user_id' => $uid, 'app' => $app, 'auth_method' => $method, 'result' => $result, 'reason' => $reason, 'src_ip' => $ip, 'geo' => $geo, 'device_id' => $device, 'device_trust' => $trust, 'session_id' => $sid, 'request_id' => $req, 'client_user_agent' => $ua];
    };

    // Normal activity, 1 Nov.
    $si[] = $mk('IDP-20261101-0031', '2026-11-01T00:41:12Z', $victim, $victimId, 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', $dev, 'registered', 'SID-7a10c3e2-55bd-4f0a-9a11-2c7d4b8e1101', 'req-1a2b31', $uaChrome);
    $si[] = $mk('IDP-20261101-0037', '2026-11-01T00:42:05Z', 'sari.dewi@' . $dom, 'USR-10388', 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', 'DEV-2b88c1', 'registered', 'SID-1c02bb31-8d4a-4c55-b0a1-7e9f2a6c1102', 'req-1a2b3c', $uaEdge);
    $si[] = $mk('IDP-20261101-0203', '2026-11-01T02:03:44Z', 'agus.pratama@' . $dom, 'USR-10503', 'SIAKAD', 'totp', 'success', '', $campusIp, 'ID', 'DEV-9d31aa', 'registered', 'SID-33aa77d0-2c1e-4b6a-8f0d-1a2b3c4d1103', 'req-1a2b3d', $uaChrome);
    // Normal, 2 Nov (Monday).
    $si[] = $mk('IDP-20261102-0012', '2026-11-02T00:33:51Z', $victim, $victimId, 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', $dev, 'registered', 'SID-5e11ab90-77c2-4b31-9d4e-8a0b1c2d1104', 'req-2b3c41', $uaChrome);
    $si[] = $mk('IDP-20261102-0018', '2026-11-02T00:41:07Z', 'budi.hartono@' . $dom, 'USR-10021', 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', 'DEV-4f10ee', 'registered', 'SID-9c22de10-3a4b-4c5d-8e6f-7a8b9c0d1105', 'req-2b3c42', $uaEdge);
    $si[] = $mk('IDP-20261102-0144', '2026-11-02T02:44:19Z', 'sari.dewi@' . $dom, 'USR-10388', 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', 'DEV-2b88c1', 'registered', 'SID-1c02bb31-8d4a-4c55-b0a1-7e9f2a6c1106', 'req-2b3c43', $uaEdge);
    $si[] = $mk('IDP-20261102-0311', '2026-11-02T03:11:28Z', 'agus.pratama@' . $dom, 'USR-10503', 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', 'DEV-9d31aa', 'registered', 'SID-33aa77d0-2c1e-4b6a-8f0d-1a2b3c4d1107', 'req-2b3c44', $uaChrome);
    $si[] = $mk('IDP-20261102-0600', '2026-11-02T06:00:12Z', $victim, $victimId, 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', $dev, 'registered', 'SID-6f23bc01-88d3-4c42-ae5f-9b1c2d3e1108', 'req-2b3c45', $uaChrome);
    // 3 Nov - attack window.
    $si[] = $mk('IDP-20261103-0081', '2026-11-03T00:52:38Z', $victim, $victimId, 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', $dev, 'registered', 'SID-4d10aa22-1b2c-4d3e-9f40-5a6b7c8d1109', 'req-3c4d51', $uaChrome);
    $si[] = $mk('IDP-20261103-0088', '2026-11-03T01:20:04Z', 'sari.dewi@' . $dom, 'USR-10388', 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', 'DEV-2b88c1', 'registered', 'SID-1c02bb31-8d4a-4c55-b0a1-7e9f2a6c1110', 'req-3c4d52', $uaEdge);
    $si[] = $mk('IDP-20261103-0090', '2026-11-03T02:08:03Z', $victim, $victimId, 'YCN-SSO', 'push', 'failure', 'mfa_denied', $attackerIp, 'SG', 'dev-unregistered-9b2e', 'unregistered', null, 'req-9a11c0', $uaChrome);
    $si[] = $mk('IDP-20261103-0091', '2026-11-03T02:08:57Z', $victim, $victimId, 'YCN-SSO', 'push', 'failure', 'mfa_timeout', $attackerIp, 'SG', 'dev-unregistered-9b2e', 'unregistered', null, 'req-9a11c1', $uaChrome);
    $si[] = $mk('IDP-20261103-0092', '2026-11-03T02:10:44Z', $victim, $victimId, 'YCN-SSO', 'push', 'failure', 'mfa_denied', $attackerIp, 'SG', 'dev-unregistered-9b2e', 'unregistered', null, 'req-9a11c2', $uaChrome);
    $si[] = $mk('IDP-20261103-0093', '2026-11-03T02:11:05Z', $victim, $victimId, 'YCN-SSO', 'totp', 'success', '', $attackerIp, 'SG', 'dev-unregistered-9b2e', 'unregistered', 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'req-9a11c3', $uaChrome);
    $si[] = $mk('IDP-20261103-0094', '2026-11-03T02:14:22Z', $victim, $victimId, 'YCN-Mail', 'session_reuse', 'success', '', $attackerIp, 'SG', 'dev-unregistered-9b2e', 'unregistered', 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'req-9a11c4', $uaChrome);
    $si[] = $mk('IDP-20261103-0098', '2026-11-03T02:36:51Z', $victim, $victimId, 'YCN-Drive', 'session_reuse', 'success', '', $attackerIp, 'SG', 'dev-unregistered-9b2e', 'unregistered', 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'req-9a11c5', $uaChrome);
    // Containment.
    $si[] = $mk('IDP-20261103-0101', '2026-11-03T02:44:31Z', $victim, $victimId, 'YCN-SSO', 'n/a', 'failure', 'account_disabled', $campusIp, 'ID', 'dev-admin-console', 'n/a', null, 'req-9a11d0', 'admin-console/2026.3');
    $si[] = $mk('IDP-20261103-0104', '2026-11-03T02:47:31Z', $victim, $victimId, 'YCN-SSO', 'password', 'failure', 'account_disabled', '203.0.113.55', 'SG', 'dev-unregistered-9b2e', 'unregistered', null, 'req-9a11c6', $uaChrome);
    $si[] = $mk('IDP-20261103-0108', '2026-11-03T02:52:40Z', $victim, $victimId, 'YCN-SSO', 'n/a', 'success', 'sessions_revoked', $campusIp, 'ID', 'dev-admin-console', 'n/a', null, 'req-9a11d1', 'admin-console/2026.3');
    $si[] = $mk('IDP-20261103-0121', '2026-11-03T03:12:44Z', $victim, $victimId, 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', $dev, 'registered', 'SID-8b31ee44-2c3d-4e5f-a061-7b8c9d0e1111', 'req-3c4d60', $uaChrome);
    $si[] = $mk('IDP-20261104-0044', '2026-11-04T01:20:19Z', $victim, $victimId, 'YCN-SSO', 'password', 'failure', 'invalid_password', $attackerIp, 'SG', 'dev-unregistered-9b2e', 'unregistered', null, 'req-9a11c7', $uaChrome);
    $si[] = $mk('IDP-20261104-0046', '2026-11-04T01:21:02Z', 'budi.hartono@' . $dom, 'USR-10021', 'YCN-Mail', 'push', 'success', '', $campusIp, 'ID', 'DEV-4f10ee', 'registered', 'SID-9c22de10-3a4b-4c5d-8e6f-7a8b9c0d1112', 'req-4d5e61', $uaEdge);
    $body = '';
    foreach ($si as $r) {
        $body .= jline($r);
    }
    put($base . '/artifacts/identity/idp-signin-20261101_20261104.jsonl', $body);

    // ------------------------------------------------------------ MAILBOX AUDIT
    $ma = [];
    $ma[] = ['audit_id' => 'MBOX-20261103-0201', 'ts' => '2026-11-03T02:11:05Z', 'operation' => 'MailboxLogin', 'mailbox' => $victim, 'actor' => $victim, 'actor_ip' => $attackerIp, 'session_id' => 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'result' => 'Success', 'parameters' => ['ClientAppId' => 'YCN-Mail/2026.10', 'LogonType' => 'Owner']];
    $ma[] = ['audit_id' => 'MBOX-20261103-0210', 'ts' => '2026-11-03T02:16:40Z', 'operation' => 'New-InboxRule', 'mailbox' => $victim, 'actor' => $victim, 'actor_ip' => $attackerIp, 'session_id' => 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'result' => 'Success', 'parameters' => ['Name' => 'RSS-Sync', 'ForwardTo' => 'arsip.akun@' . $lookalike, 'DeleteMessage' => false, 'MarkAsRead' => true, 'StopProcessing' => true, 'SubjectContainsWords' => '']];
    $ma[] = ['audit_id' => 'MBOX-20261103-0214', 'ts' => '2026-11-03T02:19:02Z', 'operation' => 'MailboxLogin', 'mailbox' => 'keuangan@' . $dom, 'actor' => $victim, 'actor_ip' => $attackerIp, 'session_id' => 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'result' => 'Success', 'parameters' => ['ClientAppId' => 'YCN-Mail/2026.10', 'LogonType' => 'Delegate']];
    $ma[] = ['audit_id' => 'MBOX-20261103-0216', 'ts' => '2026-11-03T02:19:40Z', 'operation' => 'MailItemsAccessed', 'mailbox' => 'keuangan@' . $dom, 'actor' => $victim, 'actor_ip' => $attackerIp, 'session_id' => 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'result' => 'Success', 'parameters' => ['MailAccessType' => 'Bind', 'FolderPath' => '\\Inbox', 'ItemCount' => 14]];
    $ma[] = ['audit_id' => 'MBOX-20261103-0219', 'ts' => '2026-11-03T02:22:13Z', 'operation' => 'MailItemsAccessed', 'mailbox' => 'keuangan@' . $dom, 'actor' => $victim, 'actor_ip' => $attackerIp, 'session_id' => 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'result' => 'Success', 'parameters' => ['MailAccessType' => 'Bind', 'FolderPath' => '\\Inbox\\Approval', 'ItemCount' => 23]];
    $ma[] = ['audit_id' => 'MBOX-20261103-0222', 'ts' => '2026-11-03T02:26:51Z', 'operation' => 'MailItemsAccessed', 'mailbox' => $victim, 'actor' => $victim, 'actor_ip' => $attackerIp, 'session_id' => 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'result' => 'Success', 'parameters' => ['MailAccessType' => 'Sync', 'FolderPath' => '\\Inbox', 'ItemCount' => 38]];
    $ma[] = ['audit_id' => 'MBOX-20261103-0231', 'ts' => '2026-11-03T02:31:12Z', 'operation' => 'SendAs', 'mailbox' => 'keuangan@' . $dom, 'actor' => $victim, 'actor_ip' => $attackerIp, 'session_id' => 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'result' => 'Failed', 'parameters' => ['Error' => 'AccessDenied', 'Recipients' => ['vendor-contoh.test']]];
    $ma[] = ['audit_id' => 'MBOX-20261103-0237', 'ts' => '2026-11-03T02:37:50Z', 'operation' => 'New-InboxRule', 'mailbox' => 'keuangan@' . $dom, 'actor' => $victim, 'actor_ip' => $attackerIp, 'session_id' => 'SID-3f81c2a4-6a12-4e77-9c0b-1d5e2f7a8b90', 'result' => 'Success', 'parameters' => ['Name' => 'RSS-Sync', 'ForwardTo' => 'arsip.akun@' . $lookalike, 'DeleteMessage' => false, 'MarkAsRead' => true, 'StopProcessing' => true]];
    $ma[] = ['audit_id' => 'MBOX-20261103-0244', 'ts' => '2026-11-03T02:44:31Z', 'operation' => 'Set-Mailbox', 'mailbox' => $victim, 'actor' => 'budi.hartono@' . $dom, 'actor_ip' => '192.0.2.21', 'session_id' => null, 'result' => 'Success', 'parameters' => ['AccountDisabled' => true, 'Reason' => 'INC-2026-1103-014']];
    $ma[] = ['audit_id' => 'MBOX-20261103-0248', 'ts' => '2026-11-03T02:48:02Z', 'operation' => 'Remove-InboxRule', 'mailbox' => $victim, 'actor' => 'budi.hartono@' . $dom, 'actor_ip' => '192.0.2.21', 'session_id' => null, 'result' => 'Success', 'parameters' => ['RuleName' => 'RSS-Sync']];
    $ma[] = ['audit_id' => 'MBOX-20261103-0249', 'ts' => '2026-11-03T02:48:36Z', 'operation' => 'Remove-InboxRule', 'mailbox' => 'keuangan@' . $dom, 'actor' => 'budi.hartono@' . $dom, 'actor_ip' => '192.0.2.21', 'session_id' => null, 'result' => 'Success', 'parameters' => ['RuleName' => 'RSS-Sync']];
    $ma[] = ['audit_id' => 'MBOX-20261103-0252', 'ts' => '2026-11-03T02:52:07Z', 'operation' => 'ResetPassword', 'mailbox' => $victim, 'actor' => 'budi.hartono@' . $dom, 'actor_ip' => '192.0.2.21', 'session_id' => null, 'result' => 'Success', 'parameters' => ['ResetMethod' => 'admin_console', 'MfaReenrollRequired' => true]];
    $ma[] = ['audit_id' => 'MBOX-20261103-0254', 'ts' => '2026-11-03T02:52:40Z', 'operation' => 'RevokeSessions', 'mailbox' => $victim, 'actor' => 'budi.hartono@' . $dom, 'actor_ip' => '192.0.2.21', 'session_id' => null, 'result' => 'Success', 'parameters' => ['RevokedSessionCount' => 2, 'Cause' => 'INC-2026-1103-014']];
    $ma[] = ['audit_id' => 'MBOX-20261103-0305', 'ts' => '2026-11-03T03:05:22Z', 'operation' => 'MailboxLogin', 'mailbox' => $victim, 'actor' => $victim, 'actor_ip' => $campusIp, 'session_id' => 'SID-8b31ee44-2c3d-4e5f-a061-7b8c9d0e1111', 'result' => 'Success', 'parameters' => ['ClientAppId' => 'YCN-Mail/2026.10', 'LogonType' => 'Owner']];
    $ma[] = ['audit_id' => 'MBOX-20261103-0306', 'ts' => '2026-11-03T03:06:10Z', 'operation' => 'MailItemsAccessed', 'mailbox' => $victim, 'actor' => $victim, 'actor_ip' => $campusIp, 'session_id' => 'SID-8b31ee44-2c3d-4e5f-a061-7b8c9d0e1111', 'result' => 'Success', 'parameters' => ['MailAccessType' => 'Bind', 'FolderPath' => '\\Inbox', 'ItemCount' => 9]];
    $ma[] = ['audit_id' => 'MBOX-20261103-0310', 'ts' => '2026-11-03T03:10:38Z', 'operation' => 'Set-Mailbox', 'mailbox' => $victim, 'actor' => 'budi.hartono@' . $dom, 'actor_ip' => '192.0.2.21', 'session_id' => null, 'result' => 'Success', 'parameters' => ['AccountDisabled' => false, 'Reason' => 'INC-2026-1103-014 pemulihan setelah reset']];
    $ma[] = ['audit_id' => 'MBOX-20261103-0311', 'ts' => '2026-11-03T03:11:04Z', 'operation' => 'Send', 'mailbox' => $victim, 'actor' => $victim, 'actor_ip' => $campusIp, 'session_id' => 'SID-8b31ee44-2c3d-4e5f-a061-7b8c9d0e1111', 'result' => 'Success', 'parameters' => ['Recipients' => ['keamanan@' . $dom], 'Subject' => 'Laporan insiden akun saya']];
    $body = '';
    foreach ($ma as $r) {
        $body .= jline($r);
    }
    put($base . '/artifacts/identity/mailbox-audit-20261103.jsonl', $body);

    // --------------------------------------------------------- BROWSER HISTORY
    $visits = [];
    $addVisit = function (string $id, string $ts, string $url, string $title, string $transition, string $referrer, int $dur) use (&$visits): void {
        $visits[] = ['visit_id' => $id, 'ts' => $ts, 'url' => $url, 'title' => $title, 'transition' => $transition, 'referrer' => $referrer, 'duration_ms' => $dur, 'browser' => 'Chrome 126.0.6478.127', 'profile' => 'Default'];
    };
    $addVisit('VIS-0001', '2026-11-02T14:05:12+07:00', 'https://mail.' . $dom . '/owa/', 'Surel Kampus - Kotak Masuk', 'TYPED', '', 96400);
    $addVisit('VIS-0002', '2026-11-02T16:03:11+07:00', 'https://latihan-keamanan.' . $dom . '/kampanye/sim-2026-11?p=' . urlencode($victim), 'Latihan Keamanan - Kampus Cendekia', 'LINK', 'https://mail.' . $dom . '/owa/', 41200);
    $addVisit('VIS-0003', '2026-11-02T16:03:55+07:00', 'https://latihan-keamanan.' . $dom . '/kampanye/sim-2026-11/selesai', 'Terima kasih - Latihan Keamanan', 'LINK', 'https://latihan-keamanan.' . $dom . '/kampanye/sim-2026-11?p=' . urlencode($victim), 8100);
    $addVisit('VIS-0004', '2026-11-02T16:05:02+07:00', 'https://mail.' . $dom . '/owa/', 'Surel Kampus - Kotak Masuk', 'LINK', 'https://latihan-keamanan.' . $dom . '/kampanye/sim-2026-11/selesai', 15200);
    $addVisit('VIS-0005', '2026-11-03T08:47:03+07:00', 'https://intranet.' . $dom . '/akademik/jadwal', 'Jadwal Akademik - Intranet', 'TYPED', '', 128900);
    $addVisit('VIS-0006', '2026-11-03T09:05:40+07:00', 'https://mail.' . $dom . '/owa/', 'Surel Kampus - Kotak Masuk', 'TYPED', '', 42800);
    $addVisit('VIS-0007', '2026-11-03T09:06:31+07:00', 'https://sso.' . $lookalike . '/verify?u=' . urlencode($victim) . '&c=YCN', 'Verifikasi Akun - SSO Kampus', 'LINK', 'https://mail.' . $dom . '/owa/', 62400);
    $addVisit('VIS-0008', '2026-11-03T09:07:02+07:00', 'https://sso.' . $lookalike . '/verify/step2', 'Verifikasi Akun - Langkah 2 dari 2', 'LINK', 'https://sso.' . $lookalike . '/verify?u=' . urlencode($victim) . '&c=YCN', 141800);
    $addVisit('VIS-0009', '2026-11-03T09:11:18+07:00', 'https://sso.' . $lookalike . '/verify/success', 'Verifikasi Berhasil', 'LINK', 'https://sso.' . $lookalike . '/verify/step2', 4600);
    $addVisit('VIS-0010', '2026-11-03T09:12:03+07:00', 'https://' . $idp . '/', 'SSO Kampus Cendekia', 'LINK', 'https://sso.' . $lookalike . '/verify/success', 22000);
    $addVisit('VIS-0011', '2026-11-03T09:14:22+07:00', 'https://mail.' . $dom . '/owa/', 'Surel Kampus - Kotak Masuk', 'LINK', 'https://' . $idp . '/', 118400);
    $addVisit('VIS-0012', '2026-11-03T09:31:40+07:00', 'https://intranet.' . $dom . '/akademik/berita', 'Berita Akademik - Intranet', 'TYPED', '', 33200);
    $addVisit('VIS-0013', '2026-11-03T10:20:12+07:00', 'https://mail.' . $dom . '/owa/', 'Surel Kampus - Sesi berakhir', 'TYPED', '', 7200);
    $browserDoc = [
        'host' => $host,
        'user' => $victim,
        'collected_at' => '2026-11-03T14:00:00+07:00',
        'source' => 'Chrome History export (read-only copy)',
        'timezone' => 'Asia/Jakarta (UTC+07:00)',
        'note' => 'Riwayat hanya memuat kunjungan yang tercatat; tidak memuat isi formulir atau nilai yang diketik pengguna.',
        'visits' => $visits,
    ];
    put($base . '/artifacts/endpoint/' . $host . '-browser-history.json', jdoc($browserDoc));

    // ------------------------------------------------------------------- EDR
    $edr = [];
    $edr[] = ['event_id' => 'EDR-20261103-0401', 'ts' => '2026-11-03T08:58:02+07:00', 'host' => $host, 'user' => $victim, 'category' => 'process_start', 'process' => 'OUTLOOK.EXE', 'pid' => 6120, 'ppid' => 4412, 'cmdline' => '"C:\\Program Files\\Microsoft Office\\root\\Office16\\OUTLOOK.EXE"', 'sha256' => rec_hash('outlook.exe|16.0.17928.20156'), 'signature' => 'Valid:Microsoft Corporation'];
    $edr[] = ['event_id' => 'EDR-20261103-0402', 'ts' => '2026-11-03T09:05:31+07:00', 'host' => $host, 'user' => $victim, 'category' => 'process_start', 'process' => 'chrome.exe', 'pid' => 8844, 'ppid' => 4412, 'cmdline' => '"C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe" --profile-directory=Default', 'sha256' => rec_hash('chrome.exe|126.0.6478.127'), 'signature' => 'Valid:Google LLC'];
    $edr[] = ['event_id' => 'EDR-20261103-0403', 'ts' => '2026-11-03T09:06:20+07:00', 'host' => $host, 'user' => $victim, 'category' => 'dns_query', 'process' => 'chrome.exe', 'pid' => 8844, 'query' => 'sso.' . $lookalike, 'answer' => [$attackerIp], 'dns_server' => '192.0.2.53'];
    $edr[] = ['event_id' => 'EDR-20261103-0404', 'ts' => '2026-11-03T09:06:44+07:00', 'host' => $host, 'user' => $victim, 'category' => 'network_connect', 'process' => 'chrome.exe', 'pid' => 8844, 'remote_ip' => $attackerIp, 'remote_port' => 443, 'protocol' => 'tcp', 'sni' => 'sso.' . $lookalike, 'bytes_in' => 84211, 'bytes_out' => 9402];
    $edr[] = $edr[3];
    $edr[4]['event_id'] = 'EDR-20261103-0405';
    $edr[4]['ts'] = '2026-11-03T09:07:02+07:00';
    $edr[4]['bytes_in'] = 51220;
    $edr[4]['bytes_out'] = 1044;
    $edr[] = $edr[3];
    $edr[5]['event_id'] = 'EDR-20261103-0406';
    $edr[5]['ts'] = '2026-11-03T09:11:05+07:00';
    $edr[5]['bytes_in'] = 3120;
    $edr[5]['bytes_out'] = 4210;
    $edr[] = ['event_id' => 'EDR-20261103-0407', 'ts' => '2026-11-03T09:12:03+07:00', 'host' => $host, 'user' => $victim, 'category' => 'network_connect', 'process' => 'chrome.exe', 'pid' => 8844, 'remote_ip' => '192.0.2.32', 'remote_port' => 443, 'protocol' => 'tcp', 'sni' => $idp, 'bytes_in' => 22140, 'bytes_out' => 3302];
    $edr[] = ['event_id' => 'EDR-20261103-0408', 'ts' => '2026-11-03T09:18:41+07:00', 'host' => $host, 'user' => $victim, 'category' => 'file_write', 'process' => 'OUTLOOK.EXE', 'path' => 'C:\\Users\\nadia.permata\\AppData\\Local\\Microsoft\\Outlook\\nadia.permata.ost', 'bytes' => 4096];
    $edr[] = ['event_id' => 'EDR-20261103-0409', 'ts' => '2026-11-03T09:20:11+07:00', 'host' => $host, 'user' => $victim, 'category' => 'process_start', 'process' => 'SearchProtocolHost.exe', 'pid' => 9012, 'ppid' => 780, 'cmdline' => 'SearchProtocolHost.exe -Embedding', 'sha256' => rec_hash('searchprotocolhost.exe|10.0.19041.3636'), 'signature' => 'Valid:Microsoft Corporation'];
    // False-lead candidate: legitimate IT patch script on a different host.
    $edr[] = ['event_id' => 'EDR-20261103-0420', 'ts' => '2026-11-03T09:58:27+07:00', 'host' => 'WS-IT-002', 'user' => 'budi.hartono', 'category' => 'process_start', 'process' => 'powershell.exe', 'pid' => 3311, 'ppid' => 2280, 'cmdline' => 'powershell.exe -NoProfile -ExecutionPolicy Bypass -File C:\\IT\\patch\\2026-11-kb-check.ps1 -Quiet', 'sha256' => rec_hash('powershell.exe|10.0.19041.3636'), 'signature' => 'Valid:Microsoft Corporation'];
    $edr[] = ['event_id' => 'EDR-20261103-0421', 'ts' => '2026-11-03T09:58:29+07:00', 'host' => 'WS-IT-002', 'user' => 'budi.hartono', 'category' => 'script_block', 'process' => 'powershell.exe', 'pid' => 3311, 'script_path' => 'C:\\IT\\patch\\2026-11-kb-check.ps1', 'script_sha256' => rec_hash('2026-11-kb-check.ps1|v3'), 'signature' => 'Valid:Cendekia Nusantara IT Ops', 'block_chars' => 1840];
    $edr[] = ['event_id' => 'EDR-20261103-0431', 'ts' => '2026-11-03T10:06:44+07:00', 'host' => $host, 'user' => $victim, 'category' => 'process_start', 'process' => 'OneDrive.exe', 'pid' => 7744, 'ppid' => 4412, 'cmdline' => '"C:\\Users\\nadia.permata\\AppData\\Local\\Microsoft\\OneDrive\\OneDrive.exe" /background', 'sha256' => rec_hash('onedrive.exe|24.151.0728.0003'), 'signature' => 'Valid:Microsoft Corporation'];
    $body = '';
    foreach ($edr as $r) {
        $body .= jline($r);
    }
    put($base . '/artifacts/endpoint/' . $host . '-edr-20261103.jsonl', $body);

    // ----------------------------------------------------------------- TICKETS
    $t = [];
    $t[] = ['ticket_id' => 'INC-2026-1102-021', 'ts_created' => '2026-11-02T16:22:41+07:00', 'channel' => 'portal', 'requester' => $victim, 'assignee' => 'budi.hartono', 'category' => 'security_awareness', 'summary' => 'Email "Uji kebiasaan login" - apakah ini resmi?', 'description' => 'Staf menerima email [LATIHAN KEAMANAN], mengklik tautan, dan sampai di halaman yang meminta konfirmasi keikutsertaan. Staf ingin memastikan ini bukan phishing.', 'resolution' => 'Dikonfirmasi kampanye internal SIM-2026-11 oleh Unit Keamanan. Tidak ada permintaan kredensial pada halaman kampanye.', 'ts_resolved' => '2026-11-02T16:40:00+07:00', 'related_ci' => 'CAMPAIGN-SIM-2026-11', 'related_event' => ''];
    $t[] = ['ticket_id' => 'INC-2026-1103-011', 'ts_created' => '2026-11-03T07:52:14+07:00', 'channel' => 'phone', 'requester' => 'agus.pratama@' . $dom, 'assignee' => 'budi.hartono', 'category' => 'printer', 'summary' => 'Printer lantai 3 tidak ditemukan', 'description' => 'Antrean cetak hilang setelah update driver.', 'resolution' => 'Driver diinstal ulang. Selesai.', 'ts_resolved' => '2026-11-03T08:31:00+07:00', 'related_ci' => 'PRN-AKD-03', 'related_event' => ''];
    $t[] = ['ticket_id' => 'INC-2026-1103-014', 'ts_created' => '2026-11-03T09:38:12+07:00', 'channel' => 'phone', 'requester' => $victim, 'assignee' => 'budi.hartono', 'category' => 'account_compromise', 'summary' => 'Tidak bisa login, ada notifikasi masuk yang tidak dikenal', 'description' => 'Staf membuka email "Verifikasi ulang akses SSO", mengklik tautan, lalu memasukkan password di halaman yang tampak seperti SSO kampus. Muncul notifikasi push di ponsel; staf menolak dua kali, lalu mengetikkan kode dari aplikasi authenticator pada halaman tersebut karena halaman meminta "kode verifikasi". Setelah itu muncul notifikasi masuk dari luar kota dan sesi surel berakhir sendiri.', 'resolution' => 'Akun dinonaktifkan 09:44 WIB, aturan kotak surat dihapus 09:48 WIB, reset kredensial 09:52 WIB, sesi dicabut 09:52 WIB. Pengguna diminta hadir untuk wawancara.', 'ts_resolved' => '2026-11-03T09:58:31+07:00', 'related_ci' => 'ACCT-' . $victimId, 'related_event' => 'MSG-20261103-0042'];
    $t[] = ['ticket_id' => 'INC-2026-1103-016', 'ts_created' => '2026-11-03T10:12:07+07:00', 'channel' => 'email', 'requester' => 'sari.dewi@' . $dom, 'assignee' => 'budi.hartono', 'category' => 'phishing_report', 'summary' => 'Email mencurigakan mengaku Layanan TI, domain mirip', 'description' => 'Menerima email yang sama seperti yang dilaporkan rekan Nadia. Tidak mengklik tautan karena domain pengirim tidak biasa. Melaporkan untuk pemeriksaan.', 'resolution' => 'Diteruskan ke Unit Keamanan; aturan blokir domain dibuat 10:26 WIB.', 'ts_resolved' => '2026-11-03T10:41:00+07:00', 'related_ci' => 'MAIL-FILTER', 'related_event' => 'MSG-20261103-0043'];
    $t[] = ['ticket_id' => 'REQ-2026-1103-003', 'ts_created' => '2026-11-03T11:05:22+07:00', 'channel' => 'portal', 'requester' => $victim, 'assignee' => 'budi.hartono', 'category' => 'mfa_reset', 'summary' => 'Pendaftaran ulang MFA setelah reset', 'description' => 'Pengguna meminta pendaftaran ulang aplikasi authenticator pada perangkat baru setelah insiden.', 'resolution' => 'Pendaftaran ulang selesai dengan verifikasi identitas tatap muka.', 'ts_resolved' => '2026-11-03T13:20:00+07:00', 'related_ci' => 'ACCT-' . $victimId, 'related_event' => 'INC-2026-1103-014'];
    $t[] = ['ticket_id' => 'INC-2026-1104-002', 'ts_created' => '2026-11-04T07:15:44+07:00', 'channel' => 'email', 'requester' => 'budi.hartono', 'assignee' => 'budi.hartono', 'category' => 'mail_filter', 'summary' => 'Verifikasi aturan blokir domain lookalike', 'description' => 'Memastikan aturan BLK-1103-01 aktif dan menguji dengan email masuk baru.', 'resolution' => 'Aturan aktif; satu email masuk diblokir 06:58 WIB.', 'ts_resolved' => '2026-11-04T07:40:00+07:00', 'related_ci' => 'MAIL-FILTER', 'related_event' => 'MSG-20261104-0012'];
    $body = csv_row(['ticket_id', 'ts_created', 'channel', 'requester', 'assignee', 'category', 'summary', 'description', 'resolution', 'ts_resolved', 'related_ci', 'related_event']) . "\n";
    foreach ($t as $r) {
        $body .= csv_row(array_values($r)) . "\n";
    }
    put($base . '/artifacts/service-desk/tickets-20261102_20261104.csv', $body);

    // ---------------------------------------------------------------- BASELINE
    put($base . '/baseline/README.md', <<<MD
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
MD);

    $bl = [];
    $mkb = function (string $id, string $ts, string $user, string $uid, string $app, string $ip, string $dev, string $sid, string $req, string $ua) use ($dom): array {
        return ['event_id' => $id, 'ts' => $ts, 'tenant' => 'ycn-prod', 'user' => $user, 'user_id' => $uid, 'app' => $app, 'auth_method' => 'push', 'result' => 'success', 'reason' => '', 'src_ip' => $ip, 'geo' => 'ID', 'device_id' => $dev, 'device_trust' => 'registered', 'session_id' => $sid, 'request_id' => $req, 'client_user_agent' => $ua];
    };
    $rows = [
        ['2026-10-20T00:38:11Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0001'],
        ['2026-10-20T02:11:45Z', 'sari.dewi@' . $dom, 'USR-10388', 'YCN-Mail', $campusIp, 'DEV-2b88c1', 'SID-b001-0002'],
        ['2026-10-20T04:02:33Z', 'agus.pratama@' . $dom, 'USR-10503', 'SIAKAD', '192.0.2.21', 'DEV-9d31aa', 'SID-b001-0003'],
        ['2026-10-21T00:44:52Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0004'],
        ['2026-10-21T01:19:08Z', 'budi.hartono@' . $dom, 'USR-10021', 'YCN-Mail', $campusIp, 'DEV-4f10ee', 'SID-b001-0005'],
        ['2026-10-21T06:31:20Z', 'sari.dewi@' . $dom, 'USR-10388', 'YCN-Mail', $campusIp, 'DEV-2b88c1', 'SID-b001-0006'],
        ['2026-10-22T00:29:41Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0007'],
        ['2026-10-22T03:52:17Z', 'agus.pratama@' . $dom, 'USR-10503', 'YCN-Mail', $campusIp, 'DEV-9d31aa', 'SID-b001-0008'],
        ['2026-10-23T00:35:09Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0009'],
        ['2026-10-23T07:12:44Z', 'budi.hartono@' . $dom, 'USR-10021', 'YCN-Mail', '192.0.2.21', 'DEV-4f10ee', 'SID-b001-0010'],
        ['2026-10-26T00:31:55Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0011'],
        ['2026-10-26T02:40:12Z', 'sari.dewi@' . $dom, 'USR-10388', 'YCN-Mail', $campusIp, 'DEV-2b88c1', 'SID-b001-0012'],
        ['2026-10-27T00:40:03Z', $victim, $victimId, 'YCN-Drive', $campusIp, $dev, 'SID-b001-0013'],
        ['2026-10-27T01:05:38Z', 'agus.pratama@' . $dom, 'USR-10503', 'YCN-Mail', $campusIp, 'DEV-9d31aa', 'SID-b001-0014'],
        ['2026-10-27T08:22:19Z', 'budi.hartono@' . $dom, 'USR-10021', 'YCN-Drive', $campusIp, 'DEV-4f10ee', 'SID-b001-0015'],
        ['2026-10-28T00:33:27Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0016'],
        ['2026-10-28T05:15:01Z', 'sari.dewi@' . $dom, 'USR-10388', 'YCN-Mail', '192.0.2.21', 'DEV-2b88c1', 'SID-b001-0017'],
        ['2026-10-29T00:37:49Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0018'],
        ['2026-10-29T02:19:36Z', 'agus.pratama@' . $dom, 'USR-10503', 'YCN-Mail', $campusIp, 'DEV-9d31aa', 'SID-b001-0019'],
        ['2026-10-29T06:58:52Z', 'budi.hartono@' . $dom, 'USR-10021', 'YCN-Mail', $campusIp, 'DEV-4f10ee', 'SID-b001-0020'],
        ['2026-10-30T00:28:14Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0021'],
        ['2026-10-30T01:44:40Z', 'sari.dewi@' . $dom, 'USR-10388', 'YCN-Mail', $campusIp, 'DEV-2b88c1', 'SID-b001-0022'],
        ['2026-10-30T09:02:11Z', 'agus.pratama@' . $dom, 'USR-10503', 'YCN-Mail', $campusIp, 'DEV-9d31aa', 'SID-b001-0023'],
        ['2026-11-02T00:33:51Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0024'],
        ['2026-11-02T00:41:07Z', 'budi.hartono@' . $dom, 'USR-10021', 'YCN-Mail', $campusIp, 'DEV-4f10ee', 'SID-b001-0025'],
        ['2026-11-02T02:44:19Z', 'sari.dewi@' . $dom, 'USR-10388', 'YCN-Mail', $campusIp, 'DEV-2b88c1', 'SID-b001-0026'],
        ['2026-11-02T03:11:28Z', 'agus.pratama@' . $dom, 'USR-10503', 'YCN-Mail', $campusIp, 'DEV-9d31aa', 'SID-b001-0027'],
        ['2026-11-02T06:00:12Z', $victim, $victimId, 'YCN-Mail', $campusIp, $dev, 'SID-b001-0028'],
    ];
    $body = '';
    $n = 100;
    foreach ($rows as $r) {
        $n++;
        $body .= jline($mkb('IDP-BL-' . $n, $r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], 'req-bl-' . $n, $uaChrome));
    }
    put($base . '/baseline/idp-signin-baseline-20261020_20261102.jsonl', $body);

    $body = csv_row(['window_start', 'window_end', 'inbound_total', 'blocked', 'delivered', 'dmarc_none_delivered', 'outbound_total', 'note']) . "\n";
    $daily = [
        ['2026-10-20', 412, 96, 316, 1, 141],
        ['2026-10-21', 388, 81, 307, 0, 133],
        ['2026-10-22', 401, 104, 297, 1, 158],
        ['2026-10-23', 377, 88, 289, 0, 121],
        ['2026-10-26', 455, 121, 334, 1, 176],
        ['2026-10-27', 431, 99, 332, 0, 164],
        ['2026-10-28', 409, 93, 316, 1, 149],
        ['2026-10-29', 423, 110, 313, 2, 155],
        ['2026-10-30', 396, 87, 309, 0, 138],
        ['2026-11-02', 448, 112, 336, 1, 172],
    ];
    foreach ($daily as $d) {
        $body .= csv_row([$d[0] . 'T00:00:00+07:00', $d[0] . 'T23:59:59+07:00', $d[1], $d[2], $d[3], $d[4], $d[5], 'Agregat harian; tidak memuat metadata per pesan']) . "\n";
    }
    put($base . '/baseline/mailgateway-summary-baseline-20261020_20261102.csv', $body);

    // ----------------------------------------------------------- README FILES
    put($base . '/README-mahasiswa.md', <<<MD
# Cara Membuka dan Memverifikasi Paket (Windows)

Paket ini **tidak** memerlukan Docker, Python, atau server. Semua berkas adalah
teks/JSON/CSV yang dapat dibuka dengan editor biasa.

## 1. Siapkan salinan kerja

1. Ekstrak/salin folder `{$c}` ke `C:\\DFIR\\kerja\\{$c}`.
2. Pertahankan folder asli di tempat terpisah sebagai **master**.
3. Jangan mengedit berkas di folder master. Semua catatan ditulis di salinan.

## 2. Verifikasi hash (wajib, sebelum analisis)

Buka PowerShell di dalam folder paket, lalu jalankan:

```powershell
\$ErrorActionPreference = 'Stop'
\$root = (Get-Location).Path
\$bad = 0; \$n = 0
Get-Content .\\manifest-sha256.txt |
  Where-Object { \$_ -notmatch '^#' -and \$_.Trim() -ne '' } |
  ForEach-Object {
    \$parts = \$_ -split '  ', 2
    \$expect = \$parts[0]
    \$rel    = \$parts[1]
    \$actual = (Get-FileHash -Algorithm SHA256 -LiteralPath (Join-Path \$root \$rel)).Hash.ToLower()
    \$n++
    if (\$actual -ne \$expect) { \$bad++; Write-Output "MISMATCH \$rel" }
  }
Write-Output "files=\$n mismatches=\$bad"
```

Hasil yang benar: `mismatches=0`. Catat jumlah berkas dan waktu verifikasi
pada register bukti.

Untuk satu berkas:

```powershell
Get-FileHash -Algorithm SHA256 .\\artifacts\\email\\MSG-20261103-0042.eml
```

## 3. Membaca artefak

| Jenis | Cara aman |
| --- | --- |
| `.md` | VS Code, Notepad++, atau aplikasi Markdown |
| `.jsonl` | VS Code; satu baris = satu rekaman JSON |
| `.json` | VS Code; gunakan fitur format dokumen |
| `.csv` | Excel (Impor Data, pemisah koma) atau VS Code |
| `.eml` | Buka sebagai teks di VS Code; **jangan** klik tautan di dalamnya |
| `.log` | VS Code; aktifkan word wrap |

Jangan mengeksekusi, membuka, atau menghubungi URL/IP apa pun di dalam paket.
Tautan dan alamat hanya untuk analisis.

## 4. Tips analisis tanpa Python

- Urutkan JSONL dengan Excel: impor sebagai teks, pisahkan kolom dengan tanda
  baca, lalu sortir berdasarkan kolom `ts`.
- Gunakan `Select-String` untuk mencari ID:

```powershell
Select-String -Path .\\artifacts\\identity\\*.jsonl -Pattern 'SID-3f81c2a4'
```

- Hitung baris:

```powershell
(Get-Content .\\artifacts\\email\\mailgateway-20261102_20261104.jsonl).Count
```

## 5. Zona waktu

Baca `artifacts/SOURCE-TIME-AND-CONVENTIONS.md` lebih dahulu. Jangan
menormalkan timestamp di berkas asli; buat kolom konversi terpisah.

## 6. Yang dikumpulkan

Lihat `student-card.md` (format bukti) dan `evidence/README.md` (register
bukti). Simpan versi berkas kerja Anda beserta hash-nya.
MD);

    put($base . '/evidence/README.md', <<<MD
# Register dan Verifikasi Bukti

## 1. Prinsip

1. **Asli baca-saja.** Folder paket adalah master. Jangan mengubah, memindahkan,
   atau menamai ulang berkas di dalamnya.
2. **Salinan kerja terpisah.** Analisis dilakukan pada salinan.
3. **Setiap perpindahan dicatat.** Siapa, kapan (dengan offset), dari mana,
   ke mana, dan mengapa.
4. **Hash adalah bukti integritas, bukan bukti kebenaran isi.** Hash yang cocok
   hanya berarti berkas tidak berubah sejak manifest dibuat.

## 2. Verifikasi manifest

Format `manifest-sha256.txt`: `<sha256 huruf kecil><dua spasi><path relatif>`.
Baris berawalan `#` adalah komentar.

Jalankan dari akar paket (PowerShell 5.1):

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

Catat keluaran apa adanya pada register. Jika ada `MISMATCH`, hentikan
analisis, laporkan ke mentor, dan jangan memperbaiki berkas sendiri.

## 3. Register bukti

Gunakan `evidence-register-template.csv` dan isi minimal:

| Kolom | Isi |
| --- | --- |
| `item_id` | ID unik bukti, mis. `E-001` |
| `file_path` | Path relatif di dalam paket |
| `sha256_original` | Nilai dari manifest |
| `acquired_at` | Waktu penerimaan, dengan offset |
| `received_from` | Pihak pemberi (fiktif) |
| `custodian` | Nama anggota tim yang memegang |
| `storage_location` | Path salinan kerja |
| `sha256_working_copy` | Hash salinan kerja |
| `verification_result` | `match` / `mismatch` |
| `notes` | Batas atau keraguan |

## 4. Aturan salinan kerja

- Buat salinan dengan `Copy-Item` dan hitung hash setelah penyalinan.
- Catat hash salinan; jika berbeda dari asli, salinan tidak layak dipakai.
- Jangan mengubah berkas asli untuk "merapikan" format.

## 5. Batas yang harus dinyatakan

- Hash tidak membuktikan bahwa isi artefak lengkap; lihat bagian "Batas yang
  diketahui" pada `artifacts/SOURCE-TIME-AND-CONVENTIONS.md`.
- Ketiadaan rekaman pada satu sumber tidak membuktikan peristiwa tidak terjadi.
- Semua data sintetis; jangan mengutip sebagai temuan dunia nyata.
MD);

    $reg = csv_row(['item_id', 'file_path', 'sha256_original', 'acquired_at', 'received_from', 'custodian', 'storage_location', 'sha256_working_copy', 'verification_result', 'notes']) . "\n";
    $reg .= csv_row(['E-001', 'artifacts/email/MSG-20261103-0042.eml', '', '2026-11-20T09:00:00+07:00', 'Mentor DFIR (fiktif)', '', '', '', 'isi setelah verifikasi']) . "\n";
    put($base . '/evidence/evidence-register-template.csv', $reg);

    write_manifest($c);
}

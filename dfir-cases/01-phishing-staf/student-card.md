# Kartu Peserta - DFIR-1: Phishing Akun Staf

**Kasus:** akses tidak sah ke akun staf dan penyalahgunaan sesi SSO
**Organisasi (fiktif):** Yayasan Cendekia Nusantara (YCN)
**Paket:** `dfir-cases/01-phishing-staf/`
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
| `artifacts/endpoint/WS-AKD-014-browser-history.json` | Riwayat peramban |
| `artifacts/endpoint/WS-AKD-014-edr-20261103.jsonl` | Telemetri EDR |
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

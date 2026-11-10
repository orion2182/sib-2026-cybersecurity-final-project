# Kartu Peserta - DFIR-2: Intrusi Aplikasi Perpustakaan

**Kasus:** perubahan berkas dan request HTTP mencurigakan pada layanan web
**Organisasi (fiktif):** Universitas Cakrawala Nusantara (UCN)
**Paket:** `dfir-cases/02-perpus-intrusion/`
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
| `artifacts/config/config-audit-web-perpus-01.csv` | Audit konfigurasi |
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

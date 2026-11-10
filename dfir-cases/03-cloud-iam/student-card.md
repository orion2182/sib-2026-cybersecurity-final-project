# Kartu Peserta - DFIR-3: Penyalahgunaan Identitas Cloud

**Kasus:** identitas layanan mengakses objek di luar pola normal
**Organisasi (fiktif):** Yayasan Arsip Digital Bahari (YADB)
**Paket:** `dfir-cases/03-cloud-iam/`
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

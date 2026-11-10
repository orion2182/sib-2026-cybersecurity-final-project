# 02 — Peta Data Pendaftaran dan Pembayaran

**Dokumen:** peta data oleh UPT TIK dan Biro Keuangan, 28 Oktober 2026
**Status:** tidak lengkap; disusun dari wawancara dan pembacaan basis data

---

## 1. Alur ringkas

```
Pendaftar/ Mahasiswa
   │  biodata, berkas, pilihan prodi
   ▼
SIPMA (aplikasi, VM di Awan Cakrawala)
   │  ├─ PostgreSQL 900 GB ──► NAS kampus (backup harian)
   │  ├─ berkas unggahan ──► NAS + salinan di laptop staf admisi
   │  └─ data tagihan ──► modul keuangan
   │
   ├─ PayLoka (payment gateway) ──► notifikasi webhook ──► SIPMA
   │        └─ ledger transaksi (retensi 7 hari di portal)
   │
   ├─ Bank Arunika Sejahtera ──► file rekonsiliasi harian 06.00
   │        └─ spreadsheet rekonsiliasi di shared drive
   │
   ├─ SMS gateway ──► notifikasi
   └─ PDDikti ──► pelaporan (2x/semester)

Saluran tidak resmi:
   - grup WhatsApp "Panitia Registrasi" (40 anggota, termasuk relawan mahasiswa)
   - flashdisk loket
   - kotak surel pribadi 6 staf admisi
```

## 2. Tabel data

| # | Elemen | Kategori | Sumber | Tujuan | Lokasi | Retensi (klaim) | Akses |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | Nama lengkap | Umum | Formulir | Identifikasi | SIPMA | 5 tahun | 12 staf |
| 2 | NIK | Umum (kombinasi) | Formulir | Verifikasi identitas | SIPMA | 5 tahun | 12 staf, 40 panitia (manual) |
| 3 | Nomor KK | Umum | Unggahan | Verifikasi | SIPMA, NAS | 5 tahun | idem |
| 4 | Alamat | Umum | Formulir | Administrasi | SIPMA | 5 tahun | 12 staf |
| 5 | Nomor HP, surel | Umum | Formulir | Notifikasi | SIPMA, SMS gateway | 5 tahun | 12 staf |
| 6 | Asal sekolah, nilai rapor | Umum | Unggahan | Seleksi | SIPMA, NAS | 5 tahun | 8 staf admisi |
| 7 | Penghasilan orang tua | **Spesifik (keuangan pribadi)** | Formulir | Beasiswa | SIPMA | 5 tahun | 12 staf |
| 8 | Status disabilitas | **Spesifik** | Formulir | Layanan khusus | SIPMA | 5 tahun | 12 staf |
| 9 | Jumlah tagihan, status bayar | Umum (keuangan) | Sistem | Registrasi | SIPMA | 10 tahun | 20 staf |
| 10 | Nomor virtual account | Umum | Bank | Pembayaran | Bank | 10 tahun | 20 staf |
| 11 | Riwayat transaksi PayLoka | Umum (keuangan) | PayLoka | Rekonsiliasi | PayLoka | 7 hari di portal | 6 staf keuangan |
| 12 | File rekonsiliasi harian | Umum | Bank | Rekonsiliasi | Shared drive | tidak ditetapkan | 40 panitia |
| 13 | Berkas pendaftaran (PDF) | Campuran | Unggahan | Seleksi | NAS + laptop | 5 tahun | 12 staf |
| 14 | Log akses aplikasi | Umum | SIPMA | Keamanan | SIPMA | 30 hari | 3 admin |
| 15 | Log perubahan nilai/ tagihan | Umum | SIPMA | Audit | SIPMA | 30 hari | 3 admin |

## 3. Peran dan perpindahan

| Titik | Peran | Catatan |
| --- | --- | --- |
| Pendaftar → PNB | Subjek data → **Pengendali** | PNB menentukan tujuan |
| PNB → PayLoka | Pengendali → **Prosesor** | Untuk pemrosesan pembayaran |
| PNB → Bank | Pengendali → **Pengendali terpisah** | Bank punya kewajiban sendiri |
| PNB → Awan Cakrawala | Pengendali → **Prosesor** (IaaS) | Kontrak ada |
| PNB → PT Sandi Data Nusantara | Pengendali → **Prosesor** | Backup dan kunci |
| PNB → PDDikti | Pelaporan ke badan publik | Dasar: kewajiban hukum |
| Data → WhatsApp panitia | Tidak resmi | **Tidak ada dasar, tidak ada kendali** |

## 4. Data yang bocor ke saluran tidak resmi (temuan)

| Saluran | Data | Jumlah orang dengan akses | Dasar |
| --- | --- | ---: | --- |
| Grup WhatsApp "Panitia Registrasi" | File rekonsiliasi harian berisi NIM, nama, jumlah, sebagian NIK | 40 | Tidak ada |
| Flashdisk loket | Daftar tunggakan | 4 | Tidak ada |
| Surel pribadi staf | Berkas pendaftar | 6 | Tidak ada |
| Spreadsheet "manual" | NIK, status beasiswa, status disabilitas | 40 | Tidak ada |

## 5. Perhitungan paparan

| Pertanyaan | Angka | Dasar |
| --- | ---: | --- |
| Berapa mahasiswa yang datanya ada di file rekonsiliasi satu hari? | 2.400 baris | volume puncak |
| Berapa yang berisi NIK? | ±640 (perkiraan) | sampel 40 baris |
| Berapa relawan mahasiswa dalam grup? | 28 | daftar anggota |
| Berapa lama file tersimpan di ponsel? | tidak diketahui | tidak ada kontrol |

## 6. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Data mana yang **tidak perlu** dikumpulkan pada tahap pendaftaran?
- Saluran tidak resmi mana yang paling berbahaya, dan mengapa?
- Jika terjadi gangguan dan proses manual diperlukan, data minimum apa yang boleh dicatat?
- Siapa yang harus memberi persetujuan atas saluran komunikasi darurat?

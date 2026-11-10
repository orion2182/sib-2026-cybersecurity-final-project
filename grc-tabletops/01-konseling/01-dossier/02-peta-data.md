# 02 — Peta Data dan Aliran Data

**Dokumen:** rekonstruksi peta data oleh UPT TIK, 27 Oktober 2026
**Catatan penting:** UCA **tidak memiliki** peta data resmi. Dokumen ini disusun dari wawancara, tangkapan layar, dan pembacaan kontrak. Beberapa kolom bertanda `?` berarti belum terverifikasi.

---

## 1. Alur ringkas

```
Mahasiswa
  │  formulir intake (web)
  ▼
SIPKON (Hening Cloud, Jakarta)
  │  ├─ catatan sesi (teks terstruktur)
  │  ├─ lampiran (PDF, gambar)  ──► Nimbus Object Storage (Singapura)
  │  ├─ transkrip chat           ──► modul analitik vendor (retensi 13 bulan)
  │  └─ ekspor laporan (XLSX)    ──► surel konselor (kotak masuk pribadi)
  │
  ├─ Hotline ──► PT Panggilan Aman (rekaman, 90 hari) ──► surel terenkripsi ke UPT
  ├─ Rujukan ──► Klinik Sehat Jiwa (pengendali terpisah)
  └─ Forum ──► basis data forum kampus (tanpa jadwal retensi)

Salinan lain:
  - kertas intake (lemari arsip ruang tunggu, kunci dipegang admin)
  - tangkapan layar jadwal di grup WhatsApp konselor (tidak resmi)
  - cadangan harian vendor (7 hari, region yang sama)
```

## 2. Tabel data

| # | Elemen data | Kategori | Sumber | Tujuan | Lokasi | Pemroses | Retensi menurut dokumen | Akses |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | Nama lengkap | Umum | Intake | Identifikasi | SIPKON | Hening Cloud | ? | 9 konselor, 4 admin |
| 2 | NIM | Umum (kombinasi) | Intake | Penautan ke SIAKAD | SIPKON | Hening Cloud | ? | idem |
| 3 | Kontak (HP, surel) | Umum | Intake | Penjadwalan, krisis | SIPKON | Hening Cloud | ? | idem |
| 4 | Fakultas, angkatan | Umum | Intake | Pelaporan agregat | SIPKON | Hening Cloud | ? | idem |
| 5 | Keluhan utama | **Spesifik (kesehatan)** | Intake | Triase | SIPKON | Hening Cloud | ? | idem |
| 6 | Riwayat konseling | **Spesifik (kesehatan)** | Intake | Konteks klinis | SIPKON | Hening Cloud | ? | idem |
| 7 | Catatan sesi (SOAP) | **Spesifik (kesehatan)** | Konselor | Dokumentasi klinis | SIPKON | Hening Cloud | 5 tahun (SOP) / 2 tahun (arsip) | 9 konselor |
| 8 | Skor risiko diri | **Spesifik (kesehatan)** | Konselor | Keselamatan | SIPKON | Hening Cloud | ? | 9 konselor, 2 psikolog |
| 9 | Lampiran (surat rujukan, hasil tes) | **Spesifik (kesehatan)** | Konselor | Rujukan | Nimbus (Singapura) | Hening Cloud + Nimbus | ? | 9 konselor |
| 10 | Transkrip chat | **Spesifik (kesehatan)** | Mahasiswa | Layanan | Modul analitik vendor | Hening Cloud | 13 bulan | 9 konselor + **tim analitik vendor** |
| 11 | Rekaman hotline | **Spesifik (kesehatan)** | Penelepon | Mutu, keselamatan | Panggilan Aman | Panggilan Aman | 90 hari | agen, supervisor vendor |
| 12 | Ringkasan hotline (PDF) | **Spesifik (kesehatan)** | Vendor | Tindak lanjut | Surel UPT | Panggilan Aman | ? | 4 admin, 9 konselor |
| 13 | Posting forum | **Spesifik (mungkin)** | Mahasiswa | Dukungan sebaya | DB forum kampus | UPT TIK | tidak ditetapkan | moderator, publik terbatas |
| 14 | Catatan kehadiran sesi | Umum | Admin | Administrasi | SIPKON | Hening Cloud | ? | 4 admin |
| 15 | Data penagihan vendor | Umum | Keuangan | Pembayaran | ERP kampus | Biro Keuangan | 10 tahun | 3 staf keuangan |
| 16 | Log akses aplikasi | Umum | Vendor | Keamanan | Vendor | Hening Cloud | 30 hari | vendor, UPT TIK atas permintaan |

## 3. Titik perpindahan peran

| Titik | Dari | Ke | Peran hukum | Bukti pendukung |
| --- | --- | --- | --- | --- |
| Intake → SIPKON | UCA | Hening Cloud | Pengendali → **Prosesor** | DPA, bagian 2 |
| SIPKON → Nimbus | Hening Cloud | Nimbus | Prosesor → **Subprosesor** | tidak ada persetujuan tertulis UCA |
| Chat → modul analitik | Hening Cloud | Hening Cloud (fitur internal) | Pemrosesan untuk tujuan vendor? | kontrak tidak jelas |
| Hotline → Panggilan Aman | UCA | Panggilan Aman | Pengendali → Prosesor | kontrak, bagian 4 |
| Rujukan → Klinik | UCA | Klinik Sehat Jiwa | Pengendali → **Pengendali terpisah** | surat rujukan |
| Laporan → surel konselor | SIPKON | Surel kampus | Transfer internal | tidak ada aturan |

## 4. Temuan rekonstruksi (fakta, belum disimpulkan)

1. Ada **tiga salinan** catatan sesi: SIPKON, cadangan vendor, dan ekspor XLSX di kotak masuk surel konselor.
2. Transkrip chat diproses oleh modul analitik vendor untuk "peningkatan layanan" — tujuan ini tidak muncul dalam pemberitahuan privasi.
3. Nimbus berada di Singapura dan tidak pernah disetujui tertulis oleh UCA.
4. Retensi tercatat di empat tempat berbeda dan tidak konsisten (lihat `05-jadwal-retensi.md`).
5. Tidak ada pencatatan akses baca terhadap catatan sesi; hanya login yang tercatat.
6. Formulir intake kertas masih dipakai saat jaringan lambat; tidak ada register pemusnahan.

## 5. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Data mana yang termasuk **data pribadi spesifik** dan apa konsekuensi prosesnya?
- Siapa **pengendali** untuk tiap aliran, dan siapa yang hanya prosesor?
- Di mana ada **transfer lintas negara**, dan apa dasar serta jaminannya?
- Aliran mana yang tidak memiliki **dasar pemrosesan** yang dapat ditunjukkan?
- Salinan mana yang tidak tercakup jadwal retensi dan karena itu berisiko tumbuh tanpa batas?

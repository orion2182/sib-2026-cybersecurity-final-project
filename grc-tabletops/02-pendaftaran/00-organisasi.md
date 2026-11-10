# 00 — Organisasi, Layanan, dan Tata Kelola

**Kasus:** GRC-2 Pendaftaran dan Pembayaran Kampus
**Organisasi:** Politeknik Nusa Bahari (PNB), Kota Bahari
**Badan penyelenggara:** Yayasan Pendidikan Nusa Bahari (YPNB)
**Tanggal paket:** 10 November 2026
**Status:** seluruh isi fiktif dan sintetis. Tidak ada data pribadi nyata.

> Dokumen ini adalah titik masuk. Dokumen lain di `01-dossier/` saling melengkapi dan **sengaja** memuat ketidaksesuaian. Angka pada satu dokumen tidak selalu cocok dengan dokumen lain; temukan dan jelaskan.

---

## 1. Profil organisasi

| Butir | Keterangan |
| --- | --- |
| Nama | Politeknik Nusa Bahari (PNB) |
| Badan hukum | Yayasan Pendidikan Nusa Bahari (YPNB) |
| Lokasi | Kampus Bahari, Kota Bahari (fiktif); 1 kampus satelit |
| Mahasiswa aktif | 14.300 (semester ganjil 2026/2027) |
| Program studi | 6 (Teknik Perkapalan; Teknologi Informasi; Akuntansi; Administrasi Bisnis; Keselamatan Kerja; Perhotelan) |
| Dosen dan staf | 780 |
| Anggaran tahunan | Rp 286 miliar (fiktif) |
| Anggaran TI | Rp 14 miliar/tahun |
| Penerimaan UKT per semester | Rp 40,4 miliar (9.850 pembayar × rata-rata Rp 4,1 juta) |
| Pagu program kelangsungan layanan | **Rp 320 juta/tahun** (lihat `07-batas-anggaran.md`) |

## 2. Layanan yang menjadi lingkup kasus

**Sistem Informasi Pendaftaran dan Registrasi Mahasiswa (SIPMA)** dan proses pembayaran yang bergantung padanya.

| Layanan | Pengguna | Volume | Jam kritis |
| --- | ---: | ---: | --- |
| Registrasi ulang mahasiswa lama (semester genap 2026/2027) | 9.850 pembayar | 2.400 transaksi/hari pada puncak | 08.00–22.00 WIB |
| Pembayaran UKT dan cicilan | 9.850 | 9.850 transaksi; puncak 2.400/hari | terakhir 11 Des 2026, 23.59 |
| Verifikasi beasiswa/ keringanan | 380 mahasiswa | 380 berkas | 24 Nov–9 Des 2026 |
| Pendaftaran mahasiswa baru Gelombang 1 (2027/2028) | 3.100 pendaftar | 3.100 formulir + 1.250 pembayaran | 1–15 Des 2026 |
| Pengisian KRS | 14.300 | 14.300 | 14–18 Des 2026 |
| Pelaporan ke PDDikti | 14.300 | 2 siklus/semester | 20 Des 2026 dan 10 Feb 2027 |
| Rekonsiliasi bank | 1 file/hari | 2.400 baris/hari | 06.00 WIB |

**Mengapa layanan ini kritis:** tenggat 11 Desember bersifat akademik, bukan administratif. Mahasiswa yang tidak menyelesaikan pembayaran sampai tenggat kehilangan hak mengisi KRS, dan karena itu tidak dapat mengikuti ujian. Keputusan menunda atau memperpanjang tenggat bukan kewenangan tim TI.

## 3. Kalender akademik (bagian yang relevan)

| Tanggal | Peristiwa | Sifat |
| --- | --- | --- |
| 24 Nov–11 Des 2026 | Registrasi ulang semester genap; pembayaran | **Tenggat keras 11 Des 23.59** |
| 1–15 Des 2026 | Pendaftaran Gelombang 1 admisi 2027/2028 (diskon 25% bila lunas ≤ 15 Des) | Tenggat komersial |
| 3 Des 2026 | Puncak pembayaran diperkirakan (2.400 transaksi) | Beban puncak |
| 9 Des 2026 | Rapat Senat Akademik menetapkan daftar mahasiswa tidak terdaftar | **Tidak dapat diubah oleh tim** |
| 14–18 Des 2026 | Pengisian KRS | Bergantung pada status pembayaran |
| 16–18 Des 2026 | Gladi presentasi program SIB | Jadwal peserta |
| 21–23 Des 2026 | Presentasi dan pengujian | Jadwal peserta |
| 21 Des 2026–8 Jan 2027 | Masa tenang akademik | Kesempatan pemulihan terbatas |
| 11 Jan 2027 | Perkuliahan semester genap dimulai | — |

**Catatan tekanan:** setiap hari gangguan setelah 9 Desember berarti mahasiswa yang sudah membayar tetapi belum tercatat akan tampil sebagai "tidak terdaftar" pada rapat Senat. Koreksi setelah rapat memerlukan keputusan Dekan, bukan staf.

## 4. Struktur dan peran

| Peran | Nama (fiktif) | Tanggung jawab relevan |
| --- | --- | --- |
| Direktur | Dr. Hasan Wirayuda | Pemilik risiko tertinggi; menyetujui risiko sisa |
| Wakil Direktur Akademik | Dra. Nia Salim | Pemilik proses registrasi; ketua rapat Senat |
| Direktur Akademik dan Admisi (DAA) | Rangga Putra | Pemilik operasional SIPMA |
| Kepala Biro Keuangan | Sri Wahyuni | Pemilik data pembayaran dan rekonsiliasi |
| Kepala UPT TIK | Dedi Kurnia | Infrastruktur, cadangan, integrasi vendor |
| Analis Sistem | (1 orang, kontrak) | Admin SIPMA; satu-satunya yang paham integrasi |
| Pejabat Fungsi PDP ("DPO") | Lestari Dewi, S.H. | Ditunjuk Feb 2026; juga Kepala Unit Kepatuhan |
| Kepala Unit Layanan Mahasiswa | Bayu Firmansyah | Menangani keluhan pembayaran |
| Vendor pembayaran | PT PayLoka Nusantara | Payment gateway |
| Bank penampung | Bank Arunika Sejahtera | Virtual account dan rekonsiliasi |
| Penyedia jasa terkelola | PT Sandi Data Nusantara (SDN) | Backup, HSM, dukungan server |
| Penyedia cloud | Awan Cakrawala | IaaS, satu region Jakarta |

## 5. Tata kelola saat ini

| Elemen | Kondisi per November 2026 | Bukti |
| --- | --- | --- |
| Rencana kelangsungan bisnis (BCP) | Ada, versi 2023, tidak pernah diuji | `06-kontrol-saat-ini.md` |
| BIA | Tidak pernah dibuat | tidak ada dokumen |
| Risk register | Hanya risiko TI, tanpa risiko proses | daftar 2024 |
| RTO/RPO | Disebut di BCP 2023: "4 jam untuk semua sistem" | tidak berdasar pengukuran |
| Uji restore | Terakhir Sep 2025; gagal sebagian | tiket |
| Uji failover | Tidak ada (tidak ada situs cadangan) | — |
| Manajemen vendor | Kontrak ada; tanpa pemantauan SLA | `08-sla.md` |
| Prosedur registrasi manual | Tidak ada; "dulu pernah pakai spreadsheet" | wawancara |
| Pelatihan privasi | Tidak ada sejak 2024 | — |

## 6. Mandat untuk tim peserta

Direktur membentuk **Tim Kelangsungan Layanan** pada 20 November 2026 dengan mandat:

1. Menyusun BIA untuk proses registrasi dan pembayaran.
2. Menetapkan RTO/RPO yang dapat dipertahankan dengan bukti.
3. Merancang strategi layanan manual dan/ atau failover yang melindungi data mahasiswa.
4. Menyiapkan keputusan untuk rapat pimpinan 10–11 Desember 2026.

**Batas mandat:** tim tidak dapat mengubah kalender akademik, tidak dapat menghubungi vendor, dan tidak dapat melakukan pengujian teknis. Semua analisis dari dokumen.

## 7. Fakta vs asumsi

| Label | Arti |
| --- | --- |
| **F** | Fakta — tertulis di dossier dan dapat dikutip |
| **A** | Asumsi — diisi tim; harus dinyatakan terbuka |
| **U** | Belum diketahui — perlu konfirmasi; menjadi action item |

## 8. Dokumen dalam paket ini

| Dokumen | Isi |
| --- | --- |
| `01-dossier/01-deskripsi-layanan.md` | Proses, volume, ketergantungan, kalender |
| `01-dossier/02-peta-data.md` | Aliran data pendaftaran dan pembayaran |
| `01-dossier/03-daftar-vendor-kontrak.md` | 5 vendor, klausul, celah |
| `01-dossier/04-inventaris-aset.md` | Aset, kapasitas, titik tunggal kegagalan |
| `01-dossier/05-jadwal-retensi.md` | Retensi dan konfliknya |
| `01-dossier/06-kontrol-saat-ini.md` | Kontrol dan celah |
| `01-dossier/07-batas-anggaran.md` | Pagu dan daftar harga opsi |
| `01-dossier/08-sla.md` | SLA vendor dan target internal |
| `01-dossier/09-riwayat-insiden.md` | 4 insiden sebelumnya |
| `01-dossier/10-contoh-pemberitahuan-privasi.md` | Pemberitahuan privasi pendaftar |
| `02-inject/inject-1.md` | Dibuka 3 Desember 2026 (dua bagian) |
| `02-inject/inject-2.md` | Dibuka 9 Desember 2026 |
| `03-templates/` | 7 template kerja |
| `04-tasks/student-card.md` | Situasi, aturan, Q1–Q12, deliverables |
| `05-rubric/participant-rubric.md` | Rubrik publik |

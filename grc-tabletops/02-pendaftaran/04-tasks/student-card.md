# Kartu Mahasiswa — GRC-2 Pendaftaran dan Pembayaran Kampus

**Kelompok:** ____  **Anggota:** 1. ____ 2. ____ 3. ____ 4. ____ 5. ____
**Tanggal mulai:** 20 November 2026  **Penyerahan paket:** 18 Desember 2026
**Presentasi/ pengujian:** 21–23 Desember 2026

---

## 1. Situasi

Anda adalah **Tim Kelangsungan Layanan** yang dibentuk Direktur Politeknik Nusa Bahari pada 20 November 2026. Mandat Anda: menyusun BIA, menetapkan RTO/RPO yang dapat dipertahankan, dan merancang strategi layanan saat sistem registrasi dan pembayaran terganggu.

Tenggat registrasi **11 Desember 2026 pukul 23.59 tidak dapat diubah**. Rapat Senat pada 9 Desember menetapkan daftar mahasiswa tidak terdaftar. Setiap jam setelah itu memiliki konsekuensi akademik permanen bagi mahasiswa.

Pada 3 Desember dan 9 Desember 2026, fakta baru diberikan. Sebagian asumsi Anda akan gugur.

**Yang tidak boleh Anda lakukan:** menghubungi vendor, menguji sistem, mengubah data, atau berasumsi bahwa kalender akademik dapat digeser.

## 2. Tujuan pembelajaran

1. Menyusun BIA untuk layanan yang tenggatnya ditentukan pihak lain.
2. Menetapkan RTO/RPO berbasis bukti, bukan harapan.
3. Merancang proses manual yang tetap melindungi data pribadi.
4. Menilai kegagalan vendor pembayaran dan implikasi finansial/akademiknya.
5. Menyampaikan keputusan yang tidak populer dengan alasan yang dapat dipertanggungjawabkan.

## 3. Aturan tabletop

1. **Semua anggota bicara minimal sekali per sesi.**
2. **Label klaim F/A/U.** Tanpa label = asumsi.
3. **Keputusan punya pemilik dan tenggat.**
4. **Sebutkan apa yang tidak dilakukan.**
5. **Jangan mengarang nomor pasal atau angka.**
6. **Hormati tenggat simulasi.** Waktu habis = tulis keputusan + ketidakpastian.
7. **Peran boleh dirangkap, konflik kepentingan harus dinyatakan.**

## 4. Pertanyaan Q1–Q12

### Tahap 1 — Mandat dan aset (20–23 Nov)

**Q1. Siapa pemilik keputusan, subjek data, vendor, dan pihak operasional yang terdampak?**
*Petunjuk konsep:* perhatikan pihak yang menanggung akibat tetapi tidak ada dalam rapat: mahasiswa penerima beasiswa, pendaftar, staf loket.

**Q2. Aset, proses, data, dan dependensi apa yang paling kritis? Tandai fakta dan asumsi.**
*Petunjuk konsep:* kekritisan ditentukan oleh tenggat dan hak mahasiswa, bukan oleh harga aset.

**G0:** scope dan asumsi disetujui.

### Tahap 2 — Peta data dan risiko (24–27 Nov)

**Q3. Gambarkan aliran data dari pengumpulan sampai penghapusan; di mana data berpindah pengendali/prosesor atau melewati vendor?**
*Petunjuk konsep:* ada saluran resmi dan tidak resmi. Keduanya harus digambar.

**Q4. Pilih tiga risiko prioritas; jelaskan kemungkinan, dampak, pemilik risiko, kontrol saat ini, dan gap terhadap outcome kerangka kerja yang dipilih.**
*Petunjuk konsep:* risiko duplikasi pembayaran dan risiko data manual adalah dua risiko berbeda dengan pemilik berbeda.

**G1:** prioritas risiko disetujui.

### Tahap 3 — Privasi dan BIA (30 Nov–2 Des)

**Q5. Proses pemrosesan mana yang perlu peninjauan dasar hukum, tujuan, minimisasi, retensi, atau akses? Kutip sumber resmi dan nyatakan fakta yang belum diketahui.**
*Petunjuk konsep:* data keuangan pribadi dan status disabilitas bukan data biasa. Apakah dasar "mendaftar berarti setuju" memadai untuk keduanya?

**Q6. Apa dampak gangguan pada titik 4 jam, 1 hari, dan 3 hari? Nyatakan asumsi volume dan dampak nonfinansial.**
*Petunjuk konsep:* 3 hari melewati tenggat. Dampaknya bukan "terlambat", tetapi kehilangan hak.

**Q7. Berapa RTO/RPO yang diusulkan untuk dua layanan utama, dan mengapa layak atau tidak layak berdasarkan bukti backup/dependensi?**
*Petunjuk konsep:* hitung waktu transfer. Pertimbangkan WRT setelah sistem hidup.

**G2:** rujukan dan asumsi terlacak.

### Tahap 4 — Inject 1 (3–8 Des)

**Q8 (khusus kasus). Proses pendaftaran mana yang harus berlanjut secara manual saat sistem mati?**
*Petunjuk konsep:* bedakan proses yang boleh menunggu dari proses yang kehilangan hak jika menunggu. Manual bukan satu paket untuk semua proses.

**Q9 (khusus kasus). Bukti apa yang menunjukkan target pemulihan tidak sesuai kemampuan backup saat ini?**
*Petunjuk konsep:* cari angka: ukuran data, kecepatan, frekuensi, hasil uji, dan log yang hilang.

**Q10 (khusus kasus). Bagaimana prosedur darurat mencegah paparan data mahasiswa di daftar manual?**
*Petunjuk konsep:* minimum data, media terkendali, akses terbatas, retensi, pemusnahan, dan bukti.

**G3:** keputusan tertulis (memo 1A dan 1B).

### Tahap 5 — Inject 2 dan tabletop (9–11 Des)

**Q11. Setelah inject kedua, keputusan apa yang berubah, siapa yang menyetujuinya, dan risiko sisa apa yang diterima secara sadar?**
*Petunjuk konsep:* pemulihan dicabut, vendor berhenti, tenggat tetap. Tidak semua janji bisa dipertahankan.

**G4:** risiko sisa dan pemiliknya disetujui.

### Tahap 6 — Rencana dan presentasi (14–18 Des)

**Q12. Buat rencana 30/60/90 hari: tiga tindakan prioritas, pemilik, bukti selesai, uji BCP, dan informasi yang perlu dibawa ke pimpinan.**
*Petunjuk konsep:* bedakan perbaikan sebelum 11 Desember, sebelum 31 Desember, dan setelah semester dimulai.

**G5:** paket final 18 Desember 2026.

## 5. Deliverables

| # | Berkas | Template | Isi minimum |
| :-: | --- | --- | --- |
| 1 | `risk-register.md` | `03-templates/risk-register.md` | ≥ 10 risiko, 3 prioritas |
| 2 | `data-map.md` | `03-templates/data-map.md` | ≥ 10 kegiatan, aliran resmi + tidak resmi |
| 3 | `bia.md` | `03-templates/bia.md` | 4 jam/1 hari/3 hari untuk ≥ 6 proses |
| 4 | `rto-rpo.md` | `03-templates/rto-rpo-worksheet.md` | ≥ 5 layanan + perhitungan + WRT |
| 5 | `memo-inject-1a.md` | `03-templates/decision-memo.md` | D1.1–D1.6 |
| 6 | `memo-inject-1b.md` | `03-templates/decision-memo.md` | D1.7–D1.12 |
| 7 | `memo-inject-2.md` | `03-templates/decision-memo.md` | D2.1–D2.8 |
| 8 | `continuity-plan.md` | `03-templates/continuity-plan.md` | 3 skenario + aturan data manual |
| 9 | `executive-brief.md` | `03-templates/executive-brief.md` | Maks. 2 halaman |
| 10 | `slide.pdf` atau `slide.md` | — | 8–10 slide, 12 menit |

Simpan dalam folder `submission/`.

## 6. Penilaian

| Komponen | Poin |
| --- | ---: |
| Inventaris, stakeholder, keterlacakan asumsi | 15 |
| Analisis dan prioritas risiko | 20 |
| Peta data dan analisis privasi dengan sumber resmi | 20 |
| BIA, RTO/RPO, strategi kelangsungan | 20 |
| Keputusan inject, komunikasi pimpinan, rencana aksi | 15 |
| Tanya jawab kontribusi individu | 10 |
| **Total** | **100** |

## 7. Pertanyaan yang harus bisa dijawab saat presentasi

1. Berapa RTO yang Anda klaim, dan mengapa angka itu bukan harapan?
2. Siapa yang menanggung akibat jika 640 transaksi tidak terkoreksi sebelum 11 Desember?
3. Data apa yang Anda larang masuk ke daftar manual, dan mengapa?
4. Apa yang Anda putuskan untuk tidak dilakukan?
5. Fakta mana yang membuat Anda mengubah keputusan?
6. Apa yang akan Anda lakukan berbeda jika anggaran dipotong 50%?

## 8. Larangan

- Menyalin jawaban kelompok lain.
- Mengarang nomor pasal, angka, atau kutipan kontrak.
- Menyebut data pribadi nyata.
- Menyatakan "tidak ada risiko" tanpa bukti.

# Kartu Mahasiswa — GRC-1 Layanan Konseling Mahasiswa

**Kelompok:** ____  **Anggota:** 1. ____ 2. ____ 3. ____ 4. ____ 5. ____
**Tanggal mulai:** 20 November 2026  **Penyerahan paket:** 18 Desember 2026
**Presentasi/ pengujian:** 21–23 Desember 2026

---

## 1. Situasi

Anda adalah **Tim Penasihat Risiko** yang dibentuk Wakil Rektor Kemahasiswaan Universitas Cendekia Arunika (UCA) pada 20 November 2026. Mandat Anda: menilai risiko privasi, vendor, dan kelangsungan layanan konseling mahasiswa **"Ruang Aman"**, lalu merekomendasikan prioritas yang dapat dijalankan dengan pagu Rp 180 juta.

Pada 3 Desember dan 9 Desember 2026, fakta baru akan diberikan. Rekomendasi Anda harus **berubah** jika bukti berubah — dan Anda harus menjelaskan mengapa.

**Yang tidak boleh Anda lakukan:** menghubungi vendor, memindai sistem, menguji aplikasi, atau menganggap dokumen mana pun sebagai kebenaran tunggal.

## 2. Tujuan pembelajaran

Setelah menyelesaikan kasus ini, Anda dapat:
1. memetakan aliran data dan peran pihak dalam layanan yang memproses data kesehatan;
2. menilai kesenjangan antara kewajiban hukum, isi kontrak, dan praktik;
3. menyusun BIA dan RTO/RPO yang dapat dipertahankan dengan bukti;
4. mengambil keputusan yang menyeimbangkan privasi, keselamatan, dan kelangsungan layanan;
5. menulis memo keputusan dan executive brief yang dapat dibaca pimpinan.

## 3. Aturan tabletop

1. **Tidak ada peringkat jabatan di dalam tim.** Semua anggota harus bicara minimal sekali per sesi.
2. **Setiap klaim diberi label F (fakta), A (asumsi), atau U (belum diketahui).** Klaim tanpa label dianggap asumsi.
3. **Keputusan harus punya pemilik dan tanggal.** "Tim" bukan pemilik.
4. **Sebutkan apa yang tidak dilakukan.** Keputusan yang hanya berisi daftar keinginan tidak dinilai.
5. **Jangan mengarang nomor pasal.** Kutip hanya setelah membaca teks resmi; jika belum, tulis "perlu verifikasi".
6. **Waktu dijaga.** Jika waktu habis, tulis keputusan terbaik dengan informasi yang ada dan tandai ketidakpastiannya.
7. **Rahasia sesi:** apa yang dikatakan antaranggota dalam simulasi peran tidak dipakai untuk menilai pribadi.

## 4. Pertanyaan Q1–Q12

> Ini pertanyaan, bukan petunjuk jawaban. "Petunjuk konsep" hanya menunjukkan konsep yang perlu dipertimbangkan.

### Tahap 1 — Mandat, stakeholder, aset (20–23 Nov)

**Q1. Siapa pemilik keputusan, subjek data, vendor, dan pihak operasional yang terdampak?**
*Petunjuk konsep:* bedakan pihak yang menanggung risiko, yang memutuskan, dan yang menanggung akibat. Perhatikan pihak yang tidak punya suara.

**Q2. Aset, proses, data, dan dependensi apa yang paling kritis? Tandai fakta dan asumsi.**
*Petunjuk konsep:* kekritisan tidak sama dengan nilai kontrak. Pertimbangkan keselamatan.

**G0 — Gerbang 0:** scope dan asumsi disetujui. Serahkan daftar asumsi berlabel.

### Tahap 2 — Peta data dan profil risiko (24–27 Nov)

**Q3. Gambarkan aliran data dari pengumpulan sampai penghapusan; di mana data berpindah pengendali/prosesor atau melewati vendor?**
*Petunjuk konsep:* peran hukum berpindah di titik tertentu. Tandai transfer lintas negara dan salinan yang tidak resmi.

**Q4. Pilih tiga risiko prioritas; jelaskan kemungkinan, dampak, pemilik risiko, kontrol saat ini, dan gap terhadap outcome kerangka kerja yang dipilih.**
*Petunjuk konsep:* gunakan satu kerangka secara konsisten (mis. NIST CSF 2.0 untuk tata kelola, NIST Privacy Framework untuk pemrosesan). Label kerangka tanpa bukti proses tidak cukup.

**G1 — Gerbang 1:** prioritas risiko disetujui.

### Tahap 3 — Privasi dan BIA (30 Nov–2 Des)

**Q5. Proses pemrosesan mana yang perlu peninjauan dasar hukum, tujuan, minimisasi, retensi, atau akses? Kutip sumber resmi dan nyatakan fakta yang belum diketahui.**
*Petunjuk konsep:* data kesehatan adalah kategori khusus. Persetujuan bukan satu-satunya dasar, dan tidak semua pemrosesan boleh bersandar pada persetujuan.

**Q6. Apa dampak gangguan pada titik waktu 4 jam, 1 hari, dan 3 hari? Nyatakan asumsi volume dan dampak nonfinansial.**
*Petunjuk konsep:* hotline krisis bukan layanan biasa. Ada dampak yang tidak dapat dipulihkan.

**Q7. Berapa RTO/RPO yang diusulkan untuk dua layanan utama, dan mengapa layak atau tidak layak berdasarkan bukti backup/dependensi?**
*Petunjuk konsep:* RTO/RPO adalah janji. Bedakan target, kemampuan, dan harapan.

**G2 — Gerbang 2:** rujukan dan asumsi terlacak.

### Tahap 4 — Inject 1 (3–8 Des)

**Q8 (khusus kasus). Data konseling mana yang harus tetap tersedia saat akses dibatasi karena insiden?**
*Petunjuk konsep:* ketersediaan untuk keselamatan berbeda dari ketersediaan untuk administrasi. Pertimbangkan prinsip minimisasi dan kebutuhan klinis.

**Q9 (khusus kasus). Bagaimana menilai permintaan penghapusan saat bukti insiden perlu dipertahankan?**
*Petunjuk konsep:* ada dua kewajiban yang sah. Selesaikan cakupan, durasi, dan cara memberi tahu — bukan memilih salah satu secara mutlak.

**Q10 (khusus kasus). Kontrol vendor dan komunikasi apa yang diprioritaskan setelah inject baru?**
*Petunjuk konsep:* bedakan kontrol yang mengurangi kemungkinan, yang mengurangi dampak, dan yang memenuhi kewajiban.

**G3 — Gerbang 3:** keputusan tertulis (memo 1).

### Tahap 5 — Inject 2 dan tabletop (9–11 Des)

**Q11. Setelah inject kedua, keputusan apa yang berubah, siapa yang menyetujuinya, dan risiko sisa apa yang diterima secara sadar?**
*Petunjuk konsep:* perubahan keputusan harus dapat dilacak ke fakta tertentu. Risiko sisa butuh tanda tangan.

**G4 — Gerbang 4:** risiko sisa dan pemiliknya disetujui.

### Tahap 6 — Rencana dan presentasi (14–18 Des)

**Q12. Buat rencana 30/60/90 hari: tiga tindakan prioritas, pemilik, bukti selesai, uji BCP, dan informasi yang perlu dibawa ke pimpinan.**
*Petunjuk konsep:* rencana harus dapat dijalankan dengan pagu yang ada. Tindakan tanpa bukti selesai tidak dihitung.

**G5 — Gerbang 5:** paket final diserahkan 18 Desember 2026.

## 5. Deliverables (serahkan 18 Desember 2026)

| # | Berkas | Template | Isi minimum |
| :-: | --- | --- | --- |
| 1 | `risk-register.md` | `03-templates/risk-register.md` | ≥ 8 risiko, 3 prioritas, pemilik |
| 2 | `data-map.md` | `03-templates/data-map.md` | ≥ 8 kegiatan, aliran, peran, transfer |
| 3 | `bia.md` | `03-templates/bia.md` | 4 jam/1 hari/3 hari untuk ≥ 5 proses |
| 4 | `rto-rpo.md` | `03-templates/rto-rpo-worksheet.md` | ≥ 4 layanan + bukti kemampuan |
| 5 | `memo-inject-1.md` | `03-templates/decision-memo.md` | Keputusan D1.1–D1.6 |
| 6 | `memo-inject-2.md` | `03-templates/decision-memo.md` | Keputusan D2.1–D2.7 |
| 7 | `continuity-plan.md` | `03-templates/continuity-plan.md` | 3 skenario + prosedur manual |
| 8 | `executive-brief.md` | `03-templates/executive-brief.md` | Maks. 2 halaman |
| 9 | `slide.pdf` atau `slide.md` | — | 8–10 slide untuk 12 menit |

**Penamaan berkas:** gunakan nama di atas, simpan dalam satu folder `submission/`. Jangan mengubah template menjadi format lain tanpa alasan.

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

Rincian dimensi ada di `05-rubric/participant-rubric.md`.

## 7. Pertanyaan yang harus bisa Anda jawab saat presentasi

1. Mengapa risiko nomor satu Anda lebih penting daripada nomor dua?
2. Fakta mana yang membuat Anda mengubah keputusan? Tunjukkan dokumennya.
3. Angka RTO/RPO Anda berasal dari mana? Apa yang terjadi jika salah?
4. Siapa yang menanggung akibat jika keputusan Anda gagal?
5. Apa yang Anda putuskan untuk **tidak** dilakukan, dan mengapa?
6. Di mana Anda belum yakin, dan bagaimana Anda akan mengurangi ketidakpastian itu?

## 8. Larangan

- Menyalin jawaban kelompok lain.
- Mengarang nomor pasal, angka, atau kutipan kontrak.
- Menyebut data pribadi nyata atau organisasi nyata sebagai bagian skenario.
- Menyerahkan dokumen tanpa sumber untuk klaim hukum.

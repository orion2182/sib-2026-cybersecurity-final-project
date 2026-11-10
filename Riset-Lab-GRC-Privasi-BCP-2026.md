# Riset dan rancangan final project GRC, privasi, dan business continuity

**Status:** rancangan instruktur, 26 Oktober 2026. **Peserta:** 2 kelompok, 2 organisasi/kasus berbeda.  
**Kalender:** 20 November–23 Desember 2026, sesuai jadwal SIB yang sama.

## 1. Keputusan desain berbasis riset

Tema ini adalah **tabletop dan analisis dokumen**, bukan VAPT atau deployment aplikasi rentan. Gunakan [NIST CSF 2.0](https://www.nist.gov/cyberframework) untuk outcome tata kelola risiko, [NIST Privacy Framework](https://www.nist.gov/privacy-framework/privacy-framework) untuk risiko pemrosesan data, [NIST SP 800-34 Rev. 1](https://csrc.nist.gov/pubs/sp/800/34/r1/upd1/final) untuk BIA dan rencana kontinjensi, serta [ISO 22301:2019](https://www.iso.org/standard/75106.html) sebagai referensi prinsip BCMS. Untuk konteks Indonesia, mahasiswa harus menelusuri teks resmi [UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi](https://peraturan.bpk.go.id/Details/229798/uu-no-27-), memisahkan isi aturan, asumsi skenario, dan rekomendasi. Materi ini **latihan analitis, bukan pendapat hukum**; mentor memverifikasi rujukan pasal dan status aturan sebelum rilis kasus.

Kedua kasus sengaja mencakup **GRC, privasi, dan continuity**, tetapi penekanannya berbeda. Peserta menerima memo pimpinan, inventaris aset, data flow, kontrak/vendor ringkas, insiden simulasi, BIA worksheet, dan batas anggaran fiktif. Semua data pribadi adalah nama/record dummy. Nilai bukan berdasarkan banyaknya kontrol yang disebut, melainkan keterlacakan keputusan terhadap bukti dan trade-off.

## 2. Dua kasus yang berbeda

| Kelompok | Kasus dan tekanan utama | Paket mentor | Keputusan final |
| --- | --- | --- | --- |
| GRC-1 — **Layanan konseling mahasiswa** | Data sensitif diproses bersama vendor; ada laporan akses tak sesuai dan permintaan penghapusan data | Peta data, matriks peran, potongan kontrak pemroses, log akses dummy, kebijakan retensi yang saling bertentangan, memo pimpinan | Prioritas risiko dan kontrol, keputusan penanganan data, komunikasi insiden, dan kelangsungan layanan konseling saat akses dibatasi |
| GRC-2 — **Pendaftaran dan pembayaran kampus** | Layanan penting mati saat tenggat pendaftaran; backup dan vendor gagal sesuai asumsi awal | Daftar layanan/dependensi, volume transaksi dummy, jadwal akademik, catatan backup/restore, SLA vendor, skenario gangguan berjenjang | BIA, RTO/RPO yang beralasan, strategi layanan manual/failover, risiko privasi pada prosedur darurat, dan uji pemulihan |

Mentor menyediakan informasi **bertahap**: paket awal, satu inject pada 3–4 Des, dan satu inject pada 9–10 Des yang mengubah fakta. Ini menguji revisi keputusan, bukan hafalan dokumen. Instruktur menyimpan lembar keputusan referensi dan rentang jawaban yang masuk akal; tidak ada satu angka RTO/RPO yang benar tanpa asumsi.

## 3. Lab bertahap dan pertanyaan mahasiswa

### Task 1 — Mandat, stakeholder, dan aset (20–23 Nov)

**Situasi:** tim adalah penasihat risiko untuk organisasi fiktif. Pimpinan meminta rekomendasi yang dapat dijalankan dengan anggaran terbatas.

- **Q1.** Siapa pemilik keputusan, subjek data, vendor, dan pihak operasional yang terdampak?
- **Q2.** Aset, proses, data, dan dependensi apa yang paling kritis? Tandai fakta dan asumsi.

### Task 2 — Peta data dan profil risiko (24–27 Nov)

- **Q3.** Gambarkan aliran data dari pengumpulan sampai penghapusan; di mana data berpindah pengendali/pemroses atau melewati vendor?
- **Q4.** Pilih tiga risiko prioritas; jelaskan kemungkinan, dampak, pemilik risiko, kontrol saat ini, dan gap terhadap outcome CSF/Privacy Framework yang dipilih.

**Petunjuk:** outcome framework membantu menyusun keputusan; satu label framework tanpa bukti proses tidak cukup.

### Task 3 — Privasi dan BIA (30 Nov–8 Des)

- **Q5.** Proses pemrosesan mana yang perlu peninjauan dasar hukum, tujuan, minimisasi, retensi, atau akses? Kutip sumber resmi dan nyatakan fakta yang belum diketahui.
- **Q6.** Apa dampak gangguan pada titik waktu 4 jam, 1 hari, dan 3 hari? Nyatakan asumsi volume dan dampak nonfinansial.
- **Q7.** Berapa RTO/RPO yang diusulkan untuk dua layanan utama, dan mengapa layak atau tidak layak berdasarkan bukti backup/dependensi?

**Pertanyaan khusus kasus:**

| Kasus | Q8 | Q9 | Q10 |
| --- | --- | --- | --- |
| GRC-1 | Data konseling mana harus tetap tersedia saat akses insiden dibatasi? | Bagaimana menilai permintaan penghapusan saat bukti insiden perlu dipertahankan? | Kontrol vendor dan komunikasi apa yang diprioritaskan setelah inject baru? |
| GRC-2 | Proses pendaftaran mana harus berlanjut secara manual saat sistem mati? | Bukti apa yang menunjukkan target pemulihan tidak sesuai kemampuan backup saat ini? | Bagaimana prosedur darurat mencegah paparan data mahasiswa di daftar manual? |

**Bukti:** risk register, data map, BIA, tabel RTO/RPO, rujukan resmi, serta memo perubahan keputusan ketika inject tiba.

### Task 4 — Tabletop keputusan (9–11 Des)

- **Q11.** Setelah inject kedua, keputusan apa yang berubah, siapa menyetujuinya, dan risiko sisa apa yang diterima secara sadar?

### Task 5 — Rencana dan presentasi (14–18 Des)

- **Q12.** Buat rencana 30/60/90 hari: tiga tindakan prioritas, pemilik, bukti selesai, uji BCP, dan informasi yang perlu dibawa ke pimpinan.

**Serahkan 18 Des:** risk register, data map, BIA, rekomendasi privasi, rencana kontinuitas, dua memo inject, executive brief, dan slide. Presentasi 21–23 Des mencakup pembelaan keputusan individu.

## 4. Timeline fase dan gerbang

| Tanggal | Pekerjaan dan gerbang |
| --- | --- |
| 20–23 Nov | Mandat, stakeholder, dokumen awal; **G0: scope dan asumsi disetujui** |
| 24–27 Nov | Aset, data flow, dependensi, risk register awal; **G1: prioritas risiko** |
| 30 Nov–2 Des | Privasi, BIA, RTO/RPO draf; **G2: rujukan dan asumsi terlacak** |
| 3–8 Des | Inject pertama, revisi opsi kontrol/continuity; **G3: keputusan tertulis** |
| 9–11 Des | Inject kedua dan tabletop pimpinan; **G4: risiko sisa dan pemiliknya** |
| 14–18 Des | Rencana 30/60/90 hari, gladi 16–18 Des; **G5: paket final** |
| 21–23 Des | Presentasi/pengujian sesuai slot |

## 5. Rubrik dan persiapan mentor

| Komponen | Poin |
| --- | ---: |
| Inventaris, stakeholder, dan keterlacakan asumsi | 15 |
| Analisis dan prioritas risiko | 20 |
| Peta data dan analisis privasi dengan sumber resmi | 20 |
| BIA, RTO/RPO, dan strategi continuity | 20 |
| Keputusan inject, komunikasi pimpinan, rencana aksi | 15 |
| Tanya jawab kontribusi individu | 10 |
| **Total** | **100** |

**Checklist mentor sebelum 20 Nov:** buat dua organisasi fiktif dan 2–3 dokumen yang saling tidak lengkap secara sengaja; periksa tidak ada PII asli; siapkan paket awal dan dua inject per kasus; tetapkan rentang jawaban serta alasan trade-off yang dapat diterima; review sumber hukum resmi dan tanggal berlakunya; siapkan template risk register, data map, BIA, RTO/RPO, dan executive brief; jalankan pilot buta dan uji apakah kasus dapat diselesaikan tanpa akses sistem produksi. Tidak diperlukan Docker, VPS, scanner, atau eksploitasi untuk tema ini.

**Batas saat ini:** dokumen kasus dan inject belum dibuat. Analisis kewajiban UU PDP perlu dikunci mentor sesuai teks resmi pada saat paket dirilis. Kalender harian terperinci tercantum pada Google Sheets mentor lintas tema.

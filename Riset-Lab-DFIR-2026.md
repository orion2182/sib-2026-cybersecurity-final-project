# Riset dan rancangan final project Digital Forensics & Incident Response (DFIR)

**Status:** rancangan instruktur, 26 Oktober 2026. **Peserta:** 3 kelompok, 3 kasus berbeda.  
**Kalender:** 20 November–23 Desember 2026; tanggal mentorship, gladi, dan presentasi mengikuti kalender SIB yang sama dengan VAPT.

## 1. Keputusan desain berbasis riset

Gunakan **NIST SP 800-61 Rev. 3** untuk keputusan respons dan pemulihan, serta **NIST SP 800-86** untuk akuisisi, pemeriksaan, analisis, dan pelaporan bukti digital. SP 800-61 Rev. 3 berhubungan dengan CSF 2.0; SP 800-86 adalah panduan forensik dalam konteks IR, bukan prosedur pembuktian hukum universal. Karena itu lab ini menilai kemampuan membangun kronologi, memisahkan fakta dari dugaan, dan merekomendasikan respons proporsional. Tidak perlu memaksakan PTES, eksploitasi, atau ROE VAPT. [NIST SP 800-61 Rev. 3](https://csrc.nist.gov/pubs/sp/800/61/r3/final), [NIST SP 800-86](https://csrc.nist.gov/pubs/sp/800/86/final).

Setiap kelompok menerima **paket bukti statis sintetis** dan surat penugasan insiden. Original evidence bersifat baca-saja; mahasiswa bekerja pada salinan, memverifikasi hash SHA-256, menjaga daftar perpindahan bukti, serta mencatat zona waktu sumber dan konversi WIB. Tidak ada malware aktif, endpoint nyata, akun cloud sungguhan, atau data pribadi nyata. Mentor menyimpan ground truth dan bukti penyangkal agar mahasiswa tidak cukup menebak satu IOC.

## 2. Tiga kasus yang berbeda

| Kelompok | Narasi | Paket bukti yang disiapkan mentor | Keputusan utama yang harus dijawab |
| --- | --- | --- | --- |
| DFIR-1 — **Phishing akun staf** | Staf membuka tautan login tiruan; muncul aktivitas akun tak lazim | Email EML/header sintetis, log sign-in, riwayat browser SQLite, EVTX/Sysmon terkurasi, daftar tindakan helpdesk | Kapan akses tidak sah mulai, akun/aset mana terdampak, dan bagaimana mengamankan akun sambil menjaga bukti? |
| DFIR-2 — **Intrusi aplikasi perpustakaan** | Layanan web fiktif menunjukkan perubahan berkas dan permintaan HTTP mencurigakan | Access/error log, log aplikasi, snapshot direktori kecil, audit perubahan konfigurasi, hash file, log jaringan terpilih | Jalur masuk yang paling didukung bukti, rentang perubahan, dan batas dampak yang belum dapat dipastikan? |
| DFIR-3 — **Penyalahgunaan identitas cloud simulasi** | Identitas layanan melakukan akses objek di luar pola normal | Cloud audit JSON sintetis, IAM policy snapshot, daftar objek dummy, log token terpotong/tersanitasi, catatan perubahan izin | Perubahan izin dan urutan akses apa yang relevan, tindakan containment apa yang aman, dan data dummy apa yang mungkin terpapar? |

Kesetaraan dinilai lewat pilot buta: setiap paket mempunyai 5–8 artefak utama, 2–3 petunjuk pengalih yang masuk akal, satu kronologi yang dapat direkonstruksi, serta satu ketidakpastian yang harus dinyatakan. Ukuran paket **target <2 GB** dan dapat dibaca tanpa VM besar; batas ini adalah desain awal yang perlu diuji. Kasus berbeda pada jenis bukti dan hipotesis, sementara rubriknya sama.

## 3. Lab bertahap dan pertanyaan mahasiswa

Format setiap bagian: situasi, tujuan, artefak yang boleh dipakai, pertanyaan, bentuk bukti, lalu petunjuk konsep. Pertanyaan di bawah **belum berisi jawaban**; nilai hash, timestamp, event ID, dan akun diisi setelah paket dibuat.

### Task 1 — Terima mandat dan bukti (20–23 Nov)

**Situasi:** tim menjadi analis insiden untuk organisasi fiktif. Sebelum analisis, tim harus tahu pertanyaan investigasi dan memastikan paket bukti tidak berubah.

- **Q1.** Apa mandat, sistem/akun yang tercakup, dan tiga pertanyaan investigasi yang akan dijawab? **Bukti:** tabel scope dan batas klaim.
- **Q2.** Berapa artefak diterima, apa hash asli dan salinan kerja, serta siapa memegangnya pada tiap tahap? **Bukti:** register bukti dan hasil verifikasi hash.

**Petunjuk:** nama berkas saja tidak membuktikan integritas. Catat sumber waktu tiap artefak.

### Task 2 — Triage dan hipotesis (24–27 Nov)

**Situasi:** banyak kejadian tampak mencurigakan, tetapi sebagian adalah aktivitas sah atau belum cukup konteks.

- **Q3.** Artefak mana yang paling relevan dan mana yang mungkin pengalih? Jelaskan dasar prioritas.
- **Q4.** Buat dua hipotesis yang saling bersaing tentang apa yang terjadi. Bukti apa yang dapat membedakannya?
- **Q5.** Susun lima peristiwa awal dalam urutan WIB, sertakan waktu sumber, zona waktu, dan tingkat kepastian.

**Petunjuk:** jangan mengubah timestamp asli; tampilkan konversi sebagai kolom terpisah.

### Task 3 — Analisis khusus kasus (30 Nov–8 Des)

**DFIR-1:** **Q6** email/URL apa yang menghubungkan pesan dengan tindakan pengguna? **Q7** sign-in mana menunjukkan penyimpangan dibanding baseline? **Q8** artefak endpoint mana mendukung atau menyangkal akses pasca-login?

**DFIR-2:** **Q6** rangkaian request dan log apa mendahului perubahan file? **Q7** file/config mana berubah dan apa bukti integritasnya? **Q8** apakah ada bukti akses lanjutan, atau hanya indikasi awal?

**DFIR-3:** **Q6** perubahan izin apa mendahului akses objek? **Q7** panggilan audit mana menunjukkan objek dummy yang benar-benar dibaca/diubah? **Q8** identitas dan rentang waktu mana yang dapat dibuktikan, bukan diasumsikan?

**Bukti Q6–Q8:** tabel peristiwa dengan sumber, ID event, hash/record ID, penjelasan alternatif, dan tingkat kepastian. Satu string IOC tanpa konteks tidak cukup.

### Task 4 — Respons dan cakupan (9–11 Des)

- **Q9.** Apa containment segera yang menjaga bukti, dan apa konsekuensi operasionalnya?
- **Q10.** Apa dampak yang **terbukti**, apa yang masih mungkin, serta bukti tambahan yang diperlukan sebelum memperluas klaim?

**Petunjuk:** urutan containment dapat berbeda bila bukti volatil perlu diamankan lebih dahulu. Diskusikan trade-off sesuai mandat.

### Task 5 — Laporan dan pemulihan (14–18 Des)

- **Q11.** Tulis kronologi final dengan sedikitnya satu alternatif yang ditolak beserta alasannya.
- **Q12.** Usulkan eradikasi/pemulihan, pemilik tindakan, verifikasi setelah pemulihan, dan dua perbaikan proses agar kasus serupa lebih cepat ditangani.

**Serahkan 18 Des:** register bukti, timeline, matriks hipotesis, laporan insiden, executive summary, dan slide. Presentasi serta pengujian individu pada 21–23 Des.

## 4. Timeline fase dan gerbang

| Tanggal | Pekerjaan dan gerbang |
| --- | --- |
| 20–23 Nov | Mandat, paket bukti, hash, chain of custody; **G0: bukti diterima dan tervalidasi** |
| 24–27 Nov | Triage, baseline, hipotesis, timeline awal; **G1: hipotesis dapat diuji** |
| 30 Nov–2 Des | Analisis silang artefak dan review false lead; **G2: rencana bukti final** |
| 3–8 Des | Rekonstruksi peristiwa dan jawaban kasus; **G3: Q6–Q8 dengan bukti** |
| 9–11 Des | Containment, cakupan, pemulihan awal; **G4: keputusan IR beralasan** |
| 14–18 Des | Laporan, latihan presentasi 16–18 Des; **G5: laporan final** |
| 21–23 Des | Presentasi/pengujian sesuai slot yang ditetapkan mentor |

## 5. Rubrik dan persiapan mentor

| Komponen | Poin |
| --- | ---: |
| Integritas, register, dan batas bukti | 15 |
| Triage dan hipotesis alternatif | 15 |
| Korelasi artefak dan kronologi | 25 |
| Penilaian dampak serta keputusan respons | 20 |
| Laporan, ketidakpastian, dan pemulihan | 15 |
| Tanya jawab kontribusi individu | 10 |
| **Total** | **100** |

**Checklist mentor sebelum 20 Nov:** buat tiga paket asli dan salinan kerja; hasilkan manifest hash; pastikan timestamp dan zona waktu konsisten; siapkan baseline aktivitas sah dan false leads; buat ground truth terpisah; uji bahwa Q1–Q12 dapat dijawab; verifikasi tidak ada PII/malware aktif; ukur ukuran paket, waktu unduh, dan pembukaan pada laptop 8 GB; siapkan mekanisme pembagian hanya untuk kelompok terkait; pilot buta setiap kasus.

**Batas saat ini:** paket bukti dan ground truth belum dibuat. Keputusan bahwa 8 GB memadai untuk tiga kasus masih memerlukan pilot pada artefak final. Kalender harian terperinci tercantum pada Google Sheets mentor lintas tema.

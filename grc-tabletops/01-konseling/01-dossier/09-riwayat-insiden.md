# 09 — Riwayat Insiden

**Dokumen:** catatan insiden 2025–2026 yang berhasil direkonstruksi
**Sumber:** tiket TI, surel, laporan lisan
**Catatan:** tidak ada satu pun insiden yang dinilai sebagai "insiden privasi" pada saat kejadian.

---

## 1. Ringkasan

| # | Tanggal | Peristiwa | Data terdampak | Tindakan saat itu | Pelajaran yang tidak diambil |
| --- | --- | --- | --- | --- | --- |
| I-1 | 12 Feb 2025 | Surel ringkasan sesi salah kirim ke mahasiswa lain | 1 catatan sesi | Permintaan maaf lisan | Tidak ada kontrol tujuan surel; tidak ada notifikasi |
| I-2 | 8 Nov 2025 | Laptop konselor hilang di transportasi umum | 214 catatan sesi (cache lokal), 60 lampiran | Lapor polisi; akun dinonaktifkan 3 hari kemudian | BitLocker tidak aktif; tidak ada evaluasi dampak |
| I-3 | 17 Mar 2026 | Mahasiswa magang memakai akun `konselor01` dan membuka 42 rekam | 42 rekam | Magang dihentikan | Akun bersama tetap dipakai; tidak ada notifikasi |
| I-4 | 5 Agu 2026 | Hotline mati 3 jam 07.00–10.00 (gangguan ISP vendor) | 27 panggilan masuk voicemail | Vendor minta maaf | Tidak ada nomor cadangan; tidak ada uji |

## 2. Detail

### I-1 — Salah kirim surel (12 Feb 2025)

- Konselor mengirim ringkasan sesi ke alamat `mhs.***@uca.ac.id` yang mirip dengan alamat pasien.
- Penerima membalas: "Ini bukan saya."
- Tidak ada pencatatan di tiket TI karena dianggap "kesalahan manusia".
- **Tidak ada** penilaian apakah data kesehatan terungkap, **tidak ada** pemberitahuan, **tidak ada** perubahan prosedur.
- Dampak yang mungkin: satu mahasiswa mengetahui kondisi psikologis mahasiswa lain.

### I-2 — Laptop hilang (8 Nov 2025)

- Laptop konselor berisi cache SIPKON offline (fitur yang diaktifkan tanpa persetujuan UPT TIK).
- 214 catatan sesi dan 60 lampiran tersimpan lokal tanpa enkripsi.
- Pelaporan ke polisi dilakukan hari yang sama; akun dinonaktifkan **tiga hari** kemudian.
- Tidak ada penilaian risiko, tidak ada pemberitahuan kepada 214 mahasiswa.
- Vendor tidak diberitahu; sesi di perangkat lain tidak dicabut.

### I-3 — Akses magang (17 Mar 2026)

- Seorang mahasiswa magang administrasi memakai akun bersama untuk membuka 42 rekam, termasuk 7 rekam dengan skor risiko tinggi.
- Tidak ada log baca; temuan berasal dari laporan lisan seorang konselor.
- Sanksi: magang dihentikan. Tidak ada analisis apakah data disalin.
- **Kemungkinan pelanggaran kewajiban** untuk mencegah akses tidak sah dan mencatat pemrosesan. Tim harus menilai sendiri dasar hukumnya.

### I-4 — Hotline mati (5 Agu 2026)

- Gangguan ISP vendor selama 3 jam pada jam sibuk pagi.
- Panggilan dialihkan ke voicemail sesuai kontrak.
- 27 panggilan masuk; 2 di antaranya dinilai "mendesak" setelah didengar keesokan harinya.
- Tidak ada nomor cadangan, tidak ada pengumuman ke mahasiswa, tidak ada eskalasi ke Tim Siaga.

## 3. Pola yang terlihat

1. **Tidak ada klasifikasi.** Tidak satu pun insiden dilabeli "insiden privasi", sehingga kewajiban pemberitahuan tidak pernah dipertimbangkan.
2. **Tidak ada ambang.** Tidak ada kriteria kapan harus melapor ke pimpinan, ke subjek data, atau ke lembaga.
3. **Tidak ada pembelajaran.** Tidak ada laporan pasca-insiden, tidak ada perubahan kontrol.
4. **Akar masalah berulang:** akun bersama, perangkat tanpa enkripsi, tidak ada jalur cadangan hotline.
5. **Deteksi bergantung pada kebetulan.** Dua dari empat insiden ditemukan bukan oleh kontrol.

## 4. Dampak kumulatif

| Aspek | Perkiraan |
| --- | --- |
| Subjek data yang mungkin terdampak (2025–2026) | 257 (dengan kemungkinan tumpang tindih) |
| Pemberitahuan yang dilakukan | 0 |
| Perubahan kontrol yang dihasilkan | 1 (nonaktifkan akun setelah 3 hari) |
| Biaya yang dikeluarkan | Rp 0 untuk remediasi; Rp 0 untuk notifikasi |

## 5. Kesaksian yang relevan

> "Kami tidak pernah berpikir itu 'data breach'. Kami pikir itu kesalahan operasional." — Admin UPT, wawancara 24 Okt 2026

> "Kalau saya lapor setiap kejadian kecil, saya akan dianggap tidak kompeten." — Konselor, wawancara 24 Okt 2026

Kedua kutipan menunjukkan masalah **budaya pelaporan**, bukan hanya kontrol teknis.

## 6. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Insiden mana yang, jika terulang bulan ini, akan **wajib** dilaporkan menurut hukum? Cari dasar hukumnya.
- Apakah insiden 2025–2026 masih menimbulkan kewajiban yang belum dipenuhi?
- Perubahan kontrol mana yang harus didahulukan agar pola ini berhenti berulang?

# INJECT 1 — Pemberitahuan Vendor dan Temuan Subprosesor

**Buka dokumen ini hanya pada: Kamis, 3 Desember 2026, pukul 10.00 WIB**
**Jangan membaca lebih awal.** Membaca sebelum tanggal membatalkan latihan revisi keputusan.
**Durasi pengerjaan setelah dibuka:** 60–75 menit, lalu serahkan memo revisi.

---

## 1. Surel yang diterima

**Dari:** `dpo@heningcloud.co.id` (PT Hening Cloud Nusantara)
**Kepada:** Kepala UPT-LPK; DPO UCA; Kepala UPT TIK
**Waktu:** 3 Desember 2026, 09.12 WIB
**Subjek:** Pemberitahuan Insiden Keamanan — Akun Penyimpanan Objek

> Yth. Bapak/Ibu,
>
> Kami memberitahukan adanya konfigurasi akses yang tidak semestinya pada bucket penyimpanan objek yang dikelola subprosesor kami, Nimbus Object Storage Pte. Ltd. (Singapura). Bucket tersebut memuat lampiran dan ekspor percakapan yang terkait dengan akun layanan Universitas Cendekia Arunika.
>
> Ringkasan temuan kami:
> - Konfigurasi akses publik berlaku sejak 19 November 2026 hingga 30 November 2026 (11 hari).
> - Sebanyak **1.140 objek** dapat diakses tanpa autentikasi selama periode tersebut.
> - Dari jumlah itu, **61 objek** merupakan catatan sesi konseling. Objek-objek tersebut terkait dengan **214 mahasiswa** (beberapa objek per mahasiswa).
> - Log akses terperinci hanya tersedia untuk **5 hari terakhir**; log sebelumnya tidak diaktifkan pada bucket tersebut.
> - Seorang peneliti keamanan independen melaporkan temuan ini pada 30 November 2026. Kami menutup akses dalam 41 menit setelah laporan.
> - Berdasarkan log yang ada, **kami tidak menemukan bukti pengunduhan**. Namun kami tidak dapat menyatakan dengan pasti bahwa tidak ada akses.
>
> Kami memahami bahwa pemberitahuan ini penting bagi kewajiban Anda. Kami dapat mengirimkan kuesioner tindak lanjut dalam 5 hari kerja. Audit di lokasi tidak tersedia sesuai ketentuan kontrak.
>
> Hormat kami,
> Fungsi Privasi Hening Cloud

## 2. Fakta baru (yang belum ada di dossier)

| # | Fakta | Sumber | Dampak pada analisis |
| --- | --- | --- | --- |
| F1 | Subprosesor Nimbus **tidak pernah** disetujui tertulis oleh UCA | kontrak + korespondensi | Peran dan tanggung jawab perlu dinilai ulang |
| F2 | Bucket publik 19–30 Nov 2026; ditutup 30 Nov | surel vendor | Rentang paparan 11 hari |
| F3 | 1.140 objek terekspos; 61 catatan sesi; 214 mahasiswa terkait | surel vendor | Skala dan sifat data |
| F4 | Log akses hanya 5 hari | surel vendor | Tidak dapat membuktikan ada/tidaknya akses |
| F5 | Vendor menolak audit di lokasi | kontrak + surel | Kualitas jaminan mendatang |
| F6 | Vendor menawarkan kuesioner, bukan bukti | surel vendor | Kredibilitas investigasi |
| F7 | Notifikasi tiba pada jam ke-68 sejak vendor "mengonfirmasi" | cap waktu surel | Menyisakan waktu sangat sedikit bagi UCA |
| F8 | Kontrak berakhir 31 Desember 2026; belum diperpanjang | Biro Hukum | Tekanan waktu ganda |

**Yang masih belum diketahui (U):** apakah ada pihak yang benar-benar mengunduh; apakah objek yang terekspos memuat identitas lengkap; apakah salinan cache ada di perangkat konselor; apakah vendor akan menanggung biaya notifikasi.

## 3. Potongan lain yang menempel pada surel

**Lampiran A — kutipan konfigurasi (diterima apa adanya):**
```
bucket: uca-prod-attachments
acl: public-read          # sejak 19-11-2026 02:14
encryption: SSE-S3 (kunci dikelola Nimbus)
logging: disabled          # diaktifkan 30-11-2026
object_count: 1,140
prefixes: /sessions/, /chat-exports/, /referrals/
```

**Lampiran B — tanggapan Nimbus (diteruskan vendor):**
> "Kami menganggap ini kesalahan konfigurasi, bukan pelanggaran keamanan. Tidak ada indikasi akses tidak sah. Kami tidak dapat memberikan log di luar 5 hari karena kebijakan retensi kami."

## 4. Apa yang berubah

Sebelum inject ini, tim dapat berasumsi bahwa:
- data hanya berada di vendor utama yang punya DPA;
- tidak ada kejadian yang memicu kewajiban pemberitahuan;
- waktu masih cukup untuk memperbaiki kontrak.

Setelah inject ini, asumsi tersebut tidak berlaku. Tim harus meninjau ulang minimal:
1. apakah ini peristiwa yang **wajib** diberitahukan, kepada siapa, dan dalam tenggat berapa;
2. siapa yang harus memutuskan, dan apakah keputusan boleh menunggu investigasi lengkap;
3. apakah layanan chat/video harus dihentikan sementara, dan apa konsekuensinya bagi mahasiswa;
4. apakah dasar pemrosesan dan jaminan transfer lintas negara masih dapat dipertahankan;
5. apakah 214 mahasiswa harus dihubungi secara individual atau cukup pemberitahuan umum;
6. dari mana biaya notifikasi, pendampingan, dan penguatan kontrol diambil.

## 5. Keputusan yang diminta (tulis, jangan dijawab lisan)

| Kode | Keputusan | Tenggat internal yang harus tim tetapkan | Pemilik yang harus disebut |
| --- | --- | --- | --- |
| D1.1 | Apakah peristiwa ini dilaporkan? Kepada siapa saja? | ... | ... |
| D1.2 | Isi pemberitahuan: data apa, kapan, bagaimana, upaya apa | ... | ... |
| D1.3 | Apakah layanan chat/video dihentikan, dibatasi, atau dilanjutkan dengan kontrol tambahan | ... | ... |
| D1.4 | Apakah 214 mahasiswa dihubungi langsung; siapa yang menulis dan menyetujui | ... | ... |
| D1.5 | Nasib kontrak Hening (lanjut, negosiasi ulang, hentikan) dan alternatifnya | ... | ... |
| D1.6 | Sumber dana untuk biaya tak terduga | ... | ... |

## 6. Petunjuk waktu (untuk fasilitator dan tim)

| Waktu | Aktivitas | Keluaran |
| --- | --- | --- |
| 10.00–10.10 | Membaca surel dan lampiran | Daftar fakta F/U |
| 10.10–10.30 | Menilai apakah kewajiban pemberitahuan berlaku; tetapkan tenggat | D1.1, D1.2 |
| 10.30–10.50 | Menilai dampak layanan; pilih opsi pembatasan | D1.3 |
| 10.50–11.05 | Menyusun pesan ke mahasiswa (maks. 200 kata) | Draf pemberitahuan |
| 11.05–11.15 | Menetapkan pemilik, biaya, dan risiko sisa | D1.4–D1.6 |
| Paling lambat 4 Des 16.00 | Serahkan memo revisi (template `03-templates/decision-memo.md`) | Memo 2 halaman |

**Aturan:** jangan menunggu informasi lengkap. Jika informasi tidak ada, tulis asumsinya dan siapa yang harus mengonfirmasi.

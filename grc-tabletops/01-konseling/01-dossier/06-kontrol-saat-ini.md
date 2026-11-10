# 06 — Kontrol Saat Ini

**Dokumen:** penilaian mandiri kontrol, 30 Oktober 2026
**Catatan:** penilaian ini dilakukan oleh UPT TIK tanpa kerangka acuan formal. Skala: 0 = tidak ada, 1 = ad hoc, 2 = terdokumentasi, 3 = diterapkan dan diuji.

---

## 1. Kontrol tata kelola

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| G-1 | Kebijakan PDP yang berlaku | 1 | Dokumen 2023 | Belum diperbarui; tidak menyebut data kesehatan |
| G-2 | Pejabat/petugas fungsi PDP | 2 | SK Rektor Sep 2026 | Rangkap jabatan; tanpa staf; belum punya prosedur |
| G-3 | Daftar kegiatan pemrosesan | 0 | — | Tidak ada |
| G-4 | Penilaian dampak (DPIA) | 0 | — | Tidak pernah; padahal data spesifik skala besar |
| G-5 | Manajemen risiko formal | 0 | — | Tidak ada risk register |
| G-6 | Kebijakan retensi terpadu | 0 | 4 dokumen berbeda | Lihat `05-jadwal-retensi.md` |
| G-7 | Prosedur permintaan subjek data | 1 | Surel ke DPO | Tanpa SLA, tanpa formulir, tanpa catatan |
| G-8 | Pelatihan privasi berkala | 1 | 1 sesi Agu 2025 | Kehadiran 46%; tidak diulang |
| G-9 | Uji kelangsungan layanan | 0 | — | Tidak pernah |

## 2. Kontrol akses

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| AC-1 | Akun unik per pengguna | 1 | Akun `konselor01` dipakai 3 orang | Tidak ada atribusi tindakan |
| AC-2 | MFA untuk konselor | 0 | Hanya 3 akun admin SSO | Kata sandi lemah dapat menembus |
| AC-3 | Pemisahan peran (konselor/admin) | 1 | Admin dapat membuka semua catatan | Tidak ada pembatasan berdasarkan kasus |
| AC-4 | Pencatatan akses baca | 0 | Hanya login | Tidak dapat menjawab "siapa membaca rekam X" |
| AC-5 | Pencabutan akses saat keluar | 1 | Checklist manual | 2 mantan konselor masih aktif hingga Sep 2026 |
| AC-6 | Akun vendor | 1 | Dapat impersonate dengan tiket | Tidak ada persetujuan UCA per sesi |
| AC-7 | Kunci perangkat | 2 | BitLocker 5/9 laptop | 4 laptop tanpa enkripsi |

## 3. Kontrol data

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| D-1 | Enkripsi at-rest | 2 | Diklaim vendor | Kunci dipegang vendor; tanpa BYOK |
| D-2 | Enkripsi in-transit | 2 | TLS 1.2 | Tidak ada uji konfigurasi |
| D-3 | Minimisasi field intake | 0 | Formulir meminta 19 field | Termasuk riwayat keluarga yang tidak dipakai |
| D-4 | Klasifikasi data | 0 | 4 skema berbeda | Lihat `04-inventaris-aset.md` |
| D-5 | DLP / kontrol ekspor | 0 | — | Ekspor XLSX bebas |
| D-6 | Penghapusan terjadwal | 0 | — | Lihat `05-jadwal-retensi.md` |
| D-7 | Register pemusnahan | 0 | — | Tidak ada |
| D-8 | Anonimisasi/pseudonimisasi | 0 | — | Pelaporan memakai NIM |

## 4. Kontrol vendor

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| V-1 | Due diligence sebelum kontrak | 1 | Checklist 2024 | Tidak ada bukti keamanan independen |
| V-2 | DPA yang memadai | 1 | DPA 2024 | Tanpa subprosesor, audit, bantuan hak subjek |
| V-3 | Daftar subprosesor | 0 | — | Nimbus tidak tercatat |
| V-4 | Hak audit | 0 | Kuesioner saja | Tidak dapat memverifikasi |
| V-5 | Uji restore | 0 | — | Tidak pernah |
| V-6 | Rencana keluar (exit plan) | 0 | — | Kontrak berakhir 31 Des 2026 |
| V-7 | Pemantauan SLA | 1 | Laporan bulanan vendor | Tidak diverifikasi |

## 5. Kontrol insiden

| # | Kontrol | Status | Bukti | Celah |
| --- | --- | :-: | --- | --- |
| IR-1 | Rencana respons insiden | 1 | Dokumen TI 2023 | Fokus gangguan sistem, bukan privasi |
| IR-2 | Peran dan kontak | 1 | Daftar telepon | Tidak ada piket 24/7 |
| IR-3 | Playbook pemberitahuan | 0 | — | Tidak ada template, tidak ada ambang |
| IR-4 | Pencatatan insiden | 1 | Tiket TI | Insiden privasi tidak dikategorikan |
| IR-5 | Pelajaran pasca-insiden | 0 | — | Tidak ada |
| IR-6 | Komunikasi ke mahasiswa | 0 | — | Tidak ada saluran resmi |

## 6. Ringkasan

| Kelompok | Rata-rata | Catatan |
| --- | :-: | --- |
| Tata kelola | 0,6 | Hampir seluruhnya ad hoc |
| Akses | 0,9 | Akun bersama dan tanpa MFA adalah akar masalah |
| Data | 0,5 | Tidak ada siklus hidup data |
| Vendor | 0,4 | Ketergantungan tinggi, kendali rendah |
| Insiden | 0,5 | Tidak siap menghadapi kewajiban pemberitahuan |

**Kesimpulan penilaian mandiri (kutipan):**
> "Kontrol yang ada cukup untuk operasi normal, tetapi tidak cukup untuk membuktikan kepatuhan atau bertahan pada insiden pertama yang serius."

## 7. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Tiga celah mana yang **paling** memperbesar dampak jika insiden terjadi bulan ini?
- Kontrol mana yang **wajib** ada sebelum 31 Desember 2026 karena kontrak vendor berakhir?
- Kontrol mana yang dapat ditunda tanpa menaikkan risiko secara tidak dapat diterima?

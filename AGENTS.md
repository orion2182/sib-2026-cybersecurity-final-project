# Konteks untuk OpenCode: Final Project Cyber Security SIB 2026

## Tujuan dan status

- Program menampung 65 mahasiswa dalam 13 kelompok berisi lima orang. Alokasi: VAPT 3, DFIR 3, SOC 3, GRC/privasi/BCP 2, DevSecOps/supply chain 2.
- Kalender pengerjaan tetap 20 November–18 Desember 2026, gladi 16–18 Desember, dan presentasi/pengujian 21–23 Desember. Gunakan rincian harian pada snapshot XLSX atau Google Sheet mentor.
- Per 10 November 2026, dokumen riset, spesifikasi, dan integrasi Spec Kit tersedia. Aplikasi VAPT, dataset SOC, paket bukti DFIR, paket tabletop GRC, dan repositori kasus DevSecOps belum selesai dibangun atau diuji. Jangan menyebut suatu lab siap dibagikan sebelum pilot dan pemeriksaan rilis.
- Pengajar menyediakan semua aset dan target. Mahasiswa harus dapat menjawab pertanyaan bertahap dengan bukti; tiap kelompok dalam tema yang sama mendapat kasus/target berbeda untuk mengurangi penyalinan.

## Peta sumber yang harus dibaca

1. Baca `README.md` untuk peta empat repository dan cara menyiapkan laptop lain.
2. Untuk VAPT, baca `Riset-Rancangan-VAPT-KampusMart-2026.md`, `Arsitektur-Lab-VAPT-KampusMart-Lokal.md`, lalu `vapt-labs/AGENTS.md` dan spesifikasi fitur terkait. PTES dan persetujuan Rules of Engagement berlaku sebelum peserta menguji target.
3. Untuk DFIR, baca `Riset-Lab-DFIR-2026.md`. Tiga kasus: phishing staf, intrusi aplikasi perpustakaan, dan penyalahgunaan identitas cloud simulasi. Lab berupa paket bukti sintetis, hash, kronologi, hipotesis, dan rekomendasi respons.
4. Untuk SOC, baca `Riset-Lab-SOC-2026.md`, lalu `soc-labs/AGENTS.md` dan spesifikasi. Tiga kasus: account takeover API, eksekusi endpoint, dan beacon DNS/jaringan. Lakukan replay log statis, deteksi, tuning, triase, dan pengujian holdout.
5. Untuk GRC/privasi/BCP, baca `Riset-Lab-GRC-Privasi-BCP-2026.md`. Dua kasus: layanan konseling dan pendaftaran/pembayaran kampus. Lab berupa dokumen dan tabletop dengan inject bertahap; tidak perlu memaksakan Docker atau Spec Kit.
6. Untuk DevSecOps, baca `Riset-Lab-DevSecOps-Supply-Chain-2026.md`, lalu `devsecops-labs/AGENTS.md` dan spesifikasi. Dua kasus: CampusAPI release gate dan BuildGate provenance.

## Cara bekerja di repository publik ini

- Repository induk adalah sumber perencanaan. Tiga direktori lab diabaikan oleh Git induk karena masing-masing punya remote sendiri. Jalankan Git dan OpenCode dari repository lab yang benar saat mengimplementasikan kasus tersebut.
- OpenCode membaca `AGENTS.md` pada root repository tempat ia dijalankan. Jalankan `opencode` dari dalam `vapt-labs/`, `soc-labs/`, atau `devsecops-labs/` untuk pekerjaan lab; jangan menjalankan Spec Kit dari direktori induk.
- Ketiga repository lab berisi `.opencode/commands/` dan integrasi Spec Kit 1.2.3. Pilih fitur aktif memakai `scripts/select_feature.py` sebelum perintah `/speckit.plan` dan tahapan berikutnya. Spesifikasi yang ada berstatus *ready for planning*, belum implementasi.
- Simpan kunci jawaban, label holdout, golden artifact, seed rahasia, kredensial, dan data pribadi nyata di luar repository publik. Jangan commit file itu. `docs/reference/` adalah bahan pembangunan dan dapat mengandung petunjuk solusi, sehingga bukan paket untuk mahasiswa.
- Gunakan data sintetis, lingkungan lokal/terisolasi, dan uji hanya pada instance lab yang diotorisasi. Ukur resource pada laptop 8 GB sebelum mengklaim kelayakan.
- Setiap perubahan implementasi harus punya bukti fungsi normal, kondisi sengaja gagal/terdeteksi, hasil setelah perbaikan, dan cara reset atau reproduksi sesuai tema. Kalibrasi kesetaraan kasus melalui pilot buta.

## Prioritas implementasi

Bangun satu fitur per iterasi. Mulai dari harness/runner bersama di masing-masing repository lab, lalu kasus yang tertera menurut nomor spesifikasinya. Untuk DFIR dan GRC, siapkan paket kasus, kunci instruktur terpisah, dan pilot menggunakan dokumen riset sebagai kontrak. Pertahankan kalender dan pertanyaan mahasiswa yang telah disepakati.

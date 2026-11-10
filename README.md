# Final Project Cyber Security SIB 2026

Repository **publik** untuk perencanaan final project 65 mahasiswa SIB, dibagi menjadi **13 kelompok berisi lima orang**. Pengajar menyediakan seluruh aset lab. Setiap kelompok menyelesaikan kasus yang berbeda, menjawab pertanyaan bertahap, mengumpulkan bukti, dan mempertanggungjawabkan keputusan saat presentasi.

| Tema | Kelompok | Kasus atau target |
| --- | ---: | --- |
| VAPT | 3 | KampusMart, PerpusDigital, EventPass |
| Digital Forensics & Incident Response | 3 | Phishing staf, intrusi aplikasi perpustakaan, penyalahgunaan identitas cloud simulasi |
| SOC | 3 | Account takeover API, eksekusi endpoint, beacon DNS/jaringan |
| GRC, privasi & business continuity | 2 | Layanan konseling mahasiswa; pendaftaran dan pembayaran kampus |
| DevSecOps & keamanan supply chain | 2 | CampusAPI release gate; BuildGate provenance |

**Kalender tetap:** pengerjaan 20 November–18 Desember 2026, gladi presentasi 16–18 Desember, pengujian/presentasi 21–23 Desember. Hari mentorship mengikuti tabel harian pada XLSX mentor. Per 10 November 2026, **13 kasus telah diimplementasikan dan diperiksa secara otomatis**; VAPT dan SOC juga menjalani dry pilot berbantuan agen. Pilot buta dengan mahasiswa/manusia, uji laptop perwakilan, dan pemeriksaan rilis masih diperlukan. Lihat `BUILD-STATUS.md`, `PILOT-2026-11-10.md`, dan `README-TRANSFER.md`.

## Empat repository yang perlu di-clone

| Repository | Fungsi | Arah implementasi |
| --- | --- | --- |
| [sib-2026-cybersecurity-final-project](https://github.com/orion2182/sib-2026-cybersecurity-final-project) | Riset lima tema, kartu VAPT, jadwal, checklist mentor | Sumber keputusan program dan dua tema berbasis dokumen (DFIR, GRC) |
| [sib-2026-vapt-labs](https://github.com/orion2182/sib-2026-vapt-labs) | Spec Kit, tiga target VAPT dan harness | Tiga aplikasi berbeda dengan build rentan dan patched, reset/retest |
| [sib-2026-soc-labs](https://github.com/orion2182/sib-2026-soc-labs) | Spec Kit, tiga dataset SOC dan evaluasi replay | Query/deteksi, metrik, holdout privat, triase |
| [sib-2026-devsecops-labs](https://github.com/orion2182/sib-2026-devsecops-labs) | Spec Kit, dua kasus DevSecOps dan runner | Repo simulasi, gate, SBOM/provenance, fail/pass |

Ketiga repository lab sengaja terpisah. Direktori `vapt-labs/`, `soc-labs/`, dan `devsecops-labs/` diabaikan oleh Git repository induk; commit dan push harus dilakukan dari masing-masing direktori lab.

## Mulai di Windows dengan OpenCode

Untuk **salinan lengkap dari flashdisk**, ikuti `README-TRANSFER.md`: salin ke disk lokal, verifikasi `TRANSFER-MANIFEST-SHA256.txt`, lalu jalankan pemeriksaan per tema. Lab saat ini memerlukan PowerShell 5.1+ dan PHP 8.1+ dengan ekstensi yang tercantum di dokumen transfer. **Python dan Docker tidak diperlukan** untuk menjalankan lab yang sudah dibangun. Git for Windows diperlukan jika ingin memakai riwayat Git dan Spec Kit; OpenCode diperlukan hanya untuk pekerjaan pengembangan lanjutan.

```powershell
cd .\vapt-labs
.\scripts\select-feature.ps1 --list
.\scripts\select-feature.ps1 002-kampusmart-target
opencode
```

Jalankan OpenCode dari **root repository lab** (`vapt-labs`, `soc-labs`, atau `devsecops-labs`) agar `AGENTS.md` dan perintah Spec Kit yang benar dimuat. Pemilih fitur PowerShell menggantikan `scripts/select_feature.py` pada Windows tanpa Python. Di chat OpenCode, gunakan `/speckit.plan`, `/speckit.checklist`, `/speckit.tasks`, `/speckit.analyze`, `/speckit.implement`, lalu `/speckit.converge` hanya jika mengerjakan perubahan fitur. Lab yang sudah dibangun dapat dijalankan tanpa Spec Kit. Lihat `docs/WINDOWS-SETUP.md` di masing-masing repo lab.

Jika baru **clone repo induk** dari GitHub, tiga repo lab belum otomatis ada. Clone masing-masing dari tautan tabel di atas; `setup_workspaces.py` adalah opsi untuk mesin yang memang memiliki Python. Catatan integrasi: perintah Spec Kit dipakai secara interaktif di chat OpenCode; [alur headless OpenCode v2 masih bermasalah](https://github.com/github/spec-kit/issues/4639).

## Dokumen sumber

| Tema | Baca mulai dari |
| --- | --- |
| VAPT | `Riset-Rancangan-VAPT-KampusMart-2026.md`, `Arsitektur-Lab-VAPT-KampusMart-Lokal.md`, `Form-Otorisasi-Mulai-VAPT-PTES.md`, tiga `Kartu-Target-VAPT-*.md` |
| DFIR | `Riset-Lab-DFIR-2026.md` |
| SOC | `Riset-Lab-SOC-2026.md` |
| GRC, privasi & BCP | `Riset-Lab-GRC-Privasi-BCP-2026.md` |
| DevSecOps & supply chain | `Riset-Lab-DevSecOps-Supply-Chain-2026.md` |

`Rencana-Proyek-Akhir-Cybersecurity-KampusMart.pdf` adalah **draft awal** dengan asumsi lama bahwa semua kelompok mengerjakan VAPT; rancangan terbaru pada dokumen Markdown dan spesifikasi lab menggantikannya. `outputs/` memuat snapshot XLSX timeline dan checklist mentor. [Google Sheet mentor](https://docs.google.com/spreadsheets/d/1AmBhy5wWf-PDKO3RWuc2AvEtrVgvnmWE_nGKKzPhJ_E/edit) adalah versi kerja bersama dan mungkin memerlukan akses akun yang sesuai.

## Aturan rilis lab

Repository publik ini memuat rancangan instruktur, termasuk petunjuk tentang skenario yang akan dibangun. **Jangan menjadikannya paket mahasiswa.** Kunci jawaban, label holdout, golden artifact, seed rahasia, kredensial, dan data pribadi nyata tidak boleh di-commit. Mahasiswa menerima hanya paket kasus/target yang ditugaskan, pertanyaan, instruksi, dan aset sintetis yang telah lolos pilot. VAPT memerlukan persetujuan Rules of Engagement sebelum pengujian aktif. Semua pengujian berlangsung pada instance lab lokal atau lingkup yang disetujui pengajar.

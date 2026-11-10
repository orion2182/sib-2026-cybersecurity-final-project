# Final Project Cyber Security SIB 2026

Repository **publik** untuk perencanaan final project 65 mahasiswa SIB, dibagi menjadi **13 kelompok berisi lima orang**. Pengajar menyediakan seluruh aset lab. Setiap kelompok menyelesaikan kasus yang berbeda, menjawab pertanyaan bertahap, mengumpulkan bukti, dan mempertanggungjawabkan keputusan saat presentasi.

| Tema | Kelompok | Kasus atau target |
| --- | ---: | --- |
| VAPT | 3 | KampusMart, PerpusDigital, EventPass |
| Digital Forensics & Incident Response | 3 | Phishing staf, intrusi aplikasi perpustakaan, penyalahgunaan identitas cloud simulasi |
| SOC | 3 | Account takeover API, eksekusi endpoint, beacon DNS/jaringan |
| GRC, privasi & business continuity | 2 | Layanan konseling mahasiswa; pendaftaran dan pembayaran kampus |
| DevSecOps & keamanan supply chain | 2 | CampusAPI release gate; BuildGate provenance |

**Kalender tetap:** pengerjaan 20 November–18 Desember 2026, gladi presentasi 16–18 Desember, pengujian/presentasi 21–23 Desember. Hari mentorship mengikuti tabel harian pada XLSX mentor. Per 10 November 2026, seluruh dokumen dan spesifikasi adalah **rancangan**; target, dataset, runner, paket kasus, dan pilot belum selesai dibangun.

## Empat repository yang perlu di-clone

| Repository | Fungsi | Arah implementasi |
| --- | --- | --- |
| [sib-2026-cybersecurity-final-project](https://github.com/orion2182/sib-2026-cybersecurity-final-project) | Riset lima tema, kartu VAPT, jadwal, checklist mentor | Sumber keputusan program dan dua tema berbasis dokumen (DFIR, GRC) |
| [sib-2026-vapt-labs](https://github.com/orion2182/sib-2026-vapt-labs) | Spec Kit, 3 spesifikasi target, harness VAPT | Bangun 3 aplikasi web/API berbeda, build rentan dan patched, reset/retest |
| [sib-2026-soc-labs](https://github.com/orion2182/sib-2026-soc-labs) | Spec Kit, 3 spesifikasi kasus SOC, evaluasi replay | Bangun dataset sintetis, query/deteksi, metrik, holdout, triase |
| [sib-2026-devsecops-labs](https://github.com/orion2182/sib-2026-devsecops-labs) | Spec Kit, 2 spesifikasi kasus DevSecOps, runner | Bangun repo simulasi, pipeline gate, SBOM/provenance, fail/pass |

Ketiga repository lab sengaja terpisah. Direktori `vapt-labs/`, `soc-labs/`, dan `devsecops-labs/` diabaikan oleh Git repository induk; commit dan push harus dilakukan dari masing-masing direktori lab.

## Mulai di laptop lain dengan OpenCode

Prasyarat: Git, Python 3.11+, dan OpenCode. Instal OpenCode sesuai [dokumentasi resmi](https://opencode.ai/docs/). Untuk menjalankan perintah Spec Kit yang sudah tersimpan di repository, buka OpenCode dari **root repository lab**, bukan dari root repository perencanaan. CLI `specify` diperlukan bila ingin mengubah atau memperbarui integrasi, tetapi file perintah OpenCode telah disertakan dalam repository lab.

```bash
git clone https://github.com/orion2182/sib-2026-cybersecurity-final-project.git
cd sib-2026-cybersecurity-final-project
python3 setup_workspaces.py
cd soc-labs
opencode
```

Di Windows, gunakan `py -3 setup_workspaces.py` jika perintah `python3` tidak tersedia. Skrip hanya meng-clone repo yang belum ada dan memilih fitur Spec Kit awal; skrip tidak melakukan pull, reset, atau menimpa checkout yang sudah ada. Jika hanya ingin satu tema, clone repository lab yang bersangkutan dan jalankan `python3 scripts/select_feature.py` dari root lab untuk memilih fitur.

OpenCode membaca `AGENTS.md` pada tiap repository. Baca README repository lab, konstitusi `.specify/memory/constitution.md`, dan `specs/<fitur>/spec.md`. Di chat OpenCode, jalankan urutan interaktif `/speckit.plan`, `/speckit.checklist`, `/speckit.tasks`, `/speckit.analyze`, `/speckit.implement`, lalu `/speckit.converge` untuk fitur aktif. Spesifikasi sudah ada; `/speckit.specify` hanya diperlukan bila ruang lingkup fitur diubah. Perintah dengan garis miring dijalankan **di chat OpenCode**, bukan di shell. [Dokumentasi integrasi OpenCode Spec Kit](https://github.github.com/spec-kit/integrations/opencode.html).

Untuk OpenCode v2, gunakan **chat interaktif** di atas. Pengiriman perintah Spec Kit melalui workflow headless `opencode run --command` masih tercatat tidak kompatibel dengan OpenCode v2 pada [isu resmi Spec Kit](https://github.com/github/spec-kit/issues/4639); repo ini tidak mengandalkan jalur headless tersebut.

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

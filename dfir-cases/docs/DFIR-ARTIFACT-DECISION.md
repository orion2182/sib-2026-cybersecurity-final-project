# DFIR artefak biner: memo keputusan

**Status:** rekomendasi untuk mentor. **Tanggal:** 10 November 2026.
**Pemilik keputusan:** mentor DFIR. **Batas:** tidak ada paket peserta yang berubah
sampai keputusan diambil.

## Pertanyaan

Paket DFIR saat ini memakai ekspor teks/JSON/CSV/EML. Apakah cukup untuk tujuan
pembelajaran, atau perlu artefak biner (EVTX, PCAP, image disk, SQLite mentah)
agar mahasiswa berlatih tool forensik?

## Opsi

| Opsi | Isi | Kelebihan | Konsekuensi |
| --- | --- | --- | --- |
| A. Teks-only (sekarang) | JSON, JSONL, CSV, EML, log | Jalan di 8 GB tanpa tool; hash mudah diverifikasi; fokus analisis | Tidak melatih Wireshark/Event Viewer/sqlite3 |
| B. Teks + add-on PCAP & SQLite | Paket utama tetap teks; add-on opsional berisi PCAP kecil dan SQLite | Melatih tool umum tanpa membebani semua peserta | Perlu Wireshark/DB Browser atau parser fallback; paket jadi dua varian |
| C. Biner penuh (EVTX/PCAP/image) | Event log Windows, capture, disk image | Paling dekat dengan DFIR nyata | Besar, butuh Windows/VM, sulit di 8 GB, pembuatan & validasi berat |

## Bukti kelayakan (prototipe)

Prototipe dibuat dan diverifikasi tanpa tool eksternal:

- `instructor-private/dfir/optional-binary/beacon-slice.pcap` — 330 byte, 3 frame
  (DNS query, DNS response, TCP SYN), valid magic `0xa1b2c3d4`, nama query dan
  alamat tujuan ditemukan.
- `instructor-private/dfir/optional-binary/beacon-events.sqlite` — 6 baris,
  1 query distinct, dapat dibaca dengan PDO SQLite.
- `dfir-cases/tools/build-binary-prototype.php` dan `verify-binary.php` lulus.

EVTX **belum** diprototipekan. Membuat EVTX valid memerlukan tool Windows Event
Log atau library khusus; itu menambah dependensi yang belum tersedia di mesin
ini. Jangan menjanjikan EVTX sebelum ada prototipe dan pilot.

## Rekomendasi

1. **Rilis utama tetap Opsi A (teks-only).** Ini yang sudah lolos verifikasi dan
   cocok untuk laptop 8 GB tanpa instalasi tool.
2. Sediakan **Opsi B sebagai add-on opsional** hanya jika mentor ingin melatih
   tool: satu PCAP kecil + satu SQLite + instruksi Wireshark/DB Browser, dengan
   parser PHP sebagai fallback. Add-on harus punya manifest, peta Q, dan pilot
   sendiri.
3. **Jangan memilih Opsi C** untuk rilis 2026 kecuali ada pilot perangkat dan
   proses pembuatan artefak yang dapat direproduksi.

## Yang harus dilakukan jika Opsi B dipilih

- Tambahkan PCAP/SQLite ke `manifest-sha256.txt` dan verifikasi ulang.
- Petakan artefak ke Q1–Q12 (mis. Q9 korelasi DNS/conn).
- Uji di laptop 8 GB dengan dan tanpa Wireshark.
- Sediakan fallback tanpa tool (parser PHP) dan jelaskan batasnya.
- Perbarui kartu mahasiswa dan kunci mentor.

## Batas klaim

Prototipe membuktikan bahwa PCAP/SQLite kecil dapat dibuat dan diverifikasi.
Prototipe tidak membuktikan bahwa mahasiswa dapat menganalisisnya dengan tool,
dan tidak membuktikan kelayakan EVTX/image.

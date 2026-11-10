# 09 — Riwayat Insiden

**Dokumen:** catatan insiden 2024–2026
**Sumber:** tiket TI, keluhan mahasiswa, berita kampus

---

## 1. Ringkasan

| # | Tanggal | Peristiwa | Dampak | Tindakan | Pelajaran yang tidak diambil |
| --- | --- | --- | --- | --- | --- |
| J-1 | 14 Agu 2024 | Duplikasi tagihan 312 mahasiswa | Rp 1,28 miliar tertagih ganda | Refund 6 minggu | Idempotensi tidak diperbaiki |
| J-2 | 20 Jan 2025 | SIPMA mati 5 jam pada hari terakhir pembayaran | 2.100 transaksi manual | Spreadsheet + WhatsApp | Prosedur manual tidak dibakukan |
| J-3 | 9 Sep 2025 | Backup gagal senyap 3 minggu | Tidak ada backup valid 21 hari | Ditemukan saat uji restore | Pemantauan tidak diperbaiki |
| J-4 | 11 Feb 2026 | Berkas pendaftar dikirim ke surel pribadi | 480 berkas | Staf diminta menghapus | Tanpa notifikasi, tanpa audit |

## 2. Detail

### J-1 — Duplikasi tagihan (Agu 2024)

- Webhook dikirim ulang karena SIPMA tidak merespons tepat waktu; sistem membuat dua catatan pembayaran.
- 312 mahasiswa tertagih dua kali; total Rp 1,28 miliar.
- Refund memerlukan verifikasi manual; rata-rata 42 hari.
- **Tidak ada** perubahan pada mekanisme idempotensi.
- Reputasi: 3 unggahan viral di media sosial mahasiswa; 1 surat terbuka.

### J-2 — Gangguan 5 jam (Jan 2025)

- Puncak pembayaran; basis data kehabisan koneksi karena kueri laporan yang tidak dioptimalkan.
- 2.100 transaksi dicatat manual di spreadsheet oleh 40 panitia.
- Spreadsheet berisi NIM, nama, nominal, dan sebagian NIK; diedarkan lewat WhatsApp.
- Setelah pulih, 61 transaksi tidak tercocokkan dan memerlukan koreksi manual.
- **Tidak ada** prosedur manual resmi yang dihasilkan.

### J-3 — Backup gagal senyap (Sep 2025)

- Pekerjaan backup gagal 21 hari berturut-turut karena ruang penyimpanan penuh.
- Surel peringatan dikirim ke satu alamat yang tidak dibaca (mantan staf).
- Ditemukan saat uji restore: restore berhenti pada 40% karena file WAL hilang.
- **Tidak ada** perbaikan pemantauan hingga November 2026.

### J-4 — Berkas ke surel pribadi (Feb 2026)

- Staf admisi mengirim 480 berkas pendaftar ke surel pribadi untuk "dikerjakan di rumah".
- Berkas berisi NIK, KK, rapor, dan bukti penghasilan.
- Tidak ada catatan resmi; temuan berasal dari keluhan pendaftar yang menerima surel salah alamat.
- Staf diminta menghapus; tidak ada verifikasi, tidak ada pemberitahuan.

## 3. Pola

1. **Duplikasi dan rekonsiliasi** adalah risiko berulang, bukan kejadian sekali.
2. **Proses manual selalu muncul**, tetapi tidak pernah diformalkan atau dilindungi.
3. **Pemantauan tidak ada**, sehingga kegagalan ditemukan secara kebetulan.
4. **Data pindah ke saluran pribadi** setiap kali ada tekanan waktu atau beban kerja.
5. **Tidak ada pembelajaran**, sehingga kejadian yang sama terulang dengan bentuk berbeda.

## 4. Dampak kumulatif

| Aspek | Perkiraan |
| --- | --- |
| Mahasiswa terdampak langsung | 2.893 (dengan tumpang tindih) |
| Nilai duplikasi/ koreksi | Rp 1,28 miliar + koreksi manual |
| Waktu staf tambahan | ± 1.400 jam (2024–2026) |
| Pemberitahuan insiden privasi | 0 |
| Perubahan kontrol | 1 (tidak bertahan) |

## 5. Pertanyaan yang harus dijawab tim (bukan jawaban)

- Insiden mana yang paling mungkin terulang pada 3 Desember 2026, dan mengapa?
- Apa kontrol termurah yang dapat mencegah pengulangan J-1 dan J-2 sekaligus?
- Jika J-2 terulang, data apa yang **tidak boleh** masuk ke spreadsheet?

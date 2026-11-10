# Template — Lembar Kerja RTO/RPO

**Kasus:** GRC-2 Pendaftaran dan Pembayaran Kampus
**Tim:** ____________________  **Tanggal:** __________

---

## 1. Definisi

| Istilah | Definisi tim |
| --- | --- |
| RTO | Waktu maksimum sebelum layanan harus tersedia |
| RPO | Kehilangan data maksimum yang dapat ditoleransi |
| MTPD | Titik ketika dampak menjadi tidak dapat diterima |
| WRT | Work Recovery Time — waktu untuk mengejar transaksi tertunda setelah sistem hidup |

> Jangan lupa **WRT**. Sistem yang hidup kembali dengan antrean 1.900 transaksi belum "pulih".

## 2. Target

| ID | Layanan | MTPD | RTO | WRT | RPO | Dasar | Kemampuan nyata | Sesuai? |
| --- | --- | --- | --- | --- | --- | --- | --- | :-: |
| S-01 | Pembayaran UKT | | | | | | | |
| S-02 | Pencatatan status registrasi | | | | | | | |
| S-03 | Rekonsiliasi bank | | | | | | | |
| S-04 | Pendaftaran mahasiswa baru | | | | | | | |
| S-05 | Pengisian KRS | | | | | | | |
| S-06 | Notifikasi ke mahasiswa | | | | | | | |

## 3. Bukti kemampuan

| Layanan | Mekanisme | Ukuran data | Kecepatan | Waktu hitung | Pernah diuji? | Hasil |
| --- | --- | ---: | ---: | ---: | :-: | --- |
| S-01 | | | | | | |
| S-02 | | | | | | |
| S-03 | | | | | | |

**Rumus:** `waktu = ukuran ÷ kecepatan`, lalu tambah deteksi + keputusan + verifikasi + WRT. Tulis satuannya.

## 4. Kesenjangan

| Layanan | Target | Kemampuan | Selisih | Penyebab | Tindakan |
| --- | --- | --- | --- | --- | --- |
| | | | | | |

## 5. Alternatif

| Alternatif | Biaya | Siap kapan | Kekurangan | Risiko sisa |
| --- | ---: | --- | --- | --- |
| Proses manual 4 loket | | | | |
| VA bank kedua | | | | |
| Replika basis data | | | | |
| DR region kedua | | | | |
| Menerima risiko | | | | |

## 6. Pernyataan target (untuk Direktur)

> "Untuk pembayaran UKT kami menetapkan RTO ___ dan RPO ___. Dasar: ___. Kami **tidak** dapat menjamin ___ sebelum ___. Jika target tidak tercapai, dampak akademiknya adalah ___ dan pemilik risiko sisa adalah ___."

## 7. Daftar periksa

- [ ] Ada WRT, bukan hanya RTO.
- [ ] RPO memperhitungkan hilangnya binlog.
- [ ] Target berbeda antar layanan.
- [ ] Ada perhitungan yang dapat diperiksa ulang.
- [ ] Ada layanan yang dinyatakan tidak dapat dipenuhi targetnya.

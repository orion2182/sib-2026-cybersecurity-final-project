# Template — Lembar Kerja RTO/RPO

**Kasus:** GRC-1 Layanan Konseling Mahasiswa
**Tim:** ____________________  **Tanggal:** __________

> RTO/RPO adalah **janji**, bukan harapan. Setiap angka harus dapat dipertahankan dengan bukti kemampuan teknis dan operasional.

---

## 1. Definisi yang dipakai

| Istilah | Definisi tim |
| --- | --- |
| RTO (Recovery Time Objective) | Waktu maksimum yang dapat ditoleransi sebelum layanan harus tersedia kembali |
| RPO (Recovery Point Objective) | Kehilangan data maksimum yang dapat ditoleransi, diukur dalam waktu |
| MTTR | Waktu rata-rata pemulihan aktual |
| MTPD | Titik waktu ketika dampak menjadi tidak dapat diterima |

## 2. Layanan dan target

| ID | Layanan | MTPD | RTO diusulkan | RPO diusulkan | Dasar usulan | Kemampuan saat ini | Sesuai? |
| --- | --- | --- | --- | --- | --- | --- | :-: |
| S-01 | Hotline krisis 24/7 | | | | | | |
| S-02 | Sesi tatap muka (dengan catatan kertas) | | | | | | |
| S-03 | Chat dan video | | | | | | |
| S-04 | Pencatatan rekam sesi | | | | | | |
| S-05 | Akses riwayat kasus aktif | | | | | | |
| S-06 | Rujukan klinik | | | | | | |
| S-07 | Forum sebaya | | | | | | |

## 3. Bukti kemampuan

| Layanan | Mekanisme pemulihan | Kecepatan terukur | Data terakhir yang tersedia | Pernah diuji? | Tanggal uji | Hasil |
| --- | --- | ---: | --- | :-: | --- | --- |
| S-01 | | | | | | |
| S-02 | | | | | | |
| S-03 | | | | | | |
| S-04 | | | | | | |

**Cara menghitung jika hanya ada ukuran dan kecepatan:**
`waktu transfer = ukuran data ÷ kecepatan efektif`, lalu tambahkan waktu deteksi, keputusan, dan verifikasi. Tulis satuannya.

## 4. Kesenjangan

| Layanan | RTO diusulkan | Kemampuan nyata | Selisih | Penyebab | Tindakan |
| --- | --- | --- | --- | --- | --- |
| | | | | | |

## 5. Alternatif jika target tidak dapat dicapai

| Alternatif | Biaya | Waktu siap | Kekurangan | Risiko sisa |
| --- | ---: | --- | --- | --- |
| Proses manual (kertas) | | | | |
| Alat sementara (spreadsheet terkelola) | | | | |
| Vendor cadangan | | | | |
| Pengurangan lingkup layanan | | | | |
| Menerima risiko | | | | |

## 6. Pernyataan target

Tulis satu paragraf yang akan dibaca Rektor. Harus memuat: layanan, angka, dasar, dan **apa yang tidak dijamin**.

> Contoh format: "Untuk hotline krisis kami mengusulkan RTO ___ karena ___. Kami **tidak** dapat menjamin ___ sampai ___ dilakukan. Jika target tidak terpenuhi, dampaknya adalah ___."

## 7. Daftar periksa mutu

- [ ] RTO/RPO berbeda antar layanan; tidak ada angka seragam untuk semua.
- [ ] Setiap angka punya dasar (kebutuhan pengguna atau kemampuan teknis).
- [ ] Ada layanan yang targetnya **tidak** dapat dipenuhi dan hal itu dinyatakan.
- [ ] RPO tidak lebih kecil dari frekuensi cadangan tanpa menjelaskan mekanismenya.
- [ ] Ada rencana verifikasi (uji) dengan tanggal dan pemilik.

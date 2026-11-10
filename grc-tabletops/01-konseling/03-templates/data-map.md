# Template — Peta Data (Data Map)

**Kasus:** GRC-1 Layanan Konseling Mahasiswa
**Tim:** ____________________  **Tanggal:** __________

> Peta data harus dapat menjawab: data apa, dari siapa, untuk apa, di mana, siapa yang bisa melihat, berapa lama, dan atas dasar apa.

---

## 1. Daftar kegiatan pemrosesan

| ID | Kegiatan | Tujuan | Subjek data | Kategori data | Dasar pemrosesan | Pemilik proses |
| --- | --- | --- | --- | --- | --- | --- |
| P-01 | Intake konseling | | Mahasiswa | | | |
| P-02 | Pencatatan sesi | | Mahasiswa | | | |
| P-03 | Chat dan video | | Mahasiswa | | | |
| P-04 | Hotline krisis | | Mahasiswa/ umum | | | |
| P-05 | Forum sebaya | | Mahasiswa | | | |
| P-06 | Rujukan klinik | | Mahasiswa | | | |
| P-07 | Pelaporan manajemen | | Mahasiswa (agregat) | | | |
| P-08 | Penagihan vendor | | Staf | | | |

**Kategori data:** gunakan istilah yang konsisten: `umum` / `spesifik` / `bukan data pribadi`.

**Dasar pemrosesan:** sebutkan dasar yang diklaim (mis. persetujuan, kewajiban hukum, kepentingan vital). Jika tidak jelas, tulis `tidak diketahui` — itu temuan.

## 2. Aliran data

Gambarkan dengan teks atau diagram. Setiap panah harus punya label: data apa, peran siapa, dan lintas negara atau tidak.

```
[Contoh format]
Mahasiswa --(intake: umum+spesifik)--> SIPKON [prosesor] --(lampiran)--> Nimbus [subprosesor, SG]
```

| # | Dari | Ke | Data | Peran pengirim | Peran penerima | Lintas negara? | Jaminan | Bukti |
| --- | --- | --- | --- | --- | --- | :-: | --- | --- |
| 1 | | | | | | | | |
| 2 | | | | | | | | |
| 3 | | | | | | | | |

## 3. Inventaris lokasi penyimpanan

| Lokasi | Jenis | Pemilik lokasi | Data | Retensi | Enkripsi | Siapa yang dapat mengakses | Bukti |
| --- | --- | --- | --- | --- | --- | --- | --- |
| | | | | | | | |

**Jangan lupa lokasi tidak resmi:** kotak masuk surel pribadi, laptop, grup WhatsApp, lemari kertas, kandar eksternal, printer.

## 4. Tabel field (minimisasi)

| Field | Wajib? | Dipakai untuk apa | Alternatif yang tidak mengumpulkan | Keputusan |
| --- | :-: | --- | --- | --- |
| Nama lengkap | | | | |
| NIM | | | | |
| Alamat domisili | | | | |
| Pekerjaan orang tua | | | | |
| Penghasilan orang tua | | | | |
| Riwayat keluarga | | | | |
| Nomor telepon | | | | |

## 5. Hak subjek data

| Hak | Apakah dapat dipenuhi sekarang? | Hambatan | Perbaikan yang diusulkan |
| --- | :-: | --- | --- |
| Informasi tentang pemrosesan | | | |
| Akses dan salinan | | | |
| Perbaikan data | | | |
| Penghapusan/ pemusnahan | | | |
| Penarikan persetujuan | | | |
| Pembatasan pemrosesan | | | |

## 6. Temuan

| # | Temuan | Bukti | Dampak | Rekomendasi |
| --- | --- | --- | --- | --- |
| T-1 | | | | |
| T-2 | | | | |
| T-3 | | | | |

## 7. Daftar periksa mutu

- [ ] Setiap aliran punya peran yang jelas (pengendali/ prosesor/ subprosesor/ pengendali terpisah).
- [ ] Setiap transfer lintas negara punya dasar dan jaminan yang dapat ditunjukkan.
- [ ] Ada minimal satu temuan tentang tujuan yang tidak tercantum dalam pemberitahuan.
- [ ] Ada minimal satu temuan tentang retensi yang tidak konsisten.
- [ ] Data yang tidak diperlukan diidentifikasi dan diusulkan untuk dihapus.

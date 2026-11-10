# Register dan Verifikasi Bukti

## 1. Prinsip

1. **Asli baca-saja.** Folder paket adalah master. Jangan mengubah, memindahkan,
   atau menamai ulang berkas di dalamnya.
2. **Salinan kerja terpisah.** Analisis dilakukan pada salinan.
3. **Setiap perpindahan dicatat.** Siapa, kapan (dengan offset), dari mana,
   ke mana, dan mengapa.
4. **Hash adalah bukti integritas, bukan bukti kebenaran isi.** Hash yang cocok
   hanya berarti berkas tidak berubah sejak manifest dibuat.

## 2. Verifikasi manifest

Format `manifest-sha256.txt`: `<sha256 huruf kecil><dua spasi><path relatif>`.
Baris berawalan `#` adalah komentar.

Jalankan dari akar paket (PowerShell 5.1):

```powershell
$root = (Get-Location).Path
$n = 0; $bad = 0
Get-Content .\manifest-sha256.txt |
  Where-Object { $_ -notmatch '^#' -and $_.Trim() -ne '' } |
  ForEach-Object {
    $p = $_ -split '  ', 2
    $h = (Get-FileHash -Algorithm SHA256 -LiteralPath (Join-Path $root $p[1])).Hash.ToLower()
    $n++
    if ($h -ne $p[0]) { $bad++; "MISMATCH: $($p[1])" }
  }
"checked=$n mismatches=$bad"
```

Catat keluaran apa adanya pada register. Jika ada `MISMATCH`, hentikan
analisis, laporkan ke mentor, dan jangan memperbaiki berkas sendiri.

## 3. Register bukti

Gunakan `evidence-register-template.csv` dan isi minimal:

| Kolom | Isi |
| --- | --- |
| `item_id` | ID unik bukti, mis. `E-001` |
| `file_path` | Path relatif di dalam paket |
| `sha256_original` | Nilai dari manifest |
| `acquired_at` | Waktu penerimaan, dengan offset |
| `received_from` | Pihak pemberi (fiktif) |
| `custodian` | Nama anggota tim yang memegang |
| `storage_location` | Path salinan kerja |
| `sha256_working_copy` | Hash salinan kerja |
| `verification_result` | `match` / `mismatch` |
| `notes` | Batas atau keraguan |

## 4. Aturan salinan kerja

- Buat salinan dengan `Copy-Item` dan hitung hash setelah penyalinan.
- Catat hash salinan; jika berbeda dari asli, salinan tidak layak dipakai.
- Jangan mengubah berkas asli untuk "merapikan" format.

## 5. Batas yang harus dinyatakan

- Hash tidak membuktikan bahwa isi artefak lengkap; lihat bagian "Batas yang
  diketahui" pada `artifacts/SOURCE-TIME-AND-CONVENTIONS.md`.
- Ketiadaan rekaman pada satu sumber tidak membuktikan peristiwa tidak terjadi.
- Semua data sintetis; jangan mengutip sebagai temuan dunia nyata.

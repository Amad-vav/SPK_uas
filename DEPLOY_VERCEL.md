# Deploy ke Vercel dengan Laravel

Repo sudah dikonfigurasi untuk Vercel dengan PHP serverless dan build asset Vite.

## Langkah deploy

1. Buka https://vercel.com dan login dengan GitHub.
2. Klik `New Project`.
3. Pilih repo `UAS_spk`.
4. Pastikan Vercel mendeteksi project sebagai Node + PHP, lalu `Import`.
5. Gunakan `main` sebagai branch deploy.
6. Jika Vercel meminta Build Command, gunakan:
   - `npm run vercel-build`
   - Output Directory: `public`
7. Jalankan deploy.

## Kunci konfigurasi

- `vercel.json` sudah membaca `api/index.php` sebagai fungsi PHP.
- `api/index.php` sekarang mengatur default serverless env:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_KEY` di-generate jika belum ada
  - `DB_CONNECTION=sqlite`
  - `DB_DATABASE=/tmp/database/database.sqlite`
  - `SESSION_DRIVER=cookie`
  - `CACHE_STORE=array`
  - `QUEUE_CONNECTION=sync`

## Catatan penting

- `SESSION_DRIVER=cookie` dipilih agar session tetap bekerja di lingkungan serverless Vercel.
- Database SQLite akan hidup di `/tmp/database` dan menggunakan migrasi otomatis hanya saat file DB belum ada.
- Jika Anda ingin `APP_KEY` stabil, tetapkan `APP_KEY` di Environment Variables Vercel.

## Setelah deploy

Jika build sukses, buka URL yang diberikan Vercel.

Jika masih muncul error:
- pastikan `vendor/` sudah dikomit ke repo; Vercel tidak selalu punya PHP composer saat build
- jika belum, jalankan di lokal:
  ```bash
git add vendor
git commit -m "Add vendor for Vercel deployment"
git push origin main
```
- kirimkan log error Vercel dari halaman Deployments
- saya akan bantu perbaiki langsung

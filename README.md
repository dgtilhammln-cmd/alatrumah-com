# 🌀 Cyclevent — Turbine Ventilator Specialist Website
**PT. Hiranatha Makmur Sukses** | [cyclevent.hvmdigital.id](https://cyclevent.hvmdigital.id)

Platform website bisnis lengkap untuk Cyclevent, spesialis Turbine Ventilator Non-Electric, dibangun dengan Laravel 13 dan dioptimalkan untuk performa, SEO, dan kemudahan pengelolaan konten melalui panel admin yang komprehensif.

---

## 🛠 Tech Stack

| Komponen | Detail |
|---|---|
| **Framework** | Laravel 13.x (PHP 8.3+) |
| **Database** | MySQL (production) / SQLite (development) |
| **Template Engine** | Blade (Laravel) |
| **CSS Framework** | Vanilla CSS + Design System kustom |
| **Build Tool** | Vite (opsional, tanpa wajib) |
| **Image Processing** | Intervention Image 4.0 (auto-convert ke WebP) |
| **PDF Export** | barryvdh/laravel-dompdf 3.0 |
| **Excel Export** | maatwebsite/excel 3.1 |
| **Sitemap** | spatie/laravel-sitemap 8.0 |
| **Hosting** | Hostinger VPS (Domain: cyclevent.hvmdigital.id) |
| **Git Repo** | github.com/dgtilhammln-cmd/cyclevent |

---

## 🎨 Design System & Frontend

### Font
- **Primary Font:** `Montserrat` (Google Fonts)
  - Weight: 300 (Light), 400 (Regular), 500 (Medium), 600 (SemiBold), 700 (Bold), 800, 900 (Black)
  - Load Mode: **Non-blocking** (`media="print"` swap trick) — tidak memblokir render
  - Italic: 300i tersedia untuk variasi tipografi

### Color Palette (CSS Variables)
```css
--accent:       #38BDF8  /* Brand Blue — Utama */
--accent-light: #7DD3FC  /* Blue muda */
--accent-dark:  #0EA5E9  /* Blue gelap untuk tombol */
--accent-deep:  #0284C7  /* Blue lebih gelap */
--bg-base:      #FFFFFF  /* Background putih dominan */
--bg-1:         #F8FAFF  /* Off-white */
--bg-2:         #EFF6FF  /* Light blue tint */
```

### CSS Libraries (CDN, Non-Blocking)
| Library | Versi | Fungsi |
|---|---|---|
| AOS (Animate on Scroll) | 2.3.1 | Animasi scroll masuk |
| Swiper.js | 11 | Slider/carousel gambar |
| GLightbox | Latest | Popup lightbox gambar |

### JavaScript Libraries (CDN, Deferred)
| Library | Versi | Fungsi |
|---|---|---|
| AOS JS | 2.3.1 | Controller animasi scroll |
| Swiper Bundle | 11 | Controller slider |
| GLightbox JS | Latest | Controller popup gambar |

---

## 🌐 Halaman Frontend (Public)

### 1. Beranda (`/`)
- **Hero Section** — Slider gambar otomatis (Swiper) dengan 3 kolom layout
  - Kolom kiri: Headline, badge, deskripsi, tombol CTA
  - Kolom tengah: Hero Slider (`HeroSlide` model, upload dari admin)
  - Kolom kanan: Gambar sekunder + statistik klien
- **Clients Bar** — Marquee logo klien bergulir otomatis tanpa henti
- **About Section** — 4 kartu premium (keyword chips, statistik, gambar, fitur)
- **Products Preview** — Grid produk/layanan unggulan
- **Advantages Section** — Keunggulan produk dengan icon
- **Gallery Preview** — 6 foto galeri terakhir dengan **popup lightbox** (klik = popup, bukan pindah halaman)
- **Testimonials** — Carousel testimoni klien
- **Coverage Map** — Peta jangkauan Indonesia dengan statistik animasi count-up
- **Articles Preview** — 3 artikel terbaru
- **CTA Section** — Call-to-action dengan modal WhatsApp

### 2. Halaman Produk (`/products`)
- Grid produk dengan filter kategori
- Setiap produk punya halaman detail (`/products/{slug}`)
- Halaman detail: gambar utama, deskripsi lengkap, spesifikasi, FAQ, galeri produk, form order

### 3. Halaman Galeri (`/gallery`)
- Grid foto proyek instalasi
- Filter berdasarkan kategori
- Klik foto = **popup lightbox** (bukan navigasi ke halaman baru)
- Pagination dengan desain kustom

### 4. Halaman Artikel/Blog (`/articles`)
- Daftar artikel dengan gambar dan excerpt
- Halaman detail artikel (`/articles/{slug}`)
- Rich content dengan FAQ section per artikel
- Schema JSON-LD untuk Article (SEO)

### 5. Halaman Tentang Kami (`/about`)
- Profil perusahaan
- Sejarah dan keunggulan
- Tim dan nilai perusahaan

### 6. Halaman Kontak (`/contact`)
- Form kontak dengan validasi
- Integrasi WhatsApp langsung
- Peta lokasi

### 7. Sitemap (`/sitemap.xml` & `/sitemap`)
- XML Sitemap otomatis (spatie/laravel-sitemap)
- HTML Sitemap untuk user

### 8. Robots.txt (Dinamis)
- Dihasilkan dinamis oleh Laravel, `Sitemap` URL otomatis menggunakan `APP_URL`

---

## 🔒 Panel Admin (`/admin`)

Semua route admin dilindungi middleware `admin.auth` (session-based).

### Autentikasi Admin
- Login (`/admin/login`) — username & password
- Logout
- Session management

### 1. Dashboard (`/admin`)
- Statistik ringkas: total leads, produk, galeri, artikel
- Grafik kunjungan menggunakan Chart.js
- Leads terbaru dengan badge notifikasi
- Kunjungan hari ini vs kemarin

### 2. Analytics (`/admin/analytics`)
- **Halaman Kunjungan** — tracking per URL
- **Grafik Harian** — total kunjungan 30 hari terakhir
- **Device Breakdown** — Mobile / Tablet / Desktop
- **Top Pages** — halaman paling banyak dikunjungi
- **Referrer** — sumber trafik
- **Realtime** — kunjungan aktif saat ini (polling)
- **Export XLS** — download data analytics ke Excel
- **Export PDF** — download laporan analytics ke PDF

### 3. Leads / Permintaan (`/admin/leads`)
- Semua lead dari form kontak & modal order masuk di sini
- Status lead: `new`, `contacted`, `converted`, `rejected`
- Update status lead + catatan internal
- Notifikasi badge merah di navbar jika ada lead baru
- **Export Excel** — semua lead ke `.xlsx`
- **Export PDF** — laporan lead ke PDF
- **Mark All Read** — tandai semua lead sudah dibaca
- Data lead: nama, email, telepon, produk, pesan, UTM source/medium/campaign, IP, device, timestamp

### 4. Manajemen Produk (`/admin/services`)
- CRUD Produk (nama: "services" di internal Laravel)
- Upload gambar produk → **auto-convert ke WebP**
- Field: judul, slug, deskripsi, spesifikasi, konten rich-text, meta SEO (title, description, keywords)
- Upload multiple gambar galeri per produk
- Tambah FAQ per produk
- Urutan tampil (drag/sortable)

### 5. Manajemen Galeri (`/admin/gallery`)
- CRUD foto proyek instalasi
- Upload foto → **auto-convert ke WebP**
- Field: judul, klien, kategori, alt text, deskripsi, slug
- Preview foto langsung (buka foto di tab baru)
- Filter & search berdasarkan kategori

### 6. Manajemen Artikel (`/admin/articles`)
- CRUD artikel blog
- Upload gambar artikel → **auto-convert ke WebP**
- Field: judul, slug, excerpt, konten HTML, gambar, meta SEO, tags, FAQ
- Status: draft / published
- Tanggal publish

### 7. Manajemen Klien (`/admin/clients`)
- CRUD logo klien/mitra
- Upload logo → **auto-convert ke WebP**
- Field: nama perusahaan, logo, alt text, website URL
- Tampil sebagai marquee di halaman utama

### 8. Manajemen Testimoni (`/admin/testimonials`)
- CRUD testimoni pelanggan
- Upload foto klien → **auto-convert ke WebP**
- Field: nama, jabatan, perusahaan, foto, isi testimoni, rating
- Tampil di section testimonial homepage

### 9. Hero Slides (`/admin/hero-slides`)
- CRUD slide gambar hero di halaman utama
- Upload gambar → **auto-convert ke WebP**
- Field: judul, gambar, urutan, status aktif
- Slider otomatis (Swiper) di hero homepage

### 10. Pengaturan WhatsApp (`/admin/wa-settings`)
- Multi-nomor WhatsApp yang bisa dikelola
- Field per nomor: label, nomor WA, template pesan, status aktif, urutan
- Satu nomor bisa ditandai sebagai **primary**
- Template pesan mendukung placeholder `[produk]`
- Tombol WA floating di semua halaman menggunakan nomor primary

### 11. Pengaturan Website (`/admin/settings`)
- **Identitas**: nama perusahaan, tagline, logo, favicon
- **Hero**: headline, subheadline, gambar hero utama, gambar hero sekunder, tombol CTA (teks)
- **About**: heading about, gambar kartu about
- **Statistik**: tahun berdiri, jumlah klien, kota dilayani, tahun garansi
- **Kontak**: alamat, telepon, email, jam operasional, koordinat GPS
- **Sosial Media**: WhatsApp, Instagram, Facebook, YouTube, LinkedIn, TikTok
- **SEO Global**: meta title, meta description, keywords default
- **Tracking**: Google Search Console verification tag, kode head/body scripts (GTM, dsb)
- **Peta Jangkauan**: upload gambar peta Indonesia
- **Warna Tema**: accent color, main color, text color (override CSS variables)
- **Breadcrumb Background**: gambar latar halaman dalam
- **Custom Scripts**: kode HTML custom di head / body (cocok untuk GTM, FB Pixel, dsb)

---

## ⚡ Fitur Teknis & Performa

### Image Processing
- Semua upload gambar **otomatis dikonversi ke format WebP** menggunakan Intervention Image
- Resize otomatis sesuai kebutuhan (maks 1920px wide, kualitas 80%)
- Storage di `storage/app/public/` yang diakses via symlink `public_html/storage/`

### SEO
- **Component SEO** (`components/seo.blade.php`) terpusat, dipakai semua halaman
- Open Graph (Facebook, WhatsApp share preview)
- Twitter Card `summary_large_image`
- JSON-LD Schema: `LocalBusiness`, `Article`, `FAQ`, `ImageObject`, `BreadcrumbList`
- Geo meta tag (local SEO Jakarta)
- Canonical URL (selalu gunakan `APP_URL`, bukan localhost)
- Sitemap XML otomatis
- Robots.txt dinamis

### Analytics Internal
- Tracking kunjungan halaman tanpa Google Analytics (privasi)
- Middleware `track.pageview` mencatat setiap kunjungan
- Data tersimpan di tabel `analytics_events`: URL, judul, referrer, user agent, IP, kota, device type
- Deteksi lokasi via `ip-api.com` (di-cache 24 jam per IP)

### Lead Tracking UTM
- Form order/kontak mencatat UTM parameter (`utm_source`, `utm_medium`, `utm_campaign`)
- Data tersimpan bersama lead di database

### Caching
- Setting website di-cache (`getAllAsArray()` sekali query per halaman)
- IP location di-cache 24 jam per IP
- Lokasi IP mesin di-cache 1 jam

### Performance Optimizations
- **CSS Inline** — `app.css` di-inline langsung ke HTML untuk menghilangkan render-blocking
- **Font Non-Blocking** — Google Fonts dimuat dengan `media="print"` swap trick
- **CSS Library Non-Blocking** — Swiper & GLightbox CSS dimuat dengan `media="print"` trick
- **JS Deferred** — Swiper JS & GLightbox JS menggunakan atribut `defer`
- **LCP Preload** — `<link rel="preload">` pada gambar Hero pertama untuk mempercepat Largest Contentful Paint
- **Image Lazy Load** — semua gambar non-hero menggunakan `loading="lazy"`
- **fetchpriority="high"** — pada gambar Hero utama
- **Browser Cache** — Expires header untuk gambar (1 tahun), CSS/JS (1 bulan) di `.htaccess`
- **FollowSymLinks** — diaktifkan di `.htaccess` agar symlink storage bisa diakses

### Aksesibilitas
- Semua tombol punya `aria-label`
- Warna tombol memenuhi rasio kontras WCAG AA (min 4.5:1)
- Gambar punya atribut `alt` dan dimensi eksplisit (`width`, `height`)

---

## 📁 Struktur Direktori Penting

```
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Public controllers
│   │   │   └── Admin/            # Admin controllers (14 file)
│   │   └── Middleware/
│   └── Models/                   # 11 model Eloquent
├── database/
│   ├── migrations/               # 20 migration file
│   └── seeders/
├── public/
│   └── css/app.css               # Compiled CSS
├── public_html/                  # Web root (Hostinger)
│   ├── .htaccess                 # Caching + FollowSymLinks
│   ├── index.php
│   └── storage → ../storage/app/public (symlink)
├── resources/
│   ├── css/app.css               # Source CSS (Design System)
│   ├── js/app.js                 # Source JS
│   └── views/
│       ├── components/           # 8 reusable components
│       │   ├── seo.blade.php     # SEO + JSON-LD
│       │   ├── navbar.blade.php  # Navigasi (pill design)
│       │   ├── footer.blade.php  # Footer lengkap
│       │   ├── lightbox-assets.blade.php
│       │   ├── order-modal.blade.php  # Modal WhatsApp
│       │   ├── testimonials.blade.php
│       │   ├── wa-button.blade.php    # Tombol WA floating
│       │   └── pagination.blade.php
│       ├── layouts/
│       │   ├── app.blade.php     # Layout utama frontend
│       │   └── admin.blade.php   # Layout admin panel
│       ├── home/                 # Halaman beranda
│       ├── services/             # Halaman produk
│       ├── gallery/              # Halaman galeri
│       ├── articles/             # Halaman artikel
│       ├── about/                # Halaman tentang kami
│       ├── contact/              # Halaman kontak
│       └── admin/                # Semua tampilan admin (14 modul)
├── routes/web.php                # Semua route (public + admin)
└── storage/app/public/           # File upload (gambar, dll)
    ├── hero_slides/
    ├── services/
    ├── gallery/
    ├── articles/
    ├── clients/
    ├── testimonials/
    └── settings/
```

---

## 🗃 Database Tables

| Tabel | Keterangan |
|---|---|
| `users` | Admin login |
| `settings` | Semua konfigurasi website (key-value) |
| `services` | Produk/layanan turbine ventilator |
| `gallery_projects` | Foto proyek instalasi |
| `articles` | Artikel/blog |
| `clients` | Logo klien/mitra |
| `testimonials` | Testimoni pelanggan |
| `analytics_events` | Data kunjungan halaman internal |
| `wa_settings` | Multi-nomor WhatsApp |
| `leads` | Permintaan/inquiry dari form |
| `hero_slides` | Slide gambar hero homepage |
| `cache` | Laravel cache table |
| `jobs` | Laravel queue jobs |

---

## 🚀 Setup & Deployment

### Local Development
```bash
git clone https://github.com/dgtilhammln-cmd/cyclevent.git
cd cyclevent

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Storage symlink
php artisan storage:link

# Run
composer run dev
# atau
php artisan serve
```

### Production (Hostinger SSH)
```bash
cd /home/u664715641/domains/cyclevent.hvmdigital.id/

# Pull kode terbaru
git fetch origin
git reset --hard origin/main

# Update .htaccess di web root
cp public/.htaccess public_html/.htaccess

# Symlink storage (jika belum ada)
php artisan storage:link

# Clear semua cache
php artisan optimize:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

### Environment Variables Penting (`.env`)
```env
APP_NAME="Cyclevent"
APP_ENV=production
APP_URL=https://cyclevent.hvmdigital.id

DB_CONNECTION=mysql
DB_HOST=...
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

FILESYSTEM_DISK=public
```

---

## 👤 Akses Admin

- **URL Admin:** `https://cyclevent.hvmdigital.id/admin`
- Kredensial: dikonfigurasi melalui seeder atau langsung di database `users`

---

## 📦 Composer Packages

| Package | Versi | Fungsi |
|---|---|---|
| `laravel/framework` | ^13.7 | Core Laravel |
| `intervention/image` | 4.0 | Resize & convert gambar ke WebP |
| `barryvdh/laravel-dompdf` | ^3.0 | Generate PDF (leads, analytics) |
| `maatwebsite/excel` | ^3.1 | Export Excel (leads, analytics) |
| `spatie/laravel-sitemap` | 8.0 | Generate XML Sitemap otomatis |

---

## 🔗 URL Penting

| Halaman | URL |
|---|---|
| Beranda | `/` |
| Produk | `/products` |
| Galeri | `/gallery` |
| Artikel | `/articles` |
| Tentang Kami | `/about` |
| Kontak | `/contact` |
| Sitemap XML | `/sitemap.xml` |
| Sitemap HTML | `/sitemap` |
| Admin Dashboard | `/admin` |
| Admin Login | `/admin/login` |
| Admin Analytics | `/admin/analytics` |
| Admin Leads | `/admin/leads` |
| Admin Produk | `/admin/services` |
| Admin Galeri | `/admin/gallery` |
| Admin Artikel | `/admin/articles` |
| Admin Klien | `/admin/clients` |
| Admin Testimoni | `/admin/testimonials` |
| Admin Hero Slides | `/admin/hero-slides` |
| Admin WA Settings | `/admin/wa-settings` |
| Admin Pengaturan | `/admin/settings` |

---

*Dibuat oleh HVM Digital — dgtilhammln-cmd*

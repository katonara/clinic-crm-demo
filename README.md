# ClinicCare — Clinic CRM Booking System

A modern, mobile-responsive **clinic appointment booking** system. This repository contains
**Phase 1**: a professional public landing page plus a PDPA-compliant privacy policy. Later phases
will add patient authentication, email OTP verification, and the full booking module.

Built with **Laravel 12**, **Tailwind CSS v4**, and **Alpine.js**.

---

## ✨ Features (Phase 1)

- **Responsive landing page** (blue/white clinic theme) with:
  - Hero section + Tailwind-only dashboard preview
  - Trust highlights, services grid, "How It Works" steps
  - Patient/Staff benefits, feature preview cards
  - FAQ accordion (Alpine.js) and contact CTA
  - Sticky navbar with mobile hamburger menu
- **Reusable Blade components**: `navbar`, `footer`, `icon`, `service-card`, `feature-card`,
  `section-heading`
- **Bilingual Privacy Policy** (Bahasa Malaysia + English) aligned with Malaysia's
  **Personal Data Protection Act 2010 (PDPA / Akta 709)**, with an in-page language toggle
- Clean MVC structure with named placeholder routes ready for Phase 2

## 🧱 Tech stack

| Layer      | Technology                          |
|------------|-------------------------------------|
| Framework  | Laravel 12 (PHP 8.2+)               |
| Templating | Laravel Blade                       |
| Styling    | Tailwind CSS v4 (via Vite)          |
| JS         | Alpine.js 3 (+ @alpinejs/collapse)  |
| Build      | Vite                                |
| Database   | SQLite (default)                    |

## 🗺️ Routes

| Method | URI                 | Name       | Purpose                          |
|--------|---------------------|------------|----------------------------------|
| GET    | `/`                 | `home`     | Landing page                     |
| GET    | `/login`            | `login`    | Placeholder (Phase 2: auth)      |
| GET    | `/register`         | `register` | Placeholder (Phase 2: + OTP)     |
| GET    | `/book-appointment` | `book`     | Placeholder (Phase 3: booking)   |
| GET    | `/privacy-policy`   | `privacy`  | PDPA bilingual privacy policy    |

## 🚀 Getting started

### Prerequisites
- PHP 8.2+ with extensions: `openssl`, `mbstring`, `pdo_sqlite`, `tokenizer`, `ctype`, `fileinfo`
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) 18+ and npm

### Setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Install JS dependencies and build front-end assets
npm install
npm run build        # or: npm run dev  (live reload during development)

# 3. Environment
cp .env.example .env  # Windows: copy .env.example .env
php artisan key:generate

# 4. Database (SQLite by default)
php artisan migrate

# 5. Serve
php artisan serve
```

Then open **http://127.0.0.1:8000**.

> **Windows + XAMPP note:** if `php`/`composer` aren't on your PATH, prefix commands with the full
> path, e.g. `C:\xampp\php\php.exe artisan serve`.

## 📁 Project structure

```
app/Http/Controllers/PageController.php   # Thin controller for all pages
resources/views/
├── layouts/app.blade.php                 # Base layout (navbar + footer + @vite)
├── home.blade.php                        # Landing page (all sections)
├── privacy.blade.php                     # Bilingual PDPA privacy policy
├── placeholder.blade.php                 # Stub for login/register/book
└── components/                           # Reusable Blade components
resources/css/app.css                     # Tailwind + brand theme
resources/js/app.js                       # Alpine.js setup
routes/web.php                            # Route definitions
```

## 🛣️ Roadmap

- [x] **Phase 1** — Landing page + PDPA privacy policy
- [ ] **Phase 2** — Patient registration, login, email OTP verification
- [ ] **Phase 3** — Appointment booking module (services, dates, status)
- [ ] **Phase 4** — Staff/admin dashboard (schedule, patient records)

## ⚖️ Disclaimer

The privacy policy is a good-faith template aligned with the PDPA — it is **not legal advice**.
Replace the placeholder entity details (clinic name, address, contact, DPO) and have it reviewed by
a qualified professional before production use.

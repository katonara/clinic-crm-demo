# ClinicCare — Clinic CRM Booking System

A modern, mobile-responsive **clinic appointment booking** system covering the full flow:
a public landing page, patient registration with **email OTP verification**, online appointment
booking, and a **staff/admin dashboard** to manage bookings and services — plus a PDPA-compliant
privacy policy.

Built with **Laravel 12**, **Tailwind CSS v4**, and **Alpine.js**.

## 🔑 Demo accounts (after `php artisan db:seed`)

| Role    | Email                        | Password   |
|---------|------------------------------|------------|
| Staff   | `staff@cliniccare.example`   | `password` |
| Patient | `patient@cliniccare.example` | `password` |

> In local dev, `MAIL_MAILER=log`, so OTP emails are written to `storage/logs/laravel.log`.
> The OTP verification screen also displays the code directly for convenience.

---

## ✨ Features

- **Responsive landing page** (blue/white clinic theme): hero + dashboard preview, services grid,
  "How It Works", benefits, feature preview, FAQ accordion (Alpine.js), contact CTA, sticky navbar
  with mobile hamburger menu.
- **Authentication + email OTP**: register, login, logout, and 6-digit email OTP verification
  (resend supported). Unverified users are gated until verified.
- **Patient area**: dashboard with appointment stats, online booking (service + date + time slot),
  view/cancel appointments, and profile editing.
- **Staff/admin area** (role-gated): dashboard with today's bookings + stats, full appointments list
  with status/date filters, confirm/complete/cancel actions, service management (add/toggle),
  **patient records**, a **month calendar** view, and **CSV export** of appointments.
- **Notifications**: email on booking/confirm/complete/cancel + daily follow-up reminder command;
  click-to-chat **WhatsApp** links to patients.
- **Smart booking**: **treatment-room capacity** (a slot is bookable while any of the active rooms
  is free; each booking auto-assigned a room), sessions **10:00–18:00** hourly, live full-slot
  greying, and **reschedule for both patients and staff**.
- **Reporting dashboard**: totals, status distribution, last-6-months trend, by-service, and
  room-utilisation charts.
- **Password reset** via emailed link, plus in-profile password change.
- **Reusable Blade components**: `navbar`, `footer`, `icon`, `service-card`, `feature-card`,
  `section-heading`, plus shared `auth` and `dashboard` layouts.
- **Bilingual Privacy Policy** (Bahasa Malaysia + English) aligned with Malaysia's
  **Personal Data Protection Act 2010 (PDPA / Akta 709)**, with an in-page language toggle.
- **Feature tests** covering the register → OTP → book flow and staff/role authorization.

## 🧱 Tech stack

| Layer      | Technology                          |
|------------|-------------------------------------|
| Framework  | Laravel 12 (PHP 8.2+)               |
| Templating | Laravel Blade                       |
| Styling    | Tailwind CSS v4 (via Vite)          |
| JS         | Alpine.js 3 (+ @alpinejs/collapse)  |
| Build      | Vite                                |
| Database   | SQLite (default)                    |

## 🗺️ Key routes

| URI                       | Name                  | Access            | Purpose                         |
|---------------------------|-----------------------|-------------------|---------------------------------|
| `/`                       | `home`                | public            | Landing page                    |
| `/privacy-policy`         | `privacy`             | public            | PDPA bilingual privacy policy   |
| `/register` · `/login`    | `register` · `login`  | guest             | Account creation / login        |
| `/verify-email`           | `verification.notice` | auth              | Email OTP verification          |
| `/dashboard`              | `patient.dashboard`   | patient           | Patient dashboard               |
| `/book-appointment`       | `book`                | patient           | Booking form                    |
| `/profile`                | `patient.profile`     | patient           | Edit profile                    |
| `/admin/dashboard`        | `admin.dashboard`     | staff             | Staff dashboard                 |
| `/admin/appointments`     | `admin.appointments`  | staff             | Manage all appointments         |
| `/admin/services`         | `admin.services`      | staff             | Manage services                 |

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

# 4. Database (SQLite by default) — migrate and seed demo data
php artisan migrate --seed

# 5. Serve
php artisan serve
```

Then open **http://127.0.0.1:8000**.

> **Windows + XAMPP note:** if `php`/`composer` aren't on your PATH, prefix commands with the full
> path, e.g. `C:\xampp\php\php.exe artisan serve`.

## 📁 Project structure

```
app/
├── Http/Controllers/
│   ├── PageController.php          # Landing + privacy
│   ├── Auth/                       # Register, login, OTP verification
│   ├── Patient/                    # Dashboard, booking, profile
│   └── Admin/                      # Dashboard, appointments, services
├── Http/Middleware/EnsureUserIsStaff.php
├── Models/                         # User, Service, Appointment
├── Mail/OtpMail.php                # OTP email
└── Services/OtpService.php         # OTP generate/verify logic
resources/views/
├── layouts/                        # app (public), auth, dashboard
├── home.blade.php · privacy.blade.php
├── auth/ · patient/ · admin/       # Feature views
├── emails/otp.blade.php
└── components/                     # Reusable Blade components
routes/web.php · database/migrations · database/seeders
tests/Feature/BookingFlowTest.php   # End-to-end flow + authorization tests
```

## 🛣️ Roadmap

- [x] **Phase 1** — Landing page + PDPA privacy policy
- [x] **Phase 2** — Patient registration, login, email OTP verification
- [x] **Phase 3** — Appointment booking module (services, dates, status)
- [x] **Phase 4** — Staff/admin dashboard (appointments, services)
- [x] **Phase 5** — Notifications + WhatsApp + reminders, smart booking, password reset,
  advanced admin (patient records, calendar, CSV export)
- [x] **Phase 6** — Treatment-room capacity (5 rooms, admin-managed), 10:00–18:00 sessions,
  staff reschedule, reporting dashboard
- [ ] **Future** — real SMTP/WhatsApp API, per-service room mapping, audit log, online payments

## ⏰ Scheduled reminders

`appointments:reminders` emails patients whose **confirmed** appointment is tomorrow. Run it manually
with `php artisan appointments:reminders`, or keep `php artisan schedule:work` running (dev) / add a
cron calling `php artisan schedule:run` every minute (prod) — it's scheduled daily at 08:00.

## ⚖️ Disclaimer

The privacy policy is a good-faith template aligned with the PDPA — it is **not legal advice**.
Replace the placeholder entity details (clinic name, address, contact, DPO) and have it reviewed by
a qualified professional before production use.

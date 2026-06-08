# Admin Monitoring Dashboard

A simple admin dashboard web application for displaying data, managing information, and monitoring activity more efficiently. Admins can view a data summary, manage users, manage monitoring data/products, view reports, and track activity through tables and simple charts.

## Features

1. **Authentication** — Admin login & register, logout, `auth` middleware on all dashboard pages. Redirects to `/dashboard` after login.
2. **Dashboard** — Statistic cards (Total Users, Products, Reports, Active Data), monthly line chart, category bar chart, and a recent activities table.
3. **User Management** — List, search (name/email), filter (role/status), create, edit, delete, validation, and pagination.
4. **Monitoring Data / Product Management** — List, search, filter (category/status), create, edit, delete, validation, and pagination.
5. **Reports** — Summary cards, reports table, simple chart, filter by status/date, and a dummy export button.
6. **Settings** — Update admin profile, change password, dummy dark mode toggle (functional), dummy notification toggle.
7. **Reusable Layout** — Modern SaaS-style sidebar, header, responsive mobile sidebar, and active menu indicator.

## Tech Stack

- **Laravel 12** — backend
- **Vue 3** (Composition API) — frontend
- **Inertia.js** — bridge between Laravel and Vue
- **Tailwind CSS** — styling
- **MySQL** — database
- **Laravel Breeze** — authentication scaffolding
- **Chart.js + vue-chartjs** — charts
- **lucide-vue-next** — icons

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18 and npm
- MySQL (XAMPP) running on port **3307**

## Installation

```bash
# 1. Install PHP dependencies
composer install

# 2. Install JS dependencies
npm install

# 3. Copy environment file (if .env does not exist)
copy .env.example .env

# 4. Generate application key
php artisan key:generate
```

## Database Setup

Make sure MySQL (XAMPP) is running on port **3307**, then create the database:

```sql
CREATE DATABASE dashboard_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

The `.env` is already configured with:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=dashboard_app
DB_USERNAME=root
DB_PASSWORD=
```

## Migration & Seeder

```bash
php artisan migrate:fresh --seed
```

This creates the tables (`users`, `monitoring_data`, `reports`, `activities`) and fills them with dummy data, including the default admin account.

## Running the Project

Open two terminals:

```bash
# Terminal 1 — Vite dev server (frontend)
npm run dev
```

```bash
# Terminal 2 — Laravel dev server (backend)
php artisan serve
```

Then open: http://127.0.0.1:8000

> For production assets instead of the dev server, run `npm run build`.

## Dummy Login Account

| Field    | Value             |
| -------- | ----------------- |
| Email    | admin@gmail.com   |
| Password | admin123          |
| Role     | admin             |
| Status   | active            |

Additional dummy users use the password `password`.

## Folder Structure

```
app/
  Http/Controllers/
    DashboardController.php
    UserController.php
    MonitoringDataController.php
    ReportController.php
    SettingsController.php
  Models/
    User.php
    MonitoringData.php
    Report.php
    Activity.php
resources/js/
  Components/
    Sidebar.vue
    Header.vue
    StatCard.vue
    DataTable.vue
    ModalForm.vue
    ChartCard.vue
    Badge.vue
    Pagination.vue
    FlashMessage.vue
  Layouts/
    AuthenticatedLayout.vue
    GuestLayout.vue
  Pages/
    Auth/Login.vue
    Auth/Register.vue
    Dashboard.vue
    Users/Index.vue
    Users/Create.vue
    Users/Edit.vue
    MonitoringData/Index.vue
    MonitoringData/Create.vue
    MonitoringData/Edit.vue
    Reports/Index.vue
    Settings.vue
  utils/
    debounce.js
routes/
  web.php
database/
  migrations/
  seeders/
```

## UI Design

- Clean, modern dashboard layout
- Primary color: indigo/blue
- Light gray background, white cards with `rounded-xl` and shadow
- Modern sidebar with active menu indicator
- Responsive for desktop and mobile

## Screenshots

> Add your screenshots here.

| Page      | Preview                       |
| --------- | ----------------------------- |
| Login     | `<img width="1919" height="933" alt="image" src="https://github.com/user-attachments/assets/deb91052-c5ea-4b6c-94d8-1cb4d0154c02" />
`    |
| Dashboard | `![Dashboard](docs/dash.png)` |
| Users     | `![Users](docs/users.png)`    |
| Reports   | `![Reports](docs/reports.png)`|

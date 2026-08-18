<<<<<<< HEAD
<p align="center">
  <span style="font-size: 40px;">💊</span>
</p>
<h1 align="center">PharmaStock</h1>
<p align="center">
  <b>Smart Pharmacy Inventory Management System</b><br>
  Built with Laravel 12, Livewire Volt & Tailwind CSS
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white">
  <img src="https://img.shields.io/badge/Tailwind-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white">
</p>

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 📦 **Batch Tracking** | Track medicines by batch number, expiry date, and supplier |
| ⚡ **FIFO Logic** | Automatic First-In-First-Out stock deduction on sales |
| ⏰ **Expiry Alerts** | Color-coded warnings for expired & expiring-soon medicines |
| 📊 **Reports** | Stock, Expiry, and Sales reports with date-range filters |
| 🔒 **Role-Based Access** | Admin (full CRUD) vs Staff (sales & view only) |
| 🎨 **Dark Theme** | Modern glassmorphism UI with Tailwind CSS |
| ⚙️ **Dynamic Settings** | Pharmacy name, currency, and alert days configuration |

---

## 🖼 Screenshots

<p align="center">
  <img src="screenshots/dashboard.png" width="80%" alt="Dashboard">
</p>
<p align="center"><i>Dashboard with real-time statistics</i></p>

<p align="center">
  <img src="screenshots/sales.png" width="80%" alt="Sales">
</p>
<p align="center"><i>FIFO Sales with batch preview</i></p>

---

## 🚀 Installation

```bash
# Clone the repo
git clone https://github.com/YOUR_USERNAME/pharmacy-inventory-laravel.git
cd pharmacy-inventory-laravel

# Install PHP dependencies
composer install

# Install JS dependencies
npm install
npm run build

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed --class=DemoDataSeeder
php artisan db:seed --class=SettingsSeeder

# Serve
php artisan serve

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Expense Tracking App

## Introduction
Expense Tracker is a Laravel-based application for managing personal expenses. This project allows users to add, edit, view, and delete expense records. Users can categorize their expenses, input descriptions, quantities, and prices, and have a seamless user experience with error handling and validation.

## Features
- User Authentication
- Expense Management
    - Create, Read, Update, Delete (CRUD) operations
    - Expense categories
    - Validation and error handling
- User-specific expense tracking
- Responsive UI components using Blade components

## Requirements
- PHP 8.0+
- Composer
- Laravel 8+
- MySQL or any other supported database

## Installation
1. Clone the repository:
   <code>
    git clone [ https://github.com/yourusername/expense-tracker.git](https://github.com/Promise30/ExpenseTrackingApp-Laravel)
    cd expense-tracker
   </code>
   
2. Install dependencies:
   <code>
   composer install
   npm install
   npm run dev
   </code>
3. Rename .env.example to .env
   
4. Run <code>composer update</code>

5. Generate the application key:
   <code>
   php artisan key:generate
   </code>

6. Run database migrations:
   <code>
   php artisan migrate
   </code>

7. Seed the database (if necessary):
   <code>
   php artisan migrate --seed
   </code>

8. Run the application:
   <code>
   php artisan serve
   </code>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# PHP_Laravel12_Ziggy

## Project Overview

This project demonstrates how to use Ziggy in Laravel 12 to access Laravel named routes directly inside JavaScript.
Ziggy allows frontend JavaScript code to generate URLs using Laravel route names instead of hard‑coding paths.

The project shows practical examples including basic routes, route parameters, optional parameters, and multiple parameters with live navigation between pages.

This setup is ideal for beginners and developers who want clean integration between Laravel backend routes and frontend JavaScript.

---

## Features

* Access Laravel routes in JavaScript
* Generate URLs dynamically using route names
* Support for required parameters
* Support for optional parameters
* Support for multiple parameters
* Works with Blade templates
* Vite integration
* Console debugging support
* Beginner‑friendly structure

---

## Technology Stack

* PHP 8 or Higher
* Laravel 12
* Ziggy (tightenco/ziggy)
* JavaScript
* Vite
* Blade Templates
* NPM

---

## Project Structure

```
ziggy-demo/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
│   ├── js/
│   │   ├── app.js
│   │   └── ziggy.js
│   └── views/
│       ├── welcome.blade.php
│       ├── about.blade.php
│       ├── contact.blade.php
│       ├── user.blade.php
│       ├── product.blade.php
│       └── post.blade.php
├── routes/
│   └── web.php
├── package.json
└── composer.json
```

---

## Installation Steps

### 1. Create Laravel Project

```bash
composer create-project laravel/laravel ziggy-demo
cd ziggy-demo
```

### 2. Install Ziggy

```bash
composer require tightenco/ziggy
php artisan ziggy:generate
```

### 3. Install Frontend Dependencies

```bash
npm install
npm install ziggy-js
```

---

## Environment Setup

Copy `.env.example` to `.env` and generate application key:

```bash
cp .env.example .env
php artisan key:generate
```

Configure database credentials if required.

---

## Route Configuration

File: `routes/web.php`

Examples included in project:

* Home Route
  <img width="1307" height="931" alt="image" src="https://github.com/user-attachments/assets/97472785-97a8-481f-8eba-f09c44d0df94" />
* About Route
* <img width="733" height="325" alt="image" src="https://github.com/user-attachments/assets/d7e09d51-c5d2-48ac-8735-e8d6cbb0c87e" />
* Contact Route
* <img width="515" height="282" alt="image" src="https://github.com/user-attachments/assets/6432b777-9a1c-4fba-a536-eaa19fa4b689" />
* Route with Required Parameter
* <img width="398" height="192" alt="image" src="https://github.com/user-attachments/assets/3189c3bf-d48b-40b1-8a25-604003f82372" />

* Route with Optional Parameter
* Route with Multiple Parameters

Each route is assigned a name which Ziggy uses inside JavaScript.

---

## JavaScript Configuration

File: `resources/js/app.js`

* Ziggy is imported and attached globally
* `route()` function becomes available in the browser
* Allows URL generation using route names
* Supports parameters and absolute URLs

---

## Views Included

| View              | Purpose                    |
| ----------------- | -------------------------- |
| welcome.blade.php | Main demo navigation page  |
| about.blade.php   | Basic navigation test      |
| contact.blade.php | Dynamic link generation    |
| user.blade.php    | Required parameter example |
| product.blade.php | Optional parameter example |
| post.blade.php    | Multiple parameter example |

---

## Running the Project

### Terminal 1

```bash
npm run dev
```

### Terminal 2

```bash
php artisan serve
```

Open browser:

```
http://127.0.0.1:8000
```

---

## Testing Ziggy in Browser Console

Open developer console and try:

```javascript
route('about')
route('user.profile', { id: 99 })
Ziggy.current
Ziggy.routes
```

---

## Key Concepts Demonstrated

* Named route navigation
* Parameterized routes
* Optional parameters
* Multiple parameters
* Blade and JavaScript integration
* Frontend URL generation
* Route debugging

---

## Use Cases

* Single Page Applications
* Laravel with React or Vue projects
* Dynamic navigation menus
* Frontend URL generation
* Clean backend and frontend separation
* Admin dashboards
* Large scalable web applications

---

## Troubleshooting

If routes do not work, run:

```bash
php artisan ziggy:generate
php artisan optimize:clear
npm run dev
php artisan serve
```

Ensure:

* Route names exist
* ziggy.js is generated
* Vite is running
* Browser cache is cleared

---

## Requirements

* PHP 8 or Higher
* Composer
* Node.js and NPM
* Laravel 12
* Internet Connection

---

## Future Improvements

* React integration
* Vue integration
* API route support
* Role‑based navigation
* Authentication system
* Admin dashboard

---

## Author

Mihir Mehta

---

## License

Open‑source project for learning and educational use.

# Handmade Products Marketplace

A web-based marketplace platform connecting buyers with local artisans, built as a graduation project for the Department of Computer Science, Université Yahia Fares Médéa.

## Tech Stack

- **Backend:** PHP 8 
- **Database:** MySQL / MariaDB
- **Frontend:** HTML, CSS, JavaScript 
- **Server:** Apache (WAMP/LAMP Stack)

## Features

- User registration & authentication (buyer / artisan)
- Search by categories
- Artisan shop creation and product management
- Three order types: standard, customization with options, fully custom
- Internal notification system
- Admin dashboard
- Delivery informations for payment

## Requirements

- PHP 8.0+
- Apache with `mod_rewrite` enabled
- MySQL / MariaDB
- phpMyAdmin (optional)

## Installation

1. Clone the repository:
```bash
   git clone https://github.com/db-douae/Handmade-Products-Platform.git
```
2. Move the project to your server root (e.g. `/var/www/html/`)
3. Import the database:
   - Open phpMyAdmin
   - Create a new database named `db_project`
   - Import the provided `schema.sql` file
4. Configure the database connection in `Handmade-Products-Platform/project/app/config/database.php`
5. Start Apache and navigate to `http://localhost/Handmade-Products-Platform/project`

## Project Structure

└── Handmade-Products-Plateform
    └── project
        ├── app
        │   ├── actions
        │   │   ├── delete_notif.php
        │   │   ├── mark_notification_read.php
        │   │   └── update_order_status.php
        │   ├── config
        │   │   └── database.php
        │   ├── controllers
        │   │   ├── AdminController.php
        │   │   ├── AuthController.php
        │   │   ├── NotificationController.php
        │   │   ├── OrderController.php
        │   │   ├── ProductController.php
        │   │   ├── shopController.php
        │   │   └── UserController.php
        │   ├── helpers
        │   │   └── session.php
        │   └── models
        │       ├── artisan.php
        │       ├── Deliveryinfo.php
        │       ├── notification.php
        │       ├── Order.php
        │       ├── product.php
        │       ├── Shop.php
        │       └── user.php
        ├── database
        │   └── schema.sql
        ├── layouts
        │   ├── footer.php
        │   └── header.php
        ├── pages
        │   ├── account
        │   │   ├── settings.php
        │   │   └── upgrade.php
        │   ├── admin
        │   │   └── admin.php
        │   ├── artisans.php
        │   ├── auth
        │   │   ├── interests.php
        │   │   ├── login.php
        │   │   ├── logout.php
        │   │   └── signin.php
        │   ├── index.php
        │   ├── orders
        │   │   ├── Add-product.php
        │   │   ├── costumize-product.php
        │   │   ├── customize.php
        │   │   ├── delivery-info.php
        │   │   └── order-info.php
        │   ├── products.php
        │   └── shop
        │       ├── artisan-shop.php
        │       └── my-shop.php
        └── public
            ├── assets
            │   ├── css
            │   │   ├── artisans.css
            │   │   ├── info.css
            │   │   ├── interests.css
            │   │   ├── login.css
            │   │   ├── products.css
            │   │   ├── settings.css
            │   │   ├── style.css
            │   │   └── upgrade.css
            │   ├── images
            │   │   ├── colors
            │   │   ├── icons
            │   └── js
            └── uploads
            
## Authors

- **Benchidi Douae** — [GitHub](https://github.com/db-douae)
- **Battou Nedjet** — [GitHub](https://github.com/nadjetbattou-eng)

>  Graduation Project — 2025/2026 
>  Université Yahia Fares Médéa — L3 SI


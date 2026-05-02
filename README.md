# Eshop

A full-stack ecommerce application built with **Laravel 10**. It includes storefront browsing, cart, coupon support, checkout (COD + PayPal), order management, blog, reviews, and admin dashboards.

## Tech Stack

- PHP `^8.1`
- Laravel `^10`
- MySQL / MariaDB
- Laravel Mix (Webpack)
- Bootstrap 4 + jQuery
- PayPal (`srmklive/paypal`)
- Pusher (`pusher/pusher-php-server`)
- DOMPDF (`barryvdh/laravel-dompdf`)

## Core Modules

- User authentication (login/register/forgot password)
- Product catalog (category/subcategory/brand)
- Cart and wishlist
- Coupon support
- Checkout with:
  - Cash on Delivery
  - PayPal
- Order tracking and order history
- Product reviews
- Blog + comments + tags + categories
- Admin panel for products, orders, coupons, shipping, posts, users

## Project Flow

## 1) Customer Flow

1. User registers or logs in.
2. User browses products and adds items to cart.
3. User applies coupon (optional).
4. User proceeds to checkout and fills shipping/billing details.
5. User selects payment method:
   - **COD**: order placed immediately.
   - **PayPal**: redirected to PayPal, order marked paid after successful callback.
6. User sees success message and can track order from user dashboard.

## 2) Checkout and Payment Flow

1. Checkout form posts to `POST /cart/order`.
2. `OrderController@store` validates request and creates order.
3. For COD:
   - Cart rows are linked to order.
   - Cart session/coupon session are cleared.
4. For PayPal:
   - User is redirected to `/payment`.
   - PayPal callback `/payment/success` captures payment.
   - Cart rows are linked only after successful capture.

## 3) Admin Flow

1. Admin logs in at `/admin`.
2. Admin manages catalog, shipping, coupons, posts, and users.
3. Admin reviews incoming orders and updates status (`new`, `process`, `delivered`, `cancel`).
4. Admin can download order PDF invoices.

## Installation

## 1) Clone and Install

```bash
git clone <your-repo-url>
cd Complete-Ecommerce-in-laravel-10
composer install
npm install
```

## 2) Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database and service credentials.

## 3) Database Setup

Use either of these:

1. SQL import (recommended for demo data):
   - Import `database/e-shop.sql` into your MySQL database.
2. Migrations:
   - `php artisan migrate`

## 4) Storage Link + Cache Clear

```bash
php artisan storage:link
php artisan optimize:clear
```

## 5) Frontend Assets

```bash
npm run dev
```

For production build:

```bash
npm run prod
```

## 6) Run App

```bash
php artisan serve
```

Open: `http://127.0.0.1:8000`

## Important .env Configuration

Set these keys correctly:

```env
APP_NAME="Complete Ecommerce"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### PayPal

```env
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=...
PAYPAL_SANDBOX_CLIENT_SECRET=...
PAYPAL_CURRENCY=USD
```

### Pusher (optional but recommended)

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=...
PUSHER_APP_KEY=...
PUSHER_APP_SECRET=...
PUSHER_APP_CLUSTER=...
```

If you do not use Pusher locally, use a non-pusher broadcast driver to avoid notification transport errors.

## Route Map (High Value)

- Home: `GET /`
- Cart: `GET /cart`
- Checkout: `GET /checkout`
- Place order: `POST /cart/order`
- PayPal init: `GET /payment`
- PayPal success: `GET /payment/success`
- User orders: `GET /user/order`
- User order detail: `GET /user/order/show/{id}`
- Admin dashboard: `GET /admin`
- Admin orders: `GET /admin/order`
- Admin order detail: `GET /admin/order/{id}`

## Troubleshooting

- `Attempt to read property "price" on null` on order pages:
  - This happens when order has no shipping row linked.
  - Ensure shipping is selected at checkout or keep null-safe view rendering.

- `Something went wrong` during checkout with log showing cURL/Pusher SSL issues:
  - Verify Pusher credentials and SSL certificate chain.
  - For local testing, disable/replace broadcast driver if Pusher is not configured.

- `Call to undefined method ...::posts()`:
  - Ensure `posts()` relationship exists in `PostCategory` and `PostTag` models.

## Security Notes

- Never commit real `.env` secrets.
- Disable `APP_DEBUG` in production.
- Use HTTPS and secure cookies in production.

## License

This project is based on Laravel (MIT). Keep your own project licensing as needed.

# Pip & Profit - Online Trading Course Platform

A comprehensive online platform for teaching Forex & Volatility Trading. Users can buy courses, watch structured video lessons, and track progress. Admin can manage courses, users, and payments.

## Features

### Public Pages
- Landing Page with course overview
- Courses Listing
- Course Details Page
- Login / Register
- Pricing Page

### User Features
- Register/Login (Email)
- View All Courses
- Purchase Courses (Stripe)
- View Purchased Courses
- Watch Videos (DRM Protected)
- Track Lesson Progress
- Profile Management

### Admin Features
- Dashboard Overview
- Manage Courses (CRUD)
- Upload Lessons (Video, PDF, Audio)
- User Management (View/Edit/Delete)
- Role Management (Spatie)
- Orders & Payment Reports
- Site Settings

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Vue 3 + Inertia.js
- **Styling**: TailwindCSS
- **Auth**: Laravel Breeze
- **Roles & Permissions**: Spatie Laravel-Permission
- **Payment**: Stripe (One-Time + Subscription)
- **Storage**: AWS S3 for videos, signed URLs
- **Database**: MySQL
- **Deployment**: Laravel Forge

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL
- Stripe Account

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd pip
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Environment Variables**
   Add the following to your `.env` file:
   ```env
   APP_NAME="Pip & Profit"
   APP_URL=http://pip.test
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pip_profit
   DB_USERNAME=root
   DB_PASSWORD=
   
   STRIPE_KEY=pk_test_your_stripe_public_key
   STRIPE_SECRET=sk_test_your_stripe_secret_key
   STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret
   ```

6. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build Assets**
   ```bash
   npm run build
   ```

8. **Start Development Server**
   ```bash
   php artisan serve
   npm run dev
   ```

## Development

### Running Tests
```bash
php artisan test
```

### Code Formatting
```bash
npm run format
```

### Linting
```bash
npm run lint
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests and linting
5. Submit a pull request

## License

This project is licensed under the MIT License. 
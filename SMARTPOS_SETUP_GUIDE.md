# 🎓 SmartPOS - School Project Setup Guide

**Created by: Amy Janah – XI RPL 2, 2025**

## 📋 Overview

SmartPOS is a bright, modern, and responsive web-based cashier system demonstrating a digital cashier system with 3 user roles:

1. **Admin** — manages products, users, stock, and reports
2. **Cashier (Pegawai)** — processes transactions and prints receipts
3. **Customer** — views and buys products online

## 🎨 Design Theme

- **Colors**: Pastel theme (Light Blue #3B82F6, Soft Orange #FDBA74, Green #86EFAC)
- **Font**: Poppins (Google Fonts)
- **Style**: Clean, minimal, professional with rounded corners and soft shadows
- **Icons**: Bootstrap Icons
- **Charts**: Chart.js for data visualization

## 🏗️ Project Structure

### 📄 Pages Created/Updated

1. **Landing Page** (`resources/views/landing/index.blade.php`)
   - Navigation Bar (Home, About, Features, Login, Contact)
   - Hero Section with headline and CTA buttons
   - About Section explaining the project
   - Features Section (3 colorful cards)
   - Login Access Section (3 role-based buttons)
   - Footer with developer info

2. **Login Page** (`resources/views/auth/login.blade.php`)
   - SmartPOS branded login form
   - Email and password fields
   - Back to Home button
   - Responsive design

3. **Admin Dashboard** (`resources/views/admin/dashboard/index.blade.php`)
   - Top Navbar with SmartPOS logo and user info
   - Sidebar Menu (Dashboard, Products, Users, Transactions, Reports, Settings)
   - Dashboard Overview Cards:
     - Total Products (Blue)
     - Total Sales Today (Orange)
     - Total Cashiers (Green)
     - Total Customers (Purple)
   - Chart.js Sales Chart (Last 7 Days)
   - Low Stock Products Table

4. **Existing Pages** (Already in project)
   - POS/Cashier Dashboard (`resources/views/pos/index.blade.php`)
   - Product Management Pages
   - User Management Pages
   - Reports Pages
   - Customer Transaction History

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL/MariaDB
- Laravel 10.x
- Node.js & NPM (optional, for asset compilation)

### Step 1: Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sellin
DB_USERNAME=root
DB_PASSWORD=
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Generate application key
php artisan key:generate
```

### Step 3: Database Setup
```bash
# Run migrations
php artisan migrate

# Seed database with initial data
php artisan db:seed
```

### Step 4: Storage Link
```bash
# Create symbolic link for storage
php artisan storage:link
```

### Step 5: Run the Application
```bash
# Start Laravel development server
php artisan serve

# Access the application at:
# http://localhost:8000
```

## 👥 Default User Roles

After seeding, you should have the following roles:

1. **Admin**
   - Email: admin@smartpos.local
   - Password: (set during seeding)
   - Full access to all features

2. **Cashier (Pegawai)**
   - Email: kasir@smartpos.local
   - Password: (set during seeding)
   - Access to POS and transaction processing

3. **Customer**
   - Email: customer@smartpos.local
   - Password: (set during seeding)
   - Access to catalog and transaction history

## 📊 Admin Dashboard Features

### Statistics Cards
- **Total Products**: Shows count with percentage change
- **Total Sales Today**: Displays today's revenue
- **Total Cashiers**: Number of registered cashiers
- **Total Customers**: Number of registered customers

### Sales Chart
- Bar chart showing sales for the last 7 days
- Interactive tooltips with formatted currency
- Responsive design

### Low Stock Alert Table
- Lists products with stock below threshold
- Color-coded badges (Red: Out of Stock, Yellow: Low Stock)
- Quick link to product management

## 🧾 Cashier Dashboard Features

- Product catalog with search and barcode scanning
- Shopping cart with quantity management
- Payment processing (Cash, QR, Transfer)
- Receipt generation (print/PDF)
- Transaction history

## 🛒 Customer Features

- Browse product catalog
- View transaction history from POS purchases
- Download receipts

## 🎯 Key Technologies

- **Backend**: Laravel 10.x (PHP)
- **Frontend**: Blade Templates, Custom CSS
- **Database**: MySQL
- **Charts**: Chart.js
- **Icons**: Bootstrap Icons
- **Fonts**: Google Fonts (Poppins)

## 📝 Routes Overview

```php
// Landing & Auth
GET  /                          - Landing page
GET  /login                     - Login page
POST /login                     - Login action
GET  /register                  - Registration page
GET  /logout                    - Logout

// Admin Routes (role: admin)
GET  /admin/dashboard           - Admin dashboard
GET  /admin/products            - Product management
GET  /admin/users               - User management
GET  /admin/reports             - Reports & analytics

// Cashier Routes (role: pegawai)
GET  /pos                       - POS interface
POST /pos/checkout              - Process transaction
GET  /cashier/reports           - Cashier reports

// Customer Routes (role: customer)
GET  /catalog                   - Product catalog
GET  /customer/transactions     - Transaction history
```

## 🎨 Design Customization

### Color Scheme
```css
--primary-blue: #3B82F6
--primary-orange: #FDBA74
--primary-green: #86EFAC
--primary-purple: #C084FC
--background: #F8FAFC
--text-dark: #1E293B
--text-light: #64748B
```

### Responsive Breakpoints
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

## 🐛 Troubleshooting

### Database Connection Error
- Check `.env` file database credentials
- Ensure MySQL service is running
- Run `php artisan config:clear`

### Missing Dependencies
```bash
composer install
composer dump-autoload
```

### Permission Errors
```bash
chmod -R 775 storage bootstrap/cache
```

### Chart Not Displaying
- Ensure Chart.js CDN is loaded
- Check browser console for JavaScript errors
- Verify data is passed from controller

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Chart.js Documentation](https://www.chartjs.org/docs)
- [Bootstrap Icons](https://icons.getbootstrap.com)
- [Google Fonts](https://fonts.google.com)

## 👨‍💻 Development Notes

### Controller Updates
The `DashboardController` has been updated to provide:
- `$totalProducts`: Total product count
- `$todaySales`: Today's sales amount
- `$totalCashiers`: Number of cashiers
- `$totalCustomers`: Number of customers
- `$lowStockProducts`: Products with low stock
- `$chartLabels`: Labels for Chart.js
- `$chartData`: Sales data for Chart.js

### Database Schema
Key tables:
- `users` (with role_id)
- `roles` (admin, pegawai, customer)
- `products`
- `product_variants` (with stock, price, discount)
- `sales` (transactions)
- `sale_items` (transaction details)

## 🎓 School Project Notes

This project demonstrates:
- ✅ Full-stack web development
- ✅ User authentication & authorization
- ✅ CRUD operations
- ✅ Database design & relationships
- ✅ Responsive UI/UX design
- ✅ Data visualization with charts
- ✅ PDF generation for receipts
- ✅ Barcode scanning integration
- ✅ Real-time calculations
- ✅ Role-based access control

## 📧 Contact & Support

For questions or issues:
- Email: support@smartpos.local
- Developer: Amy Janah – XI RPL 2
- Year: 2025

---

**🎉 Good luck with your presentation! 🎉**

*This project showcases modern web development practices and clean, professional design suitable for school projects and portfolio demonstrations.*

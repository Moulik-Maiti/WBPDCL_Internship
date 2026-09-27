# WBPDCL Operations & Incident Management System

A web-based operations, incident reporting, and role-based tracking portal developed for the **West Bengal Power Development Corporation Limited (WBPDCL)**. The application streamlines incident submission, audit trail tracking, user access management, and operations analytics.

---

## Table of Contents

- [Overview](#overview)
- [Key Features](#key-features)
- [Technology Stack](#technology-stack)
- [System Architecture](#system-architecture)
- [Prerequisites](#prerequisites)
- [Installation & Setup](#installation--setup)
- [Database Configuration & Seeding](#database-configuration--seeding)
- [Role-Based Access Control (RBAC)](#role-based-access-control-rbac)
- [Project Directory Structure](#project-directory-structure)
- [Security & Authorization](#security--authorization)
- [License](#license)

---

## Overview

The WBPDCL Operations Portal provides a centralized system for tracking technical reports, operational issues, and team resolution metrics. It replaces manual paper-based logging with structured reporting workflows, real-time analytics, automated audit trails, and strict role-based permission enforcement.

---

## Key Features

### 1. Operations & Incident Reporting
- **Report Lifecycle Tracking**: Create, view, update, and manage operational incident reports with status workflows (`Pending`, `In Progress`, `Completed`, `Rejected`).
- **Multi-Criteria Filtering**: Filter records by status, keyword search, or dynamic date ranges using Flatpickr.
- **Excel Export**: Export filtered or full report registries to `.xlsx` format via `maatwebsite/excel`.

### 2. Audit Trail & History Tracking
- **Automated Logging**: Automatic creation of immutable historical log entries on status changes and report updates.
- **User Attribution**: Explicit user attribution and timestamps recording who made each change and when.
- **Remarks & Notes**: Audit records preserve specific contextual remarks entered during workflow transitions.

### 3. Analytics & Dashboard
- **Live KPI Metrics**: Real-time counters for Total Reports, Pending Review, Resolution Rate, and Registered Users.
- **Resolution Trends**: Interactive 7-day grouped bar chart comparing submitted vs. resolved incidents via Chart.js.
- **Annual Distribution**: 12-month volume trend line chart illustrating submission density.
- **Team Workload Distribution**: Workload breakdown displaying open incidents per assigned team member.
- **Live Activity Feed**: Real-time timeline of recent status modifications across the organization.

### 4. Role-Based Access Control (RBAC)
- **Granular Permissions**: Fine-grained permissions for reports, users, roles, and system permissions.
- **Role Hierarchy**: Configurable roles (e.g., Administrator, Manager, Operator) with associated permission matrices powered by `spatie/laravel-permission`.

---

## Technology Stack

| Layer | Technology | Purpose |
|---|---|---|
| **Backend Framework** | Laravel 11 / PHP 8.2+ | Core MVC application and API endpoints |
| **Database** | MySQL / SQLite | Relational persistence layer |
| **RBAC Engine** | `spatie/laravel-permission` | Role and permission management with middleware enforcement |
| **Data Export** | `maatwebsite/excel` | Spreadsheet generation for operational reports |
| **Frontend Styling** | Tailwind CSS / PostCSS | Utility-first responsive design |
| **Interactivity** | Alpine.js | UI state handling, mobile drawer, and modals |
| **Data Visualization** | Chart.js | Interactive operations analytics charts |
| **Date Pickers** | Flatpickr | Multi-date range selection |
| **Asset Bundler** | Vite 8 | Frontend asset compilation |

---

## System Architecture

```
├── Web Requests
│    ├── Authentication Layer (Laravel Breeze)
│    ├── Middleware Pipeline (Permission & Role verification)
│    └── Controller Actions (ReportController, UserController, etc.)
├── Service & Domain Layer
│    ├── Eloquent Models (Report, History, Status, User)
│    ├── RBAC Guard (Spatie Permission Middleware)
│    └── Export Services (ReportsExport)
└── Presentation Layer
     ├── Blade Templates (Responsive Layout with Collapsible Sidebar)
     ├── Alpine.js Reactive Components
     └── Chart.js Visualizations
```

---

## Prerequisites

Before running the application locally, ensure your environment meets the following requirements:

- **PHP**: `>= 8.2` with `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd` extensions enabled
- **Composer**: `>= 2.2`
- **Node.js**: `>= 18.x` & **npm**: `>= 9.x`
- **Database Server**: MySQL 8.x, MariaDB 10.x, or SQLite 3

---

## Installation & Setup

### 1. Clone the Repository
```bash
git clone <repository-url>
cd application
```

### 2. Install PHP Dependencies
```bash
composer install --optimize-autoloader
```

### 3. Install Node Dependencies
```bash
npm install
```

### 4. Environment Configuration
Copy the example environment file and configure your database parameters:
```bash
cp .env.example .env
```

Open `.env` and verify your database settings:
```env
APP_NAME=WBPDCL
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Kolkata
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
# Or for MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=wbpdcl_operations
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5. Generate Application Encryption Key
```bash
php artisan key:generate
```

---

## Database Configuration & Seeding

Run the database migrations and seed default system statuses:

```bash
php artisan migrate --seed
```

To seed specific operational statuses independently:
```bash
php artisan db:seed --class=StatusSeeder
```

---

## Frontend Compilation

Compile frontend assets for development or production:

```bash
# Build for production
npm run build

# Or run the Vite development server with hot-reloading
npm run dev
```

---

## Running the Application

Start the local PHP development server:

```bash
php artisan serve
```

The portal will be accessible at:
```
http://127.0.0.1:8000
```

---

## Role-Based Access Control (RBAC)

The system implements strict permission checks at both the controller layer via Laravel 11's `HasMiddleware` interface and at the route layer:

| Resource | Required Permission | Action |
|---|---|---|
| **Reports** | `view report` | View listing and search results |
| | `create report` | Create and store new report entries |
| | `edit report` | Modify existing reports and update workflow status |
| | `delete report` | Remove report records |
| **Audit History** | `view history` | Inspect audit trail and status transition history |
| **Users** | `view users` | Access user directory |
| | `create users` | Register new team members |
| | `edit users` | Modify user credentials and assign roles |
| | `delete users` | Remove user access |
| **Roles** | `view role` | List roles and assigned permissions |
| | `create roles` | Define new system roles |
| | `edit roles` | Update role permission matrices |
| | `delete roles` | Remove roles |
| **Permissions** | `view permissions` | Inspect all registered permissions |
| | `create permissions` | Define new permission identifiers |
| | `edit permissions` | Modify permission parameters |
| | `delete permissions` | Remove permission definitions |

---

## Project Directory Structure

```
application/
├── app/
│   ├── Exports/               # Excel export definitions (ReportsExport)
│   ├── Http/
│   │   ├── Controllers/       # Controller logic (Report, History, User, Role, etc.)
│   │   └── Requests/          # Form request validations
│   ├── Models/                # Eloquent models (Report, History, Status, User)
│   └── Providers/             # Service providers
├── bootstrap/
│   └── app.php                # Application bootstrapping and middleware configuration
├── config/                    # Application and package configurations
├── database/
│   ├── migrations/            # Database schema definitions
│   └── seeders/               # Status and initial database seeders
├── public/
│   └── images/                # Static assets, including the WBPDCL logo
├── resources/
│   ├── css/                   # Tailwind CSS stylesheets
│   ├── js/                    # Alpine.js and JavaScript entry points
│   └── views/
│       ├── layouts/           # Application master layouts, navigation, and sidebar
│       ├── Report/            # Report views (list, create, edit)
│       ├── history/           # Audit trail and history views
│       ├── user/              # User management views
│       ├── roles/             # Role management views
│       └── permission/        # Permission management views
├── routes/
│   ├── auth.php               # Authentication routes
│   └── web.php                # Web routes and resource mappings
└── vite.config.js             # Vite asset build configuration
```

---

## Security & Authorization

- **CSRF Protection**: All form submissions and AJAX calls require valid CSRF tokens (`@csrf` / `x-csrf-token`).
- **SQL Injection Prevention**: Built entirely with Eloquent ORM and parameterized queries.
- **Controller Middleware**: Authorization checks enforced on controller dispatch using Laravel 11's `HasMiddleware` contract.
- **Password Hashing**: User authentication passwords are encrypted using Bcrypt (`Hash::make`).

---

## License

This software is developed and maintained for the internal operations of the **West Bengal Power Development Corporation Limited (WBPDCL)**. Unauthorized distribution or reproduction is prohibited.

# SkyConnect Flight Reservation System

## Project Overview

SkyConnect is a modern, hybrid web application for flight booking and management. This project combines Laravel (PHP) for the backend API and Blade templating, with a Node.js backend for real-time data processing, and a modern frontend using EJS templates and Bootstrap 5.

## Table of Contents

- [Technology Stack](#technology-stack)
- [Architecture](#architecture)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Schema](#database-schema)
- [API Endpoints](#api-endpoints)
- [Frontend Components](#frontend-components)
- [Payment System](#payment-system)
- [Testing](#testing)
- [Deployment](#deployment)
- [Development Guidelines](#development-guidelines)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)

## Technology Stack

### Backend (Laravel)
- **Framework**: Laravel 12.x
- **Database**: MongoDB (primary)
- **Authentication**: Laravel Sanctum + JWT tokens
- **Queue System**: Database queues
- **Caching**: Database cache
- **Mail**: Log driver (configurable)
- **File Storage**: Local storage

### Backend (Node.js)
- **Runtime**: Node.js with Express
- **Database**: MongoDB via Mongoose
- **API Security**: Token-based authentication
- **Middleware**: CORS, body parsing, request logging

### Frontend
- **Templating**: EJS (Node.js) + Blade (Laravel)
- **CSS Framework**: Bootstrap 5 + Custom CSS
- **JavaScript**: Vanilla JS + Axios
- **Styling**: Custom CSS with iPhone theme
- **Icons**: Font Awesome 6

### Development Tools
- **Package Manager**: npm
- **Build Tool**: Vite
- **Version Control**: Git
- **Testing**: PHPUnit (Laravel)

## Architecture

### Hybrid Architecture Pattern

SkyConnect uses a hybrid architecture that combines:

1. **Laravel Backend**: Handles authentication, user management, and serves Blade templates
2. **Node.js Backend**: Manages flight data, bookings, and real-time operations
3. **Shared Database**: MongoDB for both Laravel and Node.js

### Data Flow

```
User Request → Laravel (Auth/Blade) → Node.js API → MongoDB
             ← Response ← Response ← Response
```

### Key Components

- **Authentication System**: Laravel handles user auth, Node.js uses API tokens
- **Flight Management**: Node.js manages flight data and availability
- **Booking System**: Hybrid approach with data synchronization
- **Payment Processing**: Laravel handles payment logic with mock processing

## Installation

### Prerequisites

- PHP 8.2+
- Node.js 18+
- MySQL 8.0+
- MongoDB 6.0+
- Composer
- npm

### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd laravelSU15
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   # Edit .env file with your configuration
   ```

5. **Database Setup**
   ```bash
   # For MongoDB (Laravel)
   # Ensure MongoDB is running
   # Laravel will connect automatically using MongoDB driver
   
   # For MongoDB (Node.js)
   # Ensure MongoDB is running
   # Node.js will connect automatically
   ```

6. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

7. **Build Frontend Assets**
   ```bash
   npm run build
   ```

8. **Start Services**
   ```bash
   # Start Laravel development server
   php artisan serve
   
   # Start Node.js backend
   npm run node-dev
   
   # Or use the dev script for both
   npm run dev
   ```

## Configuration

### Environment Variables

Key environment variables to configure:

```env
# Application
APP_NAME=SkyConnect
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (MongoDB for Laravel)
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=skyconnect
DB_USERNAME=
DB_PASSWORD=
MONGO_URL=mongodb://127.0.0.1:27017/skyconnect

# Database (MongoDB for Node.js)
MONGO_URL=mongodb://localhost:27017/skyconnect

# Authentication
AUTH_GUARD=web
AUTH_PASSWORD_BROKER=users

# Cache
CACHE_STORE=database

# Queue
QUEUE_CONNECTION=database

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

### Database Configuration

The application uses MongoDB as the primary database for both Laravel and Node.js:

1. **MongoDB (Laravel)**: User management, payments, bookings
2. **MongoDB (Node.js)**: Flight data, real-time operations

### Security Configuration

- API tokens are generated for authenticated users
- CORS is enabled for cross-origin requests
- Passwords are hashed using bcrypt
- Session management with database storage

## Database Schema

### MySQL Tables (Laravel)

#### users
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'employee', 'customer') DEFAULT 'customer',
    is_active BOOLEAN DEFAULT true,
    api_token VARCHAR(60) UNIQUE,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### flights
```sql
CREATE TABLE flights (
    id INT PRIMARY KEY AUTO_INCREMENT,
    flight_number VARCHAR(20) UNIQUE NOT NULL,
    origin_airport_id INT NOT NULL,
    destination_airport_id INT NOT NULL,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    airline VARCHAR(100) NOT NULL,
    capacity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (origin_airport_id) REFERENCES airports(id),
    FOREIGN KEY (destination_airport_id) REFERENCES airports(id)
);
```

#### bookings
```sql
CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    flight_id INT NOT NULL,
    booking_reference VARCHAR(50) UNIQUE NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    total_price DECIMAL(10,2) NOT NULL,
    fare_class VARCHAR(20) DEFAULT 'economy',
    seat_number VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (flight_id) REFERENCES flights(id)
);
```

#### payments
```sql
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    booking_id INT NOT NULL,
    payment_reference VARCHAR(50) UNIQUE NOT NULL,
    card_number VARCHAR(16) NOT NULL,
    card_holder_name VARCHAR(100) NOT NULL,
    card_expiry_month VARCHAR(2) NOT NULL,
    card_expiry_year VARCHAR(4) NOT NULL,
    card_cvv VARCHAR(3) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(20) DEFAULT 'credit_card',
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (booking_id) REFERENCES bookings(id)
);
```

### MongoDB Collections (Node.js)

#### flights
```javascript
{
    _id: ObjectId,
    flight_number: String,
    origin_airport_id: ObjectId,
    destination_airport_id: ObjectId,
    departure_time: Date,
    arrival_time: Date,
    price: Number,
    airline: String,
    capacity: Number,
    createdAt: Date,
    updatedAt: Date
}
```

#### airports
```javascript
{
    _id: ObjectId,
    code: String,
    name: String,
    city: String,
    country: String,
    createdAt: Date,
    updatedAt: Date
}
```

#### bookings
```javascript
{
    _id: ObjectId,
    user: ObjectId,
    flight: ObjectId,
    booking_reference: String,
    status: String,
    total_price: Number,
    createdAt: Date,
    updatedAt: Date
}
```

#### passengers
```javascript
{
    _id: ObjectId,
    booking_id: ObjectId,
    first_name: String,
    last_name: String,
    date_of_birth: Date,
    passport_number: String,
    seat_number: String,
    createdAt: Date,
    updatedAt: Date
}
```

## API Endpoints

### Laravel API Endpoints

#### Authentication
- `POST /api/users` - Create user
- `GET /api/users` - List users (admin only)
- `PUT /api/users/{id}` - Update user (admin only)
- `DELETE /api/users/{id}` - Delete user (admin only)
- `POST /api/users/{id}/toggle-restriction` - Toggle user restriction

#### Flights
- `GET /api/flights` - List flights
- `GET /api/flights/{id}` - Get flight details

#### Bookings
- `GET /api/bookings` - List bookings (admin only)
- `GET /api/bookings/{id}` - Get booking details (admin only)

### Node.js API Endpoints

#### Public Endpoints
- `GET /api/airports` - List all airports
- `GET /api/flights` - List all flights with airport details
- `GET /api/flights/{id}` - Get flight details
- `GET /api/flights/{id}/seats` - Get available seats for flight

#### Protected Endpoints (require API token)
- `POST /api/flights` - Create flight (admin only)
- `PUT /api/flights/{id}` - Update flight (admin only)
- `DELETE /api/flights/{id}` - Delete flight (admin only)
- `POST /api/bookings` - Create booking
- `PUT /api/bookings/{id}` - Update booking (admin only)
- `DELETE /api/bookings/{id}` - Delete booking (admin only)

### Authentication

The system uses API tokens for authentication:

1. Users log in through Laravel
2. Laravel generates an API token
3. Node.js validates the token for protected endpoints
4. Tokens are passed via `Authorization: Bearer <token>` header

## Frontend Components

### Blade Templates (Laravel)

#### Layout System
- `resources/views/layouts/app.blade.php` - Main application layout
- `resources/views/layouts/auth.blade.php` - Authentication layout

#### Pages
- `resources/views/welcome.blade.php` - Homepage
- `resources/views/auth/login.blade.php` - Login page
- `resources/views/auth/register.blade.php` - Registration page
- `resources/views/flights/search.blade.php` - Flight search interface
- `resources/views/flights/index.blade.php` - Flight listing
- `resources/views/bookings/index.blade.php` - Booking history
- `resources/views/bookings/create.blade.php` - Booking creation
- `resources/views/payments/process.blade.php` - Payment processing

### EJS Templates (Node.js)

#### Pages
- `node-backend/views/welcome.ejs` - Welcome page
- `node-backend/views/flights/search.ejs` - Flight search
- `node-backend/views/bookings/index.ejs` - Booking management
- `node-backend/views/employee/dashboard.ejs` - Employee dashboard

#### Partials
- `node-backend/views/partials/header.ejs` - Header component
- `node-backend/views/partials/footer.ejs` - Footer component

### Styling

#### CSS Architecture
- `resources/css/app.css` - Main CSS file
- `public/css/iphone-theme.css` - Custom iPhone-style theme
- Bootstrap 5 for base styling
- Custom CSS for premium appearance

#### Key Styling Features
- Premium corporate design
- iPhone-style UI elements
- Responsive design
- Dark theme support
- Custom animations and transitions

## Payment System

### Payment Flow

1. **Booking Creation**: User selects flight and provides passenger details
2. **Payment Processing**: Redirected to payment page
3. **Card Information**: Secure card input form
4. **Mock Processing**: Simulated payment processing
5. **Confirmation**: Booking confirmed and user redirected

### Payment Model

```php
class Payment extends Model
{
    protected $fillable = [
        'user_id', 'booking_id', 'payment_reference',
        'card_number', 'card_holder_name', 'card_expiry_month',
        'card_expiry_year', 'card_cvv', 'amount', 'status',
        'payment_method', 'paid_at'
    ];

    public function isCompleted() { return $this->status === 'completed'; }
    public function isPending() { return $this->status === 'pending'; }
    public function isFailed() { return $this->status === 'failed'; }
}
```

### Security Features

- Card data is stored as plain text (for demo purposes)
- In production, implement proper encryption
- Payment validation and status tracking
- Reference number generation for tracking

## Testing

### Laravel Testing

#### Test Structure
- `tests/Feature/` - Feature tests
- `tests/Unit/` - Unit tests
- `tests/TestCase.php` - Base test case

#### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=ExampleTest

# Run with coverage
php artisan test --coverage
```

#### Test Examples
```php
// Feature test example
public function test_user_can_book_flight()
{
    $user = User::factory()->create();
    $flight = Flight::factory()->create();

    $response = $this->actingAs($user)
        ->post('/api/bookings', [
            'flight_id' => $flight->id,
            'passengers' => [
                ['first_name' => 'John', 'last_name' => 'Doe']
            ]
        ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('bookings', [
        'user_id' => $user->id,
        'flight_id' => $flight->id
    ]);
}
```

### Node.js Testing

Currently, the Node.js backend doesn't have a formal testing setup. Consider adding:

- Jest or Mocha for unit testing
- Supertest for API testing
- Test database setup for integration tests

## Deployment

### Production Environment

#### Server Requirements
- PHP 8.2+
- Node.js 18+
- MongoDB 6.0+
- Web server (Apache/Nginx)

#### Deployment Steps

1. **Environment Setup**
   ```bash
   # Set production environment
   APP_ENV=production
   APP_DEBUG=false
   
   # Configure production database
   DB_CONNECTION=mongodb
   DB_HOST=your-production-host
   DB_DATABASE=your-production-db
   DB_USERNAME=
   DB_PASSWORD=
   
   # Configure production MongoDB
   MONGO_URL=mongodb://your-mongo-host:27017/your-db
   ```

2. **Optimization**
   ```bash
   # Optimize Laravel
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   
   # Build frontend for production
   npm run build
   ```

3. **Queue Worker**
   ```bash
   # Start queue worker
   php artisan queue:work --daemon
   ```

4. **Web Server Configuration**
   - Configure Apache/Nginx to serve Laravel
   - Set up reverse proxy for Node.js backend
   - Configure SSL certificates

### Docker Deployment

Consider creating Docker containers for easier deployment:

```dockerfile
# Laravel container
FROM php:8.2-apache
# ... configuration

# Node.js container
FROM node:18
# ... configuration

# MongoDB container
FROM mongo:6.0
# ... configuration
```

### Environment-Specific Configuration

#### Development
- Debug mode enabled
- Local database connections
- Hot reloading for development

#### Staging
- Production-like environment
- Staging database
- Limited debug information

#### Production
- Debug mode disabled
- Optimized configuration
- Production database
- Monitoring and logging

## Development Guidelines

### Code Style

#### PHP (Laravel)
- Follow PSR-12 coding standards
- Use Laravel naming conventions
- Type hinting for better IDE support
- DocBlocks for public methods

#### JavaScript (Node.js)
- Use ES6+ syntax
- Consistent indentation (2 spaces)
- Meaningful variable names
- Error handling for all async operations

#### CSS
- BEM methodology for naming
- Consistent spacing and formatting
- Mobile-first responsive design
- CSS custom properties for theming

### Git Workflow

#### Branching Strategy
- `main` - Production-ready code
- `develop` - Integration branch
- `feature/*` - Feature branches
- `hotfix/*` - Emergency fixes

#### Commit Messages
```
feat: add flight search functionality
fix: resolve booking confirmation bug
docs: update API documentation
style: format code according to PSR-12
refactor: simplify payment processing logic
test: add unit tests for user model
chore: update dependencies
```

#### Pull Request Guidelines
- Create feature branches from `develop`
- Squash commits before merging
- Include tests for new features
- Update documentation as needed
- Get code review before merging

### Security Best Practices

#### Authentication
- Use strong password policies
- Implement rate limiting for login attempts
- Use HTTPS in production
- Regularly rotate API tokens

#### Data Protection
- Encrypt sensitive data (especially payment info)
- Use parameterized queries to prevent SQL injection
- Validate and sanitize all user inputs
- Implement proper access controls

#### API Security
- Use HTTPS for all API calls
- Implement proper CORS configuration
- Rate limit API endpoints
- Use API versioning for backward compatibility

## Troubleshooting

### Common Issues

#### Database Connection Errors
```bash
# Check MongoDB service
sudo systemctl status mongod

# Verify database credentials in .env
```

#### Node.js Backend Not Starting
```bash
# Check Node.js version
node --version

# Check if MongoDB is running
mongo --version

# Check Node.js logs
npm run node-dev
```

#### Laravel Development Server Issues
```bash
# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check for missing dependencies
composer install

# Regenerate autoload files
composer dump-autoload
```

#### Frontend Build Issues
```bash
# Clear npm cache
npm cache clean --force

# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install

# Rebuild assets
npm run build
```

### Debug Mode

Enable debug mode in `.env`:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Log Files

- Laravel logs: `storage/logs/laravel.log`
- Node.js logs: Console output
- Web server logs: System-specific location

### Performance Optimization

#### Database Optimization
- Add indexes for frequently queried fields
- Use eager loading to prevent N+1 queries
- Implement caching for frequently accessed data

#### Frontend Optimization
- Minify CSS and JavaScript files
- Use CDN for static assets
- Implement lazy loading for images

#### Backend Optimization
- Use queue workers for background tasks
- Implement proper caching strategies
- Optimize database queries

## Contributing

### Getting Started

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Update documentation
6. Submit a pull request

### Code Review Process

- All changes require code review
- Tests must pass before merging
- Documentation updates are required for new features
- Follow the established coding standards

### Issue Reporting

When reporting issues, please include:
- Detailed description of the problem
- Steps to reproduce
- Expected behavior vs actual behavior
- Environment information (OS, browser, versions)
- Screenshots if applicable

### Feature Requests

Submit feature requests through GitHub issues with:
- Clear description of the feature
- Use cases and benefits
- Any relevant mockups or examples
- Priority level if applicable

## License

This project is licensed under the MIT License. See the LICENSE file for details.

## Support

For support and questions:
- Create a GitHub issue
- Check the troubleshooting section
- Review the documentation
- Contact the development team

## Changelog

### Version 1.0.0
- Initial release
- Complete flight booking system
- Hybrid Laravel/Node.js architecture
- Payment processing integration
- Admin dashboard functionality

---

**Note**: This documentation is automatically generated and should be kept up-to-date with the codebase. For the most current information, always refer to the source code and commit history.

# Payment System Documentation

## Overview

A complete mock payment processing system has been implemented for flight bookings. This system securely stores payment information and provides a realistic payment flow for demonstration purposes.

## Features

### 1. Payment Processing
- **Secure Card Input**: Validates card number, CVV, and expiry date
- **Mock Payment**: Simulates successful payment processing
- **Payment Storage**: Stores payment details in database (for demo purposes)
- **Booking Confirmation**: Automatically confirms booking after payment

### 2. Payment History
- **Transaction Records**: View all payment transactions
- **Payment Status**: Track payment status (completed, pending, failed)
- **Card Information**: Display masked card numbers for security
- **Flight Details**: Link payments to specific bookings

### 3. Security Features
- **Input Validation**: Validates all payment fields
- **Card Number Masking**: Only shows last 4 digits in history
- **Database Storage**: Securely stores payment data
- **User Authorization**: Only users can access their own payments

## Database Schema

### Payments Table
```sql
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    booking_id INT NOT NULL,
    payment_reference VARCHAR(255) UNIQUE NOT NULL,
    card_number VARCHAR(255) NOT NULL,
    card_holder_name VARCHAR(255) NOT NULL,
    card_expiry_month VARCHAR(2) NOT NULL,
    card_expiry_year VARCHAR(4) NOT NULL,
    card_cvv VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50) DEFAULT 'credit_card',
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);
```

## Routes

### Payment Routes
- `GET /payments/{booking}/process` - Show payment form
- `POST /payments/{booking}/process` - Process payment
- `GET /payments` - View payment history

### Booking Routes (Updated)
- `GET /bookings/{booking}` - Show booking with payment status
- `GET /my-bookings` - View all bookings

## Usage Flow

### 1. Booking Creation
1. User books a flight
2. Booking is created with status "confirmed" (immediate)
3. Payment is NOT required initially

### 2. Payment Processing
1. User views booking details
2. If no payment exists, "Process Payment" button appears
3. User clicks button and is taken to payment form
4. User enters card information
5. Payment is processed and stored
6. Booking status remains "confirmed"

### 3. Payment History
1. User can view all payment transactions
2. Each payment shows:
   - Payment reference number
   - Amount and date
   - Card information (masked)
   - Flight details
   - Payment status

## Security Notes

⚠️ **Important**: This is a mock payment system for demonstration purposes.

### Current Implementation
- Card numbers are stored as plain text (NOT recommended for production)
- CVV is stored in database (NOT recommended for production)
- No actual payment gateway integration

### Production Recommendations
- **Encrypt sensitive data**: Use Laravel's encryption for card numbers and CVV
- **Tokenization**: Use payment gateway tokens instead of storing card data
- **PCI Compliance**: Follow PCI DSS standards for payment processing
- **Secure Transmission**: Use HTTPS for all payment-related requests

## Files Created/Modified

### New Files
- `app/Models/Payment.php` - Payment model
- `app/Http/Controllers/PaymentController.php` - Payment controller
- `resources/views/payments/process.blade.php` - Payment form
- `resources/views/payments/index.blade.php` - Payment history
- `database/migrations/2026_03_06_094017_create_payments_table.php` - Migration

### Modified Files
- `app/Models/Booking.php` - Added payment relationship
- `resources/views/bookings/show.blade.php` - Added payment section
- `routes/web.php` - Added payment routes

## Commands

### Run Migration
```bash
php artisan migrate
```

### Seed Database (includes admin account)
```bash
php artisan db:seed
```

### Clear Dashboard Cache
```bash
php artisan dashboard:clear-cache
```

## Testing

### Test Payment Flow
1. Create a booking
2. View booking details
3. Click "Process Payment"
4. Enter test card details:
   - Card Number: `1234567890123456`
   - Card Holder: `Test User`
   - Expiry: Any future date
   - CVV: `123`
5. Submit payment
6. View payment confirmation
7. Check payment history

### Test Payment History
1. Make multiple bookings and payments
2. Visit `/payments`
3. View all payment transactions
4. Verify masked card numbers
5. Check payment status and details

## Integration Points

### With Existing System
- **Bookings**: Each booking can have one payment
- **Users**: Users can view their payment history
- **Dashboard**: Admins can see booking and payment statistics
- **Authentication**: Payment access requires user login

### Future Enhancements
- **Payment Methods**: Add support for different payment types
- **Refunds**: Implement payment refund functionality
- **Recurring Payments**: Support for subscription-based payments
- **Payment Gateway**: Integrate with real payment processors (Stripe, PayPal, etc.)
- **Fraud Detection**: Add fraud detection and prevention
- **Receipts**: Generate and email payment receipts

## Troubleshooting

### Common Issues
1. **Migration Errors**: Ensure database connection is working
2. **Route Not Found**: Check that payment routes are properly defined
3. **Validation Errors**: Verify all required fields are filled
4. **Authorization Errors**: Ensure user is logged in for payment access

### Debug Commands
```bash
# Check routes
php artisan route:list | grep payment

# Check migrations
php artisan migrate:status

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

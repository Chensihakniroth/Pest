@extends('layouts.app')

@section('title', 'Process Payment - SkyConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle me-3">
                            <i class="fas fa-credit-card fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">Payment Processing</h4>
                            <p class="mb-0 small opacity-75">Secure payment for your booking</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Booking Summary -->
                    <div class="alert alert-info border-0 bg-info bg-opacity-10 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle text-info fa-lg me-3"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Booking Summary</h6>
                                <p class="mb-0 small">
                                    <strong>Flight:</strong> {{ $booking->flightDetails->flight_number }}<br>
                                    <strong>Route:</strong> {{ $booking->flightDetails->originAirport->city }} → {{ $booking->flightDetails->destinationAirport->city }}<br>
                                    <strong>Class:</strong> {{ ucfirst($booking->fare_class) }}<br>
                                    <strong>Amount:</strong> ${{ number_format($booking->total_price, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form action="{{ route('payments.process', $booking) }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- Card Number -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Card Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fab fa-cc-visa text-primary"></i>
                                    </span>
                                    <input type="text"
                                           name="card_number"
                                           class="form-control border-start-0"
                                           placeholder="1234 5678 9012 3456"
                                           maxlength="16"
                                           required
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                <div class="form-text">Enter your 16-digit card number</div>
                            </div>

                            <!-- Card Holder Name -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Card Holder Name</label>
                                <input type="text"
                                       name="card_holder_name"
                                       class="form-control"
                                       placeholder="John Doe"
                                       required
                                       maxlength="100">
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Expiry Month</label>
                                <select name="card_expiry_month" class="form-select" required>
                                    <option value="">Select Month</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Expiry Year</label>
                                <select name="card_expiry_year" class="form-select" required>
                                    <option value="">Select Year</option>
                                    @php $currentYear = date('Y'); @endphp
                                    @for($i = $currentYear; $i <= $currentYear + 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- CVV -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">CVV</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="card_cvv"
                                           class="form-control"
                                           placeholder="123"
                                           maxlength="3"
                                           required
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <span class="input-group-text bg-white border-start-0">
                                        <i class="fas fa-question-circle" title="3-digit security code on the back of your card"></i>
                                    </span>
                                </div>
                                <div class="form-text">3-digit security code</div>
                            </div>
                        </div>

                        <!-- Payment Amount -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                    <div>
                                        <span class="text-muted">Total Amount</span>
                                    </div>
                                    <div>
                                        <span class="h4 fw-bold text-primary">${{ number_format($booking->total_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Booking
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-lock me-2"></i>Process Payment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="card border-0 mt-4">
                <div class="card-body text-center text-muted">
                    <i class="fas fa-shield-alt me-2 text-success"></i>
                    Your payment information is securely processed. This is a mock payment system for demonstration purposes.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

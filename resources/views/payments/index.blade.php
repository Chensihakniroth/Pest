@extends('layouts.app')

@section('title', 'Payment History - SkyConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Payment History</h2>
                    <p class="text-muted mb-0">View all your payment transactions</p>
                </div>
                <div>
                    <a href="{{ route('my-bookings.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Bookings
                    </a>
                </div>
            </div>

            @if($payments->isEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Payment History</h5>
                        <p class="text-muted">You haven't made any payments yet.</p>
                        <a href="{{ route('flights.index') }}" class="btn btn-primary">Book a Flight</a>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    @foreach($payments as $payment)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="fw-bold mb-1">Payment #{{ $payment->payment_reference }}</h6>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $payment->created_at->format('M d, Y \a\t h:i A') }}
                                            </p>
                                        </div>
                                        <div>
                                            @if($payment->isCompleted())
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> Completed
                                                </span>
                                            @elseif($payment->isPending())
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i> Pending
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle me-1"></i> Failed
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Amount</span>
                                            <span class="fw-bold text-primary">${{ number_format($payment->amount, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Payment Method</span>
                                            <span class="text-dark">{{ ucfirst($payment->payment_method) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Card</span>
                                            <span class="text-dark">**** **** **** {{ substr($payment->card_number, -4) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Card Holder</span>
                                            <span class="text-dark">{{ $payment->card_holder_name }}</span>
                                        </div>
                                    </div>

                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="text-muted small">Flight</span><br>
                                                <span class="fw-bold">{{ $payment->booking->flight->flight_number }}</span>
                                            </div>
                                            <div class="text-end">
                                                <span class="text-muted small">Route</span><br>
                                                <span class="fw-bold">
                                                    {{ $payment->booking->flight->originAirport->city }} →
                                                    {{ $payment->booking->flight->destinationAirport->city }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

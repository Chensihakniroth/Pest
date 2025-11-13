@extends('layouts.app')

@section('content')
@php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
@endphp

<div class="container-fluid px-4 py-4">
    <!-- Slim iPhone-style Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 dark:text-gray-100 fw-bold">Customer Details</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-0 small">Complete customer information and service history</p>
        </div>
        <a href="{{ route('customers.index') }}" class="btn-back-to-list"
           style="display: inline-flex; align-items: center; gap: 0.5rem;
                  background: linear-gradient(135deg, #2d3748, #1a1d2e);
                  color: #ffffff; border: 1.5px solid #e5e7eb; border-radius: 14px;
                  padding: 0.75rem 1.5rem; text-decoration: none; font-weight: 600;
                  font-size: 0.875rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                  backdrop-filter: blur(10px);">
            <i class="fas fa-arrow-left" style="font-size: 0.8rem;"></i>
            <span>Back to List</span>
        </a>
    </div>

    <div class="row g-4">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <!-- Customer Profile Card -->
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                            <i class="fas fa-user-circle me-2 text-green-500"></i>Customer Profile
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            @if($customer->hasContractExpired())
                                <span class="status-badge expired">EXPIRED</span>
                            @else
                                <span class="status-badge {{ $customer->status == 'active' ? 'active' : 'pending' }}">
                                    {{ strtoupper($customer->status) }}
                                </span>
                            @endif
                            <span class="badge bg-blue-500 dark:bg-blue-600 text-white">{{ $customer->customer_id }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                    <i class="fas fa-info-circle me-2 text-green-500"></i>Basic Information
                                </h6>

                                <!-- Customer ID -->
                                <div class="info-item mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Customer ID</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">{{ $customer->customer_id }}</div>
                                </div>

                                <!-- Name -->
                                <div class="info-item mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Full Name</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">{{ $customer->name }}</div>
                                </div>

                                <!-- Phone Number -->
                                <div class="info-item mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Phone Number</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">
                                        <i class="fas fa-phone text-green-500 me-2"></i>{{ $customer->phone_number }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address & Location -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                    <i class="fas fa-map-marker-alt me-2 text-green-500"></i>Location
                                </h6>

                                <!-- Address -->
                                <div class="info-item mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Address</label>
                                    <div class="text-gray-800 dark:text-gray-100">
                                        <i class="fas fa-home text-green-500 me-2"></i>{{ $customer->address }}
                                    </div>
                                </div>

                                <!-- Google Map Link -->
                                @if($customer->google_map_link)
                                <div class="info-item">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Map Location</label>
                                    <div>
                                        <a href="{{ $customer->google_map_link }}" target="_blank"
                                           class="btn-map-link"
                                           style="display: inline-flex; align-items: center; gap: 0.5rem;
                                                  background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                                                  color: white; border: none; border-radius: 12px;
                                                  padding: 0.5rem 1rem; text-decoration: none;
                                                  font-weight: 500; font-size: 0.8rem;
                                                  transition: all 0.3s ease;">
                                            <i class="fas fa-external-link-alt"></i>
                                            <span>View on Maps</span>
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Service Information -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                <i class="fas fa-cogs me-2 text-green-500"></i>Service Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Service Name</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">{{ $customer->service_name }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Service Type</label>
                                    <div>
                                        <span class="service-badge {{ $customer->service_type === 'host_system' ? 'host-system' : 'baiting-system' }}">
                                            {{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Service Price</label>
                                    <div class="fw-bold text-green-600 dark:text-green-400">${{ number_format($customer->service_price, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contract Information -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                <i class="fas fa-file-contract me-2 text-green-500"></i>Contract Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Contract Start</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">
                                        <i class="fas fa-calendar-plus text-green-500 me-2"></i>{{ $customer->contract_start_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Contract End</label>
                                    @php
                                        $daysUntilExpiration = $customer->getDisplayDaysUntilExpiration();
                                        $isExpiringSoon = $customer->isContractExpiring();
                                    @endphp
                                    <div class="fw-bold {{ $isExpiringSoon ? 'text-yellow-600 dark:text-yellow-400' : ($customer->hasContractExpired() ? 'text-red-600 dark:text-red-400' : 'text-gray-800 dark:text-gray-100') }}">
                                        <i class="fas fa-calendar-minus text-green-500 me-2"></i>{{ $customer->contract_end_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Contract Status</label>
                                    <div>
                                        @php
                                            $customer->updateContractStatus();
                                        @endphp

                                        @if($customer->hasContractExpired() || $customer->status === 'expired')
                                            <span class="status-badge expired">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Expired
                                            </span>
                                            <div class="text-red-600 dark:text-red-400 small mt-1 fw-semibold">{{ $customer->getDaysSinceExpiration() }} days ago</div>
                                        @elseif($customer->isContractExpiring())
                                            <span class="status-badge expiring">
                                                <i class="fas fa-clock me-1"></i>Expiring Soon
                                            </span>
                                        @else
                                            @if($customer->status == 'active')
                                                <span class="status-badge active">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                                <div class="text-green-600 dark:text-green-400 small mt-1 fw-semibold">{{ $customer->getDisplayDaysUntilExpiration() }} days left</div>
                                            @else
                                                <span class="status-badge pending">
                                                    <i class="fas fa-pause me-1"></i>Pending
                                                </span>
                                                <div class="text-gray-600 dark:text-gray-400 small mt-1">Contract on hold</div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Contract Alert Banner -->
                            @if($customer->isContractExpiring() && !$customer->hasContractExpired())
                            <div class="alert alert-warning alert-dismissible fade show mt-3 glass-morphism" role="alert"
                                 style="border-radius: 12px; border: 1px solid rgba(245, 158, 11, 0.3);
                                        background: linear-gradient(135deg, rgba(254, 243, 199, 0.8), rgba(253, 230, 138, 0.6));">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-3 text-yellow-600"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="alert-heading mb-1 fw-bold text-yellow-800">Contract Expiring Soon!</h6>
                                        <p class="mb-0 small text-yellow-700">
                                            This contract will expire in <strong>{{ $customer->getDisplayDaysUntilExpiration() }} days</strong>
                                            on <strong>{{ $customer->contract_end_date->format('M d, Y') }}</strong>.
                                        </p>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Comments -->
                    @if($customer->comments)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                <i class="fas fa-comments me-2 text-green-500"></i>Additional Notes
                            </h6>
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                                <p class="mb-0 text-gray-800 dark:text-gray-100 small">{{ $customer->comments }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Maintenance Schedule -->
            @if($customer->status == 'active' && !$customer->hasContractExpired())
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                            <i class="fas fa-calendar-alt me-2 text-green-500"></i>Maintenance Schedule
                        </h5>
                        <button type="button" class="btn-record-maintenance"
                                data-bs-toggle="modal" data-bs-target="#maintenanceModal"
                                style="display: inline-flex; align-items: center; gap: 0.5rem;
                                       background: linear-gradient(135deg, #10b981, #059669);
                                       color: white; border: none; border-radius: 12px;
                                       padding: 0.5rem 1rem; text-decoration: none;
                                       font-weight: 500; font-size: 0.8rem;
                                       transition: all 0.3s ease;">
                            <i class="fas fa-plus"></i>
                            <span>Record</span>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @php
                        $allScheduledDates = $customer->getAllScheduledMaintenanceDates();
                    @endphp

                    @if($allScheduledDates->count() > 0)
                        <div class="maintenance-scroll-container">
                            <div class="list-group list-group-flush">
                                @foreach($allScheduledDates as $schedule)
                                    @php
                                        $isOverdue = $schedule['type'] === 'overdue';
                                        $isUpcoming = $schedule['type'] === 'upcoming';
                                        $isScheduled = $schedule['type'] === 'scheduled';
                                        $daysDiff = $schedule['days'];
                                        $isCompleted = $schedule['completed'];
                                    @endphp
                                    <div class="list-group-item list-group-item-action border-0 py-2 px-3 maintenance-item
                                        {{ $isCompleted ? 'completed' : ($isOverdue ? 'overdue' : ($isUpcoming ? 'upcoming' : '')) }}">

                                        <div class="row align-items-center g-2">
                                            <div class="col-1">
                                                <div class="fw-semibold text-gray-800 dark:text-gray-100 small">#{{ $schedule['maintenance_number'] }}</div>
                                            </div>
                                            <div class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="text-gray-800 dark:text-gray-100 small">{{ $schedule['date']->format('M d, Y') }}</span>
                                                    @if($isCompleted)
                                                        <i class="fas fa-check-circle text-green-500 ms-1" style="font-size: 0.7rem;"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                @if($isCompleted)
                                                    <span class="status-badge-sm active">Done</span>
                                                @elseif($isOverdue)
                                                    <span class="status-badge-sm expired">Overdue</span>
                                                @elseif($isUpcoming)
                                                    <span class="status-badge-sm expiring">Upcoming</span>
                                                @else
                                                    <span class="status-badge-sm pending">Scheduled</span>
                                                @endif
                                            </div>
                                            <div class="col-3">
                                                @if($isCompleted)
                                                    <span class="text-gray-600 dark:text-gray-400 small">Completed</span>
                                                @elseif($isOverdue)
                                                    <span class="text-red-600 dark:text-red-400 fw-semibold small">Overdue {{ abs($daysDiff) }}d</span>
                                                @elseif($isUpcoming)
                                                    <span class="text-blue-600 dark:text-blue-400 fw-semibold small">In {{ $daysDiff }}d</span>
                                                @else
                                                    <span class="text-gray-600 dark:text-gray-400 small">In {{ $daysDiff }}d</span>
                                                @endif
                                            </div>
                                            <div class="col-3 text-end">
                                                @if(!$isCompleted)
                                                    <button type="button" class="btn-mark-done"
                                                            data-date="{{ $schedule['date']->format('Y-m-d') }}"
                                                            style="display: inline-flex; align-items: center; gap: 0.25rem;
                                                                   background: linear-gradient(135deg, #10b981, #059669);
                                                                   color: white; border: none; border-radius: 8px;
                                                                   padding: 0.25rem 0.5rem; font-size: 0.7rem;
                                                                   font-weight: 500; transition: all 0.3s ease;">
                                                        <i class="fas fa-check" style="font-size: 0.6rem;"></i>
                                                        <span>Mark Done</span>
                                                    </button>
                                                @else
                                                    <span class="text-gray-600 dark:text-gray-400 small">Completed</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4 text-gray-600 dark:text-gray-400">
                            <i class="fas fa-calendar-times fa-lg mb-3 opacity-50"></i>
                            <p class="mb-0 fw-semibold small">No maintenance schedule</p>
                            <small class="text-muted">Maintenance dates will be generated based on service type</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Maintenance History -->
            <div class="card glass-morphism border-0 shadow-sm">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <h5 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                        <i class="fas fa-history me-2 text-green-500"></i>Maintenance History
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($maintenanceHistory->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($maintenanceHistory as $history)
                        <div class="list-group-item list-group-item-action border-0 py-3 px-4">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="fw-semibold text-gray-800 dark:text-gray-100 small">{{ $history->maintenance_date->format('M d, Y') }}</div>
                                </div>
                                <div class="col-md-3">
                                    <span class="service-badge small {{ $history->service_type === 'host_system' ? 'host-system' : 'baiting-system' }}">
                                        {{ ucfirst(str_replace('_', ' ', $history->service_type)) }}
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-gray-800 dark:text-gray-100 small">{{ $history->performed_by ?? 'System' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-gray-600 dark:text-gray-400 small">{{ $history->notes ?: 'No notes' }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4 text-gray-600 dark:text-gray-400">
                        <i class="fas fa-clipboard-list fa-lg mb-3 opacity-50"></i>
                        <p class="mb-0 fw-semibold small">No maintenance history</p>
                        <small class="text-muted">Maintenance records will appear here once added</small>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- Inactive Customer Message -->
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <h5 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                        <i class="fas fa-pause me-2 text-green-500"></i>Account On Hold
                    </h5>
                </div>
                <div class="card-body text-center py-4">
                    <i class="fas fa-pause-circle fa-2x text-gray-400 dark:text-gray-500 mb-3"></i>
                    <h6 class="text-gray-600 dark:text-gray-400 fw-semibold mb-2">
                        @if($customer->hasContractExpired())
                            Contract Expired
                        @else
                            Customer Account is Pending
                        @endif
                    </h6>
                    <p class="text-gray-600 dark:text-gray-400 mb-3 small">
                        @if($customer->hasContractExpired())
                            This contract has expired. Maintenance features are disabled until the contract is renewed.
                        @else
                            Maintenance features and contract management are available when the account status is set to Active.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn-edit-customer"
                           style="display: inline-flex; align-items: center; gap: 0.5rem;
                                  background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                                  color: white; border: none; border-radius: 12px;
                                  padding: 0.5rem 1rem; text-decoration: none;
                                  font-weight: 500; font-size: 0.8rem;
                                  transition: all 0.3s ease;">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </a>
                        @if($customer->hasContractExpired())
                            <button type="button" class="btn-renew-contract"
                                    data-bs-toggle="modal" data-bs-target="#renewModal"
                                    style="display: inline-flex; align-items: center; gap: 0.5rem;
                                           background: linear-gradient(135deg, #10b981, #059669);
                                           color: white; border: none; border-radius: 12px;
                                           padding: 0.5rem 1rem; text-decoration: none;
                                           font-weight: 500; font-size: 0.8rem;
                                           transition: all 0.3s ease;">
                                <i class="fas fa-sync-alt"></i>
                                <span>Renew</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Actions & Alerts -->
        <div class="col-lg-4">
            <!-- Contract Alerts Card -->
            @if(($customer->status == 'active' && $customer->isContractExpiring()) || $customer->hasContractExpired())
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <h6 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                        <i class="fas fa-exclamation-triangle me-2 text-yellow-500"></i>Contract Alert
                    </h6>
                </div>
                <div class="card-body p-4">
                    @if($customer->hasContractExpired())
                    <div class="text-center mb-3">
                        <i class="fas fa-calendar-times fa-lg text-red-500 mb-2"></i>
                        <p class="text-red-600 dark:text-red-400 fw-semibold mb-1 small">Contract Expired</p>
                        <p class="text-gray-600 dark:text-gray-400 small">Expired on {{ $customer->contract_end_date->format('M d, Y') }}</p>
                        <p class="text-red-600 dark:text-red-400 small fw-semibold">{{ $customer->getDaysSinceExpiration() }} days ago</p>
                    </div>
                    @elseif($customer->isContractExpiring())
                    <div class="text-center mb-3">
                        <i class="fas fa-clock fa-lg text-yellow-500 mb-2"></i>
                        <p class="text-yellow-600 dark:text-yellow-400 fw-semibold mb-1 small">Contract Expiring Soon</p>
                        <p class="text-gray-600 dark:text-gray-400 small">Expires on {{ $customer->contract_end_date->format('M d, Y') }}</p>
                        <p class="text-yellow-600 dark:text-yellow-400 small fw-semibold">{{ $customer->getDisplayDaysUntilExpiration() }} days remaining</p>
                    </div>
                    @endif

                    <div class="d-grid gap-2">
                        <button type="button" class="btn-renew-contract-full"
                                data-bs-toggle="modal" data-bs-target="#renewModal"
                                style="display: inline-flex; align-items: center; gap: 0.5rem;
                                       background: linear-gradient(135deg, #10b981, #059669);
                                       color: white; border: none; border-radius: 12px;
                                       padding: 0.75rem 1rem; text-decoration: none;
                                       font-weight: 500; font-size: 0.8rem;
                                       transition: all 0.3s ease;">
                            <i class="fas fa-sync-alt me-2"></i>Renew Contract
                        </button>
                        <form action="{{ route('customers.renew', $customer) }}" method="POST" class="d-grid">
                            @csrf
                            <input type="hidden" name="contract_start_date" value="{{ now()->format('Y-m-d') }}">
                            <input type="hidden" name="contract_end_date" value="{{ now()->addYears(5)->format('Y-m-d') }}">
                            <input type="hidden" name="service_type" value="{{ $customer->service_type }}">
                            <input type="hidden" name="service_price" value="{{ $customer->service_price }}">
                            <button type="submit" class="btn-quick-renew"
                                    style="display: inline-flex; align-items: center; gap: 0.5rem;
                                           background: transparent; color: #10b981;
                                           border: 1.5px solid #10b981; border-radius: 12px;
                                           padding: 0.75rem 1rem; text-decoration: none;
                                           font-weight: 500; font-size: 0.8rem;
                                           transition: all 0.3s ease;">
                                <i class="fas fa-bolt me-2"></i>Quick Renew (5 Years)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <h6 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                        <i class="fas fa-bolt me-2 text-green-500"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn-edit-full"
                           style="display: inline-flex; align-items: center; gap: 0.5rem;
                                  background: linear-gradient(135deg, #f59e0b, #d97706);
                                  color: white; border: none; border-radius: 12px;
                                  padding: 0.75rem 1rem; text-decoration: none;
                                  font-weight: 500; font-size: 0.8rem;
                                  transition: all 0.3s ease;">
                            <i class="fas fa-edit me-2"></i>Edit Customer
                        </a>

                        @if($customer->status == 'active' && !$customer->hasContractExpired())
                        <button type="button" class="btn-record-maintenance-full"
                                data-bs-toggle="modal" data-bs-target="#maintenanceModal"
                                style="display: inline-flex; align-items: center; gap: 0.5rem;
                                       background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                                       color: white; border: none; border-radius: 12px;
                                       padding: 0.75rem 1rem; text-decoration: none;
                                       font-weight: 500; font-size: 0.8rem;
                                       transition: all 0.3s ease;">
                            <i class="fas fa-tools me-2"></i>Record Maintenance
                        </button>
                        @else
                        <button type="button" class="btn-disabled" disabled
                                style="display: inline-flex; align-items: center; gap: 0.5rem;
                                       background: #9ca3af; color: white; border: none;
                                       border-radius: 12px; padding: 0.75rem 1rem;
                                       text-decoration: none; font-weight: 500;
                                       font-size: 0.8rem; opacity: 0.5;">
                            <i class="fas fa-tools me-2"></i>Record Maintenance
                        </button>
                        @endif

                        <a href="tel:{{ $customer->phone_number }}" class="btn-call-customer"
                           style="display: inline-flex; align-items: center; gap: 0.5rem;
                                  background: transparent; color: #3b82f6;
                                  border: 1.5px solid #3b82f6; border-radius: 12px;
                                  padding: 0.75rem 1rem; text-decoration: none;
                                  font-weight: 500; font-size: 0.8rem;
                                  transition: all 0.3s ease;">
                            <i class="fas fa-phone me-2"></i>Call Customer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service Summary -->
            @if($customer->status == 'active' && !$customer->hasContractExpired())
            <div class="card glass-morphism border-0 shadow-sm">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <h6 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                        <i class="fas fa-chart-pie me-2 text-green-500"></i>Service Summary
                    </h6>
                </div>
                <div class="card-body p-4">
                    @php
                        $allScheduledDates = $customer->getAllScheduledMaintenanceDates();
                        $completedCount = $allScheduledDates->where('completed', true)->count();
                        $pendingCount = $allScheduledDates->where('completed', false)->count();
                    @endphp
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-gray-600 dark:text-gray-400 small">Service Type</span>
                            <span class="fw-semibold text-gray-800 dark:text-gray-100 small">{{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-gray-600 dark:text-gray-400 small">Maintenance Frequency</span>
                            <span class="fw-semibold text-gray-800 dark:text-gray-100 small">
                                @if($customer->service_type === 'host_system')
                                    6 months
                                @else
                                    3 months
                                @endif
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-gray-600 dark:text-gray-400 small">Total Maintenance</span>
                            <span class="badge bg-blue-500">{{ $allScheduledDates->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-gray-600 dark:text-gray-400 small">Completed</span>
                            <span class="badge bg-green-500">{{ $completedCount }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-gray-600 dark:text-gray-400 small">Pending</span>
                            <span class="badge bg-yellow-500">{{ $pendingCount }}</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    @if($allScheduledDates->count() > 0)
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-gray-600 dark:text-gray-400">Completion</small>
                            <small class="text-gray-600 dark:text-gray-400">{{ round(($completedCount / $allScheduledDates->count()) * 100) }}%</small>
                        </div>
                        <div class="progress" style="height: 4px; background: #e5e7eb;">
                            <div class="progress-bar bg-green-500" style="width: {{ ($completedCount / $allScheduledDates->count()) * 100 }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Maintenance Modal -->
@if($customer->status == 'active' && !$customer->hasContractExpired())
<div class="modal fade" id="maintenanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content glass-morphism border-0">
            <div class="modal-header bg-transparent border-0 py-3 px-4">
                <h5 class="modal-title fw-semibold text-gray-800 dark:text-gray-100">
                    <i class="fas fa-tools me-2 text-green-500"></i>Record Maintenance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.markMaintenance', $customer) }}" method="POST" id="maintenanceForm">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label for="maintenance_date" class="form-label fw-semibold small text-gray-800 dark:text-gray-100">Maintenance Date</label>
                        <input type="date" class="form-control modern-input" id="maintenance_date" name="maintenance_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold small text-gray-800 dark:text-gray-100">Notes</label>
                        <textarea class="form-control modern-input" id="notes" name="notes" rows="3" placeholder="Any notes about this maintenance..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-transparent border-0 py-3 px-4">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal"
                            style="display: inline-flex; align-items: center; gap: 0.5rem;
                                   background: transparent; color: #6b7280;
                                   border: 1.5px solid #6b7280; border-radius: 12px;
                                   padding: 0.5rem 1rem; text-decoration: none;
                                   font-weight: 500; font-size: 0.8rem;
                                   transition: all 0.3s ease;">
                        Cancel
                    </button>
                    <button type="submit" class="btn-save-maintenance"
                            style="display: inline-flex; align-items: center; gap: 0.5rem;
                                   background: linear-gradient(135deg, #10b981, #059669);
                                   color: white; border: none; border-radius: 12px;
                                   padding: 0.5rem 1rem; text-decoration: none;
                                   font-weight: 500; font-size: 0.8rem;
                                   transition: all 0.3s ease;">
                        Save Maintenance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content glass-morphism border-0">
            <div class="modal-header bg-transparent border-0 py-3 px-4">
                <h5 class="modal-title fw-semibold text-gray-800 dark:text-gray-100">
                    <i class="fas fa-sync-alt me-2 text-green-500"></i>Renew Contract
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.renew', $customer) }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <!-- Contract Start Date -->
                    <div class="mb-3">
                        <label for="contract_start_date" class="form-label fw-semibold small text-gray-800 dark:text-gray-100">Contract Start Date</label>
                        <input type="date" class="form-control modern-input" id="contract_start_date" name="contract_start_date" value="{{ now()->format('Y-m-d') }}" required>
                    </div>

                    <!-- Contract End Date -->
                    <div class="mb-3">
                        <label for="contract_end_date" class="form-label fw-semibold small text-gray-800 dark:text-gray-100">Contract End Date</label>
                        <input type="date" class="form-control modern-input" id="contract_end_date" name="contract_end_date" value="{{ now()->addYears(5)->format('Y-m-d') }}" required>
                    </div>

                    <!-- Service Type -->
                    <div class="mb-3">
                        <label for="service_type" class="form-label fw-semibold small text-gray-800 dark:text-gray-100">Service Type</label>
                        <select class="form-control modern-select" id="service_type" name="service_type" required>
                            <option value="baiting_system_complete" {{ $customer->service_type == 'baiting_system_complete' ? 'selected' : '' }}>Baiting System Complete</option>
                            <option value="baiting_system_not_complete" {{ $customer->service_type == 'baiting_system_not_complete' ? 'selected' : '' }}>Baiting System Not Complete</option>
                            <option value="host_system" {{ $customer->service_type == 'host_system' ? 'selected' : '' }}>Host System</option>
                            <option value="drill_injection" {{ $customer->service_type == 'drill_injection' ? 'selected' : '' }}>Drill and Injection</option>
                        </select>
                    </div>

                    <!-- Service Price -->
                    <div class="mb-3">
                        <label for="service_price" class="form-label fw-semibold small text-gray-800 dark:text-gray-100">Service Price</label>
                        <input type="number" step="0.01" class="form-control modern-input" id="service_price" name="service_price" value="{{ $customer->service_price }}" required>
                    </div>
                </div>
                <div class="modal-footer bg-transparent border-0 py-3 px-4">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal"
                            style="display: inline-flex; align-items: center; gap: 0.5rem;
                                   background: transparent; color: #6b7280;
                                   border: 1.5px solid #6b7280; border-radius: 12px;
                                   padding: 0.5rem 1rem; text-decoration: none;
                                   font-weight: 500; font-size: 0.8rem;
                                   transition: all 0.3s ease;">
                        Cancel
                    </button>
                    <button type="submit" class="btn-renew-modal"
                            style="display: inline-flex; align-items: center; gap: 0.5rem;
                                   background: linear-gradient(135deg, #10b981, #059669);
                                   color: white; border: none; border-radius: 12px;
                                   padding: 0.5rem 1rem; text-decoration: none;
                                   font-weight: 500; font-size: 0.8rem;
                                   transition: all 0.3s ease;">
                        Renew Contract
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* iPhone-style Slim Design */
.glass-morphism {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
}

.dark .glass-morphism {
    background: rgba(30, 30, 30, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Button Hover Effects */
.btn-back-to-list:hover,
.btn-record-maintenance:hover,
.btn-edit-customer:hover,
.btn-renew-contract:hover,
.btn-renew-contract-full:hover,
.btn-edit-full:hover,
.btn-record-maintenance-full:hover,
.btn-save-maintenance:hover,
.btn-renew-modal:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-map-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

.btn-quick-renew:hover,
.btn-call-customer:hover {
    background: rgba(16, 185, 129, 0.1) !important;
    transform: translateY(-2px);
}

.btn-cancel:hover {
    background: #6b7280 !important;
    color: white !important;
    transform: translateY(-2px);
}

/* Status Badges */
.status-badge {
    padding: 0.3rem 0.6rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.7rem;
    display: inline-block;
}

.status-badge.active {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.status-badge.pending {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.status-badge.expired {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.status-badge.expiring {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

/* Service Badges */
.service-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.7rem;
    display: inline-block;
}

.service-badge.baiting-system {
    background: linear-gradient(135deg, #8b5cf6, #ec4899);
    color: white;
}

.service-badge.host-system {
    background: linear-gradient(135deg, #10b981, #0ea5e9);
    color: white;
}

/* Modern Inputs */
.modern-input {
    border-radius: 10px;
    border: 1.5px solid #e5e7eb;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    background: white;
}

.modern-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.1);
}

.dark .modern-input {
    background: #374151;
    border-color: #4b5563;
    color: #f9fafb;
}

.dark .modern-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.2);
}

.modern-select {
    border-radius: 10px;
    border: 1.5px solid #e5e7eb;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.modern-select:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.1);
}

/* Fixed Maintenance Schedule Styles */
.maintenance-scroll-container {
    max-height: 400px;
    overflow-y: auto;
    overflow-x: hidden;
    position: relative;
}

.maintenance-scroll-container {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 transparent;
}

.maintenance-scroll-container::-webkit-scrollbar {
    width: 8px;
}

.maintenance-scroll-container::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 4px;
    margin: 2px;
}

.maintenance-scroll-container::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 4px;
    border: 2px solid transparent;
    background-clip: padding-box;
}

.maintenance-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
    border: 2px solid transparent;
    background-clip: padding-box;
}

.maintenance-scroll-container::-webkit-scrollbar-thumb:active {
    background: #718096;
}

/* Fix hover conflicts */
.maintenance-scroll-container .maintenance-item {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f8f9fa !important;
    padding: 0.5rem 0.75rem !important;
    margin: 0;
}

.maintenance-scroll-container .maintenance-item:hover {
    background: rgba(16, 185, 129, 0.04) !important;
    border-left: 2px solid #10b981 !important;
}

/* Remove transform on hover to prevent scrollbar jump */
.maintenance-scroll-container .maintenance-item:hover {
    transform: none !important;
}

/* Status indicators */
.maintenance-item.completed {
    border-left: 2px solid #10b981;
}

.maintenance-item.overdue {
    border-left: 2px solid #ef4444;
}

.maintenance-item.upcoming {
    border-left: 2px solid #f59e0b;
}

/* Smaller status badges */
.status-badge-sm {
    padding: 0.2rem 0.4rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.65rem;
    display: inline-block;
}

.status-badge-sm.active {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.status-badge-sm.pending {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.status-badge-sm.expired {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.status-badge-sm.expiring {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

/* Mark Done Button */
.btn-mark-done:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* Info Items */
.info-item {
    padding: 0.5rem 0;
}

/* Dark Mode Support */
.dark .glass-morphism {
    background: rgba(30, 30, 30, 0.95);
}

.dark .bg-gray-50 {
    background-color: #374151 !important;
}

.dark .border-gray-200 {
    border-color: #4b5563 !important;
}

.dark .maintenance-scroll-container {
    scrollbar-color: #4a5568 transparent;
}

.dark .maintenance-scroll-container::-webkit-scrollbar-track {
    background: transparent;
}

.dark .maintenance-scroll-container::-webkit-scrollbar-thumb {
    background: #4a5568;
}

.dark .maintenance-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #718096;
}

.dark .maintenance-item {
    border-bottom-color: #374151 !important;
}

.dark .maintenance-item:hover {
    background: rgba(16, 185, 129, 0.05) !important;
}

/* Prevent content shift */
.maintenance-scroll-container .list-group-flush {
    margin: 0;
    padding: 0;
}

/* Smooth scrolling */
.maintenance-scroll-container {
    scroll-behavior: smooth;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .card-body {
        padding: 1rem !important;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}

/* Smooth Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: slideIn 0.3s ease forwards;
}

/* Stagger animation */
.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.15s; }
.card:nth-child(3) { animation-delay: 0.2s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus on notes field when maintenance modal opens
    const maintenanceModal = document.getElementById('maintenanceModal');
    if (maintenanceModal) {
        maintenanceModal.addEventListener('shown.bs.modal', function () {
            const notesField = document.getElementById('notes');
            if (notesField) notesField.focus();
        });
    }

    // Auto-focus on service price when renew modal opens
    const renewModal = document.getElementById('renewModal');
    if (renewModal) {
        renewModal.addEventListener('shown.bs.modal', function () {
            const servicePriceField = document.getElementById('service_price');
            if (servicePriceField) servicePriceField.focus();
        });
    }

    // Handle "Mark as Done" button clicks
    const markDoneButtons = document.querySelectorAll('.btn-mark-done');
    markDoneButtons.forEach(button => {
        button.addEventListener('click', function() {
            const maintenanceDate = this.getAttribute('data-date');
            document.getElementById('maintenance_date').value = maintenanceDate;

            const maintenanceModal = new bootstrap.Modal(document.getElementById('maintenanceModal'));
            maintenanceModal.show();
        });
    });

    // Handle form submission for maintenance
    const maintenanceForm = document.getElementById('maintenanceForm');
    if (maintenanceForm) {
        maintenanceForm.addEventListener('submit', function(e) {
            console.log('Submitting maintenance form with date:', document.getElementById('maintenance_date').value);
        });
    }
});
</script>
@endsection

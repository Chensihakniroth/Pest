@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Modern Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="dashboard-title">Dashboard</h1>
                <p class="dashboard-subtitle">Welcome to GreenHome Pest Control Management</p>
            </div>
            <div class="header-actions">
                <div class="refresh-indicator">
                    <i class="fas fa-sync-alt"></i>
                    <span>Auto-updates every 60s</span>
                </div>
                <div class="current-time" id="currentTime">
                    {{ now()->format('g:i A') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Grid with Full Color Gradients -->
<div class="stats-grid">
    <!-- Total Customers -->
    <div class="stat-card gradient-primary">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value" data-stat="total-customers">{{ $totalCustomers ?? 0 }}</div>
            <div class="stat-label">Total Customers</div>
            <div class="stat-description">
                <i class="fas fa-users me-1"></i>All registered clients
            </div>
        </div>
        <div class="stat-glow"></div>
    </div>

    <!-- Active Customers -->
    <div class="stat-card gradient-success">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value" data-stat="active-customers">{{ $activeCustomers ?? 0 }}</div>
            <div class="stat-label">Active Customers</div>
            <div class="stat-description">
                <i class="fas fa-check-circle me-1"></i>Current contracts
            </div>
        </div>
        <div class="stat-glow"></div>
    </div>

    <!-- Expiring Contracts -->
    <div class="stat-card gradient-warning">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value" data-stat="expiring-contracts">{{ $expiringContracts ?? 0 }}</div>
            <div class="stat-label">Expiring Contracts</div>
            <div class="stat-description">
                <i class="fas fa-clock me-1"></i>Within 90 days
            </div>
        </div>
        <div class="stat-glow"></div>
    </div>

    <!-- Maintenance Due -->
    <div class="stat-card gradient-info">
        <div class="stat-icon">
            <i class="fas fa-tools"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value" data-stat="maintenance-alerts">{{ $maintenanceAlertsCount ?? 0 }}</div>
            <div class="stat-label">Maintenance Due</div>
            <div class="stat-description">
                <i class="fas fa-tools me-1"></i>Requires attention
            </div>
        </div>
        <div class="stat-glow"></div>
    </div>
</div>

    <!-- Alerts Section -->
    <div class="alerts-grid">
        <!-- Maintenance Alerts -->
        <div class="alert-card">
            <div class="alert-header">
                <div class="alert-title">
                    <i class="fas fa-tools"></i>
                    <span>Maintenance Alerts</span>
                </div>
                <div class="alert-badge warning">{{ $maintenanceAlertsCount ?? 0 }}</div>
            </div>
            <div class="alert-content">
                @if(($maintenanceAlertsCount ?? 0) > 0)
                    @foreach($maintenanceAlerts ?? [] as $maintenanceAlert)
                        @php
                            $customer = $maintenanceAlert['customer'] ?? null;
                            $alert = $maintenanceAlert['alert'] ?? null;

                            if ($customer && $alert) {
                                $days = $alert['days'] ?? 0;
                                $alertDate = $alert['date'] ?? null;

                                if ($days < 0) {
                                    $displayText = 'Overdue by ' . abs($days) . ' days';
                                    $badgeClass = 'danger';
                                } elseif ($days == 0) {
                                    $displayText = 'Due today';
                                    $badgeClass = 'warning';
                                } else {
                                    $displayText = 'Due in ' . $days . ' days';
                                    $badgeClass = 'info';
                                }
                            } else {
                                continue;
                            }
                        @endphp

                        <div class="alert-item">
                            <div class="alert-item-main">
                                <div class="customer-avatar">
                                    {{ strtoupper(substr($customer->name ?? '', 0, 1)) }}
                                </div>
                                <div class="alert-details">
                                    <div class="customer-name">{{ $customer->name ?? 'Unknown' }}</div>
                                    <div class="customer-meta">
                                        <span class="service-type {{ $customer->service_type ?? '' }}">
                                            {{ ($customer->service_type ?? '') === 'host_system' ? 'Host' : 'Baiting' }}
                                        </span>
                                        <span class="alert-date">
                                            <i class="fas fa-calendar"></i>
                                            {{ $alertDate ? $alertDate->format('M d, Y') : 'Unknown' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="alert-item-actions">
                                <span class="alert-badge {{ $badgeClass }}">{{ $displayText }}</span>
                                @if($customer)
                                <a href="{{ route('customers.show', $customer) }}" class="action-btn view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <div class="empty-text">
                            <div class="empty-title">No maintenance alerts</div>
                            <div class="empty-description">All maintenance is up to date</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Contract Alerts -->
        <div class="alert-card">
            <div class="alert-header">
                <div class="alert-title">
                    <i class="fas fa-calendar-times"></i>
                    <span>Contract Expiration Alerts</span>
                </div>
                <div class="alert-badge danger">{{ $contractAlertsCount ?? 0 }}</div>
            </div>
            <div class="alert-content">
                @if(($contractAlertsCount ?? 0) > 0)
                    @foreach($contractAlerts ?? [] as $customer)
                    @php
                        $daysLeft = $customer->getDisplayDaysUntilExpiration() ?? 0;
                        $badgeClass = $daysLeft <= 7 ? 'danger' : ($daysLeft <= 30 ? 'warning' : 'secondary');
                    @endphp
                    <div class="alert-item">
                        <div class="alert-item-main">
                            <div class="customer-avatar">
                                {{ strtoupper(substr($customer->name ?? '', 0, 1)) }}
                            </div>
                            <div class="alert-details">
                                <div class="customer-name">{{ $customer->name ?? 'Unknown' }}</div>
                                <div class="customer-meta">
                                    <span class="service-type {{ $customer->service_type ?? '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $customer->service_type ?? '')) }}
                                    </span>
                                    <span class="alert-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        Expires: {{ $customer->contract_end_date->format('M d, Y') ?? 'Unknown' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="alert-item-actions">
                            <span class="alert-badge {{ $badgeClass }}">{{ $daysLeft }} days left</span>
                            <div class="action-group">
                                <a href="{{ route('customers.show', $customer) }}" class="action-btn view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('customers.edit', $customer) }}" class="action-btn edit">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <div class="empty-text">
                            <div class="empty-title">No contract alerts</div>
                            <div class="empty-description">All contracts are current</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Expired Contracts Section -->
    @if(isset($expiredContracts) && ($expiredContractsCount ?? 0) > 0)
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-ban"></i>
                <span>Expired Contracts</span>
            </div>
            <div class="section-badge danger">{{ $expiredContractsCount ?? 0 }}</div>
        </div>
        <div class="section-content">
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Service Type</th>
                            <th>Contract End Date</th>
                            <th>Days Expired</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expiredContracts ?? [] as $customer)
                        @php
                            $daysExpired = $customer->getDaysSinceExpiration() ?? 0;
                        @endphp
                        <tr>
                            <td>
                                <div class="customer-cell">
                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($customer->name ?? '', 0, 1)) }}
                                    </div>
                                    <div class="customer-info">
                                        <div class="customer-name">{{ $customer->name ?? 'Unknown' }}</div>
                                        <div class="customer-id">{{ $customer->customer_id ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="service-badge {{ $customer->service_type ?? '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $customer->service_type ?? '')) }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $customer->contract_end_date->format('M d, Y') ?? 'Unknown' }}</td>
                            <td>
                                <span class="status-badge expired">{{ $daysExpired }} days</span>
                            </td>
                            <td class="text-end">
                                <div class="action-group">
                                    <a href="{{ route('customers.show', $customer) }}" class="action-btn view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="action-btn edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-bolt"></i>
                <span>Quick Actions</span>
            </div>
        </div>
        <div class="section-content">
            <div class="actions-grid">
                <a href="{{ route('customers.create') }}" class="action-card primary">
                    <div class="action-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">Add New Customer</div>
                        <div class="action-description">Create new client</div>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>

                <a href="{{ route('customers.index') }}?status=active&sort=contract_end_date&order=asc" class="action-card success">
                    <div class="action-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">Active Customers</div>
                        <div class="action-description">Sorted by expiry date</div>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>

                <a href="{{ route('customers.index') }}?status=expired&sort=contract_end_date&order=desc" class="action-card danger">
                    <div class="action-icon">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">Expired Contracts</div>
                        <div class="action-description">Most recent first</div>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>

                <a href="{{ route('customers.index') }}?sort=name&order=asc" class="action-card info">
                    <div class="action-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="action-content">
                        <div class="action-title">All Customers</div>
                        <div class="action-description">A-Z sorted</div>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Modern Header */
.dashboard-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: between;
    align-items: flex-end;
    gap: 2rem;
}

.header-text {
    flex: 1;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gh-text);
    margin: 0 0 0.5rem 0;
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.dashboard-subtitle {
    color: var(--gh-text-light);
    margin: 0;
    font-size: 1rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.refresh-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--gh-surface);
    border: 1px solid var(--gh-border);
    border-radius: 12px;
    font-size: 0.875rem;
    color: var(--gh-text-light);
}

.current-time {
    padding: 0.5rem 1rem;
    background: var(--gh-primary);
    color: white;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--gh-surface);
    border: 1px solid var(--gh-border);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(135deg, currentColor, transparent);
}

.stat-card.primary::before { background: linear-gradient(135deg, #10b981, #34d399); }
.stat-card.success::before { background: linear-gradient(135deg, #059669, #10b981); }
.stat-card.warning::before { background: linear-gradient(135deg, #d97706, #f59e0b); }
.stat-card.info::before { background: linear-gradient(135deg, #0e7490, #06b6d4); }

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--gh-shadow-lg);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-card.primary .stat-icon { background: linear-gradient(135deg, #10b981, #34d399); }
.stat-card.success .stat-icon { background: linear-gradient(135deg, #059669, #10b981); }
.stat-card.warning .stat-icon { background: linear-gradient(135deg, #d97706, #f59e0b); }
.stat-card.info .stat-icon { background: linear-gradient(135deg, #0e7490, #06b6d4); }

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gh-text);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gh-text);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.stat-description {
    font-size: 0.75rem;
    color: var(--gh-text-light);
}

.stat-trend {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.stat-trend.positive { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.stat-trend.negative { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
.stat-trend.stable { background: rgba(156, 163, 175, 0.1); color: #9ca3af; }

/* Alerts Grid */
.alerts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1024px) {
    .alerts-grid {
        grid-template-columns: 1fr;
    }
}

.alert-card, .section-card {
    background: var(--gh-surface);
    border: 1px solid var(--gh-border);
    border-radius: 16px;
    overflow: hidden;
}

.alert-header, .section-header {
    padding: 1.25rem 1.5rem;
    background: var(--gh-background);
    border-bottom: 1px solid var(--gh-border);
    display: flex;
    justify-content: between;
    align-items: center;
}

.alert-title, .section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: var(--gh-text);
}

.alert-badge, .section-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.alert-badge.warning, .section-badge.warning { background: #fef3c7; color: #d97706; }
.alert-badge.danger, .section-badge.danger { background: #fee2e2; color: #dc2626; }
.alert-badge.info { background: #dbeafe; color: #2563eb; }
.alert-badge.secondary { background: #f3f4f6; color: #6b7280; }

.alert-content, .section-content {
    max-height: 400px;
    overflow-y: auto;
}

.alert-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gh-border);
    display: flex;
    justify-content: between;
    align-items: center;
    gap: 1rem;
    transition: background-color 0.2s ease;
}

.alert-item:hover {
    background: var(--gh-background);
}

.alert-item:last-child {
    border-bottom: none;
}

.alert-item-main {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
}

.customer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.alert-details {
    flex: 1;
}

.customer-name {
    font-weight: 600;
    color: var(--gh-text);
    margin-bottom: 0.25rem;
}

.customer-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.service-type {
    padding: 0.2rem 0.5rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.service-type.host_system { background: #dbeafe; color: #2563eb; }
.service-type.baiting_system { background: #f3e8ff; color: #7c3aed; }

.alert-date {
    font-size: 0.75rem;
    color: var(--gh-text-light);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.alert-item-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.action-group {
    display: flex;
    gap: 0.25rem;
}

.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid var(--gh-border);
    background: var(--gh-surface);
    color: var(--gh-text-light);
}

.action-btn.view:hover { background: #3b82f6; color: white; border-color: #3b82f6; }
.action-btn.edit:hover { background: #10b981; color: white; border-color: #10b981; }

/* Empty State */
.empty-state {
    padding: 3rem 2rem;
    text-align: center;
    color: var(--gh-text-light);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #10b981;
}

.empty-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--gh-text);
}

.empty-description {
    font-size: 0.875rem;
}

/* Modern Table */
.table-container {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gh-text-light);
    border-bottom: 1px solid var(--gh-border);
    background: var(--gh-background);
}

.modern-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gh-border);
}

.modern-table tr:last-child td {
    border-bottom: none;
}

.modern-table tr:hover {
    background: var(--gh-background);
}

.customer-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.customer-info {
    display: flex;
    flex-direction: column;
}

.customer-id {
    font-size: 0.75rem;
    color: var(--gh-text-light);
}

.service-badge {
    padding: 0.3rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.service-badge.host_system { background: #dbeafe; color: #2563eb; }
.service-badge.baiting_system { background: #f3e8ff; color: #7c3aed; }

.status-badge {
    padding: 0.3rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.expired { background: #fee2e2; color: #dc2626; }

/* Quick Actions */
.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.action-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--gh-surface);
    border: 1px solid var(--gh-border);
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
}

.action-card.primary::before { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
.action-card.success::before { background: linear-gradient(135deg, #10b981, #34d399); }
.action-card.danger::before { background: linear-gradient(135deg, #ef4444, #f87171); }
.action-card.info::before { background: linear-gradient(135deg, #06b6d4, #22d3ee); }

.action-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--gh-shadow-lg);
}

.action-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    flex-shrink: 0;
}

.action-card.primary .action-icon { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
.action-card.success .action-icon { background: linear-gradient(135deg, #10b981, #34d399); }
.action-card.danger .action-icon { background: linear-gradient(135deg, #ef4444, #f87171); }
.action-card.info .action-icon { background: linear-gradient(135deg, #06b6d4, #22d3ee); }

.action-content {
    flex: 1;
}

.action-title {
    font-weight: 600;
    color: var(--gh-text);
    margin-bottom: 0.25rem;
}

.action-description {
    font-size: 0.875rem;
    color: var(--gh-text-light);
}

.action-arrow {
    color: var(--gh-text-light);
    transition: transform 0.2s ease;
}

.action-card:hover .action-arrow {
    transform: translateX(4px);
    color: var(--gh-primary);
}

/* Scrollbar Styling */
.alert-content::-webkit-scrollbar,
.section-content::-webkit-scrollbar {
    width: 4px;
}

.alert-content::-webkit-scrollbar-track,
.section-content::-webkit-scrollbar-track {
    background: var(--gh-background);
}

.alert-content::-webkit-scrollbar-thumb,
.section-content::-webkit-scrollbar-thumb {
    background: var(--gh-border);
    border-radius: 2px;
}

.alert-content::-webkit-scrollbar-thumb:hover,
.section-content::-webkit-scrollbar-thumb:hover {
    background: var(--gh-text-light);
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 0 0.5rem;
    }

    .header-content {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .dashboard-title {
        font-size: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .stat-card {
        padding: 1rem;
    }

    .stat-value {
        font-size: 1.5rem;
    }

    .alerts-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .alert-item {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }

    .alert-item-actions {
        justify-content: between;
    }

    .actions-grid {
        grid-template-columns: 1fr;
    }

    .modern-table {
        font-size: 0.875rem;
    }

    .modern-table th,
    .modern-table td {
        padding: 0.75rem 1rem;
    }
}

/* Animation for stats update */
@keyframes pulseUpdate {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.stat-value.updating {
    animation: pulseUpdate 0.6s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update current time
    function updateCurrentTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        document.getElementById('currentTime').textContent = timeString;
    }

    // Update time immediately and every minute
    updateCurrentTime();
    setInterval(updateCurrentTime, 60000);

    // Auto-refresh dashboard every 60 seconds
    let refreshTimer = setInterval(refreshDashboardStats, 60000);

    // AJAX stats refresh function
    function refreshDashboardStats() {
        if (window.location.pathname === '/dashboard' || window.location.pathname === '/') {
            fetch('/dashboard/stats')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    updateDashboardStats(data);
                })
                .catch(error => {
                    console.log('Auto-refresh failed:', error);
                });
        }
    }

    // Update stats on the page
    function updateDashboardStats(stats) {
        const elements = {
            'total-customers': stats.totalCustomers,
            'active-customers': stats.activeCustomers,
            'expiring-contracts': stats.expiringContracts,
            'maintenance-alerts': stats.maintenanceAlertsCount
        };

        Object.entries(elements).forEach(([key, value]) => {
            const element = document.querySelector(`[data-stat="${key}"]`);
            if (element && element.textContent != value) {
                element.textContent = value;
                element.classList.add('updating');
                setTimeout(() => element.classList.remove('updating'), 600);
            }
        });

        // Update refresh indicator
        const refreshIndicator = document.querySelector('.refresh-indicator');
        if (refreshIndicator) {
            const now = new Date();
            refreshIndicator.innerHTML = `<i class="fas fa-sync-alt"></i><span>Updated: ${now.toLocaleTimeString()}</span>`;
        }
    }

    // Add smooth interactions
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
            setTimeout(() => {
                this.style.transform = 'translateY(-4px)';
            }, 150);
        });
    });

    // Initialize any charts or additional components here
    console.log('GreenHome Dashboard initialized');
});
</script>
@endsection

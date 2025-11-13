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

    <!-- Full Color Statistics Grid -->
    <div class="stats-grid compact">
        <!-- Total Customers -->
        <div class="stat-card full-color-primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" data-stat="total-customers">{{ $totalCustomers ?? 0 }}</div>
                <div class="stat-label">Total Customers</div>
            </div>
            <div class="stat-trend">
                <i class="fas fa-arrow-up"></i>
                <span>+12%</span>
            </div>
        </div>

        <!-- Active Customers -->
        <div class="stat-card full-color-success">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" data-stat="active-customers">{{ $activeCustomers ?? 0 }}</div>
                <div class="stat-label">Active Customers</div>
            </div>
            <div class="stat-trend">
                <i class="fas fa-arrow-up"></i>
                <span>+8%</span>
            </div>
        </div>

        <!-- Expiring Contracts -->
        <div class="stat-card full-color-warning">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" data-stat="expiring-contracts">{{ $expiringContracts ?? 0 }}</div>
                <div class="stat-label">Expiring Contracts</div>
            </div>
            <div class="stat-trend">
                <i class="fas fa-exclamation"></i>
                <span>Attention</span>
            </div>
        </div>

        <!-- Maintenance Due -->
        <div class="stat-card full-color-info">
            <div class="stat-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" data-stat="maintenance-alerts">{{ $maintenanceAlertsCount ?? 0 }}</div>
                <div class="stat-label">Maintenance Due</div>
            </div>
            <div class="stat-trend">
                <i class="fas fa-bell"></i>
                <span>Action</span>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="alerts-grid">
        <!-- Maintenance Alerts -->
        <div class="alert-card glass-morphism">
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
                                    $iconClass = 'fas fa-exclamation-triangle';
                                } elseif ($days == 0) {
                                    $displayText = 'Due today';
                                    $badgeClass = 'warning';
                                    $iconClass = 'fas fa-clock';
                                } else {
                                    $displayText = 'Due in ' . $days . ' days';
                                    $badgeClass = 'info';
                                    $iconClass = 'fas fa-calendar-check';
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
                                <span class="alert-badge {{ $badgeClass }}">
                                    <i class="{{ $iconClass }} me-1"></i>
                                    {{ $displayText }}
                                </span>
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
        <div class="alert-card glass-morphism">
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
                        $badgeClass = $daysLeft <= 7 ? 'danger' : ($daysLeft <= 30 ? 'warning' : 'info');
                        $iconClass = $daysLeft <= 7 ? 'fas fa-exclamation-triangle' :
                                    ($daysLeft <= 30 ? 'fas fa-clock' : 'fas fa-calendar-alt');
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
                            <span class="alert-badge {{ $badgeClass }}">
                                <i class="{{ $iconClass }} me-1"></i>
                                {{ $daysLeft }} days left
                            </span>
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
    <div class="section-card glass-morphism">
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
                                    <a href="{{ route('customers.renew', $customer) }}" class="action-btn renew">
                                        <i class="fas fa-sync-alt"></i>
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
    <div class="section-card glass-morphism">
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
                        <div class="action-description">Create new client profile</div>
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

        <!-- Recent Activity - SELF-CONTAINED REAL DATA -->
    <div class="section-card glass-morphism">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-history"></i>
                <span>Recent Activity</span>
            </div>
        </div>
        <div class="section-content">
            <div class="activity-list">
                @php
                    use App\Models\Customer;
                    use App\Models\MaintenanceHistory;

                    $activities = [];

                    // Get recent customer creations
                    $recentCustomers = Customer::latest()->take(3)->get();
                    foreach ($recentCustomers as $customer) {
                        $activities[] = [
                            'icon' => 'fas fa-user-plus',
                            'color' => 'success',
                            'text' => 'New customer "'.$customer->name.'" added',
                            'time' => $customer->created_at->diffForHumans(),
                            'link' => route('customers.show', $customer)
                        ];
                    }

                    // Get recent maintenance
                    $recentMaintenance = MaintenanceHistory::with('customer')
                        ->latest()
                        ->take(3)
                        ->get();
                    foreach ($recentMaintenance as $maintenance) {
                        $activities[] = [
                            'icon' => 'fas fa-tools',
                            'color' => 'info',
                            'text' => 'Maintenance completed for "'.$maintenance->customer->name.'"',
                            'time' => $maintenance->maintenance_date->diffForHumans(),
                            'link' => route('customers.show', $maintenance->customer)
                        ];
                    }

                    // Sort by time (newest first) and take top 5
                    usort($activities, function($a, $b) {
                        return strtotime($b['time']) - strtotime($a['time']);
                    });
                    $activities = array_slice($activities, 0, 5);
                @endphp

                @if(count($activities) > 0)
                    @foreach($activities as $activity)
                    <div class="activity-item" onclick="window.location='{{ $activity['link'] }}'" style="cursor: pointer;">
                        <div class="activity-icon {{ $activity['color'] }}">
                            <i class="{{ $activity['icon'] }}"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">{{ $activity['text'] }}</div>
                            <div class="activity-time">{{ $activity['time'] }}</div>
                        </div>
                        <div class="activity-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-history fa-2x mb-3"></i>
                        <div class="empty-text">
                            <div class="empty-title">No recent activity</div>
                            <div class="empty-description">Activity will appear here as you use the system</div>
                        </div>
                    </div>
                @endif
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
    justify-content: space-between;
    align-items: flex-end;
    gap: 2rem;
}

.header-text {
    flex: 1;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 800;
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
    background: var(--gh-glass);
    border: 1px solid var(--gh-glass-border);
    border-radius: 12px;
    font-size: 0.875rem;
    color: var(--gh-text-light);
    backdrop-filter: blur(10px);
}

.current-time {
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    color: white;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* Enhanced Statistics Grid */
.stats-grid.compact {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--gh-glass);
    backdrop-filter: blur(10px);
    border: 1px solid var(--gh-glass-border);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, var(--card-color-1), var(--card-color-2));
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

/* Gradient Variations */
.stat-card.gradient-primary::before { background: linear-gradient(135deg, #10b981, #059669); }
.stat-card.gradient-success::before { background: linear-gradient(135deg, #059669, #047857); }
.stat-card.gradient-warning::before { background: linear-gradient(135deg, #d97706, #b45309); }
.stat-card.gradient-info::before { background: linear-gradient(135deg, #0e7490, #0c6b85); }

/* Stat Icon */
.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    flex-shrink: 0;
    color: white;
}

.stat-card.gradient-primary .stat-icon { background: rgba(16, 185, 129, 0.2); }
.stat-card.gradient-success .stat-icon { background: rgba(5, 150, 105, 0.2); }
.stat-card.gradient-warning .stat-icon { background: rgba(217, 119, 6, 0.2); }
.stat-card.gradient-info .stat-icon { background: rgba(14, 116, 144, 0.2); }

/* Stat Content */
.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.25rem;
    color: var(--gh-text);
}

.stat-label {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gh-text-light);
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--gh-text-light);
}

/* Full Color Stat Cards */
.stat-card.full-color-primary {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: white;
}

.stat-card.full-color-success {
    background: linear-gradient(135deg, #059669, #047857) !important;
    color: white;
}

.stat-card.full-color-warning {
    background: linear-gradient(135deg, #d97706, #b45309) !important;
    color: white;
}

.stat-card.full-color-info {
    background: linear-gradient(135deg, #0e7490, #0c6b85) !important;
    color: white;
}

/* Remove the top line for full color cards */
.stat-card.full-color-primary::before,
.stat-card.full-color-success::before,
.stat-card.full-color-warning::before,
.stat-card.full-color-info::before {
    display: none;
}

/* Update text colors for full color cards */
.stat-card.full-color-primary .stat-value,
.stat-card.full-color-success .stat-value,
.stat-card.full-color-warning .stat-value,
.stat-card.full-color-info .stat-value {
    color: white !important;
}

.stat-card.full-color-primary .stat-label,
.stat-card.full-color-success .stat-label,
.stat-card.full-color-warning .stat-label,
.stat-card.full-color-info .stat-label {
    color: rgba(255, 255, 255, 0.9) !important;
}

.stat-card.full-color-primary .stat-trend,
.stat-card.full-color-success .stat-trend,
.stat-card.full-color-warning .stat-trend,
.stat-card.full-color-info .stat-trend {
    color: rgba(255, 255, 255, 0.9) !important;
}

/* Update icon backgrounds for full color cards */
.stat-card.full-color-primary .stat-icon,
.stat-card.full-color-success .stat-icon,
.stat-card.full-color-warning .stat-icon,
.stat-card.full-color-info .stat-icon {
    background: rgba(255, 255, 255, 0.2) !important;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

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

.alert-card {
    border-radius: 16px;
    overflow: hidden;
}

.alert-header {
    padding: 1.25rem 1.5rem;
    background: var(--gh-glass);
    border-bottom: 1px solid var(--gh-glass-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.alert-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gh-text);
}

.alert-title i {
    font-size: 1rem;
    color: var(--gh-primary);
}

.alert-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.alert-badge.warning { background: #fef3c7; color: #d97706; }
.alert-badge.danger { background: #fee2e2; color: #dc2626; }
.alert-badge.info { background: #dbeafe; color: #2563eb; }

.alert-content {
    max-height: 400px;
    overflow-y: auto;
    background: var(--gh-glass);
}

.alert-item {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gh-glass-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    transition: background-color 0.2s ease;
}

.alert-item:hover {
    background: rgba(16, 185, 129, 0.05);
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
    background: var(--gh-glass);
    color: var(--gh-text-light);
}

.action-btn.view:hover { background: #3b82f6; color: white; border-color: #3b82f6; }
.action-btn.edit:hover { background: #10b981; color: white; border-color: #10b981; }
.action-btn.renew:hover { background: #f59e0b; color: white; border-color: #f59e0b; }

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
    opacity: 0.5;
}

.empty-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--gh-text);
}

.empty-description {
    font-size: 0.875rem;
    opacity: 0.7;
}

/* Section Cards */
.section-card {
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.section-header {
    padding: 1.25rem 1.5rem;
    background: var(--gh-glass);
    border-bottom: 1px solid var(--gh-glass-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gh-text);
}

.section-title i {
    font-size: 1rem;
    color: var(--gh-primary);
}

.section-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.section-badge.danger { background: #fee2e2; color: #dc2626; }

.section-content {
    background: var(--gh-glass);
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
    border-bottom: 1px solid var(--gh-glass-border);
    background: var(--gh-glass);
}

.modern-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gh-glass-border);
}

.modern-table tr:last-child td {
    border-bottom: none;
}

.modern-table tr:hover {
    background: rgba(16, 185, 129, 0.05);
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
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
}

.action-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    background: var(--gh-glass);
    border: 1px solid var(--gh-glass-border);
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

.action-card.primary::before { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.action-card.success::before { background: linear-gradient(135deg, #10b981, #059669); }
.action-card.danger::before { background: linear-gradient(135deg, #ef4444, #dc2626); }
.action-card.info::before { background: linear-gradient(135deg, #06b6d4, #0e7490); }

.action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.action-card.primary .action-icon { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.action-card.success .action-icon { background: linear-gradient(135deg, #10b981, #059669); }
.action-card.danger .action-icon { background: linear-gradient(135deg, #ef4444, #dc2626); }
.action-card.info .action-icon { background: linear-gradient(135deg, #06b6d4, #0e7490); }

.action-content {
    flex: 1;
}

.action-title {
    font-weight: 600;
    color: var(--gh-text);
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.action-description {
    font-size: 0.875rem;
    color: var(--gh-text-light);
    line-height: 1.4;
}

.action-arrow {
    color: var(--gh-text-light);
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.action-card:hover .action-arrow {
    color: var(--gh-primary);
    transform: translateX(4px);
}

/* Recent Activity */
.activity-list {
    padding: 1rem 0;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gh-glass-border);
    transition: background-color 0.2s ease;
}

.activity-item:hover {
    background: rgba(16, 185, 129, 0.05);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
}

.activity-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
.activity-icon.info { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.activity-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
.activity-icon.danger { background: linear-gradient(135deg, #ef4444, #dc2626); }

.activity-content {
    flex: 1;
}

.activity-text {
    font-weight: 500;
    color: var(--gh-text);
    margin-bottom: 0.25rem;
}

.activity-time {
    font-size: 0.875rem;
    color: var(--gh-text-light);
}

/* Glass morphism */
.glass-morphism {
    background: var(--gh-glass);
    backdrop-filter: blur(10px);
    border: 1px solid var(--gh-glass-border);
}

/* Dark mode support */
.dark .glass-morphism {
    background: rgba(30, 30, 30, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.dark .stat-card,
.dark .alert-card,
.dark .section-card,
.dark .action-card {
    background: rgba(30, 30, 30, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.dark .alert-item:hover,
.dark .activity-item:hover,
.dark .modern-table tr:hover {
    background: rgba(16, 185, 129, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 0 0.5rem;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .header-actions {
        width: 100%;
        justify-content: space-between;
    }

    .stats-grid.compact {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .stat-card {
        padding: 1.25rem;
    }

    .actions-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
        padding: 1rem;
    }

    .action-card {
        padding: 1.25rem;
    }

    .alert-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .alert-item-actions {
        width: 100%;
        justify-content: space-between;
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

/* Loading animation */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.refresh-indicator.loading i {
    animation: spin 1s linear infinite;
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
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }

    // Update time immediately and every minute
    updateCurrentTime();
    setInterval(updateCurrentTime, 60000);

    // Auto-refresh dashboard every 60 seconds
    let refreshInterval = setInterval(refreshDashboardStats, 60000);

    // Enhanced stat card interactions
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // AJAX stats refresh function
    function refreshDashboardStats() {
        if (window.location.pathname === '/dashboard' || window.location.pathname === '/') {
            // Show loading state
            const refreshIndicator = document.querySelector('.refresh-indicator');
            if (refreshIndicator) {
                refreshIndicator.classList.add('loading');
            }

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
                })
                .finally(() => {
                    if (refreshIndicator) {
                        refreshIndicator.classList.remove('loading');
                    }
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
                // Flash animation
                const card = element.closest('.stat-card');
                if (card) {
                    card.style.animation = 'none';
                    setTimeout(() => {
                        card.style.animation = 'pulseUpdate 0.6s ease';
                    }, 10);
                }

                // Update value
                element.textContent = value;
                element.classList.add('updating');
                setTimeout(() => element.classList.remove('updating'), 600);
            }
        });

        // Update refresh indicator
        const refreshIndicator = document.querySelector('.refresh-indicator');
        if (refreshIndicator) {
            const now = new Date();
            const timeSpan = refreshIndicator.querySelector('span');
            if (timeSpan) {
                timeSpan.textContent = `Updated: ${now.toLocaleTimeString()}`;
            }
        }
    }

    // Add hover effects to action cards
    document.querySelectorAll('.action-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            const arrow = this.querySelector('.action-arrow');
            if (arrow) {
                arrow.style.transform = 'translateX(4px)';
                arrow.style.color = 'var(--gh-primary)';
            }
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            const arrow = this.querySelector('.action-arrow');
            if (arrow) {
                arrow.style.transform = 'translateX(0)';
                arrow.style.color = 'var(--gh-text-light)';
            }
        });
    });

    // Add click effects to alert items
    document.querySelectorAll('.alert-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (!e.target.closest('.action-btn')) {
                const viewLink = this.querySelector('.action-btn.view');
                if (viewLink) {
                    window.location.href = viewLink.href;
                }
            }
        });
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K for search focus
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            window.location.href = "{{ route('customers.index') }}";
        }

        // Number keys for quick actions
        if (e.key >= '1' && e.key <= '4' && !e.ctrlKey && !e.metaKey) {
            e.preventDefault();
            const actionCards = document.querySelectorAll('.action-card');
            const index = parseInt(e.key) - 1;
            if (actionCards[index]) {
                actionCards[index].click();
            }
        }
    });

    // Initialize any charts or additional components here
    console.log('GreenHome Dashboard initialized');

    // Add smooth scroll to alerts container
    const alertContainers = document.querySelectorAll('.alert-content');
    alertContainers.forEach(container => {
        if (container.scrollHeight > container.clientHeight) {
            container.style.scrollBehavior = 'smooth';
        }
    });
});
</script>
@endsection

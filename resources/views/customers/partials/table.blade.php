<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Service Type</th>
                <th>Contract Start</th>
                <th>Contract End</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr>
                <td><strong>{{ $customer->customer_id }}</strong></td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone_number }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}</td>
                <td>{{ $customer->contract_start_date->format('M d, Y') }}</td>
                <td class="{{ $customer->isContractExpiring() ? 'text-danger fw-bold' : '' }}">
                    {{ $customer->contract_end_date->format('M d, Y') }}
                </td>
                <td>
                    <span class="badge bg-{{ $customer->status == 'active' ? 'success' : ($customer->status == 'expired' ? 'danger' : 'warning') }}">
                        {{ ucfirst($customer->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    <i class="fas fa-search fa-2x mb-2"></i>
                    <p>No customers found matching your search.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="pagination-wrapper">
    @if($customers->total() > 0)
    <span class="pagination-info">
        Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} results
    </span>
    @else
    <span class="pagination-info">No results found</span>
    @endif
    
    @if($customers->hasPages())
    <nav>
        <ul class="pagination mb-0">
            {{-- Previous Button --}}
            @if ($customers->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">‹</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $customers->previousPageUrl() }}" rel="prev">‹</a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach(range(1, $customers->lastPage()) as $page)
                @if($page == $customers->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $customers->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Button --}}
            @if ($customers->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $customers->nextPageUrl() }}" rel="next">›</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">›</span>
                </li>
            @endif
        </ul>
    </nav>
    @endif
</div>
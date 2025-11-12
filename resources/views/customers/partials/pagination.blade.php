@if($customers->hasPages())
<div class="card-footer bg-transparent py-3 px-4 border-top">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing {{ $customers->firstItem() }}-{{ $customers->lastItem() }} of {{ $customers->total() }} customers
        </div>
        <div class="pagination-container">
            <nav aria-label="Customer pagination">
                <ul class="pagination pagination-sm mb-0">
                    {{-- Previous Page Link --}}
                    @if ($customers->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link" style="border-radius: 10px; margin: 0 2px;">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $customers->previousPageUrl() }}"
                               style="border-radius: 10px; margin: 0 2px; border: 1px solid var(--gh-border);">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                        @if ($page == $customers->currentPage())
                            <li class="page-item active">
                                <span class="page-link"
                                      style="border-radius: 10px; margin: 0 2px;
                                             background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
                                             border: none;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}"
                                   style="border-radius: 10px; margin: 0 2px; border: 1px solid var(--gh-border);">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($customers->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $customers->nextPageUrl() }}"
                               style="border-radius: 10px; margin: 0 2px; border: 1px solid var(--gh-border);">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link" style="border-radius: 10px; margin: 0 2px;">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
@endif

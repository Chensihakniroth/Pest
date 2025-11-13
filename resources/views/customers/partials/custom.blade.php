@if ($paginator->hasPages())
    <ul class="pagination mb-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link" style="border-radius: 10px; margin: 0 2px;">
                    <i class="fas fa-chevron-left"></i>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                   style="border-radius: 10px; margin: 0 2px; border: 1px solid var(--gh-border);">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link" style="border-radius: 10px; margin: 0 2px;">{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
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
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}"
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
@endif

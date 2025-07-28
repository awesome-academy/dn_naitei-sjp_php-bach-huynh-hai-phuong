@if (isset($paginator) && $paginator instanceof \Illuminate\Pagination\LengthAwarePaginator)
    @php
        $surroundingPages = getSurroundingPages($paginator->lastPage(), $paginator->currentPage());
    @endphp

    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="pagination" data-slot="pagination" class="mx-auto flex w-full justify-center">
            <ul data-slot="pagination-content" class="flex flex-row items-center gap-1">
                @if ($paginator->currentPage() > 1)
                    <li data-slot="pagination-item">
                        <x-ui.button tag="a" aria-label="Go to previous page" data-slot="pagination-link"
                            variant="ghost" size="default" class="gap-1 px-2.5 sm:pl-2.5"
                            href="{{ $paginator->previousPageUrl() }}">
                            <x-fas-chevron-left class="size-4" />
                            <span class="hidden sm:block">{{ __('pagination.previous') }}</span>
                        </x-ui.button>
                    </li>
                @endif

                @foreach ($surroundingPages as $page)
                    @if ($page !== 0)
                        @php
                            $isActive = $page === $paginator->currentPage();
                        @endphp
                        <li data-slot="pagination-item">
                            <x-ui.button tag="a" aria-current="{{ $isActive ? 'page' : 'undefined' }}"
                                data-slot="pagination-link" data-active="{{ $isActive ? 'true' : 'false' }}"
                                variant="{{ $isActive ? 'outline' : 'ghost' }}" size="icon"
                                href="{{ $isActive ? '#' : $paginator->url($page) }}">
                                {{ $page }}
                            </x-ui.button>
                        </li>
                    @else
                        <span aria-hidden data-slot="pagination-ellipsis" class="flex size-9 items-center justify-center">
                            <x-fas-ellipsis class="size-4" />
                            <span class="sr-only">{{ __('pagination.more_pages') }}</span>
                        </span>
                    @endif
                @endforeach

                @if ($paginator->currentPage() < $paginator->lastPage())
                    <li data-slot="pagination-item">
                        <x-ui.button tag="a" aria-label="Go to next page" data-slot="pagination-link" variant="ghost"
                            size="default" class="gap-1 px-2.5 sm:pl-2.5" href="{{ $paginator->nextPageUrl() }}">
                            <span class="hidden sm:block">{{ __('pagination.next') }}</span>
                            <x-fas-chevron-right class="size-4" />
                        </x-ui.button>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
@endif

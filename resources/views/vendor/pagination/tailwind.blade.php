@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-gray-400 bg-gray-200 cursor-default rounded-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-primary text-black rounded-md">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-primary text-black rounded-md">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="px-4 py-2 text-gray-400 bg-gray-200 cursor-default rounded-md">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-end">
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    {{-- Link Pagination --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-4 py-2 text-gray-400 bg-gray-200 cursor-default rounded-md">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="px-4 py-2 bg-fourth text-black rounded-md">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 bg-primary text-black rounded-md">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </span>
            </div>
        </div>
    </nav>
@endif
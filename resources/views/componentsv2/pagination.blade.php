@if ($paginator->hasPages())
    <nav>
        <ul class="flex pl-0 list-none rounded my-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 border-r-0 ml-0 rounded-l" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link">Anterior</span>
                </li>
            @else
                <li class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 border-r-0 ml-0 rounded-l hover:bg-gray-200">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Anterior</a>
                </li>
            @endif
            
            
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-white border-r-0 bg-blue-700"><span>{{ $page }}</span></li>
                        @else
                            <li class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 border-r-0 hover:bg-gray-200"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 rounded-r hover:bg-gray-200">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Siguiente</a>
                </li>
            @else
                <li class="disabled relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 rounded-r" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">Siguiente</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

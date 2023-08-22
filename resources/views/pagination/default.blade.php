@if ($paginator->hasPages())
    <div class="center-vertical justify-content-between">
        <p class="mb-0 d-none d-sm-block"> {{ $paginator->total() }} elementos</p>
        <div class="cs-pagination">
        {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <button class="pagination-arrow disabled"><i class="icon-arrow-left"></i></button>
                    <!-- <li class="disabled"><i class="icon-arrow-left"></i></li> -->
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-arrow"><i class="icon-arrow-left"></i></a>
                 <!-- <li><a class="pagination-arrow" rel="prev"><i class="icon-arrow-left"></i></a></li> -->
                @endif
            <ul class="pages-list">



                {{-- Pagination Elements --}}
                
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled">{{ $element }}</li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active">{{ $page }}</li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach


            </ul>
            {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a class="pagination-arrow" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="icon-arrow-right"></i></a>
                @else
                    <!-- <li class="disabled"><i class="icon-arrow-right"></i></li> -->
                    <button class="pagination-arrow disabled"><i class="icon-arrow-right"></i></button>
                @endif
        </div>
    </div>
@endif

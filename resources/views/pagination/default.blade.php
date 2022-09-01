<div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
    <div class="dataTables_info">Mostrando de {{ $filtro->firstItem() }} até {{ $filtro->lastItem() }} de {{ $filtro->total() }} registros</div>
</div>
@if ($filtro->hasPages())
<div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
    <div class="dataTables_paginate paging_simple_numbers" id="kt_table_paginate">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($filtro->onFirstPage())
                <li class="paginate_button page-item previous disabled">
                    <a href="#" class="page-link"><i class="previous"></i></a>
                </li>
            @else
                <li class="paginate_button page-item previous">
                    <a href="{{ $filtro->previousPageUrl() }}" class="page-link"><i class="previous"></i></a>
                </li>
            @endif
            @foreach( $filtro->numeros() as $pagina )
                @if ($pagina == $filtro->pagina)
                    <li class="paginate_button page-item active" class="page-link">
                        <a href="#" class="page-link">{{ $pagina }}</a>
                    </li>
                @else
                    <li class="paginate_button page-item">
                        <a href="{{ $filtro->urlPage( $pagina ) }}" class="page-link">{{ $pagina }}</a>
                    </li>
                @endif
            @endforeach

            @if( $filtro->paginas > $filtro->pagina)
                <li class="paginate_button page-item next">
                    <a href="{{ $filtro->nextPageUrl() }}" class="page-link"><i class="next"></i></a>
                </li>
            @else
                <li class="paginate_button page-item active next disabled">
                    <a href="#" class="page-link"><i class="next"></i>
                </li>
            @endif
        </ul>
    </div>
</div>
@endif

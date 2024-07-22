<div class="{{ $grid->wrapperClass }}">
    @if ($grid->showPaginationSummary())
        <div class="{{ $grid->paginationSummaryClass }}">
            Showing {{ ($grid->getPaginator()->currentpage() - 1 ) * $grid->getPaginator()->perpage() + 1 }}
                @if ($grid->getPaginator()->currentpage() * $grid->getPaginator()->perpage() < $grid->getPaginator()->total())
                    to {{ $grid->getPaginator()->currentpage() * $grid->getPaginator()->perpage() }}
                @else
                    to {{ $grid->getPaginator()->total() }}
                @endif
            of {{ $grid->getPaginator()->total() }} items.
        </div>
    @endif
    <table class="{{ $grid->getTableClass() }}">
        <thead>
            <tr>
                @if($grid->showSerialNumbers)
                    <th class="{{ $grid->serialNumberHeadCss }}">{{ $grid->serialNoText }}</th>
                @endif

                
                @foreach ($grid->getTableHeaders() as $attribute => $label)
                    <th class="{{ $grid->contentHeadCssClass }}">
                        @if ($grid->isSortable($attribute))
                            <a href="{{ route( request()->route()->getName(), array_merge(request()->route()->parameters, ['sort' => $attribute, 'orderby' => $grid->getOrderBy()]) ) }}">
                                {{ $label }}
                            </a>
                        @else
                            <a href="#">
                                {{ $label }}
                            </a>
                        @endif
                    </th>
                @endforeach

                <th class="action-column">&nbsp;</th>
            </tr>

            @if ($grid->hasFilters())
            <tr class="filters">
                <form id="grid-filter" action="{{ route(request()->route()->getName(), request()->route()->parameters) }}" method="GET"></form>
                @foreach ($grid->getTableFilters() as $filter)
                    @if (empty($filter))
                        <td>&nbsp;</td>
                    @elseif ($filter['type'] == 'text')
                        <td>
                            <input type="text" id="{{ $filter['field'] }}" class="form-control" name="{{ $filter['field'] }}" form="grid-filter" value="{{ $filter['value'] }}">
                        </td>
                    @elseif ($filter['type'] == 'select')
                        <td>
                            <select class="form-control" name="{{ $filter['field'] }}" id="{{ $filter['field'] }}" form="grid-filter">
                                <option value=''>All</option>
                                @foreach ($filter['options'] as $key => $value)
                                    <option {{ $filter['value'] == $key ? "Selected" : "" }} value="{{ $key }}"> {{ $value }} </option>
                                @endforeach
                            </select>
                        </td>
                    @endif
                @endforeach
                <td>
                    @if ($grid->showResetButton)
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-outline-primary grid-filter-button" title="filter data" form="grid-filter">Filter&nbsp;<i class="fa fa-filter"></i>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route(request()->route()->getName()) }}" style="color:red" class="btn btn-link">Reset</a>
                        </div>
                    </div>
                    @else
                    <button type="submit" class="btn btn-outline-primary grid-filter-button" title="filter data" form="grid-filter">Filter&nbsp;<i class="fa fa-filter"></i>
                    </button>
                    @endif
                    
                </td>
            </tr>
            @endif
            
        </thead>
        <tbody>
            {!! $grid->getTableBody() !!}
        </tbody>
    </table>
    <div class="col-md-12">
        {!! $grid->renderPaginationLinks() !!}
    </div>
</div>
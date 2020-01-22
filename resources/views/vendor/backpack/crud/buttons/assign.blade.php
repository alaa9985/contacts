@if ($crud->hasAccess('update'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/assign') }} " class="btn btn-sm btn-link"><i class="fa fa-user-plus"></i> Assigner</a>
@endif

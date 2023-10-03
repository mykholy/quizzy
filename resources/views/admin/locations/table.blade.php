@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<div class="card-body px-4">
    {!! $dataTable->table(['width' => '100%', 'class' => 'table border-top-0 table-bordered text-nowrap border-bottom dataTable no-footer ']) !!}
</div>

@push('third_party_scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush

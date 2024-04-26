@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

<div class="card-body px-4">
    <div class="table-responsive">
        {!! $dataTable->table([
        'width' => '100%',
        'class' => 'table border-top-0 table-bordered text-nowrap border-bottom dataTable no-footer',
        'ajax' => route('admin.coupons.index',['is_active'=>request('is_active'),'start_date'=>request('start_date')]), // Assuming you have a route named 'admin.coupons.datatables'

    ]) !!}
    </div>
</div>

@push('third_party_scripts')
    @include('layouts.datatables_js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'is_active': '{{request('is_active')}}',
                'start_date': '{{request('start_date')}}',
                'end_date': '{{request('end_date')}}',
            }
        });
    </script>
    {!! $dataTable->scripts() !!}
@endpush

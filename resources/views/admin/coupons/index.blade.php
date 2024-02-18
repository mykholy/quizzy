@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/coupons.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/coupons.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{ __('lang.list') }}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('models/coupons.plural')}}</h3>

                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.coupons.create') }}">
                        {!! __('lang.add_new') !!}
                    </a>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#BulkModal">
                        {!! __('lang.bulk') !!}
                    </button>


                </div>
            </div>
            <div class="card-body">
                @include('admin.coupons.table')
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="BulkModal" tabindex="-1" role="dialog" aria-labelledby=BulkModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route' => 'admin.coupons.store','files'=>true]) !!}
                <input type="hidden" name="bulk" value="1">
                <div class="modal-header">
                    <h5 class="modal-title" id="BulkModalLabel">{{ __('models/coupons.bulk')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Count Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('count', __('models/coupons.fields.count').':') !!}
                        {!! Form::number('count', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Value Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('value', __('models/coupons.fields.value').':') !!}
                        {!! Form::number('value', null, ['class' => 'form-control']) !!}
                    </div>



                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    @include('includes.notify.success')
    @include('includes.notify.errors')
    @include('includes.notify.delete')
@endpush

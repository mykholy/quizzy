@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/locations.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/locations.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('models/locations.list')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('models/locations.plural')</h3>

                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.locations.create') }}">
                        @lang('lang.add_new')
                    </a>
                    <a class="btn btn-primary float-right mx-2"
                       href="{{ route('admin.locations.import') }}">
                        @lang('lang.import')
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('admin.locations.table')
            </div>
        </div>
    </div>

@endsection
@push('page_scripts')
    @include('includes.notify.success')
    @include('includes.notify.errors')
    @include('includes.notify.delete')
@endpush

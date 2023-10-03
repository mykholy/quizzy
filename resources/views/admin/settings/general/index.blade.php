@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/settings.singular')}}</h4>
            <ol class="breadcrumb">
{{--                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/settings.singular')}}</a></li>--}}
                <li class="breadcrumb-item active" aria-current="page">{{ __('models/settings.singular')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>
        @include('adminlte-templates::common.errors')

        <div class="card">
            {!! Form::open(['route' => 'admin.settings.updateSettings','files'=>true]) !!}
            <div class="card-body">

                <div class="row">
                    @include('admin.settings.general.general')
                </div>

            </div>
            {!! Form::close() !!}

        </div>
    </div>

@endsection
@push('page_scripts')
    @include('includes.notify.success')
    @include('includes.notify.errors')
    @include('includes.notify.delete')
@endpush



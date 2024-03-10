@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/notifications.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{ __('models/notifications.singular')}}</li>
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
            {!! Form::open(['route' => 'admin.notifications.send','files'=>true]) !!}
            <div class="card-body">

                <div class="row">
                    @include('admin.notifications.general')
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



@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/teachers.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/teachers.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('lang.detail')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')


    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('models/teachers.plural') @lang('lang.detail')</h3>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.teachers.index') }}">
                        @lang('lang.back')
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @include('admin.teachers.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection

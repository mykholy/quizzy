@extends('layouts.app_teacher')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/groups.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/groups.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('lang.detail')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')


    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('models/groups.plural') @lang('lang.detail')</h3>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('teacher.groups.index') }}">
                        @lang('lang.back')
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @include('teacher.groups.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/subjects.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/subjects.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('lang.detail')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')


    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('models/subjects.plural') @lang('lang.detail')</h3>
                <div class="d-flex justify-content-between">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.subjects.index') }}">
                        @lang('lang.back')
                    </a>
                    <a class="btn btn-primary float-left"
                       href="{{ route('admin.units.index',['subject_id'=>$subject->id]) }}">
                        @lang('models/units.plural')
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @include('admin.subjects.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection

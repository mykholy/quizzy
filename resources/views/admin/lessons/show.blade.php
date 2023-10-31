@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/lessons.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">@lang('models/lessons.singular')</a></li>
                <li class="breadcrumb-item active" aria-current="page"> @lang('lang.detail')</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('models/lessons.plural') @lang('lang.detail')</h3>

                <div class="d-flex justify-content-between">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.lessons.index',['unit_id'=>request('unit_id')]) }}">
                        @lang('lang.back')
                    </a>
                    <a class="btn btn-primary float-left"
                       href="{{ route('admin.questions.index',['lesson_id'=>$lesson->id]) }}">
                        @lang('models/questions.plural')
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @include('admin.lessons.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection

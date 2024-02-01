@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
                            <h4 class="page-title">{{ __('models/ads.singular')}}</h4>
                        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('models/ads.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> @lang('lang.detail')</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('models/ads.plural')}} {{ __('lang.detail')}}</h3>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.ads.index') }}">
                        Back
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @include('admin.ads.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection

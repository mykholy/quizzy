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




                </div>
            </div>
            <div class="card-body">
                @include('admin.coupons.table')
                @if(isset($codes))

                    <textarea name="my_textarea" rows="15">{{ implode("\n", $codes) }}</textarea>

                @endif
            </div>
        </div>
    </div>


    <!-- Modal -->
@endsection
@push('page_scripts')
    @include('includes.notify.success')
    @include('includes.notify.errors')
    @include('includes.notify.delete')
@endpush

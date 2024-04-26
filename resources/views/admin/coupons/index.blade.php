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
                @if(isset($codes))
                    <textarea name="my_textarea"
                              rows="15">{{ implode("\n", $codes) }}</textarea>

                @else
                    <form action="{{ route('admin.coupons.index') }}" method="GET" id="coupon-filter">
                        <div class="card-header row gutters-5">
                            <div class="col-lg-2 ml-auto">
                                <select class="form-control " name="is_active" id="is_active">
                                    <option value="">{{trans('Filter by Status')}}</option>
                                    <option value="0"
                                            @if(request('is_active') == 0) selected @endif >{{trans('lang.not_active')}}</option>
                                    <option value="1"
                                            @if(request('is_active') == 1) selected @endif >{{trans('lang.active')}}</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-0">
                                    <input type="date" class="aiz-date-range form-control" value="{{ request('start_date') }}"
                                           name="start_date"
                                           placeholder="{{ trans('Start date') }}" >
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mb-0">
                                    <input type="date" class="aiz-date-range form-control" value="{{ request('end_date') }}"
                                           name="end_date"
                                           placeholder="{{ trans('End date') }}" >
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">{{ trans('Filter') }}</button>
                                </div>
                            </div>

                        </div>
                    </form>

                    @include('admin.coupons.table')

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

@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
                            <h4 class="page-title">{{ __('models/coupons.singular')}}</h4>
                        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">{{ __('models/coupons.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('lang.edit')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')


    <div class="col-lg-12">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($coupon, ['route' => ['admin.coupons.update', $coupon->id], 'method' => 'patch','files'=>true]) !!}
            {!! Form::hidden('id',$coupon->id) !!}
            <div class="card-body">
                <div class="row">
                    @include('admin.coupons.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-default"> @lang('lang.cancel') </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

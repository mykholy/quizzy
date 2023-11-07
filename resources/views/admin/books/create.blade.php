@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/books.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.books.index') }}">{{ __('models/books.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{__('lang.create')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')

    <div class="col-lg-12">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'admin.books.store','files'=>true]) !!}

            <div class="card-body">

                <div class="row">
                    @include('admin.books.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.books.index',['subject_id'=>request('subject_id')]) }}"
                   class="btn btn-default"> @lang('lang.cancel') </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

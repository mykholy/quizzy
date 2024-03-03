@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">{{ __('models/questions.singular')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="{{ route('admin.questions.index',['lesson_id'=>request('lesson_id')]) }}">{{ __('models/questions.singular')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{__('lang.create')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')

    <div class="col-lg-12">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'admin.questions.bulkImport','files'=>true]) !!}

            <div class="card-body">

                <div class="row">
                    <!-- file Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('bulk_file', __('models/questions.fields.file').':') !!}
                        <div class="mb-3">
                            {!! Form::file('bulk_file', ['class' => 'form-control','accept' => '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel']) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.questions.index',['lesson_id'=>request('lesson_id')]) }}" class="btn btn-default"> @lang('lang.cancel') </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

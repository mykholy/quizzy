@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
                            <h4 class="page-title">{{ __('models/subjects.singular')}}</h4>
                        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">{{ __('models/subjects.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('lang.edit')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')


    <div class="col-lg-12">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($subject, ['route' => ['admin.subjects.update', $subject->id], 'method' => 'patch','files'=>true]) !!}
            {!! Form::hidden('id',$subject->id) !!}
            <div class="card-body">
                <div class="row">
                    @include('admin.subjects.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.subjects.index') }}" class="btn btn-default"> @lang('lang.cancel') </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

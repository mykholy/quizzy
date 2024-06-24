@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
                            <h4 class="page-title">{{ __('models/answers.singular')}}</h4>
                        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('teacher.answers.index',['question_id'=>$answer->question_id]) }}">{{ __('models/answers.singular')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('lang.edit')}}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')


    <div class="col-lg-12">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($answer, ['route' => ['teacher.answers.update', [$answer->id,'question_id'=>$answer->question_id]], 'method' => 'patch','files'=>true]) !!}
            {!! Form::hidden('id',$answer->id) !!}
            <div class="card-body">
                <div class="row">
                    @include('teacher.answers.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('teacher.answers.index',['question_id'=>$answer->question_id]) }}" class="btn btn-default"> @lang('lang.cancel') </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@extends('layouts.app')
@section('breadcrumb')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
                            <h4 class="page-title">{{ __('models/answers.singular')}}</h4>
                        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">models/&lt;?php echo $config-&gt;modelNames-&gt;camelPlural; ?&gt;.singular</a></li>
                <li class="breadcrumb-item active" aria-current="page"> @lang('lang.detail')</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">models/&lt;?php echo $config-&gt;modelNames-&gt;camelPlural; ?&gt;.plural Detail</h3>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.answers.index') }}">
                        Back
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @include('admin.answers.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection

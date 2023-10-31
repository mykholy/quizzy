@extends('layouts.app')

@section('content')


    <div class="container-fluid">
        <h1 class="text-black-50">You are logged in!</h1>
        <div class="row row-sm">
            @foreach($cards as $card)
                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                    <div class="card overflow-hidden sales-card bg-{{$card['color']}}-gradient">
                        <div class="px-3 pt-3  pb-2 pt-0">
                            <div class="">
                                <h6 class="mb-3 tx-12 text-white">{{$card['title']}}</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <div class="">
                                        <h4 class="tx-20 fw-bold mb-1 text-white">{{$card['count']}}</h4>
{{--                                        <p class="mb-0 tx-12 text-white op-7">Compared to last week</p>--}}
                                    </div>
{{--                                    <span class="float-end my-auto ms-auto">--}}
{{--												<i class="fas fa-arrow-circle-up text-white"></i>--}}
{{--												<span class="text-white op-7"> +427</span>--}}
{{--											</span>--}}
                                </div>
                            </div>
                        </div>
{{--                        <span id="compositeline" class="pt-1"><canvas width="254" height="30" style="display: inline-block; width: 254px; height: 30px; vertical-align: top;"></canvas></span>--}}
                    </div>
                </div>
            @endforeach


        </div>

    </div>

@endsection

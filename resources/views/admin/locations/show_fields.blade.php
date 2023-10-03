<!-- Set up your HTML -->
@if($location->photos)
<div class="owl-carousel owl-theme">
    @foreach(json_decode($location->photos) as $photo)
    <img class="owl-lazy" width="300px" height="400px" data-src="{{asset($photo)}}" alt="">
    @endforeach
</div>
@endif
<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', __('models/locations.fields.name').':') !!}
    <p>{{ $location->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', __('models/locations.fields.description').':') !!}
    <p>{{ $location->description }}</p>
</div>


<!-- Latitude Field -->
<div class="col-sm-12">
    {!! Form::label('latitude', __('models/locations.fields.latitude').':') !!}
    <p>{{ $location->latitude }}</p>
</div>

<!-- Longitude Field -->
<div class="col-sm-12">
    {!! Form::label('longitude', __('models/locations.fields.longitude').':') !!}
    <p>{{ $location->longitude }}</p>
</div>




<!-- Score Field -->
<div class="col-sm-12">
    {!! Form::label('score', __('models/locations.fields.score').':') !!}
    <p>{{ $location->score }}</p>
</div>

<!-- Cost Field -->
<div class="col-sm-12">
    {!! Form::label('cost', __('models/locations.fields.cost').':') !!}

    <p>
        <span
            class="badge badge-{{$location->cost?'success':'danger'}}">{{__('lang.'.($location->cost?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Cost Description Field -->
<div class="col-sm-12">
    {!! Form::label('cost_description', __('models/locations.fields.cost_description').':') !!}
    <p>{{ $location->cost_description }}</p>
</div>

<!-- Access Field -->
<div class="col-sm-12">
    {!! Form::label('access', __('models/locations.fields.access').':') !!}
    <p>{{ $location->access }}</p>
</div>

<!-- Icon Field -->
<div class="col-sm-12">
    {!! Form::label('icon', __('models/locations.fields.icon').':') !!}

    <p><img src="{{ $location->photo }}" width="200px" height="200px" onerror="this.style.display='none';this.src=''"/>
    </p>

</div>

<!-- Icon Type Field -->
{{--<div class="col-sm-12">--}}
{{--    {!! Form::label('icon_type', __('models/locations.fields.icon_type').':') !!}--}}
{{--    <p>{{ $location->icon_type }}</p>--}}
{{--</div>--}}

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', __('models/locations.fields.phone').':') !!}
    <p>{{ $location->phone }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('address', __('models/locations.fields.address').':') !!}
    <p>{{ $location->address }}</p>
</div>

<!-- Pwps Version Field -->
{{--<div class="col-sm-12">--}}
{{--    {!! Form::label('pwps_version', __('models/locations.fields.pwps_version').':') !!}--}}
{{--    <p>{{ $location->pwps_version }}</p>--}}
{{--</div>--}}

<!-- Qr Enabled Field -->
<div class="col-sm-12">
    {!! Form::label('qr_enabled', __('models/locations.fields.qr_enabled').':') !!}

    <p>
        <span
            class="badge badge-{{$location->qr_enabled?'success':'danger'}}">{{__('lang.'.($location->qr_enabled?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Poi Name Field -->
{{--<div class="col-sm-12">--}}
{{--    {!! Form::label('poi_name', __('models/locations.fields.poi_name').':') !!}--}}
{{--    <p>{{ $location->poi_name }}</p>--}}
{{--</div>--}}

<!-- Parking Type Name Field -->
<div class="col-sm-12">
    {!! Form::label('parking_type_name', __('models/locations.fields.parking_type_name').':') !!}
    <p>{{ $location->parking_type_name }}</p>
</div>

<!-- Locale Field -->
<div class="col-sm-12">
    {!! Form::label('locale', __('models/locations.fields.locale').':') !!}
    <p>{{ $location->locale }}</p>
</div>

<!-- Opening Date Field -->
<div class="col-sm-12">
    {!! Form::label('opening_date', __('models/locations.fields.opening_date').':') !!}
    <p>{{ $location->opening_date }}</p>
</div>

<!-- Hours Field -->
<div class="col-sm-12">
    {!! Form::label('hours', __('models/locations.fields.hours').':') !!}
    <p>{{ $location->hours }}</p>
</div>

<!-- amenities Field -->
<div class="col-sm-12">
    {!! Form::label('amenities', __('models/locations.fields.amenities').':') !!}

    <p>
        @foreach($location->amenities as $amenity)
            <span
                class="badge badge-success">{{$amenity->name}}</span>


        @endforeach
    </p>
</div>

<!-- Open247 Field -->
<div class="col-sm-12">
    {!! Form::label('open247', __('models/locations.fields.open247').':') !!}
    <p>
        <span
            class="badge badge-{{$location->open247?'success':'danger'}}">{{__('lang.'.($location->open247?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Coming Soon Field -->
<div class="col-sm-12">
    {!! Form::label('coming_soon', __('models/locations.fields.coming_soon').':') !!}

    <p>
        <span
            class="badge badge-{{$location->coming_soon?'success':'danger'}}">{{__('lang.'.($location->coming_soon?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Under Repair Field -->
<div class="col-sm-12">
    {!! Form::label('under_repair', __('models/locations.fields.under_repair').':') !!}

    <p>
        <span
            class="badge badge-{{$location->under_repair?'success':'danger'}}">{{__('lang.'.($location->under_repair?'active':'not_active'))}}</span>

    </p>
</div>

<!-- Access Restrictions Field -->
<div class="col-sm-12">
    {!! Form::label('access_restrictions', __('models/locations.fields.access_restrictions').':') !!}
    <p>{{ $location->access_restrictions }}</p>
</div>

<!-- Parking Attributes Field -->
<div class="col-sm-12">
    {!! Form::label('parking_attributes', __('models/locations.fields.parking_attributes').':') !!}
    <p>{{ $location->parking_attributes }}</p>
</div>

<!-- Parking Level Field -->
<div class="col-sm-12">
    {!! Form::label('parking_level', __('models/locations.fields.parking_level').':') !!}
    <p>{{ $location->parking_level }}</p>
</div>

<!-- Overhead Clearance Meters Field -->
<div class="col-sm-12">
    {!! Form::label('overhead_clearance_meters', __('models/locations.fields.overhead_clearance_meters').':') !!}
    <p>{{ $location->overhead_clearance_meters }}</p>
</div>

<!-- Is Active Field -->
<div class="col-sm-12">
    {!! Form::label('is_active', __('models/clients.fields.is_active').':') !!}
    <p>
        <span
            class="badge badge-{{$location->is_active?'success':'danger'}}">{{__('lang.'.($location->is_active?'active':'not_active'))}}</span>

    </p>

</div>


<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', __('models/locations.fields.created_at').':') !!}
    <p>{{ $location->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', __('models/locations.fields.updated_at').':') !!}
    <p>{{ $location->updated_at }}</p>
</div>

<!-- Plugshare Location Id Field -->
<div class="col-sm-12">
    {!! Form::label('plugshare_location_id', __('models/locations.fields.plugshare_location_id').':') !!}
    <p>{{ $location->plugshare_location_id }}</p>
</div>

@push('page_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
          integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
          integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endpush

@push('page_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
            integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
            integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function () {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                lazyLoad: true,
                autoplay: true,
                autoplayTimeout: 1000,
                autoplayHoverPause: true
            });
        });

    </script>
@endpush

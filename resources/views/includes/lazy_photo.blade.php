
{{--<div class="img-profile"> <img class="lazy img-fluid mx-2" data-src="{{$photo}}" alt="Profile"></div>--}}
@if($photo)
<div class="img-profile"> <img class="lazy img-100 " width="100px" data-src="{{$photo}}" onerror="this.style.display='none';this.src=''" alt="image"></div>
@endif

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/dropify/dropify.css') }}">
@endpush



@push('vendor-scripts')
    <script src="{{ asset('assets/vendors/js/dropify/dropify.js') }}"></script>
    <script>
        $('.dropify').dropify();

    </script>
@endpush

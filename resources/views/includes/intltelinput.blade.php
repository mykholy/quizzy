@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/css/intlTelInput.css">
    <style type="text/css">
        .iti__flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/img/flags.png");}

        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .iti__flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/img/flags@2x.png");}
        }
        .iti {
            position: relative;
            display: block;
        }
    </style>
@endpush



@push('vendor-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/utils.min.js"></script>
    <script>

        function initPhone(name){
            var input = document.querySelector("input[name='"+name+"']");
            if(input!=null){
                var iti=window.intlTelInput(input, {
                    nationalMode:true,
                    hiddenInput: name,
                    //customContainer:"form-controls",
                    autoHideDialCode:true,
                    separateDialCode:true,
                    autoPlaceholder:"aggressive",
                    initialCountry: "auto",
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.18/js/utils.min.js",
                    geoIpLookup: function(success, failure) {
                        $.get("https://ipinfo.io?token=c2999fc5e1aefc",function() {}, "jsonp").always(function(resp) {
                            var countryCode = (resp && resp.country) ? resp.country : "us";
                            success(countryCode);
                        });
                    },
                });


                var reset = function() {
                    input.classList.remove("error");
                    setTheHidden();
                };

                var setTheHidden =function(){
                    var theHidden=document.querySelector("input[type=hidden][name='"+name+"']");
                    theHidden.value = '+'+iti.getSelectedCountryData().dialCode+input.value;
                    // console.log(theHidden.value);
                }


                input.addEventListener('change', reset);
                input.addEventListener('keyup', reset);

                input.addEventListener("countrychange", function() {
                    setTheHidden();
                });

                setTheHidden();

            }
        }
        setTimeout(() => {
            initPhone('phone');
        }, 3000);

    </script>
@endpush

<script>

    $(document).on('click', '.remove_record', function (event) {

        var that = $(this);
        var attr_id = that.attr('id');


        iziToast.question({
            timeout: false,
            close: false,
            overlay: true,
            displayMode: 'replace',
            id: 'question',
            color: 'red',
            icon: 'icon-trash',
            zindex: 9999,
            close: true,
            title: '{{ucfirst(__('lang.delete'))}}!',
            message: '{{__('lang.are_you_sure')}}',
            position: 'topCenter',
            buttons: [
                ['<button><b>{{__('lang.yes')}}</b></button>', function (instance, toast) {

                    instance.hide({transitionOut: 'fadeOut'}, toast, 'YES');
                    $('#Row' + attr_id).submit();

                }, true],
                ['<button>{{__('lang.no')}}</button>', function (instance, toast) {

                    instance.hide({transitionOut: 'fadeOut'}, toast, 'NO');

                }],
            ],

        });
    });

</script>

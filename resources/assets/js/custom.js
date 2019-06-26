(function($) {
    $(document).ready(function () {

        $('#overtime-employees').select2();
        $('#search').on('click', function() {
            overtimeData($('#overtime-employees').val(), $('input[name="to"]').val(), $('input[name="from"]').val());
        });

        $('.slider').slider({
            min: $('.slider').data('min'),
            max: $('.slider').data('max'),
            step: $('.slider').data('step'),
            value: $('.slider').data('value'),
            animate: 'fast',
            create: function (event, ui) {
                $('.slider').children().text($('.slider').data('value')).parent().next().val($('.slider').data('value'));
            },
            slide: function (event, ui) {
                $(this).children().text(ui.value).parent().next().val(ui.value);
            }
        });
        $('.slider-range').slider({
            range: true,
            values: [1.2, 2.5],
            step: 0.1,
            min: 1,
            max: 5,
            create: function () {
                $('.slider-range').children().first().text($('.slider-range').slider('values')[0]).next().text($('.slider-range').slider('values')[1]);
                $('.slider-range').prev().val($('.slider-range').slider('values')[1]).prev().val($('.slider-range').slider('values')[0]);
            },
            slide: function (event, ui) {
                $(this).children().first().text(ui.values[0]).next().text(ui.values[1]);
                $(this).prev().val(ui.values[1]).prev().val(ui.values[0]);
            }
        });
    });
})(jQuery);

function showAlert(type, message) {
    $(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "9000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr[type](message);
    });
}
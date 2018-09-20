$(document).ready(function () {
    $('#form_category input[type=checkbox]').checkboxradio();
    $('.page-subscribe form').submit(function () {
        if (!$('#form_category input[type=checkbox]:checked')[0]) {
            $('#form_category .ui-checkboxradio-label').css('background', 'red');
            return false;
        }
    });
    $('#form_category .ui-checkboxradio-label').click(function () {

        $('#form_category .ui-checkboxradio-label').removeAttr('style');
    } );
});

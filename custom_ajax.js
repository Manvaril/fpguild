$(document).ready(function() {
    jQuery('#datetime').datetimepicker({
        lang:'en',
        format:'m/d/Y g:i a',
        step:5
    });
    jQuery('#datetimestart').datetimepicker({
        lang:'en',
        format:'m/d/Y g:i a',
        step:5,
        allowBlank: true
    });
    jQuery('#datetimeend').datetimepicker({
        lang:'en',
        format:'m/d/Y g:i a',
        step:5,
        allowBlank: true
    });
    jQuery('#datetimeadjust').datetimepicker({
        lang:'en',
        format:'m/d/Y',
        step:5,
        timepicker: false,
        allowBlank: true
    });
    $('.present').click(function() {
        var id = $(this).attr("value");
        $('.present_rid_' + id).attr('disabled', !this.checked);
    });
});
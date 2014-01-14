$(function() {
    $('[data-picker]').each(function(key, value) {
        var options = $(value).data('picker');

        switch ($(value).data('pickertype')) {
            case 'date':
                $(value).datepicker(options);
                break;

            case 'time':
            case 'datetime':
                $(value).datetimepicker(options);
                break;
        }
    });
});

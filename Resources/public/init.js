(function($) {
    $(function() {
        $('[data-picker]').each(function(key, element) {
            var options = $(element).data('picker') || {};
            var type = $(element).data('pickertype') || 'date';

            switch (type) {
                case 'date':
                    $(element).datepicker(options);
                    break;

                case 'time':
                case 'datetime':
                    $(element).datetimepicker(options);
                    break;
            }
        });
    });
})(jQuery);
$(function() {
    $('input[name="start_date"]').daterangepicker({
        autoUpdateInput: false,
        alwaysShowCalendars: true,
        locale: {
            cancelLabel: 'Clear',
            format: 'D MMMM YYYY',
            separator: 's/d',
            monthNames: [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ]
        },
        ranges: {
            'Hari ini': [moment(), moment()],
            'Minggu ini': [moment().startOf('week'), moment().endOf('week')],
            'Bulan ini': [moment().startOf('month'), moment().endOf('month')]
        }
    });
    
    $('input[name="start_date"]').on('apply.daterangepicker', function(event, picker) {
        $(this).val(picker.startDate.format('D MMMM YYYY') + ' s/d ' + picker.endDate.format('D MMMM YYYY'));
    });

    $('input[name="start_date"]').on('cancel.daterangepicker', function(event, picker) {
        $(this).val('');
    });
});
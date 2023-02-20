/* global $ */
$(document).ready(function () {
    $('.delete').click(function (event) {
        $('#delete-form').attr('action', $(event.currentTarget).data('url'));
        $('#delete-dialog').modal('show');
    });
});
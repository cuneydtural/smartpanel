$('.datatable-responsive').on('draw.dt', function () {

    $("input[type=checkbox]").addClass("styled");

    $(".styled, .multiselect-container input").uniform({
        radioClass: 'choice'
    });

    $("a.dt-button").addClass("btn-xs bg-slate-600");

    $('.datatable-responsive tbody td input[type=checkbox]').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parents('tr').addClass('success');
        }
        else {
            $(this).parents('tr').removeClass('success');
        }
    });

    $("#select-all").click ( function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
        $.uniform.update();
        if ($(this).is(':checked')) {
            $('.datatable-responsive tr').addClass('success');
        }
        else {
            $('.datatable-responsive tr').removeClass('success');
        }
    })

    $('.datatable-responsive th').css('width', 'auto');

    $('.select').select2({
        minimumResultsForSearch: Infinity
    });

});
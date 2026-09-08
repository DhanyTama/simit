$(function () {
    var hasAlldataLoader = $('#loading-alldata').length > 0;

    $('.js-basic-example').each(function () {
        var $tbl = $(this);
        var isNoPaging = $tbl.hasClass('no-paging') 
                      || $tbl.attr('id') === 'table-today' 
                      || $tbl.data('paging') === false
                      || $tbl.closest('.card').find('h2:contains("TODAY")').length > 0;
        $tbl.DataTable({
            responsive: true,
            paging: !isNoPaging,
            info: true
        });
    });

    if (hasAlldataLoader) {
        setTimeout(function () {
            $('#loading-alldata').fadeOut(200, function () {
                $(this).remove();
                $('#table-wrapper-alldata').fadeIn(200, function () {
                    $('.js-basic-example').each(function () {
                        if ($.fn.dataTable.isDataTable(this)) {
                            $(this).DataTable().columns.adjust().responsive.recalc();
                        }
                    });
                });
            });
        }, 300);
    }

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Accordion effect: Hanya 1 detail collapse yang terbuka bergantian dalam tabel
    $(document).off('show.bs.collapse.tableAccordion').on('show.bs.collapse.tableAccordion', '.table .collapse', function () {
        var $table = $(this).closest('.table');
        $table.find('.collapse.in').not(this).collapse('hide');
    });
});
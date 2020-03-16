/*$(document).ready( function () {
        $('#transaction-table').DataTable();
    } );*/
let table = $(document).ready(function () {
    document.body.style.display = "block";
    DTable = $('#transaction-table');
    DTable.DataTable({
        "order": [[0, 'desc']],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Details for ' + data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                } )
            }
        }
    });
});

//function to delete rows
$(".delete-row").on('click',function () {
    let count = 0;
    $("table tbody").find('input[name ="record"]').each(function () {
        if($(this).is(":checked")){
            let tid = $(this).attr('data-tid');
            let func = "deleteTran";
            //keeping track of number of rows deleted
            count++;
            $.post('model/functions.php',{$tid:tid, $func:func});
        }
    });
    if(count == 0){
        alert("No rows selected to delete");
    }
    else {
        location.reload(true);
    }
});


//update sold status
$('.isSold').on('click', function () {
    let sold;
    if($(this).attr('checked') == 'checked'){
        sold = 0;
    }
    else{
        sold = 1;
    }
    //transaction id of transaction being updated
    let tid = $(this).attr('data-tid');
    //alert(sold);
    let func = "updateSold";
    //data['func'] = "updateSold";
    $.post('model/functions.php', {$sold: sold, $func: func, $tid:tid});
    //alert("did this work original?");
    //forcing the page to reload so they can click on the checkbox multiple times
    //location.reload(true);
    //DTable.ajax.reload();

});


//currently not working within modal
/*
        $(document).on('click', 'div.dtr-modal select', function () {
            $('.isSold').on('change', function () {
                console.log($(this));
                let sold;
                if($(this).attr('checked') == 'checked'){
                    sold = 0;
                }
                else{
                    sold = 1;
                }
                //transaction id of transaction being updated
                let tid = $(this).attr('data-tid');
                alert(tid);

                let func = "updateSold";
                //data['func'] = "updateSold";
                $.post("model/functions.php", {$sold: sold, $func: func, $tid: tid});
                alert("did this work?");

            });
        });
*/
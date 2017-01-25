<?php
/**
 * Created by PhpStorm.
 * User: Kamrul
 * Date: 2/8/2016
 * Time: 10:42 AM
 */
?>
 <!--list -->
<div id="grid_common_config"></div>
<script type="application/javascript">

$(document).ready(function () {
    {{!!$js_grid_common_config!!}}
	
});

 function commandDelete(e) {
    e.preventDefault ? e.preventDefault() : e.returnValue = false;
    var grid = $("#grid_common_config").data("kendoGrid");
    if (confirm("{!!config('app_config.msg_delete_confirmation')!!}")) {
        var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
        $.ajax({
            type: "POST",
            url: "/commonconfig/destroy/<?php echo $table_name; ?>",
            contentType: "application/json",
            data: JSON.stringify({id: dataItem.id}),

        }).done(function(data) {
            //console.log(data);

            toastr["success"]("{!!config('app_config.msg_delete')!!}", "Delete");
            grid.dataSource.read();
            grid.refresh();

        });

    }
 }
 
 



</script> 
<!-- /list -->
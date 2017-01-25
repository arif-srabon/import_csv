@extends('layouts.master')
@section('page_title', trans('setup/news.title'))
@section('menu_news','active')

@section('page_header')
    <i class="icon-gear position-left"></i> <span
            class="text-semibold">{{ trans('setup/news.title') }}</span>
@endsection

@section('breadcrumb_links')
	@if (SentinelAuth::check('transactions.news.add'))
        <li><a href="{{url('news/create')}}">
            <button class="btn btn-info btn-labeled btn-xs" type="button"><b><i
                            class="icon-file-plus2"></i></b> {{ trans('setup/news.btn_add') }}</button>
        </a></li>
    @endif 
@endsection

    @section('content')

            <!--list -->

    <div id="grid_allowance_program"></div>

    <script type="application/javascript">

        $(document).ready(function () {

          {{!!$js_grid_allowance_program!!}}

          $("#grid_allowance_program").on("click", ".k-grid-edit", function (e) {
                e.preventDefault ? e.preventDefault() : e.returnValue = false;
                var grid = $("#grid_allowance_program").data("kendoGrid");
                var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
                window.location.href = '/news/' + dataItem.id + '/edit/';
          });


          $("#grid_allowance_program").on("click", ".k-grid-delete", function (e) {
                e.preventDefault ? e.preventDefault() : e.returnValue = false;
                var grid = $("#grid_allowance_program").data("kendoGrid");
                if (confirm("{!!config('app_config.msg_delete_confirmation')!!}")) {
                    var dataItem = grid.dataItem($(e.currentTarget).closest("tr"));
                    $.ajax({
                        type: "POST",
                        url: "/news/destroy",
                        contentType: "application/json",
                        data: JSON.stringify({id: dataItem.id}),
                    }).done(function (data) {
                        //console.log(data);
                        if (data == 1) {
                            toastr["success"]("{!!config('app_config.msg_delete')!!}", "Delete");
                        } else {
                            toastr["error"]("{!!config('app_config.msg_failed_delete')!!}", "Delete");
                        }
                        grid.dataSource.read();
                        grid.refresh();
                    });

                }
            });

        });
    </script>

    <!-- /list -->

@endsection
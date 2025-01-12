<!DOCTYPE html>
<html>

<head>
    <!-- TABLES CSS CODE -->
    <?php include "comman/code_css.php"; ?>
    <!-- </copy> -->
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include "sidebar.php"; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= $page_title; ?>
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
                    <li class="active"><?= $page_title; ?></li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- right column -->
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="box box-primary ">
                            <div class="box-header with-border">
                                <h3 class="box-title">Please Enter Valid Information</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                <div class="box-body">
                                    <!-- <div class="form-group">

                                        <?php if (store_module() && is_admin()) {
                                            $this->load->view('store/store_code', array('show_store_select_box' => true, 'store_id' => get_current_store_id(), 'div_length' => 'col-sm-3', 'show_all' => 'true', 'form_group_remove' => 'true'));
                                        } else {
                                            echo "<input type='hidden' name='store_id' id='store_id' value='" . get_current_store_id() . "'>";
                                        } ?>
                                       
                                        <label for="category_id" class="col-sm-2 control-label"><?= $this->lang->line('category_name'); ?></label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2 " id="category_id" name="category_id" ">
                                       <option value="">-All-</option> 
                                       <?= get_expense_category_select_list(null, get_current_store_id()); ?>
                                    </select>
                                    <span id=" category_id_msg" style="display:none" class="text-danger"></span>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <!-- Warehouse Code -->
                                        <?php if (true) {
                                            $this->load->view('warehouse/warehouse_code', array('show_warehouse_select_box' => true, 'div_length' => 'col-sm-3', 'show_alls' => false, 'form_group_remove' => 'true', 'show_all_optionssss' => false));
                                        } else {
                                            echo "<input type='hidden' name='warehouse_id' id='warehouse_id' value='" . get_store_warehouse_id() . "'>";
                                        } ?>
                                        <!-- Warehouse Code end -->
                                        <label for="customer_id" class="col-sm-2 control-label">Items</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2 " id="products" name="products">
                                                <option value="">-All-</option>
                                                <?= get_items_select_list(null, get_current_store_id()); ?>
                                            </select>
                                            <span id=" products_msg" style="display:none" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="from_date" class="col-sm-2 control-label"><?= $this->lang->line('from_date'); ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker" id="from_date" name="from_date" value="<?php echo show_date(date('d-m-Y')); ?>">
                                            </div>
                                            <span id="from_date_msg" style="display:none" class="text-danger"></span>
                                        </div>
                                        <label for="to_date" class="col-sm-2 control-label"><?= $this->lang->line('to_date'); ?></label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker" id="to_date" name="to_date" value="<?php echo show_date(date('d-m-Y')); ?>">
                                            </div>
                                            <span id="to_date_msg" style="display:none" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="col-sm-8 col-sm-offset-2 text-center">
                                        <div class="col-md-3 col-md-offset-3">
                                            <button type="button" id="view" class=" btn btn-block btn-success" title="Save Data">Show</button>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="<?= base_url('dashboard'); ?>">
                                                <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
            <section class="content">
                <div class="row">
                    <!-- right column -->
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Records Table</h3>
                                <!-- <?php $this->load->view('components/export_btn', array('tableId' => 'report-data')); ?> -->
                                <!-- <div class="btn-group pull-right" title="View Account">
                                    <a class="btn btn-primary btn-o dropdown-toggle export-to-pdf" data-toggle="dropdown" href="#" aria-expanded="true">
                                        <i class="fa fa-fw fa-bars"></i> Export <span class="caret"></span>
                                    </a>
                                </div> -->
                                <div class="btn-group pull-right" title="View Account">
                                    <a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-fw fa-bars"></i> Export <span class="caret"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu dropdown-light pull-right">
                                        <li>
                                            <a style="cursor:pointer" class="downloadExcel" data-table-id="report-data" title="Download Excel Format" data-toggle="tooltip" data-placement="top">
                                                <i class="fa fa-fw fa-file-excel-o text-red"></i>Excel
                                            </a>
                                            <a style="cursor:pointer" class="export-to-pdf" title="Download PDF Format" data-toggle="tooltip" data-placement="top">
                                                <i class="fa fa-fw fa-file-pdf-o text-red"></i>PDF
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-bordered table-hover  " id='report-data'>
                                    <thead>
                                        <tr class="">
                                            <th style="" colspan='10'>
                                                <div class="text-center">
                                                    <h1 style="font-weight: 800;">PRODA STOCK MOVEMENT REPORT</h1>

                                                    <div>
                                                        <div style="font-size: 16px; font-weight: 500; margin-bottom: 5px;">
                                                            From: <span class="display-from-date"></span>
                                                        </div>
                                                        <div style="font-size: 16px; font-weight: 500; margin-bottom: 5px;">
                                                            To: <span class="display-to-date"></span>
                                                        </div>
                                                        <div style="font-size: 20px; font-weight: 500;">
                                                            <strong>For:</strong> <span class="display-distribution-center"></span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="bg-blue">
                                            <th style="">S/N</th>

                                            <th style="">Date Recorded</th>
                                            <th style="">Transaction Reference</th>
                                            <th style="">Transaction Type</th>
                                            <th style="">Product Name</th>
                                            <th style="">Opening</th>
                                            <th style="">Quantity</th>
                                            <th style="">Closing</th>
                                            <th style="">Remarks</th>
                                            <th style="">Initial Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyid">
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include "footer.php"; ?>
        <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <!-- SOUND CODE -->
    <?php include "comman/code_js_sound.php"; ?>
    <!-- TABLES CODE -->
    <?php include "comman/code_js.php"; ?>
    <!-- TABLE EXPORT CODE -->
    <?php include "comman/code_js_export.php"; ?>
    <script src="<?php echo $theme_link; ?>js/sheetjs.js" type="text/javascript"></script>

    <script type="text/javascript">
        var base_url = $("#base_url").val();
        $("#store_id").on("change", function() {
            var store_id = $(this).val();
            $.post(base_url + "expense/get_expense_category_select_list", {
                store_id: store_id
            }, function(result) {
                result = '<option value="">All</option>' + result;
                $("#category_id").html('').append(result).select2();
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $(".export-to-pdf").on("click", function(e) {
                // alert("export-to-pdf");
                e.preventDefault();
                var base_url = $("#base_url").val();
                var from_date = document.getElementById("from_date").value;
                var to_date = document.getElementById("to_date").value;
                var warehouse_id = document.getElementById("warehouse_id").value;
                var products = document.getElementById("products").value;

                // Construct the URL with parameters
                const url =
                    base_url +
                    `reports/stock-movements-pdf?warehouse_id=${warehouse_id}&from_date=${from_date}&to_date=${to_date}&item_id=${products}`;

                // location.href = url;
                // Open the URL in a new tab
                window.open(url, '_blank');
            });
        });
    </script>

    <!-- <script src="<?php echo $theme_link; ?>js/report-expense.js"></script> -->
    <script src="<?php echo $theme_link; ?>js/report-stock-movement.js"></script>
    <!-- Make sidebar menu hughlighter/selector -->
    <script>
        $(".<?php echo basename(__FILE__, '.php'); ?>-active-li").addClass("active");
    </script>
</body>

</html>
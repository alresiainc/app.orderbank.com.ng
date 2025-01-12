<!DOCTYPE html>
<html>

<head>
    <!-- TABLES CSS CODE -->
    <?php include "comman/code_css.php"; ?>
    <!-- </copy> -->
</head>

<body class="">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <div class="bo">

                <!-- /.box-header -->
                <div class="box-boddy table-responsivee no-paddingg">
                    <table class="tablee table-borderedd table-hoverr  " id='report-data' style="max-width: 100%;">
                        <thead>
                            <tr class="">
                                <th style="" colspan='10'>
                                    <div class="text-center">
                                        <h1 style="font-weight: 800;">PRODA STOCK MOVEMENT REPORT</h1>

                                        <div>
                                            <div style="font-size: 16px; font-weight: 500; margin-bottom: 5px;">
                                                From: <span class="display-from-date"><?= $from_date ?? ''; ?></span>
                                            </div>
                                            <div style="font-size: 16px; font-weight: 500; margin-bottom: 5px;">
                                                To: <span class="display-to-date"><?= $to_date ?? ''; ?></span>
                                            </div>
                                            <div style="font-size: 20px; font-weight: 500;">
                                                <strong>For:</strong> <span class="display-distribution-center"><?= $warehouse ?? ''; ?></span>
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
                            <?= $body; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

</body>

</html>
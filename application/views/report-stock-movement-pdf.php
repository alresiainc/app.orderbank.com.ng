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
                    <div class="text-center mb-3">
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
                    <table class="tablee table-borderedd table-hoverr  " id='report-data' style="max-width: 100%;">
                        <thead>

                            <tr class="bg-blue">
                                <th style="padding: 5px 10px;">S/N</th>

                                <th style="padding: 5px 10px;">Date Recorded</th>
                                <th style="padding: 5px 10px;">Transaction Reference</th>
                                <th style="padding: 5px 10px;">Transaction Type</th>
                                <th style="padding: 5px 10px;">Product Name</th>
                                <th style="padding: 5px 10px;">Opening</th>
                                <th style="padding: 5px 10px;">Quantity</th>
                                <th style="padding: 5px 10px;">Closing</th>
                                <th style="padding: 5px 10px;">Remarks</th>
                                <th style="padding: 5px 10px;">Initial Stock</th>
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
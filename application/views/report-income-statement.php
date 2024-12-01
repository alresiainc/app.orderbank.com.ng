<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css.php"; ?>
      <!-- </copy> -->  
<!--      <script-->
<!--	src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>-->
<!--<script-->
<!--	src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.min.js"></script>-->
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?=$page_title;?>
                  <small></small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
                  <li class="active"><?=$page_title;?></li>
               </ol>
            </section>
            <!-- Main content -->
            
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
                        <form target='_blank' class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;" action='<?=base_url('reports/sales_and_payments_report')?>'>
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <div class="box-body">
                              <div class="form-group">
                                 <!-- Store Code -->
                                  <?php if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>get_current_store_id(),'div_length'=>'col-sm-3','show_all'=>'true','form_group_remove' => 'true')); }else{
                                     echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
                                     }?>
                                  <!-- Store Code end -->
                                </div>
                                
                              
                              <div class="form-group">
                                 <label for="from_date" class="col-sm-2 control-label"><?= $this->lang->line('from_date'); ?></label>
                                 <div class="col-sm-3">
                                    <div class="input-group date">
                                       <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                       </div>
                                       <input type="text" class="form-control pull-right datepicker" id="from_date" name="from_date" value="">
                                    </div>
                                    <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                 <label for="to_date" class="col-sm-2 control-label"><?= $this->lang->line('to_date'); ?></label>
                                 <div class="col-sm-3">
                                    <div class="input-group date">
                                       <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                       </div>
                                       <input type="text" class="form-control pull-right datepicker" id="to_date" name="to_date" value="">
                                    </div>
                                    <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>

                              <!--<div class="form-group">-->
                              <!--   <label for="customer_id" class="col-sm-2 control-label"><?= $this->lang->line('customer_name'); ?></label>-->
                              <!--   <div class="col-sm-3">-->
                              <!--      <select class="form-control select2 " id="customer_id" name="customer_id">-->
                              <!--         <option value="">-Select-</option>-->
                              <!--         <?= get_customers_select_list(null,get_current_store_id());?>-->
                              <!--      </select>-->
                              <!--      <span id="customer_id_msg" style="display:none" class="text-danger"></span>-->
                              <!--   </div>-->

                              <!--</div>-->
                           

                           </div>

                           <!-- /.box-body -->
                           <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="view" class=" btn btn-block btn-success" title="Save Data">Show</button>
                                 </div>
                                 <div class="col-sm-3">
                                    <a href="<?=base_url('dashboard');?>">
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
<!--<button id="btn-generate">Generate PDF</button>-->
<!--<button id="btn-generate2">Generate PDF 2</button>-->
            <section class="content">
               <div class="row">
                  <!-- right column -->
                  <div class="col-md-12">
                           
                     <div class="box" id="container">
                         <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="https://backend.myproda.com/theme/bootstrap/css/bootstrap.min.css">
   
                         <h1 class="text-center" style="font-weight:bold; color:#2d436a;">PRODA Technologies LTD</h1>
                       
                        <div class="box-header  bg-secondary font-weight-bolder text-center"  style="color:white;background-color:#2d436a;font-weight:900;">
                            
                           <h1 class="box-title">Consolidated Income Statement</h1>
                           <!--<?php $this->load->view('components/export_btn',array('tableId' => 'report-data'));?>-->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body p-0">
                            <div id="content"></div>
                            <div id="editor"></div>
                    
                          
                        </div>
                        <!-- /.box-body -->
                     </div>
                     <!-- /.box -->
                     <div class="text-center" ><button type="button" id="btn-generates" class=" btn  btn-success" title="Print" onclick="converHTMLFileToPDF('table-container')">Download Report</button></div>
   
                  </div>
               </div>
            </section>
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js.php"; ?>
      <!-- TABLE EXPORT CODE -->
      <?php include"comman/code_js_export.php"; ?>
      <!--<script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>-->
		<!--<script src="http://html2canvas.hertzen.com/build/html2canvas.js"></script>-->

      <script src="<?php echo $theme_link; ?>js/sheetjs.js" type="text/javascript"></script>
      <!--<script src="<?php echo $theme_link; ?>js/jsPDF/jspdf.min.js" type="text/javascript"></script>-->
      <!--<script src="<?php echo $theme_link; ?>js/jsPDF/jspdf.debug.js" type="text/javascript"></script>-->
      <!--<script src="<?php echo $theme_link; ?>js/jsPDF/examples/js/html2canvas.js" type="text/javascript"></script>-->
      <script
	src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
      <script type="text/javascript">
        var base_url=$("#base_url").val();
        $("#store_id").on("change",function(){
          var store_id=$(this).val();
          $.post(base_url+"expense/get_expense_category_select_list",{store_id:store_id},function(result){
              result='<option value="">All</option>'+result;
              $("#category_id").html('').append(result).select2();
          });
        });
      </script>
      
  <script>
		var buttonElement = document.querySelector("#btn-generate");
		buttonElement.addEventListener('click', function() {
			const { jsPDF } = window.jspdf;
	var doc = new jsPDF('p', 'mm', [1200, 1210]);
	var specialElementHandlers = {
            '#editor': function (element, renderer) {
                return true;
            }
        };
			var pdfContent = document.querySelector("#container");

			// Generate PDF from HTML using right id-selector
			doc.html(pdfContent, {
				callback: function(doc) {
				doc.save("income-statement-report.pdf");
				},
				x: 10,
				y: 19
			});
		});
	</script>
  

<script language="javascript">

function converHTMLFileToPDF() {
	const { jsPDF } = window.jspdf;
	var doc = new jsPDF('p', 'mm', [1200, 1210]);

	var pdfjs = document.querySelector('#container');
	var title = document.querySelector("title").innerText;

	doc.html(pdfjs, {
		callback: function(doc) {
			doc.save("income-statement-report.pdf");
		},
		filename: 'title',
// 		x: 10,
// 		y: 10,
	    width: 170,
	});

}
</script>
      <script src="<?php echo $theme_link; ?>js/report-income-statement.js"></script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>

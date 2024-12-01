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
	src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- /.content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-info ">
                        <div class="box-header with-border">
                           <h3 class="box-title">Please Enter Valid Information</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <div class="box-body">
                            <div class="form-group">
                                 <!-- Store Code -->
                                  <?php if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>get_current_store_id(),'div_length'=>'col-sm-3','show_all'=>'true','form_group_remove' => 'true')); }else{
                                     echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
                                     }?>
                                  <!-- Store Code end -->

                                  <!-- Warehouse Code -->
                                  <?php if(true) {$this->load->view('warehouse/warehouse_code',array('show_warehouse_select_box'=>true,'div_length'=>'col-sm-3','show_all'=>'true','form_group_remove' => 'true','show_all_option'=>true)); }else{
                                     echo "<input type='hidden' name='warehouse_id' id='warehouse_id' value='".get_store_warehouse_id()."'>";
                                     }?>
                                  <!-- Warehouse Code end -->

                                </div>

                              <div class="form-group">
                               <!--  <label for="brand_id" class="col-sm-2 control-label"><?= $this->lang->line('brand'); ?></label> --> 
                                 <div class="col-sm-3">
                                   <!-- <select class="form-control select2 " id="brand_id" name="brand_id"  style="width: 100%;">
                                       <option value="">-Select-</option>
                                       <?= get_brands_select_list();  ?>
                                    </select> -->
                                    
                                    <span id="brand_id_msg" style="display:none" class="text-danger"></span>
                                 </div>

                                <!-- <label for="category_id" class="col-sm-2 control-label"><?= $this->lang->line('category'); ?></label> -->
                                
                                 <div class="col-sm-3">
                                <!--    <select class="form-control select2 " id="category_id" name="category_id"  style="width: 100%;">
                                       <option value="">-Select-</option>
                                      <?= get_categories_select_list();  ?>
                                    </select>  -->
                                    
                                    <span id="category_id_msg" style="display:none" class="text-danger"></span>
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

                  <div class="col-md-12">
                     <!-- Custom Tabs -->
                     <div class="nav-tabs-custom">
                       
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1" data-toggle="tab"><?= $this->lang->line('item_wise'); ?></a></li>
                            <!--<li><a href="#tab_2" data-toggle="tab"><?= $this->lang->line('brand_wise'); ?></a></li> -->
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane active" id="tab_1">
                            
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                     <!--<div class="text-center" ><button type="button" id="btn-generates" class=" btn  btn-success" title="Download Report" >Download Report</button></div>-->
   
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                          <div class="btn-group pull-right" title="View Account">
                                            	<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                            		<i class="fa fa-fw fa-bars"></i> Export <span class="caret"></span>
                                            	</a>
                                            	<ul role="menu" class="dropdown-menu dropdown-light pull-right">
                                            	 <li>
                                            		
                                            		<a onclick="converHTMLFileToPDF('container')" style="cursor:pointer"  title="" data-toggle="tooltip" data-placement="top" data-original-title="Download PDF Format">
                                            			<i class="fa fa-fw fa-file-pdf-o text-red"></i>PDF
                                            		</a>
                                            		<a onclick="printElement('brand_wise_stock')" style="cursor:pointer" class=""  title="" data-toggle="tooltip" data-placement="top" data-original-title="Download PDF Format">
                                            			<i class="fa fa-fw fa-file-pdf-o text-red"></i>Print
                                            		</a>
                                            	</li>
                                            </ul>
                                            </div>
                                          <br><br>
                                          <div id="container">
                                              
                                         <h1 class="text-center" style="font-weight:bold; color:#2d436a;">PRODA Technologies LTD</h1>
                                   
                                                <div class="box-header  bg-secondary font-weight-bolder text-center"  style="font-weight:900;">
                                                    
                                                   <h1 class="box-title">Stock Report <span id="for-name"></span></h1>
                                                   <p class="">   <?php echo "Date " . date("l"). ", " .date("Y-m-d") . "<br>"; ?></p>
                                                 </div>
                                          <div class="table-responsive" id="table-container"><br>
                                            
                                          <table class="table table-bordered table-hover " id="report-data" >
                                            <thead>
                                       

                                            <tr class="bg-blue">
                                              <th style="">#</th>
                                              <?php if(store_module() && is_admin()){ ?>
                                              <th style=""><?= $this->lang->line('store_name'); ?></th>
                                              <?php } ?>
                                              <th style=""><?= $this->lang->line('item_code'); ?></th>
                                              <th style=""><?= $this->lang->line('item_name'); ?></th>
                                              <!--<th style=""><?= $this->lang->line('brand'); ?></th>-->
                                              <!--<th style=""><?= $this->lang->line('category'); ?></th>-->
                                              <!--<th style=""><?= $this->lang->line('unit_price'); ?>(<?= $CI->currency(); ?>)</th>-->
                                              <!--<th style=""><?= $this->lang->line('tax'); ?></th>-->
                                              <!--<th style=""><?= $this->lang->line('sales_price'); ?>(<?= $CI->currency(); ?>)</th>-->
                                              <th style=""><?= $this->lang->line('current_stock'); ?></th>
                                              <!--<th style=""><?= $this->lang->line('value'); ?></th>-->
                                            </tr>
                                            </thead>
                                            <tbody id="tbodyid">
                                            
                                          </tbody>
                                          </table>
                                          </div>
                                           </div>
                                       <!-- /.box-body -->
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                          
                           <div class="tab-pane" id="tab_2">
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                      
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                          <div class="btn-group pull-right" title="View Account">
                                            	<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                            		<i class="fa fa-fw fa-bars"></i> Export <span class="caret"></span>
                                            	</a>
                                            	<ul role="menu" class="dropdown-menu dropdown-light pull-right">
                                            	 <li>
                                            		
                                            		<a onclick="converHTMLFileToPDF('brand_wise_stock')" style="cursor:pointer" class=""  title="" data-toggle="tooltip" data-placement="top" data-original-title="Download PDF Format">
                                            			<i class="fa fa-fw fa-file-pdf-o text-red"></i>PDF
                                            		</a>
                                            			<a onclick="printElement('brand_wise_stock')" style="cursor:pointer" class=""  title="" data-toggle="tooltip" data-placement="top" data-original-title="Download PDF Format">
                                            			<i class="fa fa-fw fa-file-pdf-o text-red"></i>Print
                                            		</a>
                                            	</li>
                                            </ul>
                                            </div>
                                          <br><br>
                                          <div class="table-responsive">
                                          <table class="table table-bordered table-hover " id="brand_wise_stock" >
                                              <thead>
                                              <tr class="bg-blue">
                                                <th style="">#</th>
                                                <?php if(store_module() && is_admin()){ ?>
                                                  <th style=""><?= $this->lang->line('store_name'); ?></th>
                                                  <?php } ?>
                                                <th style=""><?= $this->lang->line('brand_name'); ?></th>
                                                
                                                <th style=""><?= $this->lang->line('current_stock'); ?></th>
                                              </tr>
                                              </thead>
                                              <tbody id="">
                                              
                                              </tbody>
                                            </table>
                                          </div>
                                       <!-- /.box-body -->
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                             
                           </div>
                           <!-- /.tab-pane -->
                      
                        </div>
                        <!-- /.tab-content -->
                     </div>
                     <!-- nav-tabs-custom -->
                  </div>
                  <!-- /.col -->
     
      
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
    
<!--<script src="<?php echo $theme_link; ?>js/sheetjs.js" type="text/javascript"></script>-->

<script type="text/javascript">
  var base_url=$("#base_url").val();


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!--<script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
  function load_reports(){
   var store_id=$("#store_id").val();
   var brand_id=$("#brand_id").val();
   var category_id=$("#category_id").val();
   var warehouse_id=$("#warehouse_id").val();
   
   $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.post(base_url+"reports/get_stock_report",{warehouse_id:warehouse_id,store_id:store_id,brand_id:brand_id,category_id:category_id},function(result){
            result = $.parseJSON(result);
            //alert(JSON.stringify(result))
                
              $.each( result, function( key, val ) {
                if(key=='item_wise_report'){
                    $("#tbodyid").empty().append(val);
                }
                if(key=='brand_wise_stock'){
                    $("#brand_wise_stock tbody").empty().append(val);     
                }
                /*if(key=='category_wise_stock'){
                    $("#category_wise_stock tbody").empty().append(val);     
                }*/

              });
              $(".overlay").remove();
           });

    }//function end
</script>
<script language="javascript">

    $("#view").on("click",function(){
    var warehouse_name=$(".select2-selection__rendered").attr('title');
      load_reports();
      $("#for-name").text('For '+warehouse_name);
    });
    $("#store_id,#warehouse_id").on("change",function(){
       var warehouse_name=$(".select2-selection__rendered").attr('title');
      load_reports();
      $("#for-name").text('For '+warehouse_name);
    });

</script>
<script type="text/javascript">
function converHTMLFileToPDFOLD(id) {
    var warehouse_name = $(".select2-selection__rendered").attr('title');
    var title = 'Stock Report For ' + warehouse_name + '.pdf';
    var filename = title.replace(/ /g, "-") + '.pdf';

    var pdfContent = document.querySelector('#' + id);

    // Configure html2pdf settings
    var opt = {
        // margin: [10, 10, 10, 10], // Margins in mm
        filename: filename,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // Use html2pdf to create and save the PDF
    html2pdf().from(pdfContent).set(opt).toContainer().toCanvas().toPdf().save();
}

function printElement(id) {
    var pdfjs = document.querySelector('#' + id);
    if (pdfjs) {
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('<style>body { margin: 0; }</style>'); // Add any styling here
        printWindow.document.write('</head><body>');
        printWindow.document.write(pdfjs.outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    } else {
        console.error("Element not found");
    }
}


function converHTMLFileToPDF(id) {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF('p', 'mm', [1200, 1210]); // Set to A4 size in portrait mode
    var warehouse_name = $(".select2-selection__rendered").attr('title');

    var pdfjs = document.querySelector('#' + id);
    var title = 'Stock Report For ' + warehouse_name + '.pdf';
    title = title.replace(/ /g, "-");

    doc.html(pdfjs, {
        callback: function(doc) {
            doc.save(title);
        },
        x: 10,
        y: 10,
        width: 190, // Adjust width to fit the content within the A4 width
        html2canvas: {
            scale: 1, // Scale of the canvas
            useCORS: true, // Enable CORS for cross-origin images
            logging: true // Enable logging for debugging
        },
        jsPDF: { 
            unit: 'mm', 
            format: [1200, 1210], 
            orientation: 'portrait' 
        }
    });
}



function converHTMLFileToPDF(id) {
//     const { jsPDF } = window.jspdf;
// 	var doc = new jsPDF('p', 'mm', [1200, 1210]);
//     var warehouse_name=$(".select2-selection__rendered").attr('title');
    
// 	var pdfjs = document.querySelector('#'+id);
// 	var title = 'Stock Report For '+warehouse_name+'.pdf';
// 	title = title.replace(" ", "-");

// 	doc.html(pdfjs, {
// 		callback: function(doc) {
// 			doc.save(title);
// 		},
// 		filename: 'title',
// 		x: 10,
// 		y: 10,
// 	    width: 170,
// 	});
            var warehouse_name=$(".select2-selection__rendered").attr('title');
            var title = 'Stock Report For '+warehouse_name+'.pdf';
        	var filename = title.replace(" ", "-");

			var pdfContent = document.querySelector('#'+id);
			html2pdf().set({
              margin:       5,
              filename:     filename,
              jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            }).from(pdfContent).save();

}
</script>
<script>
        var base_url=$("#base_url").val();
        $("#store_id").on("change",function(){
          var store_id=$(this).val();
          $.post(base_url+"sales/get_customers_select_list",{store_id:store_id},function(result){
              result='<option value="">All</option>'+result;
              $("#customer_id").html('').append(result).select2();

          });
          $.post(base_url+"sales/get_warehouse_select_list",{store_id:store_id},function(result){
              result='<option value="">All</option>'+result;
              $("#warehouse_id").html('').append(result).select2();

              load_brands_list();
              load_category_list();
          });
        });


    function load_brands_list(){
     var store_id=$("#store_id").val();
     $.post(base_url+"sales/get_brands_select_list",{store_id:store_id},function(result){
          result='<option value="">All</option>'+result;
          $("#brand_id").html('').append(result).select2();
      });
    }

    function load_category_list(){
     var store_id=$("#store_id").val();
     $.post(base_url+"sales/get_categories_select_list",{store_id:store_id},function(result){
          result='<option value="">All</option>'+result;
          $("#category_id").html('').append(result).select2();
      });
    }

      </script>
 <script>
		var buttonElement = document.querySelector("#btn-generates");
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
	<script>
		var buttonElement = document.querySelector("#btn-generated");
		buttonElement.addEventListener('click', function() {
		    var warehouse_name=$(".select2-selection__rendered").attr('title');
            var title = 'Stock Report For '+warehouse_name+'.pdf';
        	var filename = title.replace(" ", "-");

			var pdfContent = document.querySelector("#container");
			var optionArray = {
              margin:       10,
              filename:     'output.pdf',
              jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
        
			html2pdf().set({
              margin:       [10, 10, 10, 10],
              filename:     filename,
              jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            }).from(pdfContent).save();
		});



// html to pdf generation with the reference of PDF worker object
// html2pdf().set(optionArray).from(pdfContent).save();
	</script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    
    
</body>
</html>

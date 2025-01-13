<!-- Export -->
<script type="text/javascript" src="<?php echo $theme_link; ?>plugins/tableExporter/libs/js-xlsx/xlsx.core.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_link; ?>plugins/tableExporter/libs/jsPDF/jspdf.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_link; ?>plugins/tableExporter/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
<script type="text/javascript" src="<?php echo $theme_link; ?>plugins/tableExporter/tableExport.min.js"></script>
<script>
      function downloadPdf(tableId, fileName = null) {
            // $('#'+tableId).tableExport({type:'pdf',escape:'false'});
            var options = {
                  type: 'pdf',
                  header: '<div class="text-center">Title Here<div>',
                  footer: '<small>Special Footer Here</small>',
                  escape: 'false'
            };
            if (fileName) {
                  options.fileName = fileName;
            }

            $('#' + tableId).tableExport(options);
      }

      function downloadExcel(tableId, fileName = null) {
            var options = {
                  type: 'xlsx',
                  escape: 'false'
            };
            if (fileName) {
                  options.fileName = fileName;
            }

            $('#' + tableId).tableExport(options);
      }
      $(".downloadPdf").on("click", function() {
            var tableId = $(this).attr("data-table-id");
            var fileName = $(this).attr("data-file-name");
            downloadPdf(tableId, fileName ?? null);
      });
      $(".downloadExcel").on("click", function() {
            var tableId = $(this).attr("data-table-id");
            var fileName = $(this).attr("data-file-name");
            downloadExcel(tableId, fileName ?? null);
      });
</script>
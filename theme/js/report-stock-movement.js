$("#view,#view_all").on("click", function () {
  var base_url = $("#base_url").val();
  var from_date = document.getElementById("from_date").value;
  var to_date = document.getElementById("to_date").value;
  var warehouse_id = document.getElementById("warehouse_id").value;
  var products = document.getElementById("products").value;
  console.log("from_date:", from_date);
  console.log("to_date:", to_date);

  // Find the option text for the selected warehouse_id
  var warehouse_name = $(
    "#warehouse_id option[value='" + warehouse_id + "']"
  ).text();

  // Format the dates (optional: customize the format as needed)
  // Parse and format the dates
  var formatted_from_date = parseDate(from_date).toLocaleDateString("en-GB", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
  var formatted_to_date = parseDate(to_date).toLocaleDateString("en-GB", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });

  var file_name =
    "Stock Movement for " +
    warehouse_name +
    " from " +
    from_date +
    " to " +
    to_date;

  // data-file-name
  // Populate the display elements
  $(".downloadExcel").attr("data-file-name", file_name);
  $(".downloadPdf").attr("data-file-name", file_name);
  $(".display-from-date").text(formatted_from_date || "N/A");
  $(".display-to-date").text(formatted_to_date || "N/A");
  $(".display-distribution-center").text(warehouse_name || "N/A");

  item_ids = products ? [products] : null;

  function parseDate(input) {
    const [day, month, year] = input.split("-").map(Number); // Split and parse day, month, year
    return new Date(year, month - 1, day); // Month is zero-based
  }

  if (from_date == "") {
    toastr["warning"]("Select From Date!");
    document.getElementById("from_date").focus();
    return;
  }

  if (to_date == "") {
    toastr["warning"]("Select To Date!");
    document.getElementById("to_date").focus();
    return;
  }

  if (this.id == "view_all") {
    var view_all = "yes";
  } else {
    var view_all = "no";
  }

  $(".box").append(
    '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
  );
  $.post(
    base_url + "reports/stock_movement_table_body_data",
    {
      warehouse_id: warehouse_id,
      item_ids: item_ids ?? [],
      from_date: from_date,
      to_date: to_date,
      //   store_id: $("#store_id").val(),
      //   warehouse_id: $("#warehouse_id").val(),
    },
    function (result) {
      //alert(result);
      setTimeout(function () {
        $("#tbodyid").empty().append(result);
        $(".overlay").remove();
      }, 0);
    }
  );
});

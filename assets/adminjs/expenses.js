$(document).ready(function()
{
  $("#date_range").click(function (e) {
      e.preventDefault();
      $("#period_reports").fadeIn(200);
  });
  $("#expenses").addClass('active');
  $("#pointer").html("Expenses");

  show_allExpenses();
  function show_allExpenses()
  {
    $.ajax({
      url: './pagination_data/expenses-pagination.php', 
      type: 'GET',
      success: function(response) {
          $('#paginationDiv').html(response)
          $("#searchInput").val("");
      },
      error: function(xhr, status, error) {
          console.error(xhr.responseText); 
      }
    });
  }
  $("#clear_all_search").off("click").on("click", function(){
    $("#searchInput").val("");
    $("#date_range").val("");
    $("#searchInput").focus();
    show_allExpenses();
  })
  $("#date_range").val(""); 
  $("#printThis").on("click", function () {
    $('#modalCashPrint').show();
    $.ajax({
      url: './reports/generate_expense_pdf.php',
      type: 'GET',
      xhrFields: {
        responseType: 'blob'
      },
      success: function (response) {
        $('#modalCashPrint').hide();
        var newBlob = new Blob([response], { type: 'application/pdf' });
        var blobURL = URL.createObjectURL(newBlob);

        var newWindow = window.open(blobURL, '_blank');
        if (newWindow) {
          newWindow.onload = function () {
            newWindow.print();
            newWindow.focus();
          };
        } 
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  })
  $("#generatePDFBtn").on("click", function () 
  {
    $('#modalCashPrint').show();
      $.ajax({
        url: './reports/generate_expense_pdf.php',
        type: 'GET',
        xhrFields: {
          responseType: 'blob'
        },
        success: function (response) {
          $('#modalCashPrint').hide();
          var blob = new Blob([response], { type: 'application/pdf' });
          var url = URL.createObjectURL(blob);
          var a = document.createElement('a');
          a.href = url;
          a.download = 'expenses.pdf';
          document.body.appendChild(a);
          a.click();

          URL.revokeObjectURL(url);
          document.body.removeChild(a);
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
  })
  $('#generateEXCELBtn').click(function () {
    $('#modalCashPrint').show();
    var fileName = "overall_expenses";
    $.ajax({
      url: './reports/generate_expense_excel.php',
      type: 'GET',
      xhrFields: {
        responseType: 'blob'
      },
      success: function (response) {
        $('#modalCashPrint').hide();
        var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = fileName + '.xlsx';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
    
  });
  $("#btn_createExpense").off("click").on("click", function(){
    $("#expense_form")[0].reset();
    $('#imagePreview').attr('src', "./assets/img/invoice.png");
    $("#expense_id").val(""); 
    $("#isProductIDExist").val("0");
    $("#item_name").focus();
    $("#add_expense_modal").find(".modalHeaderTxt").html("Add New Expense");
    createExpense();
    
  })
  function createExpense()
  {
    $("#add_expense_modal").addClass('slideInRight');
    $(".expense_content").addClass('slideInRight');
    setTimeout(function () {
      $("#add_expense_modal").show();
      $(".expense_content").show();
    }, 100);
    $(".expense-hide").prop("disabled", false);
    $(".expense-hide input").prop("disabled", false);
    $(".expense-hide").css({
      'opacity': '1',
    })
    $("#landingCostDiv").hide();
    $("#expense_errorMessages").html("");
    $('table td').removeClass('form-error'); 
    $("input").removeClass('form-error'); 
  }
  function setFormattedDate(date) {
    return moment(date).format('MM-DD-YYYY');
  }
  $("#responsive-data").on("click", "#btn_removeExpense", function(){
    var id = $(this).data('id');
    $.ajax({
      type: 'get',
      url: 'api.php?action=get_expenseDataById',
      data: {
        expense_id: id
      },
      success: function(response)
      {
        $("#remove_expense_id").val(id);
        $("#expense_name").html("Item name: <span style ='color: var(--primary-color)'>"+response['item_name'].toUpperCase() + "</span> Invoice number: <span style = 'color: var(--primary-color)'>"+response['invoice_number'] + "</span>");
        $("#expense_msg").html("<span style ='color: red; font-weight: bold'>Deleting an item might be crucial as it can affect other transactions</span>");
        if (response['invoice_photo_url']) {
              $("#item_image").attr("src", response['invoice_photo_url']).show();
          } else {
              $('#item_image').attr('src', "./assets/img/tinkerpro-logo-light.png").show();
          }
        $("#delete_expenseConfirmation").slideDown({
          backdrop: 'static',
          keyboard: false
        });
      }
    })
  })
  $("#responsive-data").on("dblclick", ".tbl_rows", function() {
    createExpense();
    var expense_id = $(this).data("id");
    var product_id = $(this).data('product_id');
    $("#tbl_expenses tbody").find(".tbl_rows").removeClass('highlighted-row')
    $(this).toggleClass('highlighted-row');
    $("#add_expense_modal").find(".modalHeaderTxt").html("Edit Expense");

    if(product_id == 0)
    {
      $(".expense-hide").prop("disabled", false);
      $(".expense-hide input").prop("disabled", false);
      $(".expense-hide").css({
        'opacity': '1',
      })
    }
    else
    {
      $(".expense-hide").prop("disabled", true);
      $(".expense-hide input").prop("disabled", true);
      $(".expense-hide").css({
        'opacity': '0.5',
      })
    }
    $("#isProductIDExist").val(product_id);

    $.ajax({
      type: 'get',
      url: 'api.php?action=get_expenseDataById',
      data: {
        expense_id: expense_id
      },
      success: function(response)
      {
        $("#expense_id").val(expense_id);
        var item_name = response['item_name'] === "" ? response['product'] : response['item_name'];
        $("#item_name").val(item_name);
        var formattedDate = moment(response['date_of_transaction']).format('MM-DD-YYYY');
        $("#date_of_transaction").val(formattedDate);
        $("#billable_receipt_no").val(response['billable_receipt_no']);
        $("#expense_type").val(response['expense_type']);
        $("#qty").val(response['quantity']);
        $("#supplier").val(response['supplier']);
        $("#supplier_id").val(response['supplier_id']);
        $("#uomType").val(response['uom_name']);
        $("#uomID").val(response['uom_id']);
        $("#invoice_number").val(response['invoice_number']);
        $("#price").val(response['price']);
        $("#discount").val(response['discount']);
        $("#total_amount").val(addCommasToNumber(response['total_amount']));
        $("#vatable_amount").val(addCommasToNumber(response['taxable_amount']));
        $("#description").val(response['description']);
        if (response['invoice_photo_url']) {
              $("#imagePreview").attr("src", response['invoice_photo_url']).show();
        } else {
            $('#imagePreview').attr('src', "./assets/img/invoice.png").show();
        }

        var isLandingCostEnabled = response['isLandingCostEnabled'] === 1;
        if(isLandingCostEnabled)
        {
          $("#landingCostDiv").show();
          $("#toggleLandingCost").prop("checked", "checked");
          // $("#totalLandingCost").val(response['total_amount']);
          
          var totalLandingCost = $("#totalLandingCost").val();
          var landingCostPerPiece = totalLandingCost / response['quantity'];
          $("#totalLandingCostPerPiece").val(landingCostPerPiece);

          var landingCosts = JSON.parse(response['landingCost']);
          $.each(landingCosts, function(key, value) {
              var $element = $("#" + key);
              if ($element.length) {
                  $element.val(addCommasToNumber(value));
              } else {
                  console.warn("Element with ID '" + key + "' not found.");
              }
          });
        }
        else
        {
          $("#landingCostDiv").hide();
          $("#toggleLandingCost").prop("checked", false);
        }
      }
    })
  });
  function addCommasToNumber(number) 
  {
    var roundedNumber = Number(number).toFixed(2);
    var parts = roundedNumber.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
  }
  function hide_modal()
  {
    $("#add_expense_modal").addClass('slideOutRight');
    $(".expense_content").addClass('slideOutRight');
    setTimeout(function () {
      $("#add_expense_modal").removeClass('slideOutRight');
      $("#add_expense_modal").hide();
      $(".expense_content").removeClass('slideOutRight');
      $(".expense_content").hide();
    }, 100);
    $("#searchInput").focus();
  }
  function getLandingCostValues() 
  {
      const inputs = document.querySelectorAll('.landingCost');
      const landingCostTotals = document.querySelectorAll('.landingCostTotal');
      const valuesObject = {};
      inputs.forEach(input => {
          valuesObject[input.id] = input.value;
      });

      landingCostTotals.forEach(input => {
        const cleanedValue = input.value.replace(/,/g, '');
        const numericValue = parseFloat(cleanedValue);

        valuesObject[input.id] = numericValue;
      });
      
      return valuesObject;
  }
  $("#expense_form").on("submit", function(e){
    e.preventDefault();
    var errorCount = $('#expense_form td.form-error').length;
    if(errorCount === 0)
    {
      var formData = new FormData(this);
      var landingCostValues = getLandingCostValues();
      formData.append('landingCostValues', JSON.stringify(landingCostValues));
      var expense = $("#item_name").val();
      var total_amount = $("#total_amount").val();
      var invoice_number = $("#invoice_number").val();
      var expense_id = $("#expense_id").val();
      $.ajax({
        type: 'POST',
        url: 'api.php?action=save_expense',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response)
        {
          $('table td').removeClass('form-error'); 
          if (!response.success) {
            var errors = "";
              $.each(response.errors, function(key, error) {
                if(key === "qty")
                {
                  $('#' + key + '').addClass("form-error");
                }
                else if(key === "image_url")
                {
                  $('#' + key + '').addClass("form-error");
                }
                else{
                  $('#' + key + '').closest("td").addClass("form-error");
                } 
                errors += "<li>"+error+"</li>"
              });
              $("#expense_errorMessages").html(errors)
          } else {
            $("#expense_form")[0].reset();
            $("#isProductIDExist").val("0");
            $("table td").removeClass('form-error');
            show_sweetReponse(response.message);
            hide_modal();
            show_allExpenses();

            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 

            if(expense_id !== "" && expense_id !== "0")
            {
              insertLogs('Expense', "Updated expense: "+expense + ", Amount: "+total_amount + ", Invoice#: "+invoice_number)
            }
            else
            {
              insertLogs('Expense', "Created expense: "+expense + ", Amount: "+total_amount + ", Invoice#: "+invoice_number)
            }

          }
        },
        error: function(e){
          console.log("server error.")
        }
      })
    }
  })
  $(".continue_deleteExpense").off("click").on("click", function(){
    $.ajax({
      type: 'get',
      url: "api.php?action=delete_expenseById",
      data: {
        expense_id: $("#remove_expense_id").val(),
      },
      success: function(response)
      {
        if(response.success)
        {
          var info = response.info;
          $("#remove_expense_id").val("");
          $('#delete_expenseConfirmation').hide();
          show_sweetReponse(response.message);
          show_allExpenses();
          var userInfo = JSON.parse(localStorage.getItem('userInfo'));
          var firstName = userInfo.firstName;
          var lastName = userInfo.lastName;
          var cid = userInfo.userId;
          var role_id = userInfo.roleId; 

          var item_name = info['item_name'] === "" ? info['product'] : info['item_name'];
          insertLogs('Expense', "Deleted Expense: "+item_name+ " Invoice #: "+info['invoice_number'] + " Amount: "+info['total_amount'])
        }
      },
      error: function(response){
        console.log("Error");
      }
    })
  })
  function show_sweetReponse(message) 
  {
    toastr.options = {
      "onShown": function () {
        $('.custom-toast').css({
          "opacity": 1,
          "width": "fit-content",
          "text-align": "center",
          "border": "2px solid #1E1C11",
        });
      },
      "closeButton": true,
      "positionClass": "toast-top-right",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "progressBar": true,
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut",
      "tapToDismiss": false,
      "toastClass": "custom-toast",
      "onclick": function () {  }

    };
    toastr.success(message);
  }
})
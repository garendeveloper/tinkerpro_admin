    var perPage = 25;
    let inventoryCurrentPage = 1;
    const inventoryPageSize = 300;

    var selected_products = [];
    var isSaving = false;
    var lastInputTime = 0; 
    var productsCache = [];
    var toastDisplayed =false;
    $("#tbl_orders").hide();

    show_allSuppliers();
    show_purchaseOrderNo();
    display_datePurchased();

    show_allInventories();
    $("#btn_openOption").attr('title', 'Click this to open option').tooltip();
    $("#btn_openOption").tooltip({
        open: function(event, ui) {
            $('body').css('background-color', '#262626'); 
        },
        close: function(event, ui) {
            $('body').css('background-color', '#262626'); 
        }
    }).tooltip("open");
    $("#btn_openOption").trigger('mouseenter');

    $(document).ready(function () {
    
        $('.container-scroller').click(function(event) {
          if ($(event.target).is('#optionModal')) {
              $('#optionModal').fadeOut();
          }
      });
      
        $("#inventory").addClass('active');
        $("#inventories").addClass('active');
        $("#pointer").html("Inventory");
        $(".otherinput").css('border', '1px solid white')
        $(".tablinks").click(function (e) {
          e.preventDefault();
          var tabId = $(this).data("tab");
          if (validateUnpaidSettings()) {
            $(".tabcontent").hide();
            $("#" + tabId).show();
            $(".tablinks").removeClass("active");
            $(this).addClass("active");
          }
        });
        $("#tab1").show();
        $(".tablinks[data-tab='tab1']").addClass("active");
        $('#paidSwitch').change(function () {
          if ($(this).is(':checked')) {
            $('.toggle-switch-container').css('color', '#28a745');
            $('#paidSwitch').css('background-color', '#28a745');
          }
          else {
            $('.toggle-switch-container').css('color', '');
            $('#paidSwitch').css('background-color', '');
          }
        });
        
        $('#s_due').datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: 'M dd y',
          altFormat: 'M dd y',
          altField: '#s_due',
          minDate: 0,
          onSelect: function (dateText, inst) { }
        });
  
  
        $('#calendar-btn2').on('click',function () {
          $('#s_due').datepicker('show');
        });
  
        $('#date_paid').datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: 'M dd y',
          altFormat: 'M dd y',
          altField: '#date_paid',
          minDate: 0,
          onSelect: function (dateText, inst) { }
        });
  
  
        $('#calendar-btn3').click(function () {
          $('#date_paid').datepicker('show');
        });
      });

      document.addEventListener('DOMContentLoaded', function () {
        var price_ids = ['price', 's_price', 'p_qty', 'u_qty', 'u_pay', 'loan_amount', 'interest_rate', 'loan_term'];
        price_ids.forEach(function (id) {
          var element = document.getElementById(id);
          if (element) {
            element.addEventListener('input', function (event) {
              this.value = this.value.replace(/[^0-9.]/g, '');
              let parts = this.value.split('.');
              if (parts[1] && parts[1].length > 2) {
                parts[1] = parts[1].slice(0, 2);
                this.value = parts.join('.');
              }
            });
          }
        });
      });
      function show_allInventories()
      {
        $.ajax({
              url: './pagination_data/inventory-pagination.php', 
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
      function show_allStocks()
      {
        $.ajax({
              url: './pagination_data/stocks-pagination.php', 
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
      function show_allOrders()
      {
        $.ajax({
              url: './pagination_data/orders-pagination.php', 
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
      function show_allInventoryCounts()
      {
        $.ajax({
              url: './pagination_data/inventoryCount-pagination.php', 
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
      function show_allLossAndDamagesInfo()
      {
        $.ajax({
              url: './pagination_data/lossanddamages-pagination.php', 
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
      function show_expiredProducts()
      {
        $.ajax({
              url: './pagination_data/expirations-pagination.php', 
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
      

      $("#clear_inventory_search").on("click", function(){
        $("#searchInput").val("");
        $("#searchInput").focus();
        $('#searchInput').keypress();
      })
      function progress_bar_process(response,percentage, timer)
      {
        $('.progressText').text(percentage + '%');
        if(percentage == 100)
        {
          percentage = 0;
          clearInterval(timer);
          $('#modalCashPrint').hide();
          var percentage = 0;
          
          var newBlob = new Blob([response], { type: 'application/pdf' });
          var blobURL = URL.createObjectURL(newBlob);

          var newWindow = window.open(blobURL, '_blank');
          if (newWindow) {
            newWindow.onload = function () {
              newWindow.print();
              newWindow.focus();
            };
          } 
        }
      }
      $("#printThis").on("click", function () {
       
        var active_tbl_id = $(".inventoryCard table").attr('id');
    
        if (active_tbl_id !== 'tbl_all_inventoryCounts' && active_tbl_id !== 'tbl_all_stocks') {
          $(".progressText").text('0%');
          $('#modalCashPrint').show();
          $.ajax({
            url: './reports/generate_inventory_pdf.php',
            type: 'GET',
            xhrFields: {
              responseType: 'blob'
            },
         
            data: {
              active_type: active_tbl_id,
            },
            success: function (response) {
              var percentage = 0;
              var timer = setInterval(function(){
              percentage = percentage + 20;
              if(percentage == 100)
              {
                percentage = 100;
              }
              progress_bar_process(response, percentage, timer);
              }, 100);
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            },
           
        
          });
        }
        else {
          var message = "Unfortunately, there are no download features available for this table.";
          show_errorResponse(message)
        }

      })
      $('#generateEXCELBtn').click(function () {
        var active_tbl_id = $(".inventoryCard table").attr('id');
  
        if (active_tbl_id !== 'tbl_all_inventoryCounts' && active_tbl_id !== 'tbl_all_stocks') 
        {
          $(".progressText").text('0%');
          $('#modalCashPrint').show();
          var fileName = active_tbl_id.replace("tbl_", "");
          $.ajax({
            url: './reports/generate_inventory_excel.php',
            type: 'GET',
            xhrFields: {
              responseType: 'blob'
            },
            data: {
              active_type: active_tbl_id,
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
        }
        else {
          var message = "Unfortunately, there are no download features available for this table.";
          show_errorResponse(message)
        }
      });
      $("#generatePDFBtn").on("click", function () {
        var active_tbl_id = $(".inventoryCard table").attr('id');
        if (active_tbl_id !== 'tbl_all_inventoryCounts' && active_tbl_id !== 'tbl_all_stocks') {
          $(".progressText").text('0%');
          $('#modalCashPrint').show();
          $.ajax({
            url: './reports/generate_inventory_pdf.php',
            type: 'GET',
            xhrFields: {
              responseType: 'blob'
            },
            data: {
              active_type: active_tbl_id,
            },
            success: function (response) {
              $('#modalCashPrint').hide();
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'inventory.pdf';
              document.body.appendChild(a);
              a.click();

              URL.revokeObjectURL(url);
              document.body.removeChild(a);
            },
            error: function (xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }
        else {
          var message = "Unfortunately, there are no download features available for this table.";
          show_errorResponse(message)
        }
      })
      $("#purchase-order").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allOrders();
        $("#tbl_products").hide();
      })
      $("#purchase_modal_payment_form").on("submit", function (e) {
        e.preventDefault();
        var rem_balance = $("#rem_balance").val();
        if (rem_balance !== "₱ 0.00") {
          var formData = $(this).serialize();
          $.ajax({
            type: 'post',
            url: 'api.php?action=save_orderPayments',
            data: formData,
            success: function (response) {
              if (response.status) {
                show_allPaymentHistory();
              }
            }
          })
        }
        else {
          console.log("");
        }
      })
      function show_allPaymentHistory() {
        var order_id = $("#payment_order_id").val();
        $.ajax({
          type: 'GET',
          url: 'api.php?action=get_orderPaymentHistory',
          data: {
            order_id: order_id,
          },
          success: function (data) {
            $("#next_payment").val("");
            $("#rem_balance").val("");
            $("#payment_totalPaid").html("");
            $("#payment_balance").html("");
            $("#tbl_paymentHistory tbody").html("");
            $("#total_toPay").html("");
            var tbl_history = "";
            var total_paid = 0;
            var total_balance = 0;
            if (data.length > 0) {
              if ($("#purchase_modal_payment").is(":visible")) {
                $("#order_payment_setting_id").val(data[0].order_payment_setting_id);
                var installment = data[data.length - 1].order_balance !== "0.00" ? data[0].installment : 0;
                var balance = data[data.length - 1].order_balance !== "0.00" ? data[0].order_balance : 0;
                $("#next_payment").val("₱ " + addCommasToNumber(installment))
                $("#rem_balance").val("₱ " + addCommasToNumber(balance));
                $("#total_toPay").html("(" + "₱ " + addCommasToNumber(data[0].with_interest) + ")");
                for (var i = 0; i < data.length; i++) {
                  tbl_history += "<tr>";
                  tbl_history += "<td style = 'text-align: center'>" + date_format(data[i].date_paid) + "</td>";
                  tbl_history += "<td style = 'text-align: right'>₱ " + addCommasToNumber(data[i].payment) + "</td>";
                  tbl_history += "<td style = 'text-align: right'>₱ " + addCommasToNumber(data[i].order_balance) + "</td>";
                  tbl_history += "</tr>";
                  total_paid += parseFloat(data[i].payment);
                  total_balance += parseFloat(data[i].order_balance);
                }
                total_balance = balance === 0 ? "0.00" : total_balance;
                $("#payment_totalPaid").html("₱ " + addCommasToNumber(total_paid));
                $("#payment_balance").html("₱ " + addCommasToNumber(total_balance))
                $("#tbl_paymentHistory tbody").html(tbl_history);
              }
            }
          }
        });
      }
      $("#inventory-count").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allInventoryCounts();
      })
      $("#expiration").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_expiredProducts();
      })
      $("#loss-damage").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allLossAndDamagesInfo();
      })
      $("#stocks").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allStocks();
      })
      $("#inventories").on('click', function () {
        $(".grid-container button").removeClass('active');
        $(this).addClass('active');
        show_allInventories();
      })
      $("#btn_refreshStockHistory").on("click",  function(e){
        e.preventDefault();
        var id = $("#stockhistory_modal #inventory_id").val();
        display_allStocksData(id);
      })
      function display_allStocksData(id)
      {
        $('#modalCashPrint').show();
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_allStocksData',
          data: { 
            inventory_id: id
          },
          success: function (data) {
            $('#modalCashPrint').hide();
            var info = data.inventoryInfo;
            var stocks = data.stocks;
            var tbl_rows = [];
            $("#stockhistory_modal").fadeIn('show');
            $("#stockhistory_modal").find(".modal-title").html("<span style = 'font-weight: bold' class = 'text-custom'> "+info.prod_desc + "</span>&nbsp; - STOCK HISTORY")
            var tbl_rows = [];

            var stock_reference = info.product_stock > 0 ? "<span style = 'color: #90EE90'>" + info.product_stock + "</span>" : "<span style = 'color: #FFCCCC'>" + info.product_stock + "</span>";
            var new_stock = stocks.length !== 0 ? stock_reference : "0.00";

            for (var i = 0, len = stocks.length; i < len; i++) 
            {
              var stockItem = stocks[i];
              var stockDate = $.datepicker.formatDate("dd M yy", new Date(stockItem.stock_date));
              var stockTimestamp = stockItem.stock_date;
              var stock = stockItem.stock > 0 ? "<span style = 'color: #90EE90'>" + stockItem.stock + "</span>" : "<span style = 'color: #FFCCCC'>" + stockItem.stock + "</span>";

              tbl_rows.push(
                `<tr>
                  <td style = 'text-align: left;  font-size: 12px; font-weight: bold'>${stockItem.transaction_type}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.document_number}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockItem.stock_customer}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockDate}</td>
                  <td style = 'text-align: center;  font-size: 12px; font-weight: bold'>${stockTimestamp}</td>
                  <td style = 'text-align: right;  font-size: 12px; font-weight: bold'>${stockItem.stock_qty}</td>
                  <td style = 'text-align: right; font-size: 12px; font-weight: bold'>${stock}</td>
              </tr>`
              );
            }
            var tfoot = `<tr>
                  <td style = 'text-align: left;  font-size: 12px; font-weight: bold' colspan ='6'>Remaining Stock</td>
                  <td style = 'text-align: right; font-size: 12px; font-weight: bold; color: #ccc' >${new_stock}</td>
              </tr>`;

            $("#tbl_stocks_history tbody").html(tbl_rows);
            $("#tbl_stocks_history tfoot").html(tfoot);
          }
        })
      }
      $(".inventoryCard").on("click", "#btn_openStockHistory", function () {
        var id = $(this).data('id');
        $("#start_date").val("");
        $("#end_date").val("");
        $("#stockhistory_modal #inventory_id").val(id);
        display_allStocksData(id);
      })
      $(".inventoryCard").on("dblclick", "tr", function(){

        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');


        var id = $(this).data('id');
        var active_tbl_id = $(".inventoryCard table").attr('id');
        switch(active_tbl_id)
        {
          case 'tbl_products':
            $(".purchase-grid-container button").removeClass('active');
            $("#btn_createPO").addClass('active');
            $("#expiration_div").hide();
            $("#received_div").hide()
            $("#quickinventory_div").hide();
            $("#stocktransfer_div").hide();
            $("#lossanddamage_div").hide();
            $("#inventorycount_div").hide();
            $("#purchaseItems_div").show();
            $("#po_form #product").focus();
            openOptionModal();
            $("#open_po_report").hide();
            $("#btn_omPayTerms").hide();
            $("#po_form #product").focus();

            $("#unpaid_identifier").val("0");
            $("#unpaid_order_id").val("0");
            $("#unpaid_purchase_modal .modal-content").css('height', '430px');
            $("#unpaid_purchase_modal #unpaid_toHide1").show();
            $("#unpaid_purchase_modal #unpaid_toHide2").show();

            $("#unpaid_purchase_modal #unpaid_hide1").show();
            $("#unpaid_purchase_modal #unpaid_hide2").show();
            $("#unpaid_purchase_modal #unpaid_hide3").show();
            $("#unpaid_purchase_modal #unpaid_hide4").hide();

            $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-printer"></i>&nbsp; Save & Print');
            show_allSuppliers();
            break;
          case 'tbl_all_stocks':
            $("#start_date").val("");
            $("#end_date").val("");
            $("#stockhistory_modal #inventory_id").val(id);
            display_allStocksData(id);
            break;
          case 'tbl_all_inventoryCounts':
            $(".scrollable").addClass('hasLockImage');
            $("#inventorycount_div").addClass('lock');
            $("#btn_savePO").addClass('lockButton');
            show_inventoryCountDetails(id);
            break;
          case 'tbl_all_lostanddamages':
            show_lossanddamage_details(id);
            break;
          case 'tbl_orders':
            var to_received = $(this).data('to_receive');
            var po_number = $(this).data('po_number');
            if(to_received === 1)
            {
              $(".scrollable").addClass('hasLockImage');
              $("#purchaseItems_div").addClass('lock');
              $("#btn_savePO").addClass('lockButton');
            }
            if(to_received === 0)
            {
              openOptionModal();
              openReceivedItems();
              $("#r_PONumbers").val(po_number);
              $("#btn_searchPO").click();
            }
            else
            {
              orderdata(id, to_received);
            }
            break;
          default:
            break;
        }
       
      })

      $(".inventoryCard").off("click").on("click", "#btn_delete_lossanddamage", function(){
        var id = $(this).data('id');
        var reference = $(this).data('reference_no');
        $("#response_ld_id").val(id);
        $("#response_ld_reference").val(reference);
        var po_title = '<h6>Are you sure you want to delete the <i style="color: #FF6700">LOSS AND DAMAGE WITH REFERENCE: '+reference+'</i>?</h6>';
        po_title += '<h6>This action cannot be undone!</h6>';
        $("#lossanddamage_response .ld_title").html(po_title);
        $("#lossanddamage_response").slideDown({
          backdrop: 'static',
          keyboard: false,
        });
      });
      $("#ld_btn_continue").off("click").on("click", function(){
        var id = $("#response_ld_id").val();
        var reference_no = $("#response_ld_reference").val();
        $.ajax({
          type: 'get',
          url: 'api.php?action=delete_lossanddamage',
          data: {
            id: id,
            reference_no: reference_no,
            user: $("#first_name").val()+" "+$("#last_name").val(),
          },
          success: function(response){
            if(response.success)
            {
              show_allLossAndDamagesInfo();
              show_sweetReponse(response.message);
              $("#lossanddamage_response").hide();
            }
            else{
              show_errorResponse("Unable to delete the item.")
            }
          },
          error: function(error)
          {
            console.log("Server error!");
          }
        })
      });

      function show_lossanddamage_details(id)
      {
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_lostanddamage_data',
          data: {
            id: id,
          },
          success: function (data) {
            var infoData = data.info;
            var ld_data = data.data;
            var tbody = $("#tbl_lossand_damages tbody");
            $("#ld_reference").val(infoData['reference_no']);
            $("#lossDamageInfoID").val(infoData['id']);
            $("#date_damage").val(date_format(infoData['date_transact']));
            $("#ld_reason").val(infoData['reason']);
            $("#footer_lossand_damages #total_qty").html(infoData['total_qty']);
            $("#footer_lossand_damages #total_cost").html("₱ " + infoData['total_cost']);
            $("#footer_lossand_damages #overall_total_cost").html("₱ " + infoData['over_all_total_cost']);
            $("#loss_and_damage_note").val(infoData['note']);
            var rows = [];
            for (var i = 0; i < ld_data.length; i++) {
              var inventory = ld_data[i];
              var row = "<tr data-id=" + inventory.inventory_id + " data-ld_id = "+inventory.loss_and_damage_id+">";
              row += "<td data-id = "+inventory.inventory_id+" style = 'width: 40%'>" + inventory.prod_desc + "</td>";
              row += "<td style='text-align:center; width: 15%'><input placeholder='QTY' style = 'text-align:center; width: 50px; height: 20px; font-size: 12px;' id = 'qty_damage' value = "+inventory.qty_damage+" ></input></td>";
              row += "<td style='text-align:right; width: 15%' id = 'cost' class='editable' data-id=" + data['cost'] + ">₱ " + addCommasToNumber(inventory.cost) + "</td>";
              row += "<td style='text-align:right; width: 15%' id = 'total_row_cost'>₱ " + addCommasToNumber(inventory.total_cost) + "</td>";
              rows.push(row);
            }
            tbody.html(rows.join(''));
          }
        })
        // $("#loss_and_damage_input").attr('disabled', true);
        // $("#btn_searchLDProduct").attr('disabled', true);
        $("#stocktransfer_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide()
        $("#expiration_div").hide()
        $("#lossanddamage_div").show();
        $(".purchase-grid-container button").removeClass('active');
        $("#btn_lossDamage").addClass('active');
        $("#purchaseItems_div").hide();
        $("#inventorycount_div").hide();
        $("#open_po_report").show();
        // $("#btn_savePO").attr("disabled", true);
        $("#btn_omPayTerms").hide();
        // $("#btn_omCancel").attr("disabled", true);
        $("#lossanddamage_form").find('input').removeClass('has-error');
        openOptionModal();
      }
      $(".inventoryCard").on('click', "#btn_view_lossanddamage", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        show_lossanddamage_details(id);
      })
      function show_inventoryCountDetails(id)
      {

        $("#printcount_modal").find("#inv_id").val(id);
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_inventoryCountDataById',
          data: {
            id: id,
          },
          success: function (data) {
            var infoData = data.info;
            var inventoryData = data.data;
            var tbody = $("#tbl_inventory_count tbody");
            $("#ic_reference").val(infoData['reference_no']);
            $("#inventory_count_info_id").val(infoData.id);
            $("#date_counted").val(date_format(infoData['date_counted']));

            var rows = [];
            for (var i = 0; i < inventoryData.length; i++) 
            {
              var inventory = inventoryData[i];
              var row = "<tr data-id=" + inventory.inventory_id + " data-ic_id = " + inventory.inventory_count_item_id + ">";
              row += "<td data-id=" + inventory.inventory_id + " style = 'width: 50%'>" + inventory.prod_desc + "</td>";
              row += "<td style='text-align:center' style = 'width: 20%'>" + inventory.counted_qty + "</td>";
              row += "<td class='text-right' style = 'width: 50px'><input placeholder='QTY' id = 'counted' style='text-align:center; width: 60px; height: 20px; font-size: 12px;' class='counted-input toLock' value = " + inventory.counted + " ></input></td>";
              var difference = inventory.difference;
              var differenceDisplay = difference > 0 ? "+" + difference : difference;
              row += "<td style='text-align: right; width: 50px'>" + differenceDisplay + "</td>";
              row += "</tr>";
              rows.push(row);
            }
            tbody.html(rows.join(''));
         
            $("#stocktransfer_div").hide();
            $("#received_div").hide()
            $("#quickinventory_div").hide()
            $("#expiration_div").hide()
            $("#lossanddamage_div").hide();
            $(".purchase-grid-container button").removeClass('active');
            $("#btn_inventoryCount").addClass('active');
            $("#purchaseItems_div").hide();
            $("#inventorycount_div").show();
            $("#open_po_report").show();
            $("#btn_omPayTerms").hide();
            $("#inventorycount_form").find('input').removeClass('has-error');
            openOptionModal();

          }
        })
      }
      $(".inventoryCard").on("click", "#btn_view_inventoryCount", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        show_inventoryCountDetails();
      })
      function display_datePurchased() 
      {
        var currentDate = new Date();
        var formattedDate = formatDate(currentDate);
        $('#date_purchased').val(formattedDate);
      }
      $('#date_purchased').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'M dd y',
        altFormat: 'M dd y',
        altField: '#date_purchased',
        onSelect: function (dateText, inst) { }
      });
      $('#calendar-btn').on('click', function (e) {
          e.preventDefault();
          $('#date_purchased').datepicker('show');
      });

      function formatDate(date) {
        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
          "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear().toString().substr(-2);
        return monthNames[monthIndex] + ' ' + (day < 10 ? '0' : '') + day + ' ' + year;
      }
      function show_purchaseOrderNo() {
        $("#pcs_no").val("10-000000001");
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_purchaseOrderNo',
          success: function (data) {
            $("#pcs_no").val(data);
          }
        })
      }
      function hideDropdownItems() {
        $('#tbl_purchaseOrders tbody tr').each(function () {
          var tableText = $(this).find('td').text();
          $('.search-dropdown-item').each(function () {
            if ($(this).text() === tableText) {
              $(this).hide();
            }
          });
        });
      }
      function resetPurchaseOrderForm() {
        show_purchaseOrderNo();
        display_datePurchased();
        $("#supplier").val("");
        $("#_order_id").val("0");
        $("#_inventory_id").val("0");
        $("#product").val("");
        $('#tbl_purchaseOrders tbody').empty();
        $("#po_form input[type=text], input[type=date]").removeClass('has-error');
      }
      $("#btn_omCancel").click(function () {
        resetPurchaseOrderForm();
      })
      var remove_inventories = [];
      $("#unpaid_form").on('submit', function (e) {
        e.preventDefault();
        var order_id = $("#_order_id").val();
        var identifier = $("#unpaid_identifier").val();
        var u_id = $("#unpaid_order_id").val(); 
        if(order_id > 0)
        {
          
          if (validateUPForUpdateForm()) 
          {
            $.ajax({
              type: 'POST',
              url: 'api.php?action=save_unpaidPaymentTerms',
              data: {
                unpaid_form: $("#unpaid_form").serialize(),
                order_id: order_id
              },
              success: function(response)
              {
                if(response.success)
                {
                  show_sweetReponse(response.message);
                  $("#unpaid_purchase_modal").hide();
                }
              },
              error: function(error){
                console.log("Error!")
              }
            })
          }
        } 
        else if(u_id > 0 && identifier > 0)
        {
          if (validateUPForUpdateForm()) 
          {
            $.ajax({
              type: 'POST',
              url: 'api.php?action=save_unpaidPayment',
              data: {
                unpaid_form: $("#unpaid_form").serialize(),
                order_id: order_id
              },
              success: function(response)
              {
                if(response.success)
                {
                  show_sweetReponse(response.message);
                  show_allOrders();
                  $("#unpaid_purchase_modal").hide();
                }
              },
              error: function(error){
                console.log("Error!")
              }
            })
          }
        }
        else
        {
          if (validateUPForUpdateForm()) {
            submit_purchaseOrder();
          }
        }
      })
      var isSavingPO = false;
      var totalPO = 0;
      let validationID;
      function submit_purchaseOrder() {
        totalPO =  $("#overallTotal").text();
        if (isSavingPO) return;
        var tbl_length = $("#tbl_purchaseOrders tbody tr").length;
        if (tbl_length > 0) {
          isSavingPO = true;
          var dataArray = [];
          $('#modalCashPrint').show();
          $('#tbl_purchaseOrders tbody tr').each(function () {
            var rowData = {};
            $(this).find('td').each(function (index, cell) {
              if (index === 0) {
                rowData['product_id'] = $(cell).data('id');
                rowData['inventory_id'] = $(cell).data('inv_id');
              }
              rowData['column_' + (index + 1)] = $(cell).text();
            });
            dataArray.push(rowData);
          });
          var isPaid = $('#paidSwitch').prop('checked') ? 1 : 0; 
          validationID =   $("#_order_id").val();
          $.ajax({
            type: 'POST',
            url: 'api.php?action=save_purchaseOrder',
            data: {
              data: JSON.stringify(dataArray),
              po_number: $("#pcs_no").val(),
              isPaid: isPaid,
              date_purchased: $("#date_purchased").val(),
              supplier: $("#supplier").val(),
              product: $("#product").val(),
              total: $("#overallTotal").text(),
              totalPrice: $("#totalPrice").text(),
              totalTax: $("#totalTax").text(),
              totalQty: $("#totalQty").text(),
              order_id: $("#_order_id").val(),
              inventory_id: $("#_inventory_id").val(),
              remove_inventories: remove_inventories,
              unpaid_form: $("#unpaid_form").serialize(),
              amortization_frequency_text: $("#amortization_frequency option:selected").text(),
            },
            dataType: 'json',
            success: function (response) {
              isSavingPO = false;
              if (response.status) 
              {
                $('#modalCashPrint').hide();
                var order_id = response.order_id;
                var po_number = response.po_number;
                resetPurchaseOrderForm();
                $("#paid_purchase_modal").hide();
                $("#unpaid_form")[0].reset();
                $("#unpaid_purchase_modal").hide();
                $("#totalTax").html("0.00");
                $("#totalQty").html("0");
                $("#totalPrice").html("&#x20B1;&nbsp;0.00");
                $("#overallTotal").html("&#x20B1;&nbsp;0.00");
                $('#show_purchasePrintModal').show()
                var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                var firstName = userInfo.firstName;
                var lastName = userInfo.lastName;
                var cid = userInfo.userId;
                var role_id = userInfo.roleId; 
                if(validationID > 0){
                  insertLogs('P.O Updated',firstName + ' ' + lastName + ' '+ 'P.0 #' + ' ' + po_number + ' ' + 'Amount:'+  totalPO)
                }else{
                  insertLogs('P.O Created',firstName + ' ' + lastName + ' '+ 'P.0 #' + ' ' + po_number + ' ' + 'Amount:'+  totalPO) 
                }
          
                if($('#show_purchasePrintModal').is(":visible"))
                {
                
                    var loadingImage = document.getElementById("loadingImage");
                    loadingImage.removeAttribute("hidden");
                    var pdfFile= document.getElementById("pdfFile");
                    pdfFile.setAttribute('hidden',true);
                    $.ajax({
                        url: './toprint/purchaseorder_print.php',
                        type: 'GET',
                        xhrFields: {
                            responseType: 'blob'
                        },
                        data: {
                            order_id: order_id,
                            po_number: po_number,
                        },
                        success: function(response) {
                          loadingImage.setAttribute("hidden",true);
                          var pdfFile = document.getElementById("pdfFile");
                          pdfFile.removeAttribute('hidden')
                          if( loadingImage.hasAttribute('hidden')) {
                              var newBlob = new Blob([response], { type: 'application/pdf' });
                              var blobURL = URL.createObjectURL(newBlob);
                              
                              $('#pdfViewer').attr('src', blobURL);
                          }
                        
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
                show_sweetReponse(response.message);
                show_purchaseOrderNo();
                show_allSuppliers();
                display_datePurchased();
                show_allReceivedItems_PurchaseOrders();
                hideModals();
                $(".inventoryCard").html("");
                $(".grid-container button").removeClass('active');
                $("#purchase-order").addClass('active');
                show_allOrders();
              }
              else {
                $.each(response.errors, function (key, value) {
                  if (key === "isPaid") {
                    $("#" + key).addClass('switch-error');
                  }
                  else {
                    $('#' + key).addClass('has-error');
                  }
                });
              }
            },
            error: function (xhr, status, error) {
              alert("Something went wrong!");
            }
          });
        }
        else {
          show_errorResponse("The table should not be empty.")
        }
      }
      function show_allReceivedItems_PurchaseOrders() {
        $.ajax({
          type: 'GET',
          url: 'api.php?action=get_allPurchaseOrders',
          success: function (data) {
            var po_numbers = [];
            for (var i = 0; i < data.length; i++) {
              po_numbers.push(data[i].po_number);
            }
            $("#r_PONumbers").autocomplete({
              source: function (request, response) {
                var term = request.term.toLowerCase();
                var array = po_numbers.filter(function (row) {
                  return row.includes(term);
                });
                response(array.map(function (row) {
                  return {
                    label: row,
                    value: row,
                  };
                }));
              },
              select: function (event, ui) {
                var selectedItem = ui.value;
                return false;
              }
            });
          }
        });
      }
      $("#receive_form").on("submit", function(e){
           e.preventDefault();
            var po_number = $("#").val();
            if (po_number !== '') {
                if(po_number !== ""){
                    show_orders(po_number);
                    $("#receive_form #po_data_div").show();
                } else {
                    $("#receive_form #po_data_div").hide();
                    $("#receive_form #tbl_receivedItems tbody").empty();
                }
            } else {
                $("#po_data_div").hide();
            }
        });
      $("#received_payment_confirmation #btn_paidClose, #btn_paidCancel").click(function () {
        $("#received_payment_confirmation").hide();
      })
      function show_response(message) {
        var modal = $("#response_modal");
        $("#response_modal").slideDown({
          backdrop: 'static',
          keyboard: false,
        });
        $("#r_message").html("<i class = 'bi bi-check-circle-fill'></i>&nbsp;" + message);
        setTimeout(function () {
          $("#response_modal").slideUp();
        }, 3000);
      }
      function validateTableSubRowInputs(table_id) {
        var isValid = true;
        $('#' + table_id + ' tbody tr.sub-row input').each(function () {
          if (!$(this).val().trim()) {
            isValid = false;
            $(this).addClass('has-error');
          } else {
            $(this).removeClass('has-error');
          }
        });
        return isValid;
      }
      function validateTableInputs(table_id) {
        var isValid = true;
        $('#' + table_id + ' tbody tr:not(.sub-row) input').each(function () {
          if ($(this).attr('id') === 'date_expired') {
            return; 
          }
          if (!$(this).val().trim()) {
            isValid = false;
            $(this).addClass('has-error');
          } else {
            $(this).removeClass('has-error');
          }
        });
        return isValid;
      }

      function validate_loss_and_damage_form() {
        var isValid = true;
        $('#lossanddamage_form  input[type=date]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }

      function validate_inventorycount_form() {
        var isValid = true;
        $('#inventorycount_form input[type=text], input[type=date]').each(function () {
          if ($(this).val() === '' || $(this).val().trim() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }
      function show_reference_no() {
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_loss_and_damage_latest_reference_no',
          success: function (data) {
            $("#ld_reference").val(data);
          }
        })
      }
      function show_inventory_count_reference_no() {
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_inventorycount_latest_reference_no',
          success: function (data) {
            $("#ic_reference").val(data);
          }
        })
      }
      function show_expiration() {
        $.ajax({
          type: 'get',
          url: 'api.php?action=get_expirationNotification',
          success: function (data) {
            $("#tbl_expirationItems tbody").find("input[type=checkbox]").prop("checked", false);
            for (var i = 0; i < data.length; i++) {
              switch (data[i].notify_before) {
                case 30:
                  if (data[i].is_active === 1) {
                    $("#first_expiration").prop("checked", true);
                  }
                  break;
                case 15:
                  if (data[i].is_active === 1) {
                    $("#second_expiration").prop("checked", true);
                  }
                  break;
                case 5:
                  if (data[i].is_active === 1) {
                    $("#third_expiration").prop("checked", true);
                  }
                  break;
                case 0:
                  if (data[i].is_active === 1) {
                    $("#fourth_expiration").prop("checked", true);
                  }
                  break;
                default:
                  break;
              }
            }
          }
        })
      }
      function show_sweetReponse(message) {
        toastr.options = {
          "onShown": function () {
            $('.custom-toast').css({
              "opacity": 1,
              "width": "600px",
              "text-align": "center",
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
      function show_errorResponse(message) {
        if (toastDisplayed) {
                return; 
            }

        toastDisplayed = true; 

        toastr.options = {
          "onShown": function () {
            $('.custom-toast').css({
              "opacity": 1,
              "width": "600px",
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
        toastr.error(message);
      }

      $("#btn_savePO").off("click").on("click", function (e) {
        e.preventDefault();
   
        var activeModuleId = $("button.active").attr('id');
        if (activeModuleId === "btn_expiration") {
          $('#modalCashPrint').show();
          var tbl_data = [];
          $("#tbl_expirationItems tbody tr").each(function () {
            var row_data = {};
            var notify_before = $(this).find("td:nth-child(2)").text();
            row_data['label'] = notify_before;
            row_data['value'] = $(this).find("input[type=checkbox]").prop("checked");
            tbl_data.push(row_data);
          })
          $.ajax({
            type: 'post',
            url: 'api.php?action=save_expirationNotification',
            data: { notifications: JSON.stringify(tbl_data) },
            success: function (response) {
              if (response.status) 
              {
                show_sweetReponse(response.msg);
                hideModals();
                $(".inventoryCard").html("");
                $(".grid-container button").removeClass('active');
                $("#expiration").addClass('active');
                show_expiration();
                show_expiredProducts();

                var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                var firstName = userInfo.firstName;
                var lastName = userInfo.lastName;
                var cid = userInfo.userId;
                var role_id = userInfo.roleId; 

                insertLogs('Expiration', "Updated inventory expiration settings");

                $('#modalCashPrint').hide();
              }
            }
          })
        }
        if (activeModuleId === "btn_quickInventory") {
          var rowCount = $("#tbl_quickInventories tbody tr").length;
          if(rowCount > 0)
          {
            if(validateTableInputs("tbl_quickInventories"))
            {
              $('#modalCashPrint').show();
              var formData = $("#quickinventory_form").serialize();
              var tbl_data = [];
              $("#tbl_quickInventories tbody tr").each(function () {
                var rowData = {};
                rowData['inventory_id'] = $(this).data('id');
                $(this).find("td").each(function (index, cell) {
                  if (index === 2)
                    rowData['newqty'] = $(cell).find("#qty").val();
                  rowData['col_' + (index + 1)] = $(cell).text();
                })
                tbl_data.push(rowData);
              })
          
              $.ajax({
                type: 'POST',
                url: 'api.php?action=save_quickInventory',
                data: {
                  tbl_data: JSON.stringify(tbl_data),
                  user_name: $("#first_name").val()+" "+$("#last_name").val(),
                },
                success: function (response) {
                  if (response.status) 
                  {
                    show_sweetReponse(response.msg);
                    var po_number = $("#q_product").val();
                    $("#tbl_quickInventories tbody").empty();
                    hideModals();

                    $(".inventoryCard").html("");
                    $(".grid-container button").removeClass('active');
                    $("#stocks").addClass('active');
                    show_allStocks();

                    var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                    var firstName = userInfo.firstName;
                    var lastName = userInfo.lastName;
                    var cid = userInfo.userId;
                    var role_id = userInfo.roleId; 

                    $.each(tbl_data, function(index, item){
                      insertLogs('Quick Inventory', "Quick inventory: "+item.col_1 + " From: "+item.col_2 + " To: "+item.newqty);
                    })
                    $('#modalCashPrint').hide();
                  }
                }
              })
            }
          }
          else
          {
            $("#q_product").addClass('has-error');
            $("select[name='inventory_type']").addClass('has-error');
          }
        }
        if (activeModuleId === "btn_inventoryCount") {
          var rowCount = $("#tbl_inventory_count tbody tr").length;
          if(rowCount > 0)
          {
            if(validateTableInputs("tbl_inventory_count"))
            {
              $('#modalCashPrint').show();
              var tbl_data = [];
              $("#tbl_inventory_count tbody tr").each(function () {
                var rowData = {};
                rowData['inventory_id'] = $(this).data('id');
                rowData['inventory_count_item_id'] = $(this).data('ic_id');
                rowData['qty'] = $(this).find("td:nth-child(2)").text();
                rowData['counted'] = $(this).find("#counted").val();
                rowData['difference'] = $(this).find("td:nth-child(4)").text();

                tbl_data.push(rowData);
              });
              var reference_no = $("#ic_reference").val();
              var date_counted = $("#date_counted").val();
              $.ajax({
                type: 'post',
                url: 'api.php?action=save_inventory_count',
                data: {
                  tbl_data: JSON.stringify(tbl_data),
                  reference_no: $("#ic_reference").val(),
                  date_counted: $("#date_counted").val(),
                  refer_id: $("#inventory_count_info_id").val(),
                  user_name: $("#first_name").val()+" "+$("#last_name").val(),
                },
                success: function (response) {
                  if (response.status) {
                    show_sweetReponse(response.msg);
                    $("#tbl_inventory_count tbody").empty();
                    $("#inventorycount_form")[0].reset();
                    show_inventory_count_reference_no();
                    hideModals();

                    $(".inventoryCard").html("");
                    $(".grid-container button").removeClass('active');
                    $("#inventory-count").addClass('active');
                    show_allInventoryCounts();

                    var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                    var firstName = userInfo.firstName;
                    var lastName = userInfo.lastName;
                    var cid = userInfo.userId;
                    var role_id = userInfo.roleId; 
                    
                    insertLogs('Inventory Count', "Successfully inventory count with reference #: "+reference_no + " Date: "+date_counted);
                    $('#modalCashPrint').hide();
                  }
                }
              })
            }
          }
          else
          {
            if (validate_inventorycount_form()) {
              var inventory_type = $("#qi_inventory_type").val();
              if (inventory_type !== "") {
                validateTableInputs("tbl_inventory_count")
              }
              else {
                $("#qi_inventory_type").css('border', '1px solid red');
              }
            }
          }
        }
        if (activeModuleId === "btn_lossDamage") {
          var loss_and_damage_length = $("#tbl_lossand_damages tbody tr:not(.sub-row)").length;
          if (validate_loss_and_damage_form()) {
            if (loss_and_damage_length > 0) {
              $('#modalCashPrint').show();
              var table_id = "tbl_lossand_damages";
              var loss_and_damage_form = $("#lossanddamage_form").serialize();
              if (validateTableInputs(table_id)) {
                var tbl_data = [];
                var subRowData = [];
                $("#tbl_lossand_damages tbody tr:not(.sub-row)").each(function () {
                  var row_data = {};
                  row_data['inventory_id'] = $(this).data('id');
                  row_data['damageID'] = $(this).data('ld_id');
                  $(this).find("td").each(function (index, cell) {
                    if (index === 1) {
                      row_data['qty_damage'] = $(cell).find("#qty_damage").val();
                    }
                    row_data['col_' + (index + 1)] = $(cell).text();
                  })
                  tbl_data.push(row_data);
                })
                $("#tbl_lossand_damages tbody .sub-row").each(function () {
                  var row_data = {};
                  row_data['inventory_id'] = $(this).data('id');
                  $(this).find("td").each(function (index, cell) {
                    row_data['is_serialCheck'] = $(cell).find("#serial_ischeck").prop('checked');
                    row_data['serial_number'] = $(cell).find("#serial_number").val();
                    row_data['serial_id'] = $(cell).data('id');
                  })
                  subRowData.push(row_data);
                })

                var reference = $("#ld_reference").val();
                var date_damage = $("#date_damage").val();
                var total_qty = $("#footer_lossand_damages thead").find("#total_qty").text();
                var total_cost = $("#footer_lossand_damages thead").find("#total_cost").text();
                var overall_total_cost = $("#footer_lossand_damages thead").find("#overall_total_cost").text();
                $.ajax({
                  type: 'post',
                  url: 'api.php?action=save_loss_and_damage',
                  data: {
                    tbl_data: JSON.stringify(tbl_data),
                    sub_row_data: JSON.stringify(subRowData),
                    note: $("#loss_and_damage_note").val(),
                    total_qty: total_qty,
                    total_cost: total_cost,
                    over_all_total_cost: overall_total_cost,
                    loss_and_damage_form: loss_and_damage_form,
                    user_name: $("#first_name").val()+" "+$("#last_name").val(),
                  },
                  success: function (response) {
                    if (response.status) {
                      show_sweetReponse(response.msg);
                      $("#lossanddamage_form")[0].reset();
                      $("#tbl_lossand_damages tbody").empty();
                      $("#footer_lossand_damages thead").find("#total_qty").html("0");
                      $("#footer_lossand_damages thead").find("#total_cost").html("₱ 0.00");
                      $("#footer_lossand_damages thead").find("#overall_total_cost").html("₱ 0.00");
                      $("#loss_and_damage_note").val("");
                      show_reference_no();
                      hideModals();

                      $(".inventoryCard").html("");
                      $(".grid-container button").removeClass('active');
                      $("#loss-damage").addClass('active');
                      show_allLossAndDamagesInfo();

                      var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                      var firstName = userInfo.firstName;
                      var lastName = userInfo.lastName;
                      var cid = userInfo.userId;
                      var role_id = userInfo.roleId; 

                      insertLogs('Loss and Damages', "Declared loss and damages with reference #: "+reference + " Date: "+date_damage + " Total Amount"+overall_total_cost);
                      $('#modalCashPrint').hide();
                    }
                  }
                })
              }
            }
            else {
              show_errorResponse("Please add a product");
            }
          }
        }
        if (activeModuleId === "btn_receiveItems") {
          var table_id = "tbl_receivedItems";
          var received_items_length = $("#tbl_receivedItems tbody tr").length;
          if (received_items_length > 0) {
            if (validateTableInputs(table_id)) {
              $('#modalCashPrint').show();
                if (isSaving) return;
                isSaving = true;
                var tbl_data = [];
                var subRowData = [];
                $("#tbl_receivedItems tbody tr:not(.sub-row)").each(function () {
                  var rowData = {};
                  rowData['isSelected'] = $(this).find("#receive_item").prop("checked");
                  rowData['inventory_id'] = $(this).data('id');
                  rowData['isSerialized'] = $(this).find("#check_isSerialized").hasClass('checked');
                  rowData['qty_received'] = $(this).find("td:nth-child(4)").text();
                  rowData['date_expired'] = $(this).find("td:nth-child(5)").text();
                  tbl_data.push(rowData);
                })
                $('#tbl_receivedItems tbody .sub-row').each(function () {
                  var rowData = {};
                  rowData.inventory_id = $(this).data('id');
                  rowData.serial_number = $(this).find('input').val();
                  rowData.serial_id = $(this).find("#serial_id").data('id');
                  subRowData.push(rowData);
                });
                var receive_form = $("#receive_all").serialize();
                var po_number = $("#r_po_number").text();
                var supplier = $("#r_supplier").text();
        
                
                $.ajax({
                  type: 'POST',
                  url: 'api.php?action=save_receivedItems',
                  data: {
                    tbl_data: JSON.stringify(tbl_data),
                    receive_form: receive_form,
                    subRowData: JSON.stringify(subRowData),
                    po_number: $("#r_po_number").text(),
                    supplier: $("#r_supplier").text(),
                    is_received: $("#is_received").val(),
                    isPaid: $("#order_isPaid").val(),
                    user_name: $("#first_name").val()+" "+$("#last_name").val(),
                  },
                  success: function (response) {

                    if (response.status)
                    {
                      show_sweetReponse(response.msg);
                      $('#modalCashPrint').hide();
                      $("#r_PONumbers").val("");
                      $("#is_received").val("0");
                      $("#tbL_receivedItems tbody").empty();
                      $("#po_data_div").hide();
                      $("#received_payment_confirmation").hide();
                      show_allReceivedItems_PurchaseOrders();
                      $("#purchase-order").addClass('active');
                      show_allOrders();
                      isSaving = false;
                      hideModals();

                      var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                      var firstName = userInfo.firstName;
                      var lastName = userInfo.lastName;
                      var cid = userInfo.userId;
                      var role_id = userInfo.roleId; 

                      insertLogs('Received Items', "Tender received items, PO Number: "+po_number+" Supplier: "+supplier);
                    }
                  },
                  error: function (error) {
                    console.log("server error!")
                  }
                })
              // })
            }
          }
          else {
            show_errorResponse("Please find a purchase number first!");
          }
        }
        if (activeModuleId === "btn_createPO")
        {
          var tbl_poL = $("#po_body tr").length;
          if (tbl_poL > 0) {
        
            var order_id = $("#_order_id").val();
            if (order_id > 0) {
              submit_purchaseOrder();
            }
            else {
              if ($("#paidSwitch").prop("checked") === false) {
                $("#unpaid_purchase_modal").fadeIn("200")
                var amount = clean_number($("#overallTotal").text());
                amount = amount.replace(/,/g, '');
                $("#unpaid_term").focus();
                $("#unpaid_form")[0].reset();
                $("#unpaid_note").val("");
                $("#unpaid_amount").val(amount);
                $("#unpaid_amount").attr("max", amount);
                $("#unpaid_amount").on("input", function() {
                    var enteredValue = $(this).val().replace(/,/g, '');
                    if (parseFloat(enteredValue) > parseFloat(amount)) {
                      $(this).val(amount);
                    }
                });
                
              }
              else {
                submit_purchaseOrder();
              }
            }
          }
          else if (tbl_poL === 0 && validatePOForm()) {
            show_errorResponse("Kindly add a product to your cart to proceed with the purchase.");
          }
          else {
            validatePOForm();
          }
        }
      })
    
      function roundToTwoDecimalPlaces(number) {
        return parseFloat(number).toFixed(2);
      }
      function validatePOForm() {
        var isValid = true;
        $('#po_form input[type=text], #po_form input[type=date]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }
      function validateUPForm()
      {
          var isValid = true;
          $('#unpaid_form input[type=text], #unpaid_form input[type=number], #unpaid_form input[type=date]').each(function () {
              if ($(this).val().trim() === '') { 
                  isValid = false;
                  $(this).addClass('has-error');
              }
          });

          return isValid;
      }
      function validateUPForUpdateForm()
      {
          var isValid = true;
          $('#unpaid_form input[type=text]:visible, #unpaid_form input[type=number]:visible, #unpaid_form input[type=date]:visible').each(function () {
              if ($(this).val().trim() === '') { 
                  isValid = false;
                  $(this).addClass('has-error');
              }
          });

          return isValid;
      }
      function validatePOForm() {
        var isValid = true;
        $('#po_form input[type=text], input[type=date]').each(function () {
          if ($(this).val() === '') {
            isValid = false;
            $(this).addClass('has-error');
          }
          else {
            $(this).removeClass('has-error');
          }
        });

        return isValid;
      }

      function addCommasToNumber(number) {
        var roundedNumber = Number(number).toFixed(2);
        var parts = roundedNumber.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
      }
      $("#btn_pqtyClose, #btn_pqtyCancel").on('click', function (e) {
        e.preventDefault();
        $("#purchaseQty_modal").hide();
        $("#unpaid_purchase_modal").hide();
      })
      $("#btn_paidClose, #btn_paidCancel").on('click', function (e) {
        e.preventDefault();
        $("#paid_purchase_modal").hide();
      })
      $("#btn_pqtyCancel").click(function () {
        $("#prod_form")[0].reset();
      })
      $("#paginationDropdown").change(function () {
        perPage = $(this).val();
        show_allInventories();
      })
      // var i_quantities = ['#p_qty', '#u_qty'];

      // i_quantities.forEach(function (id) {
      //   $(id).on('input', function (e) {
      //     var inputValue = $(this).val();
      //     inputValue = inputValue.replace(/\D/g, '');
      //     $(this).val(inputValue);
      //   });
      // });
      
      $('#po_form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
          type: "POST",
          url: "api.php?action=save_purchaseOrder",
          data: formData,
          success: function (response) {
            $.each(response.errors, function (key, value) {
              $('#' + key).addClass('has-error');
            });
          }
        });
      });
      function show_allSuppliers() {
        $.ajax({
          type: 'GET',
          url: 'api.php?action=get_allSuppliers',
          success: function (data) {
            var options = "";
            for (var i = 0; i < data.length; i++) {
              options += "<option>"+data[i].supplier+"</option>";
            }
           $("#supplier").html(options);
            $("#supplier option:first").attr('selected', 'selected');
          }
        })
      }
      

      var finish = 0;
     
      
      function date_format(date) 
      {
        var date = new Date(date);
        var formattedDate = $.datepicker.formatDate("M dd yy", date);
        return formattedDate;
      }
        $(".inventoryCard").on("click", "#btn_removeOrder", function(e){
          e.preventDefault();
          var is_received = $(this).data('isreceived');
          var order_id = $(this).data("id");
          var isPaid = $(this).data("ispaid");
        
          var po_number = $(this).data("po_number");
          if(isPaid === 1)
          {
            var po_title = '<h6 style = "color: #FF9999; font-weight: bold">Sorry, the <i style = "color: red">PURCHASE ORDER</i> cannot be removed; the order may have already been received or paid.</h6>';
            $("#purchaseOrder_response .po_title").html(po_title);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
                var firstName = userInfo.firstName;
                var lastName = userInfo.lastName;
                var cid = userInfo.userId;
                var role_id = userInfo.roleId; 
              
              
                insertLogs('Denied','Tries to delete' + ' ' + 'P.O order id #:' + ' ' + po_number )
                
            $("#purchaseOrder_response").slideDown({
              backdrop: 'static',
              keyboard: false,
            });
            $("#response_order_id").val("0");
            $("#po_btn_continue").hide();
          }
          else
          {
            var po_title = '<h6>Are you sure you want to delete the <i style="color: #FF6700">PURCHASE ORDER</i>?</h6>';
            po_title += '<h6>This action cannot be undone!</h6>';
            $("#purchaseOrder_response .po_title").html(po_title);
            $("#purchaseOrder_response").slideDown({
              backdrop: 'static',
              keyboard: false,
            });
            $("#response_order_id").val(order_id);
            $("#po_btn_continue").show();
          }
        })
      $("#po_btn_continue").on("click", function(){
        $.ajax({
            type: 'get',
            url: 'api.php?action=delete_purchaseOrder',
            data: {
                id: $("#response_order_id").val(),
            },
            success: function(response){
      
                if(response.status)
                {
                  $("#purchaseOrder_response").hide();
                  $("#response_order_id").val("");
                  show_sweetReponse(response.message);
                  show_allOrders();
                  show_allReceivedItems_PurchaseOrders();
                }
            },
            error: function(response)
            {
                console.log("Server Error:")
            }
        })
      })
     
     
      function maskPONumber(poNumber) 
      {
          if (poNumber.length > 10) 
          {
              var firstPart = poNumber.substring(0, 2);
              var middlePart = "XXXXXXX"; 
              var lastPart = poNumber.substring(poNumber.length - 3); 

              var maskedPO = firstPart + "-" + middlePart + lastPart; 
              return maskedPO; 
          } else {
              return poNumber; 
          }
      }
      function orderdata(order_id, to_received)
      {
        if(to_received === 0)
        {
          $(".scrollable").removeClass('hasLockImage');
          $("#purchaseItems_div").removeClass('lock');
          $("#btn_savePO").removeClass('lockButton');
        }
        $("#stocktransfer_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide()
        $("#expiration_div").hide()
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $(".purchase-grid-container button").removeClass('active');
        $("#btn_createPO").addClass('active');
        $("#purchaseItems_div").show();
        openOptionModal();
        $("#open_po_report").show();

        $.ajax({
          type: 'GET',
          url: 'api.php?action=get_orderData&order_id=' + order_id,
          dataType: 'json',
          success: function (data) {
            var table = "";
            var tbl_report = "";
            $("#supplier").val(data[0].supplier);
            $("#date_purchased").val(date_format(data[0].date_purchased));
            $("#_order_id").val(data[0].order_id);
            $("#_inventory_id").val(data[0].inventory_id);
            $("#pcs_no").val(data[0].po_number);

            $("#rep_po").html(data[0].po_number);
            $("#rep_supplier").html(data[0].supplier);
            $("#rep_datePurchased").html(date_format(data[0].date_purchased));
            var isPaid = data[0].isPaid === 1 ? "Yes" : "No";
            $("#rep_isPaid").html(isPaid);

            if (isPaid === "Yes") {
              $("#btn_omPayTerms").hide();
              $("#paidSwitch").css('background-color', 'green');
              $('#paidSwitch').prop('checked', true).prop('disabled', true);
            }
            else {
              $("#btn_omPayTerms").show();
              $("#paidSwitch").css('background-color', '#ffff');
              $('#paidSwitch').prop('checked', false).prop('disabled', true);
            
              $("#unpaid_identifier").val("0");
              $("#unpaid_order_id").val("0");
              $("#unpaid_purchase_modal .modal-content").css('height', '380px');
              $("#unpaid_purchase_modal #unpaid_toHide1").hide();
              $("#unpaid_purchase_modal #unpaid_toHide2").hide();

              $("#unpaid_purchase_modal #unpaid_hide1").show();
              $("#unpaid_purchase_modal #unpaid_hide2").show();
              $("#unpaid_purchase_modal #unpaid_hide3").show();
              $("#unpaid_purchase_modal #unpaid_hide4").hide();

              $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-arrow-clockwise"></i>&nbsp; Update');

              var orderData = data[0];
              
              orderData.isNotification === 1 ? $("#notification_unpaid").prop('checked', true) : $("#notification_unpaid").prop('checked', false);
              orderData.isReccurring === 1 ? $("#reccurring_unpaid").prop('checked', true) : $("#reccurring_unpaid").prop('checked', false);
              $("#unpaid_amount").val(orderData.unpaid_amount);
              $("#unpaid_term").val(orderData.term);
              $("#unpaid_dueDate").val(orderData.due_date);
              $("#unpaid_note").val(orderData.note);
            }
            
            for (var i = 0; i < data.length; i++) 
            {
              var qty_purchased = to_received === 1 ? data[i].qty_received : data[i].qty_purchased; 
              table += "<tr data-rowid = "+data[i].product_id+" id = 'show_pqtymodal'>";
              table += "<td style = 'width: 55%'  data-rowid = "+data[i].product_id+" data-id = " + data[i].product_id + " data-inv_id = " + data[i].inventory_id + ">" + data[i].prod_desc + " </td>";
              table += "<td style = 'text-align: center; width: 10%;' class ='editable' data-qty = "+data[i].qty_purchased+" data-price= "+data[i].amount_beforeTax+">" + qty_purchased + "</td>";
              table += "<td style = 'text-align: right; width: 10%;' class ='editable'>&#x20B1;&nbsp;" + addCommasToNumber(data[i].amount_beforeTax) + "</td>";
              table += "<td style = 'text-align: right; width: 10%;'>&#x20B1;&nbsp;" + addCommasToNumber(data[i].total) + "</td>";
              table += "<td style = 'text-align: right; width: 10%;'><i class = 'bi bi-trash' id = 'removeOrder'></i></td>";
              table += "</tr>";
            }
            var counter = 1;
            for (var i = 0; i < data.length; i++) {
              tbl_report += "<tr>";
              tbl_report += "<td >" + counter + "</td>";
              tbl_report += "<td >" + data[i].prod_desc + "</td>";
              tbl_report += "<td style = 'text-align: center' >" + data[i].qty_purchased + "</td>";
              tbl_report += "<td style = 'text-align: right' >&#x20B1;&nbsp;" + addCommasToNumber(data[i].amount_beforeTax) + "</td>";
              tbl_report += "<td style = 'text-align: right'>&#x20B1;&nbsp;" + data[i].tax + "</td>";
              tbl_report += "<td style = 'text-align: right'>&#x20B1;&nbsp;" + data[i].total + "</td>";
              tbl_report += "<td style = 'text-align: right; width: 0px;'></td>";
              tbl_report += "</tr>";
              counter++;
            }
            $("#tbl_purchaseOrders tbody").html(table);
            $("#tbl_purchaseOrdersReport tbody").html(tbl_report);
            $("#rep_qty").html(data[0].totalQty);
            $("#rep_price").html("&#x20B1;&nbsp;" + addCommasToNumber(roundToTwoDecimalPlaces(data[0].totalPrice)));
            $("#rep_tax").html("Tax: " + roundToTwoDecimalPlaces(data[0].totalTax));
            $("#rep_total").html("&#x20B1;&nbsp;" + addCommasToNumber(roundToTwoDecimalPlaces(data[0].price)));

            $("#totalTax").html("Tax: " + roundToTwoDecimalPlaces(data[0].totalTax));
            $("#totalQty").html(data[0].totalQty);
            $("#totalPrice").html("&#x20B1;&nbsp;" + addCommasToNumber(roundToTwoDecimalPlaces(data[0].totalPrice)));
            $("#overallTotal").html("&#x20B1;&nbsp;" + addCommasToNumber(data[0].price));
          },
          error: function (data) {
           console.log("Error!");
          }
        })
      }
      $(".inventoryCard").on('click', '#btn_editOrder', function (e) {
        e.preventDefault();
        var order_id = $(this).data('id');
        orderdata(order_id, 0);
      })
      $(".inventoryCard").on('click', '#btn_openUnpaidPayment', function (e) {
        e.preventDefault();
        var order_id = $(this).data('id');
        $("#unpaid_order_id").val(order_id);
        $("#unpaid_identifier").val("1");

        $.ajax({
          type: 'get',
          url: 'api.php?action=get_unpaid_transaction',
          data: {
            order_id: order_id,
          },
          success: function(response){
            var orderdata = response['orderData'];

            $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-save"></i>&nbsp; Save');

            $("#unpaid_purchase_modal .modal-content").css('height', '280px');
            $("#unpaid_purchase_modal #unpaid_toHide1").show();
            $("#unpaid_purchase_modal #unpaid_toHide2").show();

            $("#unpaid_purchase_modal #unpaid_hide1").hide();
            $("#unpaid_purchase_modal #unpaid_hide2").hide();
            $("#unpaid_purchase_modal #unpaid_hide3").hide();
            $("#unpaid_purchase_modal #unpaid_hide4").show();
            $("#unpaid_purchase_modal").slideDown({
              backdrop: 'static',
              keyboard: false,
            });
                
      
            var amount = orderdata['unpaid_amount'];
            amount = amount.replace(/,/g, '');
            $("#unpaid_amount").focus();
            $("#unpaid_note").val("");
            $("#unpaid_amount").val("");
            $("#unpaid_balance").val(amount);
            $("#unpaid_amount").attr("max", amount);
            $("#unpaid_amount").on("input", function() {
                var enteredValue = $(this).val().replace(/,/g, '');
                if (parseFloat(enteredValue) > parseFloat(amount)) {
                    $(this).val(amount);
                }
            });
          }
        })
      })

      function clean_number(number) {
        return number.replace(/[₱\s]/g, '');
      }

      function filterPO(barcode) {
        $('.search-dropdown-item').each(function () {
          var $row = $(this);
          var rowBarcode = $row.text().trim().toLowerCase();
          if (rowBarcode.includes(barcode)) {
            $row.show();
          }
          else {
            $row.hide();
          }
        });
      }
      function openReceivedItems()
      {
        $(".purchase-grid-container button").removeClass('active');
        $("#btn_receiveItems").addClass('active');
        $("#po_data_div").hide();
        $("#expiration_div").hide();
        $("#purchaseItems_div").hide();
        $("#received_div").show();
        $("#quickinventory_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#open_po_report").show();
        $("#receive_form #r_PONumbers").focus();
        $("#receive_form #r_PONumbers").val("");
        $("#btn_omPayTerms").hide();
        $("#btn_savePO").attr('disabled', false);
      }
      function hideModals() {
        $("#optionModal").addClass('slideOutRight');
        $(".optionmodal-content").addClass('slideOutRight');
        setTimeout(function () {
          $("#optionModal").removeClass('slideOutRight');
          $("#optionModal").hide();
          $(".optionmodal-content").removeClass('slideOutRight');
          $(".optionmodal-content").hide();
        }, 100);
      }
      $('#btn_minimizeModal').click(function () {
        $(".purchase-grid-container button").removeClass('active');
        hideModals();
        $("#searchInput").focus();
      });
      $("#product-form").on("submit", function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
      })
      function reset_poFooter()
      {
        $("#totalTax").html("Tax: 0.0");
        $("#totalQty").html("0.0");
        $("#totalPrice").html("0.0");
        $("#overallTotal").html("0.0");
      }
      $("#btn_openOption").click(function (e) {
        e.preventDefault();
        reset_poFooter();

        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $(".purchase-grid-container button").removeClass('active');
        $("#btn_createPO").addClass('active');
        $("#expiration_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide();
        $("#inventorycount_div").hide();
        $("#purchaseItems_div").show();
        $("#po_form #product").focus();
        openOptionModal();
        $("#open_po_report").hide();
        $("#btn_omPayTerms").hide();
        $("#po_form #product").focus();

        $("#unpaid_identifier").val("0");
        $("#unpaid_order_id").val("0");
        $("#unpaid_purchase_modal .modal-content").css('height', '430px');
        $("#unpaid_purchase_modal #unpaid_toHide1").show();
        $("#unpaid_purchase_modal #unpaid_toHide2").show();

        $("#unpaid_purchase_modal #unpaid_hide1").show();
        $("#unpaid_purchase_modal #unpaid_hide2").show();
        $("#unpaid_purchase_modal #unpaid_hide3").show();
        $("#unpaid_purchase_modal #unpaid_hide4").hide();

        $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-printer"></i>&nbsp; Save & Print');
        show_allSuppliers();
      })
      $("#btn_createPO").click(function (e) {
        e.preventDefault();
        reset_poFooter();

        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass('active');
        $("#expiration_div").hide();
        $("#received_div").hide()
        $("#quickinventory_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#purchaseItems_div").show();
        openOptionModal();
        $("#open_po_report").hide();
        $("#btn_omPayTerms").hide();
        $("#po_form #product").focus();

        $("#unpaid_identifier").val("0");
        $("#unpaid_order_id").val("0");
        $("#unpaid_purchase_modal .modal-content").css('height', '430px');
        $("#unpaid_purchase_modal #unpaid_toHide1").show();
        $("#unpaid_purchase_modal #unpaid_toHide2").show();

        $("#unpaid_purchase_modal #unpaid_hide1").show();
        $("#unpaid_purchase_modal #unpaid_hide2").show();
        $("#unpaid_purchase_modal #unpaid_hide3").show();
        $("#unpaid_purchase_modal #unpaid_hide4").hide();
        $("#btn_savePO").attr('disabled', false);
        $("#unpaid_purchase_modal #btn_saveUnpaid").html('<i class = "bi bi-printer"></i>&nbsp; Save & Print');
        show_allSuppliers();
      })
      $("#btn_receiveItems").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');
        openReceivedItems();
      })
      $("#btn_stockTransfer").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass('active');
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#quickinventory_div").hide();
        $("#expiration_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#stocktransfer_div").show();
      })
      $("#btn_expiration").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $("#open_po_report").hide();
        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass('active');
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#quickinventory_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#expiration_div").show();
        $("#btn_omPayTerms").hide();
        $("#btn_savePO").attr('disabled', false);
      })
      $("#btn_quickInventory").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass("active");
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#expiration_div").hide();
        $("#stocktransfer_div").hide();
        $("#lossanddamage_div").hide()
        $("#inventorycount_div").hide();
        $("#quickinventory_div").show();
        $("#quickinventory_form #q_product").focus();
        $("#btn_savePO").attr('disabled', false);
      })
      $("#btn_lossDamage").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $("#loss_and_damage_input").focus();
        $("#loss_and_damage_input").attr('disabled', false);
        $("#btn_searchLDProduct").attr('disabled', false);
        $("#lossanddamage_form")[0].reset();
        $("#lossDamageInfoID").val("");
        $("#footer_lossand_damages #total_qty").html("0");
        $("#footer_lossand_damages #total_cost").html("₱ 0.0");
        $("#footer_lossand_damages #overall_total_cost").html("₱ 0.0");
        $("#loss_and_damage_note").val("");
        show_reference_no();
        $("#tbl_lossand_damages tbody").empty();
        $("#btn_savePO").attr("disabled", false);
        $("#btn_omCancel").attr("disabled", false);
        $(".purchase-grid-container button").removeClass('active');
        $("#loss_and_damage_input").focus();
        $(this).addClass("active");
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#expiration_div").hide();
        $("#stocktransfer_div").hide();
        $("#quickinventory_div").hide();
        $("#inventorycount_div").hide();
        $("#lossanddamage_div").show();
        var currentDate = new Date();
        var formattedDate = formatDate(currentDate);
        $('#date_damage').datepicker('setDate', currentDate);
        $('#date_damage').val(formattedDate);
        $("#lossanddamage_form #loss_and_damage_input").focus();
        $("#btn_omPayTerms").hide();
        $("#btn_savePO").attr('disabled', false);
      })
      $("#btn_inventoryCount").click(function (e) {
        e.preventDefault();
        $(".scrollable").removeClass('hasLockImage');
        $("#inventorycount_div").removeClass('lock');
        $("#purchaseItems_div").removeClass('lock');
        $("#received_div").removeClass('lock');
        $("#btn_savePO").removeClass('lockButton');

        $("#btn_savePO").attr("disabled", false);
        $("#btn_omCancel").attr("disabled", false);
        $("#inventorycount_form")[0].reset();
        $("#inventory_count_info_id").val("");
        $("#qi_inventory_type").attr("disabled", false);
        $("#btn_go_inventory").attr("disabled", false);
        $("#tbl_inventory_count tbody").empty();
        var currentDate = new Date();
        var formattedDate = formatDate(currentDate);
        $('#date_counted').datepicker('setDate', currentDate);
        $('#date_counted').val(formattedDate);
        show_inventory_count_reference_no();
        $(".purchase-grid-container button").removeClass('active');
        $(this).addClass("active");
        $("#purchaseItems_div").hide();
        $("#received_div").hide();
        $("#expiration_div").hide();
        $("#stocktransfer_div").hide();
        $("#quickinventory_div").hide();
        $("#lossanddamage_div").hide();
        $("#inventorycount_div").show();
        $("#btn_omPayTerms").hide();
        $("#btn_savePO").attr('disabled', false);
      })
      function openOptionModal() {
        resetPurchaseOrderForm();
        $("#paidSwitch").css('background-color', 'green');
        $('#paidSwitch').prop('checked', true).prop('disabled', false);
        $("#optionModal").addClass('slideInRight');
        $(".optionmodal-content").addClass('slideInRight');
        setTimeout(function () {
          $("#optionModal").show();
          $(".optionmodal-content").show();
        }, 100);
        $("#po_form #product").focus();
        $("#btn_savePO").attr('disabled', false);
      }
      $(document).click(function(event) {
        var $target = $(event.target);

        if (!$target.closest('#optionModal, #btn_openOption, #purchaseQty_modal, #removeOrder, .removeItem, #show_purchasePrintModal, #unpaid_purchase_modal, .ui-autocomplete, .ui-autocomplete-input').length) {
            if ($('#optionModal').is(':visible')) {
                hideModals();
            }
        }
    });
 
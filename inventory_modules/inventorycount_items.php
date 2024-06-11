<style>
    tr:hover {
        background-color: #151515;
        cursor: pointer;
    }

    .group {
        display: inline-block;
        margin-right: 3px;
    }

    .custom-select {
        position: relative;
        display: inline-block;

    }

    .custom-select select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        padding-right: 25px;
        text-indent: 0.5em;
    }

    .custom-select i {
        position: absolute;
        top: 50%;
        right: 5px;
        transform: translateY(-50%);
    }

    #tbl_inventory_count tbody {
        font-size: 12px;
    }

    #tbl_inventory_count tbody {
        font-size: 12px;
    }

    #tbl_inventory_count thead th {
        border: none;
        color: #FF6900;
    }

    #tbl_inventory_count thead {
        border: 1px solid #FF6900;
    }

    #tbl_inventory_count tbody td {
        border: none;
    }
    #tbl_inventory_count td:nth-child(3){
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center
    }
    #btn_open_print_count_modal{
        background-color: #00b050
    }
    #btn_open_print_count_modal:hover{
        background-color: #046c04;
    }
</style>
<div class="fcontainer" id="inventorycount_div" style="display: none">
    <form id="inventorycount_form">
        <input type="hidden" id = "inventory_count_info_id" value = "">
        <div class="fieldContainer">
            <label>REF# </label>
            <input type="text" name="ref" id="ic_reference" name="ic_reference"
                style="width: 250px; height: 30px; font-size: 14px;" readonly>
            <div class="date-input-container">
                <input type="text" name="date_counted" value = "" oninput="$(this).removeClass('has-error')" id="date_counted"
                    style="height: 30px;  text-align: center" >
                <button id="btn_dateCounted" class="button" type="button" style="height: 30px;">
                    <i class="bi bi-calendar2" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="fieldContainer">
            <div class="group left-aligned">
                <div class="custom-select">
                    <select name="qi_inventory_type" id = "qi_inventory_type"
                        style=" background-color: #1E1C11; color: #ffff; width: 160px; border: 1px solid #ffff; font-size: 12px; height: 30px;">
                        <option value="0">Select inventory type</option>
                        <!-- <option value="1">B.O.M Inventory</option> -->
                        <option value="2">Product Inventory</option>
                    </select>
                    <i class="bi bi-chevron-double-down"></i>
                </div>
                <button style="font-size: 12px; height: 30px; border-radius: 4px;" id="btn_go_inventory">
                    DISPLAY ALL</button>
            </div>
            <div class="group right-aligned" style="display: flex; align-items: center;">
                <button style="font-size: 12px; height: 30px; border-radius: 4px; width: 200px; " id="btn_open_print_count_modal" type = "button">
                   <i class = "bi bi-printer"></i>&nbsp;&nbsp; Print Count Sheet</button>
            </div>
            
        </div>
        <div class="fieldContainer" style="margin-top: -3px;">
            <label><img src="assets/img/barcode.png" style="color: white; height: 50px; width: 40px;"></label>
            <div class="search-container">
                <input type="hidden" id="invc_product_id" value="0">
                <input type="text" style="width: 280px; height: 30px; font-size: 14px;"
                    class="search-input italic-placeholder" placeholder="Search Product [barcode,name,brand]"
                    name="invc_product" onkeyup="$(this).removeClass('has-error')" id="invc_product" autocomplete="off">
            </div>
            <button style="font-size: 12px; height: 30px; width: 120px; border: 1px solid #FF6900; border-radius: 5px;"
                id="btn_invcSearch">
                Search</button>
        </div>
    </form>
    <table id="tbl_inventory_count" class="text-color table-border" style=" margin-bottom: 30vh">
        <thead>
            <tr>
                <th style="background-color: #1E1C11; width: 50%">ITEM DESCRIPTION</th>
                <th style="background-color: #1E1C11; text-align:center">QTY</th>
                <th style="background-color: #1E1C11; text-align:center">COUNTED</th>
                <th style="background-color: #1E1C11; text-align:right">DIF.</th>
            </tr>
        </thead>
        <tbody style="border-collapse: collapse; border: none">

        </tbody>
    </table>
</div>

<?php include("./modals/print-counts-modal.php")?>
<script>
    $('#date_counted').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'M dd y',
        minDate: 0,
    });

    $(document).ready(function () {
        show_reference_no();
        show_allProducts();
        function show_reference_no() {
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_inventorycount_latest_reference_no',
                success: function (data) {
                    $("#ic_reference").val(data);
                }
            })
        }
        $("#btn_open_print_count_modal").on("click", function() {
            var type = $("#qi_inventory_type").val();
            if(type !== "")
            {
                $("#qi_inventory_type").removeClass('has-error');
                $("#printcount_modal").show();
            }
            {
                $("#qi_inventory_type").addClass('has-error');
            }
        });

        $(".close").click(function() {
            $("#printcount_modal").hide();
        });

        $(window).resize(function() {
            if ($(window).width() < 768) {
            $("#printcount_modal .modal-content").css("margin", "30% auto");
            } else {
            $("#printcount_modal.modal-content").css("margin", "15% auto");
            }
        });
  
       
        
        $("#qi_inventory_type").on("change", function(){
            $(this).css("border", "1px solid #ffff")
        })
        function clean_number(number) {
            return number.replace(/[₱\s]/g, '');
        }
        $('#btn_dateCounted').on('click', function (e) {
            e.preventDefault();
            $('#date_counted').datepicker('show');
        });
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // $("#btn_go_inventory").off().on("click", function (e) {
        //     e.preventDefault();
        //     var search_value = $("#qi_inventory_type").val();
        //     $("#inventory_count_info_id").val("");
        //     $('#modalCashPrint').show();
        //     $.ajax({
        //         type: 'get',
        //         url: 'api.php?action=get_allProductByInventoryType&type='+search_value,
        //         success: function (data) {
        //             $('#modalCashPrint').hide();
        //             var row = "";
        //             for(var i =0 ;i<data.length; i++)
        //             {
        //                 row += "<tr data-id = "+data[i].product_id+">";
        //                 row += "<td>" + data[i].prod_desc + "</td>";
        //                 row += "<td style = 'text-align:center'>"+data[i].product_stock+"</td>";
        //                 row += "<td class = 'text-center'><input placeholder='QTY' style = 'text-align:center; width: 60px; height: 20px; font-size: 12px;'  id = 'counted' value = ''></input></td>";
        //                 row += "<td style = 'text-align: right'></td>";
        //                 row += "</tr>";
        //             }
        //             $("#tbl_inventory_count tbody").html(row);
        //         }
        //     })
           
        // })
        $("#btn_invcSearch").on("click",function (e) {
            e.preventDefault();
            var inventory_id = $("#invc_product_id").val();
            if(inventory_id !== 0)
            {
                if ($("select[name='inventory_type']").val() === "") {
                    $("select[name='inventory_type']").css('border', '1px solid red');
                }
                else {
                    $("select[name='inventory_type']").css('border', '1px solid #ffff');
                    if (!isDataExistInTable(inventory_id)) 
                    {
                        display_productBy(inventory_id);
                    }
                    else
                    {
                        alert("Product is already in the table.")
                    }
                }
            }
        })
        var productsCache = [];
        function show_allProducts() 
        {
            $.ajax({
            type: 'GET',
            url: 'api.php?action=get_allProducts',
            success: function (data) {
                for (var i = 0; i < data.length; i++) 
                {
                    var row = 
                    {
                        product_id: data[i].id,
                        product: data[i].prod_desc,
                        barcode: data[i].barcode,
                        brand: data[i].brand,
                    };
                    productsCache.push(row);
                }
            }
            });
        }
        function filterProducts(term) {
            return productsCache.filter(function (row) {
            return row.product.toLowerCase().includes(term) ||
                row.barcode.includes(term) ||
                (row.brand && row.brand.toLowerCase().includes(term)) ||
                (!row.brand && term === "");
            }).map(function (row) {
            var brand = row.brand === null ? " " : row.brand;
            return {
                label: row.product + " (" + row.barcode + ")" + " (" + brand + ")",
                value: row.barcode ?? row.product,
                id: row.product_id
            };
            });
        }
        function show_errorResponse(message) {
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
            "onclick": function () { alert('Clicked'); }

            };
            toastr.error(message);
        }
        $("#invc_product").on("input", function(e) {
            var term = $(this).val();
            $(this).autocomplete('search', term);

        });

        $("#invc_product").autocomplete({
            minLength: 2,
            source: function (request, response) {
            var term = request.term;
            var filteredProducts = filterProducts(term);
            var slicedProducts = filteredProducts.slice(0, 5);
            response(slicedProducts);
            if (slicedProducts.length > 0) {
                $('#filters').show();
            } else {
                $('#filters').hide();
            }
            
            var slicedProductsLength = slicedProducts.length - 1;
            var selectedProductId = slicedProducts[slicedProductsLength].id;
                $("#invc_product_id").val(selectedProductId);
            },
            select: function (event, ui) {
                
                var selectedProductId = ui.item.id;
                $("#invc_product_id").val(selectedProductId);
                return false;
            },
        });
      $("#invc_product").on("input", function(e) {
        e.preventDefault();
          var term = $(this).val();
          $(this).autocomplete('search', term);
      });
      $("#invc_product").on("keypress", function(event){
        if(event.which === 13){
            var product_id = $("#invc_product_id").val();
      
          if (!isDataExistInTable(product_id)) {
            append_to_table(product_id);
          }
          else
          {
            show_errorResponse("Product already in the table")
          }
          $("#invc_product").val('');
        }
      
      })

      $("#invc_product").on("autocompletechange", function(event, ui) {
        var product_id = $("#invc_product_id").val();
        
        if (!isDataExistInTable(product_id)) {
            append_to_table();
        }
        else
        {
          show_errorResponse("Product already in the table");
        }
          $(this).val('');
      });
        function isDataExistInTable(data) {
            var $matchingRow = $('#tbl_inventory_count tbody td:first[data-id="' + data + '"]').closest('tr');
            
            if ($matchingRow.length > 0) {
                return true;
            }
            
            return false;
        }
       
        function append_to_table(product_id) 
        {
            $.ajax({
                type: 'get',
                url: 'api.php?action=get_productInfo',
                data: { data: product_id },
                success: function (data) {
                    var row = "";
                    row += "<tr data-id = " + data['id'] + ">";
                    row += "<td data-id = " + data['id'] + ">" + data['prod_desc'] + "</td>";
                    row += "<td style = 'text-align:center'>" + data['product_stock'] + "</td>";
                    row += "<td class = 'text-center'><input placeholder='QTY' class = 'italic-placeholder required' id = 'qty' style = 'width: 60px; text-align: center; height:20px;'></input></td>";
                    row += "</tr>";
                    $("#tbl_inventory_count tbody").append(row);
                }
            })
        }

        $("#tbl_inventory_count").on("input", "#counted", function (e) {
            e.preventDefault();
            $(this).removeClass('has-error');
            var counted = $(this).val();
            counted = parseFloat(counted);
            var stock = $(this).closest("tr").find("td:nth-child(2)").text();
            stock =parseFloat(stock);

            if(stock < 0)
            {
                var difference = stock + counted
                if(difference > 0) difference = "+"+difference;
                $(this).closest("tr").find("td:nth-child(4)").text(difference);
            }
            else
            {
                var difference = counted - stock;
                if(difference > 0) difference = "+"+difference;
                $(this).closest("tr").find("td:nth-child(4)").text(difference);
            }
        })
      
    })
</script>
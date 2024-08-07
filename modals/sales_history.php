

<div class="modal salesHistoryModal" id="salesHistoryModal" tabindex="0" style="background-color: rgba(0, 0, 0, 0.9)">
  <div class="modal-dialog modal-dialog-centered modal-xl" style="max-width: 80%; max-height: 80%;">
    <div class="modal-content">
      <div class="modal-body" style="background: #262626; color: #ffff; border-radius: 0;">
        
        <div class="d-flex">
            <h3 class="headTitle">E-JOURNAL <span class="spanUserName">[USER: <span id="user_Name">ADMIN</span>]</span> <span class="current_date">CURRENT DATE</span></h3>
            <div class="ml-auto"> 
                <button class="btn btn-secondary shadow-none closeBtnSalesHistory"><i class="bi bi-x"></i></button>
            </div>
        </div>

        <div class=" salesContent">
            <div class="row">
                <div class="col-lg-9 d-flex ps-0 pe-0">
                    <div  style="margin-right: 10px; color:#ffff; margin-top: -12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#ffff" class="bi bi-upc-scan" viewBox="0 0 16 16">
                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0z" />
                        </svg>
                    </div>
                    <div class="search_input_history" style="position: relative; width: 100%; margin-right: 10px">
                        <input type="text" id="search-sales" placeholder="Search customer/ tax no./ email/ phone/ loyalty card" class="form-control shadow-none" style="margin-right: 10px; border:none; border-radius: 0; font-style: italic">
                        <div id="customer-result" class="form-control shadow-none d-none"></div>
                    </div>
                    <div class="allUserSales me-2">
                        <input type="checkbox" id="all_user_sales" class="toggle-checkbox">
                        <label for="all_user_sales" data-toggle="tooltip" data-placement="top" title="Show all users" class="toggle-label"></label>
                    </div>
                    <select name="select_filter_doc_type" id="select_filter_doc_type" data-toggle="tooltip" data-placement="top" title="Filter Reports" class="custom_form_control shadow-none select_filter_doc_type">
                        <option value="SUCCESS">SUCCESS</option>
                        <option value="ALL">ALL</option>
                        <option value="REFUNDED">REFUNDED</option>
                        <option value="VOIDED">VOIDED</option>
                        <option value="RET&EX">RET&EX</option>
                    </select>
                </div>

                <div class="col-lg-3 ps-0 pe-0 d-flex">
                    <select name="select_filter" data-toggle="tooltip" data-placement="top" title="Filter Reports" id="select_filter" class="w-100 custom_form_control shadow-none select_filter">
                        <option value="TODAY">TODAY</option>
                        <option value="YESTERDAY">YESTERDAY</option>
                        <option value="THIS WEEK">THIS WEEK</option>
                        <option value="THIS MONTH">THIS MONTH</option>
                        <option value="THIS YEAR">THIS YEAR</option>
                        <option value="CUSTOM">CUSTOM</option>
                    </select>
                    <input class="dateRange" style="width: 300px; outline: none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                        <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                    </svg>
                </div>
            </div>

           
            <div class="d-flex sales_history" style="align-items: baseline;">
            <table style="width: 80%; margin-right: 10px; margin-top: 10px; border: none !important;" class="salesHistoryTable m-0 text-light">
                <thead>
                    <tr class="salesHistoryBorder" style="border: 1px solid transparent !important">
                        <th colspan="1">#</th>
                        <th colspan="2">Receipt No.</th>
                        <th colspan="2">Reference No.</th>
                        <th colspan="2">Document Type</th>
                        <th colspan="2">Date/Time</th>
                        <th colspan="2">User Name</th>
                        <th colspan="2">Type</th>
                        <th colspan="2">Amount</th>
                        <th colspan="2">Status</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>


                <div class="justify-content-end receipt_preview_history">
                    <div class="row" id="receipt_information">
                        <div class="col-12" style="text-align: center; font-size:small; background: #fff;">
                        <h6 style="font-weight: bold;">TinkerPro Store</h6> 
                        <label style="font-weight: bold;">Owned and Operated by:</label> 
                        <label style="font-weight: bold;">UNKNOWN</label> 
                        <label style="font-weight: bold;">GUN-OB LAPU-LAPU CITY, 6015</label> 
                        <label style="font-weight: bold;">VAR REG TIN: XXXX-XXX-XXXX-XXXX</label> 
                        <label style="font-weight: bold;">MIN: XXXXXXXXXXX</label> 
                        <label style="font-weight: bold;">S/N: XXXX-XXXX-XXXX-XXXX</label> 
                        <label>CN: 09981231232</label> 
                        <label style="font-weight: bold;" class="receipt_type">PREVIEW RECEIPT</label>
                        </div>    

                        <div class="col-12" style="font-size: small; padding-top: 15px; background: #fff;">
                        <div class="d-flex justify-content-center h5"><label style="font-weight: bold;">SALES INVOICE</label></div>
                        <div class="d-flex justify-content-center h6"><label style="font-weight: bold;" id="or_num_id">00000000</label></div>
                        <label class="transactionNo" >Trans #: <span class="Preview_transacNo">02312312</span></label>
                        <label>Terminal: <?php echo gethostname()?> </label> 
                        <label >Cashier: <span class="userNames"></span></label>
                        <label class="date_transac">Date: <span class="CurrentDate" id="CurrentDate">02/02/2024</span></label>
                        <label class="time_transac" >Time: <span id="CurrentTime">05:59:29pm</span> </label>
                        <label>Payer: <span class="Payer" id="Payer"></span></label>
                        <label class="cus_type">Customer Type: <span class="CustomerDisType"> Regular </span></label>
                    </div>

                    <div class="col-12" style="font-size: small; padding-top: 10px; background: #fff;">
                        <div class="row">
                            <label style="font-weight: bold">Item(s) <span style="float: right">Subtotal</span></label>
                            <hr class="new2">
                        
                            <div class="soldProduct" id="soldProduct">
                                <label class="orderProducts"><span style="float: right" class="subTotal_receipt">0.00</span></label>
                            </div>
                            
                            <hr class="new2">

                            <label class="itemQty">ITEM QTY <span style="float: right" class="TotalQty" id="TotalQty">0</span></label>
                            <label class="tAmount">AMOUNT <span style="float: right" class="TotalAmount" id="TotalAmount">0.00</span></label>
                            <label class="service_charges"><span style="float: right" class="srvc_charge" id="srvc_charge"></span></label>
                            <label class="reg_dis">REGULAR DISCOUNT <span style="float: right" id="CustomerDiscount">0.00</span></label>
                            <label class="cart_discount"><span style="float: right" id="cart_discounted"></span></label>
                            <label class="discount_item">ITEM(s) DISCOUNT <span style="float: right" id="ItemsDiscount">0.00</span></label>
                            <label class="totalPayment_preview" style="font-weight: bold">TOTAL <span style="float: right;" id="totalPayment_preview">0.00</span></label>

                            <label class="tendered" style="text-align: center">Tendered: </label>
                            <label class="payments" style="font-weight: bold" id="paymentMethod_text"><span style="float: right" id="PaidAmount"></span></label> 
                            <label class="payment_change" style="font-weight: bold">CHANGE <span style="float: right" id="ChangeAmount">0.00</span></label>  

                            <span class="totalRefund"></span>
                            <span class="dividerLine"></span>

                            <label>Total Discounts <span style="float: right" id="allDiscounts">&#8369; 0.00</span></label>
                            <label id="VatSales1">VAtable Sales(V) <span style="float: right">&#8369; 0.00</span></label>
                            <label id="VatAmount1">VAT Amount <span style="float: right" >&#8369; 0.00</span></label>
                            <label id="Vat_exempt_text">VAT Exempt <span style="float: right" >&#8369; 0.00</span></label>

                            <hr class="new2">

            
                            <label>Name: ? _____________________</label>
                            <label>TIN/ID/SC: ? _________________</label>
                            <label>Address: ? _________________________</label>
                            <label>Signature: ? ________________________</label>  <br>
                            <label class="barcode_text" style="text-align: center; font-weight: bold"></label>  <br>
                        </div>
                    </div>

                    <div class="col-12" style="text-align: center; font-size: small; background: #fff;">
                        <label>TinkerPro IT Solution</label> 
                        <label> Gun-ob, Lapu-Lapu City, Cebu</label> 
                        <label>Website: www.tinkerpro.com</label> 
                        <label>Mobile #: 09xxxxxxxxx</label> 
                        <label>TIN #: 0000000-000000</label>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
        <div class="row mt-2 me-1 row_button">
            <div class="col-lg-12 d-flex justify-content-between buttonActions">
                <div class="d-flex" style="display: flex; justify-content: flex-end;width: 100%">
                    <button style="width: 150px" class="btn btn-secondary shadow-none reprintBtn" style="align-items: right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt" viewBox="0 0 16 16">
                        <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27m.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0z"/>
                        <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5"/>
                    </svg>
                    PRINT</button>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
 
?>

<script>


var transactionNumber = 0;
var customerId = 0;
var payment_id = 0;
var refundedData = 0;
var reasonToVoid = '';
var reasonToVoidSlip = '';
var discoutnIds = 0;


var receipt_count = 0;
var isRefunded = false;
var isReturn  = false;
var isVoid = false;


var totalPayment = 0;
var totalChange = 0;

var calcuTotalPayment = 0;
var calcuTotalChange = 0;

var t_refund = 0;



function scrollToSelectedRow_sales() {
    var container_sales = $('.sales_history');
    var selectedRow_sales = $('.selectable-sales-row.selected');
    if (selectedRow_sales.length > 0) {
        container_sales.scrollTop(selectedRow_sales.offset().top - container_sales.offset().top + container_sales.scrollTop());
    }
}

function currentDate() {
  var d = new Date();
  var month = d.getMonth() + 1;
  var day = d.getDate();
  var hour = d.getHours();
  var minutes = d.getMinutes();
  var seconds = d.getSeconds(); 

  var output = (month < 10 ? '0' : '') + month + '-' +
    (day < 10 ? '0' : '') + day + '-' +
    d.getFullYear() + ' ' + hour + ':' +
    (minutes < 10 ? '0' : '') + minutes + ':' +
    (seconds < 10 ? '0' : '') + seconds; 
  return output;
}

$(document).ready(function() {

    getAllSalesHistory()
    $('#all_user_sales').off('change').on('change', function() {
        getAllSalesHistory();
    })

    $('#user_Name').text(localStorage.firstName)
    var selectedFilter = $("#select_filter").val();
    var currentDateObj = new Date(currentDate());
    var nextDayDate = new Date(currentDateObj);
    
    var ornum;
    var transactionToVoid;
    nextDayDate.setDate(nextDayDate.getDate() + 1);

    $(".dateRange").flatpickr({
        mode: "range",
        dateFormat: "m-d-Y",
        altInput: true,
        altFomart: "M j, Y",
        defaultDate: [currentDateObj, nextDayDate],
        onChange: function(selectedDates, dateStr, instance) {
            getAllSalesHistory();
        }
    });

    $('.reprintBtn').off('click').on('click',function() {
        var selectedDataHistory = $('.selectable-sales-row.selected');
        transactionNumber = selectedDataHistory.data('transaction');
        customerId = selectedDataHistory.data('userid');
        discoutnIds = selectedDataHistory.data('discid');
        paymentid = selectedDataHistory.data('paymentid');
        
        var voided = selectedDataHistory.data('voided');
        var refundedReceipt = selectedDataHistory.data('refunddata');
        var indicator_print = 0;
        var modalPrintLoad = $('#modalPrintLoadData');

    $('.salesHistoryModal').focus();
    var existingData = [];
    var existingDataRefund = [];
    var salesIndexRow = -1;
    var selectedDateRange = $(".dateRange").val();
    var selectedFilter = $("#select_filter").val();
    var selected_doc = $(".select_filter_doc_type").val();
    var selectedDates = selectedDateRange.split(" to ");
    var startDate = new Date(selectedDates[0]);
    var endDate = new Date(selectedDates[1]);

    var yesterDay = new Date (currentDate())
    var thisMonth = new Date(currentDate())
    var currentYear = new Date().getFullYear();

    var totalToBePaidSum = 0;
    var refundedAmoutn = 0;
    var totalReturn = 0;

    var all = selected_doc === 'ALL';
    var succ = selected_doc === 'SUCCESS';
    var refunded_doc = selected_doc === 'REFUNDED';
    var voided_doc = selected_doc === 'VOID';
    var testRow = document.querySelectorAll('.selectable-sales-row');
    var texts = [];
    var lastCell;
    function returnTextStat () {
        testRow.forEach(function(t_row) {
            var lastCell = t_row.querySelector('td:last-child');
            var text = lastCell.textContent.trim();
            
            texts.push(text);
        });
        return texts;
    }

    
    if (selectedFilter === 'TODAY') {
        startDate = dateAndTimeFormat(currentDate()).formatted_date;
        
        $('.dateRange').prop('disabled', true);
        $('.current_date').text(startDate);
    } else if (selectedFilter === 'YESTERDAY') {
        yesterDay.setDate(yesterDay.getDate() - 1);
        startDate = dateAndTimeFormat(yesterDay).formatted_date;
        $('.current_date').text(startDate);
        $('.dateRange').prop('disabled', true);
    } else if (selectedFilter === 'THIS WEEK') {
        Date.prototype.getWeek = function () {
            var dt = new Date(this.getFullYear(), 0, 1);
            return Math.ceil((((this - dt) / 86400000) + dt.getDay() + 1) / 7);
        };

        var thisWeek = new Date();
        var firstDayOfWeek = new Date(thisWeek);
        firstDayOfWeek.setDate(thisWeek.getDate() - thisWeek.getDay()); 

        var lastDayOfWeek = new Date(thisWeek);
        lastDayOfWeek.setDate(thisWeek.getDate() - thisWeek.getDay() + 6);

        startDate = dateAndTimeFormat(firstDayOfWeek).formatted_date;
        endDate = dateAndTimeFormat(lastDayOfWeek).formatted_date;
        $('.dateRange').prop('disabled', true);
        $('.current_date').text(startDate + ' to ' + endDate);
    } else if (selectedFilter === 'THIS MONTH') {
        thisMonth.setDate(thisMonth.getMonth());
        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        $('.dateRange').prop('disabled', true);
        var startDateString = dateAndTimeFormat(thisMonth).formatted_date;
        startDate = new Date(startDateString);
        startDate.setDate(startDate.getDate() - 1);
        startDate = dateAndTimeFormat(startDate).formatted_date
        endDate = dateAndTimeFormat(lastDay).formatted_date;
        $('.current_date').text(dateAndTimeFormat(startDate).formatted_date + ' to ' + dateAndTimeFormat(endDate).formatted_date);
    } else if (selectedFilter === 'THIS YEAR') {
        startDate = dateAndTimeFormat(new Date(currentYear, 0, 1)).formatted_date;
        endDate = dateAndTimeFormat(new Date(currentYear, 11, 31)).formatted_date;
        $('.dateRange').prop('disabled', true);
        $('.current_date').text(startDate + ' to ' + endDate);
    } else if (selectedFilter === 'CUSTOM') {
        $('.dateRange').prop('disabled', false);
        var startDate = new Date(selectedDates[0]);
        var endDate = new Date(selectedDates[1]);
        startDate = dateAndTimeFormat(new Date(selectedDates[0])).formatted_date
        endDate = dateAndTimeFormat(new Date(selectedDates[1])).formatted_date
        $('.current_date').text(dateAndTimeFormat(currentDate()).formatted_date);
    }

   var allUser = $('#all_user_sales').prop('checked') ? 1 : 0;
   var filteredSalesHistory = [];
axios.post('api.php?action=getSalesHistory', {
        'cashier_id': localStorage.userIds,
        'roleId': localStorage.roleIds,
        'allUsers': $('#all_user_sales').prop('checked') ? 1 : 0,
    })
    .then(function(response) {
        var salesHistory = response.data.data;
        var refundedData = response.data.data2;
        var returnProducts = response.data.returnProducts;
        var startingIndex = salesHistory.length;
        var pay_details = response.data.payments_details;
        var saleDate;
      

        $.each(salesHistory, function(index, sale) {
           
        
        if(selectedFilter === 'CUSTOM') {
            saleDate = dateAndTimeFormat(sale.date_time_of_payment).formatted_date;
        } else {
            saleDate = dateAndTimeFormat(sale.date_time_of_payment).formatted_date;
        }

        function getFilterTable(saleDate, startDate, endDate) {
            if(selectedFilter === 'TODAY' && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate == dateAndTimeFormat(startDate).formatted_date;
            } else if (selectedFilter == 'YESTERDAY' && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate == dateAndTimeFormat(startDate).formatted_date;
            } else if ((selectedFilter === 'THIS WEEK' || selectedFilter === 'THIS MONTH') && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate >= dateAndTimeFormat(startDate).formatted_date || saleDate <= dateAndTimeFormat(endDate).formatted_date; 
            }
            else if (selectedFilter === 'THIS YEAR' && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate >= dateAndTimeFormat(startDate).formatted_date || saleDate <= dateAndTimeFormat(endDate).formatted_date;
            }
             else if (selectedFilter === 'CUSTOM' && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate >= dateAndTimeFormat(startDate).formatted_date || saleDate <= dateAndTimeFormat(endDate).formatted_date;
            }
        }
        
        if (getFilterTable(saleDate, startDate, endDate) ) {
            displaySalesReport()
            $('#receiptCount').text(receipt_count)
        } else {
            totalPayment = 0;
            totalChange = 0;
            $('#receiptCount').text(receipt_count)
            $('#totalSalesHistory').text('₱' + parseFloat(totalPayment - totalChange).toFixed(2))
        }

        
        function displaySalesReport() {
            var descendingIndex = startingIndex - index;
            receipt_count = startingIndex;
            if (existingData.indexOf(sale.or_num) === -1) {

                var row = '<tr class="selectable-sales-row"' +
                    'data-transaction="' + sale.transaction_num + '" ' +
                    'data-refunddata="' + sale.is_refunded + '" ' +
                    'data-userid="' + sale.customer_id + '" ' +
                    'data-discid="' + sale.discount_id + '" ' +
                    'data-voided="' + sale.is_void + '" ' +
                    'data-reasons="' + sale.reason + '" ' +
                    'data-ornums="'+ (sale.barcode) + '" ' +
                    '>' +
                    '<td colspan="1">' + (descendingIndex) + '</td>' +
                    '<td colspan="2">' + (sale.barcode) + '</td>' +
                    '<td colspan="2">' + ' ' + '</td>' +
                    '<td colspan="2">' + 'Sale' + '</td>' +
                    '<td colspan="2">' + dateAndTimeFormat(sale.date_time_of_payment).formatted_date + " " + dateAndTimeFormat(sale.date_time_of_payment).formatted_time + '</td>';

                
                if (sale.temporary_name != null) {
                    row += '<td colspan="2">' + sale.temporary_name + '</td>';
                } else {
                    row += '<td colspan="2">' + sale.cashier + '</td>';
                }

                if (pay_details.find(function(pay) { return pay.id === sale.payment_id})) {
                    var getPayments = pay_details.filter(function(pay) { return pay.id === sale.payment_id });
                    var cartDiscounts = parseFloat(getPayments[0].cart_discount);

                    // var totalToBePay = parseFloat(sale.payment_amount) - parseFloat(cartDiscounts)
                    var totalToBePay = parseFloat(sale.payment_amount)
                    row += '<td colspan="2">' + sale.customer_type + '</td>' +
                    '<td colspan="2">' + addCommas(parseFloat(totalToBePay).toFixed(2)) + '</td>';
                }
                
                if (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0) {
                    row += '<td  style="color: lightgreen;">' + 'SUCCESS' + '</td>';
                } else if (sale.is_void == 2) {
                    row += '<td class="text-danger" >' + 'VOIDED' + '</td>';
                } else if (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; })) {
                    row += '<td class="text-warning" >' + 'REFUNDED' + '</td>';
                    var refToGet = refundedData.filter(function(ref) { return ref.or_num === sale.or_num; });
                    var allDetailsRefund = refToGet;
                    var refund_total = 0;
                    var totalAmountRefund = 0;
                    var getCartDiscount1 = 0;
                    var itemDiscountRef = 0;

                for(var i = 0; i < allDetailsRefund.length; i++) {
                    var refunded = JSON.parse(allDetailsRefund[i].otherDetails);
                    var cartDiscounteRef = parseFloat(refunded[0].cartRate)
                    getCartDiscount1 = parseFloat(allDetailsRefund[i].totalRefunded * cartDiscounteRef)
                    totalAmountRefund = allDetailsRefund[i].totalRefunded;
                    refundedAmoutn += ((parseFloat(totalAmountRefund - refunded[0].discount)) - getCartDiscount1 )- parseFloat(allDetailsRefund[i].itemDiscountsData)
                }

                } else if (sale.is_paid == 1 && sale.is_refunded == 2) {
                    row += '<td class="text-primary" >' + 'RET&EX' + '</td>';
                } else if (sale.is_paid == 1 && sale.is_refunded == 3) {
                    row += '<td style="color: pink" >' + 'RETURN' + '</td>';
                }

                
                if (sale.is_void != 2) {
                    totalToBePaidSum += parseFloat(sale.payment_amount);
                    if (pay_details.find(function(pay) { return pay.id === sale.payment_id})) {
                        var getPayments = pay_details.filter(function(pay) { return pay.id === sale.payment_id });
                        var cartDiscounts = parseFloat(getPayments[0].cart_discount);
                        // totalToBePaidSum -= cartDiscounts;
                    }
                }

               

                // row += '</tr>';
                // $('.salesHistoryTable tbody').append(row);

                
                if (sale.is_paid == 1 && sale.is_refunded == 1) {
                    var refunds = refundedData.filter(function(ref) { return ref.or_num === sale.or_num; });
                    refunds.sort(function(a, b) {
                        return a.refunded_date_time.localeCompare(b.refunded_date_time);
                    });
                    
                    refunds.forEach(function(refund) { 
                        var refundRow = '<tr class="selectable-sales-row"' +
                            'data-paymentid="'+ refund.payment_id +'"' + 
                            'data-references="'+ refund.reference_num +'"' +
                            '>' +
                            '<td class="color_text" colspan="1" style="font-size: large; padding: 0;text-align: center; ">' + '&#x21B3;' + '</td>' +
                            '<td class="color_text" colspan="2">' + refund.reference_num + '</td>' +
                            '<td class="color_text" colspan="2">' + 'RS-' +  (refund.barcode) + '</td>' +
                            '<td class="color_text" colspan="2">' + 'Refund' + '</td>' +
                            '<td class="color_text" colspan="2">' + dateAndTimeFormat(refund.refunded_date_time).formatted_date + " " + dateAndTimeFormat(refund.refunded_date_time).formatted_time + '</td>';
                        if (refund.temporary_name != null) {
                            refundRow += '<td class="color_text" colspan="2">' + refund.temporary_name + '</td>';
                        } else {
                            refundRow += '<td class="color_text" colspan="2">' + refund.cashier + '</td>';
                        }

                        refundRow += '<td class="color_text" colspan="2">' + refund.customer_type + '</td>';
                        var refundOtherDetails = JSON.parse(refund.otherDetails);
                        var total_refund = 0;
                        var getCartDiscount = 0;
                        var item_discount = 0;
                        
                        for(var i = 0; i < refundOtherDetails.length; i++) {
                            var cartDiscounteRef = parseFloat(refundOtherDetails[i].cartRate)
                            getCartDiscount = parseFloat(refund.totalRefunded * cartDiscounteRef)
                            total_refund = parseFloat(refundOtherDetails[i].discount);
                            item_discount += parseFloat(refundOtherDetails[i].itemDiscountsData)
                        }

                        var totalRef = ((parseFloat(refund.totalRefunded - total_refund)) - getCartDiscount) - parseFloat(item_discount);
                        refundRow += '<td class="color_text" colspan="2">' + addCommas(parseFloat('-' + (totalRef)).toFixed(2)) + '</td>' +
                            '<td colspan="2" style="color: lightgreen;">' + 'SUCCESS' + '</td>' +
                            '</tr>';

                        var associatedSaleRow = $('.salesHistoryTable tbody tr[data-ornums="' + (refund.barcode) + '"]').last();
                        // associatedSaleRow.after(refundRow);
                    });

                } else if ((sale.is_paid == 1 && sale.is_refunded == 3) || (sale.is_paid == 1 && sale.is_refunded == 2)) {
                    var returned = returnProducts.filter(function(ret) { return ret.or_num === sale.or_num;})
                    returned.sort(function(c, d) {
                        return c.return_date.localeCompare(d.return_date);
                    });

                    returned.forEach(function(returns) { 
                        var returnRow = '<tr class="selectable-sales-row"' +
                            'data-paymentid="'+ returns.payment_id +'"' + 
                            'data-refreturn="'+ 'returned' +'"' + 
                            '>' +
                            '<td class="color_text" colspan="1" style="font-size: large; padding: 0;text-align: center; ">' + '&#x21B3;' + '</td>' +
                            '<td class="color_text" colspan="2">' + returns.returnID + '</td>' +
                            '<td class="color_text" colspan="2">' + (returns.barcode) + '</td>' +
                            '<td class="color_text" colspan="2">' + 'Return' + '</td>' +
                            '<td class="color_text" colspan="2">' + dateAndTimeFormat(returns.return_date).formatted_date + " " + dateAndTimeFormat(returns.return_date).formatted_time + '</td>';
                        if (returns.temporary_name != null) {
                            returnRow += '<td class="color_text" colspan="2">' + returns.temporary_name + '</td>';
                        } else {
                            returnRow += '<td class="color_text" colspan="2">' + returns.cashier + '</td>';
                        }

                        returnRow += '<td class="color_text" colspan="2">' + returns.customer_type + '</td>';
                        var returnOtherDetails = JSON.parse(returns.otherDetails);
                        var total_return = 0;
                        var getCartDiscount = 0;
                        var itemDiscountReturn = 0;
                        
                        for(var i = 0; i < returnOtherDetails.length; i++) {
                            var cartDiscounteRef = parseFloat(returnOtherDetails[i].cartRate)
                            getCartDiscount = returns.totalReturn * cartDiscounteRef;
                            itemDiscountReturn = parseFloat(returnOtherDetails[i].itemDiscountsData);
                            total_return = parseFloat(returnOtherDetails[i].discount);
                        }

                        var totalReturns = Math.abs(Math.abs(parseFloat(returns.totalReturn - total_return)) - getCartDiscount) - parseFloat(itemDiscountReturn);
                        totalReturn += totalReturns
                        returnRow += '<td class="color_text" colspan="2">' + addCommas(parseFloat('-' + (totalReturns)).toFixed(2)) + '</td>' +
                            '<td colspan="2" style="color: lightgreen;">' + 'SUCCESS' + '</td>' +
                            '</tr>';

                        var associatedRedSaleRow = $('.salesHistoryTable tbody tr[data-ornums="' + (returns.barcode) + '"]').last();
                        // associatedRedSaleRow.after(returnRow);
                    })

                }
                filteredSalesHistory.push(sale);
              
            }
           
        }
        
       
      })
      var salesHistoryJSON = JSON.stringify(filteredSalesHistory);
        $.ajax({
            url: './reports/invoice-list-pdf.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                salesHistory:  salesHistoryJSON
            },
            success: function(response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'invoiceList.pdf';
                document.body.appendChild(a);
                a.click();

                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
       
    })
    .catch(function(error) {
        console.error('Error fetching sales history:', error);
    });
    })

    $('#refundButton').click(function() {
        var selectedDataHistory = $('.selectable-sales-row.selected');
        ornum = selectedDataHistory.data('ornums');
        $('#refundModalButton').click();
        $('#salesHistoryModal').hide();
        $('#receiptNumber').val(ornum);
    })

    $('.current_date').text(dateAndTimeFormat(currentDate()).formatted_date)
    $('.select_filter').change(function () {
        selectedFilter = $("#select_filter").val();
        getAllSalesHistory()
    })

    $('.select_filter_doc_type').change(function () {
        selected_doc = $(".select_filter_doc_type").val();
        getAllSalesHistory()
    })


    function submitReasons() {
        $('#void_reason').keydown(function(event) {
            if (event.key === 'Enter' || event.keyCode === 13) {
                event.preventDefault();
                $('.void_receipt').click();
            } if (event.shiftKey && event.which === 13) { 
                var textarea = $(this)[0];
                var cursorPosition = textarea.selectionStart;
                var textBeforeCursor = textarea.value.substring(0, cursorPosition);
                var textAfterCursor = textarea.value.substring(cursorPosition);
                textarea.value = textBeforeCursor + '\n' + textAfterCursor;

                // Move the cursor after the inserted newline character
                textarea.selectionStart = cursorPosition + 1;
                textarea.selectionEnd = cursorPosition + 1;

                // Prevent the default behavior
                event.preventDefault();
            }
        });
    }

    $('#cancel_receipt').click(function () {
        var selectedDataHistory = $('.selectable-sales-row.selected');
        var selectedRow = $('.selectable-row');
        if (selectedRow.hasClass('selected')) {
            modifiedMessageAlert('error', 'Invalid to Process: You have other transaction', false, false, 2000);
        } else {
            $('#salesHistoryModal').hide();
            $('#permModal').show();
            $('#adminCredentials').focus();
            $('#forRefund').prop('hidden', true)
            $('#continueLogin').prop('hidden', false)

            $('#continueLogin').click(function() {

                transactionToVoid = selectedDataHistory.data('transaction')
                customerId = selectedDataHistory.data('userid');
                discoutnIds = selectedDataHistory.data('discid');
                paymentid = selectedDataHistory.data('paymentid');

                var roleID = localStorage.roleIds
                var cashierID = localStorage.userIds
                var adminPass = $('#adminCredentials').val();

                axios.get(`api.php?action=credentialsAdmin2&credentials=${adminPass}`)
                .then(function(response) {
                    if (response.data.credentials2) {
                    if(roleID == 2 || roleID == 1) {
                        
                        $('#permModal').hide();
                        $('#salesHistoryModal').hide();
                        $("#void_with_reasonModal").show();
                        $('#void_reason').focus();
                        submitReasons()
                        
                        $('#reciept_to_void').val(transactionToVoid);
                        $('#receipt_to_paid').val(paymentid);
                        $('#receipt_customer_id').val(customerId);
                        voidProducts(); 
                    } else {

                        axios.get(`api.php?action=getPermissionLevel&userID=${cashierID}`)
                        .then(function(response){
                            var accessLevel = response.data.permission[0].permission
                            var accLvl = JSON.parse(accessLevel)
                            if(accLvl[0].VoidCart == "Access Granted") {
                            $('#permModal').hide();
                            $('#granted_modal').show();

                            $('.grantedBtn').click(function() {
                                $("#void_with_reasonModal").show();
                                $('#reciept_to_void').val(transactionToVoid);
                                $('#receipt_to_paid').val(paymentid);
                                $('#receipt_customer_id').val(customerId);
                                $('#granted_modal').hide();
                                submitReasons()
                                voidProducts(); 
                            })

                            } else if (accLvl[0].VoidCart == "No Access") {
                            $('#permModal').hide();
                            $('#denied_modal').show();

                            $('.deniedBtn').click(function() {
                                $('#permModal').show();
                                $('#adminCredentials').focus();
                                $('#forRefund').prop('hidden', true)
                                $('#continueLogin').prop('hidden', false)
                                $('#toChangeText').text('X-Reading Report')
                            })

                            } 
                        })
                    }
                    } else {
                    modifiedMessageAlert('error', 'Admin password or id incorrect!' , false, false);
                    }
                    
                })
                .catch(function(error) {
                    console.log(error)
                })
            })
        }
    })


    $('#search-sales').on('input', function() {
        var searchTerm = $(this).val().trim().toLowerCase();
        $('.salesHistoryTable tbody tr').each(function() {
            var saleOrNum = $(this).find('td:nth-child(2)').text().trim().toLowerCase(); 
            var customer_name = $(this).find('td:nth-child(6)').text().trim().toLowerCase();
            if (saleOrNum.includes(searchTerm) || customer_name.includes(searchTerm)) {
                $(this).show(); 
            } else {
                $(this).hide(); 
            }
        });
    });

});


function reprintReceipt(urls, print_idetifier) {
    if(paymentid) {

    } else if(print_idetifier == 2) {
       
    } else if(print_idetifier == 1) {

    } else if(print_idetifier == 3) {

    } else {
       
    }
}

function runPrintPreview_history() {
  var receiptPreview = document.querySelector('.receipt_preview_history');
  receiptPreview.scrollTop = 0;
  var scrollSpeed = 5;

  function scrollContent() {
    const totalHeight = receiptPreview.scrollHeight;
    const visibleHeight = receiptPreview.clientHeight;
    
    if (receiptPreview.scrollTop + visibleHeight >= totalHeight) {
      cancelAnimationFrame(animateScroll);
    } else {
      receiptPreview.scrollTop += scrollSpeed;
    }
  }

}

function dateAndTimeFormat (dateVal) {
    var date_time_str = dateVal;
    var date_time_obj = new Date(date_time_str);

    var options = { year: 'numeric', month: 'short', day: 'numeric' };
    var formatted_date = date_time_obj.toLocaleDateString('en-US', options);

    var optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
    var formatted_time = date_time_obj.toLocaleTimeString('en-US', optionsTime);
  
    return {
        formatted_date: formatted_date,
        formatted_time: formatted_time
    };
}


function dateAndTimeFormat (dateVal) {
    var date_time_str = dateVal;
    var date_time_obj = new Date(date_time_str);

    var options = { year: 'numeric', month: 'short', day: 'numeric' };
    var formatted_date = date_time_obj.toLocaleDateString('en-US', options);

    var optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
    var formatted_time = date_time_obj.toLocaleTimeString('en-US', optionsTime);
  
    return {
        formatted_date: formatted_date,
        formatted_time: formatted_time
    };
}

function addCommas(number) {
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function removeCommas(numberString) {
  if (typeof numberString !== 'string' || isNaN(parseFloat(numberString))) {
    return 0;
  }
  return parseFloat(numberString.replace(/,/g, ''));
}
function getTransactionSales(transaction) {
    axios.post('api.php?action=getTransactionsByNumJS', {
        'transNo': transaction,
    })
    .then(function (response) {
        // console.log(response.data.response)
        var dateAdnTimeFomatted = dateAndTimeFormat(response.data.response[0].date_time_of_payment)
        let receiptId = response.data.response[0].receipt_id;
        let service_charge = parseFloat(response.data.response[0].service_charge).toFixed(2);
        let other_charge = parseFloat(response.data.response[0].other_charge).toFixed(2)
        var totalCharges = parseFloat(service_charge) + parseFloat(other_charge);
        var sc_pwd = parseFloat(response.data.response[0].sc_pwd_discount).toFixed(2);
        var cart_discount = parseFloat(response.data.response[0].cart_discount).toFixed(2);
        var vat_sales = parseFloat(response.data.response[0].vatable_sales)
        var nonVatPrice = 0;
        let fullName;
        // console.log(response.data)
        if(response.data.response[0].temporary_name != null) {
            fullName = response.data.response[0].temporary_name
        } else {
            fullName = response.data.response[0].first_name + ' ' + response.data.response[0].last_name
        }
        let formattedReceiptId = receiptId.toString().padStart(8, '0');
       
    
        $('.receipt_type').text('PREVIEW RECEIPT')
        $('.transactionNo').text('Transaction #: ' + response.data.response[0].transaction_num);
        $('#or_num_id').text(formattedReceiptId)
        

        if(totalCharges > 0) {
            $('.service_charges').html('<label class="service_charges">Service Charge <span style="float: right" class="srvc_charge" id="srvc_charge">' + parseFloat(totalCharges).toFixed(2) + '</span></label>')
        }

        $('.cus_type').text('Customer Type: ' + response.data.response[0].name)
        $('.date_transac').text('Date: ' + dateAdnTimeFomatted.formatted_date);
        $('.time_transac').text('Time ' + dateAdnTimeFomatted.formatted_time)
        $('.Payer').text(fullName);
        
        var TotalQty = 0;
        var totalAmount = 0; 

        var lengthResponse = response.data.response.length;
        const container = $('#soldProduct');
        container.empty();
        var soldProduct = response.data.response;

        for (const key in soldProduct) {
            if (soldProduct.hasOwnProperty(key)) {
                const transacNum = $('.Preview_transacNo');
                const label = $('<label class="orderProducts"></label>');

                if (soldProduct[key].isVAT == '1') {
                    label.html('<span style="font-weight: bold">' + soldProduct[key].prod_desc + " (V) " + '</span>' + '<br>' +soldProduct[key].totalProdQty + " x &#8369; " + addCommas(parseFloat(soldProduct[key].prod_price).toFixed(2)) +
                        `<span style="float: right" class="subTotal_receipt">&#8369; ${addCommas(parseFloat(soldProduct[key].totalSubtotal).toFixed(2))}</span>`);
                } else {
                    nonVatPrice += parseFloat(soldProduct[key].prod_price)
                    label.html('<span style="font-weight: bold">' + soldProduct[key].prod_desc + " (N) " + '</span>' + '<br>' +soldProduct[key].totalProdQty + " x &#8369; " + addCommas(parseFloat(soldProduct[key].prod_price).toFixed(2)) +
                        `<span style="float: right" class="subTotal_receipt">&#8369; ${addCommas(parseFloat(soldProduct[key].totalSubtotal).toFixed(2))}</span>`);
                }
                TotalQty += parseInt(soldProduct[key].totalProdQty);
                transacNum.text(soldProduct[key].transaction_num)
                container.append(label);
            }
        }

        for(var i = 0; i < lengthResponse; i++) {
            totalAmount += parseFloat(response.data.response[i].totalSubtotal);
        }

        var res = response.data.response[0];
        let htmlContent = '';
        const paymentMethod = response.data.paymentMethod;
      
        const paymentSelected = JSON.parse(response.data.response[0].payment_details);
        for(var j = 0; j < paymentSelected.length; j++) {
            $('.userNames').text(paymentSelected[j].cashier_fullName)
            if(paymentSelected[j].amount != 0) {
                for(var i = 0; i < paymentMethod.length; i++) {
                    if (paymentMethod[i].id == paymentSelected[j].index) {
                        
                        var methodPay = paymentMethod[i].method; 
                        var amountPay = parseFloat(paymentSelected[j].amount).toFixed(2);
                        // $('.payments').append(methodPay + ' <span style="float: right" class="PaidAmount">' + addCommas(amountPay) + '</span><br>');
                        htmlContent += methodPay + ' <span style="float: right" class="PaidAmount">&#8369; ' + addCommas(parseFloat(amountPay).toFixed(2)) + '</span><br>';
                    }
                }
            }
            $('.payments').html(htmlContent);
        }

        if(cart_discount > 0) {
            $('.cart_discount').html('<label class="cart_discount">CART DISCOUNT <span style="float: right" id="cart_discounted">'+ parseFloat(cart_discount).toFixed(2) + '</span></label>')
        } else {
            $('.cart_discount').html('')
        }


        if (response.data.response[0].name != 'Regular') {
            $('#VatSales1').html('<label id="VatSales1">Vatable Sales <span style="float: right" >&#8369; ' + parseFloat(0).toFixed(2) + '</span></label>')
            var totalVat = parseFloat(0) * 0.12;
            $('#VatAmount1').html('<label id="VatAmount1">VAT Amount <span style="float: right" >&#8369; ' + parseFloat(totalVat).toFixed(2) + '</span></label>')
            $('#Vat_exempt_text').html('<label id="Vat_exempt_text">VAT Exempt Sales <span style="float: right" >&#8369; ' + parseFloat((vat_sales + nonVatPrice)).toFixed(2) + '</span></label>')
        } else {
            $('#VatSales1').html('<label id="VatSales1">Vatable Sales <span style="float: right" >&#8369; ' + parseFloat(vat_sales).toFixed(2) + '</span></label>')
            var totalVat = parseFloat(vat_sales) * 0.12;

            $('#VatAmount1').html('<label id="VatAmount1">VAT Amount <span style="float: right" >&#8369; ' + parseFloat(totalVat).toFixed(2) + '</span></label>')
            $('#Vat_exempt_text').html('<label id="Vat_exempt_text">VAT Exempt Sales <span style="float: right" >&#8369; ' + parseFloat(nonVatPrice).toFixed(2) + '</span></label>')
        }
        

        $('.dividerLine').html('');
        $('#allDiscounts').text('₱ ' + parseFloat(parseFloat(cart_discount) + parseFloat(sc_pwd)).toFixed(2))
        $('.totalRefund').html('')
        $('.itemQty').html('ITEM QTY <span style="float: right" class="TotalQty" id="TotalQty">' + addCommas(TotalQty) + '</span>');
        $('.tAmount').html('AMOUNT <span style="float: right" class="TotalAmount" id="TotalAmount">&#8369; ' + (addCommas(parseFloat(totalAmount).toFixed(2))) + '</span>' );
        $('.reg_dis').html('<span style="text-transform: uppercase;">' + res.name + '</span>' +' DISCOUNT <span style="float: right" id="CustomerDiscount">&#8369; ' + sc_pwd + '</span>');
        $('.discount_item').html('ITEM(s) DISCOUNT <span style="float: right" id="ItemsDiscount">&#8369; 0.00' + '</span>');
        $('.totalPayment_preview').html('TOTAL <span style="float: right;" id="TotalPayment">&#8369; ' + addCommas(parseFloat(res.payment_amount - res.change_amount).toFixed(2)) + '</span>');
        $('.tendered').html('<label class="tendered" style="text-align: center">Tendered: </label>');
        $('.payment_change').html('CHANGE <span style="float: right" id="ChangeAmount">&#8369; '+ addCommas(parseFloat(res.change_amount).toFixed(2)) +' </span>');

    })
    .catch(function(error) {
        console.log(error);
    });
}

function getRefundedSales(refunded, referenceNum) {
    axios.post('api.php?action=getRefundedSales', {
        'payment_id' : refunded,
        'reference_num' : referenceNum,
    })
    .then(function(response) {
        // console.log(response.data.refunded)
        var dateAdnTimeFomatted = dateAndTimeFormat(response.data.refunded[0].date)
        let receiptId = response.data.refunded[0].ref_num;
        let fullName;

        if(response.data.refunded[0].temporary_name != null) {
            fullName = response.data.refunded[0].temporary_name
        } else {
            fullName = response.data.refunded[0].first_name + ' ' + response.data.refunded[0].last_name
        }

        let formattedReceiptId = receiptId.toString().padStart(8, '0');
        $('.Payer').text(fullName);
        $('.receipt_type').text('REFUND RECEIPT')
        $('#or_num_id').text('Refund #: ' + response.data.refunded[0].refund_num)
        $('.transactionNo').html('<strong>Reference #:' + formattedReceiptId + '</strong>');
        $('.date_transac').text('Date: ' + dateAdnTimeFomatted.formatted_date );
        $('.time_transac').text('Time ' + dateAdnTimeFomatted.formatted_time)
        $('.cus_type').text('Customer Type: ' + response.data.refunded[0].discountType)

        var TotalQty = 0;
        var totalAmount = 0; 

        var lengthResponse = response.data.refunded.length;
        const container = $('#soldProduct');
        container.empty();
        var refundProduct = response.data.refunded;

        for (const key in refundProduct) {
            if (refundProduct.hasOwnProperty(key)) {
                const label = $('<label class="orderProducts"></label>');

                if (refundProduct[key].isVAT == '1') {

                label.html('<span style="font-weight: bold">' + refundProduct[key].prod_desc + " (V) " + '</span>' + '<br>' + refundProduct[key].qty + " x &#8369; " + addCommas(parseFloat(refundProduct[key].prod_price).toFixed(2)) +
                    `<span style="float: right" class="subTotal_receipt">&#8369; ${addCommas(parseFloat(refundProduct[key].totalSubtotal).toFixed(2))}</span>`);
                } else {
                label.html('<span style="font-weight: bold">' + refundProduct[key].prod_desc + " (N) " + '</span>' + '<br>' + refundProduct[key].qty + " x &#8369; " + addCommas(parseFloat(refundProduct[key].prod_price).toFixed(2)) +
                    `<span style="float: right" class="subTotal_receipt">&#8369; ${addCommas(parseFloat(refundProduct[key].totalSubtotal).toFixed(2))}</span>`);

                }
                
                TotalQty += parseInt(refundProduct[key].qty);
                container.append(label);
            }
        }

        for(var i = 0; i < lengthResponse; i++) {
            totalAmount += parseFloat(response.data.refunded[i].prod_price);
            var other_details = JSON.parse(response.data.refunded[i].otherDetails);
            var refund_cart = 0;
            var scpwd_discoutn = 0;
            var allDiscount = 0;
            var itemDiscounts = 0;
            var totalRefund = 0;
            totalRefund = totalAmount
            for(var j = 0; j < other_details.length; j++) {
                itemDiscounts = parseFloat(other_details[j].itemDiscountsData)
                scpwd_discoutn = parseFloat(other_details[j].discount)
                refund_cart = (parseFloat(totalAmount) * parseFloat(other_details[j].cartRate))
                allDiscount = (parseFloat(totalAmount) * parseFloat(other_details[j].cartRate) + parseFloat(other_details[j].discount) + itemDiscounts)
                
            }
        }
        
        if(refund_cart > 0) {
            $('.cart_discount').html('<label class="cart_discount">CART DISCOUNT<span style="float: right" id="cart_discounted">'+ parseFloat(refund_cart).toFixed(2) + '</span></label>')
        } else {
            $('.cart_discount').html('')
        }

        totalRefund -= parseFloat(allDiscount);
     
        $('#allDiscounts').text('₱ ' + parseFloat(parseFloat(allDiscount)).toFixed(2))
        $('.totalRefund').html('<label style="font-weight: bold;">TOTAL REFUND <span style="float: right"> &#8369;' + parseFloat(totalRefund).toFixed(2) +  '</span></label>')
        $('.tAmount').html('<label>AMOUNT<span style="float: right">' + parseFloat(totalAmount).toFixed(2) + '</span></label>');
        $('.reg_dis').html('<span style="text-transform: uppercase;">' + 'SC' + '</span>' +' DISCOUNT <span style="float: right" id="CustomerDiscount">&#8369; ' + scpwd_discoutn + '</span>');
        $('.dividerLine').html('<hr class="new2">');
        $('.discount_item').html('ITEM(s) DISCOUNT <span style="float: right" id="ItemsDiscount">&#8369; ' + parseFloat(itemDiscounts).toFixed(2) + '</span>');
        $('.totalPayment_preview').html('');
        $('.tendered').html('');
        $('.payments').html('');
        $('.payment_change').html('');
        $('.itemQty').html();
       
        // $('.TotalAmount').html(parseFloat(totalAmount).toFixed(2));
        
    })
    .catch(function(error) {
        console.log(error)
    })
}



function getAllSalesHistory() {
    $('.salesHistoryModal').focus();

    var existingData = [];
    var existingDataRefund = [];
    var salesIndexRow = -1;
    var selectedDateRange = $(".dateRange").val();
    var selectedFilter = $("#select_filter").val();
    var selected_doc = $(".select_filter_doc_type").val();
    var selectedDates = selectedDateRange.split(" to ");
    var startDate = new Date(selectedDates[0]);
    var endDate = new Date(selectedDates[1]);

    var yesterDay = new Date (currentDate())
    var thisMonth = new Date(currentDate())
    var currentYear = new Date().getFullYear();

    var totalToBePaidSum = 0;
    var refundedAmoutn = 0;
    var totalReturn = 0;

    var all = selected_doc === 'ALL';
    var succ = selected_doc === 'SUCCESS';
    var refunded_doc = selected_doc === 'REFUNDED';
    var voided_doc = selected_doc === 'VOID';
    var testRow = document.querySelectorAll('.selectable-sales-row');
    var texts = [];
    var lastCell;
    function returnTextStat () {
        testRow.forEach(function(t_row) {
            var lastCell = t_row.querySelector('td:last-child');
            var text = lastCell.textContent.trim();
            
            texts.push(text);
        });
        return texts;
    }

    $('.dateRange').css({
        'color': 'var(--border-color)',
        'background-color': 'transparent',
    });
    
    if (selectedFilter === 'TODAY') {
        startDate = dateAndTimeFormat(currentDate()).formatted_date;
        $('.dateRange').prop('disabled', true);
        $('.current_date').text(startDate);
    } else if (selectedFilter === 'YESTERDAY') {
        yesterDay.setDate(yesterDay.getDate() - 1);
        startDate = dateAndTimeFormat(yesterDay).formatted_date;
        $('.current_date').text(startDate);
        $('.dateRange').prop('disabled', true);
    } else if (selectedFilter === 'THIS WEEK') {
        Date.prototype.getWeek = function () {
            var dt = new Date(this.getFullYear(), 0, 1);
            return Math.ceil((((this - dt) / 86400000) + dt.getDay() + 1) / 7);
        };

        var thisWeek = new Date();
        var firstDayOfWeek = new Date(thisWeek);
        firstDayOfWeek.setDate(thisWeek.getDate() - thisWeek.getDay()); 

        var lastDayOfWeek = new Date(thisWeek);
        lastDayOfWeek.setDate(thisWeek.getDate() - thisWeek.getDay() + 6);

        startDate = dateAndTimeFormat(firstDayOfWeek).formatted_date;
        endDate = dateAndTimeFormat(lastDayOfWeek).formatted_date;
        $('.dateRange').prop('disabled', true);
        $('.current_date').text(startDate + ' to ' + endDate);
    } else if (selectedFilter === 'THIS MONTH') {
        thisMonth.setDate(thisMonth.getMonth());
        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        $('.dateRange').prop('disabled', true);
        var startDateString = dateAndTimeFormat(thisMonth).formatted_date;
        startDate = new Date(startDateString);
        startDate.setDate(startDate.getDate() - 1);
        startDate = dateAndTimeFormat(startDate).formatted_date
        endDate = dateAndTimeFormat(lastDay).formatted_date;
        $('.current_date').text(dateAndTimeFormat(startDate).formatted_date + ' to ' + dateAndTimeFormat(endDate).formatted_date);
    } else if (selectedFilter === 'THIS YEAR') {
        startDate = dateAndTimeFormat(new Date(currentYear, 0, 1)).formatted_date;
        endDate = dateAndTimeFormat(new Date(currentYear, 11, 31)).formatted_date;
        $('.dateRange').prop('disabled', true);
        $('.current_date').text(startDate + ' to ' + endDate);
    } else if (selectedFilter === 'CUSTOM') {
        $('.dateRange').prop('disabled', false);

        $('.dateRange').css({
            'color': '#fff',
            'background-color': 'transparent',
        });
        var startDate = new Date(selectedDates[0]);
        var endDate = new Date(selectedDates[1]);
        startDate = dateAndTimeFormat(new Date(selectedDates[0])).formatted_date
        endDate = dateAndTimeFormat(new Date(selectedDates[1])).formatted_date
        $('.current_date').text(dateAndTimeFormat(currentDate()).formatted_date);
    }

    var allUser = $('#all_user_sales').prop('checked') ? 1 : 0;
    axios.post('api.php?action=getSalesHistory', {
        'cashier_id' : localStorage.userIds,
        'roleId' : localStorage.roleIds,
        'allUsers' : allUser,
    })
    .then(function(response) {
        var salesHistory = response.data.data;
        var refundedData = response.data.data2;
        var returnProducts = response.data.returnProducts;
        var startingIndex = salesHistory.length;
        var pay_details = response.data.payments_details;
        var saleDate;
     
      $('.salesHistoryTable tbody').empty();
        
      $.each(salesHistory, function(index, sale) {
        
        if(selectedFilter === 'CUSTOM') {
            saleDate = dateAndTimeFormat(sale.date_time_of_payment).formatted_date;
        } else {
            saleDate = dateAndTimeFormat(sale.date_time_of_payment).formatted_date;
        }

        function getFilterTable(saleDate, startDate, endDate) {
            if(selectedFilter === 'TODAY' && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate == dateAndTimeFormat(startDate).formatted_date;
            } else if (selectedFilter == 'YESTERDAY' && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate == dateAndTimeFormat(startDate).formatted_date;
            } else if ((selectedFilter === 'THIS WEEK' || selectedFilter === 'THIS MONTH') && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate >= dateAndTimeFormat(startDate).formatted_date || saleDate <= dateAndTimeFormat(endDate).formatted_date; 
            }
            else if (selectedFilter === 'THIS YEAR' && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate >= dateAndTimeFormat(startDate).formatted_date || saleDate <= dateAndTimeFormat(endDate).formatted_date;
            }
             else if (selectedFilter === 'CUSTOM' && ((sale.is_void == 2 && selected_doc == 'VOIDED') 
            || (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0 && selected_doc == 'SUCCESS' ) 
            || (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; }) && selected_doc == 'REFUNDED') 
            ||  (sale.is_paid == 1 && sale.is_refunded == 2 && selected_doc == 'RET&EX')
            || selected_doc == 'ALL')) {
                return saleDate >= dateAndTimeFormat(startDate).formatted_date || saleDate <= dateAndTimeFormat(endDate).formatted_date;
            }
        }
        
        if (getFilterTable(saleDate, startDate, endDate) ) {
            displaySalesReport()
            $('#receiptCount').text(receipt_count)
        } else {
            totalPayment = 0;
            totalChange = 0;
            $('#receiptCount').text(receipt_count)
            $('#totalSalesHistory').text('₱' + parseFloat(totalPayment - totalChange).toFixed(2))
        }

        
        function displaySalesReport() {
            var descendingIndex = startingIndex - index;
            receipt_count = startingIndex;
            if (existingData.indexOf(sale.or_num) === -1) {

                var row = '<tr class="selectable-sales-row"' +
                    'data-transaction="' + sale.transaction_num + '" ' +
                    'data-refunddata="' + sale.is_refunded + '" ' +
                    'data-userid="' + sale.customer_id + '" ' +
                    'data-discid="' + sale.discount_id + '" ' +
                    'data-voided="' + sale.is_void + '" ' +
                    'data-reasons="' + sale.reason + '" ' +
                    'data-ornums="'+ (sale.barcode) + '" ' +
                    '>' +
                    '<td colspan="1">' + (descendingIndex) + '</td>' +
                    '<td colspan="2">' + (sale.barcode) + '</td>' +
                    '<td colspan="2">' + ' ' + '</td>' +
                    '<td colspan="2">' + 'Sale' + '</td>' +
                    '<td colspan="2">' + dateAndTimeFormat(sale.date_time_of_payment).formatted_date + " " + dateAndTimeFormat(sale.date_time_of_payment).formatted_time + '</td>';

                
                if (sale.temporary_name != null) {
                    row += '<td colspan="2">' + sale.temporary_name + '</td>';
                } else {
                    row += '<td colspan="2">' + sale.cashier + '</td>';
                }

                if (pay_details.find(function(pay) { return pay.id === sale.payment_id})) {
                    var getPayments = pay_details.filter(function(pay) { return pay.id === sale.payment_id });
                    var cartDiscounts = parseFloat(getPayments[0].cart_discount);

                    // var totalToBePay = parseFloat(sale.payment_amount) - parseFloat(cartDiscounts)
                    var totalToBePay = parseFloat(sale.payment_amount)
                    row += '<td colspan="2">' + sale.customer_type + '</td>' +
                    '<td colspan="2">' + addCommas(parseFloat(totalToBePay).toFixed(2)) + '</td>';
                }
                
                if (sale.is_paid == 1 && sale.is_refunded == 0 && sale.is_void == 0) {
                    row += '<td  style="color: lightgreen;">' + 'SUCCESS' + '</td>';
                } else if (sale.is_void == 2) {
                    row += '<td class="text-danger" >' + 'VOIDED' + '</td>';
                } else if (sale.is_paid == 1 && sale.is_refunded == 1 && refundedData.find(function(ref) { return ref.or_num === sale.or_num; })) {
                    row += '<td class="text-warning" >' + 'REFUNDED' + '</td>';
                    var refToGet = refundedData.filter(function(ref) { return ref.or_num === sale.or_num; });
                    var allDetailsRefund = refToGet;
                    var refund_total = 0;
                    var totalAmountRefund = 0;
                    var getCartDiscount1 = 0;
                    var itemDiscountRef = 0;

                for(var i = 0; i < allDetailsRefund.length; i++) {
                    var refunded = JSON.parse(allDetailsRefund[i].otherDetails);
                    var cartDiscounteRef = parseFloat(refunded[0].cartRate)
                    getCartDiscount1 = parseFloat(allDetailsRefund[i].totalRefunded * cartDiscounteRef)
                    totalAmountRefund = allDetailsRefund[i].totalRefunded;
                    refundedAmoutn += ((parseFloat(totalAmountRefund - refunded[0].discount)) - getCartDiscount1 )- parseFloat(allDetailsRefund[i].itemDiscountsData)
                }

                } else if (sale.is_paid == 1 && sale.is_refunded == 2) {
                    row += '<td class="text-primary" >' + 'RET&EX' + '</td>';
                } else if (sale.is_paid == 1 && sale.is_refunded == 3) {
                    row += '<td style="color: pink" >' + 'RETURN' + '</td>';
                }

                
                if (sale.is_void != 2) {
                    totalToBePaidSum += parseFloat(sale.payment_amount);
                    if (pay_details.find(function(pay) { return pay.id === sale.payment_id})) {
                        var getPayments = pay_details.filter(function(pay) { return pay.id === sale.payment_id });
                        var cartDiscounts = parseFloat(getPayments[0].cart_discount);
                        // totalToBePaidSum -= cartDiscounts;
                    }
                }

               

                row += '</tr>';
                $('.salesHistoryTable tbody').append(row);

                
                if (sale.is_paid == 1 && sale.is_refunded == 1) {
                    var refunds = refundedData.filter(function(ref) { return ref.or_num === sale.or_num; });
                    refunds.sort(function(a, b) {
                        return a.refunded_date_time.localeCompare(b.refunded_date_time);
                    });
                    
                    refunds.forEach(function(refund) { 
                        var refundRow = '<tr class="selectable-sales-row"' +
                            'data-paymentid="'+ refund.payment_id +'"' + 
                            'data-references="'+ refund.reference_num +'"' +
                            '>' +
                            '<td class="color_text" colspan="1" style="font-size: large; padding: 0;text-align: center; ">' + '&#x21B3;' + '</td>' +
                            '<td class="color_text" colspan="2">' + refund.reference_num + '</td>' +
                            '<td class="color_text" colspan="2">' + 'RS-' +  (refund.barcode) + '</td>' +
                            '<td class="color_text" colspan="2">' + 'Refund' + '</td>' +
                            '<td class="color_text" colspan="2">' + dateAndTimeFormat(refund.refunded_date_time).formatted_date + " " + dateAndTimeFormat(refund.refunded_date_time).formatted_time + '</td>';
                        if (refund.temporary_name != null) {
                            refundRow += '<td class="color_text" colspan="2">' + refund.temporary_name + '</td>';
                        } else {
                            refundRow += '<td class="color_text" colspan="2">' + refund.cashier + '</td>';
                        }

                        refundRow += '<td class="color_text" colspan="2">' + refund.customer_type + '</td>';
                        var refundOtherDetails = JSON.parse(refund.otherDetails);
                        var total_refund = 0;
                        var getCartDiscount = 0;
                        var item_discount = 0;
                        
                        for(var i = 0; i < refundOtherDetails.length; i++) {
                            var cartDiscounteRef = parseFloat(refundOtherDetails[i].cartRate)
                            getCartDiscount = parseFloat(refund.totalRefunded * cartDiscounteRef)
                            total_refund = parseFloat(refundOtherDetails[i].discount);
                            item_discount += parseFloat(refundOtherDetails[i].itemDiscountsData)
                        }

                        var totalRef = ((parseFloat(refund.totalRefunded - total_refund)) - getCartDiscount) - parseFloat(item_discount);
                        refundRow += '<td class="color_text" colspan="2">' + addCommas(parseFloat('-' + (totalRef)).toFixed(2)) + '</td>' +
                            '<td colspan="2" style="color: lightgreen;">' + 'SUCCESS' + '</td>' +
                            '</tr>';

                        var associatedSaleRow = $('.salesHistoryTable tbody tr[data-ornums="' + (refund.barcode) + '"]').last();
                        associatedSaleRow.after(refundRow);
                    });

                } else if ((sale.is_paid == 1 && sale.is_refunded == 3) || (sale.is_paid == 1 && sale.is_refunded == 2)) {
                    var returned = returnProducts.filter(function(ret) { return ret.or_num === sale.or_num;})
                    returned.sort(function(c, d) {
                        return c.return_date.localeCompare(d.return_date);
                    });

                    returned.forEach(function(returns) { 
                        var returnRow = '<tr class="selectable-sales-row"' +
                            'data-paymentid="'+ returns.payment_id +'"' + 
                            'data-refreturn="'+ 'returned' +'"' + 
                            '>' +
                            '<td class="color_text" colspan="1" style="font-size: large; padding: 0;text-align: center; ">' + '&#x21B3;' + '</td>' +
                            '<td class="color_text" colspan="2">' + returns.returnID + '</td>' +
                            '<td class="color_text" colspan="2">' + (returns.barcode) + '</td>' +
                            '<td class="color_text" colspan="2">' + 'Return' + '</td>' +
                            '<td class="color_text" colspan="2">' + dateAndTimeFormat(returns.return_date).formatted_date + " " + dateAndTimeFormat(returns.return_date).formatted_time + '</td>';
                        if (returns.temporary_name != null) {
                            returnRow += '<td class="color_text" colspan="2">' + returns.temporary_name + '</td>';
                        } else {
                            returnRow += '<td class="color_text" colspan="2">' + returns.cashier + '</td>';
                        }

                        returnRow += '<td class="color_text" colspan="2">' + returns.customer_type + '</td>';
                        var returnOtherDetails = JSON.parse(returns.otherDetails);
                        var total_return = 0;
                        var getCartDiscount = 0;
                        var itemDiscountReturn = 0;
                        
                        for(var i = 0; i < returnOtherDetails.length; i++) {
                            var cartDiscounteRef = parseFloat(returnOtherDetails[i].cartRate)
                            getCartDiscount = returns.totalReturn * cartDiscounteRef;
                            itemDiscountReturn = parseFloat(returnOtherDetails[i].itemDiscountsData);
                            total_return = parseFloat(returnOtherDetails[i].discount);
                        }

                        var totalReturns = Math.abs(Math.abs(parseFloat(returns.totalReturn - total_return)) - getCartDiscount) - parseFloat(itemDiscountReturn);
                        totalReturn += totalReturns
                        returnRow += '<td class="color_text" colspan="2">' + addCommas(parseFloat('-' + (totalReturns)).toFixed(2)) + '</td>' +
                            '<td colspan="2" style="color: lightgreen;">' + 'SUCCESS' + '</td>' +
                            '</tr>';

                        var associatedRedSaleRow = $('.salesHistoryTable tbody tr[data-ornums="' + (returns.barcode) + '"]').last();
                        associatedRedSaleRow.after(returnRow);
                    });
                }
              
            }
        }
       
      });
      scrollToSelectedRow_sales()
      selectRow($('.selectable-sales-row').first());

      var totalSalesValue = parseFloat(totalToBePaidSum) - parseFloat(refundedAmoutn) - Math.abs(parseFloat(totalReturn))
      $('#totalSalesHistory').text('₱' + addCommas(parseFloat(totalSalesValue).toFixed(2)))
      $('#totalSalesReturnHistory').text('₱' + addCommas(Math.abs(parseFloat(totalReturn)).toFixed(2)))
      $('#totalSalesRefundedHistory').text('₱' + addCommas(parseFloat(refundedAmoutn).toFixed(2)))
    })
    .catch(function(error) {
      console.error('Error fetching sales history:', error);
    });

        var selectedRow = null;
        function selectRow(row) {
            $('.selectable-sales-row.selected').removeClass('selected');
            selectedRow = row;
            selectedRow.addClass('selected'); 
        
            if (selectedRow && selectedRow.length > 0) {
            var offset = selectedRow.offset();
            if (offset) {
                $('html, body').animate({
                scrollTop: offset.top - $(window).height() / 2
                }, 1);
            }

            if($(row).data('transaction')) {
                var transactionValue = $(row).data('transaction');
                var isRefundedData = $(row).data('refunddata');
                var isVoided = $(row).data('voided');
                if (isRefundedData == 0 && isVoided != 2) {
                    $('#cancel_receipt').prop('disabled', false)
                } else if (isRefundedData == 0 && isVoided == 2) {
                    $('#cancel_receipt').prop('disabled', true)
                } else {
                    $('#cancel_receipt').prop('disabled', true)
                }
                getTransactionSales(transactionValue)
                $('.color_text').css('color', '#fc3d49');
            } else {
                var refunded = $(row).data('paymentid')
                var referenceNum = $(row).data('references')
                var refreturn = $(row).data('refreturn');
                if (referenceNum) {
                    $('#cancel_receipt').prop('disabled', true)
                    $(row).find('.color_text').css('color', 'black');
                } else if (refreturn) {
                    $('#cancel_receipt').prop('disabled', true)
                    $(row).find('.color_text').css('color', 'black');
                }
                getRefundedSales(refunded, referenceNum)
            }

            }
        }

        $('.salesHistoryTable tbody').on('click', '.selectable-sales-row', function() {
            $('.selectable-sales-row').removeClass('selected'); 
            $(this).addClass('selected'); 
            selectRow($(this)); 
        });

        function moveSelection(direction) {
            if (selectedRow) {
                var nextRow = (direction === 'up') ? selectedRow.prev('.selectable-sales-row') : selectedRow.next('.selectable-sales-row');
                if (nextRow.length) {
                    selectRow(nextRow);
                }
                scrollToSelectedRow_sales()
            } else {
                var rowToSelect = (direction === 'up') ? $('.selectable-sales-row').last() : $('.selectable-sales-row').first();
                selectRow(rowToSelect);
                scrollToSelectedRow_sales()
            }
        }

        
        $('.salesHistoryModal').off('keydown').on('keydown', function (e) {
          switch(e.which) {
              case 38: 
                  moveSelection('up');
                 
                  e.preventDefault();
                  break;
              case 40: 
                  moveSelection('down');
                  e.preventDefault();
                  
                  break;
              default:
                  return; 
          }
          e.preventDefault();
      }); 
      
    $('.closeBtnSalesHistory').click(function () {
        $('.salesHistoryModal').hide();
        $('#search-input').focus()
    })

    
}




</script>


<style>

option {
    background: #262626
}


.custom_form_control {
    height: 33px;
    margin-top: -10px;
    padding-left: 10px;
    background: transparent;
    outline: 0;
}

    .color_text {
        color: #fc3d49;
    }
    .select_filter_doc_type {
        border: none;
        margin-right: 10px;
        border-radius: 0;
        background: transparent;
        border: 1px solid #4B413E; 
        color: #fff;
        font-size: small;
        width: auto;
    }

    .select_filter {
        border: none;
        margin-right: 10px;
        border-radius: 0;
        background: transparent;
        border: 1px solid #4B413E; 
        color: #fff;
        font-size: small;
        width: auto;
    }

    /* span.flatpickr-day  {
        color: #fff;
    }

    div.flatpickr-months {
        color: #fff;
    } */

    .search_input_history input {
        font-size: small;
    }
    
    .dateRange {
        font-size: small;
        background: transparent !important; 
        color: var(--border-color);
        outline: solid 1px #4B413E;
        width: auto;
        border: none;
        border-radius: 0;
    }

     input.dateRange {
        width: 100%
    }

    .receipt_preview_history {
        border: 1px solid #4B413E; 
        height: 600px; 
        color: #000 !important;
        padding: 0;
        overflow-y: auto;
        scrollbar-width: 0; 
        scrollbar-color: transparent; 
        padding: 10px;
        width: 300px;
        right: 27px;
        position: absolute;
    }

    
    .row_button button {
        font-size: small;
    }
    

    .d-flex svg.bi.bi-calendar-check {
        margin-left: 10px;
        margin-top: -10px
    }
 
    .sales_history {
        height: 600px; 
        color: #000;
        padding: 0;
        overflow-y: auto;
        scrollbar-width: 0; 
        scrollbar-color: transparent;
        font-size: small;
    }

    .sales_history::-webkit-scrollbar {
        width: 0;
    }

    .sales_history::-webkit-scrollbar-thumb {
        background-color: transparent ;
    }

    /* #receipt_information {
        height: 600px;
        display: flex;
        flex-direction: column;
    } */


    .receipt_preview_history::-webkit-scrollbar {
        width: 0;
    }

    .receipt_preview_history::-webkit-scrollbar-thumb {
        background-color: transparent;
    }

    .headTitle {
        font-weight: bold;
    }

    .salesContent {
        margin-top: 10px;
        border: solid 1px #4B413E;
        padding: 20px; 
        
    }


    .closeBtnSalesHistory {
        background-color: #262626;
        border: solid 1px #4B413E;
        color: #ffff;
        border-radius: 0;
        font-weight: bold;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        width: auto;
    }

    .close {
        float: right;
    }

    .d-flex {
        display: flex;
        justify-content: space-between; 
        align-items: center;
    }

    .buttonActions button {
        background-color: #262626;
        border: solid 1px #4B413E;
        color: #ffff;
        border-radius: 0;
        font-weight: bold;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        width: auto
    }

    #cancel_receipt {
        background: red;
    }


    /* Background and Text Color */
    .flatpickr-calendar {
        background: #262626 !important;
    }

    .flatpickr-calendar .flatpickr-days, .flatpickr-calendar .day, .flatpickr-calendar .weekday {
        color: #fff !important;
    }

    /* Header Styling */
    .flatpickr-calendar .flatpickr-month {
        background: #262626 !important; /* Slightly lighter than the main background for depth */
        color: #fff !important;
    }

    /* Size Adjustments for a Compact Look */
    .flatpickr-calendar {
        font-size: 12px !important; /* Smaller text */
    }

    .flatpickr-day {
        padding: 0 !important;
        width: 24px !important;
        height: 24px !important; /* Smaller day cells */
        line-height: 24px !important;
    }

    /* Adjust the calendar width */
    .flatpickr-calendar .flatpickr-innerContainer, .flatpickr-calendar .flatpickr-rContainer {
        width: auto !important; /* Adjust based on new cell sizes */
    }

    /* Hover and Active State for Better Visibility */
    .flatpickr-day:hover, .flatpickr-day.today, .flatpickr-day.selected {
        background: #555 !important; /* Darker background for hover */
        color: #fff !important;
    }


    .flatpickr-monthDropdown-months {
        background-color: #262626 !important; /* Your desired background color */
        color: #fff !important; /* Adjust text color as needed */
    }

    /* Change background color of year dropdown, if applicable */
    .flatpickr-monthDropdown-months, .numInput {
        background-color: #262626 !important; /* Your desired background color */
        color: #fff !important; /* Adjust text color as needed */
    }

    input.numInput.cur-year {
        font-size: small;
    }

    span.flatpickr-weekday {
        color: #fff;
    }

    span.flatpickr-day {
        color: #fff;
    }


    span.flatpickr-day.nextMonthDay {
        color: gray;
    }

    span.flatpickr-day.prevMonthDay {
        color: gray;
    }

    /* span.flatpickr-day.inRange {
        background: transparent;
    } */

    div.flatpickr-calendar.rangeMode.animate.open.arrowTop.arrowLeft {
        border: 1px solid rgb(75, 65, 62);
        box-shadow: none;
        outline: 0;
        border-radius: 0;
    }

    div.flatpickr-calendar.rangeMode.animate.arrowTop.arrowLeft.centerMost.open {
        width: auto;
        right: 100px !important;
        left: auto !important;
    }


    .toggle-checkbox {
      display: none; 
    }

    .toggle-label {
      margin-left: 0;
    }



    .toggle-label {
        display: inline-block;
        position: relative;
        width: 40px; /* Width of the toggle */
        height: 20px; /* Height of the toggle */
        background-color: #C62828; /* Background color of the toggle */
        border-radius: 20px; /* Half of height to make it round */
        cursor: pointer;
        transition: background-color 0.3s ease; /* Smooth transition */
    }

    .toggle-label::before {
      content: '';
      position: absolute;
      top: 1px; 
      left: 1px; 
      width: 18px; 
      height: 18px;
      background-color: #fff; 
      border-radius: 50%; 
      transition: transform 0.2s ease;
    }

    .toggle-checkbox:checked + .toggle-label::before {
        transform: translateX(20px); /* Move handle to the right */
    }

    .toggle-checkbox:checked + .toggle-label {
        background-color: #428A47; /* Change background color when checked */
    }

    .salesHistoryModal {
        -webkit-user-select: none; 
        -moz-user-select: none;   
        -ms-user-select: none;  
        user-select: none;   
    }



</style>
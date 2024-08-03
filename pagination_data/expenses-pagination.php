<?php
    include(__DIR__ . '/../utils/db/connector.php');
    include(__DIR__ . '/../utils/models/product-facade.php');
    include(__DIR__ . '/../utils/models/expense-facade.php');

    $expenseFacade = new ExpenseFacade();
    $totalRecords = $expenseFacade->total_expensesRows();
    $totalPages = ceil($totalRecords / 100);
    echo "<div id='paginationBtns'>";
    echo "<a  class='paginationButtons paginationTag prev' href='javascript:void(0)' onclick='changePage(\"prev\")'>Prev</a>";

    for ($i = 1; $i <= min(20, $totalPages); $i++) {
        $activeClass = ($i == 1) ? 'active' : '';
        echo "<a  class='paginationButtons paginationTag $activeClass' href='javascript:void(0)' onclick='show_allExpensesData($i, '', '', '')'>$i</a> ";
    }

    if ($totalPages > 20) {
        echo "<a  class='paginationButtons paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>";
        echo "<a  class='paginationButtons paginationTag' href='javascript:void(0)' onclick='show_allExpensesData($totalPages, '', '', '')'>$totalPages</a> ";
    }

    echo "<a  class='paginationButtons paginationTag next' href='javascript:void(0)' onclick='changePage(\"next\")'>Next</a>";
    echo "</div>";

?>
<style>
    .paginationButtons 
    {
        border-radius: 50%; 
        background: transparent; 
        border: 1px solid #757373; 
        color: #fff'
    }
    #responsive-data thead tr th{
        background-color: #1e1e1e;
        border: 2px solid #262626;
        height: 5px;
        padding: 10px 10px;
    }
</style>

<script>
    var currentPageD = 1;
    var currentPageDGroup = 1;
    var pagesPerGroup = 20;
    var totalPages = <?php echo $totalPages; ?>;

    $('#searchInput').focus();
    $("#responsive-data").html("");

    var tblData = `
            <table id='tbl_expenses' class='text-color table-border display' style='font-size: 12px;'>
                <thead class = 'adminTableHead'>
                    <tr>
                        <th style = "width: 3%" class='text-center auto-fit'>No.</th>
                        <th style = "width: 20%" f>Item Name</th>
                        <th style = "width: 6%">Date</th>
                        <th style = "width: 6%">Billable</th>
                        <th style = "width: 10%" >Type</th>
                        <th style = "width: 6%" >UOM</th>
                        <th style = "width: 6%" >Supplier</th>
                        <th style = "width: 6%;font-size: 10px; text-align: center" >Invoice Number</th>
                        <th style = "width: 8%" >Quantity</th>
                        <th style = "width: 8%" >Price (Php)</th>
                        <th style = "width: 8%" >Discount</th>
                        <th style = "width: 8%" >Total Amount(Php)</th>
                        <th >Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>`;

    $("#responsive-data").html(tblData);
 
    $("#searchInput").on("input", function(){
        var searchInput = $(this).val();
        show_allExpensesData(1, '', '', searchInput)
    })
    $("#btn_datePeriodSelected").on("click", function(){
        var date_selected = $("#date_selected").text();
        $("#date_range").val(date_selected);
        $("#period_reports").hide();
        var dates = date_selected.split(" - ");
        var startDate = convertDateFormat(dates[0]);
        var endDate = convertDateFormat(dates[1]);
        show_allExpensesData(1, startDate, endDate, '');
    })
    function convertDateFormat(date) 
    {
        var parts = date.split("/");
        return parts[2] + "-" + ("0" + parts[1]).slice(-2) + "-" + ("0" + parts[0]).slice(-2);
    }
    function show_allExpensesData(page, start_date, end_date, searchInput)
    {
        currentPageD = page;
        $('.paginationTag').removeClass('active');
        $('.paginationTag').eq(page - 1).addClass('active');
        $('#searchInput').focus();
        $.ajax({
            url: './fetch-data/fetch-expenses.php',
            type: 'GET',
            data: { 
                page: currentPageD,
                start_date: start_date,
                end_date: end_date,
                searchInput: searchInput,
            },
            success: function (response) {
                $('#tbl_expenses tbody').html(response);
                display_records();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        updatePaginationButtons();
    }
    function numberWithCommas(number) 
    {
        var numString = number.toString();
        var parts = numString.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return parts.join('.');
    }
    function removeCommas(numString) 
    {
        return numString.replace(/,/g, '');
    }
    function display_records() 
    {
        $("#preview_records").html('');

        var table = `
            <table tabindex='0' style='color:#ccc; font-family: Century Gothic; font-weight: bold; width: 100%' id="tbl_previewRecord">
                <tbody>
                   <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Items:</th>
                        <th style="background-color: #262626; border: 1px solid #262626; "  class = "text-right"  id="total_items"></th>
                    </tr>
                    <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Qty:</th>
                        <th style="background-color: #262626; border: 1px solid #262626; "  class = "text-right totalQty"></th>
                    </tr>
                     <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Price:</th>
                        <th  class = "text-right totalPrice" style="background-color: #262626; border: 1px solid #262626;"</th>
                    </tr>
                    <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Discount:</th>
                        <th  class = "text-right totalDiscount" style="background-color: #262626; border: 1px solid #262626;" ></th>
                    </tr>
                    <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Overall Total:</th>
                        <th  class = "text-right overallTotal" style="background-color: #262626; border: 1px solid #262626;" ></th>
                    </tr>
                </tbody>
            </table>
        `;

        var totalQty = 0;
        var totalPrice = 0;
        var totalDiscount = 0;
        var overallTotal = 0;

        var itemCount = $('#responsive-data #tbl_expenses tbody tr').length;
        $('#responsive-data #tbl_expenses tbody tr').each(function() {
            var tq = removeCommas($(this).find('td:eq(8)').text().trim());
            tq = parseFloat(tq);
            if (!isNaN(tq)) 
            {
                totalQty += tq;
            }

            var tp = removeCommas($(this).find('td:eq(9)').text().trim());
            tp = parseFloat(tp);
            if (!isNaN(tp)) 
            {
                totalPrice += tp;
            } 

            var td = removeCommas($(this).find('td:eq(10)').text().trim());
            td = parseFloat(td);
            if (!isNaN(td)) 
            {
                totalDiscount += td;
            }

            var ot = removeCommas($(this).find('td:eq(11)').text().trim());
            ot = parseFloat(ot);
            if (!isNaN(ot)) 
            {
                overallTotal += ot;
            }
        });
      
        $("#preview_records").html(table);

        $('#total_items').text(numberWithCommas(itemCount));
        $('.totalQty').text(numberWithCommas(totalQty.toFixed(2)));
        $('.totalPrice').text(numberWithCommas(totalPrice.toFixed(2)));
        $('.totalDiscount').text(numberWithCommas(totalDiscount.toFixed(2)));
        $('.overallTotal').text(numberWithCommas(overallTotal.toFixed(2)));
    }
    function updatePaginationButtons() 
    {
        const paginationBtns = document.getElementById('paginationBtns');
        paginationBtns.innerHTML = '';
        paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag prev' href='javascript:void(0)' onclick='changePage("prev")'>Prev</a>`;
        if (currentPageDGroup > 1) 
        {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(-1)'>...</a>`;
        }
        const startPage = (currentPageDGroup - 1) * pagesPerGroup + 1;
        const endPage = Math.min(currentPageDGroup * pagesPerGroup, totalPages);

        for (let i = startPage; i <= endPage; i++) 
        {
            let styleString = '';

            if (i == currentPageD) {
                styleString = 'border-radius: 50%; background: transparent; border: 1px solid var(--primary-color); color: #fff';
            } else {
                styleString = 'border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff';
            }

            const activeClass = (i == currentPageD) ? 'active' : '';
            paginationBtns.innerHTML += `<a style='${styleString}' class='paginationTag ${activeClass}' href='javascript:void(0)' onclick='show_allExpensesData(${i})'>${i}</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag' href='javascript:void(0)' onclick='show_allExpensesData(${totalPages})'>${totalPages}</a>`;
        }
        paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag next' href='javascript:void(0)' onclick='changePage("next")'>Next</a>`;
    }

    function changePage(direction) 
    {
        if (direction === 'next' && currentPageD < totalPages) 
        {
            currentPageD++;
        } 
        else if (direction === 'prev' && currentPageD > 1) 
        {
            currentPageD--;
        }

        show_allExpensesData(currentPageD, '', '', '');
    }

    function changePageGroup(direction) 
    {
        if (direction === 1 && currentPageDGroup * pagesPerGroup < totalPages) {
            currentPageDGroup++;
        } else if (direction === -1 && currentPageDGroup > 1) {
            currentPageDGroup--;
        }
        updatePaginationButtons();
    }

    show_allExpensesData(1, '', '', '');
   
</script>
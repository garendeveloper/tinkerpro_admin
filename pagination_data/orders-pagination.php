<?php
    include(__DIR__ . '/../utils/db/connector.php');
    include(__DIR__ . '/../utils/models/product-facade.php');
    include(__DIR__ . '/../utils/models/order-facade.php');

    $orderfacade = new OrderFacade;

    $totalRecords = $orderfacade->get_totalOrders();
    $totalPages = ceil($totalRecords / 100);
    echo "<div id='paginationBtns'>";
    echo "<a  class='paginationButtons paginationTag prev' href='javascript:void(0)' onclick='changePage(\"prev\")'>Prev</a>";

    for ($i = 1; $i <= min(20, $totalPages); $i++) {
        $activeClass = ($i == 1) ? 'active' : '';
        echo "<a  class='paginationButtons paginationTag $activeClass' href='javascript:void(0)' onclick='show_allOrderData($i)'>$i</a> ";
    }

    if ($totalPages > 20) {
        echo "<a  class='paginationButtons paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>";
        echo "<a  class='paginationButtons paginationTag' href='javascript:void(0)' onclick='show_allOrderData($totalPages)'>$totalPages</a> ";
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
    .inventoryCard thead tr th{
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
    $(".inventoryCard").html();

    var tblData = `
              <table tabindex = '0' id='tbl_orders' class='text-color table-border display' style='font-size: 12px; margin-top: -8px; margin-right: -10px; margin-left: -3px; width: 100%;'>
                  <thead>
                      <tr>
                          <th style='width: 2%;'>PO Number</th>
                          <th style='width: 4%;'>Supplier</th>
                          <th style='width: 2%;'>Date Purchased</th>
                          <th style='width: 2%;'>Due Date</th>
                          <th style='width: 2%;'>Qty</th>
                          <th style='width: 2%;'>Price</th>
                          <th style='width: 2%;'>Total</th>
                          <th style='width: 2%;'>Payment Status</th>
                          <th style='width: 2%;'>Status</th>
                          <th style='width: 1%;' class='autofit'>Action</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table> `;

    $(".inventoryCard").html(tblData);
 
    $("#searchInput").on("input", function(){
        var searchInput = $(this).val();
        $.ajax({
            url: './fetch-data/fetch-orders.php',
            type: 'GET',
            data: { searchInput:searchInput },
            success: function (response) {
             $('#tbl_orders tbody').html(response);
             display_records();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    })
   
    function show_allOrderData(page)
    {
        currentPageD = page;
        $('.paginationTag').removeClass('active');
        $('.paginationTag').eq(page - 1).addClass('active');
        $('#searchInput').focus();
        $.ajax({
            url: './fetch-data/fetch-orders.php',
            type: 'GET',
            data: { page: currentPageD },
            success: function (response) {
                $('#tbl_orders tbody').html(response);
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
            <table tabindex='0' style='width: 100%;' id="tbl_previewRecord">
                <tbody>
                   <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Items:</th>
                        <th style="background-color: #262626; border: 1px solid #262626; "  class = "text-right"  id="total_items"></th>
                    </tr>
                    <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Qty Purchased:</th>
                        <th style="background-color: #262626; border: 1px solid #262626; "  class = "text-right"  id="total_qty_purchased"></th>
                    </tr>
                     <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Price:</th>
                        <th  class = "text-right" style="background-color: #262626; border: 1px solid #262626;" id="total_pp"></th>
                    </tr>
                    <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Overall Total:</th>
                        <th  class = "text-right" style="background-color: #262626; border: 1px solid #262626;" id="total_pot"></th>
                    </tr>
                    </tr>
                </tbody>
            </table>
        `;

        var totalQtyP = 0;  
        var totalPP = 0;
        var totalPOT = 0;

        var itemCount = $('.inventoryCard #tbl_orders tbody tr').length;
        $('.inventoryCard #tbl_orders tbody tr').each(function() {
            var qty_purchased = removeCommas($(this).find('td:eq(4)').text().trim());
            qty_purchased = parseFloat(qty_purchased);
            if (!isNaN(qty_purchased)) 
            {
                totalQtyP += qty_purchased;
            }

            var pp = removeCommas($(this).find('td:eq(5)').text().trim());
            pp = parseFloat(pp);
            if (!isNaN(pp)) 
            {
                totalPP += pp;
            }

            var pot = removeCommas($(this).find('td:eq(6)').text().trim());
            pot = parseFloat(pot);
            if (!isNaN(pot)) 
            {
                totalPOT += pot;
            }
        });
      
        $("#preview_records").html(table);
        $('#total_items').text(numberWithCommas(itemCount));
        $('#total_qty_purchased').text(numberWithCommas(totalQtyP.toFixed(2)));
        $('#total_pp').text(numberWithCommas(totalPP.toFixed(2)));
        $('#total_pot').text(numberWithCommas(totalPOT.toFixed(2)));
    }
    $(".inventoryCard tbody").on("click", "tr", function(e){
        e.preventDefault();
        $(".inventoryCard  tbody").find("tr").removeClass('highlightedss')
        $(this).toggleClass('highlightedss');
    })
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
            paginationBtns.innerHTML += `<a style='${styleString}' class='paginationTag ${activeClass}' href='javascript:void(0)' onclick='show_allOrderData(${i})'>${i}</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag' href='javascript:void(0)' onclick='show_allOrderData(${totalPages})'>${totalPages}</a>`;
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

        show_allOrderData(currentPageD);
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

    show_allOrderData(1);
   
</script>
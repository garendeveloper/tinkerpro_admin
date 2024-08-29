<?php
    include(__DIR__ . '/../utils/db/connector.php');
    include(__DIR__ . '/../utils/models/product-facade.php');
    include( __DIR__ . '/../utils/models/loss_and_damage-facade.php');

    $loss_and_damage = new Loss_and_damage_facade();

    $totalRecords = $loss_and_damage->total_lossAndDamagesInfo();
    $totalPages = ceil($totalRecords / 100);
    echo "<div id='paginationBtns'>";
    echo "<a  class='paginationButtons paginationTag prev' href='javascript:void(0)' onclick='changePage(\"prev\")'>Prev</a>";

    for ($i = 1; $i <= min(20, $totalPages); $i++) {
        $activeClass = ($i == 1) ? 'active' : '';
        echo "<a  class='paginationButtons paginationTag $activeClass' href='javascript:void(0)' onclick='show_allLossAndDamagesData($i)'>$i</a> ";
    }

    if ($totalPages > 20) {
        echo "<a  class='paginationButtons paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>";
        echo "<a  class='paginationButtons paginationTag' href='javascript:void(0)' onclick='show_allLossAndDamagesData($totalPages)'>$totalPages</a> ";
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
    $(".inventoryCard").html("");

    var tblData = `
    <div class="wrapper">
             <table id='tbl_all_lostanddamages' class='text-color table-border display' style='font-size: 12px; margin-top: -8px; margin-right: -10px; margin-left: -3px; width: 100%;'>
                <thead class='adminTableHead'>
                    <tr>
                        <th class='autofit'>Reference No.</th>
                        <th style = 'text-align:center'>Date of Transaction</th>
                        <th style = 'text-align:center;'>Reason</th>
                        <th style = 'text-align:center'>Total Qty</th>
                        <th style = 'text-align:center'>Total Cost</th>
                        <th style = 'text-align:center'>Overall Cost</th>
                        <th style = 'text-align:center'>Note</th>
                        <th style = 'text-align:center' class='autofit'>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>
              </div>`;

    $(".inventoryCard").html(tblData);
 
    $("#searchInput").on("input", function(){
        var searchInput = $(this).val();
        $.ajax({
            url: './fetch-data/fetch-lossanddamages.php',
            type: 'GET',
            data: { searchInput:searchInput },
            success: function (response) {
             $('#tbl_all_lostanddamages tbody').html(response);
             display_records();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    })
    function show_allLossAndDamagesData(page)
    {
        currentPageD = page;
        $('.paginationTag').removeClass('active');
        $('.paginationTag').eq(page - 1).addClass('active');
        $('#searchInput').focus();
        $.ajax({
            url: './fetch-data/fetch-lossanddamages.php',
            type: 'GET',
            data: { page: currentPageD },
            success: function (response) {
                $('#tbl_all_lostanddamages tbody').html(response);
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
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Qty Damage:</th>
                        <th style="background-color: #262626; border: 1px solid #262626; "  class = "text-right"  id="total_qtyD"></th>
                    </tr>
                     <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Cost:</th>
                        <th  class = "text-right" style="background-color: #262626; border: 1px solid #262626;" id="total_cd"></th>
                    </tr>
                    <tr style="background-color: #262626; font-size: 12px;">
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Overall Total Cost:</th>
                        <th  class = "text-right" style="background-color: #262626; border: 1px solid #262626; color: #F08080" id="total_cot"></th>
                    </tr>
                    </tr>
                </tbody>
            </table>
        `;

        var totalqd = 0;
        var totalcd = 0;
        var totalcot = 0;

        var itemCount = $('.inventoryCard #tbl_all_lostanddamages tbody .tbl_rows').length;
        $('.inventoryCard #tbl_all_lostanddamages tbody tr').each(function() {
            var qd = removeCommas($(this).find('td:eq(3)').text().trim());
            qd = parseFloat(qd);
            if (!isNaN(qd)) 
            {
                totalqd += qd;
            }

            var cd = removeCommas($(this).find('td:eq(4)').text().trim());
            cd = parseFloat(cd);
            if (!isNaN(cd)) 
            {
                totalcd += cd;
            }

            var cot = removeCommas($(this).find('td:eq(5)').text().trim());
            cot = parseFloat(cot);
            if (!isNaN(cot)) 
            {
                totalcot += cot;
            }
        });
      
        $("#preview_records").html(table);
        $('#total_items').text(numberWithCommas(itemCount));
        $('#total_qtyD').text(numberWithCommas(totalqd.toFixed(2)));
        $('#total_cd').text(numberWithCommas(totalcd.toFixed(2)));
        $('#total_cot').text(numberWithCommas(totalcot.toFixed(2)));
    }
    $(".inventoryCard tbody").on("click", ".tbl_rows", function(e){
        e.preventDefault();
        $(".inventoryCard  tbody ").find(".tbl_rows").removeClass('highlightedss')
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
            paginationBtns.innerHTML += `<a style='${styleString}' class='paginationTag ${activeClass}' href='javascript:void(0)' onclick='show_allLossAndDamagesData(${i})'>${i}</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag' href='javascript:void(0)' onclick='show_allLossAndDamagesData(${totalPages})'>${totalPages}</a>`;
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

        show_allLossAndDamagesData(currentPageD);
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

    show_allLossAndDamagesData(1);
   
</script>
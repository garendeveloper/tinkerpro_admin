<?php
    include(__DIR__ . '/../utils/db/connector.php');
    include(__DIR__ . '/../utils/models/product-facade.php');
    include( __DIR__ . '/../utils/models/inventory-facade.php');

    $inventoryfacade = new InventoryFacade();

    $totalRecords = $inventoryfacade->total_forExpiringProducts();
    $totalPages = ceil($totalRecords / 100);
    echo "<div id='paginationBtns'>";
    echo "<a  class='paginationButtons paginationTag prev' href='javascript:void(0)' onclick='changePage(\"prev\")'>Prev</a>";

    for ($i = 1; $i <= min(20, $totalPages); $i++) {
        $activeClass = ($i == 1) ? 'active' : '';
        echo "<a  class='paginationButtons paginationTag $activeClass' href='javascript:void(0)' onclick='show_allForExpiringProductsData($i)'>$i</a> ";
    }

    if ($totalPages > 20) {
        echo "<a  class='paginationButtons paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>";
        echo "<a  class='paginationButtons paginationTag' href='javascript:void(0)' onclick='show_allForExpiringProductsData($totalPages)'>$totalPages</a> ";
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

    var tblData =`<table id="tbl_expiredProducts" class="text-color table-border" style='font-size: 12px; margin-top: -8px; margin-right: -10px; margin-left: -3px; width: 100%'>
                          <thead>
                              <tr>
                                  <th>Product</th>
                                  <th>Barcode</th>
                                  <th style="text-align: center">Expiration Date</th>
                                  <th style="text-align: center; background-color: red">Days Remaining</th>
                              </tr>
                          </thead>
                          <tbody></tbody>
                      </table>`;

    $(".inventoryCard").html(tblData);
 
    $("#searchInput").on("input", function(){
        var searchInput = $(this).val();
        $.ajax({
            url: './fetch-data/fetch-expirations.php',
            type: 'GET',
            data: { searchInput:searchInput },
            success: function (response) {
             $('#tbl_expiredProducts tbody').html(response);
             display_records();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    })
    function show_allForExpiringProductsData(page)
    {
        currentPageD = page;
        $('.paginationTag').removeClass('active');
        $('.paginationTag').eq(page - 1).addClass('active');
        $('#searchInput').focus();
        $.ajax({
            url: './fetch-data/fetch-expirations.php',
            type: 'GET',
            data: { page: currentPageD },
            success: function (response) {
                $('#tbl_expiredProducts tbody').html(response);
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
                </tbody>
            </table>
        `;

        var totalQtyS = 0;

        var itemCount = $('.inventoryCard #tbl_expiredProducts  tbody tr').length;
        $("#preview_records").html(table);
        $('#total_items').text(numberWithCommas(itemCount));
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
            paginationBtns.innerHTML += `<a style='${styleString}' class='paginationTag ${activeClass}' href='javascript:void(0)' onclick='show_allForExpiringProductsData(${i})'>${i}</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag' href='javascript:void(0)' onclick='show_allForExpiringProductsData(${totalPages})'>${totalPages}</a>`;
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

        show_allForExpiringProductsData(currentPageD);
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

    show_allForExpiringProductsData(1);
   
</script>
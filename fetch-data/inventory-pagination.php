<?php
    include(__DIR__ . '/../utils/db/connector.php');
    include(__DIR__ . '/../utils/models/product-facade.php');
    include(__DIR__ . '/../utils/models/inventory-facade.php');

    $inventoryfacade = new InventoryFacade;

    $totalRecords = $inventoryfacade->get_totalInventories();
    $totalPages = ceil($totalRecords / 100);
    // echo "<div id='paginationBtns'>";
    // for ($i = 1; $i <= $totalPages; $i++) 
    // {
    //     $activeClass = ($i == 1) ? 'active' : ''; 
    //     echo "<a class='paginationTag $activeClass' href='javascript:void(0)' onclick='show_allInventoriesData($i)' data-page = '$i'>$i</a> ";
    // }
    // echo "</div>";
    echo "<div id='paginationBtns'>";
    echo "<a  class='paginationButtons paginationTag prev' href='javascript:void(0)' onclick='changePage(\"prev\")'>Prev</a>";

    for ($i = 1; $i <= min(20, $totalPages); $i++) {
        $activeClass = ($i == 1) ? 'active' : '';
        echo "<a  class='paginationButtons paginationTag $activeClass' href='javascript:void(0)' onclick='show_allInventoriesData($i)'>$i</a> ";
    }

    if ($totalPages > 20) {
        echo "<a  class='paginationButtons paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>";
        echo "<a  class='paginationButtons paginationTag' href='javascript:void(0)' onclick='show_allInventoriesData($totalPages)'>$totalPages</a> ";
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

</style>

<script>
    let currentPage = 1;
    let currentPageGroup = 1;
    const pagesPerGroup = 20;
    const totalPages = <?php echo $totalPages; ?>;

    $('#searchInput').focus();
    var tblData = `
        <table tabindex='0' id='tbl_products' class='' style='font-size: 12px; margin-top: -20px; margin-right: -10px; margin-left: -3px; width: 100%;'>
            <thead >
                <tr>
                    <th class='text-center ' >No.</th>
                    <th>Product</th>
                    <th >Barcode</th>
                    <th>UOM</th>
                    <th  >Qty Purchased</th>
                    <th  style='text-align: center'>Qty Received</th>
                    <th  style='text-align: center'>Qty in Store</th>
                    <th  style='text-align: center'>Amount Before Tax</th>
                    <th  style='text-align: center'>Amount After Tax</th>
                    <th style='text-align: center'>Document Type</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table> 
        `;
    $(".inventoryCard").html(tblData);
 
    $("#searchInput").on("input", function(){
        var searchInput = $(this).val();
        $.ajax({
            url: './fetch-data/fetch-inventories.php',
            type: 'GET',
            data: { searchInput:searchInput },
            success: function (response) {
             $('#tbl_products tbody').html(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    })
    function show_allInventoriesData(page)
    {
      $('.paginationTag').removeClass('active');
      $('.paginationTag').eq(page - 1).addClass('active');
      $('#searchInput').focus();
      $.ajax({
        url: './fetch-data/fetch-inventories.php',
        type: 'GET',
        data: { page: page },
        success: function (response) {
          $('#tbl_products tbody').html(response);
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
      updatePaginationButtons();
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
        if (currentPageGroup > 1) 
        {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(-1)'>...</a>`;
        }
        const startPage = (currentPageGroup - 1) * pagesPerGroup + 1;
        const endPage = Math.min(currentPageGroup * pagesPerGroup, totalPages);

        for (let i = startPage; i <= endPage; i++) 
        {
            let styleString = '';

            if (i == currentPage) {
                styleString = 'border-radius: 50%; background: transparent; border: 1px solid var(--primary-color); color: #fff';
            } else {
                styleString = 'border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff';
            }

            const activeClass = (i == currentPage) ? 'active' : '';
            paginationBtns.innerHTML += `<a style='${styleString}' class='paginationTag ${activeClass}' href='javascript:void(0)' onclick='show_allInventoriesData(${i})'>${i}</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag' href='javascript:void(0)' onclick='show_allInventoriesData(${totalPages})'>${totalPages}</a>`;
        }
        paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag next' href='javascript:void(0)' onclick='changePage("next")'>Next</a>`;
    }

    function changePage(direction) 
    {
        if (direction === 'next' && currentPage < totalPages) 
        {
            currentPage++;
        } 
        else if (direction === 'prev' && currentPage > 1) 
        {
            currentPage--;
        }

        show_allInventoriesData(currentPage);
    }

    function changePageGroup(direction) 
    {
        if (direction === 1 && currentPageGroup * pagesPerGroup < totalPages) {
            currentPageGroup++;
        } else if (direction === -1 && currentPageGroup > 1) {
            currentPageGroup--;
        }
        updatePaginationButtons();
    }

    show_allInventoriesData(1);
   
</script>
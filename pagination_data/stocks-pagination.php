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
    //     echo "<a class='paginationTag $activeClass' href='javascript:void(0)' onclick='show_allStocksData($i)' data-page = '$i'>$i</a> ";
    // }
    // echo "</div>";
    echo "<div id='paginationBtns'>";
    echo "<a  class='paginationButtons paginationTag prev' href='javascript:void(0)' onclick='changePage(\"prev\")'>Prev</a>";

    for ($i = 1; $i <= min(20, $totalPages); $i++) {
        $activeClass = ($i == 1) ? 'active' : '';
        echo "<a  class='paginationButtons paginationTag $activeClass' href='javascript:void(0)' onclick='show_allStocksData($i)'>$i</a> ";
    }

    if ($totalPages > 20) {
        echo "<a  class='paginationButtons paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>";
        echo "<a  class='paginationButtons paginationTag' href='javascript:void(0)' onclick='show_allStocksData($totalPages)'>$totalPages</a> ";
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
        <table tabindex='0' id='tbl_all_stocks' class='' style='font-size: 12px; margin-top: -8px; margin-right: -10px; margin-left: -3px; width: 100%;'>
            <thead class='adminTableHead'>
                <tr >
                    <th style = "width: 5%" >No.</th>
                    <th style = "width: 20%" >Product</th>
                    <th>Barcode</th>
                    <th>UOM</th>
                    <th class = "text-center">Qty in Store</th>
                    <th style='text-align: center; ;width: 5%'>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table> 
        </div>
        `;
    $(".inventoryCard").html(tblData);
 
    $("#searchInput").on("input", function(){
        var searchInput = $(this).val();
        $.ajax({
            url: './fetch-data/fetch-stocks.php',
            type: 'GET',
            data: { searchInput:searchInput },
            success: function (response) {
             $('#tbl_all_stocks tbody').html(response);
             display_records();
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    })
    function show_allStocksData(page)
    {
        currentPageD = page;
        $('.paginationTag').removeClass('active');
        $('.paginationTag').eq(page - 1).addClass('active');
        $('#searchInput').focus();
        $.ajax({
            url: './fetch-data/fetch-stocks.php',
            type: 'GET',
            data: { page: currentPageD },
            success: function (response) {
                $('#tbl_all_stocks tbody').html(response);
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
                        <th class='autofit text-right' style="background-color: #262626; border: 1px solid #262626;">Total Qty In Store:</th>
                        <th  class = "text-right" style="background-color: #262626; border: 1px solid #262626;" id="total_qty_store"></th>
                    </tr>
                </tbody>
            </table>
        `;

        var totalQtyS = 0;

        var itemCount = $('.inventoryCard #tbl_all_stocks tbody .tbl_rows').length;
        $('.inventoryCard #tbl_all_stocks tbody tr').each(function() {
            var qs = removeCommas($(this).find('td:eq(4)').text().trim());
            qs = parseFloat(qs);
            if (!isNaN(qs)) 
            {
                totalQtyS += qs;
            }
        });
      
        $("#preview_records").html(table);
        $('#total_items').text(numberWithCommas(itemCount));
        $('#total_qty_store').text(numberWithCommas(totalQtyS.toFixed(2)));
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
            paginationBtns.innerHTML += `<a style='${styleString}' class='paginationTag ${activeClass}' href='javascript:void(0)' onclick='show_allStocksData(${i})'>${i}</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>`;
        }
        if (endPage < totalPages) {
            paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag' href='javascript:void(0)' onclick='show_allStocksData(${totalPages})'>${totalPages}</a>`;
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

        show_allStocksData(currentPageD);
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

    show_allStocksData(1);



     
 // for moving up and down using keyboard
$(document).ready(function() {
  // Handle row click to highlight
  $(document).on("click", "#tbl_all_stocks tbody tr", function(e) {
    e.preventDefault();
    $(this).siblings().removeClass('highlightedss');
    $(this).addClass('highlightedss');
  });

  // Handle keyboard navigation
  $(document).on("keydown", function(e) {
    var $highlighted = $("#tbl_all_stocks tbody tr.highlightedss");
    if ($highlighted.length) {
      var $next, $prev;
      var $tableBody = $("#tbl_all_stocks tbody");
      var $tableContainer = $("#responsive-data");
      var tableBodyHeight = $tableBody.height();
      var tableContainerHeight = $tableContainer.height();
      var rowHeight = $highlighted.outerHeight();

      if (e.key === "ArrowDown") {
        // Move to the next row
        $next = $highlighted.next('tr');
        if ($next.length) {
          $highlighted.removeClass('highlightedss');
          $next.addClass('highlightedss');

          // Scroll to the next row if needed
          var nextOffsetTop = $next.position().top + $tableBody.scrollTop();
          var visibleBottom = $tableBody.scrollTop() + tableBodyHeight;

          if (nextOffsetTop > visibleBottom) {
            $tableBody.scrollTop(nextOffsetTop - tableBodyHeight + rowHeight);
          }

          // Ensure horizontal scroll stays in sync
          var nextOffsetLeft = $next.position().left + $tableBody.scrollLeft();
          $tableContainer.scrollLeft(nextOffsetLeft - $tableContainer.width() / 2);
        }
        e.preventDefault();
      } else if (e.key === "ArrowUp") {
        // Move to the previous row
        $prev = $highlighted.prev('tr');
        if ($prev.length) {
          $highlighted.removeClass('highlightedss');
          $prev.addClass('highlightedss');

          // Scroll to the previous row if needed
          var prevOffsetTop = $prev.position().top + $tableBody.scrollTop();
          var visibleTop = $tableBody.scrollTop();  + tableBodyHeight;

          if (prevOffsetTop < visibleTop) {
            $tableBody.scrollTop(prevOffsetTop);
          }

          // Ensure horizontal scroll stays in sync
          var prevOffsetLeft = $prev.position().left + $tableBody.scrollLeft();
          $tableContainer.scrollLeft(prevOffsetLeft - $tableContainer.width() / 2);
        }
        e.preventDefault();
      }
    }
  });
});
   
</script>
<?php
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/product-facade.php');
include(__DIR__ . '/../utils/models/inventory-facade.php');

$inventoryfacade = new InventoryFacade;

$totalRecords = $inventoryfacade->get_totalInventories();
$totalPages = ceil($totalRecords / 100);
echo "<div id='paginationBtns'>";
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == 1) ? 'active' : ''; // Add 'active' class to the first button initially
    echo "<a class='paginationTag $activeClass' href='javascript:void(0)' onclick='show_allInventories($i)' data-page = '$i'>$i</a> ";
}
echo "</div>";

?>
<script>
 
    function show_allInventories(page)
    {
      $('.paginationTag').removeClass('active');
      $('.paginationTag').eq(page - 1).addClass('active');
      $('.searchProducts').focus();
      $('#modalCashPrint').show();
      var tblData = `
          <table tabindex='0' id='tbl_products' class='' style='font-size: 12px; margin-top: -20px; margin-right: 15px; margin-left: -3px; width: 100%;'>
               <thead >
                  <tr style = "background-color: none">
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
      $.ajax({
        url: './fetch-data/fetch-inventories.php',
        type: 'GET',
        data: { page: page },
        success: function (response) {
          $('#tbl_products tbody').html(response);
          $('#modalCashPrint').hide();
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }
    show_allInventories(1);
   
</script>
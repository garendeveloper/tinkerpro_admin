<?php
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/supplier-facade.php');
include(__DIR__ . '/../utils/models/user-facade.php');

$supplierFacade = new SupplierFacade;


$searchQuery = $_GET['searchQuery'] ?? null;

// $selectedIngredients = $_GET['selectedIngredients'] ?? null;
// Fetch users with pagination
$fetchSupplier = $supplierFacade->getSupplierAndSuppliedData($searchQuery);
$counter = 1;

ob_start();
if ($fetchSupplier->rowCount() > 0) {
while ($row = $fetchSupplier->fetch(PDO::FETCH_ASSOC)) {
//   var_dump( $row)
    ?>
    <tr class="table-row supplier-rows">
    <td class='text-center child-a' ><?= $counter?></td>
    <td hidden class='text-center action-td supplierStatus'><?= $row['status'] ?? null ?></td>
    <td hidden class='text-center action-td supplierId'><?= $row['id'] ?? null ?></td>
    <td class='text-left action-td supplierName child-b'><?= $row['name'] ?? null ?></td>//
    <td class='text-center action-td supplierContact child-c'><?= $row['contact'] ?? null ?></td>
    <td class='text-left action-td supplierEmail child-d'><?= $row['email'] ?? null ?></td>
    <td class='text-left action-td supplierCompany child-e'><?= $row['company'] ?? null ?></td>
    <td class='text-center action-td child-f' style='color: <?= $row['status'] === 1 ? 'green' : 'red' ?>;'>
    <?= $row['status']=== 1 ? 'Active' : 'Inactive' ?></td>
    <td  class='text-center action-td child-g'>
               <a class='text-success editSupplier' style='text-decoration: none;'>
               <i class = "bi bi-pencil-square normalIcon" style = "font-size: 16px; color: white"></i>
               </a>
               <a class='text-success deleteSupplier' style='text-decoration: none;'>
                    <i class = "bi bi-trash3 deleteIcon" style = "font-size: 16px; color: white"></i>
               </a>
            <?php 
            ?>
        </td>
</tr>
    <?php
    $counter++;
}
} else {
    ?>
    <tr>
        <td colspan="100%" rowspan="100%" style="text-align: center; padding: 20px; border: 1px solid transparent !important">
        No data found.
        </td>
    </tr>
    <?php
}


$html = ob_get_clean();
echo $html;

?>


<script>
$(document).ready(function() {
    // Add click event listener to table rows
    $(document).on('click', '.supplier-rows', function() {
        // Check if the modal is visible
        if ($('#add_supplier_modal').is(':visible')) {
            closeAddSupplierModal();
        }
    });

    // Prevent modal from closing when clicking inside the modal
    $(document).on('click', '#add_supplier_modal, .supplier-modal', function(event) {
        event.stopPropagation();
    });

    // Add click event listener to edit icon to open the modal
    $(document).on('click', '.editSupplier', function(event) {
        event.stopPropagation(); // Prevent this click from closing the modal
     
        $('#add_supplier_modal').show(); 
        $('.supplier-modal').show(); 
    });
});



  // for moving up and down using keyboard
  $(document).ready(function() {
  // Handle row click to highlight
  $(document).on("click", "#recentsuppliers tbody tr", function(e) {
    e.preventDefault();
    $(this).siblings().removeClass('highlighteds');
    $(this).addClass('highlighteds');
  });

  // Handle keyboard navigation
  $(document).on("keydown", function(e) {
    var $highlighted = $("#recentsuppliers tbody tr.highlighteds");
    if ($highlighted.length) {
      var $next, $prev;
      if (e.key === "ArrowDown") {
        // Move to the next row
        $next = $highlighted.next('tr');
        if ($next.length) {
          $highlighted.removeClass('highlighteds');
          $next.addClass('highlighteds');
        }
        e.preventDefault();
      } else if (e.key === "ArrowUp") {
        // Move to the previous row
        $prev = $highlighted.prev('tr');
        if ($prev.length) {
          $highlighted.removeClass('highlighteds');
          $prev.addClass('highlighteds');
        }
        e.preventDefault();
      }
    }
  });
});

</script>


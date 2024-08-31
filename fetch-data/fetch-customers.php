<?php
include(__DIR__ . '/../utils/db/connector.php');
include(__DIR__ . '/../utils/models/customer-facade.php');
include(__DIR__ . '/../utils/models/user-facade.php');

$customerFacade = new CustomerFacade;


$searchQuery = $_GET['searchQuery'] ?? null;

$customer = $customerFacade->getCustomersData($searchQuery);
$counter = 1;

ob_start();
    if ($customer->rowCount() > 0) {
        while ($row = $customer->fetch(PDO::FETCH_ASSOC)) 
        {
        //   var_dump( $row)
            ?>
            <tr class="table-row customer-row" >
            <td class='text-center col-1 child-a' ><?= $counter?></td>
            <td hidden class='text-center action-td td-h'><span class="userId"><?= $row['id'] ?? null ?></span><span class="customerId"><?= $row['customerId'] ?? null ?></span></td>
            <td class='text-light child-b' style = "padding-left: 10px !important;"><span class="firstName text-light"><?= $row['firstname'] ?? null ?></span>&nbsp;<span class="lastName text-light"><?= $row['lastname'] ?? null ?></span></td>
            <td class='action-td text-center customerContact child-c'><?= $row['contact'] ?? null ?></td>
            <td class='action-td text-center customerCode  child-d'><?= $row['code'] ?? null ?></td>
            <td class='text-center action-td child-e discountType' data-discountID = '<?= $row['discount_id']?>' data-childName = '<?= $row['child_name']?>' data-childBirth = '<?= $row['child_birth']?>' data-childAge = '<?= $row['child_age']?>'>
              <?= $row['name'] ?>
            </td>
            <td hidden class='text-center action-td pwdID'><?= $row['pwdOrScId'] ?? null ?></td>
            <td hidden class='text-center action-td pwdTIN'><?= $row['scOrPwdTIN'] ?? null ?></td>
            <td hidden class='text-center action-td dueDate'><?= $row['dueDateInterval'] ?? null ?></td>
            <td hidden class='text-center action-td taxExempt'><?= $row['is_tax_exempt'] ?? null ?></td>
            <td hidden class='text-center action-td customerType' ><?= $row['type'] ?? null ?></td>
            <td class='action-td customerEmail child-f' style = "padding-left: 10px !important;"><?= $row['email'] ?? null ?></td>
            <td class='action-td customerAddress child-g' style = "padding-left: 10px !important;"><?= $row['address'] ?? null ?></td>
            <td class='text-center action-td td-h child-h' style="border-right: 1px solid transparent !important">
                <a class='text-success editCustomer' style='text-decoration: none; cursor: pointer;'>
                    <i class = "bi bi-pencil-square normalIcon" style = "font-size: 16px; color: white"></i>
                </a>

                <?php 
                if ($row['firstname'] != 'Unknown') { ?>
                    <a class='text-success deleteCustomer' style='text-decoration: none; cursor: pointer;'>
                        <i class = "bi bi-trash3 deleteIcon" style = "font-size: 16px; color: white"></i>
                    </a>
                <?php } ?>
                
            </td>
            <?php
            $counter++;
        }
    } else {
    ?>
    <tr style="border: none">
        <td colspan="100%" rowspan="100%" style="text-align: center; padding: 20px; border: 1px solid transparent !important">
            <!-- <img src="./assets/img/no-data.png" alt="No Products Found" style="display: block; margin: 0 auto 10px auto;"><br> -->
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
    $(document).on('click', '.customer-row', function() {
        // Check if the modal is visible
        if ($('#add_customer_modal').is(':visible')) {
            closeAddingModal();
        }
    });

    // Prevent modal from closing when clicking inside the modal
    $(document).on('click', '#add_customer_modal, .customer-modal', function(event) {
        event.stopPropagation();
    });

    // Add click event listener to edit icon to open the modal
    $(document).on('click', '.editCustomer', function(event) {
        event.stopPropagation(); // Prevent this click from closing the modal
     
        $('#add_customer_modal').show(); 
        $('.customer-modal').show(); 
    });
});



  // for moving up and down using keyboard
  $(document).ready(function() {
  // Handle row click to highlight
  $(document).on("click", "#recentusers tbody tr", function(e) {
    e.preventDefault();
    $(this).siblings().removeClass('highlighteds');
    $(this).addClass('highlighteds');
  });

  // Handle keyboard navigation
  $(document).on("keydown", function(e) {
    var $highlighted = $("#recentusers tbody tr.highlighteds");
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


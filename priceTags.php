<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/product-facade.php');
  include( __DIR__ . '/utils/models/ingredients-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');
  include(__DIR__ . '/utils/models/supplier-facade.php');
  
  $productFacade = new ProductFacade;

  $userId = 0;
  
  $abilityFacade = new AbilityFacade;

  if (isset($_SESSION['totalPages'])) {
    $totalPages = $_SESSION['totalPages'];
    unset($_SESSION['totalPages']); 
}

if (isset($_SESSION['user_id'])) {
 
    $userID = $_SESSION['user_id'];

    
    $permissions = $abilityFacade->perm($userID);

    
    $accessGranted = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Products']) && $permission['Products'] == "Access Granted") {
            $accessGranted = true;
            break;
        }
    }
    if (!$accessGranted) {
      header("Location: 403.php");
      exit;
  }
} else {
    header("Location: login.php");
    exit;

}

  if (isset($_SESSION["user_id"])){
    $userId = $_SESSION["user_id"];
  }
  if (isset($_SESSION["first_name"])){
    $firstName = $_SESSION["first_name"];
  }
  if (isset($_SESSION["last_name"])){
    $lastName = $_SESSION["last_name"];
  }

  if ($userId == 0) {
    header("Location: login");
  }
  if (isset($_GET["add_product"])) {
		$error = $_GET["add_product"];
    array_push($success, $error);
	}
  if (isset($_GET["update_product"])) {
		$error = $_GET["update_product"];
    array_push($info, $error);
	}
  if (isset($_GET["delete_product"])) {
		$error = $_GET["delete_product"];
    array_push($info, $error);
	}

  include('./modals/add-expenses-modal.php');
  include('./modals/category-modal.php');
  include('./modals/add-bom.php');
  include('./modals/add-price-list.php');
  include('./modals/loading-modal.php');
  include ('./modals/pricetagsModal.php'); 
?>


<?php include "layout/admin/css.php"?> 
  <div class="container-scroller">
    <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel">
        <div class="content-wrapper">
        </div>
      </div>
    </div>
  </div>
<?php 
  include("layout/footer.php");
  include("./modals/delete_expense_confirmation.php");
?>
<script>
  $(document).ready(function(){
    $("#price_tags").addClass('active');
    $("#pointer").html("Price Tags");

    $("#optionModal").addClass('slideInRight');
    $(".optionmodal-content").addClass('slideInRight');
    setTimeout(function () {
      $("#optionModal").show();
      $(".optionmodal-content").show();
    }, 100);
  })
</script>

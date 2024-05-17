<?php
   require_once('./utils/models/ability-facade.php');
$userId = 0;



if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $abilityFacade = new AbilityFacade;
    $permissions = $abilityFacade->perm($userId);
    $accessInventory= false;
    $accessProducts = false;
    $accessReporting = false;
    $accessUsers = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Inventory']) && $permission['Inventory'] == "Access Granted") {
            $accessInventory = true;
            break;
        }
    }
    foreach ($permissions as $permission) {
        if (isset($permission['Products']) && $permission['Products'] == "Access Granted") {
            $accessProducts  = true;
            break;
        }
    }
    foreach ($permissions as $permission) {
        if (isset($permission['Reports']) && $permission['Reports'] == "Access Granted") {
            $accessReporting  = true;
            break;
        }
    }
    foreach ($permissions as $permission) {
        if (isset($permission['Users']) && $permission['Users'] == "Access Granted") {
            $accessUsers = true;
            break;
        }
    }
}
?>



<?php include ("./modals/permissionModal.php") ?>
<?php include ("./modals/access_granted.php") ?>
<?php include ("./modals/access_denied.php") ?>



<style>
    .site-header {
        color: #fff;
        padding: 10px 0;
        background-color: #151515;
    }


    .logo {
        margin: 0;
        display: block;
    }

    .sidebar {
        height: 100%;
        width: 200px;
        background-color: #151515;
        position: fixed;
        top: 30px;
        left: 0;
        overflow-x: hidden;
        padding-top: 10px, 0;
    }

    .sidebar a {
        padding: 5px 15px;
        text-decoration: none;
        font-size: 14px;
        color: #ffff;
        font-family: Century Gothic;
        display: block;
        margin-top: 10px;
    }

    .header-container {
        max-width: 1200px;
        margin: 0;
        padding: 0 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar a:hover {
        background-color: #FF6700;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo i {
        margin-right: 4px;
    }

    .sidebar a.active {
        background-color: '#FF6700',
    }

    .sidebar-footer {
        background-color: #151515;
        color: #fff;
        text-align: right; 
        bottom: 0;
        min-height: 5vh; 
    }   



</style>
<header class="site-header">
    <div class="header-container">
        <h6 class="logo">Management&nbsp; <i class="bi bi-globe" style="font-size: 0.5rem;"></i> <span
                id="pointer"></span> </h6>
    </div>
</header>
<div class="sidebar" id="sidebar">
    <a href="index" id="index"><i class="bi bi-house-door"></i>&nbsp; Dashboard</a>
    <?php if ($accessInventory): ?>
        <a href="#" id="inventory"><i class="bi bi-box-seam"></i>&nbsp; Inventory </a>
    <?php endif; ?>
    <?php if ($accessProducts): ?>
        <a href="#" id="products"><i class="bi bi-bag-check"></i>&nbsp; Products</a>
    <?php endif; ?>

    <a href="suppliers" id="suppliers"><i class="bi bi-people bi-3x "></i>&nbsp; Suppliers</a>
    <a href="customer" id="suppliers"><i class="bi bi-people bi-3x "></i>&nbsp; Customers</a>
    <?php if ($accessReporting): ?>
        <a href="#" id="reporting"><i class="bi bi-bar-chart"></i>&nbsp; Reporting</a>
    <?php endif; ?>
    <?php if ($accessUsers): ?>
        <a href="#" id="users"><i class="bi bi-person"></i>&nbsp; Users</a>
    <?php endif; ?>
    <a href="#" id="btn_logout"><i class="bi bi-box-arrow-right"></i>&nbsp; Logout</a>
    <input hidden class="userId" id="userId" value="<?php echo $userId; ?>"/>
    <!-- for v2 -->
    <!-- <a href="company" id="company"><i class="bi bi-building"></i>&nbsp; Company</a>
    <a href="machine-details" id="machine-details"><i class="bi bi-tools"></i>&nbsp; Machine Details</a>
    <a href="backup-restore" id="backup-restore"><i class="bi bi-cloud-arrow-up-fill"></i>&nbsp; Backup & Restore</a> -->
<!-- <a href="ingredients" id="ingredients"><i class="bi bi-egg bi-3x "></i>&nbsp; Ingredients</a> -->
  
</div>
<script>
let  productSValidate  = false;  
let  reportingsValidate = false;
let  inventoryValidate = false;
let  userValidate = false;
$('#products').on('click', function(){
$('#toChangeText').text("Products")
var forUser = document.getElementById('forUser')
forUser.setAttribute('hidden',true)
var forInventory = document.getElementById('forInventory')
forInventory.setAttribute('hidden',true);
var forProducts = document.getElementById('forProducts')
forProducts.removeAttribute('hidden');
var forUsers = document.getElementById('forUsers')
forUsers.setAttribute('hidden',true)
var forReportings = document.getElementById('forReportings')
forReportings.setAttribute('hidden',true);
  userSValidate  = false;  
  productSValidate  = true; 
  reportingsValidate = false;
  inventoryValidate = false;
  userValidate = false;
  permModals() 
})


$('#reporting').on('click', function(){
 $('#toChangeText').text("Reports")
 var forUser = document.getElementById('forUser')
forUser.setAttribute('hidden',true)
var forInventory = document.getElementById('forInventory')
forInventory.setAttribute('hidden',true);
var forReportings = document.getElementById('forReportings')
forReportings.removeAttribute('hidden');
var forProducts = document.getElementById('forProducts')
forProducts.setAttribute('hidden',true);
var forUsers = document.getElementById('forUsers')
forUsers.setAttribute('hidden',true)
  userSValidate  = false;  
  productSValidate  = false;  
  reportingsValidate = true;
  inventoryValidate = false;
  userValidate = false;
  permModals() 
})

$('#inventory').on('click', function(){
 $('#toChangeText').text("Inventory")
var forUser = document.getElementById('forUser')
forUser.setAttribute('hidden',true)
var forInventory = document.getElementById('forInventory')
forInventory.removeAttribute('hidden');
var forReportings = document.getElementById('forReportings')
forReportings.setAttribute('hidden',true);
var forProducts = document.getElementById('forProducts')
forProducts.setAttribute('hidden',true);
var forUsers = document.getElementById('forUsers')
forUsers.setAttribute('hidden',true)
  userSValidate  = false;  
  productSValidate  = false;  
  reportingsValidate = false;
  inventoryValidate = true;
  userValidate = false;
  permModals() 
})
$('#users').on('click', function(){
 $('#toChangeText').text("Users")
var forUser = document.getElementById('forUser')
forUser.removeAttribute('hidden')
var forInventory = document.getElementById('forInventory')
forInventory.setAttribute('hidden',true);
var forReportings = document.getElementById('forReportings')
forReportings.setAttribute('hidden',true);
var forProducts = document.getElementById('forProducts')
forProducts.setAttribute('hidden',true);
var forUsers = document.getElementById('forUsers')
forUsers.setAttribute('hidden',true)
  userSValidate  = false;  
  productSValidate  = false;  
  reportingsValidate = false;
  inventoryValidate = false;
  userValidate = true;
  permModals() 
})
    
    
</script>

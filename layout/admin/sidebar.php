<?php
require_once ('./utils/models/ability-facade.php');
$userId = 0;



if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $abilityFacade = new AbilityFacade;
    $permissions = $abilityFacade->perm($userId);
    $accessInventory = false;
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
            $accessProducts = true;
            break;
        }
    }
    foreach ($permissions as $permission) {
        if (isset($permission['Reports']) && $permission['Reports'] == "Access Granted") {
            $accessReporting = true;
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
        overflow-x: auto;
        overflow-y: auto;
        padding-top: 10px, 0;
        transition: width 0.3s;
    }

    .sidebar a {
        padding: 15px;
        text-decoration: none;
        font-size: 14px;
        color: #ffff;
        font-family: Century Gothic;
        display: block;
        margin-top: 10px;

    }

    .sidebar.collapsed {
        width: 60px;
    }

    .sidebar nav ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar nav ul li {
        margin: 20px 0;
    }

    .sidebar nav ul li a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .sidebar nav ul li a .icon {
        font-size: 24px;
        margin-right: 10px;
    }

    .sidebar.collapsed nav ul li a .text {
        display: none;
    }

    .header-container {
        max-width: 1200px;
        margin: 0;
        padding: 0 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar nav ul li:hover {
        background-color: var(--hover-bg-color);
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo i {
        margin-right: 4px;
    }

    .sidebar a.active {
        background-color: var(--hover-bg-color);
    }
    .sidebar-footer {
        background-color: #151515;
        color: #fff;
        text-align: right;
        bottom: 0;
        min-height: 5vh;
    }

    .main-panel {
        padding: 15px;
        transition: margin-left 0.3s;
    }

    .main-panel.expanded {
        left: 50px;
        width: calc(100% - 50px);
    }
    #top-right-end 
    {
        position: absolute;
        top: 10px; 
        right: 20px; 
        color: white;
        font-family: "Century Gothic";
    }
</style>
<header class="site-header">
    <div class="header-container">
        <h6 class="logo">Management&nbsp; <i class="bi bi-globe" style="font-size: 0.75rem;"></i> <span
                id="pointer"></span> </h6>
        <div class = "justify-content-end" id = "top-right-end">
            <span id = "ct7" style = "color: white; font-family: Century Gothic; font-weight: bold"></span>
            <span style = "color: white; font-family: Century Gothic; font-weight: bold"><i style = "color: lightblue; font-weight: normal">You are logged in as:</i> <span style = "color: green">[<?= $_SESSION['first_name']." ".$_SESSION['last_name']?>]</span></span>
        </div>
    </div>
   
</header>
<div class="sidebar" id="sidebar">
    <nav>
        <ul>
            <li><a href="index" id="index"><i class="bi bi-house-door"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Dashboard</span></a></li>
            <?php if ($accessInventory): ?>
                <li><a href="inventory" id="inventory"><i class="bi bi-box-seam"></i>&nbsp;&nbsp; <span
                            class="text dynamic-color">Inventory</span></a>
                </li>
            <?php endif ?>
            <?php if ($accessProducts): ?>
                <li><a href="products" id="products"><i class="bi bi-bag-check"></i>&nbsp;&nbsp; <span
                            class="text dynamic-color">Products</span></a>
                </li>
            <?php endif ?>
            <li><a href="expenses" id="expenses"><i class="bi bi-wallet"></i>&nbsp;&nbsp; <span
            class="text dynamic-color">Expenses</span></a></li>

            <li><a href="suppliers" id="suppliers"><i class="bi bi-building"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Suppliers</span></a></li>
            <li><a href="customer" id="customers"><i class="bi bi-people"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Customers</span></a></li>
            <?php if ($accessReporting): ?>
                <li><a href="reporting" id="reporting"><i class="bi bi-bar-chart"></i>&nbsp;&nbsp; <span
                            class="text dynamic-color">Reporting</span></a>
                </li>
            <?php endif ?>
            <?php if ($accessUsers): ?>
                <li><a href="users" id="users"><i class="bi bi-person"></i>&nbsp;&nbsp; <span class="text dynamic-color">Users</span></a></li>
            <?php endif ?>
            <li><a href="coupons" id="coupons"><i class="bi bi-ticket"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Coupons</span></a></li>
            <li><a href="charges" id="coupons"><i class="bi bi-gear-fill"></i>&nbsp;&nbsp; <span
            class="text dynamic-color">Charges</span></a></li>
            <li><a href="#" id="btn_logout"><i class="bi bi-box-arrow-right"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Logout</span></a></li>
            <li><a href="#" id="toggle-sidebar" class="d-flex justify-content-end"><i
                        class="bi bi-chevron-double-left"></i>&nbsp;&nbsp; <span class="text dynamic-color"></span></a></li>
        </ul>
        <input hidden class="userId" id="userId" value="<?php echo $userId; ?>" />
    </nav>
    <!-- for v2 -->
    <!-- <a href="company" id="company"><i class="bi bi-building"></i>&nbsp; Company</a>
    <a href="machine-details" id="machine-details"><i class="bi bi-tools"></i>&nbsp; Machine Details</a>
    <a href="backup-restore" id="backup-restore"><i class="bi bi-cloud-arrow-up-fill"></i>&nbsp; Backup & Restore</a> -->
    <!-- <a href="ingredients" id="ingredients"><i class="bi bi-egg bi-3x "></i>&nbsp; Ingredients</a> -->
        <!-- <li><a href="ingredients" id="ingredients"><i class="bi bi-egg"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Ingredients</span></a></li> --> 

</div>
<script>
    let productSValidate = false;
    let reportingsValidate = false;
    let inventoryValidate = false;
    let userValidate = false;
    // $('#products').on('click', function () {
    //     $('#toChangeText').text("Products")
    //     var forUser = document.getElementById('forUser')
    //     forUser.setAttribute('hidden', true)
    //     var forInventory = document.getElementById('forInventory')
    //     forInventory.setAttribute('hidden', true);
    //     var forProducts = document.getElementById('forProducts')
    //     forProducts.removeAttribute('hidden');
    //     var forUsers = document.getElementById('forUsers')
    //     forUsers.setAttribute('hidden', true)
    //     var forReportings = document.getElementById('forReportings')
    //     forReportings.setAttribute('hidden', true);
    //     userSValidate = false;
    //     productSValidate = true;
    //     reportingsValidate = false;
    //     inventoryValidate = false;
    //     userValidate = false;
    //     permModals()
    // })


    // $('#reporting').on('click', function () {
    //     $('#toChangeText').text("Reports")
    //     var forUser = document.getElementById('forUser')
    //     forUser.setAttribute('hidden', true)
    //     var forInventory = document.getElementById('forInventory')
    //     forInventory.setAttribute('hidden', true);
    //     var forReportings = document.getElementById('forReportings')
    //     forReportings.removeAttribute('hidden');
    //     var forProducts = document.getElementById('forProducts')
    //     forProducts.setAttribute('hidden', true);
    //     var forUsers = document.getElementById('forUsers')
    //     forUsers.setAttribute('hidden', true)
    //     userSValidate = false;
    //     productSValidate = false;
    //     reportingsValidate = true;
    //     inventoryValidate = false;
    //     userValidate = false;
    //     permModals()
    // })

    // $('#inventory').on('click', function () {
    //     $('#toChangeText').text("Inventory")
    //     var forUser = document.getElementById('forUser')
    //     forUser.setAttribute('hidden', true)
    //     var forInventory = document.getElementById('forInventory')
    //     forInventory.removeAttribute('hidden');
    //     var forReportings = document.getElementById('forReportings')
    //     forReportings.setAttribute('hidden', true);
    //     var forProducts = document.getElementById('forProducts')
    //     forProducts.setAttribute('hidden', true);
    //     var forUsers = document.getElementById('forUsers')
    //     forUsers.setAttribute('hidden', true)
    //     userSValidate = false;
    //     productSValidate = false;
    //     reportingsValidate = false;
    //     inventoryValidate = true;
    //     userValidate = false;
    //     permModals()
    // })
    // $('#users').on('click', function () {
    //     $('#toChangeText').text("Users")
    //     var forUser = document.getElementById('forUser')
    //     forUser.removeAttribute('hidden')
    //     var forInventory = document.getElementById('forInventory')
    //     forInventory.setAttribute('hidden', true);
    //     var forReportings = document.getElementById('forReportings')
    //     forReportings.setAttribute('hidden', true);
    //     var forProducts = document.getElementById('forProducts')
    //     forProducts.setAttribute('hidden', true);
    //     var forUsers = document.getElementById('forUsers')
    //     forUsers.setAttribute('hidden', true)
    //     userSValidate = false;
    //     productSValidate = false;
    //     reportingsValidate = false;
    //     inventoryValidate = false;
    //     userValidate = true;
    //     permModals()
    // })


</script>
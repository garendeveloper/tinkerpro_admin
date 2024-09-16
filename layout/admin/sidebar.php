<?php
require_once ('./utils/models/ability-facade.php');
require_once ('./utils/models/product-facade.php');
$userId = 0;



if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $abilityFacade = new AbilityFacade;
    $permissions = $abilityFacade->perm($userId);

    $accessProducts = false;
    $accessInventory = false;
    $accessExpenses = false;
    $accessSupplier = false;
    $accessCustomer = false;
    $accessUsers = false;
    $accessCoupon = false;
    $accessCharges = false;
    $accessPromotions = false;
    $accessPricelist = false;
    $accessPricetag = false;
    $accessReporting = false;
    $accessActivitylogs = false;
 
    foreach ($permissions as $permission) {

        if (isset($permission['Products']) && $permission['Products'] == "Access Granted") {
            $accessProducts = true;
        }
        if (isset($permission['Inventory']) && $permission['Inventory'] == "Access Granted") {
            $accessInventory = true;
        }
        //new
        if (isset($permission['Expenses']) && $permission['Expenses'] == "Access Granted") {
            $accessExpenses = true;
        }
        if (isset($permission['Supplier']) && $permission['Supplier'] == "Access Granted") {
            $accessSupplier = true;
        }
        if (isset($permission['Customer']) && $permission['Customer'] == "Access Granted") {
            $accessCustomer = true;
        }
        if (isset($permission['Users']) && $permission['Users'] == "Access Granted") {
            $accessUsers = true;
        }
        if (isset($permission['Coupon']) && $permission['Coupon'] == "Access Granted") {
            $accessCoupon = true;
        }
        if (isset($permission['Charges']) && $permission['Charges'] == "Access Granted") {
            $accessCharges = true;
        }

        if (isset($permission['Promotion']) && $permission['Promotion'] == "Access Granted") {
            $accessPromotions = true;
        }

        if (isset($permission['Pricelist']) && $permission['Pricelist'] == "Access Granted") {
            $accessPricelist = true;
        }

        if (isset($permission['Pricetag']) && $permission['Pricetag'] == "Access Granted") {
            $accessPricetag = true;
        }
       
        if (isset($permission['Reports']) && $permission['Reports'] == "Access Granted") {
            $accessReporting = true;
        }
        if (isset($permission['Activitylogs']) && $permission['Activitylogs'] == "Access Granted") {
            $accessActivitylogs = true;
        }
        
    }
}
?>



<?php include ("./modals/permissionModal.php") ?>
<?php include ("./modals/access_granted.php") ?>
<?php include ("./modals/access_denied.php")

?>


<style>
    .site-header {
        color: #fff;
        padding: 10px 0;
        background-color: #151515;
        border: 1px solid #151515;
        border-top: 1px solid #151515;
    }


    .logo {
        margin: 0;
        display: block;
    }

    .sidebar {
        height: 100%;
        width: 200px;
        background-color: #1e1e1e;
        border: 1px solid #151515;
        border-top: 1px solid #151515;
        position: fixed;
        top: 40px;
        left: 0;
        overflow-x: auto;
        overflow-y: auto;
        padding-top: 10px, 0;
        transition: width 0.3s;
    }

    .sidebar a {
        padding:5px;
        text-decoration: none;
        font-size: 16px;
        color: #ffff;
        font-family: Century Gothic;
        display: block;
        margin-top: 10px;

    }

    .sidebar.collapsed {
        width: 60px;
        background-color: #1e1e1e;
        border: 1px solid #151515;
        border-top: 1px solid #151515;
    }

    .sidebar nav ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar nav ul li {
        margin: 10px 0;
       
        
    }

    .sidebar nav ul li a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        margin-left: 5px;
        line-height: 0;
    }

    .sidebar nav ul li a .icon {
        font-size: 24px;
        margin-right: 30px;
    
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
        background-color: #151515;
        border: 1px solid #151515;
    }

    .sidebar nav ul li:hover {
        background-color: #262626;
        color: #000000;
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

    #toggle-sidebar {
        position: absolute;
        bottom: 50px;
        width: 100%;
        background-color: #1e1e1e; 
        border-top: 1px solid #292928; 
        padding: 10px;
        text-align: center;
    }
    @media screen and (max-width: 1400px) {
     
     .sidebar{
       zoom: 90%;
       margin-top: 2px;
     }
   
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
        <!-- <div>
            <style>
                img {
                    max-width: 100%; 
                    height: auto; 
                    margin: 0 auto; 
                    display: block;
                }

                @media (max-width: 768px) {
                    img {
                        max-width: 200px; 
                    }
                }

                @media (max-width: 480px) {
                    img {
                        max-width: 150px; 
                    }
                }
                li {
                    overflow: hidden;
                }

                .divider {
                    border-bottom: 1px solid #ccc;
                    margin: 20px 0;
                }
            </style>
            <div>
                <?php
                    // $products = new ProductFacade();
                    // $fetchShop = $products->getShopDetails();
                    // $shop = $fetchShop->fetch(PDO::FETCH_ASSOC);
                    // $ipAddress = gethostbyname(gethostname());
                    // $imageFile = "http://".$ipAddress."/tinkerpros/www/assets/company_logo/".$shop['company_logo'];
                ?>
                <img src="" alt="" style="height: 100px; width: 250px;">
            </div>
            
        </div>
        <div class="divider"></div> -->
        <ul>
            <li><a href="index" id="index"><i class="bi bi-house-door"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Dashboard</span></a></li>


            <?php if ($accessProducts): ?>
                <li><a href="products" id="products"><i class="bi bi-bag-check"></i>&nbsp;&nbsp; <span
                            class="text dynamic-color">Products</span></a>
                </li>
            <?php endif ?>
            
            <?php if ($accessInventory): ?>
                <li><a href="inventory" id="inventory"><i class="bi bi-box-seam"></i>&nbsp;&nbsp; <span
                            class="text dynamic-color">Inventory</span></a>
                </li>
            <?php endif ?>
         
            <?php if ($accessExpenses): ?>
            <li><a href="expenses" id="expenses"><i class="bi bi-wallet"></i>&nbsp;&nbsp; <span
            class="text dynamic-color">Expenses</span></a></li>
            <?php endif ?>

            <?php if ($accessSupplier): ?>
            <li><a href="suppliers" id="suppliers"><i class="bi bi-building"></i>&nbsp;&nbsp; <span
            class="text dynamic-color">Suppliers</span></a></li>
            <?php endif ?>

            <?php if ($accessCustomer): ?>
            <li><a href="customer" id="customers"><i class="bi bi-people"></i>&nbsp;&nbsp; <span
            class="text dynamic-color">Customers</span></a></li>
            <?php endif ?>
                        

            <?php if ($accessUsers): ?>
                <li><a href="users" id="users"><i class="bi bi-person"></i>&nbsp;&nbsp; <span class="text dynamic-color">Users</span></a></li>
            <?php endif ?>
         
            <!-- <li><a href="employee" id="employee"><i class="bi bi-people"></i>&nbsp;&nbsp; <span class="text dynamic-color">Employee</span></a></li> -->

            <?php if ($accessCoupon): ?>
            <li><a href="coupons" id="s_coupons"><i class="bi bi-ticket"></i>&nbsp;&nbsp; <span
            class="text dynamic-color">Coupons</span></a></li>
            <?php endif ?>
          

            <?php if ($accessCharges): ?>
            <li><a href="charges" id="charges"><i class="bi bi-gear-fill"></i>&nbsp;&nbsp; <span
            class="text dynamic-color">Charges</span></a></li>
            <?php endif ?>

        
            <!-- <?php if ($accessPromotions): ?>
            <li><a href="promotions" id="promotions"><i class="bi bi-megaphone"></i>&nbsp;&nbsp; <span
            class="text dynamic-color">Promotions</span></a></li>
            <?php endif ?> -->
<!--             
            <?php if ($accessPricelist): ?>
            <li><a href="priceLists" id="price_list"><i class="bi bi-cash-coin"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Price List</span></a>
            </li>
            <?php endif ?> -->

<!-- 
            <?php if ($accessPricetag): ?>
            <li><a href="priceTags" id="price_tags"><i class="bi bi-tag fa-lg"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Price Tags</span></a>
            </li>
            <?php endif ?> -->

            <?php if ($accessReporting): ?>
                <li><a href="reporting" id="reporting"><i class="bi bi-bar-chart"></i>&nbsp;&nbsp; <span
                            class="text dynamic-color">Reporting</span></a>
                </li>
            <?php endif ?>

            <?php if ($accessActivitylogs): ?>
            <li><a href="activityLogs" id="activity_logs"><i class="bi bi-activity fa-lg"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Activity Logs</span></a>
            </li>
            <?php endif ?>

            <li><a href="#" id="btn_logout"><i class="bi bi-box-arrow-right"></i>&nbsp;&nbsp; <span
                        class="text dynamic-color">Logout</span></a></li>
            
        </ul>
        <input hidden class="userId" id="userId" value="<?php echo $userId; ?>" />
    </nav>
    <a href="#" id="toggle-sidebar" >
        <i class="bi bi-chevron-double-left" style = "color: white;"></i>&nbsp;&nbsp; <span class="text dynamic-color"></span>
    </a>
</div>
<script>
    let productSValidate = false;
    let reportingsValidate = false;
    let inventoryValidate = false;
    let userValidate = false;
 
</script>
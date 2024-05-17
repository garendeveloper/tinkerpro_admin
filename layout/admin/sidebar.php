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

    .main-panel {
        padding: 15px;
        transition: margin-left 0.3s;
    }

    .main-panel.expanded {
        left: 50px;
        width: calc(100% - 50px); 
    }   
</style>
<header class="site-header">
    <div class="header-container">
        <h6 class="logo">Management&nbsp; <i class="bi bi-globe" style="font-size: 0.5rem;"></i> <span
                id="pointer"></span> </h6>
    </div>
</header>
<div class="sidebar" id="sidebar">
    <nav>
        <ul>
            <li><a href="index" id="index"><i class="bi bi-house-door"></i>&nbsp;&nbsp; <span
                        class="text">Dashboard</span></a></li>
            <li><a href="#" id="inventory"><i class="bi bi-box-seam"></i>&nbsp;&nbsp; <span class="text">Inventory</span></a>
            </li>
            <li><a href="#" id="products"><i class="bi bi-bag-check"></i>&nbsp;&nbsp; <span class="text">Products</span></a>
            </li>
            <li><a href="ingredients" id="ingredients"><i class="bi bi-egg"></i>&nbsp;&nbsp; <span
                        class="text">Ingredients</span></a></li>
            <li><a href="suppliers" id="suppliers"><i class="bi bi-people"></i>&nbsp;&nbsp; <span
                        class="text">Suppliers</span></a></li>
            <li><a href="customer" id="customers"><i class="bi bi-people"></i>&nbsp;&nbsp; <span
                        class="text">Customers</span></a></li>
            <li><a href="#" id="reporting"><i class="bi bi-bar-chart"></i>&nbsp;&nbsp; <span class="text">Reporting</span></a>
            </li>
            <li><a href="#" id="users"><i class="bi bi-person"></i>&nbsp;&nbsp; <span class="text">Users</span></a></li>
            <!-- <li><a href="company" id="company"><i class="bi bi-building"></i>&nbsp;&nbsp; <span
                        class="text">Company</span></a></li> -->
            <li><a href="#" id="btn_logout"><i class="bi bi-box-arrow-right"></i>&nbsp;&nbsp; <span
                        class="text">Logout</span></a></li>
            <li ><a href="#" id="toggle-sidebar" class="d-flex justify-content-end" ><i class="bi bi-chevron-double-left"></i>&nbsp;&nbsp; <span
                        class="text"></span></a></li>
        </ul>
        <input hidden class="userId" id="userId" value="<?php echo $userId; ?>" />
    </nav>
</div>
<script>
    let productSValidate = false;
    let reportingsValidate = false;
    let inventoryValidate = false;
    let userValidate = false;
    $('#products').on('click', function () {
        $('#toChangeText').text("Products")
        var forUser = document.getElementById('forUser')
        forUser.setAttribute('hidden', true)
        var forInventory = document.getElementById('forInventory')
        forInventory.setAttribute('hidden', true);
        var forProducts = document.getElementById('forProducts')
        forProducts.removeAttribute('hidden');
        var forUsers = document.getElementById('forUsers')
        forUsers.setAttribute('hidden', true)
        var forReportings = document.getElementById('forReportings')
        forReportings.setAttribute('hidden', true);
        userSValidate = false;
        productSValidate = true;
        reportingsValidate = false;
        inventoryValidate = false;
        userValidate = false;
        permModals()
    })


    $('#reporting').on('click', function () {
        $('#toChangeText').text("Reports")
        var forUser = document.getElementById('forUser')
        forUser.setAttribute('hidden', true)
        var forInventory = document.getElementById('forInventory')
        forInventory.setAttribute('hidden', true);
        var forReportings = document.getElementById('forReportings')
        forReportings.removeAttribute('hidden');
        var forProducts = document.getElementById('forProducts')
        forProducts.setAttribute('hidden', true);
        var forUsers = document.getElementById('forUsers')
        forUsers.setAttribute('hidden', true)
        userSValidate = false;
        productSValidate = false;
        reportingsValidate = true;
        inventoryValidate = false;
        userValidate = false;
        permModals()
    })

    $('#inventory').on('click', function () {
        $('#toChangeText').text("Inventory")
        var forUser = document.getElementById('forUser')
        forUser.setAttribute('hidden', true)
        var forInventory = document.getElementById('forInventory')
        forInventory.removeAttribute('hidden');
        var forReportings = document.getElementById('forReportings')
        forReportings.setAttribute('hidden', true);
        var forProducts = document.getElementById('forProducts')
        forProducts.setAttribute('hidden', true);
        var forUsers = document.getElementById('forUsers')
        forUsers.setAttribute('hidden', true)
        userSValidate = false;
        productSValidate = false;
        reportingsValidate = false;
        inventoryValidate = true;
        userValidate = false;
        permModals()
    })
    $('#users').on('click', function () {
        $('#toChangeText').text("Users")
        var forUser = document.getElementById('forUser')
        forUser.removeAttribute('hidden')
        var forInventory = document.getElementById('forInventory')
        forInventory.setAttribute('hidden', true);
        var forReportings = document.getElementById('forReportings')
        forReportings.setAttribute('hidden', true);
        var forProducts = document.getElementById('forProducts')
        forProducts.setAttribute('hidden', true);
        var forUsers = document.getElementById('forUsers')
        forUsers.setAttribute('hidden', true)
        userSValidate = false;
        productSValidate = false;
        reportingsValidate = false;
        inventoryValidate = false;
        userValidate = true;
        permModals()
    })


</script>
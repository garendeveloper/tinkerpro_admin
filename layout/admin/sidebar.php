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

    /* Sidebar styles */
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
    .sidebar a.active{
        background-color: '#FF6700',
    }
</style>
<header class="site-header">
    <div class="header-container">
        <h6 class="logo">Management&nbsp; <i class = "bi bi-globe" style = "font-size: 0.5rem;"></i> <span id = "pointer"></span></h6>
    </div>
</header>
<div class="sidebar">
    <a href="index" id = "index" ><i class = "bi bi-house-door"></i>&nbsp; Dashboard</a>
    <a href="Branches" id = "branches"><i class = "bi bi-tree"></i>&nbsp; Branches</a>
    <a href="inventory" id = "inventory"><i class = "bi bi-box-seam"></i>&nbsp; Inventory</a>
    <a href="products" id = "products"><i class = "bi bi-bag-check"></i>&nbsp; Products</a>
    <a href="ingredients" id = "ingredients"><i class="bi bi-egg bi-3x "></i>&nbsp; Ingredients</a>
    <a href="suppliers" id = "suppliers"><i class="bi bi-egg bi-3x "></i>&nbsp; Suppliers</a>
    <a href="reporting" id = "reporting"><i class = "bi bi-bar-chart"></i>&nbsp; Reporting</a>
    <a href="users" id = "users"><i class = "bi bi-person"></i>&nbsp; Users</a>
    <a href="company" id = "company"><i class = "bi bi-building"></i>&nbsp; Company</a>
    <a href="machine-details" id = "machine-details"><i class = "bi bi-tools"></i>&nbsp; Machine Details</a>
    <a href="backup-restore" id = "backup-restore"><i class = "bi bi-cloud-arrow-up-fill"></i>&nbsp; Backup & Restore</a>
    <a href="#" id = "btn_logout"><i class = "bi bi-box-arrow-right"></i>&nbsp; Logout</a>
</div>
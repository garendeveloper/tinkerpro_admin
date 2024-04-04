<!-- <style>

    .sidebar {
        height: 100%;
        width: 200px;
        background-color: #1E1C11;
        position: fixed;
        top: 0;
        left: 0;
        overflow-x: hidden;
        padding-top: 20px;
    }

    .sidebar a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 16px;
        color: #ffff;
        font-family: Century Gothic;
        display: block;
    }

    .sidebar a:hover {
        background-color: #FF6700;
    }
</style> -->
<style>
        /* Header styles */
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
            background-color: #151515; ;
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
    </style>
<header class="site-header">
    <div class="header-container">
        <h6 class="logo">Management Settings</h6>
    </div>
</header>
<div class="sidebar">
    <a href="index" id = "index"><i class = "bi bi-house-door"></i>&nbsp; Dashboard</a>
    <a href="inventory" id = "inventory"><i class = "bi bi-box-seam"></i>&nbsp; Inventory</a>
    <a href="products" id = "products"><i class = "bi bi-bag-check"></i>&nbsp; Products</a>
    <a href="expiry" id = "expiry"><i class = "bi bi-calendar-x"></i>&nbsp; Expiry</a>
    <a href="reporting" id = "reporting"><i class = "bi bi-bar-chart"></i>&nbsp; Reporting</a>
    <a href="reporting" id = "users"><i class = "bi bi-person"></i>&nbsp; Users</a>
    <a href="company" id = "company"><i class = "bi bi-building"></i>&nbsp; Company</a>
    <a href="machine-details" id = "machine-details"><i class = "bi bi-tools"></i>&nbsp; Machine Details</a>
    <a href="backup-restore" id = "backup-restore"><i class = "bi bi-cloud-arrow-up-fill"></i>&nbsp; Backup & Restore</a>
    <a href="#" id = "btn_logout"><i class = "bi bi-box-arrow-right"></i>&nbsp; Logout</a>
</div>
<style>
    /* Apply this CSS to make the table responsive */
.table-responsive {
    overflow-x: auto;
}

/* Style the table as needed */
.table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
}

/* Style the table headers */
.table th, .table td {
    padding: 8px;
    border: 1px solid #ddd;
}

/* Style the table header row */
.table thead th {
    background-color: #f2f2f2;
    color: #333;
    text-align: left;
}

/* Style alternating table rows */
.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Style the table cells */
.table td {
    text-align: left;
}

/* Adjust table appearance for smaller screens */
@media screen and (max-width: 600px) {
    .table-responsive {
        overflow-x: auto;
    }
    
    /* Make table cells stack on top of each other */
    .table, .table thead, .table tbody, .table th, .table td, .table tr {
        display: block;
    }
    
    /* Hide table header */
    .table thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
    
    /* Style table rows */
    .table tr {
        border: 1px solid #ccc;
    }
    
    /* Style table cells */
    .table td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
    }
    
    /* Add padding for table cells */
    .table td:before {
        position: absolute;
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
    }
    
    /* Style table header labels */
    .table td:before {
        content: attr(data-label);
        font-weight: bold;
    }
}

</style>
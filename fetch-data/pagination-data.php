<?php
    include(__DIR__ . '/../utils/db/connector.php');
    include(__DIR__ . '/../utils/models/product-facade.php');
    include(__DIR__ . '/../utils/models/user-facade.php');
    include(__DIR__ . '/../utils/models/supplier-facade.php');


    $productFacade = new ProductFacade;
    $supplierFacade = new SupplierFacade;


    if (isset ($_GET["pageType"])) {
        $pagination = $_GET["pageType"];
    }

    if ($pagination == 'products') {
        $totalRecords = $productFacade->getTotalProductsCount();
    } else if ($pagination == 'supplier') {
        $totalRecords = $supplierFacade->getTotalSupplier();
    } else if ($pagination == 'customer') {
        $totalRecords = 1;
    } else {
        $totalRecords = 1;
    }   

   
    $totalPages = ceil($totalRecords / 100);

    if ($totalPages > 1) {
        echo "<div id='paginationBtns'>";
        echo "<a  class='paginationButtons paginationTag prev' href='javascript:void(0)' onclick='changePage(\"prev\")'>Prev</a>";
    
        for ($i = 1; $i <= min(20, $totalPages); $i++) {
            $activeClass = ($i == 1) ? 'active' : '';
            echo "<a  class='paginationButtons paginationTag $activeClass' href='javascript:void(0)' onclick='refreshProductsTable($i)'>$i</a> ";
        }
    
        if ($totalPages > 20) {
            echo "<a  class='paginationButtons paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>";
            echo "<a  class='paginationButtons paginationTag' href='javascript:void(0)' onclick='refreshProductsTable($totalPages)'>$totalPages</a> ";
        }
    
        echo "<a  class='paginationButtons paginationTag next' href='javascript:void(0)' onclick='changePage(\"next\")'>Next</a>";
        echo "</div>";
    } else {
        echo "<div id='paginationBtns' class='d-none'>";

        echo "</div>";
    }

?>



<style>
    .paginationButtons {
        border-radius: 50%; 
        background: transparent; 
        border: 1px solid #757373; 
        color: #fff'
    }


</style>

<script>

let currentPage = 1;
let currentPageGroup = 1;
const pagesPerGroup = 20;
const totalPages = <?php echo $totalPages; ?>;

function refreshProductsTable(page) {
    currentPage = page;
    $.ajax({
        url: './fetch-data/fetch-products.php',
        type: 'GET',
        data: { page: page },
        success: function (response) {
            $('#productTable').html(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
    updatePaginationButtons();
}

function updatePaginationButtons() {
    const paginationBtns = document.getElementById('paginationBtns');
    paginationBtns.innerHTML = '';

    // Prev button
    paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag prev' href='javascript:void(0)' onclick='changePage("prev")'>Prev</a>`;

    // Previous dots
    if (currentPageGroup > 1) {
        paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(-1)'>...</a>`;
    }

    // Page numbers
    const startPage = (currentPageGroup - 1) * pagesPerGroup + 1;
    const endPage = Math.min(currentPageGroup * pagesPerGroup, totalPages);

    for (let i = startPage; i <= endPage; i++) {
        let styleString = '';

        if (i == currentPage) {
            styleString = 'border-radius: 50%; background: transparent; border: 1px solid var(--primary-color); color: #fff';
        } else {
            styleString = 'border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff';
        }

        const activeClass = (i == currentPage) ? 'active' : '';
        paginationBtns.innerHTML += `<a style='${styleString}' class='paginationTag ${activeClass}' href='javascript:void(0)' onclick='refreshProductsTable(${i})'>${i}</a>`;
    }
    // Next dots
    if (endPage < totalPages) {
        paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag dots' href='javascript:void(0)' onclick='changePageGroup(1)'>...</a>`;
    }

    // Last page button
    if (endPage < totalPages) {
        paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag' href='javascript:void(0)' onclick='refreshProductsTable(${totalPages})'>${totalPages}</a>`;
    }

    // Next button
    paginationBtns.innerHTML += `<a style='border-radius: 50%; background: transparent; border: 1px solid #757373; color: #fff' class='paginationTag next' href='javascript:void(0)' onclick='changePage("next")'>Next</a>`;
}

function changePage(direction) {
    if (direction === 'next' && currentPage < totalPages) {
        currentPage++;
    } else if (direction === 'prev' && currentPage > 1) {
        currentPage--;
    }

    refreshProductsTable(currentPage);
}

function changePageGroup(direction) {
    if (direction === 1 && currentPageGroup * pagesPerGroup < totalPages) {
        currentPageGroup++;
    } else if (direction === -1 && currentPageGroup > 1) {
        currentPageGroup--;
    }
    updatePaginationButtons();
}


refreshProductsTable(currentPage);


</script>
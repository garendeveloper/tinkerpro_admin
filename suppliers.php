<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/product-facade.php');
  include( __DIR__ . '/utils/models/ingredients-facade.php');
  $productFacade = new ProductFacade;

  $userId = 0;

  if (isset($_SESSION["user_id"])){
    $userId = $_SESSION["user_id"];
  }
  if (isset($_SESSION["first_name"])){
    $firstName = $_SESSION["first_name"];
  }
  if (isset($_SESSION["last_name"])){
    $lastName = $_SESSION["last_name"];
  }


  // Redirect to login page if user has not been logged in
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

  include('./modals/add-suppliers-modal.php');
  
  include('./modals/delete_modal.php');
  include('./modals/supplied-products.php');
  include('./modals/supplied-ingredients.php');
 
?>
<style>
  #topBar{
  background-color:#262626
}
.content-wrapper{
    background-color: #262626;
  
  }
  .searchSupplier{
  background-color: #7C7C7C;
  }
  .text-color::placeholder {
  color: #ffff;
}
.btn-control{
  font-family: Century Gothic;
  border-radius: 10px;
  border-color: #33557F;
}
/* 
.btn-success-custom{
  background-color: #00B050
} */
.btn-error-custom{
  background-color: red;
}
.btn-control:hover {
    border-color: var(--primary-color); 
    color: #fefefe !important; 
}
.productTable{
    position: absolute; 
    left: 2px;
    right:2px;
    top:2px;
    
}
.table-border{
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #292928 !important;
}

.table-border td {
  padding: 2px !important;
}

.table-border th, td {
  border: 1px solid #292928 !important;
  padding: 8px;
  font-size: 12px !important;
}


 th.text-center{
  background: transparent !important;
  color: var(--primary-color);
  font-size: 12px;
}

.text-color{
    color: #ffff;
    font-family: Century Gothic;
  }
  .table-responsive {
    max-height: 600px;
    width: 100%; 
   
}


.card{
    background-color:#151515;
    border-color: #242424;
    height: 200px; 
    border-radius: 8px;
    padding: 16px; 
  }




  .searchDis, .addProducts {
    background: #7C7C7C;
    border: 1px solid transparent;
  }

  .addProducts {
    border-radius: 0 20px 20px 0;
  }

  .searchSupplier {
    padding-left: 15px;
    border-radius: 20px 0 0 20px;
  }

  .main-panel {
    -webkit-user-select: none; 
    -moz-user-select: none;   
    -ms-user-select: none;  
    user-select: none;   
  }




  #responsive-data thead th,
    #responsive-data tbody td {
      padding: 3px 3px; 
      height: auto; 
      line-height: 0.4; 
      border: 1px solid #292928;
      color: #ffff;
  }
  #responsive-data{
    width: 100%;
  }
  #responsive-data thead {
      display: table; 
      width: calc(100% - 4px);
  }

  #responsive-data tbody {
      display: block; 
      max-height: 76vh; 
      overflow-y: scroll;
  }

  #responsive-data th, td {
      width: 9%;
      overflow-wrap: break-word; 
      box-sizing: border-box;
      font-size: 13px;
  }
  #responsive-data tr {
      display: table;
      width: 100%;
  }
  #responsive-data, table,  tbody{
    border: 1px solid #292928;
  }
  #responsive-data table{
      background-color: #1e1e1e;
   
      height: 5px;
      padding: 10px 10px;
  }
  #responsive-data tbody::-webkit-scrollbar {
    width: 4px; 
}
#responsive-data tbody::-webkit-scrollbar-track {
    background: #151515;
}
#responsive-data tbody::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 50px; 
}
 .main-panel, .container-scroller, .card, .card-body, .content-wrapper{
  overflow: hidden !important;
 }
 .child-a{
  width: 5% !important;
 }
 .child-b{
  width: 12% !important;
 }
 .child-c{
  width: 10% !important;
 }
 .child-d{
  width: 10% !important;
 }
 .child-e{
  width: 10% !important;
 }
 .child-f{
  width: 5% !important;
 }
 .child-g{
  width: 5% !important;
 }
 .adminTableHead th{
  font-weight: bold !important;
  font-size: 12px !important;
  line-height: 18px !important;
 }


  /* start for search bar css*/

  ::selection {
  color: black;
  background: white;
}

.text-color.searchSupplier{
    caret-color: white; 
    color: white; 
    background-color: #555; 
    font-size: 15px; 
  
}

.text-color.searchSupplier::placeholder {
    color: rgba(255, 255, 255, 0.8);
}

.clearSupplierBtn{
  background-color: #555;  
  margin-left: -5px;
  height: 35px;
  cursor: pointer;
}

.clearSupplierBtn svg {
  transition: fill 0.3s ease, transform 0.3s ease; 
 

}

.clearSupplierBtn:hover svg {
  fill: var(--primary-color); 
  transform: scale(1.1);
}

.searchbtn {
   background-color: #555;  
  border:none;
  }

  
.addProducts.searchAdd {
    background-color: #555;
}
.addProducts.searchAdd:hover {
    background-color: var(--primary-color);
}
/*   end for search bar css */




@media screen and (max-width: 1400px) {
     
     .d-flex{
       zoom: 90%;
     }
     
      .modal{
       zoom: 90%;
   
      }
   
      .modal-content{
        height: 800px;
        width:400px;
        margin-right:-10px ;
      }

      #add_supplier_modal{
        height: 900px;
      }
      
      .button-container{
        zoom: 90%;
        margin-left: -70px !important;
      }
   
    #recentsuppliers td {
        font-size: 12px;
        padding: 2 !important;
    }


    #recentsuppliers th {
        font-size: 14px !important;
       
    }
    
   

#paginationDiv{
  zoom: 80%;
  margin-top: 0px;

    
}

#responsive-data {
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch; 
    scrollbar-color: #555 ; 
        }


        
#responsive-data::-webkit-scrollbar {
    height: 5px !important; 
}
/* Track */
#responsive-data::-webkit-scrollbar-track {
  background: #333; 

}
 
/* Handle */
#responsive-data::-webkit-scrollbar-thumb {
  background: #888; 
  border-radius: 10px;
}


        #recentsuppliers {
            min-width: 1800px; 
            font-size: 12px;
        }

.btn-control{
  zoom:90%
}

       }
</style>
<?php include "layout/admin/css.php"?>
  <div class="container-scroller">
      <?php include 'layout/admin/sidebar.php' ?>
      <div class="main-panel h-100">
        <div class="content-wrapper">

          <div class="d-flex mb-2 w-10">

            <input  class="text-color searchSupplier w-100 ms-2 searchInputs" id="searchInput" placeholder="Search Suppliers"/>
            <span class="clearSupplierBtn" id="clearBtn">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="35" fill="#fff" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
              </svg>
            </span>

            <button class="searchbtn">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
              </svg>
            </button>

            <button onclick="addSuppliers()" class="addProducts searchAdd">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
              </svg> 
            </button>
          </div>

          <div>
          <div class="row">
            <div>
              <div class="card" style="height:76vh; width: 100%; overflow: hidden;">
                <!-- <div class="card-body" style="max-height: 80vh; border-radius: 0;"> -->
                  <?php include('errors.php'); ?>
                  <!-- <div class="productTable" > -->
             
                    <div id="responsive-data">
                      <table id="recentsuppliers">
                        <thead class = "adminTableHead">
                          <th class="text-center child-a">No.</th>
                          <th class="text-left child-b" >Supplier</th>
                          <th class="text-center child-c" >Contact</th>
                          <th class="text-left child-d" >Email</th>
                          <th class="text-left child-e">Address</th>
                          <th class="text-center child-f" >Status</th>
                          <th class="text-center child-g" >Action</th>
                        </thead>
                        <tbody id="fetchsuppliers">
                          
                        </tbody>
                      </table>
                    </div>
                   
                  
                   
                  <!-- </div> -->
                <!-- </div> -->
              </div>

              <div id="paginationDiv" class="paginactionClass">

              </div>

              <div class="d-flex ms-2 justify-content-center">
                <button class="btn-control" id="printSupplier" style="width:160px; height:45px; margin-right: 10px"><svg version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffff;} </style> <g> <path class="st0" d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z"></path> <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect> <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect> <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect> <path class="st0" d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z"></path> <path class="st0" d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z"></path> </g> </g></svg>&nbsp;Print</button>
                <button class="btn-control" id="generateSupplierDFBtn" style="width:160px; height:45px; margin-right: 10px"><svg width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z" fill="#ffff"></path> </g></svg>&nbsp;Save as PDF</button>
                <button class="btn-control" id="exportSupplier" style="width:160px; height:45px;"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;Save as Excel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- main-panel ends -->
    
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

<?php include("layout/footer.php") ?>
<script>


// for clear button in search bar

document.addEventListener('DOMContentLoaded', function() {
  const input = document.getElementById('searchInput');
  const clearBtn = document.getElementById('clearBtn');

  // Function to update the visibility of the SVG
  function updateClearBtnVisibility() {
    if (input.value.trim() !== '') {
      clearBtn.style.display = 'inline'; // Show the SVG
    } else {
      clearBtn.style.display = 'none'; // Hide the SVG
    }
  }

  // Initial check
  updateClearBtnVisibility();

  // Event listeners for input changes
  input.addEventListener('input', updateClearBtnVisibility);

  // Optional: Clear input on SVG click
  clearBtn.addEventListener('click', function() {
    input.value = '';
    updateClearBtnVisibility(); // Hide SVG after clearing input
    input.focus(); // Optional: refocus input field
  });
});





  showPaginationBtn('supplier')

  $("#suppliers").addClass('active');
  $("#pointer").html("Suppliers");

 

  function addSuppliers(){
    $('#add_supplier_modal').show()
    if($('#add_supplier_modal').is(":visible")){
        var slider = document.getElementById('statusValueSupplier'); 
        var statusLabel = document.getElementById('statusSupplier');
        var s_id = document.getElementById('supplierid').value;
        $('.modalHeaderTxt').text(!s_id ? "Add New Supplier" : $('.modalHeaderTxt').text());
        slider.checked = true;
        if(slider.checked){
            toggleStatusSupplier(slider)
        }else{
            toggleStatusSupplier(slider)
        }
    }
  }

  function refreshSupplierTable() 
  {
    $.ajax({
        url: './fetch-data/fetch-supplier.php', 
        type: 'GET',
        success: function(response) {
            $('#fetchsuppliers').html(response); 
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); 
        }
    });
  }

  refreshSupplierTable()


  function showSupplier(t) 
  {
    var supplierId      =  t.closest('tr').find('.supplierId').text();
    var supplierName    =  t.closest('tr').find('.supplierName').text();
    var supplierContact =  t.closest('tr').find('.supplierContact').text();
    var supplierEmail   =  t.closest('tr').find('.supplierEmail').text();
    var supplierCompany =  t.closest('tr').find('.supplierCompany').text();
    var supplierStatus  =  t.closest('tr').find('.supplierStatus').text();

    $('.highlighteds').removeClass('highlighteds');
    var $row = t.closest('tr').addClass('highlighteds');
    toUpdateSupplier(supplierId,supplierName,supplierContact,supplierEmail,supplierCompany,supplierStatus)
  }

  $(document.body).on('click', '.supplier-rows', function() {
    $('.highlighteds').removeClass('highlighteds');
    var $row = $(this).closest('tr').addClass('highlighteds');
  })

  $(document.body).on('dblclick', '.supplier-rows', function() {
    showSupplier($(this))
  })

  $(document.body).on('click', '.editSupplier', function() {
    showSupplier($(this))
  })

  $(document.body).on('click', '.deleteSupplier', function() {
    var supplierId =  $(this).closest('tr').find('.supplierId').text();
    var supplierName    =  $(this).closest('tr').find('.supplierName').text();
    var supplierContact =  $(this).closest('tr').find('.supplierContact').text();
    var userInfo = JSON.parse(localStorage.getItem('userInfo'));
    var firstName = userInfo.firstName;
    var lastName = userInfo.lastName;
    var cid = userInfo.userId;
    var role_id = userInfo.roleId; 

    $.ajax({
      type: 'get',
      url: 'api.php?action=verify_supplier',
      data: {
        id: supplierId,
      },
      success: function(response)
      {
        if(!response)
        {
          var warningDelete = `
            <div class="d-flex justify-content-center text-center align-items-center w-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="red" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
            </svg>
          </div>
          <div class="d-flex align-items-center justify-content text-center mt-2">
            <h4 class="w-100">Are you sure you want to delete this supplier?</h4>
          </div>`;
          $('.show_product_info').html(warningDelete);
          insertLogs('Supplier',firstName + ' ' + lastName + ' '+ 'Tries to delete' + ' ' +  supplierName)
          $("#deleteProdModal").fadeIn(200);
          $('.deleteProductItem').removeClass('d-none');
          $('.inactiveBtn').addClass('d-none');
          $('.deleteProductItem').off('click').on('click', function() {
            $.ajax({
              type: 'get',
              url: 'api.php?action=delete_supplier',
              data: {
                id: supplierId,
              },
              success: function(response)
              {
                $("#deleteProdModal").fadeOut(200);
                show_response("Supplier has been successfully deleted", 1);
                refreshSupplierTable()
                insertLogs('Supplier',firstName + ' ' + lastName + ' '+ 'Deleted Supplier' + ' ' +  supplierName)
              }
            })
          });
        }
        else
        {
          show_response("Unable to delete. Supplier has been used by other transaction.", 0);
        }
      }
    })
  })

    $('.clearSupplierBtn').on('click', function(){
     $('.searchSupplier').val('')
       refreshSupplierTable()
    })

    $('.searchSupplier').on('input', function() {
      var searchData = $(this).val();
      $.ajax({
          url: './fetch-data/fetch-supplier.php',
          type: 'GET',
          data: {
              searchQuery: searchData
          },
          success: function(response) {
            $('#fetchsuppliers').html(response);              
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
    });

$('#generateSupplierDFBtn').click(function() {
      var searchData = $('.searchSupplier').val();
   
    $.ajax({
        url: './reports/supplier.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            searchQuery: searchData
        },
        success: function(response) {
            var blob = new Blob([response], { type: 'application/pdf' });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'supplier_list.pdf';
            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 
    
    
           insertLogs('Supplier',firstName + ' ' + lastName + ' '+ 'Generated a pdf')
            // $('#modalCashPrint').hide()
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.log(searchData)
        }
    });
});

function show_response(message, type) {
  toastr.options = {
    "onShown": function () {
      $('.custom-toast').css({
        "opacity": 1,
        "width": "600px",
        "text-align": "center",
      });
    },
    "closeButton": true,
    "positionClass": "toast-top-right",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "progressBar": true,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut",
    "tapToDismiss": false,
    "toastClass": "custom-toast",
    "onclick": function () {  }

  };
  type === 1 ? toastr.success(message) : toastr.error(message);
}

$('#printSupplier').click(function() {
    var searchData = $('.searchSupplier').val();
    $.ajax({
        url: './reports/supplier.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            searchQuery: searchData 
        },
        success: function(response) {
          var blob = new Blob([response], { type: 'application/pdf' });
            var url = window.URL.createObjectURL(blob);
            var win = window.open(url);
            win.onload = function() {
                win.print();
                win.onafterprint = function() {
                    window.focus(); 
                    win.close();
                }
            }

            window.URL.revokeObjectURL(url);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 
    
    
           insertLogs('Supplier',firstName + ' ' + lastName + ' '+ 'Printing a pdf')
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.log(searchData)
        }
    });
  });

  $('#exportSupplier').click(function() {
    var searchData = $('.searchSupplier').val();
    $.ajax({
        url: './reports/supplier-csv.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            searchQuery: searchData 
        },
        success: function(response) {
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(response);
            a.href = url;
            a.download = 'supplier.csv';
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);

            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 
    
    
           insertLogs('Supplier',firstName + ' ' + lastName + ' '+ 'Exported' + 'supplier.csv')
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});


</script>
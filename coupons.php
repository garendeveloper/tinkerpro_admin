<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/user-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');


  $userId = 0;
  
  $abilityFacade = new AbilityFacade;

if (isset($_SESSION['user_id'])) {
 
    $userID = $_SESSION['user_id'];

    
    $permissions = $abilityFacade->perm($userID);

    
    $accessGranted = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Users']) && $permission['Users'] == "Access Granted") {
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

  // Redirect to login page if user has not been logged in
  if ($userId == 0) {
    header("Location: login");
  }
  if (isset($_GET["add_user"])) {
		$error = $_GET["add_user"];
    array_push($success, $error);
	}
  if (isset($_GET["update_user"])) {
		$error = $_GET["update_user"];
    array_push($info, $error);
	}
  if (isset($_GET["delete_user"])) {
		$error = $_GET["delete_user"];
    array_push($info, $error);
	}

?>
<?php include "layout/admin/css.php"?>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include 'layout/admin/sidebar.php' ?>
      <!-- partial -->
      <div class="main-panel h-100">
          <div class="row">
            <div class="d-flex">
                <label class="text-color user-header ms-4" style="font-size: 35px">Coupons Or Vouchers</label>
            </div> 

            <div class="d-flex p-0 mt-4 w-100 justify-content-between">
              <div class="col-8  mt-2 ms-3 p-0">
                <div class="d-flex align-items-center justify-content-between mt-4">
                  <input hidden id="couponID"/>
                  <input  class="text-color searchCoupon w-100" style="height: 35px;" placeholder="Search QR CODE"/>
                  <button class="clearBtn buttonCoupon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                  </button>
                  <button class="buttonCoupon btnSearchCoupon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                  </button>
                </div>
              </div>


              <div class="col-3 mt-2 ms-3 p-0">
                <div class="d-flex align-items-center justify-content-end mt-3">
                  <div class="select-container">
                    <select id="expirationSelect">
                    <option  selected >Select Expiration Date</option>
                    <?php
                        $userFacade = new UserFacade;
                        $others =     $userFacade->getExpiration();
                        while ($row = $others->fetch(PDO::FETCH_ASSOC)) {
                          echo '<option value="' . $row['id'] . '" data-days="' . $row['days'] . '">' . $row['days'] . '</option>';
                        }
                        ?>
                    </select>
                    <div class="select-arrow"></div>
                  </div>
                  <button style="margin-left: 5px" class="setExpiration">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                      <path d="M11 2H9v3h2z"/>
                      <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                    </svg>
                  </button>



                    <?php include('errors.php'); ?>
                    
                    <input class="custom-input texct-color filterStatus" readonly hidden name="filterStatus" id="filterStatus" style="width: 180px"/>
                    <!-- <input class="text-color filterStatusName" readonly name="filterStatusName" id="filterStatusName" >    -->

                    <select class="text-color filterStatusName" name="filterStatusName" id="filterStatusName">
                        <option value="all" data-value="all">All</option>
                        <option value="0" data-value="0">Not Use</option>
                        <option value="1" data-value="1">Used</option>
                    </select>

                    <button name="filterStatusBtn" id="filterStatusBtn" class="filterBtn">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter-right" viewBox="0 0 16 16">
                        <path d="M14 10.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 .5-.5m0-3a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0 0 1h7a.5.5 0 0 0 .5-.5m0-3a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0 0 1h11a.5.5 0 0 0 .5-.5"/>
                      </svg>
                    </button>
                    
                    
                   

                    <!-- <div class="statusDropDown" id="statusDropDown" style="background: #151515; border-radius: 10px; margin-right: 10px">
                      <a href="#" class="text-light "  style="font-size: 14px" data-value="all">All</a>
                      <a href="#" class="text-light "  style="font-size: 14px" data-value="0">Not Use</a>
                      <a href="#" class="text-light "  style="font-size: 14px" data-value="1">Used</a>
                    </div> -->
                </div>

              </div>
            </div>

          
            
            <div class="d-flex justify-content-center mt-3 p-0">
              <table id="recentusers" class="text-color table-border table-container-coupon">
                  <thead>
                    <tr>
                      <th class="text-center" style="width: 3%;">No.</th>
                      <th class="text-center" style="width: 20%;">QR Number</th>
                      <th class="text-center" style="width: 10%;">Amount</th>
                      <th class="text-center" style="width: 8%;">Transaction Date</th>
                      <th class="text-center" style="width: 10%;">Used Date</th>
                      <th class="text-center" style="width: 10%;">Expiry Date</th>
                      <th class="text-center" style="width: 10%;">Status</th>
                      <th class="text-center" style="width: 10%;">ACTION</th>
                    </tr>
                  </thead>
                  <tbody  id="couponsTable">
                    
                  </tbody>
              </table>
            </div>
          
              
            


          </div> 
        </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

<?php include("layout/footer.php") ?>
<style>


  #expirationSelect, #filterStatusName {
    background: none;
    height: 40px;
    padding: 10px;
    color: var(--text-color);
    border-radius: 5px;
    border: 1px solid var(--border-color);
    font-size: 13px;
    width: auto;
  }

 .setExpiration, .filterBtn {
    border-radius: 50%;
    height: 45px;
    width: 45px;
    border: none;
    box-shadow: none;
 }  
 
 .setExpiration:hover, .filterBtn:hover {
  background: none;
 }
.custom-select {
  position: absolute;
  width: 300px;
  top: 10px;
  right: 0;
}
.custom-btn{
border-radius: 5px;
height: 40px;
}
.custom-select label {
  display: block;
}

.custom-select .select-container {
  position: relative;
  /* margin-left: 10px;
  margin-right: 10px; */
}
.custom-input input,
.custom-select select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 8px 30px 8px 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 0;
  background-color: #575757;
  color: white;
  cursor: pointer;
  width: 100%;
}

.custom-select .select-arrow {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  height: 0;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-top: 6px solid #666;
}

.custom-select select:focus {
  outline: none;
  border-color:#333333;
}
 .statusDropDown {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1;
    top: calc(100% + 10px); 
    right: 0; 
    top: 38px;
}


#topBar{
  background-color:#262626
}

  .statusDropDown a {
    display: block;
    width: 100%;
    padding: 10px;
    min-width: 210px;
    border: none; 
    background-color: transparent;
    color: #000000; 
    text-decoration: none; 
    padding-top: 0;
    padding-bottom: 0;
    margin-top: 0;
    margin-bottom: 0;  
   
  }
  

  .statusDropDown a:hover {
    background: #1967D2;
  }

  
   .editBtn:hover {
     transform: scale(0.9);
  }
  .editBtn {
    text-decoration: none; 
    border-radius: 3px; 
    overflow: hidden;
    display: inline-block; 
    transition: transform 0.3s;
  }
  .content-wrapper{
    background-color: #262626;
  
  }
  .btn-control:hover {
    border-color: #FF6900 !important; 
    color: #ffff !important; 
}
  .text-color{
    color: #ffff;
    font-family: Century Gothic;
  }
  .card{
    background-color:#151515;
    border-color: #242424;
  }
  .table-border{
    border-collapse: collapse;
    border: 1px solid white;
  }


  .table-container-coupon {
    background: #151515;
    padding: 0;
  }
  .usersTable{
    width: 100%;
   
    background: #151515;
    /* position: absolute; 
    left: 2px;
    right:2px;
    margin-top: 90px; */
  }
  .select-area {
  margin-top: 40px;
  position: absolute;
  right:5px;
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;

}

  .searchCoupon{
    background-color: #7C7C7C;
    border-top-left-radius: 20px;
    border-bottom-left-radius: 20px;
    padding-left: 20px;
    font-style: italic;
  }

  .btnSearchCoupon {
    padding-left: 20px;
    padding-right: 20px;
    border-top-right-radius: 20px;
    border-bottom-right-radius: 20px;
  }

  .buttonCoupon {
    height: 35px; 
    background: #7C7C7C; 
    border-left: none; 
    border-right: none;
    border-top: 1px solid transparent;
    border-bottom: 1px solid transparent;
  }

  .text-color::placeholder {
  color: #ffff;
}

.table-border th, td {
  border: 1px solid #282829;
}
.table-border th{
  padding: 8px;
  font-size: 12px;
  color: var(--primary-color);
  background-color: transparent;
}
.text-center{
  text-align: center;
}
.user-header{
  position: absolute;
  left: 0;
  top: 5px;
}
.btn-control{
  font-family: Century Gothic;
  border-radius: 10px;
  border-color: #33557F;
}
.table-responsive {
    max-height: 600px; 
    overflow: auto; 
    width: 100%;
}

.table-responsive table {
    border-collapse: collapse;
    width: 100%;
}
.text-custom{
   color: #FF6900;
   font-family: Century Gothic;
   font-weight: bold;
}
.text-custom-data{
   color: #FF6900;
   font-family: Century Gothic;
}
.btn-success-custom{
  background-color: #00B050
}
.btn-error-custom{
  background-color: red;
}
.action-td{
  font-style: italic;
}
.highlightedCoupon {
    border: 2px solid #00B050 !important; 
}


</style>
<script>


$("#s_coupons").addClass('active');
  $("#pointer").html("Coupons");


function refreshTable() {
        $.ajax({
            url: './fetch-data/fetch-coupons.php', 
            type: 'GET',
            success: function(response) {
                $('#couponsTable').html(response); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });
    }
refreshTable()


function selectDataDisplay() {
  var value;
  $('#filterStatusName').on('change', function() {
    value = $(this).val();
    $.ajax({
      url: './fetch-data/fetch-coupons.php', 
      type: 'GET',
      data:{selectedValue:value},
      success: function(response) {
          $('#couponsTable').html(response); 
      },
      error: function(xhr, status, error) {
          console.error(xhr.responseText); 
      }
    });
  })    
}

selectDataDisplay()

$(document.body).on('click', '.editBtn', function() {
        var id = $(this).closest('tr').find('.couponId').text();
        
        $('.highlightedCoupon').removeClass('highlightedCoupon');
        var $row = $(this).closest('tr').addClass('highlightedCoupon');
        printCoupon(id)
        
    });
function printCoupon(id){
    $.ajax({
            url: './reports/coupons-print.php', 
            type: 'GET',
            data:{id:id},
            success: function(response) {
              var userInfo = JSON.parse(localStorage.getItem('userInfo'));
              var firstName = userInfo.firstName;
              var lastName = userInfo.lastName;
              var cid = userInfo.userId;
              var role_id = userInfo.roleId; 
              insertLogs('Coupons', firstName + ' ' + lastName + ' ' + 'Printed a coupon id #:' + id);
                Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Coupon Printed Successfully!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
        })
            },
            error: function(xhr, status, error) {
                Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error Printing!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
        })
            }
        });
}

$(document).ready(function() {

      $(".statusDropDown a[data-value='all']").click();
      $('#generatePDFBtn').click(function() {
      var searchData = $('.searchCoupon').val();
      var statusValue = $("#filterStatus").val(); 
    $.ajax({
        url: './reports/coupons.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            selectedValue: statusValue,
            searchQuery: searchData
        },
        success: function(response) {
            var blob = new Blob([response], { type: 'application/pdf' });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'coupon_list.pdf';
            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 

            insertLogs('Coupons', firstName + ' ' + lastName + ' ' + 'Generated a pdf');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.log(searchData)
        }
    });
});


  $('#generateEXCELBtn').click(function() {
    var searchData = $('.searchCoupon').val();
    $.ajax({
       url: './reports/coupons-excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            selectedValue: $('#filterStatus').val(),
            searchQuery: searchData 
        },
        success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'coupons_list.csv'; 

            
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
            var userInfo = JSON.parse(localStorage.getItem('userInfo'));
            var firstName = userInfo.firstName;
            var lastName = userInfo.lastName;
            var cid = userInfo.userId;
            var role_id = userInfo.roleId; 

            insertLogs('Coupons', firstName + ' ' + lastName + ' ' + 'Exported' + 'coupons_list.csv' );
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
 
$('#printThis').click(function() {
    var searchData = $('.searchCoupon').val();
    var statusValue = $("#filterStatus").val(); 

    $.ajax({
        url: './reports/coupons.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            selectedValue: statusValue,
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
        insertLogs('Coupons', firstName + ' ' + lastName + ' ' + 'Printing pdf' );
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.log(searchData)
        }
    });
});
$('.searchCoupon').on('input', function(){
    var searchData = $(this).val();
    $.ajax({
            url: './fetch-data/fetch-coupons.php', 
            type: 'GET',
            data: {
            searchQuery: searchData 
        },
            success: function(response) {
                $('#couponsTable').html(response); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });
});
 $('.clearBtn').on('click', function(){
    $('.searchCoupon').val("")
    $(".statusDropDown a[data-value='all']").click();
    refreshTable() 
 })
 $('.setExpiration').on('click', function() {
    var expirationSelect = document.getElementById('expirationSelect');
    var selectedValue = expirationSelect.value;
    var selectedOption = expirationSelect.options[expirationSelect.selectedIndex];
    var days = selectedOption.getAttribute('data-days');
    
    
    axios.post(`api.php?action=updateExpiration&value=${selectedValue}`).then(function (response) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Coupon Expiration updated successfully!',
            timer: 1000, 
            timerProgressBar: true, 
            showConfirmButton: false 
        });
        
        var userInfo = JSON.parse(localStorage.getItem('userInfo'));
        var firstName = userInfo.firstName;
        var lastName = userInfo.lastName;
        var cid = userInfo.userId;
        var role_id = userInfo.roleId; 
        insertLogs('Coupons', firstName + ' ' + lastName + ' ' + 'Updated the coupon expiration to ' + days);
    }).catch(function (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Error!',
            timer: 1000, 
            timerProgressBar: true, 
            showConfirmButton: false 
        });
    });
});

});

 function currentExpiration(){
    axios.post('api.php?action=getCurrent').then(function (response) {
       var defaultData = response.data.result[0].id;
       $('#expirationSelect').val(defaultData)
      }).catch(function (error) {
       
      }) 
}
currentExpiration()
</script>

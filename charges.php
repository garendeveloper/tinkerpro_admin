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
      <div class="main-panel ms-2 h-100">
         
        <div class="row">
          <div class="col-4 justify-content-between titleCharges mb-4 flex-column">
              <label class="labelTitle mb-2">CHARGES</label>

              <div class="d-flex mb-4">
                <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon">

                </span>
                <div class="charges-container">
                    <div class="inner-border p-2 d-flex">
                      <div class="col-8 charges-label pe-5">
                          <label for="">Tax (Value Added Tax)</label>
                          <select name="" id="" class="mt-3 selectTypeAmount">
                            <option value="">Percentage</option>
                            <option value="">Fixed</option>
                          </select>     
                      </div>

                      <div class="col-4 charges-input">
                          <input type="number" id="tax_value" value="12" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                      </div>
                    </div>
                </div>
              </div>

              <div class="d-flex mb-4">
                <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon">
                
                </span>
                <div class="charges-container">
                  <div class="inner-border p-2 d-flex">
                    <div class="col-8 charges-label pe-5">
                        <label for="">Service Charge</label>
                        <select name="" id="" class="mt-3 selectTypeAmount">
                          <option value="">Percentage</option>
                          <option value="">Fixed</option>
                        </select>     
                    </div>

                    <div class="col-4 charges-input">
                        <input type="number" id="serviceCharge" value="12" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-flex mb-4">
                <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon">
                  
                </span>
                <div class="charges-container" style="float: right">
                  <div class="inner-border p-2 d-flex">
                    <div class="col-8 charges-label pe-5">
                        <label for="">Other Charages</label>
                        <select name="" id="" class="mt-3 selectTypeAmount">
                          <option value="">Percentage</option>
                          <option value="">Fixed</option>
                        </select>     
                    </div>

                    <div class="col-4 charges-input">
                        <input disabled type="number" id="other_charges" value="5" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                    </div>
                  </div>
                </div>
              </div>
          </div>


          <div class="col-4 justify-content-between titleCharges mb-4 flex-column">
              <label class="labelTitle mb-2">DISCOUNT</label>

              <div class="d-flex mb-4">
                <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon">
                  
                </span>
                <div class="charges-container" style="float: right">
                  <div class="inner-border p-2 d-flex">
                    <div class="col-8 charges-label pe-5">
                        <label for="">Senior Citizen/PWD/SP</label>
                        <select name="" id="" class="mt-3 selectTypeAmount">
                          <option value="">Percentage</option>
                          <option value="">Fixed</option>
                        </select>     
                    </div>

                    <div class="col-4 charges-input">
                        <input type="number" id="sc_pwd_sp_discount" value="5" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                    </div>
                  </div>
                </div>
              </div>

            <div class="d-flex mb-4">
              <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon">
               
              </span>

              <div class="charges-container" style="float: right">
                <div class="inner-border p-2 d-flex">
                  <div class="col-8 charges-label pe-5">
                      <label for="">Default Discount</label>
                      <select name="" id="" class="mt-3 selectTypeAmount">
                        <option value="">Percentage</option>
                        <option value="">Fixed</option>
                      </select>     
                  </div>

                  <div class="col-4 charges-input">
                      <input disabled type="number" id="default_discount" value="5" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                  </div>
                </div>
              </div>
            </div>
          
          </div>


          <div class="col-4 justify-content-between titleCharges mb-4 flex-column">
            <label class="labelTitle mb-2">LOYALTY POINTS</label>

            <div class="d-flex mb-4">
              <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon">
               
              </span>

              <div class="loyalty_points" style="float: right;">
                <div class="inner-border p-2 d-flex" style="height: 100%">

                  <div class="col-12 charges-label">

                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" style="color: var(--primary-color); font-weight: bold">EARNINGS</label>
                    </div>

                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" style="font-style: italic">Minimum Purchase (Php)</label> 
                      <input type="number" id="minPurchase" class="loyalty_inputs text-end mb-2" style="border: 1px solid var(--primary-color)">
                    </div>

                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" class="mb-2" style="font-style: italic">Equivalent</label>  
                      <input type="number" id="minPurchase" class="loyalty_inputs text-end mb-2" style="border: 1px solid var(--primary-color)">
                    </div>


                    <div class="d-flex align-items-center justify-content-between w-100 mt-2">
                      <label for="" style="color: var(--primary-color); font-weight: bold">CONVERSION</label>
                    </div>


                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" style="font-style: italic">Points</label>  
                      <input type="number" id="minPurchase" class="loyalty_inputs text-end mb-2" style="border: 1px solid var(--primary-color)">
                    </div>

                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" class="mb-2" style="font-style: italic">Conversion Amount (Php)</label>
                      <input type="number" id="minPurchase" class="loyalty_inputs text-end mb-2" style="border: 1px solid var(--primary-color)">
                    </div>
                    
                  </div>

                </div>
              </div>
            </div>

              
          </div>
        </div>

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

<?php include("layout/footer.php") ?>


<script>
$(document).ready(function() {


  var checkIcon = `
    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="green" class="bi bi-check2-circle" viewBox="0 0 16 16">
      <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
      <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
    </svg>
  `;

  var exIcon = `
    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="red" class="bi bi-x-circle" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
    </svg>
  `;



  var inputSelectors = ['#other_charges', '#serviceCharge', '#default_discount', '#sc_pwd_sp_discount', '#tax_value'];
  var inputNames = ['Other Charge', 'Service Charge', 'Default Discount', 'SC/PWD Discount', 'Tax Charge'];

  for (var i = 0; i < inputSelectors.length; i++) {
      var input = $(inputSelectors[i]);
      var isDisabled = input.is(':disabled');
      

      $(inputSelectors[i]).each(function() {
        if (isDisabled) {
          $('.svgIcon').html(exIcon);
        } else {
          $('.svgIcon').html(checkIcon);
        }
      });
    
  }


})


 $("#charges").addClass('active');
 $("#pointer").html("Charges");
  function getSRate(){
      axios.get('api.php?action=getServiceCharge').then(function(response){
      serviceCharge = response.data.result[0].rate
      var id = response.data.result[0].id
      var displayRate = parseFloat(serviceCharge) *100;
      $('#serviceCharges').val(displayRate.toFixed(2));
      $('#idService').val(id)
      $('#serviceCharges').focus()
      $('#serviceCharges').select()
    }).catch(function(error){
      console.log(error)
    })
  }


  getSRate()
  function getORate(){
      axios.get('api.php?action=getOtherCharges').then(function(response){
      otherCharge = response.data.result[0].rate
      var id = response.data.result[0].id
      var displayRate = parseFloat(otherCharge) *  100;
      $('#otherCharges').val(displayRate.toFixed(2));
      $('#idOthers').val(id)
    }).catch(function(error){
      console.log(error)
    })
  }

  getORate()

$('.serviceSaveBtn').on('click', function(){
    var serviceValue = $('#serviceCharges').val();
    console.log(serviceValue)
    var idValue = $('#idService').val()
    if(idValue){
     axios.post('api.php?action=updateServiceCharge',{
        serviceValue: serviceValue,
        idValue: idValue
     }).then(function(response){
          var userInfo = JSON.parse(localStorage.getItem('userInfo'));
          var firstName = userInfo.firstName;
          var lastName = userInfo.lastName;
          var cid = userInfo.userId;
          var role_id = userInfo.roleId; 
      
         insertLogs('Charges',firstName + ' ' + lastName + ' '+ 'Updated service charges to' + ' ' + serviceValue + '%' )
        getSRate()
        Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Service Charge Rate Saved!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
        })
     }).catch(function(error){
        Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
        })
     })
    }
  
})
$('.othersSaveBtn').on('click', function(){
    var othersValue = $('#otherCharges').val();
    var idValue = $('#idOthers').val()
    console.log(idValue)
    if(idValue){
        axios.post('api.php?action=updateOtherCharge',{
        othersValue: othersValue,
        idValue: idValue
     }).then(function(response){
          var userInfo = JSON.parse(localStorage.getItem('userInfo'));
          var firstName = userInfo.firstName;
          var lastName = userInfo.lastName;
          var cid = userInfo.userId;
          var role_id = userInfo.roleId; 
      
         insertLogs('Charges',firstName + ' ' + lastName + ' '+ 'Updated Other charges to' + ' ' +  othersValue + '%' )
        getORate()
        Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Other Charge Rate Saved!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
        })
     }).catch(function(error){
        Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error!',
                timer: 1000, 
                timerProgressBar: true, 
                showConfirmButton: false 
        })
     })
    }
  
})

    
    $('#otherCharges').on('keydown', function(e) {
        switch (e.which) {
            case 13:
                $('.othersSaveBtn').click(); 
                break;
            default:
                break;
        }
    });

    $('#serviceCharges').on('keydown', function(e) {
        switch (e.which) {
            case 13:
                $('.serviceSaveBtn').click(); 
                break;
            default:
                break;
        }
    });


    var $inputs = $('#otherCharges, #serviceCharges');
      $inputs.keydown(function(e) {
          var index = $inputs.index(this),
              nextIndex = 0;
          switch(e.which) {
              case 38: 
                  nextIndex = (index > 0) ? index - 1 : 0;
                  break;
              case 40: 
                  nextIndex = (index < $inputs.length - 1) ? index + 1 : $inputs.length - 1;
                  break;
              default: return; 
          }
          
          $inputs.eq(nextIndex).focus();
          $inputs.eq(nextIndex).select()
          e.preventDefault(); 
});

</script>



<style>


.loyalty_inputs {
  border: 1px solid var(--primary-color);
  border-radius: 5px;
  padding-right: 10px;
  padding-left: 10px;
}

.charges-label, .charges-input {
  height: 100%;
  color: var(--text-color)
}


.selectTypeAmount {
  background: none;
  color: var(--text-color);
  border: none;
  width: 100%;
}

.taxVal {
  border: 1px solid var(--primary-color);
  width: 100%;
  height: 100%;
  border-radius: 10px;
}
.inner-border {
    height: 100%;
    width: 100%;
    box-sizing: border-box; /* Ensure border is included in the element's total width and height */
}


.titleCharges .labelTitle{
 
  color: var(--primary-color);
  min-width: 30%;
  /* width: 95%; */
  font-size: 35px;
}

.charge-container {
  width: 95%;
}





.charges-container {
  padding: 5px;
  border: 1px solid var(--primary-color);
  height: 10vh;
  width: 25vw;
  border-radius: 20px;
}

.loyalty_points {
  padding: 5px;
  border: 1px solid var(--primary-color);
  height: auto;
  width: 25vw;
  border-radius: 20px;
}

.serviceCharges{
    width: 30%;
    height: 50px
}
.chargesCards{
    height: 60vh !important;
   
}
 .setExpiration{
    border-radius: 5px;
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
    background-color: #ddd;
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
  .usersTable{
    position: absolute; 
    left: 2px;
    right:2px;
    margin-top: 90px;
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
  }
  .text-color::placeholder {
  color: #ffff;
}

.table-border th, td {
  border: 1px solid white;
  padding: 8px;
}
.table-border th{
  background-color: #FF6900;
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

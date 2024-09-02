<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/user-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');


//   $userId = 0;
  
//   $abilityFacade = new AbilityFacade;

// if (isset($_SESSION['user_id'])) {
 
//     $userID = $_SESSION['user_id'];
//     $permissions = $abilityFacade->perm($userID);

    
//     $accessGranted = false;
    
//     foreach ($permissions as $permission) {
//       if (isset($permission['Charges']) && $permission['Charges'] == "Access Granted") {
//         $accessGranted = true;
//         break;
//       }
//     }

//     if (!$accessGranted) {
//       header("Location: 403.php");
//       exit;
//   }
// } else {
//     header("Location: login.php");
//     exit;
// }

//   if (isset($_SESSION["user_id"])){
//     $userId = $_SESSION["user_id"];
//   }
//   if (isset($_SESSION["first_name"])){
//     $firstName = $_SESSION["first_name"];
//   }
//   if (isset($_SESSION["last_name"])){
//     $lastName = $_SESSION["last_name"];
//   }

//   // Redirect to login page if user has not been logged in
//   if ($userId == 0) {
//     header("Location: login");
//   }
//   if (isset($_GET["add_user"])) {
// 		$error = $_GET["add_user"];
//     array_push($success, $error);
// 	}
//   if (isset($_GET["update_user"])) {
// 		$error = $_GET["update_user"];
//     array_push($info, $error);
// 	}
//   if (isset($_GET["delete_user"])) {
// 		$error = $_GET["delete_user"];
//     array_push($info, $error);
// 	}

  

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

              <div class="d-flex mb-4 charges-discount">
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
                          <input disabled type="number" id="tax_value" value="12" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                      </div>
                    </div>
                </div>
              </div>

              <div class="d-flex mb-4 charges-discount">
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
                        <input disabled type="number" id="serviceCharge" value="12" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-flex mb-4 charges-discount">
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

              <div class="d-flex mb-4 charges-discount">
                <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon">
                  
                </span>
                <div class="charges-container" style="float: right">
                  <div class="inner-border p-2 d-flex">
                    <div class="col-8 charges-label pe-5">
                        <label for="">Senior Citizen/PWD</label>
                        <select name="" id="" class="mt-3 selectTypeAmount">
                          <option value="">Percentage</option>
                          <option value="">Fixed</option>
                        </select>     
                    </div>

                    <div class="col-4 charges-input">
                        <input disabled type="number" id="sc_pwd_sp_discount" value="5" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                    </div>
                  </div>
                </div>
              </div>


              <div class="d-flex mb-4 charges-discount">
                <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon">
                  
                </span>
                <div class="charges-container" style="float: right">
                  <div class="inner-border p-2 d-flex">
                    <div class="col-8 charges-label pe-5">
                        <label for="">Solo Parent</label>
                        <select name="" id="" class="mt-3 selectTypeAmount">
                          <option value="">Percentage</option>
                          <option value="">Fixed</option>
                        </select>     
                    </div>

                    <div class="col-4 charges-input">
                        <input disabled type="number" id="sp_discount" value="5" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                    </div>
                  </div>
                </div>
              </div>


              <div class="d-flex mb-4 charges-discount">
                <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon"></span>
                <div class="charges-container" style="float: right">
                  <div class="inner-border p-2 d-flex">
                    <div class="col-8 charges-label pe-5">
                        <label for="">NAAC and MOV</label>
                        <select name="" id="" class="mt-3 selectTypeAmount">
                          <option value="">Percentage</option>
                          <option value="">Fixed</option>
                        </select>     
                    </div>

                    <div class="col-4 charges-input">
                        <input disabled type="number" id="naac_discount" value="5" style="border: 1px solid var(--primary-color)" class="taxVal text-center">
                    </div>
                  </div>
                </div>
              </div>



            <div class="d-flex mb-4 charges-discount">
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

            <div class="d-flex mb-4 charges-discount">
              <span class="me-2 d-flex h-100 justify-content-center align-items-center svgIcon">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="green" class="bi bi-check2-circle" viewBox="0 0 16 16">
                  <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
                  <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                </svg>
              </span>

              <div class="loyalty_points" style="float: right;">
                <div class="inner-border p-2 d-flex" style="height: 100%">

                  <div class="col-12 charges-label">

                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" style="color: var(--primary-color); font-weight: bold">EARNINGS</label>
                    </div>

                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" style="font-style: italic">Minimum Purchase (Php)</label> 
                      <input type="number" placeholder="Enter an amount" id="minPurchase" class="loyalty_inputs text-end mb-2" style="border: 1px solid var(--primary-color)">
                    </div>

                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" class="mb-2" style="font-style: italic">Equivalent</label>  
                      <input type="number" placeholder="Enter equivalent point/s" id="equivalent" class="loyalty_inputs text-end mb-2" style="border: 1px solid var(--primary-color)">
                    </div>


                    <div class="d-flex align-items-center justify-content-between w-100 mt-2">
                      <label for="" style="color: var(--primary-color); font-weight: bold">CONVERSION</label>
                    </div>


                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" style="font-style: italic">Points</label>  
                      <input type="number"  placeholder="Enter a Point/s" id="pointVal" class="loyalty_inputs text-end mb-2" style="border: 1px solid var(--primary-color)">
                    </div>

                    <div class="d-flex align-items-center justify-content-between w-100">
                      <label for="" class="mb-2" style="font-style: italic">Conversion Amount (Php)</label>
                      <input type="number" placeholder="Enter an amount" id="conversionVal" class="loyalty_inputs text-end mb-2" style="border: 1px solid var(--primary-color)">
                    </div>
                    
                  </div>

                </div>
              </div>
            </div> 
          </div>

          <div class="d-flex justify-content-end position-absolute saveBtnSetting w-100">

  <div class="button-group">
    <button type="button" class="btn btn-secondary cancelbtn" style="color: #ffffff; display: none;">
          <svg width="23px" height="23px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
              <g id="SVGRepo_iconCarrier">
                  <path d="M6 18L18 6M6 6l12 12" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
              </g>
          </svg>
          CANCEL
      </button>
      <button type="button" class="btn btn-primary editbtn" style="color: #ffffff;">
        <svg width="23px" height="23px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" 
                stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>
        EDIT
    </button>  

            <button class="btn btn-secondary me-4" id="saveBtnSet">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
              <path d="M11 2H9v3h2z"/>
              <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
            </svg> SAVE SETTINGS</button>

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

document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.querySelector('.editbtn');
    const cancelButton = document.querySelector('.cancelbtn');

    editButton.addEventListener('click', function() {
        
        if (cancelButton.style.display === 'none' || cancelButton.style.display === '') {
            cancelButton.style.display = 'inline-block'; 
        } else {
            cancelButton.style.display = 'none';
        }
    });

    cancelButton.addEventListener('click', function() {
     cancelbtn(); 
        cancelButton.style.display = 'none'; 
    });
});

  var toastDisplayed = false;
  function show_successResponse(message) {
    if (toastDisplayed) {
        return; 
    }

    toastDisplayed = true;
    toastr.options = {
        "onShown": function () {
            $('.custom-toast').css({
                "opacity": 1,
                "text-align": "center",
            });
        },
        "onHidden": function () {
            toastDisplayed = false; 
        },
        "closeButton": true,
        "positionClass": "toast-top-right",
        "timeOut": "3500",
        "extendedTimeOut": "1000",
        "progressBar": true,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "tapToDismiss": false,
        "toastClass": "custom-toast",
        "onclick": function () { 
            toastr.clear();
            toastDisplayed = false;
            }
    };
    toastr.success(message);
  }

  function postSettings() {
    var min_purchase = $('#minPurchase').val();
    var equivalent = $('#equivalent').val();
    var points = $('#pointVal').val();
    var conver_points = $('#conversionVal').val();

    var sc_pwd_sp = $('#sc_pwd_sp_discount').val();
    var solo_parent = $('#sp_discount').val();       
    var naac = $('#naac_discount').val();    
    var tax = $('#tax_value').val();

    var service_charge = $('#serviceCharge').val();
    var other_charge = $('#other_charges').val();

    var returnValues = {
        'min_purchase' : min_purchase ?? 0,
        'equivalent' : equivalent ?? 0,
        'points' : points ?? 0,
        'conver_points' : conver_points ?? 0,
        'sc_pwd_sp' : sc_pwd_sp ?? 0,
        'solo_parent' : solo_parent ?? 0,            
        'naac' : naac ?? 0,
        'tax' : tax ?? 0,
        'service_charge' : service_charge ?? 0,
        'other_charge' : other_charge ?? 0,
    };

    axios.post('api.php?action=postSettings', {
        'returnVal' : returnValues,
    })
    .then(function(response) {
        console.log(response.data);
        show_successResponse('Successfully Updated!');
        setTimeout(function() {
            location.reload(); // Refresh the page after a successful save
        }, 800); // Adjust the timeout duration as needed
    })
    .catch(function(error) {
        console.log(error);
    });
}


function cancelbtn() {
    var min_purchase = $('#minPurchase').val();
    var equivalent = $('#equivalent').val();
    var points = $('#pointVal').val();
    var conver_points = $('#conversionVal').val();

    var sc_pwd_sp = $('#sc_pwd_sp_discount').val();
    var solo_parent = $('#sp_discount').val();       
    var naac = $('#naac_discount').val();    
    var tax = $('#tax_value').val();

    var service_charge = $('#serviceCharge').val();
    var other_charge = $('#other_charges').val();

    var returnValues = {
        'min_purchase' : min_purchase ?? 0,
        'equivalent' : equivalent ?? 0,
        'points' : points ?? 0,
        'conver_points' : conver_points ?? 0,
        'sc_pwd_sp' : sc_pwd_sp ?? 0,
        'solo_parent' : solo_parent ?? 0,            
        'naac' : naac ?? 0,
        'tax' : tax ?? 0,
        'service_charge' : service_charge ?? 0,
        'other_charge' : other_charge ?? 0,
    };

    axios.post('api.php?action=postSettings', {
        'returnVal' : returnValues,
    })
    .then(function(response) {
        console.log(response.data);
        setTimeout(function() {
            location.reload(); // Refresh the page after cancel
        }, 100); // Adjust the timeout duration as needed
    })
    .catch(function(error) {
        console.log(error);
    });
}




  $(document).ready(function() {
    getSRate()
  
    var checkIcon = `
      <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="green" class="bi bi-check2-circle" viewBox="0 0 16 16">
        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
      </svg>
    `;

    var lockIcon = `
      <svg width="35" height="35" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
      </g><g id="SVGRepo_iconCarrier"> <path d="M12 14.5V16.5M7 10.0288C7.47142 10 8.05259 10 8.8 10H15.2C15.9474 10 16.5286 10 17 10.0288M7 10.0288C6.41168 10.0647 5.99429 10.1455 5.63803 10.327C5.07354 10.6146 4.6146 11.0735 4.32698 11.638C4 12.2798 4 13.1198 4 14.8V16.2C4 17.8802 4 18.7202 4.32698 19.362C4.6146 19.9265 5.07354 20.3854 5.63803 20.673C6.27976 21 7.11984 21 8.8 21H15.2C16.8802 21 17.7202 21 18.362 20.673C18.9265 20.3854 19.3854 19.9265 19.673 19.362C20 18.7202 20 17.8802 20 16.2V14.8C20 13.1198 20 12.2798 19.673 11.638C19.3854 11.0735 18.9265 10.6146 18.362 10.327C18.0057 10.1455 17.5883 10.0647 17 10.0288M7 10.0288V8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8V10.0288" stroke="#0ED8AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
      </svg>
    `;
      var exIcon = `
      <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="red" class="bi bi-x-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
      </svg>
    `;


  document.querySelectorAll('.taxVal').forEach(function(inputElement) {
    inputElement.addEventListener('input', function (e) {
        var input = e.target.value;
        input = input.replace(/[^0-9]/g, '');
        input = input.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        // e.target.value = input;

        if (parseFloat(e.target.value) > 100) {
          e.target.value = 100;
        }
        
    });
  });

  $('#saveBtnSet').off('click').on('click', function() {
    postSettings()
    
  })

  $('#cancelbtn').off('click').on('click', function() {
    postSettings()
    
  })


// for input disabled
document.querySelectorAll('.charges-discount').forEach(function(chargesDiscountDiv) {
    var svgIconSpan = chargesDiscountDiv.querySelector('.svgIcon');
    var inputBox = chargesDiscountDiv.querySelector('input');
    var selectOption = chargesDiscountDiv.querySelector('.selectTypeAmount');

    if (inputBox.disabled) {
        selectOption.disabled = true;

        if (inputBox.id === 'default_discount' || inputBox.id === 'other_charges') {
            svgIconSpan.innerHTML = exIcon;
        } else {
            svgIconSpan.innerHTML = lockIcon;
        }

        console.log('Hello world');
        chargesDiscountDiv.querySelector('.charges-container').style.borderColor = 'var(--border-color)';
        chargesDiscountDiv.querySelector('.charges-container label').style.color = 'var(--border-color)';
        chargesDiscountDiv.querySelector('.taxVal').style.borderColor = 'var(--border-color)';
        chargesDiscountDiv.querySelector('.taxVal').style.color = 'var(--border-color)';
        chargesDiscountDiv.querySelector('.selectTypeAmount').style.color = 'var(--border-color)';
    } else {
        svgIconSpan.innerHTML = checkIcon;
    }
});


//for edit button
const editButton = document.querySelector('.editbtn');


editButton.addEventListener('click', function() {
  document.querySelectorAll('.charges-discount').forEach(function(chargesDiscountDiv) {
    var svgIconSpan = chargesDiscountDiv.querySelector('.svgIcon');
    var inputBox = chargesDiscountDiv.querySelector('input');
    var selectOption = chargesDiscountDiv.querySelector('.selectTypeAmount');

    if (inputBox.id === 'default_discount' || inputBox.id === 'other_charges') {
      return; 
    }

    inputBox.disabled = false;
    selectOption.disabled = false;

    svgIconSpan.innerHTML = checkIcon;
    chargesDiscountDiv.querySelector('.charges-container').style.borderColor = 'var(--primary-color)';
    chargesDiscountDiv.querySelector('.charges-container label').style.color = 'var(--primary-color)';
    chargesDiscountDiv.querySelector('.taxVal').style.borderColor = 'var(--primary-color)';
    chargesDiscountDiv.querySelector('.taxVal').style.color = 'var(--primary-color)';
    chargesDiscountDiv.querySelector('.selectTypeAmount').style.color = 'var(--primary-color)';
  });
});

  
  
})


 $("#charges").addClass('active');
 $("#pointer").html("Charges");


  function getSRate() {
    axios.get('api.php?action=getServiceCharge')
    .then(function(response){
      var charges = response.data.data;
      var tax = response.data.tax.tax;
      var customer_discount = response.data.cusDiscount.discount_amount;
      var solo_parent = response.data.soloParentDiscount.discount_amount; 
      var naac = response.data.naacDiscount.discount_amount;  
      var loyaltySet = response.data.loyaltyPoits
      


      $.each(charges, function(index, data) {

        if (data.charges == "Service Charge") { // Services Charges
          $('#serviceCharge').val(parseFloat(data.rate * 100).toFixed(2));
          $('#idService').val(data.id)
        }

        if (data.charges == "Other Charges") { // Other Charges
          $('#other_charges').val(parseFloat(data.rate * 100).toFixed(2));
          $('#idOthers').val(data.id)
        }
      });

      $('#tax_value').val(parseFloat(tax).toFixed(2))
      $('#sc_pwd_sp_discount').val(parseFloat(customer_discount).toFixed(2))
      $('#sp_discount').val(parseFloat(solo_parent).toFixed(2));  
        $('#naac_discount').val(parseFloat(naac).toFixed(2));    
   


      $('#minPurchase').val(loyaltySet.min_amount);
      $('#equivalent').val(loyaltySet.equivalent_point);
      $('#pointVal').val(loyaltySet.points);
      $('#conversionVal').val(loyaltySet.converted_amount);

    }).catch(function(error){
      console.log(error)
    })
  }


 
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


.main-panel {
  -webkit-user-select: none; 
  -moz-user-select: none;   
  -ms-user-select: none;  
  user-select: none;   
}


.saveBtnSetting {
  bottom: 5vh;
  height: auto;
}


.saveBtnSetting button {
  background: var(--primary-color) !important;
  height: 5vh;
  border: none;
}


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

  .saveBtnSet:hover {
     transform: scale(0.9);
  }
  .editBtn {
    text-decoration: none; 
    border-radius: 3px; 
    overflow: hidden;
    display: inline-block; 
    transition: transform 0.3s;
    color: white
  }

  .saveBtnSet {
    text-decoration: none; 
    border-radius: 3px; 
    overflow: hidden;
    display: inline-block; 
    transition: transform 0.3s;
    color: white
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


@media screen and (max-width: 1400px) {
.row{
  zoom:80%;
}
.charges-container{
 
  height: 100px;
}

.button-group{
  margin-top:-50px;
margin-left: 200px;
}

.loyalty_points{
 max-width: 500px;
 margin-left: -5px;
}

.loyalty_inputs::placeholder {
  font-size: 15px; 
  float:inline-start;

}

}
</style>

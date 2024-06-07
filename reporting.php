<?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/product-facade.php');
  include( __DIR__ . '/utils/models/ingredients-facade.php');
  include(__DIR__ . '/utils/models/user-facade.php');
  include(__DIR__ . '/utils/models/other-reports-facade.php');
  include(__DIR__ . '/utils/models/ability-facade.php');
  $productFacade = new ProductFacade;

  $userId = 0;
  
  $abilityFacade = new AbilityFacade;

if (isset($_SESSION['user_id'])) {
 
    $userID = $_SESSION['user_id'];

    
    $permissions = $abilityFacade->perm($userID);

    
    $accessGranted = false;
    foreach ($permissions as $permission) {
        if (isset($permission['Reports']) && $permission['Reports'] == "Access Granted") {
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
    include('./modals/datePickerModal.php');
    include('./modals/showReportsModal.php');
?>
<style>
.headerReport{
    padding-left: 2px;
    margin: 0;
    
}
.text-color{
    font-family: Century Gothic;
    color: white
}
.line {
  display: inline-block;
  width: calc(100% - 50px); 
  border-bottom: 1px solid #575757; 
  margin-left: 5px;
}
::-webkit-scrollbar {
      width: 6px; 
    }

::-webkit-scrollbar-track {
    background: #262626; 
}
::-webkit-scrollbar-thumb {
    background: #888; 
    border-radius: 3px; 
}

::-webkit-scrollbar-thumb:hover {
    background: #555; 
}

.allAnchrBtn:hover {
    color: white;
}
.highlight {
  background-color:   #FF6900;
}
.anchor-container{
    padding:0;
    margin: 0;
    margin-top: 10px;
  
}
.highlightAll{
    padding-left: 20px;
    height: 30px;
    display: flex;
    align-items: center;

}

.custom-select {
  position: relative;
  display: inline-block;
  width: 100%;
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
.custom-input {
  position: relative;
  display: inline-block;
  width: 100%;
}


.custom-input input {
  padding-left: 30px; 
  width: 100%
}

.custom-input .calendar-icon {
  position: absolute;
  top: 50%;
  left: 10px; 
  transform: translateY(-50%);
  cursor: pointer;
}

.divider {
    width: 100%;
    height: 2px; 
    background-color: #333333; 
    margin: 20px 0;
  }
.custom_btn{
    border-color: #333333 !important;
    width: 200px;
    height: 50px
}
.topDiv{
    margin-bottom: 10px;
    
}

/* toggle */

.switchExcludes {
  position: relative;
  display: inline-block;
  width: 40px; 
  height: 20px; 
  outline: none;
}

.switchExcludes input {
  opacity: 0;
  width: 0;
  height: 0;
}

.sliderStatusExcludes {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #262626;
  -webkit-transition: .4s;
  transition: .4s;
  outline: none;
  border-radius: 10px; 
}


.sliderStatusExcludes:before {
  position: absolute;
  content: "";
  height: 16px; 
  width: 16px;
  left: 2px; 
  bottom: 2px;
  background-color: #888888;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%; 
}

input:checked + .sliderStatusExcludes {
  background-color: #00CC00;
}

input:focus + .sliderStatusExcludes {
  box-shadow: 0 0 1px #262626;
}

input:checked + .sliderStatusExcludes:before {
  -webkit-transform: translateX(20px); 
  -ms-transform: translateX(20px);
  transform: translateX(20px); 
}

.sliderStatusExcludes.round {
  border-radius: 10px; 
}

.sliderStatusExcludes.round:before {
  border-radius: 50%; 
}
.sliderStatusExcludes.active {
  background-color: #00CC00;
}
input:not(:checked) + .sliderStatusExcludes {
  background-color: white; 
}

</style>

 <?php include "layout/admin/css.php"?> 
 <div class="container-scroller">
  <!-- partial:partials/_navbar.html -->
  <?php include 'layout/admin/sidebar.php' ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper" style="width:100%">

        <div style="display:flex; width: 100%; height: 100%">
          <div class="cardLeft" style="height:1200px; width: 170vh; border: 1px solid #464646; background-color: #262626; border-radius: 0;">
            <div class="card-body ">
              <h5 class="headerReport text-color">Select report to view or print</h5>
              <h5 class="headerReport text-color" style="margin-top: 5px; display: flex;align-items: center;">Sales<span  class="line"></span></h5>
               <div class="anchor-container">
                  <div id="highlightDiv1" style="width: 100%"><a href="#" onclick="highlightDiv(1)" class="text-color customerAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Customers</span></a></div>
                  <div id="highlightDiv2" style="width: 100%"><a href="#" onclick="highlightDiv(2)" class="text-color usersAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Users</span></a></div>
                  <div id="highlightDiv3" style="width: 100%"><a href="#" onclick="highlightDiv(3)" class="text-color productssAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Products</span></a></div>
                  <div hidden id="highlightDiv4" style="width: 100%"><a href="#" onclick="highlightDiv(4)" class="text-color ingredientsAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Ingredients</span></a></div>
                  <div hidden id="highlightDiv31" style="width: 100%"><a href="#" onclick="highlightDiv(31)" class="text-color bomAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Bill of Materials (B.O.M)</span></a></div>
                  <div id="highlightDiv5" style="width: 100%"><a href="#" onclick="highlightDiv(5)" class="text-color refundAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Refund by Products</span></a></div>
                  <div hidden id="highlightDiv28" style="width: 100%"><a href="#" onclick="highlightDiv(28)" class="text-color refundCustomersAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Refund by Types & Customers</span></a></div>
                  <div id="highlightDiv29" style="width: 100%"><a href="#" onclick="highlightDiv(29)" class="text-color retAndExAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Return and Exchange by Products</span></a></div>
                  <div hidden id="highlightDiv30" style="width: 100%"><a href="#" onclick="highlightDiv(30)" class="text-color retAndExByCustomerAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Return and Exchange by Customers</span></a></div>
                  <div id="highlightDiv6" style="width: 100%"><a href="#" onclick="highlightDiv(6)" class="text-color taxRatesAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Tax Rates</span></a></div>
                  <div id="highlightDiv7" style="width: 100%"><a href="#" onclick="highlightDiv(7)" class="text-color paymentTypesAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Payment Types</span></a></div>
                  <div id="highlightDiv8" style="width: 100%"><a href="#" onclick="highlightDiv(8)" class="text-color paymentTypesUsersAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Payment Types by users</span></a></div>
                  <div id="highlightDiv9" style="width: 100%"><a href="#" onclick="highlightDiv(9)" class="text-color paymentTypesCustomersAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Payment Types by customers</span></a></div>
                  <div id="highlightDiv10" style="width: 100%"><a href="#" onclick="highlightDiv(10)" class="text-color profitAndMarginAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Profit & margin</span></a></div>
                  <div hidden id="highlightDiv11" style="width: 100%"><a href="#" onclick=" highlightDiv(11)" class="text-color profitAndLossAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Profit & loss</span></a></div>
                  <div id="highlightDiv12" style="width: 100%"><a href="#" onclick=" highlightDiv(12)" class="text-color unpaidSalesAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Unpaid Sales</span></a></div>
                  <div hidden id="highlightDiv32" style="width: 100%"><a href="#" onclick=" highlightDiv(32)" class="text-color unpaidSalesByCashierAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Unpaid Sales by Cashier</span></a></div>
                  <div id="highlightDiv13" style="width: 100%"><a href="#" onclick=" highlightDiv(13)" class="text-color startingCashEntriesAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Starting Cash Entries</span></a></div>
                  <div id="highlightDiv14" style="width: 100%"><a href="#" onclick=" highlightDiv(14)" class="text-color voidedItemssAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Voided Items</span></a></div>
                  <div id="highlightDiv15" style="width: 100%"><a href="#" onclick=" highlightDiv(15)" class="text-color discountsGrantedAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Discounts Granted</span></a></div>
                  <div id="highlightDiv16" style="width: 100%"><a href="#" onclick=" highlightDiv(16)" class="text-color itemsDiscountssAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Items Discounts</span></a></div>
                  <div hidden id="highlightDiv17" style="width: 100%"><a href="#" onclick=" highlightDiv(17)" class="text-color stocksMovementsAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Stock movement</span></a></div>
               </div>
               <!-- <h5 class="headerReport text-color" style="margin-top: 15px; display: flex;align-items: center;">Purchase<span  class="line"></span></h5>
               <div class="anchor-container">
                  <div id="highlightDiv18" style="width: 100%"><a href="#" onclick=" highlightDiv(18)" class="text-color purchaseProductsAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Products</span></a></div>
                  <div id="highlightDiv19" style="width: 100%"><a href="#" onclick=" highlightDiv(19)" class="text-color suppliersAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Suppliers</span></a></div>
                  <div id="highlightDiv20" style="width: 100%"><a href="#" onclick=" highlightDiv(20)" class="text-color unpaidPurchaseAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Unpaid purchase</span></a></div>
                  <div id="highlightDiv21" style="width: 100%"><a href="#" onclick=" highlightDiv(21)" class="text-color pDiscountsAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Purchase Discounts</span></a></div>
                  <div id="highlightDiv22" style="width: 100%"><a href="#" onclick=" highlightDiv(22)" class="text-color pItemsDiscountsAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Purchased items discounts</span></a></div>
                  <div id="highlightDiv23" style="width: 100%"><a href="#" onclick=" highlightDiv(23)" class="text-color purchaseInvoiceRatesAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Purchase invoice lits</span></a></div>
                  <div id="highlightDiv24" style="width: 100%"><a href="#" onclick=" highlightDiv(24)" class="text-color taxRatesSuppAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Tax Rates</span></a></div>
            </div> -->

            <!-- <h5 class="headerReport text-color" style="margin-top: 15px; display: flex; align-items: center;">Loss&nbsp;and&nbsp;damage<span class="line"></span></h5>
               <div class="anchor-container">
                  <div id="highlightDiv25" style="width: 100%"><a href="#" onclick=" highlightDiv(25)" class="text-color lossAndDamageAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Products</span></a></div>    
            </div> -->
            <!-- <h5 class="headerReport text-color" style="margin-top: 15px; display: flex; align-items: center;">Loss&nbsp;Control<span class="line"></span></h5>
               <div class="anchor-container">
                  <div id="highlightDiv26" style="width: 100%"><a href="#" onclick=" highlightDiv(26)" class="text-color reorderAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Reorder product list</span></a></div>  
                  <div id="highlightDiv27" style="width: 100%"><a href="#" onclick=" highlightDiv(27)" class="text-color lowStockWarningAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Low stock warning</span></a></div>      
            </div> -->
            <h5 class="headerReport text-color" style="margin-top: 15px; display: flex; align-items: center;">BIR<span class="line"></span></h5>
               <div class="anchor-container">
                  <div id="highlightDiv33" style="width: 100%"><a href="#" onclick=" highlightDiv(33)" class="text-color reorderAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Z-Reading</span></a></div>  
                  <div id="highlightDiv34" style="width: 100%"><a href="#" onclick=" highlightDiv(34)" class="text-color lowStockWarningAnchrBtn highlightAll allAnchrBtn" style="text-decoration: none;">
                  <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H9.67452C10.1637 5 10.4083 5 10.6385 5.05526C10.8425 5.10425 11.0376 5.18506 11.2166 5.29472C11.4184 5.4184 11.5914 5.59135 11.9373 5.93726L12.0627 6.06274C12.4086 6.40865 12.5816 6.5816 12.7834 6.70528C12.9624 6.81494 13.1575 6.89575 13.3615 6.94474C13.5917 7 13.8363 7 14.3255 7H17.8C18.9201 7 19.4802 7 19.908 7.21799C20.2843 7.40973 20.5903 7.71569 20.782 8.09202C21 8.51984 21 9.0799 21 10.2V15.8C21 16.9201 21 17.4802 20.782 17.908C20.5903 18.2843 20.2843 18.5903 19.908 18.782C19.4802 19 18.9201 19 17.8 19H6.2C5.07989 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg><span style="margin-top:5px; margin-left: 3px">Sales Report</span></a></div>      
            </div>
            </div>
          </div>
          <div class="cardRight" style="height:1200px; width: 60vh; border: 1px solid #464646; background-color: #262626; border-radius: 0;">
            <div class="card-body" style="margin-left: 20px;margin-right: 20px" >
            <h5 class="headerReport text-color" style="margin-left: -20px">Filter</h5>
            <div hidden class="custom-select" id="customerDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px;">Select Customers</label>
                <div  class="select-container">
                    <select id="customersSelect">
                    <option value="" selected>All Customers</option>
                    <?php
                        $userFacade = new UserFacade;
                        $users = $userFacade->getCustomersData();
                        while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['first_name'] .' ' . $row['last_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
            <div hidden class="custom-select" id="suppliersDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Suppliers</label>
                <div class="select-container">
                    <select id="suppliersSelect">
                    <option value="" selected disabled>All Suppliers</option>
                    <?php
                        $productFacade = new ProductFacade;
                        $products =  $productFacade->getSuppliersData();
                        while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['supplier'] .' </option>';
                        }
                        ?>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
            <div hidden class="custom-select" id="usersDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Users</label>
                <div class="select-container">
                    <select id="usersSelect">
                        <option value="" selected >All Users</option>
                        <?php
                        $userFacade = new UserFacade;
                        $users = $userFacade->getUsersData();
                        while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['first_name'] .' ' . $row['last_name'] . '</option>';
                        }
                        ?>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
            <div hidden class="custom-select" id="cashRegisterDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Cash Register</label>
                <div class="select-container">
                    <select id="cashRegisterSelect">
                    <option value="" selected disabled>All Cash Register</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
            <div hidden class="custom-select" id="productsDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Products</label>
                <div class="select-container">
                        <input type="text" id = "selectProducts">
                    <!-- <select id="selectProducts" >
                    <option value="" selected >All Products</option>
                    <?php
                        // $productFacade = new ProductFacade;
                        // $products =  $productFacade->getProductsData();
                        // while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
                        //     echo '<option value="' . $row['id'] . '">' . $row['prod_desc'] .' </option>';
                        // }
                        // ?>
                    </select>
                    <div class="select-arrow"></div> -->
                </div>
            </div>
            <div hidden class="custom-select" id="categoriesDiv">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Product Categories</label>
                <div class="select-container" >
                    <select id="categoreisSelect">
                    <option value="" selected>ALL Product Categories</option>
                    <?php
                        $productFacade = new ProductFacade;
                        $products =  $productFacade->getCategoriesData();
                        while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['category_name'] .' </option>';
                        }
                        ?>
                    </select>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
            <div hidden class="custom-select" id="subCategoriesDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Product Sub-categories</label>
                <div class="select-container">
                    <select id="subCategoreisSelect">
                    <option value="" selected >All Product Sub-categories</option>
                    <?php
                        $productFacade = new ProductFacade;
                        $products =  $productFacade->getVariantsData();
                        while ($row = $products->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['variant_name'] .' </option>';
                        }
                        ?>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
            <div hidden class="custom-select" id="ingredientsDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Ingredients</label>
                <div class="select-container">
                    <select id="ingredientsSelect">
                    <option value="" selected >All Ingredients</option>
                    <?php
                        $ingredientFacade = new IngredientsFacade;
                        $ingredients =  $ingredientFacade->getIngredientsData();
                        while ($row = $ingredients->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] .' </option>';
                        }
                        ?>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
            <div hidden class="custom-select" id="methodDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Refund Types</label>
                <div class="select-container">
                    <select id="refundTypesSelect">
                    <option value="" selected >All Refund Types</option>
                    <option value="1">Cash</option>
                    <option value="7">Voucher/Coupon</option>
                    <option value="2">GCash</option>
                    <option value="3">Pay Maya</option>
                    <option value="4">Grab Pay</option>
                    <option value="8">Ali Pay</option>
                    <option value="9">Shopee Pay</option>
                    <option value="5">Visa</option>
                    <option value="6">Master Card</option>
                    <option value="10">Discover</option>
                    <option value="11">American Express</option>
                    <option value="12">JCB</option>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
            <div hidden  class="custom-select" id="discountDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Discount Type</label>
                <div class="select-container">
                    <select id="discountTypesSelect">
                    <option value="" selected >All Discount Type</option>
                    <?php
                        $otherFacade = new OtherReportsFacade;
                        $others =    $otherFacade->getDiscountType();
                        while ($row = $others->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] .' </option>';
                        }
                        ?>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>

            <div hidden class="custom-select" id="paymentMethodDIV">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Payment Method</label>
                <div class="select-container">
                    <select id="paymentTypesSelect">
                    <option value="" selected >All Payment Method</option>
                    <option value="receipt">By Receipt</option>
                    <option value="cash">Cash</option>
                    <option value="coupon">Voucher/Coupon</option>
                    <option value="gcash">GCash</option>
                    <option value="pay maya">Pay Maya</option>
                    <option value="grab pay">Grab Pay</option>
                    <option value="ali pay">Ali Pay</option>
                    <option value="shopee pay">Shopee Pay</option>
                    <option value="visa">Visa</option>
                    <option value="master card">Master Card</option>
                    <option value="discover">Discover</option>
                    <option value="american express">American Express</option>
                    <option value="jcb">JCB</option>
                    <option value="credit">Credit</option>
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
           
            <a hidden href="#" onclick="openModalDatePicker()"class="custom-input" id="dateTimeAnchor" style="margin-top: 20px">
                <input readonly type="text" id="datepicker" style="padding-left: 35px; flex: 1; text-align: center;">
                <svg class="calendar-icon" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier"> 
                        <path d="M7 10H17M7 14H12M7 3V5M17 3V5M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
             </a>
             <div hidden id="toggleDivExcludes" style="margin-top: 10px; display: flex">
            <?php
                  $status = 'Active'; 
                  $opposite_status = ($status == 'Active') ? 'Inactive' : 'Active';
                  ?>
                  <label class="switchExcludes" style="margin-left: 5px">
                      <input readonly type="checkbox" id="statusExcludes"<?php if($status == 'Active')?>>
                      <span class="sliderStatusExcludes round"></span>
                  </label> 
                  <p style="color: #fefefe; font-family: Century Gothic">&nbsp;Exclude Refund and Return & Exchange</p>  
            </div>
            <div hidden class="custom-select" id="soldDiv">
                <label class="text-color" style="display: block; margin-bottom: 5px; margin-top: 10px">Select Options</label>
                <div class="select-container">
                    <select id="soldSelect">
                    <option value="sold" selected >Sold</option>
                    <option value="unsold">Not Sold</option>
                 
                    </select>
                    <div class="select-arrow"></div>
                </div>
            </div>
                <div class="divider"></div>
                <div style="display:flex;justify-content:center" class="topDiv">
                 <button id="showReport" class="custom_btn" style="margin-right: 10px;"><svg height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" enable-background="new 0 0 50 50" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="#fefefe" d="M20.921,31.898c2.758,0,5.367-0.956,7.458-2.704l1.077,1.077l-0.358,0.358 c-0.188,0.188-0.293,0.442-0.293,0.707s0.105,0.52,0.293,0.707l8.257,8.256c0.195,0.195,0.451,0.293,0.707,0.293 s0.512-0.098,0.707-0.293l2.208-2.208c0.188-0.188,0.293-0.442,0.293-0.707s-0.105-0.52-0.293-0.707l-8.257-8.256 c-0.391-0.391-1.023-0.391-1.414,0l-0.436,0.436l-1.073-1.073c1.793-2.104,2.777-4.743,2.777-7.537c0-3.112-1.212-6.038-3.413-8.239 s-5.127-3.413-8.239-3.413s-6.038,1.212-8.238,3.413c-2.201,2.201-3.413,5.126-3.413,8.239c0,3.112,1.212,6.038,3.413,8.238 C14.883,30.687,17.809,31.898,20.921,31.898z M38.855,37.385l-0.794,0.793l-6.843-6.842l0.794-0.793L38.855,37.385z M14.097,13.423 c1.823-1.823,4.246-2.827,6.824-2.827s5.002,1.004,6.825,2.827c1.823,1.823,2.827,4.247,2.827,6.825 c0,2.578-1.004,5.001-2.827,6.824c-1.823,1.823-4.247,2.827-6.825,2.827s-5.001-1.004-6.824-2.827 c-1.823-1.823-2.827-4.247-2.827-6.824C11.27,17.669,12.273,15.246,14.097,13.423z"></path> </g></svg>&nbsp;Show Report</button>
                 <button id="printDocu" class="custom_btn"><svg version="1.1" id="_x32_" width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="" stroke=""><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffff;} </style> <g> <path class="st0" d="M488.626,164.239c-7.794-7.813-18.666-12.684-30.578-12.676H409.01V77.861L331.145,0h-4.225H102.99v151.564 H53.955c-11.923-0.008-22.802,4.862-30.597,12.676c-7.806,7.798-12.665,18.671-12.657,30.574v170.937 c-0.008,11.919,4.847,22.806,12.661,30.589c7.794,7.813,18.678,12.669,30.593,12.661h49.034V512h306.02V409.001h49.037 c11.901,0.008,22.78-4.848,30.574-12.661c7.818-7.784,12.684-18.67,12.677-30.589V194.814 C501.306,182.91,496.436,172.038,488.626,164.239z M323.519,21.224l62.326,62.326h-62.326V21.224z M123.392,20.398l179.725,0.015 v83.542h85.491v47.609H123.392V20.398z M388.608,491.602H123.392v-92.801h-0.016v-96.638h265.217v106.838h0.015V491.602z M480.896,365.751c-0.004,6.353-2.546,11.996-6.694,16.17c-4.166,4.136-9.813,6.667-16.155,6.682h-49.049V281.75H102.974v106.853 H53.955c-6.365-0.015-12.007-2.546-16.166-6.682c-4.144-4.174-6.682-9.817-6.686-16.17V194.814 c0.004-6.338,2.538-11.988,6.686-16.155c4.167-4.144,9.809-6.682,16.166-6.698h49.034h306.02h49.037 c6.331,0.016,11.985,2.546,16.151,6.698c4.156,4.174,6.694,9.817,6.698,16.155V365.751z"></path> <rect x="167.59" y="336.155" class="st0" width="176.82" height="20.405"></rect> <rect x="167.59" y="388.618" class="st0" width="176.82" height="20.398"></rect> <rect x="167.59" y="435.255" class="st0" width="83.556" height="20.398"></rect> <path class="st0" d="M353.041,213.369c-9.263,0-16.767,7.508-16.767,16.774c0,9.251,7.504,16.759,16.767,16.759 c9.263,0,16.77-7.508,16.77-16.759C369.811,220.877,362.305,213.369,353.041,213.369z"></path> <path class="st0" d="M424.427,213.369c-9.262,0-16.77,7.508-16.77,16.774c0,9.251,7.508,16.759,16.77,16.759 c9.258,0,16.766-7.508,16.766-16.759C441.193,220.877,433.685,213.369,424.427,213.369z"></path> </g> </g></svg>&nbsp;Print</button>
                </div>
                <div style="display:flex;justify-content:center" >
                  <button id="EXCELBtn" class="custom_btn" style="margin-right: 10px"><svg height="25px" width="25px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" xml:space="preserve" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#ffff;" d="M25.162,3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162 C25.623,23,26,22.609,26,22.13V3.87C26,3.391,25.623,3,25.162,3z M24,20h-4v-2h4V20z M24,16h-4v-2h4V16z M24,12h-4v-2h4V12z M24,8 h-4V6h4V8z"></path> <path style="fill:#ffff;" d="M0,2.889v20.223L15,26V0L0,2.889z M9.488,18.08l-1.745-3.299c-0.066-0.123-0.134-0.349-0.205-0.678 H7.511C7.478,14.258,7.4,14.494,7.277,14.81l-1.751,3.27H2.807l3.228-5.064L3.082,7.951h2.776l1.448,3.037 c0.113,0.24,0.214,0.525,0.304,0.854h0.028c0.057-0.198,0.163-0.492,0.318-0.883l1.61-3.009h2.542l-3.037,5.022l3.122,5.107 L9.488,18.08L9.488,18.08z"></path> </g> </g></svg>&nbsp;Excel</button>
                 <button id="PDFBtn" class="custom_btn"><svg width="25px" height="25px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.5 6.5V6H2V6.5H2.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 10.5H6V11H6.5V10.5ZM13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM2.5 7H3.5V6H2.5V7ZM3 11V8.5H2V11H3ZM3 8.5V6.5H2V8.5H3ZM3.5 8H2.5V9H3.5V8ZM4 7.5C4 7.77614 3.77614 8 3.5 8V9C4.32843 9 5 8.32843 5 7.5H4ZM3.5 7C3.77614 7 4 7.22386 4 7.5H5C5 6.67157 4.32843 6 3.5 6V7ZM6 6.5V10.5H7V6.5H6ZM6.5 11H7.5V10H6.5V11ZM9 9.5V7.5H8V9.5H9ZM7.5 6H6.5V7H7.5V6ZM9 7.5C9 6.67157 8.32843 6 7.5 6V7C7.77614 7 8 7.22386 8 7.5H9ZM7.5 11C8.32843 11 9 10.3284 9 9.5H8C8 9.77614 7.77614 10 7.5 10V11ZM10 6V11H11V6H10ZM10.5 7H13V6H10.5V7ZM10.5 9H12V8H10.5V9ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1Z" fill="#ffff"></path> </g></svg>&nbsp;Pdf</button>
             </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<?php include("layout/footer.php") ?>
<script>
  $(document).ready(function(e){
    var productsCache = [];
    show_allProducts();
    $("#selectProducts").autocomplete({
      minLength: 2,
      source: function (request, response) {
        var term = request.term;
        var filteredProducts = filterProducts(term);
        var slicedProducts = filteredProducts.slice(0, 5);
        response(slicedProducts);
        if (slicedProducts.length > 0) {
          $('#filters').show();
        } else {
            $('#filters').hide();
        }
        },
        select: function (event, ui) {
          var selectedProductId = ui.item.id;
          $("#selectProducts").val(selectedProductId);
          return false;
        },
    });
    function show_allProducts() {
      $.ajax({
        type: 'GET',
        url: 'api.php?action=get_allProducts',
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            var row = {
              product_id: data[i].id,
              product: data[i].prod_desc,
              barcode: data[i].barcode,
              brand: data[i].brand,
            };
            productsCache.push(row);
          }
        }
      });
    }
    function filterProducts(term) {
      return productsCache.filter(function (row) {
        return row.product.toLowerCase().includes(term) ||
          row.barcode.includes(term) ||
          (row.brand && row.brand.toLowerCase().includes(term)) ||
          (!row.brand && term === "");
      }).map(function (row) {
        return {
          label: row.product ,
          value: row.product,
          id: row.product_id
        };
      });
    }
  })
</script>
<script>
$("#reporting").addClass('active');
  $("#pointer").html("Reporting");
function highlightDiv(id) {
  console.log(id)
  document.querySelectorAll('.anchor-container div').forEach(div => {
    div.classList.remove('highlight');
  });
  $('#PDFBtn').off('click');
  $('#EXCELBtn').off('click')
  $('#showReport').off('click')
  $('#printDocu').off('click')

 
     if (id == 2) {
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)

          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.removeAttribute('hidden');

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');
          
          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);
          
          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);
          
          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          
          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false

        }else if(id == 10){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)

          var soldDiv = document.getElementById('soldDiv');
          soldDiv.removeAttribute('hidden');

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.setAttribute('hidden',true);

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.removeAttribute('hidden');

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.removeAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.removeAttribute('hidden');

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if (id == 6){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)

          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');
          
          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);
          
          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);
          
          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          
          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }
        else if(id==3){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)

          var soldDiv = document.getElementById('soldDiv');
          soldDiv.removeAttribute('hidden');

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.setAttribute('hidden',true);

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.removeAttribute('hidden');

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.removeAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.removeAttribute('hidden');

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
          
        }else if(id == 4){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.removeAttribute('hidden');

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.setAttribute('hidden',true);

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);


          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
         
        }else if(id == 5){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)

          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.removeAttribute('hidden');

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false

        }else if(id == 28){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.removeAttribute('hidden');

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.removeAttribute('hidden');

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 29){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.removeAttribute('hidden');

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 30){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.removeAttribute('hidden');

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 31){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.removeAttribute('hidden');

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.setAttribute('hidden', true);

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.removeAttribute('hidden');

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 1){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.setAttribute('hidden', true);

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.removeAttribute('hidden');

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 13){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.removeAttribute('hidden');

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 12){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.removeAttribute('hidden');

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          document.getElementById("usersSelect").value = "";
          document.getElementById('datepicker').value =""

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 32){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.removeAttribute('hidden');

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          document.getElementById("customersSelect").value = "";
          document.getElementById('datepicker').value =""

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 15){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.removeAttribute('hidden');

          document.getElementById("customersSelect").value = "";
          document.getElementById('datepicker').value =""

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.removeAttribute('hidden');

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 16){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          document.getElementById("customersSelect").value = "";
          document.getElementById('datepicker').value =""

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.removeAttribute('hidden');

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 7){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          document.getElementById("customersSelect").value = "";
          document.getElementById('datepicker').value =""

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden', true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden', true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.removeAttribute('hidden');

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false

        }else if(id == 8){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.removeAttribute('hidden');

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

          document.getElementById("customersSelect").value = "";
          document.getElementById('datepicker').value =""

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden', true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden', true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.removeAttribute('hidden');

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false

        }else if(id == 9){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden', true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.removeAttribute('hidden');

          document.getElementById("customersSelect").value = "";
          document.getElementById('datepicker').value =""

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden', true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden', true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.removeAttribute('hidden');

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
          
        }else if(id == 14){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.removeAttribute('hidden');

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden', true);

          document.getElementById("customersSelect").value = "";
          document.getElementById('datepicker').value =""

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.removeAttribute('hidden');

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden', true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 33){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden', true);

          document.getElementById("customersSelect").value = "";
          document.getElementById('datepicker').value =""

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden', true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden', true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }else if(id == 34){
          generatePdf(id)
          generateExcel(id)
          printDocuments(id)
          showReports(id)
          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.removeAttribute('hidden');

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden', true);

          document.getElementById("customersSelect").value = "";
          document.getElementById('datepicker').value =""

          var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden', true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden', true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }
        else{

          var soldDiv = document.getElementById('soldDiv');
          soldDiv.setAttribute('hidden',true);

          var usersSelect = document.getElementById('usersDIV');
          usersSelect.setAttribute('hidden',true);

          var dateTimeAnchor = document.getElementById('dateTimeAnchor');
          dateTimeAnchor.setAttribute('hidden',true);

          var customerDIV = document.getElementById('customerDIV');
          customerDIV.setAttribute('hidden',true);

         var suppliersDIV = document.getElementById('suppliersDIV');
          suppliersDIV.setAttribute('hidden',true);

          var cashRegisterDIV = document.getElementById('cashRegisterDIV');
          cashRegisterDIV.setAttribute('hidden',true);

          var categoriesDiv = document.getElementById('categoriesDiv');
          categoriesDiv.setAttribute('hidden',true);

          var productsDIV = document.getElementById('productsDIV');
          productsDIV.setAttribute('hidden',true);

          var subCategoriesDIV = document.getElementById('subCategoriesDIV');
          subCategoriesDIV.setAttribute('hidden',true);

   
          var ingredientsDIV = document.getElementById('ingredientsDIV');
          ingredientsDIV.setAttribute('hidden',true);

          var methodDIV = document.getElementById('methodDIV');
          methodDIV.setAttribute('hidden',true);

          var discountDIV = document.getElementById('discountDIV');
          discountDIV.setAttribute('hidden',true);

          var paymentMethodDIV = document.getElementById('paymentMethodDIV');
          paymentMethodDIV.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('toggleDivExcludes');
          toggleDivExcludes.setAttribute('hidden',true);

          var toggleDivExcludes = document.getElementById('statusExcludes');
          toggleDivExcludes.checked = false
        }
   
  document.getElementById('highlightDiv' + id).classList.add('highlight');
}

document.addEventListener("DOMContentLoaded", function() {
    var selectElement = document.getElementById('customersSelect');
    selectElement.addEventListener('change', function() {
      
        if (selectElement.value === "") {
            selectElement.selectedIndex = 0;
        }
    });
});

function openModalDatePicker(){
    $('#dateTimeModal').show()
    $('.predefinedDates').val("")
}

// USERS
function generatePdf(id){
  if(id == 2){
    $('#PDFBtn').off('click').on('click',function() {
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
        $.ajax({
            url: './reports/generate_pdf.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                selectedUser: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'usersList.pdf';
                document.body.appendChild(a);
                a.click();

                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
    });
  }else if(id == 3){
    $('#PDFBtn').off('click').on('click',function() {
      var soldSelect = document.getElementById('soldSelect')
      var selectedOption = soldSelect.value;
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var categoriesSelect = document.getElementById('categoreisSelect')
      var selectedCategories = categoriesSelect.value
      var subCategoreisSelect = document.getElementById('subCategoreisSelect')
      var selectedSubCategories = subCategoreisSelect.value
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
        $.ajax({
            url: './reports/generate-products-data-inventory.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                selectedOption: selectedOption,
                selectedProduct: selectedProduct,
                selectedCategories: selectedCategories,
                selectedSubCategories:  selectedSubCategories,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'product_report.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
    });
  }else if(id == 4){
    $('#PDFBtn').off('click').on('click',function() {
      var ingredientsSelect = document.getElementById('ingredientsSelect')
      var selectedIngredients = ingredientsSelect.value;
      
      $.ajax({
          url: './reports/generate_ingredients_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
            selectedIngredients: selectedIngredients 
          },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'ingredients_list.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
    });
  }else if(id == 5){
    $('#PDFBtn').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_refund_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedProduct: selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'refundList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
    });
  }else if (id == 28){
    $('#PDFBtn').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var refundTypes = document.getElementById('refundTypesSelect')
      var selectedRefundTypes = refundTypes.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_refund_users_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedRefundTypes: selectedRefundTypes,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'refundList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
    });
  }else if(id == 29){
    $('#PDFBtn').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_return_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedProduct: selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'returnAndExchangeList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if(id == 30){
    $('#PDFBtn').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_return_customers.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'returnAndExchangeList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if(id == 31){
    $('#PDFBtn').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var ingredientsSelect = document.getElementById('ingredientsSelect')
      var selectedIngredients = ingredientsSelect.value;
      $.ajax({
          url: './reports/generate_bom_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
            selectedProduct: selectedProduct,
            selectedIngredients: selectedIngredients 
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'bomList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if(id == 1){
    $('#PDFBtn').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      $.ajax({
          url: './reports/generate_customers_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
            customerId: selectedCustomers
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'customerList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if(id == 13){
    $('#PDFBtn').off('click').on('click',function() {
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_cashIn_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'cashEntriesList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if(id == 12){
    $('#PDFBtn').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_unpaid_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                userId: selectedUser,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'unpaidSalesList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if(id==32){
    $('#PDFBtn').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_unpaidpdf_users.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                userId: selectedUser,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'unpaidSalesList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if(id == 15){
    $('#PDFBtn').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var dType = document.getElementById('discountTypesSelect')
      var discountType = dType.value
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
           url: './reports/generate_discountsPerReceipt_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                discountType: discountType,
                customerId: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'discountsGranted.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if(id == 16){
    $('#PDFBtn').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
           url: './reports/generate_item_discounts_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedProduct:selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'itemsDiscounts.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if( id == 7){
    $('#PDFBtn').off('click').on('click',function() {
      var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
      var paymentM = document.getElementById('paymentTypesSelect')
      var paymentMethod =  paymentM.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
           url: './reports/generate_paymentMethod_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                exclude :toggleDivExcludes,
                selectedMethod: paymentMethod,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'paymentMethodList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);

          }
          });
    });
  }else if(id == 8){
    $('#PDFBtn').off('click').on('click',function() {
      var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
           url: './reports/generate_payment_method_users.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                exclude :toggleDivExcludes,
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'paymentMethodList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
          });
    });
  }else if(id == 9){//pdfme
    $('#PDFBtn').off('click').on('click',function() {
      var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
           url: './reports/generate_payment_method_customer.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                exclude :toggleDivExcludes,
                customerId:selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'paymentMethodList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
          });
    });
  }else if(id == 14){//pdf14
    $('#PDFBtn').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
           url: './reports/generate_voided_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedProduct:selectedProduct,
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'voidedList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
          });
    });
  }else if(id == 33){ //pdf33
    $('#PDFBtn').off('click').on('click',function() {
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
           url: './reports/z-read-report.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'zReadReportList.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
          });
    });
  }else if(id == 34){

    $('#PDFBtn').off('click').on('click',function() {
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
        $.ajax({
            url: './reports/bir-sales-report-pdf.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'salesReport.pdf';
                document.body.appendChild(a);
                a.click();

                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
    });
  }else if(id == 6){//taxpdf

    $('#PDFBtn').off('click').on('click',function() {
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
        $.ajax({
            url: './reports/tax-rates-pdf.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'tax-rates.pdf';
                document.body.appendChild(a);
                a.click();

                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
    });
  }else if(id==10){//profitpdf
    $('#PDFBtn').off('click').on('click',function() {
      var soldSelect = document.getElementById('soldSelect')
      var selectedOption = soldSelect.value;
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var categoriesSelect = document.getElementById('categoreisSelect')
      var selectedCategories = categoriesSelect.value
      var subCategoreisSelect = document.getElementById('subCategoreisSelect')
      var selectedSubCategories = subCategoreisSelect.value
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
        $.ajax({
            url: './reports/profit-pdf.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                selectedOption: selectedOption,
                selectedProduct: selectedProduct,
                selectedCategories: selectedCategories,
                selectedSubCategories:  selectedSubCategories,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
              var blob = new Blob([response], { type: 'application/pdf' });
              var url = window.URL.createObjectURL(blob);
              var a = document.createElement('a');
              a.href = url;
              a.download = 'profit.pdf';
              document.body.appendChild(a);
              a.click();

              window.URL.revokeObjectURL(url);
              document.body.removeChild(a);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
    });
  }
}

function generateExcel(id){
  if(id == 2){
    $('#EXCELBtn').off('click').on('click',function() {
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDate = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth()+1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        singleDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }

      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
      singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
            url: './reports/generate_excel.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                selectedUser: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'usersList.xlsx'; 

            
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                
            }
        });
    });
  }else if(id==3){
    $('#EXCELBtn').click(function() {
      var soldSelect = document.getElementById('soldSelect')
      var selectedOption = soldSelect.value;
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var categoriesSelect = document.getElementById('categoreisSelect')
      var selectedCategories = categoriesSelect.value
      var subCategoreisSelect = document.getElementById('subCategoreisSelect')
      var selectedSubCategories = subCategoreisSelect.value
      var datepicker = document.getElementById('datepicker').value
      var singleDateData;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDate = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth()+1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        singleDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }

      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
      singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
    $.ajax({
        url: './reports/generate-products-data-inventory-excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
            selectedOption:selectedOption,
            selectedProduct: selectedProduct,
            selectedCategories: selectedCategories,
            selectedSubCategories:  selectedSubCategories,
            singleDateData: singleDateData,
            startDate: startDate,
            endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'product_report.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 4){
  $('#EXCELBtn').click(function() {
      var ingredientsSelect = document.getElementById('ingredientsSelect')
      var selectedIngredients = ingredientsSelect.value;
      $.ajax({
        url: './reports/generate_ingredients_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
          selectedIngredients: selectedIngredients 
        },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'ingredientsList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 5){
  $('#EXCELBtn').click(function() {
    var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
        url: './reports/generate_refund_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                selectedProduct: selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'refundList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 28){
  $('#EXCELBtn').click(function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var refundTypes = document.getElementById('refundTypesSelect')
      var selectedRefundTypes = refundTypes.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
        url: './reports/generate_refund_users_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                selectedRefundTypes: selectedRefundTypes,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'refundList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 29){
  $('#EXCELBtn').click(function() {
    var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
        url: './reports/generate_return_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                selectedProduct: selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'returnAndExchangeList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 30){
  $('#EXCELBtn').click(function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
        url: './reports/generate_excel_return_customers.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'returnAndExchangeList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id==31){
  $('#EXCELBtn').click(function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var ingredientsSelect = document.getElementById('ingredientsSelect')
      var selectedIngredients = ingredientsSelect.value;
      $.ajax({
        url: './reports/generate_excel_bom.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
              selectedProduct: selectedProduct,
              selectedIngredients: selectedIngredients 
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'bomList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 1){
  $('#EXCELBtn').click(function() {
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
      $.ajax({
        url: './reports/generate_excel_customers.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
             customerId: selectedCustomers
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'customerList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 13){
  $('#EXCELBtn').click(function() {
    var usersSelect = document.getElementById("usersSelect");
        var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_excel_casIn.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'cashEntriesList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 12){
  $('#EXCELBtn').click(function() {
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var usersSelect = document.getElementById("usersSelect");
        var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_excel_unpaid.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                userId: selectedUser,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'unpaidSalesList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 32){
  $('#EXCELBtn').click(function() {
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var usersSelect = document.getElementById("usersSelect");
        var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_excelunpaid_users.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                userId: selectedUser,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'unpaidSalesList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 15){
  $('#EXCELBtn').click(function() {
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var dType = document.getElementById('discountTypesSelect')
        var discountType = dType.value
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_discountsPerReceipt_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                discountType: discountType,
                customerId: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'discountsGrantedList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 16){
  $('#EXCELBtn').click(function() {
        var productSelect = document.getElementById('selectProducts')
        var selectedProduct = productSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_item_discounts_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                selectedProduct:selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'itemsDiscountsList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 7){//excelPayment
  $('#EXCELBtn').click(function() {
        var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_excel_payment_methods.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: {
                exclude :toggleDivExcludes,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'paymentMethodList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 8){
  $('#EXCELBtn').click(function() {
       var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
        var usersSelect = document.getElementById("usersSelect");
        var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_payment_method_users_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: { 
                exclude :toggleDivExcludes,
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'paymentMethodList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 9){
  $('#EXCELBtn').click(function() {
        var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_payment_method_customers_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: { 
                exclude :toggleDivExcludes,
                customerId:selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'paymentMethodList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 14){//excel14
  $('#EXCELBtn').click(function() {
       var productSelect = document.getElementById('selectProducts')
       var selectedProduct = productSelect.value;
       var usersSelect = document.getElementById("usersSelect");
       var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_voided_excel.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: { 
                selectedProduct:selectedProduct,
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'voidedList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id==33){
  $('#EXCELBtn').click(function() {

        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
        url: './reports/generate_excel_zReading.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
           data: { 
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
       success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'zReadingList.xlsx'; 
            document.body.appendChild(link);
            link.click();

            // Clean up
            document.body.removeChild(link);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
}else if(id == 34){
  $('#EXCELBtn').click(function() {
var datepicker = document.getElementById('datepicker').value
var singleDateData = null;
var startDate;
var endDate;
if (datepicker.includes('-')) {
  var dateRange = datepicker.split(' - ');
  var startDates = new Date(dateRange[0].trim());
  var endDate = new Date(dateRange[1].trim());

  var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
  var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

  startDate = formattedStartDate;
  endDate = formattedEndDate;
} else {
  var singleDate = datepicker.trim();
  var singleDate = datepicker.trim();
  var dateObj = new Date(singleDate);
  var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
  singleDateData =  formattedDate

}
if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
  singleDateData = ""
}
if(startDate == "" || startDate == null){
  startDate = ""
}
  if(endDate == "" || endDate == null){
  endDate = ""
}
$.ajax({
url: './reports/bir-sales-report-csv.php',
type: 'GET',
xhrFields: {
    responseType: 'blob'
},
   data: { 
        singleDateData: singleDateData,
        startDate: startDate,
        endDate: endDate
    },
success: function(response) {
  var a = document.createElement('a');
  var url = window.URL.createObjectURL(response);
  a.href = url;
  a.download = 'SALESREPORT.csv';
  document.body.append(a);
  a.click();
  a.remove();
  window.URL.revokeObjectURL(url);
},
error: function(xhr, status, error) {
    console.error(xhr.responseText);
}
});
});
}else if(id==6){//exceltax
  $('#EXCELBtn').click(function() {
var datepicker = document.getElementById('datepicker').value
var singleDateData = null;
var startDate;
var endDate;
if (datepicker.includes('-')) {
  var dateRange = datepicker.split(' - ');
  var startDates = new Date(dateRange[0].trim());
  var endDate = new Date(dateRange[1].trim());

  var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
  var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

  startDate = formattedStartDate;
  endDate = formattedEndDate;
} else {
  var singleDate = datepicker.trim();
  var singleDate = datepicker.trim();
  var dateObj = new Date(singleDate);
  var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
  singleDateData =  formattedDate

}
if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
  singleDateData = ""
}
if(startDate == "" || startDate == null){
  startDate = ""
}
  if(endDate == "" || endDate == null){
  endDate = ""
}
$.ajax({
url: './reports/tax-rates-excel.php',
type: 'GET',
xhrFields: {
    responseType: 'blob'
},
   data: { 
        singleDateData: singleDateData,
        startDate: startDate,
        endDate: endDate
    },
success: function(response) {
  var a = document.createElement('a');
  var url = window.URL.createObjectURL(response);
  a.href = url;
  a.download = 'TAXRATES.csv';
  document.body.append(a);
  a.click();
  a.remove();
  window.URL.revokeObjectURL(url);
},
error: function(xhr, status, error) {
    console.error(xhr.responseText);
}
});
});
}
}

function printDocuments(id){
    if(id==2){
      $('#printDocu').off('click').on('click',function() {
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDate = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth()+1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        singleDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }

      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
      singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }

        $.ajax({
            url: './reports/generate_pdf.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                selectedUser: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
    });
    }else if(id==3){
      $('#printDocu').off('click').on('click',function() {
        var soldSelect = document.getElementById('soldSelect')
        var selectedOption = soldSelect.value;
        var productSelect = document.getElementById('selectProducts')
        var selectedProduct = productSelect.value;
        var categoriesSelect = document.getElementById('categoreisSelect')
        var selectedCategories = categoriesSelect.value
        var subCategoreisSelect = document.getElementById('subCategoreisSelect')
        var selectedSubCategories = subCategoreisSelect.value 
        var datepicker = document.getElementById('datepicker').value
      var singleDateData;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDate = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth()+1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        singleDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }

      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
      singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
    $.ajax({
        url: './reports/generate-products-data-inventory.php',
        type: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        data: {
          selectedOption: selectedOption,
            selectedProduct: selectedProduct,
            selectedCategories: selectedCategories,
            selectedSubCategories:  selectedSubCategories,
            singleDateData: singleDateData,
            startDate: startDate,
            endDate: endDate
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
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            console.log(searchData)
        }
    });
  });
    }else if(id == 4){
      $('#printDocu').off('click').on('click',function() {
      var ingredientsSelect = document.getElementById('ingredientsSelect')
      var selectedIngredients = ingredientsSelect.value;
      $.ajax({
          url: './reports/generate_ingredients_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
            selectedIngredients: selectedIngredients 
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
    });
  });
  }else if(id == 5){
    $('#printDocu').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_refund_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedProduct: selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
  });
  }else if(id == 28){
    $('#printDocu').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var refundTypes = document.getElementById('refundTypesSelect')
      var selectedRefundTypes = refundTypes.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_refund_users_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedRefundTypes: selectedRefundTypes,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
  });
  }else if(id == 29){
    $('#printDocu').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_return_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedProduct: selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
  });
  }else if(id == 30){
    $('#printDocu').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_return_customers.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
  });
  }else if(id==31){
    $('#printDocu').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var ingredientsSelect = document.getElementById('ingredientsSelect')
      var selectedIngredients = ingredientsSelect.value;
      $.ajax({
          url: './reports/generate_bom_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
              selectedProduct: selectedProduct,
              selectedIngredients: selectedIngredients 
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
  });
  }else if(id == 1){
    $('#printDocu').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      $.ajax({
          url: './reports/generate_customers_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
             customerId: selectedCustomers
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
  });
  }else if(id == 13){
    $('#printDocu').off('click').on('click',function() {
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_cashIn_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
              userId: selectedUser,
              singleDateData: singleDateData,
              startDate: startDate,
              endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
  });
  }else if(id == 12){
    $('#printDocu').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_unpaid_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                userId: selectedUser,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
  });
  }else if(id == 32){
    $('#printDocu').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_unpaidpdf_users.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                userId: selectedUser,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
  });
  }else if(id == 15){
    $('#printDocu').off('click').on('click',function() {
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var dType = document.getElementById('discountTypesSelect')
      var discountType = dType.value
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
           url: './reports/generate_discountsPerReceipt_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                discountType: discountType,
                customerId: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }else if(id == 16){
    $('#printDocu').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
           url: './reports/generate_item_discounts_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedProduct:selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }else if(id == 7){
    $('#printDocu').off('click').on('click',function() {
      var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
      var paymentM = document.getElementById('paymentTypesSelect')
      var paymentMethod =  paymentM.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_paymentMethod_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                 exclude :toggleDivExcludes,
                selectedMethod: paymentMethod,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }else if(id === 8){
    $('#printDocu').off('click').on('click',function() {
      var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_payment_method_users.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                exclude :toggleDivExcludes,
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }else if(id == 9){
    $('#printDocu').off('click').on('click',function() {
      var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
      var customerSelect = document.getElementById('customersSelect')
      var selectedCustomers = customerSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_payment_method_customer.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                exclude :toggleDivExcludes,
                customerId:selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }else if(id == 14){
    $('#printDocu').off('click').on('click',function() {
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_voided_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedProduct:selectedProduct,
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }else if(id == 33){
    $('#printDocu').off('click').on('click',function() {
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
        url: './reports/z-read-report.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }else if(id == 34){
    $('#printDocu').off('click').on('click',function() {
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
        url: './reports/bir-sales-report-pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }else if(id == 6){//printtax
    $('#printDocu').off('click').on('click',function() {
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
        url: './reports/tax-rates-pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }else if(id==10){//printprofit
    $('#printDocu').off('click').on('click',function() {
      var soldSelect = document.getElementById('soldSelect')
      var selectedOption = soldSelect.value;
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var categoriesSelect = document.getElementById('categoreisSelect')
      var selectedCategories = categoriesSelect.value
      var subCategoreisSelect = document.getElementById('subCategoreisSelect')
      var selectedSubCategories = subCategoreisSelect.value
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/profit-pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedOption: selectedOption,
                selectedProduct: selectedProduct,
                selectedCategories: selectedCategories,
                selectedSubCategories:  selectedSubCategories,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
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
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              
          }
          });
  });
  }
 }

function showReports(id){
  if(id == 2){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
   if($('#showReportsModal').is(":visible")){
    var loadingImage = document.getElementById("loadingImage");
    loadingImage.removeAttribute("hidden");
    var pdfFile= document.getElementById("pdfFile");
    pdfFile.setAttribute('hidden',true)
     var usersSelect = document.getElementById("usersSelect");
      var selectedUser = usersSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDate = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth()+1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        singleDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }

      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
      singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }

        $.ajax({
            url: './reports/generate_pdf.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
                selectedUser: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
              loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/users/usersList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
     }
    })
  }else if(id == 3){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
      var soldSelect = document.getElementById('soldSelect')
      var selectedOption = soldSelect.value;
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var productSelect = document.getElementById('selectProducts')
        var selectedProduct = productSelect.value;
        var categoriesSelect = document.getElementById('categoreisSelect')
        var selectedCategories = categoriesSelect.value
        var subCategoreisSelect = document.getElementById('subCategoreisSelect')
        var selectedSubCategories = subCategoreisSelect.value 
        var datepicker = document.getElementById('datepicker').value
      var singleDateData;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDate = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth()+1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        singleDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }

      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
      singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
        $.ajax({
            url: './reports/generate-products-data-inventory.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
              selectedOption: selectedOption,
              selectedProduct: selectedProduct,
              selectedCategories: selectedCategories,
              selectedSubCategories:  selectedSubCategories,
              singleDateData: singleDateData,
              startDate: startDate,
              endDate: endDate
            },
            success: function(response) {
              loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                  var pdfUrl = './assets/pdf/product/product_report.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
     }
    })
  }else if(id == 4){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var ingredientsSelect = document.getElementById('ingredientsSelect')
        var selectedIngredients = ingredientsSelect.value;
   
        $.ajax({
            url: './reports/generate_ingredients_pdf.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {
              selectedIngredients: selectedIngredients 
            },
            success: function(response) {
              loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/ingredients/ingredients_list.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                console.log(searchData)
            }
        });
     }
    })
  }else if(id == 5){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/generate_refund_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedProduct: selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/refund/refundList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 28){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var refundTypes = document.getElementById('refundTypesSelect')
        var selectedRefundTypes = refundTypes.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_refund_users_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
           data: {
                selectedRefundTypes: selectedRefundTypes,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/refund/refundList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if (id == 29){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var productSelect = document.getElementById('selectProducts')
        var selectedProduct = productSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_return_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                selectedProduct: selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/return/returnAndExchangeList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 30){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_return_customers.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/return/returnAndExchangeList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 31){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var productSelect = document.getElementById('selectProducts')
        var selectedProduct = productSelect.value;
        var ingredientsSelect = document.getElementById('ingredientsSelect')
        var selectedIngredients = ingredientsSelect.value;
      $.ajax({
          url: './reports/generate_bom_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
            selectedProduct: selectedProduct,
            selectedIngredients: selectedIngredients 
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/bom/bomList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 1){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
      $.ajax({
          url: './reports/generate_customers_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
            customerId: selectedCustomers
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/customer/customerList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 13){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var usersSelect = document.getElementById("usersSelect");
        var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_cashIn_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/entries/cashEntriesList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 12){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var usersSelect = document.getElementById("usersSelect");
        var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_unpaid_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                userId: selectedUser,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/unpaid/unpaidSalesList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 32){
 $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var usersSelect = document.getElementById("usersSelect");
        var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_unpaidpdf_users.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                userId: selectedUser,
                selectedCustomers: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/unpaidByUser/unpaidSalesList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if (id == 15){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var dType = document.getElementById('discountTypesSelect')
        var discountType = dType.value
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_discountsPerReceipt_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                discountType: discountType,
                customerId: selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                 var pdfUrl = './assets/pdf/discounts_granted/discountsGranted.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 16){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var productSelect = document.getElementById('selectProducts')
        var selectedProduct = productSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_item_discounts_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                selectedProduct:selectedProduct,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/discounts_items/itemsDiscounts.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 7){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
        var paymentM = document.getElementById('paymentTypesSelect')
        var paymentMethod =  paymentM.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_paymentMethod_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                exclude:toggleDivExcludes,
                selectedMethod: paymentMethod,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                  var pdfUrl = './assets/pdf/payment_method/paymentMethodList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 8){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
        var usersSelect = document.getElementById("usersSelect");
        var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_payment_method_users.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                exclude:toggleDivExcludes,
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/payment_method_users/paymentMethodList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 9){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var toggleDivExcludes = document.getElementById('statusExcludes').checked ? 1 : 0;
        var customerSelect = document.getElementById('customersSelect')
        var selectedCustomers = customerSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_payment_method_customer.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                 exclude :toggleDivExcludes,
                customerId:selectedCustomers,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/payment_method_customer/paymentMethodList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 14){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var productSelect = document.getElementById('selectProducts')
        var selectedProduct = productSelect.value;
        var usersSelect = document.getElementById("usersSelect");
        var selectedUser = usersSelect.value;
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/generate_voided_pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                selectedProduct:selectedProduct,
                userId: selectedUser,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
               var pdfUrl = './assets/pdf/voided/voidedList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 33){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/z-read-report.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                  var pdfUrl = './assets/pdf/zread/zReadReportList.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 34){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/bir-sales-report-pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                  var timestamp = new Date().getTime(); 
                  var pdfUrl = './assets/pdf/salesReport/salesReport.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id == 6){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var datepicker = document.getElementById('datepicker').value
        var singleDateData = null;
        var startDate;
        var endDate;
        if (datepicker.includes('-')) {
          var dateRange = datepicker.split(' - ');
          var startDates = new Date(dateRange[0].trim());
          var endDate = new Date(dateRange[1].trim());

          var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
          var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

          startDate = formattedStartDate;
          endDate = formattedEndDate;
        } else {
          var singleDate = datepicker.trim();
          var singleDate = datepicker.trim();
          var dateObj = new Date(singleDate);
          var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
          singleDateData =  formattedDate
        
        }
        if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
          singleDateData = ""
        }
        if(startDate == "" || startDate == null){
          startDate = ""
        }
          if(endDate == "" || endDate == null){
          endDate = ""
        }
      $.ajax({
          url: './reports/tax-rates-pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                  var pdfUrl = './assets/pdf/tax/tax-rates.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }else if(id==10){
    $('#showReport').off('click').on('click', function(){
       $('#showReportsModal').show()
    if($('#showReportsModal').is(":visible")){
        var loadingImage = document.getElementById("loadingImage");
        loadingImage.removeAttribute("hidden");
        var pdfFile= document.getElementById("pdfFile");
        pdfFile.setAttribute('hidden',true)
        var soldSelect = document.getElementById('soldSelect')
      var selectedOption = soldSelect.value;
      var productSelect = document.getElementById('selectProducts')
      var selectedProduct = productSelect.value;
      var categoriesSelect = document.getElementById('categoreisSelect')
      var selectedCategories = categoriesSelect.value
      var subCategoreisSelect = document.getElementById('subCategoreisSelect')
      var selectedSubCategories = subCategoreisSelect.value
      var datepicker = document.getElementById('datepicker').value
      var singleDateData = null;
      var startDate;
      var endDate;
      if (datepicker.includes('-')) {
        var dateRange = datepicker.split(' - ');
        var startDates = new Date(dateRange[0].trim());
        var endDate = new Date(dateRange[1].trim());

        var formattedStartDate = startDates.getFullYear() + '-' + ('0' + (startDates.getMonth()+1)).slice(-2) + '-' + ('0' + startDates.getDate()).slice(-2);
        var formattedEndDate = endDate.getFullYear() + '-' + ('0' + (endDate.getMonth()+1)).slice(-2) + '-' + ('0' + endDate.getDate()).slice(-2);

        startDate = formattedStartDate;
        endDate = formattedEndDate;
      } else {
        var singleDate = datepicker.trim();
        var singleDate = datepicker.trim();
        var dateObj = new Date(singleDate);
        var formattedDate = dateObj.getFullYear() + '-' + ('0' + (dateObj.getMonth()+1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
        singleDateData =  formattedDate
       
      }
      if(singleDateData == "NaN-aN-aN" || singleDateData == "" || singleDateData == null ){
        singleDateData = ""
      }
      if(startDate == "" || startDate == null){
        startDate = ""
      }
        if(endDate == "" || endDate == null){
        endDate = ""
      }
      $.ajax({
          url: './reports/profit-pdf.php',
          type: 'GET',
          xhrFields: {
              responseType: 'blob'
          },
          data: {
                selectedOption: selectedOption,
                selectedProduct: selectedProduct,
                selectedCategories: selectedCategories,
                selectedSubCategories:  selectedSubCategories,
                singleDateData: singleDateData,
                startDate: startDate,
                endDate: endDate
            },
          success: function(response) {
            loadingImage.setAttribute("hidden",true);
              var pdfFile= document.getElementById("pdfFile");
              pdfFile.removeAttribute('hidden')
              if( loadingImage.hasAttribute('hidden')) {
                var timestamp = new Date().getTime(); 
                var pdfUrl = './assets/pdf/profit/profit.pdf?t=' + timestamp; 
                  $('#pdfViewer').attr('src', pdfUrl);
              }
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
              console.log(searchData)
          }
          });
     }
    })
  }
}
</script>
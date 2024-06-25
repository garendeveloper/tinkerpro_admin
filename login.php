<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin : Backend Site</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="icon" type="image/png" href="assets/login/images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="assets/login/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="assets/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/login/css/main.css">

  <?php

  include( __DIR__ . '/layout/header.php');
  include( __DIR__ . '/utils/db/connector.php');
  include( __DIR__ . '/utils/models/user-facade.php');

  $userFacade = new UserFacade;
  if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}


  if (isset($_POST["login"])) {
    $password = $_POST["password"];

     if (empty($password)) {
      array_push($invalid, 'Password should not be empty!');
    } else {
      $verifyUsernameAndPassword = $userFacade->verifyUsernameAndPassword( $password);
      $signIn = $userFacade->signIn( $password);
      if ($verifyUsernameAndPassword > 0) {
        while ($row = $signIn->fetch(PDO::FETCH_ASSOC)) {
          $_SESSION['user_id'] = $row['id'];
          $_SESSION['first_name'] = $row['first_name'];
          $_SESSION['last_name'] = $row['last_name'];
          header('Location: index'); 
          exit;
        }
      } else {
        array_push($invalid, "Incorrect username or password!");
      }
    }
  }

?>
<style>


  .container-login100{
    background-image: url('./assets/img/admin-background.jpeg');
    background-size: cover;
    font-family: Century Gothic;
    z-index: 1; 
    opacity: 2;
  }
  .wrap-login100 {
    width: 500px;
    border-radius: 10px;
    overflow: hidden;
    padding: 55px 55px 37px 55px;
    background: -webkit-linear-gradient(top, #202025, #09080a);
    background: -o-linear-gradient(top, #7579ff, #b224ef);
    background: -moz-linear-gradient(top, #7579ff, #b224ef);
    background: linear-gradient(top, #7579ff, #b224ef);
    border: 4px solid gray;
    z-index: 1; 
}
.login100-form-btn {
    font-family: Century Gothic;
    font-size: 16px;
    color: #555555;
    line-height: 0.5;
    margin-top: -20;
    : -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 20px;
    min-width: 320px;
    height: 50px;
    border-radius: 15px;
    /* background: #9152f8; */
    /* background: -webkit-linear-gradient(bottom, #FF6710, #FF6710);
    background: -o-linear-gradient(bottom, #7579ff, #b224ef);
    background: -moz-linear-gradient(bottom, #7579ff, #b224ef);
    background: linear-gradient(bottom, #7579ff, #b224ef); */
    position: relative;
    z-index: 1;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
    transition: all 0.4s;
}
.contact100-form-checkbox{
  margin-top: -50px;
}
.wrap-login100{
  background: rgba(0, 0, 0, 0.7);
}
.wrap-login100 {
    width: 300px;
    height: 400px;
    border-radius: 10px;
    overflow: hidden;
    padding: 15px 25px 17px 25px;
    /* background: #0e0e0e;
    background: -webkit-linear-gradient(top, #202025, #09080a);
    background: -o-linear-gradient(top, #7579ff, #b224ef);
    background: -moz-linear-gradient(top, #7579ff, #b224ef);
    background: linear-gradient(top, #7579ff, #b224ef); */
}
.login-header {
  text-align: center;
  margin-top: -200px; 
  font-family: Century Gothic;
  font-weight: 200;
}
.login-header h1{
  font-weight: 200;
}
.container-login100 {
    width: 100%;
    min-height: 100vh;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    padding: 15px;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    position: relative;
    z-index: 1;
    align-content: stretch;
    flex-direction: column;
}

.login-form-btn::before {
  background-color: none;
}
.login-form-btn {
    width: 300px;
    height: 40px;
    border: 2px solid gray;
    border-radius: 10px;
    /* background-color: rgba(255, 103, 0, 2); */
}
</style>
</head>
<body>
	<div class="">
		<div class="container-login100" >
      <div class="login-header" style = "justify-content: center; margin-bottom: 100px">
        <div style = "font-weight: bold; font-size: 40px;  -webkit-text-stroke-width: 1px; -webkit-text-stroke-color: #151515; color: #151515"><b> Business Management Portal </b></div>
        <h5>Manage Business, inventory, products and services</h5>
      </div> 
			<div class="wrap-login100" >
				<form class="login100-form " action="login.php" method = "post">
          <div class="d-flex" style="justify-content: center; ">
            <img style="height: 70px; width: 200px; z-index: 1; opacity: 1" src="./assets/img/tinkerpro-logo-light.png" class="img-fluid " alt="logo">
          </div>

					<span class="login100-form-title p-b-14 p-t-17" style = "margin-top: -20px">
            <div class="d-flex" style="justify-content: center;">
              <img style="height: 150px; width: 200px; " src="./assets/img/fingerprint-scan.webp" class="img-fluid " alt="logo">
            </div>
					</span>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password" autofocus="autofocus" autocomplete="off">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

            <?php include('errors.php') ?>

					<div class="container-login100-form-btn">
						<button class="login-form-btn" type = "submit" name = "login">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="assets/login/vendor/animsition/js/animsition.min.js"></script>
	<script src="assets/login/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/login/vendor/select2/select2.min.js"></script>
	<script src="assets/login/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets/login/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="assets/login/vendor/countdowntime/countdowntime.js"></script>
	<script src="assets/login/js/main.js"></script>

  <script>
    display_settings();
    function display_settings()
    {
      $.ajax({
        type: 'get',
        url: 'api.php?action=pos_settings',
        success:function(response){
          if(response !== "")
          {
            $(".login-form-btn").css("background-color", response)
            $(".login-form-btn").css("border-color", response)
          }
        }
      })
    }
  </script>

</body>
</html>
<?php

	include( __DIR__ . '/utils/db/connector.php');
	include( __DIR__ . '/utils/models/user-facade.php');

	$userFacade = new UserFacade;

	if (isset($_GET["user_id"])) {
		$userId = $_GET["user_id"];
		$deleteUser = $userFacade->deleteUser($userId);
		if ($deleteUser) {
			header("Location: users.php?delete_user=User has been deleted successfully!");
		}
	}

?>
<?php

	include( __DIR__ . '/utils/db/connector.php');
	include( __DIR__ . '/utils/models/withdraw-facade.php');

	$withdrawFacade = new WithdrawFacade;

	if (isset($_GET["withdraw_id"])) {
		$withdrawId = $_GET["withdraw_id"];
		$settleWithdraw = $withdrawFacade->settleWithdraw($withdrawId);
		if ($settleWithdraw) {
			header("Location: index.php");
		}
	}

?>
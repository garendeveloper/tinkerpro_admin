<?php

	include( __DIR__ . '/utils/db/connector.php');
	include( __DIR__ . '/utils/models/transaction-facade.php');

	$transactionFacade = new TransactionFacade;

	if (isset($_GET["transaction_num"])) {
		$transactionNum = $_GET["transaction_num"];
		$pay = $transactionFacade->pay($transactionNum);
		if ($pay) {
			header("Location: index");
		}
	}

?>
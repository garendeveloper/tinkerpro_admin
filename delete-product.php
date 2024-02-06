<?php

	include( __DIR__ . '/utils/db/connector.php');
	include( __DIR__ . '/utils/models/product-facade.php');

	$productFacade = new ProductFacade;

	if (isset($_GET["product_id"])) {
		$productId = $_GET["product_id"];
		$deleteProduct = $productFacade->deleteProduct($productId);
		if ($deleteProduct) {
			header("Location: products.php?delete_product=Product has been deleted successfully!");
		}
	}

?>
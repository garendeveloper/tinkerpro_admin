<?php
// require_once __DIR__ .'/vendor/paymongo/src/HttpClient.php';

// use Paymongo\Paymongo;
// use Paymongo\Resources\PaymentMethod;

// Paymongo::setApiKey('pk_test_zZP6NXXRTNvYhqXmdGYrFN1J');

// $payment_method = PaymentMethod::create([
//     'type' => 'qr',
//     'attributes' => [
//         'amount' => 100,
//         'purpose' => 'Sample QR Code',
//     ],
// ]);

// $qr_code = $payment_method->qr_code;

// ?>

 <img src="<?php echo $qr_code; ?>" alt="GCash QR Code"> 
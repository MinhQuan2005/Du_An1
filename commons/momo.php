<?php
return [
    'partnerCode' => 'YOUR_PARTNER_CODE',
    'accessKey' => 'YOUR_ACCESS_KEY',
    'secretKey' => 'YOUR_SECRET_KEY',
    'endpoint' => 'https://test-payment.momo.vn/gw_payment/transactionProcessor', // Sandbox URL
    'returnUrl' => 'http://yourwebsite.com/index.php?act=momo_return',
    'notifyUrl' => 'http://yourwebsite.com/momo_notify' // Webhook để nhận kết quả từ MoMo
];

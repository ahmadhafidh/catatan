<?php
Yii::setAlias('@command', dirname(__DIR__));

$icons = require(__DIR__ . '/icons.php');
return [
	'icons' => $icons,
	'user.passwordResetTokenExpire' => 3600,
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'no-reply.idkoding@gmail.com',
    'senderName' => 'Catatan',

    'secret_key' => '781aab615cd3c78fe10052df6a361c67',
    'createbilling' => "createbilling",
    'client_id' => "90001",
    'prefix' => "8",
    'billing_type' => "c",
];

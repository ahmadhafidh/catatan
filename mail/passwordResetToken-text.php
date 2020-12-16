<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Hallo <?= $user->username ?>,

Anda menerima e-mail ini karena mengajukan permintaan untuk Lupa Kata Sandi. Berikut ini adalah link untuk mengganti kata sandi baru Anda :

<?= $resetLink ?>

Atau copy link di bawah ini dan buka di dalam browser Anda :

<?= $resetLink ?>

Salam hangat, 
Tim E-Tilang Kejaksaan

Powered by PT. Solusi Pembayaran Elektronik
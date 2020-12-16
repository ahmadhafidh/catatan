<?php
use yii\helpers\Html;
$imageFileName = Yii::getAlias('@app/web/img/mail-header.jpg');
$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
 <tr>
  <td align="center">
        <img class="header-img" src="<?=$message->embed($imageFileName);?>" alt="header img">
      <hr>
  </td>
 </tr>
 <tr>
  <td align="center">
   <h3>Hallo <?= Html::encode($user->username) ?>,</h3>
    <p>Anda menerima e-mail ini karena mengajukan permintaan untuk Lupa Kata Sandi. Berikut ini adalah link untuk mengganti kata sandi baru Anda : </p>
    <a href="<?= $verifyLink ?>" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 3px; background-color: #EB7035; border-top: 12px solid #EB7035; border-bottom: 12px solid #EB7035; border-right: 18px solid #EB7035; border-left: 18px solid #EB7035; display: inline-block;">Reset Password</a>
    <p>Atau copy link di bawah ini dan buka di dalam browser Anda :</p>
    <a href="<?= $verifyLink ?>"><?= $verifyLink ?></a>
    <br>
    <br>
    <br>
    <p>Salam hangat, <br> Tim E-Tilang Kejaksaan</p>
  </td>
 </tr>
 <tr>
  <td align="center">
    <br>
    <hr>
    <p>Powered by PT. Solusi Pembayaran Elektronik <br> 
    </p>
  </td>
 </tr>
</table>
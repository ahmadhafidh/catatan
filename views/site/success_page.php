<?php
use yii\helpers\Html;
?>

<div class="bg-img col-lg-12">
    <div class="card card-success-msg">
        <div class="card-content">
            <div class="card-body">
                <div class="col-lg-12 px-4 pt-3 text-center">
                    <h2>Berhasil</h2>
                    <?php if ($data['type'] == 'mail') { ?>
                        <h1 style="color:blue"><span class="feather fe-mail"></span></h1>
                        <p class="card-text mb-3">
                            Silahkan periksa email Anda. Pastikan email yang Anda input adalah email yang benar.
                        </p>
                    <?php } else { ?>
                        <h1 style="color:green"><span class="feather fe-check-circle"></span></h1>
                        <p class="card-text mb-3">
                            Password baru telah berhasil di set. Silahkan login <a href="<?= Yii::getAlias("@web"); ?>/site/login">disini</a>
                        </p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
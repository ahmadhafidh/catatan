<?php
use yii\helpers\Html;
?>

<div class="bg-img col-lg-12">
    <div class="card card-success-msg">
        <div class="card-content">
            <div class="card-body">
                <div class="col-lg-12 px-4 pt-3 text-center">
                    <h2>Halaman tidak ditemukan</h2>
                    <h1 style="color:red"><span class="feather fe-x-circle"></span></h1>
                    <h4 class="mb-2 card-title"><?= Html::encode($this->title) ?></h4>
                    <p class="card-text mb-3">
                        Silahkan periksa kembali URL Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
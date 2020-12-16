<div class="col-xl-4">
    <div class="card">
        <div class="card-content">
            <div class="card-body pt-2 pb-2">
                <div class="media">
                    <div class="media-body text-left">
                        <span>Total Transaksi</span>
                        <h3 class="font-large-1 mb-0">Rp.
                            <?= number_format($sidebarTransaksi['total_transaksi'] , 2) ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-4">
    <div class="card">
        <div class="card-content">
            <div class="card-body pt-2 pb-2">
                <div class="media">
                    <div class="media-body text-left">
                        <span>Total Transaksi Terbayar</span>
                        <h3 class="font-large-1 mb-0">Rp.
                            <?= number_format($sidebarTransaksi['sudah_dibayar'], 2) ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-4">
    <div class="card">
        <div class="card-content">
            <div class="card-body pt-2 pb-2">
                <div class="media">
                    <div class="media-body text-left">
                        <span>Transaksi Belum Dibayar</span>
                        <h3 class="font-large-1 mb-0">Rp.
                            <?= number_format($sidebarTransaksi['belum_dibayar'], 2); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4">
    <div class="card">
        <div class="card-content">
            <div class="card-body pt-2 pb-2">
                <div class="media">
                    <div class="media-body text-left">
                        <span>Total Pelanggar</span>
                        <h3 class="font-large-1 mb-0">
                            <?= $sidebarPelanggar['total_pelanggar'];?> orang</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-4">
    <div class="card">
        <div class="card-content">
            <div class="card-body pt-2 pb-2">
                <div class="media">
                    <div class="media-body text-left">
                        <span>Pelanggar Sudah Bayar</span>
                        <h3 class="font-large-1 mb-0">
                            <?= $sidebarPelanggar['sudah_bayar'];?> orang</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-4">
    <div class="card">
        <div class="card-content">
            <div class="card-body pt-2 pb-2">
                <div class="media">
                    <div class="media-body text-left">
                        <span>Pelanggar Belum Bayar</span>
                        <h3 class="font-large-1 mb-0"><?= $sidebarPelanggar['belum_bayar'];?> orang</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
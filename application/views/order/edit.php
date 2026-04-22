<div class="content-wrapper">
    <section class="content-header">
        <h1>Pesanan</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('order/index')?>">Pesanan</a></li>
            <li class='aktif'>Edit</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-mytheme">
                    <div class="box-body box-profile">
                        <div class="col-lg-6 col-md-6">
                            <form method="POST">
                                <div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
                                    <label>Status Pesanan</label> <span class="text-red">*</span>
                                    <?php 
                                        $statusArr[0]  = 'Silakan Pilih';
                                        $statusArray   = $statusArr + orderStatusArray();
                                        echo form_dropdown('status', $statusArray, set_value('status', $order->status),' id='status' class="form-control"');
                                    ?>
                                    <?=form_error('status')?>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" id="placeOrder">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="checkout-cart-list">
                                <h3 style="margin-top: 0px">Informasi Pesanan</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Produk</th>
                                            <th>Total Pesanan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($item_pesanan as $orderitem) { ?>
                                            <tr>
                                                <td class="p-1">
                                                    <img class="checkoutimage rounded mx-auto d-block" src="<?=app_image_link($orderitem->coverphoto,'uploads/buku_toko/','buku_toko.jpg')?>" alt="<?=$orderitem->nama?>">
                                                </td>
                                                <td><?=$orderitem->nama?> <strong> × <?=$orderitem->jumlah?></strong></td>
                                                <td><?=app_amount_format($orderitem->subtotal)?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="order_total">
                                            <th colspan="2">Ongkos Kirim</th>
                                            <th><strong><?=app_amount_format($pengaturan_umum->delivery_charge) ?></strong></th>
                                        </tr>
                                        <tr class="order_total">
                                            <th colspan="2">Harga Diskon</th>
                                            <th><strong><?=app_amount_format(0) ?></strong></th>
                                        </tr>
                                        <tr class="order_total">
                                            <th colspan="2">Total Pesanan</th>
                                            <th><strong><?=app_amount_format($order->total + $pengaturan_umum->delivery_charge); ?></strong></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
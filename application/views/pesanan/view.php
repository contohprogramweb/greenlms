<div class="content-wrapper">
    <section class="content-header">
        <h1>Pesanan</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('Pesanan/index')?>">Pesanan</a></li>
            <li class='aktif'>Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-mytheme">
                    <div class="box-body box-profile">
                        <div class="invoice-container" id="invoiceprint">
                            <?php if (calculate($order)) {?>
                                <!-- Header -->
                                <header>
                                    <div class="row align-items-center">
                                        <div class="col-sm-7 pull-left">
                                            <img class="orderlogo" src="<?=app_image_link($pengaturan_umum->logo, 'uploads/images/', 'logo.jpg')?>" alt="<?=$pengaturan_umum->sitename?>" />
                                        </div>
                                        <div class="col-sm-5 pull-right text-right">
                                            <h3><b>Invoice Pesanan</b></h3>
                                        </div>
                                    </div>
                                    <hr />
                                </header>

                                <!-- Main Content -->
                                <main>
                                    <div class="row">
                                        <div class="col-sm-6 pull-left"><strong>Tanggal Buat:</strong> <?=app_date($order->tanggal_dibuat)?></div>
                                        <div class="col-sm-6 pull-right text-right"><strong>Nomo Invoice :</strong> <?=sprintf("%08d", $order->id_pesanan);?></div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-6 pull-left">
                                            <strong>Pesanan Dari</strong>,
                                            <address>
                                                <?=site_address($pengaturan_umum)?>
                                            </address>
                                        </div>
                                        <div class="col-sm-6 pull-right text-right">
                                            <strong>Dikirim Ke</strong>,
                                            <address>
                                                <?=order_delivery_to($order)?>
                                            </address>
                                        </div>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td><strong>Gambar</strong></td>
                                                <td><strong>Buku</strong></td>
                                                <td><strong>Harga Satuan</strong></td>
                                                <td><strong>Quantity</strong></td>
                                                <td><strong>Total Pesanan</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (calculate($item_pesanan)) {foreach ($item_pesanan as $orderitem) { ?>
                                                <tr>
                                                    <td class="p-1">
                                                        <img class="checkoutimage rounded mx-auto d-block" src="<?=app_image_link($orderitem->coverphoto,'uploads/buku_toko/','buku_toko.jpg')?>">
                                                    </td>
                                                    <td><?=$orderitem->nama?></td>
                                                    <td><?=$orderitem->unit_price?></td>
                                                    <td><?=$orderitem->jumlah?></td>
                                                    <td class="text-bold"><?=$orderitem->subtotal?></td>
                                                </tr>
                                            <?php } } ?>
                                            <tr>
                                                <td colspan="4" class="text-right">
                                                    Ongkos Kirim
                                                </td>
                                                <td class="text-bold"><?=app_amount_format($order->delivery_charge)?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right">
                                                    Harga Diskon
                                                </td>
                                                <td class="text-bold"><?=app_amount_format($order->discounted_price)?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Total Pesanan</strong></td>
                                                <td class="text-bold"><?=app_amount_format($order->total)?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-left">
                                                    <span><strong>Status Pesanan: </strong><?=orderStatus($order->status)?></span>
                                                </td>
                                                <td colspan="2" class="text-left">
                                                    <span><strong>Metode Pembayaran: </strong><?=orderPamentMethod($order->payment_method)?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-left">
                                                    <span><strong>Status Pembayaran: </strong><?=orderPamentStatus($order->payment_status)?></span>
                                                </td>
                                                <td colspan="2" class="text-left">
                                                    <span><strong>Jumlah Pembayaran: </strong><?=app_amount_format($order->paid_amount)?></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </main>
                                <!-- Footer -->
                                <footer class="text-center mt-4">
                                    <p><strong>Catatan :</strong> Catatan</p>
                                    <a onclick="printDiv('invoiceprint')" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</a>
                                </footer>
                            <?php } else {?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="not-found">
                                            <h2>Item pesanan tidak ditemukan.</h2>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


    <script>
        function printDiv(divID) {
          let divElements = document.getElementById(divID).innerHTML;
          let oldPage     = document.body.innerHTML;
          document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";
          window.print();
          document.body.innerHTML = oldPage;
          window.location.reload();
        }
    </script>
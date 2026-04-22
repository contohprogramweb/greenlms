<section class="main-slider">
	<div class="container">
		<div class="row">

			<?php $this->load->view('_layouts/myaccount-sidebar');?>

			<div class="col-sm-9">
				<div class="card" id="invoiceprint">
					<div class="card-body" style="color: #000">
						<div class="invoice-container">
						    <?php if (calculate($order)) { ?>
							    <!-- Header -->
							    <header>
							        <div class="row align-items-center">
							            <div class="col-sm-7 text-center text-sm-left">
							                <img class="header-logo" src="<?=app_image_link($pengaturan_umum->logo, 'uploads/images/', 'logo.jpg')?>" alt="<?=$pengaturan_umum->sitename?>" />
							            </div>
							            <div class="col-sm-5 text-center text-sm-right">
							                <h4>Invoice</h4>
							            </div>
							        </div>
							        <hr />
							    </header>

							    <!-- Main Content -->
							    <main>
							        <div class="row">
							            <div class="col-sm-6"><strong>Tanggal buat:</strong> <?=app_date($order->tanggal_dibuat)?></div>
							            <div class="col-sm-6 text-sm-right"><strong>Nomor Invoice:</strong> <?=sprintf("%08d", $order->id_pesanan);?></div>
							        </div>
							        <hr />
							        <div class="row">
							            <div class="col-sm-6">
							                <strong>Pesanan dari</strong>,
							                <address>
							                    <?=site_address($pengaturan_umum)?>
							                </address>
							            </div>
							            <div class="col-sm-6 text-right">
							                <strong>Dikirim ke</strong>,
							                <address>
							                    <?=order_delivery_to($order)?>
							                </address>
							            </div>
							        </div>
					                <table class="table table-bordered mt-3">
					                    <thead>
					                        <tr>
					                            <td><strong>Gambar</strong></td>
					                            <td><strong>Buku</strong></td>
					                            <td><strong>Harga satuan</strong></td>
					                            <td><strong>Quantity</strong></td>
					                            <td><strong>Total</strong></td>
					                        </tr>
					                    </thead>
				                        <tbody>
				                        	<?php if (calculate($item_pesanan)) {foreach ($item_pesanan as $orderitem) {?>
					                            <tr>
					                                <td class="p-1">
					                                	<img class="checkoutimage rounded mx-auto d-block" src="<?=app_image_link($orderitem->coverphoto,'uploads/buku_toko/','buku_toko.jpg')?>">
					                                </td>
					                                <td><?=$orderitem->nama?></td>
					                                <td><?=$orderitem->unit_price?></td>
					                                <td><?=$orderitem->jumlah?></td>
					                                <td class="text-bold"><?=app_amount_format($orderitem->subtotal)?></td>
					                            </tr>
				                        	<?php } } ?>
				                            <tr>
				                                <td colspan="4" class="text-right">
				                                	Ongkos kirim
				                                </td>
				                                <td class="text-bold"><?=app_amount_format($order->delivery_charge)?></td>
				                            </tr>
				                            <tr>
				                                <td colspan="4" class="text-right">
				                                	Harga diskon
				                                </td>
				                                <td class="text-bold"><?=app_amount_format($order->discounted_price)?></td>
				                            </tr>
				                            <tr>
				                                <td colspan="4" class="text-right"><strong>Total</strong></td>
				                                <td class="text-bold"><?=app_amount_format($order->total)?></td>
				                            </tr>
				                            <tr>
				                            	<td colspan="3" class="text-left">
				                            		<span><strong>Status pesanan: </strong><?=orderStatus($order->status)?></span>
				                            	</td>
				                            	<td colspan="2" class="text-left">
				                            		<span><strong>Metode pembayaran: </strong><?=orderPamentMethod($order->payment_method)?></span>
				                            	</td>
				                            </tr>
				                            <tr>
				                            	<td colspan="3" class="text-left">
				                            		<span><strong>Status pembayaran: </strong><?=orderPamentStatus($order->payment_status)?></span>
				                            	</td>
				                            	<td colspan="2" class="text-left">
				                            		<span><strong>Jumlah pembayaran: </strong><?=app_amount_format($order->paid_amount)?></span>
				                            	</td>
				                            </tr>
				                        </tbody>
					                </table>
							    </main>
						    	<!-- Footer -->
							    <footer class="text-center mt-4">
							        <p><strong>Catatan :</strong> <?=$order->notes?></p>
							        <div class="btn-group btn-group-sm d-print-none">
							            <a onclick="printDiv('invoiceprint')" class="btn btn-success text-white">
							            	<i class="fa fa-print"></i> Cetak
							            </a>
							        </div>
							    </footer>
					        <?php } else { ?>
				            	<div class="row">
									<div class="col-sm-12">
					                    <div class="not-found">
					                        <h2>Item pesaan tidak ditemukan.</h2>
					                    </div>
					                </div>
				            	</div>
				            <?php }?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

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
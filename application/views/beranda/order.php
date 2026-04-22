<section class="main-slider">
	<div class="container">
		<div class="row">
			
			<?php $this->load->view('_layouts/myaccount-sidebar'); ?>
			
			<div class="col-sm-9">
				<div class="card">
					<div class="card-body p-0">
						<?php if(calculate($pesanan)) { ?>
							<table class="table table-bordered table-hover">
							  <thead>
							    	<tr>
							      		<th>ID Pesanan</th>
							      		<th>Judul</th>
							      		<th>Tanggal Buat</th>
							      		<th>Status Pembayaran</th>
							      		<th>Status Pesanan</th>
							      		<th>Total</th>
							      		<th>Aksi</th>
							    	</tr>
							  	</thead>
							  	<tbody>
							  		<?php $i = 0; foreach($pesanan as $order) { $i++; ?>
								    	<tr>
								      		<td><?=sprintf("%08d", $order->id_pesanan);?></td>
								      		<td><?=$order->nama?></td>
								      		<td><?=app_date($order->tanggal_dibuat)?></td>
								      		<td><?=orderPamentStatus($order->payment_status)?></td>
								      		<td><?=orderStatus($order->status)?></td>
								      		<td><?=$order->total?></td>
								      		<td>
												<a href="<?=base_url('Akunsaya/orderview/'.$order->id_pesanan)?>" class="btn btn-success btn-sm">
													<i class="fa fa-check-square-o"></i>
												</a>
								      		</td>
								    	</tr>
							    	<?php } ?>
							  	</tbody>
							</table>
						<?php } else { ?>
			                <h2 class="p-3 text-center">Pesanan tidak ditemukan.</h2>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

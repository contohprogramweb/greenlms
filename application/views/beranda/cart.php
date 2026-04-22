	<section class="main-shop">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="cart-page table-responsive table-hover">
					    <table>
					        <thead>
					            <tr>
					                <th class="product-image">Gambar</th>
					                <th class="product-name">Produk</th>
					                <th class="product-price">Harga</th>
					                <th class="product-quantity">Quantity</th>
					                <th class="product-total">Total</th>
					                <th class="product-remove">Hapus</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php if(calculate($cart_contents)) { foreach($cart_contents as $cart_content) { ?>
						            <tr>
						                <td class="product-image">
						                    <a href="<?=base_url('Beranda/single/'.$cart_content['id'])?>">
						                    	<img src="<?=$cart_content['images']?>" alt="<?=$cart_content['nama']?>"/>
						                    </a>
						                </td>
						                <td class="product-name">
						                	<a href="<?=base_url('Beranda/single/'.$cart_content['id'])?>">
						                		<?=$cart_content['nama']?>
						                	</a>
						                </td>
						                <td class="product-price">
						                	<?=app_amount_format($cart_content['harga'])?>
						                </td>
						                <td class="product-quantity">
						                	<input min="1" max="100" value="<?=$cart_content['qty']?>" type="number" />
						                </td>
						                <td class="product-total">
						                	<?=app_amount_format($cart_content['subtotal'])?>
						                </td>
						                <td class="product-remove">
						                    <a href="<?=base_url('Beranda/removecart/'.$cart_content['rowid'])?>"><i class="fa fa-trash-o"></i></a>
						                </td>
						            </tr>
					        	<?php } } ?>
					        </tbody>
					    </table>
					</div>
				</div>
			</div>
			<div class="row">
			    <div class="col-md-8 col-sm-12">
			        <a class="continue-shopping" href="<?=base_url('Beranda/shop')?>">Lanjutkan Belanja</a>
			    </div>
			    <div class="col-md-4 col-sm-12">
			        <div class="cart_totals float-md-right text-md-right">
			            <table class="float-md-right">
			                <tbody>
			                    <tr class="order-total">
			                        <th>Total</th>
			                        <th>
			                            <span class='jumlah'><?=app_amount_format($this->cart->total()); ?></span>
			                        </th>
			                    </tr>
			                </tbody>
			            </table>
			            <div class="wc-proceed-to-checkout">
			                <a href="<?=base_url('Beranda/checkout')?>">Proses Checkout</a>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</section>
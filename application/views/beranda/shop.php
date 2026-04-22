	<section class="main-shop">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="main-slider-menu">
						<span class="sidebar-title"><i class="fa fa-list"></i> Kategori Produk</span>
						<div class="slider-menu">
							<ul>
								<?php foreach($storebookcategorys as $kategori_buku_toko) { ?>
									<li><a href="<?=base_url('Beranda/shop?category='.$kategori_buku_toko->storebookcategoryID)?>"><?=$kategori_buku_toko->nama?></a></li>
								<?php } ?>
								<!-- <li><a href="<?=base_url('/')?>"> + Kategori Lain</a></li> -->
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-9">
					<div class="row">
						<?php if(calculate($storebooks)) { foreach ($storebooks as $buku_toko) { ?>
							<div class="col-sm-4">
							    <div class="single-buku">
							        <div class="buku-image">
							            <a href="<?=base_url('Beranda/single/'.$buku_toko->storebookID)?>">
							                <img class="buku-thumbail-image" src="<?=app_image_link($buku_toko->coverphoto, 'uploads/buku_toko/', 'buku_toko.jpg')?>" alt="single-buku" />
							            </a>
							            <span class="buku-badge-label">Baru</span>
							            <span class="buku-badge-price"><?=$buku_toko->harga?></span>
							        </div>
							        <div class="buku-content">
							            <a href="<?=base_url('Beranda/single/'.$buku_toko->storebookID)?>" class="buku-title">
							            	<?=$buku_toko->nama?>
							            </a>
							            <div class="buku-actions">
						                    <a class="btn btn-outline-success btn-sm" href="<?=base_url('Beranda/single/'.$buku_toko->storebookID)?>"><i class="fa fa-eye"></i></a>
						                    <a class="btn btn-outline-success btn-sm" href="<?=base_url('Beranda/addcart/'.$buku_toko->storebookID)?>"><i class="fa fa-cart-plus"></i></a>
							            </div>
							        </div>
							    </div>
							</div>
						<?php } } else { ?>
			                <div class="col-sm-12">
			                    <div class="not-found">
			                        <h2>Buku dijual tidak ditemukan.</h2>
			                    </div>
			                </div>
						<?php } ?>
					</div>
					<div class="row">
		                <div class="col-sm-12">
		                    <?=$this->pagination->create_links();?>
		                </div>
		            </div>
				</div>
			</div>
		</div>
	</section>
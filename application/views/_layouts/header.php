<!DOCTYPE html>
<html lang="en">
<head>
	 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$get_title?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	
    <link rel="shortcut icon" type="image/x-icon" href="<?=app_image_link($pengaturan_umum->logo, 'uploads/images/', 'logo.jpg')?>">
	<link rel="stylesheet" href="<?=base_url('assets/frontend/css/font-awesome.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/frontend/css/bootstrap.min.css')?>">
	
	<!--Owl.carousel Code Add Here-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/frontend/css/owl.carousel.min.css')?>" media="all" />
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/frontend/css/owl.theme.default.min.css')?>" media="all" />
	<link rel="stylesheet" href="<?=base_url('assets/plugins/toastr/toastr.min.css')?>">

	<!-- All Css files Load Here -->
    <?php 
      if(isset($headerassets['css']) && calculate($headerassets['css'])) {
        foreach ($headerassets['css'] as $css) { ?>
          <link rel="stylesheet" href="<?=base_url($css)?>">
        <?php }
      }
    ?>

	<link rel="stylesheet" href="<?=base_url('assets/frontend/style.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/frontend/css/responsive.css')?>">
	<script type="text/javascript" src="<?=base_url('assets/frontend/js/jquery.min.js')?>"></script>
	<?php 
      if(isset($headerassets['headerjs']) && calculate($headerassets['headerjs'])) {
        foreach ($headerassets['headerjs'] as $headerjs) { ?>
          <script src="<?=base_url($headerjs)?>"></script>
        <?php }
      }
    ?>
    <script type="text/javascript">
        var THEME_BASE_URL = "<?=base_url('/')?>";
    </script>
	
	<style>
		.header a:hover {
			text-decoration:none;
		}
		
		 
		.footer-bootom-menu  ul li a.active {
		  color: #fff !important;
		  font-weight:bolder;
		}
		
		.mainmenu ul li a.active {
		  color: #fff !important;
		  font-weight:bolder;
		}
		
		.buku-category-thumbnail-image {
		  width: 100%;
		  height: 120px;
		}
		
		table.table th {
			text-align:center;
		}

	</style>
	
</head>
<body>
	<section class="header-top">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<a href="mailto:<?=$pengaturan_umum->surel?>" class="header-email">
						<i class="fa fa-envelope"></i> <?=$pengaturan_umum->surel?>
					</a>
					<a href="" class="header-phone">
						<i class="fa fa-phone"></i> <?=$pengaturan_umum->telepon?>
					</a>
				</div>
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
					<ul class="header-items">

						<?php if($this->session->userdata('loggedin')) { ?>
							<li><a href="<?=base_url('dashboard/index')?>" target="_blank"><i class="fa fa-dashboard"></i> Dashboard</a></li>
							<?php if (calculate($this->data["cart_contents"])) { ?>
								<li><a href="<?=base_url('frontend/checkout')?>"><i class="fa fa-cart-arrow-down"></i> Checkout</a></li>
								<li><a href="<?=base_url('frontend/cart')?>"><i class="fa fa-shopping-bag"></i> Chart (<?=$this->cart->total_items()?>)</a></li>
							<?php } ?>
							<li><a href="<?=base_url('myaccount/index')?>"><i class="fa fa-lock"></i> My Account</a></li>
							<li><a href="<?=base_url('myaccount/logout')?>"><i class="fa fa-sign-out"></i> Logout</a></li>
						<?php } else { ?>
							<li><a href="<?=base_url('myaccount/login')?>"><i class="fa fa-sign-in"></i> Login </a></li>
							<?php if($pengaturan_umum->registration) { ?>
								<li><a href="<?=base_url('myaccount/register')?>"><i class="fa fa-user-plus"></i> Daftar</a></li>
						<?php } } ?>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<section class="header">
		<div class="container">
			<div class="row">
				<div class="col-sm-5" style="margin-bottom:5px;">
					<a href="<?=base_url('/')?>">
						<img class="" src="<?=app_image_link($pengaturan_umum->logo, 'uploads/images/', 'logo.jpg')?>" style="width:60px; height:60px; margin-right:20px;" align="left"> <div style="color:#49b14d; margin-top:5px; font-weight:bolder; font-size:2em;"><?php echo strtoupper($pengaturan_umum->sitename);?></div>
					</a>
					
				</div>
				<div class="col-sm-4" style="margin-bottom:5px;">
					<div class="header-search">
						<form action="<?=base_url('frontend/shop')?>" method="GET">
							<div class="input-group input-group-search-form">
							  	<input type="text" placeholder="Cari...." class="form-control form-control-lg input-group-search" name="search" value="<?=$search ?? ''?>" />
							  	<div class="input-group-append search-btn">
							  		<input type="submit" style="width:70px;" class="input-group-text" value="Cari">
							  	</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-sm-3" style="margin-bottom:5px;">
					<div class="carts float-right">
						<button class="btn btn-success btn btn-lg cart-item-badge" type="button" data-toggle="dropdown">
						    <i class="fa fa-shopping-bag"></i> <b>Rp <?=number_format($this->cart->total(),0,",",".")?></b>
						    <span class="badge badge-danger cart-item-badge-count"><?=$this->cart->total_items()?></span>
						</button>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="mini-cart">
							    <?php 
							    $cart_contents = $this->cart->contents();
							    if(calculate($cart_contents)) { foreach($cart_contents as $cart_content) { ?>
								    <div class="cart-item">
								        <div class="cart-item-image">
								            <a href="<?=base_url('frontend/single/'.$cart_content['id'])?>">
								            	<img src="<?=$cart_content['images']?>" alt="<?=$cart_content['nama']?>" />
								            </a>
								        </div>
								        <div class="cart-item-info">
								            <a href="<?=base_url('frontend/single/'.$cart_content['id'])?>">
								            	<?=$cart_content['nama']?> 
								            </a>
								            <p>Qty: <?=$cart_content['qty']?> X <span> <?=$cart_content['harga']?> </span></p>
								        </div>
								        <div class="cart-item-remove">
								            <a class="btn btn-danger btn-sm" href="<?=base_url('frontend/removecart/'.$cart_content['rowid'])?>"><i class="fa fa-trash"></i></a>
								        </div>
								    </div>
								<?php } ?>
								    <div class="mini-cart-total">
								        <div class="cart-total">
								            <span>Ongkos Kirim:</span>
								            <span class='harga'><?=app_amount_format($pengaturan_umum->delivery_charge); ?></span>
								        </div>
								        <div class="cart-total">
								            <span>Total:</span>
								            <span class='harga'><?=number_format($this->cart->total(),0,",",".")?></span>
								        </div>
								    </div>

								    <div class="mini-cart-footer">
							            <a class="btn btn-success btn-sm float-left" href="<?=base_url('frontend/cart')?>">Lihat Keranjang</a>
							            <a class="btn btn-success btn-sm float-right" href="<?=base_url('frontend/checkout')?>">Checkout</a>
								    </div>
								<?php } else { ?>
									<h6 class="p-3">Keranjang Kosong</h6>
								<?php } ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="mainmenu">
		<div class="container">
			<ul>
				<li><a class="<?=$activemenu=='index' ? 'aktif' : ''?>" href="<?=base_url('frontend/index')?>">Home</a></li>
				<li><a class="<?=$activemenu=='buku_elektronik' ? 'aktif' : ''?>" href="<?=base_url('frontend/buku_elektronik')?>">Ebook</a></li>
				<li><a class="<?=$activemenu=='buku' ? 'aktif' : ''?>" href="<?=base_url('frontend/buku')?>">Buku</a></li>
				<li><a class="<?=$activemenu=='shop' ? 'aktif' : ''?>" href="<?=base_url('frontend/shop')?>">Toko</a></li>
				<li><a class="<?=$activemenu=='contact' ? 'aktif' : ''?>" href="<?=base_url('frontend/contact')?>">Kontak</a></li>
			</ul>
		</div>
	</section>
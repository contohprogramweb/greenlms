<style type="text/css">
	.reportnotfound {
		text-align: center;
		font-size: 20px;
		border: 1px solid #ddd;
		padding: 15px 10px;
	}

	@media print {
		body {
			-webkit-print-color-adjust: exact !important;
		}
	}

	.booklist {
		overflow: hidden;
	}

	.item_buku {
		width: 150px;
		margin:0px 15px 25px 0px;
		float: left;
	}

	.item_buku p {
		text-align: center;
		margin-bottom: 2px;	
	}

	.item_buku img {
		width: 150px;
		height: 40px;
	}

</style>
<?php if(calculate($bookitems)) { ?>
	<div class="booklist">
		<?php foreach ($bookitems as $item_buku) { ?>
			<div class='item_buku'>
				<p><?=$buku->codeno.'-'.$item_buku->bookno?></p>
				<img src="<?=base_url('uploads/bookbarcode/'.$buku->codeno.'-'.$item_buku->bookno.'.jpg')?>" alt="">
			</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<div class="reportnotfound">
		Barcode Buku Tidak Tersedia
	</div>
<?php } ?>
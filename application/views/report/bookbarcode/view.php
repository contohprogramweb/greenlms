<style type="text/css">
	.reportheader {
		text-align: center;
		margin-bottom: 10px;
	}
	.reportheader p{
		margin-bottom: 0px;
	}
	.reporttable {
		overflow: hidden;
	}
	.reportnotfound {
		text-align: center;
		font-size: 20px;
		border: 1px solid #ddd;
		padding: 15px 10px;
	}

	.reportfooter {
		text-align: center;
	}

	.reportfooter h4 {
		margin-bottom: 2px;
	}

	.table-bordered {
		border: 1px solid #ddd;
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
<div class="reportheader">
	<h2><?=$pengaturan_umum->sitename?></h2>
	<p><?=$pengaturan_umum->telepon?></p>
	<p><?=$pengaturan_umum->surel?></p>
	<p><?=$pengaturan_umum->alamat?></p>
</div>
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
<div class="reportfooter">
	<h4><?=$pengaturan_umum->sitename?></h4>
	<p><?=$pengaturan_umum->alamat?></p>
</div>
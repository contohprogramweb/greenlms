<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Book Report</title>
</head>
<body>
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
					<img class="bookitemimg" src="<?=base_url('uploads/bookbarcode/'.$buku->codeno.'-'.$item_buku->bookno.'.jpg')?>" alt="">
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
</body>
</html>
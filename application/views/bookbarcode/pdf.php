<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Book Barcode</title>
</head>
<body>
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
			Buku Tidak Tersedia
		</div>
	<?php } ?>
</body>
</html>
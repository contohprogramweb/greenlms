<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Book Report</title>
</head>
<body>
	<div class="reportheader">
		<h2><?=$generalsetting->sitename?></h2>
		<p><?=$generalsetting->phone?></p>
		<p><?=$generalsetting->email?></p>
		<p><?=$generalsetting->address?></p>
	</div>
	<?php if(calculate($books)) { ?>
		<table class="reporttable">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Sampul</th>
					<th>Judul</th>
					<th>Pengarang</th>
					<th>Kode Buku</th>
					<th>Kategori</th>
					<th>Status</th>
					<th>Quantity</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; foreach($books as $book) { $i++;?>
				<tr>
					<td><?=$i?></td>
					<td><img src="<?=app_image_link($book->coverphoto, 'uploads/book/')?>" class="profile_img"></td>
					<td><?=$book->name?></td>
					<td><?=$book->author?></td>
					<td><?=$book->codeno?></td>
					<td><?=isset($bookcategorys[$book->bookcategoryID]) ? $bookcategorys[$book->bookcategoryID]->name : ''?></td>
					<td><?=($book->status == 0) ? 'Tersedia' : 'Tidak Tersedia'?></td>
					<td><?=isset($bookQuantity[$book->bookID]) ? $bookQuantity[$book->bookID] : 0?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } else { ?>
		<div class="reportnotfound">
			Buku Tidak Tersedia
		</div>
	<?php } ?>
	<div class="reportfooter">
		<h4><?=$generalsetting->sitename?></h4>
		<p><?=$generalsetting->address?></p>
	</div>
</body>
</html>
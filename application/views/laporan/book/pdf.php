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
				<?php $i=0; foreach($books as $buku) { $i++;?>
				<tr>
					<td><?=$i?></td>
					<td><img src="<?=app_image_link($buku->coverphoto, 'uploads/buku/')?>" class="profile_img"></td>
					<td><?=$buku->nama?></td>
					<td><?=$buku->penulis?></td>
					<td><?=$buku->codeno?></td>
					<td><?=isset($bookcategorys[$buku->bookcategoryID]) ? $bookcategorys[$buku->bookcategoryID]->nama : ''?></td>
					<td><?=($buku->status == 0) ? 'Tersedia' : 'Tidak Tersedia'?></td>
					<td><?=isset($bookQuantity[$buku->id_buku]) ? $bookQuantity[$buku->id_buku] : 0?></td>
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
		<h4><?=$pengaturan_umum->sitename?></h4>
		<p><?=$pengaturan_umum->alamat?></p>
	</div>
</body>
</html>
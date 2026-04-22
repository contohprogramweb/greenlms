<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Book Issue Report</title>
</head>
<body>
	<div class="reportheader">
		<h2><?=$pengaturan_umum->sitename?></h2>
		<p><?=$pengaturan_umum->telepon?></p>
		<p><?=$pengaturan_umum->surel?></p>
		<p><?=$pengaturan_umum->alamat?></p>
	</div>
	<?php if(calculate($bookissues)) { ?>
		<table class="reporttable">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Foto</th>
					<th>Nama</th>
					<th>Hak Akses</th>
					<th>Judul Buku</th>
					<th>Nomor Buku</th>
					<th>Tgl Pinjam</th>
					<th>Tgl Batas Pinjam</th>
					<th>Perpanjangan</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; foreach($bookissues as $peminjaman_buku) { $i++; ?>
				<tr>
					<td><?=$i?></td>
					<td><img src="<?=app_image_link(isset($members[$peminjaman_buku->id_anggota]) ? $members[$peminjaman_buku->id_anggota]->foto : '', 'uploads/images/')?>" class="profile_img"></td>
					<td><?=isset($members[$peminjaman_buku->id_anggota]) ? $members[$peminjaman_buku->id_anggota]->nama : ''?></td>
					<td><?=isset($roles[$peminjaman_buku->id_peran]) ? $roles[$peminjaman_buku->id_peran]->peran : ''?></td>
					<td><?=isset($books[$peminjaman_buku->id_buku]) ? $books[$peminjaman_buku->id_buku] : ''?></td>
					<td><?=$peminjaman_buku->bookno?></td>
					<td><?=app_date($peminjaman_buku->issue_date)?></td>
					<td><?=app_date($peminjaman_buku->expire_date)?></td>
					<td><?=$peminjaman_buku->diperbarui?></td>
					<td>
						<?php
							if($peminjaman_buku->status == 0) {
								echo 'Issued';
							} elseif($peminjaman_buku->status == 1) {
								echo 'Return';
							} elseif($peminjaman_buku->status == 2) {
								echo 'Lost';
							}
						?>						
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } else { ?>
		<div class="reportnotfound">
			Data tidak tersedia.
		</div>
	<?php } ?>
	<div class="reportfooter">
		<h4><?=$pengaturan_umum->sitename?></h4>
		<p><?=$pengaturan_umum->alamat?></p>
	</div>
</body>
</html>
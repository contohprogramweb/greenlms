<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laporan Data Anggota</title>
</head>
<body>
	<div class="reportheader">
		<h2><?=$pengaturan_umum->sitename?></h2>
		<p><?=$pengaturan_umum->telepon?></p>
		<p><?=$pengaturan_umum->surel?></p>
		<p><?=$pengaturan_umum->alamat?></p>
	</div>
	<?php if(calculate($members)) { ?>
		<table class="reporttable">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Foto</th>
					<th>Nama</th>
					<th>Hak Akses</th>
					<th>Gol. Darah</th>
					<th>Nomor Telp.</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; foreach($members as $anggota) { $i++;?>
				<tr>
					<td><?=$i?></td>
					<td><img src="<?=app_image_link($anggota->foto, 'uploads/anggota/')?>" class="profile_img"></td>
					<td><?=$anggota->nama?></td>
					<td><?=isset($roles[$anggota->id_peran]) ? $roles[$anggota->id_peran]->peran : ''?></td>
					<td><?=$anggota->bloodgroup?></td>
					<td><?=$anggota->telepon?></td>
					<td><?=$anggota->surel?></td>
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
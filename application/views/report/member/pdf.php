<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laporan Data Anggota</title>
</head>
<body>
	<div class="reportheader">
		<h2><?=$generalsetting->sitename?></h2>
		<p><?=$generalsetting->phone?></p>
		<p><?=$generalsetting->email?></p>
		<p><?=$generalsetting->address?></p>
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
				<?php $i=0; foreach($members as $member) { $i++;?>
				<tr>
					<td><?=$i?></td>
					<td><img src="<?=app_image_link($member->photo, 'uploads/member/')?>" class="profile_img"></td>
					<td><?=$member->name?></td>
					<td><?=isset($roles[$member->roleID]) ? $roles[$member->roleID]->role : ''?></td>
					<td><?=$member->bloodgroup?></td>
					<td><?=$member->phone?></td>
					<td><?=$member->email?></td>
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
		<h4><?=$generalsetting->sitename?></h4>
		<p><?=$generalsetting->address?></p>
	</div>
</body>
</html>
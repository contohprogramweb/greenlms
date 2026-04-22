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

		tr.info th {
			background: #d9edf7 !important;
		}
	}

</style>
<div class="reportheader">
	<h2><?=$pengaturan_umum->sitename?></h2>
	<p><?=$pengaturan_umum->telepon?></p>
	<p><?=$pengaturan_umum->surel?></p>
	<p><?=$pengaturan_umum->alamat?></p>
</div>
<?php if(calculate($members)) { ?>
	<table class="table table-hover table-striped table-bordered reporttable">
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
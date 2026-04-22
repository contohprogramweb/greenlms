<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laporan Data Transaksi</title>
</head>
<body>
	<div class="reportheader">
		<h2><?=$pengaturan_umum->sitename?></h2>
		<p><?=$pengaturan_umum->telepon?></p>
		<p><?=$pengaturan_umum->surel?></p>
		<p><?=$pengaturan_umum->alamat?></p>
	</div>
	<?php if(calculate($transactions)) { ?>
		<table class="reporttable">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Jenis Transaksi</th>
					<?php if($reportfor!=1 && $reportfor!=2) { ?>
						<th>Hak Akses</th>
						<th>Anggota</th>
					<?php } ?>
					<th>Tanggal</th>
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; foreach($transactions as $transaction) { $i++;?>
				<tr>
					<td><?=$i?></td>
					<td><?=$transaction['type']?></td>
					<?php if($reportfor !=1 && $reportfor !=2) { ?>
						<td><?=$transaction['peran']?></td>
						<td><?=$transaction['anggota']?></td>
					<?php } ?>
					<td><?=app_date($transaction['tanggal'])?></td>
					<td><?=$transaction['jumlah']?></td>
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
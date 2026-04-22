<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laporan Data Transaksi</title>
</head>
<body>
	<div class="reportheader">
		<h2><?=$generalsetting->sitename?></h2>
		<p><?=$generalsetting->phone?></p>
		<p><?=$generalsetting->email?></p>
		<p><?=$generalsetting->address?></p>
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
						<td><?=$transaction['role']?></td>
						<td><?=$transaction['member']?></td>
					<?php } ?>
					<td><?=app_date($transaction['date'])?></td>
					<td><?=$transaction['amount']?></td>
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
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
<?php if(calculate($transactions)) { ?>
	<table class="table table-hover table-striped table-bordered reporttable">
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
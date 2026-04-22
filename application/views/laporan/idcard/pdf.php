<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laporan Kartu Anggota</title>
</head>
<body>
	<div class="reportheader">
		<h2><?=$pengaturan_umum->sitename?></h2>
		<p><?=$pengaturan_umum->telepon?></p>
		<p><?=$pengaturan_umum->surel?></p>
		<p><?=$pengaturan_umum->alamat?></p>
	</div>
	<div>
	<?php if(calculate($members)) { 
		$sitenames = str_split($pengaturan_umum->sitename);
		foreach($members as $anggota) { if($type==1) { ?>
			<div class="singleidcard">
				<div class="topbar"></div>
				<div class="titlebar">
					<?php 
						if(calculate($sitenames) > 7) {
							$margindefault = 0;
						} else {
							$letter        = calculate($sitenames)-3;
							$margindefault = 80 - ($letter * 18);
						}
					?>	
					<div class="titlebarcenter" style="margin-left: <?=$margindefault?>px">
						<?php if(calculate($sitenames) && calculate($sitenames) <= 7) { foreach($sitenames as $sitename) {
							echo "<div class='titlebarletter'>".$sitename."</div> ";
						} } else { 
							echo "<div class='titlebarletterwidth'>".$pengaturan_umum->sitename."</div> ";
						} ?>
					</div>
				</div>
				<div class="infobar">
					<img style="width: 70px;height: 75px;border: 1px solid #ddd;border-radius: 5px;" src="<?=profile_img($anggota->foto)?>" alt="">
					<h3><?=$anggota->nama?></h3>
					<p>Nomor Anggota: <span><?=generate_memberID($anggota->id_anggota)?></span></p>
					<p>Gol. Darah: <span><?=$anggota->bloodgroup?></span></p>
					<p>No. Telp.: <span><?=$anggota->telepon?></span></p>
					<p>Email: <span><?=$anggota->surel?></span></p>
				</div>
				<div class="bottombar">
					<div class="bottombarborder"></div>
					<div class="bottombaraddress">
						<span><?=$pengaturan_umum->web_address?></span>
					</div>
				</div>
			</div>
		<?php } elseif($type==2) { ?>
			<div class="singleidcard">
				<div class="topbar"></div>
				<div class="titlebar" style="padding-bottom: 0px;"></div>
				<div class="infobar backinfobar">
					<p>Kartu Anggota Milik <?=$pengaturan_umum->sitename?></p>
					<p><u>Jika menemukan mohon mengembalikan ke:</u></p>
					<p><b><?=$pengaturan_umum->sitename?></b></p>
					<p><i><?=$pengaturan_umum->alamat?></i></p>
					<p>Berlaku sampai: <span><?=date('d.m.Y', strtotime('Dec 31'))?></span></p>
				</div>
				<div class="signaturebar">
					<div class="bar">
						<img src="<?=base_url('uploads/idcard/'.generate_memberID($anggota->id_anggota).'.jpg')?>" alt="">
					</div>
					<div class="signature">
						<span>Mengesahkan</span>
					</div>
				</div>
				<div class="bottombar">
					<div class="bottombarborder"></div>
					<div class="bottombaraddress">
						<span><?=$pengaturan_umum->web_address?></span>
					</div>
				</div>
			</div>
	<?php } } } else { ?>
		<div class="reportnotfound">
			Data tidak tersedia. 
		</div>
	<?php } ?>
	</div>
	<div class="reportfooter">
		<h4><?=$pengaturan_umum->sitename?></h4>
		<p><?=$pengaturan_umum->alamat?></p>
	</div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Laporan Kartu Anggota</title>
</head>
<body>
	<div class="reportheader">
		<h2><?=$generalsetting->sitename?></h2>
		<p><?=$generalsetting->phone?></p>
		<p><?=$generalsetting->email?></p>
		<p><?=$generalsetting->address?></p>
	</div>
	<div>
	<?php if(calculate($members)) { 
		$sitenames = str_split($generalsetting->sitename);
		foreach($members as $member) { if($type==1) { ?>
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
							echo "<div class='titlebarletterwidth'>".$generalsetting->sitename."</div> ";
						} ?>
					</div>
				</div>
				<div class="infobar">
					<img style="width: 70px;height: 75px;border: 1px solid #ddd;border-radius: 5px;" src="<?=profile_img($member->photo)?>" alt="">
					<h3><?=$member->name?></h3>
					<p>Nomor Anggota: <span><?=generate_memberID($member->memberID)?></span></p>
					<p>Gol. Darah: <span><?=$member->bloodgroup?></span></p>
					<p>No. Telp.: <span><?=$member->phone?></span></p>
					<p>Email: <span><?=$member->email?></span></p>
				</div>
				<div class="bottombar">
					<div class="bottombarborder"></div>
					<div class="bottombaraddress">
						<span><?=$generalsetting->web_address?></span>
					</div>
				</div>
			</div>
		<?php } elseif($type==2) { ?>
			<div class="singleidcard">
				<div class="topbar"></div>
				<div class="titlebar" style="padding-bottom: 0px;"></div>
				<div class="infobar backinfobar">
					<p>Kartu Anggota Milik <?=$generalsetting->sitename?></p>
					<p><u>Jika menemukan mohon mengembalikan ke:</u></p>
					<p><b><?=$generalsetting->sitename?></b></p>
					<p><i><?=$generalsetting->address?></i></p>
					<p>Berlaku sampai: <span><?=date('d.m.Y', strtotime('Dec 31'))?></span></p>
				</div>
				<div class="signaturebar">
					<div class="bar">
						<img src="<?=base_url('uploads/idcard/'.generate_memberID($member->memberID).'.jpg')?>" alt="">
					</div>
					<div class="signature">
						<span>Mengesahkan</span>
					</div>
				</div>
				<div class="bottombar">
					<div class="bottombarborder"></div>
					<div class="bottombaraddress">
						<span><?=$generalsetting->web_address?></span>
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
		<h4><?=$generalsetting->sitename?></h4>
		<p><?=$generalsetting->address?></p>
	</div>
</body>
</html>
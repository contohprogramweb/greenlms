<section class="main-slider">
    <div class="container">
        <div class="row">

            <?php $this->load->view('_layouts/myaccount-sidebar');?>

            <div class="col-sm-9">
                <div class="user-profile">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="user-profile-image">
                                <img class="img-thumbnail" src="<?=profile_img($anggota->foto)?>" alt="<?=$anggota->nama?> profile picture">
                                <h3><?=$anggota->nama?></h3>
                                <p class="text-muted text-center"><?=calculate($peran) ? $peran->peran : ''?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
	                        <div class="profile_view_item">
	                            <p><b>Email</b>: <?=$anggota->surel?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Jenis Kelamin</b>: <?=$anggota->jenis_kelamin?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Gol. Darah</b>: <?=$anggota->bloodgroup?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Agama</b>: <?=ucfirst($anggota->agama)?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Tanggal Mendaftar</b>: <?=app_date($anggota->joinningdate)?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Tanggal Lahir</b>: <?=app_date($anggota->dateofbirth)?></p>
	                        </div>
                        </div>
                        <div class="col-md-6">
	                        <div class="profile_view_item">
	                            <p><b>Nomor Telp.</b>: <?=$anggota->telepon?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Alamat</b>: <?=$anggota->alamat?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Hak Akses</b>: <?=calculate($peran) ? $peran->peran : ''?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Username</b>: <?=$anggota->nama_pengguna?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Status</b>: <span class="text-danger text-bold"><?=($anggota->status == 1) ? 'Aktif' : 'Non Aktif'?></span></p>
	                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

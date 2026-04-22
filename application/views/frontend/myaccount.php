<section class="main-slider">
    <div class="container">
        <div class="row">

            <?php $this->load->view('_layouts/myaccount-sidebar');?>

            <div class="col-sm-9">
                <div class="user-profile">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="user-profile-image">
                                <img class="img-thumbnail" src="<?=profile_img($member->photo)?>" alt="<?=$member->name?> profile picture">
                                <h3><?=$member->name?></h3>
                                <p class="text-muted text-center"><?=calculate($role) ? $role->role : ''?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
	                        <div class="profile_view_item">
	                            <p><b>Email</b>: <?=$member->email?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Jenis Kelamin</b>: <?=$member->gender?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Gol. Darah</b>: <?=$member->bloodgroup?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Agama</b>: <?=ucfirst($member->religion)?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Tanggal Mendaftar</b>: <?=app_date($member->joinningdate)?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Tanggal Lahir</b>: <?=app_date($member->dateofbirth)?></p>
	                        </div>
                        </div>
                        <div class="col-md-6">
	                        <div class="profile_view_item">
	                            <p><b>Nomor Telp.</b>: <?=$member->phone?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Alamat</b>: <?=$member->address?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Hak Akses</b>: <?=calculate($role) ? $role->role : ''?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Username</b>: <?=$member->username?></p>
	                        </div>
	                        <div class="profile_view_item">
	                            <p><b>Status</b>: <span class="text-danger text-bold"><?=($member->status == 1) ? 'Aktif' : 'Non Aktif'?></span></p>
	                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

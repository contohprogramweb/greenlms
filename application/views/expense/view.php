<div class="content-wrapper">
    <section class="content-header">
        <h1>Anggota</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('anggota/index')?>">Anggota</a></li>
            <li class='aktif'>Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-mytheme">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?=profile_img($anggota->foto)?>" alt="<?=$anggota->nama?> profile picture">
                        <h3 class="profile-username text-center"><?=$anggota->nama?></h3>
                        <p class="text-muted text-center"><?=calculate($peran) ? $peran->peran : ''?></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Jenis Kelamin</b> <span class="pull-right"><?=$anggota->jenis_kelamin?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Nomor Telp.</b> <span class="pull-right"><?=$anggota->telepon?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <span class="pull-right"><?=$anggota->surel?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class='aktif'><a href="#profile" data-toggle="tab">Profil Anggota</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="profile">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile_view_item">
                                        <p><b>Agama</b>: <?=ucfirst($anggota->agama)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Tanggal Daftar</b>: <?=app_date($anggota->joinningdate)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Tanggal Lahir</b>: <?=app_date($anggota->dateofbirth)?></p>
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
                                        <p><b>Status</b>: <span class="text-danger text-bold"><?=($anggota->status == 1) ? 'Aktif' : 'Non Aktif' ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

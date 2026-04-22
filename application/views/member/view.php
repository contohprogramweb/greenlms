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
                        <li class='aktif'><a href="#profile" data-toggle="tab">Profile Anggota</a></li>
                        <li><a href="#peminjaman_buku" data-toggle="tab">Buku Dipinjam</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="profile">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile_view_item">
                                        <p><b>Gol. Darah</b>: <?=$anggota->bloodgroup?></p>
                                    </div>
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
                                        <p><b>Status</b>: <span class="text-danger text-bold"><?=($anggota->status == 0) ? 'Pending' : (($anggota->status == 1) ? 'Aktif' : 'Non Aktif') ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id='peminjaman_buku'>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="hide-table">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kategori</th>
                                                    <th>Buku</th>
                                                    <th>Nomor Buku</th>
                                                    <th>Status</th>
                                                    <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                                        <th>Aksi</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(calculate($bookissues)) { $i=0; foreach($bookissues as $peminjaman_buku) { $i++; ?>
                                                <tr>
                                                    <td data-title="#"><?=$i?></td>
                                                    <td data-title="Kategori"><?=isset($kategori_buku[$peminjaman_buku->bookcategoryID]) ? $kategori_buku[$peminjaman_buku->bookcategoryID] : 'Uncategorized'?></td>
                                                    <td data-title="Buku"><?=isset($buku[$peminjaman_buku->id_buku]) ? $buku[$peminjaman_buku->id_buku] : ''?></td>
                                                    <td data-title="Nomor Buku"><?=$peminjaman_buku->bookno?></td>
                                                    <td data-title="Status">
                                                        <span class="text-bold text-success">
                                                            <?php 
                                                                if($peminjaman_buku->status == 0) {
                                                                    echo 'Dipinjam';              
                                                                } elseif ($peminjaman_buku->status == 1) {
                                                                    echo 'Kembali';              
                                                                } elseif ($peminjaman_buku->status == 2) {
                                                                    echo 'Hilang';
                                                                }
                                                            ?>
                                                        </span>
                                                    </td>
                                                    
                                                    <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                                    <td data-title="Aksi">
                                                        <?=btn_view('peminjaman_buku/view/'.$peminjaman_buku->bookissueID,'Lihat'); ?>
                                                        <?php if($peminjaman_buku->status == 0) { ?>
                                                            <a href="<?=base_url('peminjaman_buku/renewandreturn/'.$peminjaman_buku->bookissueID)?>" class="btn btn-info btn-xs mrg" data-placement="auto" data-toggle="tooltip" data-original-title="Perpanjangan / Kembali"><i class="fa fa-retweet"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                                <?php } } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Kategori</th>
                                                <th>Buku</th>
                                                <th>Nomor Buku</th>
                                                <th>Status</th>
                                                <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                                    <th>Aksi</th>
                                                <?php } ?>
                                            </tr>
                                            </tfoot>
                                        </table>
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

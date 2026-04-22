<div class="content-wrapper">
    <section class="content-header">
        <h1>Profile</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li>Profile</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-mytheme">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?=profile_img($member->photo)?>" alt="<?=$member->name?> profile picture">
                        <h3 class="profile-username text-center"><?=$member->name?></h3>
                        <p class="text-muted text-center"><?=calculate($role) ? $role->role : ''?></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Jenis Kelamin</b> <span class="pull-right"><?=$member->gender?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Nomor Telp.</b> <span class="pull-right"><?=$member->phone?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <span class="pull-right"><?=$member->email?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
                        <li><a href="#bookissue" data-toggle="tab">Buku Dipinjam</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="profile">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile_view_item">
                                        <p><b>Gol. Darah</b>: <?=$member->bloodgroup?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Agama</b>: <?=ucfirst($member->religion)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Tanggal Daftar</b>: <?=app_date($member->joinningdate)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Tanggal Lahir</b>: <?=app_date($member->dateofbirth)?></p>
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
                                        <p><b>Status</b>: <span class="text-danger text-bold"><?=($member->status == 1) ? 'Aktif' : 'Non Aktif' ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="bookissue">
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
                                                <?php if(calculate($bookissues)) { $i=0; foreach($bookissues as $bookissue) { $i++; ?>
                                                <tr>
                                                    <td data-title="#"><?=$i?></td>
                                                    <td data-title="Kategori"><?=isset($bookcategory[$bookissue->bookcategoryID]) ? $bookcategory[$bookissue->bookcategoryID] : 'Uncategorized'?></td>
                                                    <td data-title="Buku"><?=isset($book[$bookissue->bookID]) ? $book[$bookissue->bookID] : ''?></td>
                                                    <td data-title="Nomor Buku"><?=$bookissue->bookno?></td>
                                                    <td data-title="Status">
                                                        <span class="text-bold text-success">
                                                            <?php 
                                                                if($bookissue->status == 0) {
                                                                    echo 'Dipinjam';              
                                                                } elseif ($bookissue->status == 1) {
                                                                    echo 'Kembali';              
                                                                } elseif ($bookissue->status == 2) {
                                                                    echo 'Hilang';
                                                                }
                                                            ?>
                                                        </span>
                                                    </td>
                                                    
                                                    <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                                    <td data-title="Aksi">
                                                        <?=btn_view('bookissue/view/'.$bookissue->bookissueID,'Lihat'); ?>
                                                        <?php if($bookissue->status == 0) { ?>
                                                            <a href="<?=base_url('bookissue/renewandreturn/'.$bookissue->bookissueID)?>" class="btn btn-info btn-xs mrg" data-placement="auto" data-toggle="tooltip" data-original-title="Perpanjang / Kembali"><i class="fa fa-retweet"></i></a>
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
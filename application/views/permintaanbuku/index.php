<div class="content-wrapper">
    <section class="content-header">
		<h1>Permintaan Buku</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class='aktif'>Permintaan Buku</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('requestbook_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('permintaan_buku/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Permintaan Buku</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sampul</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <?php if(permissionChecker('requestbook_edit') || permissionChecker('requestbook_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($requestbooks)) { $i=0; foreach($requestbooks as $permintaan_buku) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Sampul"><img src="<?=app_image_link($permintaan_buku->coverphoto,'uploads/buku/','permintaan_buku.jpg')?>" class="profile_img" alt=""></td>
                                    <td data-title="Judul Buku"><?=$permintaan_buku->nama?></td>
                                    <td data-title="Penulis"><?=$permintaan_buku->penulis?></td>
                                    <td data-title="Kategori"><?=isset($bookcategorys[$permintaan_buku->bookcategoryID]) ? $bookcategorys[$permintaan_buku->bookcategoryID] : ''?></td>
                                    <td data-title="Status">
                                        <span class="btn btn-danger btn-xs mrg">
                                        <?php 
                                            if($permintaan_buku->status ==0) {
                                                echo 'Bari Diminta';
                                            } elseif($permintaan_buku->status == 1) {
                                                echo 'Diterima';
                                            } elseif($permintaan_buku->status == 2) {
                                                echo 'Ditolak';
                                            }

                                            if($permintaan_buku->dihapus_pada) {
                                                echo " - ".'Dihapus';
                                            }
                                        ?>
                                        </span>
                                    </td>
                                    <?php if(permissionChecker('requestbook_edit') || permissionChecker('requestbook_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('permintaan_buku/view/'.$permintaan_buku->requestbookID, 'Lihat'); ?>
                                            <?php if(($permintaan_buku->status==0) && ($permintaan_buku->dihapus_pada==0)) {
                                                echo btn_edit('permintaan_buku/edit/'.$permintaan_buku->requestbookID, 'Edit')." "; 
                                                echo btn_delete('permintaan_buku/delete/'.$permintaan_buku->requestbookID, 'Delete'); 
                                            } ?>
                                            <?php if(permissionChecker('book_add') && ($permintaan_buku->status==0) && ($permintaan_buku->dihapus_pada==0)) { ?>
                                                <a href="<?=base_url('permintaan_buku/bookadd/'.$permintaan_buku->requestbookID)?>" class="btn btn-mytheme btn-xs mrg" data-placement="auto" data-toggle="tooltip" data-original-title="Tambahkan"><i class="fa fa-external-link"></i></a>
                                            <?php } 
                                            if(($permintaan_buku->status == 0) && ($permintaan_buku->dihapus_pada==0)) { ?>
                                                <a href="<?=base_url('permintaan_buku/rejected/'.$permintaan_buku->requestbookID)?>" class="btn btn-info btn-xs mrg" data-placement="auto" data-toggle="tooltip" data-original-title="Tolak"><i class="fa fa-ban"></i></a>
                                            <?php } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Sampul</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <?php if(permissionChecker('requestbook_edit') || permissionChecker('requestbook_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
          </div>
    </section>
</div>

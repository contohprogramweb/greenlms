<div class="content-wrapper">
    <section class="content-header">
		<h1>Permintaan Buku</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class="active">Permintaan Buku</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('requestbook_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('requestbook/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Permintaan Buku</a>
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
                            <?php if(calculate($requestbooks)) { $i=0; foreach($requestbooks as $requestbook) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Sampul"><img src="<?=app_image_link($requestbook->coverphoto,'uploads/book/','requestbook.jpg')?>" class="profile_img" alt=""></td>
                                    <td data-title="Judul Buku"><?=$requestbook->name?></td>
                                    <td data-title="Penulis"><?=$requestbook->author?></td>
                                    <td data-title="Kategori"><?=isset($bookcategorys[$requestbook->bookcategoryID]) ? $bookcategorys[$requestbook->bookcategoryID] : ''?></td>
                                    <td data-title="Status">
                                        <span class="btn btn-danger btn-xs mrg">
                                        <?php 
                                            if($requestbook->status ==0) {
                                                echo 'Bari Diminta';
                                            } elseif($requestbook->status == 1) {
                                                echo 'Diterima';
                                            } elseif($requestbook->status == 2) {
                                                echo 'Ditolak';
                                            }

                                            if($requestbook->deleted_at) {
                                                echo " - ".'Dihapus';
                                            }
                                        ?>
                                        </span>
                                    </td>
                                    <?php if(permissionChecker('requestbook_edit') || permissionChecker('requestbook_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('requestbook/view/'.$requestbook->requestbookID, 'Lihat'); ?>
                                            <?php if(($requestbook->status==0) && ($requestbook->deleted_at==0)) {
                                                echo btn_edit('requestbook/edit/'.$requestbook->requestbookID, 'Edit')." "; 
                                                echo btn_delete('requestbook/delete/'.$requestbook->requestbookID, 'Delete'); 
                                            } ?>
                                            <?php if(permissionChecker('book_add') && ($requestbook->status==0) && ($requestbook->deleted_at==0)) { ?>
                                                <a href="<?=base_url('requestbook/bookadd/'.$requestbook->requestbookID)?>" class="btn btn-mytheme btn-xs mrg" data-placement="auto" data-toggle="tooltip" data-original-title="Tambahkan"><i class="fa fa-external-link"></i></a>
                                            <?php } 
                                            if(($requestbook->status == 0) && ($requestbook->deleted_at==0)) { ?>
                                                <a href="<?=base_url('requestbook/rejected/'.$requestbook->requestbookID)?>" class="btn btn-info btn-xs mrg" data-placement="auto" data-toggle="tooltip" data-original-title="Tolak"><i class="fa fa-ban"></i></a>
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

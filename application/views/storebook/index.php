<div class="content-wrapper">
    <section class="content-header">
		<h1>Buku Toko</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class="active">Buku Toko</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('storebook_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('storebook/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Buku</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto Sampul</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Quantity</th>
                                <th>Nomor Kode</th>
                                <?php if(permissionChecker('storebook_edit') || permissionChecker('storebook_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($storebooks)) { $i=0; foreach($storebooks as $storebook) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Foto Sampul"><img src="<?=app_image_link($storebook->coverphoto,'uploads/storebook/','storebook.jpg')?>" class="profile_img" alt=""></td>
                                    <td data-title="Judul Buku"><?=$storebook->name?></td>
                                    <td data-title="Penulis"><?=$storebook->author?></td>
                                    <td data-title="Quantity"><?=$storebook->quantity?></td>
                                    <td data-title="Nomor Kode"><?=$storebook->codeno?></td>
                                    <?php if(permissionChecker('storebook_edit') || permissionChecker('storebook_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('storebook/view/'.$storebook->storebookID,'Lihat'); ?>
                                            <?php if($storebook->deleted_at == 0) {
                                                echo btn_edit('storebook/edit/'.$storebook->storebookID,'Edit'). " ";
                                                echo btn_delete('storebook/delete/'.$storebook->storebookID,'Delete');
                                            } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Foto Sampul</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Quantity</th>
                                <th>Nomor Kode</th>
                                <?php if(permissionChecker('storebook_edit') || permissionChecker('storebook_delete')) { ?>    
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
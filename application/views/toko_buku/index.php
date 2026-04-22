<div class="content-wrapper">
    <section class="content-header">
		<h1>Buku Toko</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class='aktif'>Buku Toko</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('storebook_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('buku_toko/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Buku</a>
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
                            <?php if(calculate($storebooks)) { $i=0; foreach($storebooks as $buku_toko) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Foto Sampul"><img src="<?=app_image_link($buku_toko->coverphoto,'uploads/buku_toko/','buku_toko.jpg')?>" class="profile_img" alt=""></td>
                                    <td data-title="Judul Buku"><?=$buku_toko->nama?></td>
                                    <td data-title="Penulis"><?=$buku_toko->penulis?></td>
                                    <td data-title="Quantity"><?=$buku_toko->jumlah?></td>
                                    <td data-title="Nomor Kode"><?=$buku_toko->codeno?></td>
                                    <?php if(permissionChecker('storebook_edit') || permissionChecker('storebook_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('buku_toko/view/'.$buku_toko->storebookID,'Lihat'); ?>
                                            <?php if($buku_toko->dihapus_pada == 0) {
                                                echo btn_edit('buku_toko/edit/'.$buku_toko->storebookID,'Edit'). " ";
                                                echo btn_delete('buku_toko/delete/'.$buku_toko->storebookID,'Delete');
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
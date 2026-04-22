<div class="content-wrapper">
    <section class="content-header">
		<h1>Buku</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class='aktif'>Buku</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('book_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('buku/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Buku</a>
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
                                <th>Kode Buku</th>
                                <?php if(permissionChecker('book_edit') || permissionChecker('book_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($books)) { $i=0; foreach($books as $buku) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Foto Sampul"><img src="<?=app_image_link($buku->coverphoto,'uploads/buku/','buku.jpg')?>" class="profile_img" alt=""></td>
                                    <td data-title="Judul Buku"><?=$buku->nama?></td>
                                    <td data-title="Penulis"><?=$buku->penulis?></td>
                                    <td data-title="Quantity"><?=$buku->jumlah?></td>
                                    <td data-title="Kode Buku"><?=$buku->codeno?></td>
                                    <?php if(permissionChecker('book_edit') || permissionChecker('book_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('buku/view/'.$buku->id_buku,'Lihat'); ?>
                                            <?php if($buku->dihapus_pada == 0) {
                                                echo btn_edit('buku/edit/'.$buku->id_buku,'Edit'). " ";
                                                echo btn_delete('buku/delete/'.$buku->id_buku,'Delete');
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
                                <th>Kode Buku</th>
                                <?php if(permissionChecker('book_edit') || permissionChecker('book_delete')) { ?>    
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
<div class="content-wrapper">
    <section class="content-header">
		<h1>Kategori (Toko)</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class='aktif'>Kategori (Toko)</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('storebookcategory_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('kategori_buku_toko/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i>Tambah Kategori</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sampul</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <?php if(permissionChecker('storebookcategory_edit') || permissionChecker('storebookcategory_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($kategori_buku_toko)) { $i=0; foreach($kategori_buku_toko as $category) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Sampul"><img src="<?=app_image_link($category->coverphoto,'uploads/kategori_buku_toko/','kategori_buku_toko.jpg')?>" class="profile_img" alt=""></td>
                                    <td data-title="Nama Kategori"><?=$category->nama?></td>
                                    <td data-title="Deskripsi"><?=namesorting($category->deskripsi, 50)?></td>
                                    <td data-title="Status"><?=status_button($category->status)?></td>
                                    <?php if(permissionChecker('storebookcategory_edit') || permissionChecker('storebookcategory_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_edit('kategori_buku_toko/edit/'.$category->storebookcategoryID,'Edit'); ?>
                                            <?=btn_delete('kategori_buku_toko/delete/'.$category->storebookcategoryID,'Delete'); ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Sampul</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <?php if(permissionChecker('storebookcategory_edit') || permissionChecker('storebookcategory_delete')) { ?>    
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
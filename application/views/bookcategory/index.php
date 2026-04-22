<div class="content-wrapper">
    <section class="content-header">
		<h1>Kategori Buku</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class="active">Kategori Buku</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('bookcategory_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('bookcategory/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Kategori</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto Kategori</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <?php if(permissionChecker('bookcategory_edit') || permissionChecker('bookcategory_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($bookcategory)) { $i=0; foreach($bookcategory as $category) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Foto Kategori"><img src="<?=app_image_link($category->coverphoto,'uploads/bookcategory/','bookcategory.jpg')?>" class="profile_img" alt=""></td>
                                    <td data-title="Nama Kategori"><?=$category->name?></td>
                                    <td data-title="Deskripsi"><?=namesorting($category->description, 50)?></td>
                                    <td data-title="Status"><?=status_button($category->status)?></td>
                                    <?php if(permissionChecker('bookcategory_edit') || permissionChecker('bookcategory_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_edit('bookcategory/edit/'.$category->bookcategoryID,'Edit'); ?>
                                            <?=btn_delete('bookcategory/delete/'.$category->bookcategoryID,'Delete'); ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Foto Kategori</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <?php if(permissionChecker('bookcategory_edit') || permissionChecker('bookcategory_delete')) { ?>    
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
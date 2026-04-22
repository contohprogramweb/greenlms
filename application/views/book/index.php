<div class="content-wrapper">
    <section class="content-header">
		<h1>Buku</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class="active">Buku</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('book_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('book/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Buku</a>
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
                            <?php if(calculate($books)) { $i=0; foreach($books as $book) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Foto Sampul"><img src="<?=app_image_link($book->coverphoto,'uploads/book/','book.jpg')?>" class="profile_img" alt=""></td>
                                    <td data-title="Judul Buku"><?=$book->name?></td>
                                    <td data-title="Penulis"><?=$book->author?></td>
                                    <td data-title="Quantity"><?=$book->quantity?></td>
                                    <td data-title="Kode Buku"><?=$book->codeno?></td>
                                    <?php if(permissionChecker('book_edit') || permissionChecker('book_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('book/view/'.$book->bookID,'Lihat'); ?>
                                            <?php if($book->deleted_at == 0) {
                                                echo btn_edit('book/edit/'.$book->bookID,'Edit'). " ";
                                                echo btn_delete('book/delete/'.$book->bookID,'Delete');
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
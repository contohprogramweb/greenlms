<section class="main-books">
    <div class="container">
        <div class="card book-header mt-4">
            <div class="card-body">
                <form method="POST" action="<?=base_url('frontend/book')?>">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group <?=form_error('bookcategoryID') ? 'has-error' : ''?>">
                                <label>Kategori Buku</label>
                                <?php 
                                    $bookcategoryArray[0]   = 'Silakan Pilih';
                                    if(calculate($bookcategorys)) {
                                        foreach($bookcategorys as $bookcategory) {
                                            $bookcategoryArray[$bookcategory->bookcategoryID] = $bookcategory->name;
                                        }
                                    }
                                    echo form_dropdown('bookcategoryID', $bookcategoryArray, set_value('bookcategoryID'),'id="bookcategoryID" class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-3" style="display:none;">
                            <div class="form-group <?=form_error('bookID') ? 'has-error' : ''?>">
                                <label>Buku</label>
                                <?php 
                                    $bookArray[0]   = 'Silakan Pilih';
                                    echo form_dropdown('bookID', $bookArray, set_value('bookID'),'id="bookID" class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
                                <label>Status</label>
                                <?php 
                                    $statusArray[0]   = 'Silakan Pilih';
                                    $statusArray[1]   = 'Tersedia';
                                    $statusArray[2]   = 'Tidak Tersedia';
                                    echo form_dropdown('status', $statusArray, set_value('status'),'id="status" class="form-control"');
                                ?>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <button class="btn btn-success" style="margin-top: 30px">Dapatkan Buku</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php if($flag) { ?>
            <div class="card my-4 divhide">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php if(calculate($books)) { ?>
                                <table class="table table-hover table-striped table-bordered booktabble mb-0">
                                    <thead>
                                        <tr class="info">
                                            <th>#</th>
                                            <th>Foto Sampul</th>
                                            <th>Judul</th>
                                            <th>Penulis</th>
                                            <th>Kode Buku</th>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach($books as $book) { $i++;?>
                                        <tr>
                                            <td align="center"><?=$i?></td>
                                            <td align="center"><img src="<?=app_image_link($book->coverphoto, 'uploads/book/', 'book.jpg')?>" class="profile_img"></td>
                                            <td><?=$book->name?></td>
                                            <td><?=$book->author?></td>
                                            <td align="center"><?=$book->codeno?></td>
                                            <td><?=isset($bookcategorys[$book->bookcategoryID]) ? $bookcategorys[$book->bookcategoryID]->name : ''?></td>
                                            <td align="center"><?=($book->status == 0) ? 'Tersedia' : 'Tidak Tersedia'?></td>
                                            <td align="center"><?=isset($bookQuantity[$book->bookID]) ? $bookQuantity[$book->bookID] : 0?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div class="not-found">
                                    Buku tidak ditemukan.
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
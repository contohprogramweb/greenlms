<section class="main-buku_elektronik mainebook">
	<div class="container">
        <div class="card buku_elektronik-header mb-4">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-sm-4 offset-md-3">
                            <div class="form-group">
                                <label>Kata Pencarian</label> <span class="text-danger">*</span>
                                <input type="text" placeholder="Ketik kata pencarian disini" name="search" class="form-control" value="<?=$search?>" />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <button class="btn btn-success" style="margin-top: 30px;">Cari Ebook</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<?php if(calculate($ebooks)) { ?>
            <div class="row">
                <?php foreach($ebooks as $buku_elektronik) { ?>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="single-buku_elektronik">
                            <div class="single-buku_elektronik-img">
                                <img src="<?=app_image_link($buku_elektronik->coverphoto, 'uploads/buku_elektronik/', 'buku_elektronik.jpg')?>" class="img-fluid" alt="">
                                <div class="single-overlay">
                                    <div class="icon-info">
                                        <h6><b>Judul :</b> <?=$buku_elektronik->nama?></h6>
                                        <h6><b>Penulis :</b> <?=$buku_elektronik->penulis?></h6>
                                        <p><?=namesorting($buku_elektronik->notes, 200)?></p>
                                    </div>
                                    <div class="icon-item">
                                        <ul>
                                            <li><a href="<?=base_url('Beranda/ebookview/'.$buku_elektronik->id_buku_elektronik)?>"><i class="fa fa-eye"></i></a></li>
                                            <?php if($pengaturan_umum->ebook_download == 1) { ?>
                                                <li><a href="<?=base_url('Beranda/ebookdownload/'.$buku_elektronik->id_buku_elektronik)?>"><i class="fa fa-download"></i></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="single-buku_elektronik-content">
                                <h6><b>Judul :</b> <?=$buku_elektronik->nama?></h6>
                                <h6><b>Penulis :</b> <?=$buku_elektronik->penulis?></h6>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?=$this->pagination->create_links();?>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="not-found">
                        <h2>Ebook tidak ditemukan.</h2>
                    </div>
                </div>
            </div>
        <?php } ?>
	</div>
</section>
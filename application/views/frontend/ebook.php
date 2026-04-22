<section class="main-ebook mainebook">
	<div class="container">
        <div class="card ebook-header mb-4">
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
                <?php foreach($ebooks as $ebook) { ?>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="single-ebook">
                            <div class="single-ebook-img">
                                <img src="<?=app_image_link($ebook->coverphoto, 'uploads/ebook/', 'ebook.jpg')?>" class="img-fluid" alt="">
                                <div class="single-overlay">
                                    <div class="icon-info">
                                        <h6><b>Judul :</b> <?=$ebook->name?></h6>
                                        <h6><b>Penulis :</b> <?=$ebook->author?></h6>
                                        <p><?=namesorting($ebook->notes, 200)?></p>
                                    </div>
                                    <div class="icon-item">
                                        <ul>
                                            <li><a href="<?=base_url('frontend/ebookview/'.$ebook->ebookID)?>"><i class="fa fa-eye"></i></a></li>
                                            <?php if($generalsetting->ebook_download == 1) { ?>
                                                <li><a href="<?=base_url('frontend/ebookdownload/'.$ebook->ebookID)?>"><i class="fa fa-download"></i></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="single-ebook-content">
                                <h6><b>Judul :</b> <?=$ebook->name?></h6>
                                <h6><b>Penulis :</b> <?=$ebook->author?></h6>
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
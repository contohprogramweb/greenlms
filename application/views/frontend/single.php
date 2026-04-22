<section class="buku-details">
    <div class="container">
        <?php if(calculate($buku_toko)) { ?>
            <div class="main-buku-content">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="tab-content">
                            <div id="thumb0" class="tab-pane fade active show">
                                <img class="buku-mainimage-item" src="<?=app_image_link($buku_toko->coverphoto, 'uploads/buku_toko/', 'buku_toko.jpg')?>" alt="product-view" />
                            </div>
                            <?php $i = 0; if(calculate($storebookimages)) { foreach($storebookimages as $gambar_buku_toko) { $i++; ?>
                                <div id="thumb<?=$i?>" class="tab-pane fade">
                                    <img class="buku-mainimage-item" src="<?=app_image_link($gambar_buku_toko->file_name, 'uploads/buku_toko/', 'buku_toko.jpg')?>" alt="product-view" />
                                </div>
                            <?php } } ?>
                        </div>
                        <div class="nav justify-content-center buku-thumbnail-items">
                            <a data-toggle="tab" href="#thumb0" class='aktif'><img class="buku-thumbnail-item" src="<?=app_image_link($buku_toko->coverphoto, 'uploads/buku_toko/', 'buku_toko.jpg')?>" alt="product-thumbnail" /></a>
                            <?php $i = 0; if(calculate($storebookimages)) { foreach($storebookimages as $gambar_buku_toko) { $i++; ?>
                                <a data-toggle="tab" href="#thumb<?=$i?>"><img class="buku-thumbnail-item" src="<?=app_image_link($gambar_buku_toko->file_name, 'uploads/buku_toko/', 'buku_toko.jpg')?>" alt="product-thumbnail" /></a>
                            <?php } } ?>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="product-thumbnail-description">
                            <h3 class="product-header"><?=$buku_toko->nama?></h3>
                            <hr>
                            <div class="product-price">
                                <span class='harga'>Rp <?=number_format($buku_toko->harga,0,",",".")?></span>
                            </div>
                            <p class="product-description-details">
                                <?=$buku_toko->notes?>
                            </p>
                            <div class="product-quantity">
                                <form action="<?=base_url('frontend/addcart/'.$buku_toko->storebookID)?>" method="POST">
                                    <div class="input-group mb-3">
                                      <input name="qty" type="number" min="1" value="1" class="form-control" placeholder="Qty"   />
                                      <div class="input-group-append">
                                        <button class="btn btn-success"><i class="fa fa-cart-plus"></i> Masukkan</button>
                                      </div>
                                    </div>
                                </form>
                            </div>
                            <div class="product-stock">
                                <!-- <span><i class="fa fa-check"></i> IN STOCK</span> -->
                            </div>
                            <div class="social-sharing">
                                <ul>
                                    <li>Share :</li>
                                    <li>
                                        <a href="http://www.facebook.com/sharer.php?href=<?=base_url('frontend/single/'.$buku_toko->storebookID)?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="http://twitter.com/share?url=<?=base_url('frontend/single/'.$buku_toko->storebookID)?>&text=<?=$buku_toko->nama?>&hashtags=greenlms" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-buku-details">
                        <ul class="nav buku-details-navs" peran="tablist">
                            <li><a data-toggle="tab" href="#description">Detail Produk</a></li>
                        </ul>
                        <div class="tab-content buku-details-content">
                            <div id='deskripsi' class="tab-pane fade show active">
                                <?=$buku_toko->deskripsi?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="not-found">
                        <h2>Buku dijual tidak ditemukan.</h2>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
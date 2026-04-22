<div class="content-wrapper">
    <section class="content-header">
        <h1>Ebook</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Ebook</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('ebook_add')) { ?>
                <div class="box-header">
                    <a href="<?=base_url('buku_elektronik/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i>Tambah Ebook</a>
                </div>
            <?php } ?>
            <div class="box-body">
                <div class="mainebook">
                    <?php if(calculate($ebooks)) { ?>
                        <div class="row">
                            <?php foreach($ebooks as $buku_elektronik) { ?>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="single-buku_elektronik">
                                        <div class="single-buku_elektronik-img">
                                            <img src="<?=base_url('uploads/buku_elektronik/'.$buku_elektronik->coverphoto)?>" class="img-fluid" alt="">
                                            <div class="single-overlay">
                                                <div class="icon-info">
                                                    <h6><b>Judul Ebook :</b> <?=$buku_elektronik->nama?></h6>
                                                    <h6><b>Penulis :</b> <?=$buku_elektronik->penulis?></h6>
                                                    <p><?=namesorting($buku_elektronik->notes, 200)?></p>
                                                </div>
                                                <div class="icon-item">
                                                    <ul>
                                                        <?php if(permissionChecker('ebook_edit')) { ?>
                                                            <li><a href="<?=base_url('buku_elektronik/edit/'.$buku_elektronik->id_buku_elektronik)?>"><i class="fa fa-edit"></i></a></li>
                                                        <?php } if(permissionChecker('ebook_view')) { ?>
                                                            <li><a href="<?=base_url('buku_elektronik/view/'.$buku_elektronik->id_buku_elektronik)?>"><i class="fa fa-eye"></i></a></li>
                                                        <?php } if(permissionChecker('ebook_delete')) { ?>
                                                            <li><a href="<?=base_url('buku_elektronik/delete/'.$buku_elektronik->id_buku_elektronik)?>"><i class="fa fa-trash"></i></a></li>
                                                        <?php } if(permissionChecker('ebook_view') && ($pengaturan_umum->ebook_download == 1)) { ?>
                                                            <li><a href="<?=base_url('buku_elektronik/download/'.$buku_elektronik->id_buku_elektronik)?>"><i class="fa fa-download"></i></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
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
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</div>
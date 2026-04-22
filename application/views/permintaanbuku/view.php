<div class="content-wrapper">
    <section class="content-header">
        <h1>Permintaan Buku</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('permintaan_buku/index')?>">Permintaan Buku</a></li>
            <li class='aktif'>Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <div class="row" style="padding-top: 0px;">
                    <div class="col-sm-12">
                        <div class="panel-body profile_view_des">
                            <div class="row">
                                <div class="profile_view_item">
                                    <p><b>Judul Buku</b>: <?=$permintaan_buku->nama?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Penulis</b>: <?=$permintaan_buku->penulis?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Kategori</b>: <?=calculate($kategori_buku) ? $kategori_buku->nama : ''?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>ISBN</b>: <?=$permintaan_buku->isbnno?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Edisi Ke</b>: <?=$permintaan_buku->editionnumber?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Tanggal Edisi</b>: <?=app_date($permintaan_buku->editiondate)?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Penerbit</b>: <?=$permintaan_buku->penerbit?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Tanggal Terbit</b>: <?=app_date($permintaan_buku->publisheddate)?></p>
                                </div>
                                <div class="profile_view_item" width="100%">
                                    <p><b>Catatan</b>: <?=$permintaan_buku->notes?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

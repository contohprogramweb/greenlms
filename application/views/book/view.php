<div class="content-wrapper">
    <section class="content-header">
        <h1>Buku</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('buku/index')?>">Buku</a></li>
            <li class='aktif'>Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile_view_item">
                            <p><b>Judul Buku</b>: <?=$buku->nama?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Penulis</b>: <?=$buku->penulis?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Quantity</b>: <?=$buku->jumlah?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Harga</b>: <?=$buku->harga?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Kode Buku</b>: <?=$buku->codeno?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Kategori</b>: <?=calculate($kategori_buku) ? $kategori_buku->nama : ''?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>ISBN</b>: <?=$buku->isbnno?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Rak</b>: <?=calculate($rak) ? $rak->nama : ''?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Edisi</b>: <?=$buku->editionnumber?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Tanggal Edisi</b>: <?=app_date($buku->editiondate)?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Penerbit</b>: <?=$buku->penerbit?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Tanggal Penerbit</b>: <?=app_date($buku->publisheddate)?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Catatan</b>: <?=$buku->notes?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
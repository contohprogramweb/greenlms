<div class="content-wrapper">
    <section class="content-header">
        <h1>Buku Toko</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('buku_toko/index')?>">Buku Toko</a></li>
            <li class='aktif'>Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile_view_item">
                            <p><b>Judul Buku</b>: <?=$buku_toko->nama?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Penulis</b>: <?=$buku_toko->penulis?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Quantity</b>: <?=$buku_toko->jumlah?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Harga</b>: <?=$buku_toko->harga?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Nomor Kode</b>: <?=$buku_toko->codeno?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Kategori</b>: <?=calculate($kategori_buku_toko) ? $kategori_buku_toko->nama : ''?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>ISBN</b>: <?=$buku_toko->isbnno?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Edisi Ke</b>: <?=$buku_toko->editionnumber?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Edisi Tanggal</b>: <?=app_date($buku_toko->editiondate)?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Penerbit</b>: <?=$buku_toko->penerbit?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Tanggal Terbit</b>: <?=app_date($buku_toko->publisheddate)?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Catatan</b>: <?=$buku_toko->notes?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
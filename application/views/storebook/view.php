<div class="content-wrapper">
    <section class="content-header">
        <h1>Buku Toko</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('storebook/index')?>">Buku Toko</a></li>
            <li class="active">Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile_view_item">
                            <p><b>Judul Buku</b>: <?=$storebook->name?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Penulis</b>: <?=$storebook->author?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Quantity</b>: <?=$storebook->quantity?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Harga</b>: <?=$storebook->price?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Nomor Kode</b>: <?=$storebook->codeno?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Kategori</b>: <?=calculate($storebookcategory) ? $storebookcategory->name : ''?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>ISBN</b>: <?=$storebook->isbnno?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Edisi Ke</b>: <?=$storebook->editionnumber?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Edisi Tanggal</b>: <?=app_date($storebook->editiondate)?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Penerbit</b>: <?=$storebook->publisher?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Tanggal Terbit</b>: <?=app_date($storebook->publisheddate)?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Catatan</b>: <?=$storebook->notes?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
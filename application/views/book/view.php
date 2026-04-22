<div class="content-wrapper">
    <section class="content-header">
        <h1>Buku</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('book/index')?>">Buku</a></li>
            <li class="active">Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile_view_item">
                            <p><b>Judul Buku</b>: <?=$book->name?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Penulis</b>: <?=$book->author?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Quantity</b>: <?=$book->quantity?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Harga</b>: <?=$book->price?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Kode Buku</b>: <?=$book->codeno?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Kategori</b>: <?=calculate($bookcategory) ? $bookcategory->name : ''?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>ISBN</b>: <?=$book->isbnno?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Rak</b>: <?=calculate($rack) ? $rack->name : ''?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Edisi</b>: <?=$book->editionnumber?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Tanggal Edisi</b>: <?=app_date($book->editiondate)?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Penerbit</b>: <?=$book->publisher?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Tanggal Penerbit</b>: <?=app_date($book->publisheddate)?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Catatan</b>: <?=$book->notes?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
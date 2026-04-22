<div class="content-wrapper">
    <section class="content-header">
        <h1>Permintaan Buku</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('requestbook/index')?>">Permintaan Buku</a></li>
            <li class="active">Lihat</li>
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
                                    <p><b>Judul Buku</b>: <?=$requestbook->name?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Penulis</b>: <?=$requestbook->author?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Kategori</b>: <?=calculate($bookcategory) ? $bookcategory->name : ''?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>ISBN</b>: <?=$requestbook->isbnno?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Edisi Ke</b>: <?=$requestbook->editionnumber?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Tanggal Edisi</b>: <?=app_date($requestbook->editiondate)?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Penerbit</b>: <?=$requestbook->publisher?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Tanggal Terbit</b>: <?=app_date($requestbook->publisheddate)?></p>
                                </div>
                                <div class="profile_view_item" width="100%">
                                    <p><b>Catatan</b>: <?=$requestbook->notes?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

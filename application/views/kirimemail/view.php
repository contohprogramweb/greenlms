<div class="content-wrapper">
    <section class="content-header">
        <h1>Kirim Email</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('kirim_email/index')?>">Kirim Email</a></li>
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
                                    <p><b>Judul Email</b>: <?=$kirim_email->subjek?></p>
                                </div>
                                <?php if(isset($emailtemplates[$kirim_email->emailtemplateID])) { ?>
                                    <div class="profile_view_item">
                                        <p><b>Template Email</b>: <?=$emailtemplates[$kirim_email->emailtemplateID]?></p>
                                    </div>
                                <?php } ?>
                                <div class="profile_view_item">
                                    <p><b>Pesan</b>: <?=$kirim_email->pesan?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Nama Pengirim</b>: <?=$kirim_email->sender_name?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Terkirim</b>: <?=$kirim_email->surel?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Tanggal Buat</b>: <?=app_date($kirim_email->tanggal_dibuat)?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

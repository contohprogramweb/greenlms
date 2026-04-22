<div class="content-wrapper">
    <section class="content-header">
        <h1>Kirim Email</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('emailsend/index')?>">Kirim Email</a></li>
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
                                    <p><b>Judul Email</b>: <?=$emailsend->subject?></p>
                                </div>
                                <?php if(isset($emailtemplates[$emailsend->emailtemplateID])) { ?>
                                    <div class="profile_view_item">
                                        <p><b>Template Email</b>: <?=$emailtemplates[$emailsend->emailtemplateID]?></p>
                                    </div>
                                <?php } ?>
                                <div class="profile_view_item">
                                    <p><b>Pesan</b>: <?=$emailsend->message?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Nama Pengirim</b>: <?=$emailsend->sender_name?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Terkirim</b>: <?=$emailsend->email?></p>
                                </div>
                                <div class="profile_view_item">
                                    <p><b>Tanggal Buat</b>: <?=app_date($emailsend->create_date)?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

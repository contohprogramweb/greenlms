<div class="content-wrapper">
    <section class="content-header">
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Dashboard</li>
        </ol>
    </section>
    <section class="content">

        <div class="box box-mytheme">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-body" style="width: 100%">
                        <canvas id="canvas" width="600" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="box box-mytheme">
                    <div class="box-header">
                        <i class="fa fa-comments-o"></i>
                        <h3 class="box-title">Chat</h3>
                    </div>
                    <div class="box-body obrolan mainchatbox" id="obrolan-box">
                        <div class="text-center">
                            <button class="btn btn-xs btn-mytheme loadmore"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Muat lagi</button>
                        </div>
                        <div class="chatboxmessage">
                          <!-- obrolan item -->
                          <?php if(calculate($chats)) { foreach($chats as $obrolan) { ?>
                            <div class="item chatID" data-chatid="<?=$obrolan->id_obrolan?>">
                                <?php $memberimage = isset($members[$obrolan->create_memberID]) ? $members[$obrolan->create_memberID]->foto : '';?>
                                <img src="<?=profile_img($memberimage)?>" alt="anggota image" class="offline">
                                <p class='pesan'>
                                    <a href="#" class='nama'>
                                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?=date('d M Y H:i', strtotime($obrolan->tanggal_dibuat))?></small>
                                        <?=isset($members[$obrolan->create_memberID]) ? $members[$obrolan->create_memberID]->nama : ''?>
                                    </a>
                                    <?=$obrolan->pesan?>
                                </p>
                            </div>
                            <?php } } ?>
                            <!-- obrolan item -->
                        </div>
                    </div>
                    <!-- /.obrolan -->
                    <div class="box-footer">
                        <div class="input-group">
                            <input class="form-control" type="text" id="chatmessage" name="chatmessage" placeholder="Ketik Pesan">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-mytheme" id="chatmessagesend"><i class="fa fa-send"></i></button>
                                <button type="button" class="btn btn-danger" id="chatmessagerefresh"><i class="fa fa-refresh fa-spin"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box box-mytheme">
                    <form action="<?=base_url('dashboard/quickmail')?>" method="post">
                        <div class="box-header">
                            <i class="fa fa-envelope"></i>
                            <h3 class="box-title">Email Cepat</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <input type='surel' class="form-control" name='surel' placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name='subjek' placeholder="Judul Email">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name='pesan' id='pesan' cols="30" rows="10" placeholder="Pesan"></textarea>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <button type="submit" class="pull-right btn btn-default" id="sendEmail"> Kirim <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    var dashboard_provide_message = "Sediakan Pesan";
    var dashboard_income          = [<?=$pemasukan?>];
    var dashboard_expense         = [<?=$pengeluaran?>];
</script>
<div class="content-wrapper">
    <section class="content-header">
  		<h1>Kirim Email</h1>
  		<ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('kirim_email/index')?>"> Kirim Email</a></li>
  			<li class='aktif'>Kirim</li>
  		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="<?=($active_tab==1) ? 'aktif' : ''?>"><a href="#email" data-toggle="tab" aria-expanded="false">Terkirim</a></li>
                    <li class="<?=($active_tab==2) ? 'aktif' : ''?>"><a href="#otheremail" data-toggle="tab" aria-expanded="false">Lainnya</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane <?=($active_tab==1) ? 'aktif' : ''?>" id='surel'>
                        <div class="row"> 
                            <div class="col-md-6">
                                <form peran="form" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="emailtype" value="1">
                                    <div class="box-body">
                                        <div class="form-group <?=form_error('subjek') ? 'has-error' : ''?>">
                                            <label for='subjek'>Judul Email</label> <span class="text-red">*</span>
                                            <input type="text" class="form-control" value="<?=set_value('subjek')?>" id='subjek' name='subjek'/>
                                            <?=form_error('subjek')?>
                                        </div>
                                        <div class="form-group <?=form_error('sender_roleID') ? 'has-error' : ''?>">
                                            <label for="sender_roleID">Hak Akses Pengirim</label> <span class="text-red">*</span>
                                            <?php 
                                                $sender_roleArray['0'] = 'Silakan Pilih';
                                                if(calculate($roles)) {
                                                    foreach($roles as $peran) {
                                                        $sender_roleArray[$peran->id_peran] = $peran->peran;
                                                    }
                                                }
                                                echo form_dropdown('sender_roleID', $sender_roleArray, set_value('sender_roleID') , 'class="form-control" id="sender_roleID"'); 
                                            ?>
                                            <?=form_error('sender_roleID')?>
                                        </div>
                                        <div class="form-group <?=form_error('sender_memberID') ? 'has-error' : ''?>">
                                            <label for="sender_memberID">Nama Pengirim</label>
                                            <?php 
                                                $sender_memberArray['0'] = 'Semua Anggota'; 
                                                echo form_multiselect('sender_memberID[]', $sender_memberArray, set_value('sender_memberID[]') , 'class="form-control select2" id="sender_memberID"'); 
                                            ?>
                                            <?=form_error('sender_memberID')?>
                                        </div>
                                        <div class="form-group <?=form_error('emailtemplateID') ? 'has-error' : ''?>">
                                            <label for="emailtemplateID">Template Email</label>
                                            <?php 
                                                $emailtemplateArray['0'] = 'Silakan Pilih';
                                                if(calculate($emailtemplates)) {
                                                    foreach ($emailtemplates as $templat_surel) {
                                                        $emailtemplateArray[$templat_surel->emailtemplateID] = $templat_surel->nama;
                                                    }
                                                }
                                                echo form_dropdown('emailtemplateID', $emailtemplateArray, set_value('emailtemplateID') , 'class="form-control" id="emailtemplateID"'); 
                                            ?>
                                            <?=form_error('emailtemplateID')?>
                                        </div>
                                        <div class="form-group <?=form_error('pesan') ? 'has-error' : ''?>">
                                            <label for='pesan'>Pesan</label> <span class="text-red">*</span>
                                            <textarea name='pesan' id='pesan' cols="30" rows="10" class="form-control"><?=set_value('pesan')?></textarea>
                                            <?=form_error('pesan')?>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-mytheme">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane <?=($active_tab==2) ? 'aktif' : ''?>" id="otheremail">
                        <div class="row"> 
                            <div class="col-md-6">
                                <form peran="form" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="emailtype" value="2">
                                    <div class="box-body">
                                        <div class="form-group <?=form_error('othersubject') ? 'has-error' : ''?>">
                                            <label for="othersubject">Judul lain</label> <span class="text-red">*</span>
                                            <input type="text" class="form-control" value="<?=set_value('othersubject')?>" id="othersubject" name="othersubject"/>
                                            <?=form_error('othersubject')?>
                                        </div>
                                        <div class="form-group <?=form_error('nama') ? 'has-error' : ''?>">
                                            <label for='nama'>Nama</label> <span class="text-red">*</span>
                                            <input type="text" class="form-control" value="<?=set_value('nama')?>" id='nama' name='nama'/>
                                            <?=form_error('nama')?>
                                        </div>
                                        <div class="form-group <?=form_error('surel') ? 'has-error' : ''?>">
                                            <label for='surel'>Terkirim</label> <span class="text-red">*</span>
                                            <input type="text" class="form-control" value="<?=set_value('surel')?>" id='surel' name='surel'/>
                                            <?=form_error('surel')?>
                                        </div>
                                        <div class="form-group">
                                            <label for="othermessage">Isi pesan</label> <span class="text-red">*</span>
                                            <textarea name="othermessage" id="othermessage" cols="30" rows="5" class="form-control"><?=set_value('othermessage')?></textarea>
                                            <span class="<?=form_error('othermessage') ? 'has-error' : ''?>"><?=form_error('othermessage')?></span>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-mytheme">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    var set_sender_roleID = "<?=set_value('sender_roleID')?>";
</script>
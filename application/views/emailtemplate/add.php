<div class="content-wrapper">
    <section class="content-header">
  		<h1>Template Email</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('templat_surel/index')?>">Template Email</a></li>
            <li class='aktif'>Tambah</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="row">
                <div class="col-md-6">
                    <form peran="form" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group <?=form_error('nama') ? 'has-error' : ''?>">
                                <label for='nama'>Nama</label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="<?=set_value('nama')?>" id='nama' name='nama'/>
                                <?=form_error('nama')?>
                            </div>
                            <div class="form-group">
                                <label for='nama'>Atribut</label><br/>
                                <div class="btn-group">
                                    <span class="btn btn-default single_email_tag" data-emailtag="[memberID]">Nomor Anggota</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[name]">Nama</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[dateofbirth]">Tanggal Lahir</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[gender]">Jenis Kelamin</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[religion]">Agama</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[email]">Email</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[phone]">Nomor Telp.</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[address]">Alamat</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[joinningdate]">Tanggal Gabung</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[photo]">Foto</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[username]">Username</span>
                                    <span class="btn btn-default single_email_tag" data-emailtag="[current_date]">Tanggal Sekarang</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for='templat'>Template Email</label> <span class="text-red">*</span>
                                <textarea name='templat' id='templat' cols="30" class="form-control"><?=set_value('templat')?></textarea>
                                <?=form_error('templat','<p class="text-red">','</p>')?>
                            </div>
                            <div class="form-group <?=form_error('nama') ? 'has-error' : ''?>">
                                <label for='status'>Status</label> <span class="text-red">*</span>
                                <?php 
                                    $statusArray['0'] = 'Silakan Pilih'; 
                                    $statusArray['1'] = 'Aktif';
                                    $statusArray['2'] = 'Disabled';
                                    echo form_dropdown('status', $statusArray, set_value('status') , 'class="form-control"'); 
                                ?>
                                <?=form_error('status')?>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-mytheme">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
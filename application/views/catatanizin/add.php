<div class="content-wrapper">
    <section class="content-header">
  		<h1>Log Izin</h1>
  		<ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('catatan_izin/index')?>">Log Izin</a></li>
  			<li class='aktif'>Tambah</li>
  		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="row">
                <div class="col-md-6">
                    <form peran="form" method="POST">
                        <div class="box-body">
                            <div class="form-group <?=form_error('nama') ? 'has-error' : ''?>">
                                <label for='nama'>Nama Log</label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="<?=set_value('nama')?>" id='nama' name='nama'/>
                                <?=form_error('nama')?>
                            </div>
                            <div class="form-group <?=form_error('deskripsi') ? 'has-error' : ''?>">
                                <label for='deskripsi'>Deskripsi</label> <span class="text-red">*</span>
                                <textarea name='deskripsi' id='deskripsi' cols="30" rows="3" class="form-control"><?=set_value('deskripsi')?></textarea>
                                <?=form_error('deskripsi')?>
                            </div>
                            <div class="form-group <?=form_error('aktif') ? 'has-error' : ''?>">
                                <label for='aktif'>Aksi</label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="<?=set_value('aktif','yes')?>" id='aktif' name='aktif' />
                                <?=form_error('aktif')?>
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

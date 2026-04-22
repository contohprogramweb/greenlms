<div class="content-wrapper">
    <section class="content-header">
  		<h1>Hak Akses</h1>
  		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('role')?>">Hak Akses</a></li>
  			<li class="active">Tambah</li>
  		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="row">
                <div class="col-md-6">
                    <form role="form" method="POST">
                        <div class="box-body">
                            <div class="form-group <?=form_error('role') ? 'has-error' : ''?>">
                                <label for="role">Hak Akses</label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="<?=set_value('role')?>" id="role" name="role"/>
                                <?=form_error('role')?>
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

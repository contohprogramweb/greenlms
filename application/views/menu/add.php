<div class="content-wrapper">
    <section class="content-header">
  		<h1>Menu</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('menu/index')?>">Menu</a></li>
            <li class='aktif'>Tambah</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="row">
                <div class="col-md-6">
                    <form peran="form" method="POST">
                        <div class="box-body">
                            <div class="form-group <?=form_error('menuname') ? 'has-error' : ''?>">
                              <label for="menuname">Nama Menu</label> <span class="text-red">*</span>
                              <input type="text" class="form-control" value="<?=set_value('menuname')?>" id="menuname" name="menuname"/>
                              <?=form_error('menuname')?>
                            </div>
                            <div class="form-group <?=form_error('menulink') ? 'has-error' : ''?>">
                              <label for="menulink">Link</label> <span class="text-red">*</span>
                              <input type="text" class="form-control" value="<?=set_value('menulink')?>" id="menulink" name="menulink"/>
                              <?=form_error('menulink')?>
                            </div>
                            <div class="form-group <?=form_error('menuicon') ? 'has-error' : ''?>">
                              <label for="menuicon">Icon</label> <span class="text-red">*</span>
                              <input type="text" class="form-control" value="<?=set_value('menuicon','fa fa-leaf')?>" id="menuicon" name="menuicon"/>
                              <?=form_error('menuicon')?>
                            </div>
                            <div class="form-group <?=form_error('prioritas') ? 'has-error' : ''?>">
                              <label for='prioritas'>Prioritas</label> <span class="text-red">*</span>
                              <input type="text" class="form-control" value="<?=set_value('prioritas','0')?>" id='prioritas' name='prioritas'/>
                              <?=form_error('prioritas')?>
                            </div>
                            <div class="form-group <?=form_error('parentmenuID') ? 'has-error' : ''?>">
                              <label for="parentmenuID">Parent Menu</label> <span class="text-red">*</span>
                              <?php
                                $parentmenuArray['0'] = 'Silakan Pilih';
                                if(calculate($parentmenus)) {
                                  foreach($parentmenus as $parentmenu) {
                                    $parentmenuArray[$parentmenu->id_menu] = $parentmenu->menuname;
                                  }
                                }
                                echo form_dropdown('parentmenuID', $parentmenuArray, set_value('status') , 'class="form-control"');
                                form_error('parentmenuID');
                              ?>
                            </div>
                            <div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
                              <label for='status'>Status</label> <span class="text-red">*</span>
                              <?php 
                                $statusArray['0'] = 'Silakan Pilih'; 
                                $statusArray['1'] = 'Aktif'; 
                                $statusArray['2'] = 'Disabled'; 
                                echo form_dropdown('status', $statusArray, set_value('status') , 'class="form-control"'); ?>
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

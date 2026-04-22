<div class="content-wrapper">
    <section class="content-header">
  		<h1>Kategori Buku</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('kategori_buku/index')?>">Kategori Buku</a></li>
  			<li class='aktif'>Tambah</li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="row">
				<div class="col-md-6">
					<form peran="form" method="post" enctype="multipart/form-data">
						<div class="box-body">
							<div class="form-group <?=form_error('nama') ? 'has-error' : ''?>">
							 	<label for='nama'>Nama Kategori</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='nama' name='nama' value="<?=set_value('nama')?>" placeholder="Enter name">
							  	<?=form_error('nama')?>
							</div>
							<div class="form-group <?=form_error('deskripsi') ? 'has-error' : ''?>">
							  	<label for='deskripsi'>Deskripsi</label> <span class="text-red">*</span>
							  	<textarea name='deskripsi' value="<?=set_value('deskripsi')?>" id="" cols="30" rows="5" class="form-control" placeholder="Enter description"><?=set_value('deskripsi')?></textarea>
							  	<?=form_error('deskripsi')?>
							</div>
							<div class="form-group <?=form_error('coverphoto') ? 'has-error' : ''?>">
						        <label for="coverphoto">Foto Kategori</label>
						        <div class="input-group image-preview">
						            <input type="text" class="form-control image-preview-filename" disabled="disabled">
						            <span class="input-group-btn">
						                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
						                    <span class="fa fa-remove"></span>Clear
						                </button>
						                <div class="btn btn-success image-preview-input">
						                    <span class="fa fa-repeat"></span>
						                    <span class="image-preview-input-title">Browse</span>
						                    <input type='file' accept="image/png, image/jpeg, image/gif" name="coverphoto"/>
						                </div>
						            </span>
						        </div>
						      	<?=form_error('coverphoto');?>
						    </div>
							<div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
							  	<label for='status'>Status</label> <span class="text-red">*</span>
							  	<?php 
									$statusArray[0] = 'Silakan Pilih';
									$statusArray[1] = 'Difungsikan';
									$statusArray[2] = 'Tidak Difungsikan';

									echo form_dropdown('status', $statusArray, set_value('status'),'id='status' class="form-control"');
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
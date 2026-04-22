<div class="content-wrapper">
    <section class="content-header">
  		<h1>Kategori Buku</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('bookcategory/index')?>">Kategori Buku</a></li>
  			<li class="active">Edit</li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" enctype="multipart/form-data">
						<div class="box-body">
							<div class="form-group <?=form_error('name') ? 'has-error' : ''?>">
							 	<label for="name">Nama Kategori</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="name" name="name" value="<?=set_value('name', $bookcategory->name)?>" placeholder="Enter name">
							  	<?=form_error('name')?>
							</div>
							<div class="form-group <?=form_error('description') ? 'has-error' : ''?>">
							  	<label for="description">Deskripsi</label> <span class="text-red">*</span>
							  	<textarea name="description" id="description" cols="30" rows="5" class="form-control" placeholder="Enter description"><?=set_value('description', $bookcategory->description)?></textarea>
							  	<?=form_error('description')?>
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
						                    <input type="file" accept="image/png, image/jpeg, image/gif" name="coverphoto"/>
						                </div>
						            </span>
						        </div>
						        <div class="input-group">
						        	<img class="userprofileimg" src="<?=app_image_link($bookcategory->coverphoto,'uploads/bookcategory/','bookcategory.jpg')?>" alt="">
						        </div>
						      	<?=form_error('coverphoto');?>
						    </div>
							<div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
							  	<label for="status">Status</label> <span class="text-red">*</span>
							  	<?php 
									$statusArray[0] = 'Silakan Pilih';
									$statusArray[1] = 'Difungsikan';
									$statusArray[2] = 'Tidak Difungsikan';

									echo form_dropdown('status', $statusArray, set_value('status', $bookcategory->status),'id="status" class="form-control"');
								?>
							  	<?=form_error('status')?>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-mytheme">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </section>
</div>
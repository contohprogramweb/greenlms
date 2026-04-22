<div class="content-wrapper">
    <section class="content-header">
  		<h1>Ebook</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('ebook/index')?>">Ebook</a></li>
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
							 	<label for="name">Judul Ebook</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="name" name="name" value="<?=set_value('name', $ebook->name)?>" placeholder="Enter Name">
							  	<?=form_error('name')?>
							</div>
							<div class="form-group <?=form_error('author') ? 'has-error' : ''?>">
							 	<label for="author">Penulis</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="author" name="author" value="<?=set_value('author', $ebook->author)?>" placeholder="Enter Author">
							  	<?=form_error('author')?>
							</div>
							<div class="form-group <?=form_error('coverphoto') ? 'has-error' : ''?>">
						        <label for="coverphoto">Sampul</label> <span class="text-red">*</span>
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
						      	<?=form_error('coverphoto');?>
						    </div>
							<div class="form-group <?=form_error('file') ? 'has-error' : ''?>">
							  	<label for="file">File</label> <span class="text-red">*</span>
							    <input type="file" class="form-control" name="file" accept="application/pdf"/>
							  	<?=form_error('file')?>
							</div>
							<div class="form-group <?=form_error('notes') ? 'has-error' : ''?>">
							  	<label for="notes">Catatan</label>
							  	<textarea name="notes" cols="30" rows="5" class="form-control" placeholder="Enter notes"><?=set_value('notes', $ebook->notes)?></textarea>
							  	<?=form_error('notes')?>
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
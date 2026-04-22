<div class="content-wrapper">
    <section class="content-header">
  		<h1>Buku Toko</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('storebook/index')?>">Buku Toko</a></li>
  			<li class="active">Tambah</li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" enctype="multipart/form-data">
						<div class="box-body">
							<div class="form-group <?=form_error('name') ? 'has-error' : ''?>">
							 	<label for="name">Judul Buku</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="name" name="name" value="<?=set_value('name')?>" placeholder="Enter name">
							  	<?=form_error('name')?>
							</div>

							<div class="form-group <?=form_error('author') ? 'has-error' : ''?>">
							 	<label for="author">Penulis</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="author" name="author" value="<?=set_value('author')?>" placeholder="Enter Author">
							  	<?=form_error('author')?>
							</div>

							<div class="form-group <?=form_error('quantity') ? 'has-error' : ''?>">
							 	<label for="quantity">Quantity</label> <span class="text-red">*</span>
							  	<input type="number" class="form-control" id="quantity" name="quantity" value="<?=set_value('quantity')?>" placeholder="Enter Quantity">
							  	<?=form_error('quantity')?>
							</div>

							<div class="form-group <?=form_error('price') ? 'has-error' : ''?>">
							 	<label for="price">Harga</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="price" name="price" value="<?=set_value('price')?>" placeholder="Enter Price">
							  	<?=form_error('price')?>
							</div>

							<div class="form-group <?=form_error('codeno') ? 'has-error' : ''?>">
							 	<label for="codeno">Nomor Kode</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="codeno" name="codeno" value="<?=set_value('codeno')?>" placeholder="Enter Code No">
							  	<?=form_error('codeno')?>
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

							<div class="form-group <?=form_error('storebookcategoryID') ? 'has-error' : ''?>">
							  	<label for="storebookcategoryID">Kategori</label> <span class="text-red">*</span>
								<?php 
									$storebookcategoryArray = [];
									$storebookcategoryArray[0] = 'Silakan Pilih';
									if(calculate($storebookcategorys)) {
										foreach($storebookcategorys as $storebookcategory) {
											$storebookcategoryArray[$storebookcategory->storebookcategoryID] = $storebookcategory->name;
										}
									}
									echo form_dropdown('storebookcategoryID', $storebookcategoryArray, set_value('storebookcategoryID'), 'id="storebookcategoryID" class="form-control"');
								?>
							  	<?=form_error('storebookcategoryID')?>
							</div>

							<div class="form-group <?=form_error('isbnno') ? 'has-error' : ''?>">
							 	<label for="isbnno">ISBN</label>
							  	<input type="text" class="form-control" id="isbnno" name="isbnno" value="<?=set_value('isbnno')?>" placeholder="Enter isbnno">
							  	<?=form_error('isbnno')?>
							</div>
							
						    <div class="form-group <?=form_error('editionnumber') ? 'has-error' : ''?>">
							 	<label for="editionnumber">Edisi Ke</label>
							  	<input type="text" class="form-control" id="editionnumber" name="editionnumber" value="<?=set_value('editionnumber')?>" placeholder="Enter Edition Number">
							  	<?=form_error('editionnumber')?>
							</div>
							
							<div class="form-group <?=form_error('editiondate') ? 'has-error' : ''?>">
							 	<label for="editiondate">Edisi Tanggal</label>
							  	<input type="text" class="form-control datepicker" id="editiondate" name="editiondate" value="<?=set_value('editiondate')?>" placeholder="Enter Edition Date">
							  	<?=form_error('editiondate')?>
							</div>
							
							<div class="form-group <?=form_error('publisher') ? 'has-error' : ''?>">
							 	<label for="publisher">Penerbit</label>
							  	<input type="text" class="form-control" id="publisher" name="publisher" value="<?=set_value('publisher')?>" placeholder="Enter Publisher">
							  	<?=form_error('publisher')?>
							</div>
							
							<div class="form-group <?=form_error('publisheddate') ? 'has-error' : ''?>">
							 	<label for="publisheddate">Tanggal Terbit</label>
							  	<input type="text" class="form-control datepicker" id="publisheddate" name="publisheddate" value="<?=set_value('publisheddate')?>" placeholder="Enter Published Date">
							  	<?=form_error('publisheddate')?>
							</div>
							
							<div class="form-group <?=form_error('notes') ? 'has-error' : ''?>">
							  	<label for="notes">Catatan</label>
							  	<textarea name="notes"  id="notes" cols="30" rows="5" class="form-control" placeholder="Enter Notes"><?=set_value('notes')?></textarea>
							  	<?=form_error('notes')?>
							</div>
							
							<div class="form-group <?=form_error('description') ? 'has-error' : ''?>">
							  	<label for="description">Deskripsi</label> <span class="text-red">*</span>
							  	<textarea name="description"  id="description" cols="30" rows="5" class="form-control" placeholder="Enter description"><?=set_value('description')?></textarea>
							  	<?=form_error('description')?>
							</div>

							<div class="form-group">
		                        <label for="images">Gambar(Multiple)</label>
							  	<input type="file" class="form-control" name="images[]" multiple id="images"/>
		                    </div>
		                    <div id="image_preview"></div>

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


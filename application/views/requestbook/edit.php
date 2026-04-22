<div class="content-wrapper">
    <section class="content-header">
  		<h1>Permintaan Buku</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('permintaan_buku/index')?>">Permintaan Buku</a></li>
  			<li class='aktif'>Edit</li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="row">
				<div class="col-md-6">
					<form peran="form" method="post" enctype="multipart/form-data">
						<div class="box-body">
							<div class="form-group <?=form_error('nama') ? 'has-error' : ''?>">
							 	<label for='nama'>Judul Buku</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='nama' name='nama' value="<?=set_value('nama', $permintaan_buku->nama)?>" placeholder="Enter name">
							  	<?=form_error('nama')?>
							</div>

							<div class="form-group <?=form_error('penulis') ? 'has-error' : ''?>">
							 	<label for='penulis'>Penulis</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='penulis' name='penulis' value="<?=set_value('penulis', $permintaan_buku->penulis)?>" placeholder="Enter Author">
							  	<?=form_error('penulis')?>
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
						                    <input type='file' accept="image/png, image/jpeg, image/gif" name="coverphoto"/>
						                </div>
						            </span>
						        </div>
						        <div class="input-group">
						        	<img class="userprofileimg" src="<?=app_image_link($permintaan_buku->coverphoto,'uploads/buku/','permintaan_buku.jpg')?>" alt="">
						        </div>
						      	<?=form_error('coverphoto');?>
						    </div>

							<div class="form-group <?=form_error('bookcategoryID') ? 'has-error' : ''?>">
							  	<label for="bookcategoryID">Kategori</label>
								<?php 
									$bookcategoryArray = [];
									$bookcategoryArray[0] = 'Silakan Pilih';
									if(calculate($bookcategorys)) {
										foreach($bookcategorys as $kategori_buku) {
											$bookcategoryArray[$kategori_buku->bookcategoryID] = $kategori_buku->nama;
										}
									}
									echo form_dropdown('bookcategoryID', $bookcategoryArray, set_value('bookcategoryID', $permintaan_buku->bookcategoryID), 'id="bookcategoryID" class="form-control"');
								?>
							  	<?=form_error('bookcategoryID')?>
							</div>

							<div class="form-group <?=form_error('isbnno') ? 'has-error' : ''?>">
							 	<label for="isbnno">ISBN</label>
							  	<input type="text" class="form-control" id="isbnno" name="isbnno" value="<?=set_value('isbnno', $permintaan_buku->isbnno)?>" placeholder="Enter isbnno">
							  	<?=form_error('isbnno')?>
							</div>

						    <div class="form-group <?=form_error('editionnumber') ? 'has-error' : ''?>">
							 	<label for="editionnumber">Edisi Ke</label>
							  	<input type="text" class="form-control" id="editionnumber" name="editionnumber" value="<?=set_value('editionnumber', $permintaan_buku->editionnumber)?>" placeholder="Enter Edition Number">
							  	<?=form_error('editionnumber')?>
							</div>
							
							<div class="form-group <?=form_error('editiondate') ? 'has-error' : ''?>">
							 	<label for="editiondate">Tanggal Edisi</label>
							 	<?php $editiondate = isset($permintaan_buku->editiondate) ? date('d-m-Y',strtotime($permintaan_buku->editiondate)) : ''?>
							  	<input type="text" class="form-control datepicker" id="editiondate" name="editiondate" value="<?=set_value('editiondate', $editiondate)?>" placeholder="Enter Edition Date">
							  	<?=form_error('editiondate')?>
							</div>
							
							<div class="form-group <?=form_error('penerbit') ? 'has-error' : ''?>">
							 	<label for='penerbit'>Penerbit</label>
							  	<input type="text" class="form-control" id='penerbit' name='penerbit' value="<?=set_value('penerbit', $permintaan_buku->penerbit)?>" placeholder="Enter Publisher">
							  	<?=form_error('penerbit')?>
							</div>
							
							<div class="form-group <?=form_error('publisheddate') ? 'has-error' : ''?>">
							 	<label for="publisheddate">Tanggal Terbit</label>
							 	<?php $publisheddate = isset($permintaan_buku->publisheddate) ? date('d-m-Y',strtotime($permintaan_buku->publisheddate)) : ''?>
							  	<input type="text" class="form-control datepicker" id="publisheddate" name="publisheddate" value="<?=set_value('publisheddate', $publisheddate)?>" placeholder="Enter Published Date">
							  	<?=form_error('publisheddate')?>
							</div>
							
							<div class="form-group <?=form_error('notes') ? 'has-error' : ''?>">
							  	<label for="notes">Catatan</label>
							  	<textarea name="notes"  id="notes" cols="30" rows="5" class="form-control" placeholder="Enter Notes"><?=set_value('notes', $permintaan_buku->notes)?></textarea>
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
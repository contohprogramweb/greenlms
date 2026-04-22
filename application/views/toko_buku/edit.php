<div class="content-wrapper">
    <section class="content-header">
  		<h1>Buku Toko</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('buku_toko/index')?>">Buku Toko</a></li>
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
							  	<input type="text" class="form-control" id='nama' name='nama' value="<?=set_value('nama', $buku->nama)?>" placeholder="Enter name">
							  	<?=form_error('nama')?>
							</div>

							<div class="form-group <?=form_error('penulis') ? 'has-error' : ''?>">
							 	<label for='penulis'>Penulis</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='penulis' name='penulis' value="<?=set_value('penulis', $buku->penulis)?>" placeholder="Enter Author">
							  	<?=form_error('penulis')?>
							</div>

							<div class="form-group <?=form_error('jumlah') ? 'has-error' : ''?>">
							 	<label for='jumlah'>Quantity</label> <span class="text-red">*</span>
							  	<input type="number" class="form-control" id='jumlah' name='jumlah' value="<?=set_value('jumlah', $buku->jumlah)?>" placeholder="Enter Quantity">
							  	<?=form_error('jumlah')?>
							</div>

							<div class="form-group <?=form_error('harga') ? 'has-error' : ''?>">
							 	<label for='harga'>Harga</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='harga' name='harga' value="<?=set_value('harga', $buku->harga)?>" placeholder="Enter Price">
							  	<?=form_error('harga')?>
							</div>

							<div class="form-group <?=form_error('codeno') ? 'has-error' : ''?>">
							 	<label for="codeno">Nomor Kode</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="codeno" name="codeno" value="<?=set_value('codeno', $buku->codeno)?>" placeholder="Enter Code No">
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
						                    <input type='file' accept="image/png, image/jpeg, image/gif" name="coverphoto"/>
						                </div>
						            </span>
						        </div>
						        <div class="input-group">
						        	<img class="userprofileimg" src="<?=app_image_link($buku->coverphoto,'uploads/buku_toko/','permintaan_buku.jpg')?>" alt="">
						        </div>
						      	<?=form_error('coverphoto');?>
						    </div>

							<div class="form-group <?=form_error('storebookcategoryID') ? 'has-error' : ''?>">
							  	<label for="storebookcategoryID">Kategori</label> <span class="text-red">*</span>
								<?php 
									$storebookcategoryArray = [];
									$storebookcategoryArray[0] = 'Silakan Pilih';
									if(calculate($storebookcategorys)) {
										foreach($storebookcategorys as $kategori_buku_toko) {
											$storebookcategoryArray[$kategori_buku_toko->storebookcategoryID] = $kategori_buku_toko->nama;
										}
									}
									echo form_dropdown('storebookcategoryID', $storebookcategoryArray, set_value('storebookcategoryID', $buku->storebookcategoryID), 'id="storebookcategoryID" class="form-control"');
								?>
							  	<?=form_error('storebookcategoryID')?>
							</div>

							<div class="form-group <?=form_error('isbnno') ? 'has-error' : ''?>">
							 	<label for="isbnno">ISBN</label>
							  	<input type="text" class="form-control" id="isbnno" name="isbnno" value="<?=set_value('isbnno', $buku->isbnno)?>" placeholder="Enter isbnno">
							  	<?=form_error('isbnno')?>
							</div>
							
						    <div class="form-group <?=form_error('editionnumber') ? 'has-error' : ''?>">
							 	<label for="editionnumber">Edisi Ke</label>
							  	<input type="text" class="form-control" id="editionnumber" name="editionnumber" value="<?=set_value('editionnumber', $buku->editionnumber)?>" placeholder="Enter Edition Number">
							  	<?=form_error('editionnumber')?>
							</div>
							
							<div class="form-group <?=form_error('editiondate') ? 'has-error' : ''?>">
							 	<label for="editiondate">Edisi Tanggal</label>
							 	<?php $editiondate = isset($buku->editiondate) ? date('d-m-Y',strtotime($buku->editiondate)) : ''?>
							  	<input type="text" class="form-control" id="editiondate" name="editiondate" value="<?=set_value('editiondate', $editiondate)?>" placeholder="Enter Edition Date">
							  	<?=form_error('editiondate')?>
							</div>
							
							<div class="form-group <?=form_error('penerbit') ? 'has-error' : ''?>">
							 	<label for='penerbit'>Penerbit</label>
							  	<input type="text" class="form-control" id='penerbit' name='penerbit' value="<?=set_value('penerbit', $buku->penerbit)?>" placeholder="Enter Publisher">
							  	<?=form_error('penerbit')?>
							</div>
							
							<div class="form-group <?=form_error('publisheddate') ? 'has-error' : ''?>">
							 	<?php $publisheddate = isset($buku->publisheddate) ? date('d-m-Y',strtotime($buku->publisheddate)) : ''?>
							 	<label for="publisheddate">Tanggal Terbit</label>
							  	<input type="text" class="form-control" id="publisheddate" name="publisheddate" value="<?=set_value('publisheddate', $publisheddate)?>" placeholder="Enter Published Date">
							  	<?=form_error('publisheddate')?>
							</div>
							
							<div class="form-group <?=form_error('notes') ? 'has-error' : ''?>">
							  	<label for="notes">Catatan</label>
							  	<textarea name="notes"  id="notes" cols="30" rows="5" class="form-control" placeholder="Enter Notes"><?=set_value('notes', $buku->notes)?></textarea>
							  	<?=form_error('notes')?>
							</div>

							<div class="form-group <?=form_error('deskripsi') ? 'has-error' : ''?>">
							  	<label for='deskripsi'>Deskripsi</label> <span class="text-red">*</span>
							  	<textarea name='deskripsi'  id='deskripsi' cols="30" rows="5" class="form-control" placeholder="Enter description"><?=set_value('deskripsi', $buku->deskripsi)?></textarea>
							  	<?=form_error('deskripsi')?>
							</div>
							
							<div class="form-group">
							  	<label for="images">Gambar(Multiple)</label>
							  	<input type='file' class="form-control" name="images[]" multiple id="images"/>
		                    </div>
		                    <div id="image_preview">
		                    	<?php if(calculate($storebookimages)) { foreach($storebookimages as $gambar_buku_toko) { ?>
		                    		<img class="imgthumbnail" src="<?=app_image_link($gambar_buku_toko->file_name,'uploads/buku_toko/','permintaan_buku.jpg')?>"/>
		                    	<?php } } ?>
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
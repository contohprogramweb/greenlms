<div class="content-wrapper">
    <section class="content-header">
  		<h1>Pengeluaran</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('pengeluaran/index')?>">Pengeluaran</a></li>
  			<li class='aktif'>Edit</li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="row">
				<div class="col-md-6">
					<form peran="form" method="post" enctype="multipart/form-data" autocomplete="off">
						<div class="box-body">
							<div class="form-group <?=form_error('nama') ? 'has-error' : ''?>">
							 	<label for='nama'>Nama Pengeluaran</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='nama' name='nama' value="<?=set_value('nama', $pengeluaran->nama)?>" placeholder="Enter Name">
							  	<?=form_error('nama')?>
							</div>
							<div class="form-group <?=form_error('tanggal') ? 'has-error' : ''?>">
								<label for='tanggal'>Tanggal</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control datepicker" id='tanggal' name='tanggal' value="<?=set_value('tanggal', date('d-m-Y', strtotime($pengeluaran->tanggal)))?>" placeholder="Enter Date">
							  	<?=form_error('tanggal')?>
							</div>
							<div class="form-group <?=form_error('jumlah') ? 'has-error' : ''?>">
							  	<label for='jumlah'>Jumlah</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='jumlah' name='jumlah' value="<?=set_value('jumlah', $pengeluaran->jumlah)?>" placeholder="Enter Amount">
							  	<?=form_error('jumlah')?>
							</div>
							<div class="form-group <?=form_error('file') ? 'has-error' : ''?>">
						        <label for='file'>File</label>
						        <div class="input-group image-preview">
						            <input type="text" class="form-control image-preview-filename" disabled="disabled">
						            <span class="input-group-btn">
						                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
						                    <span class="fa fa-remove"></span>Clear
						                </button>
						                <div class="btn btn-success image-preview-input">
						                    <span class="fa fa-repeat"></span>
						                    <span class="image-preview-input-title">Browse</span>
						                    <input type='file' accept="image/png, image/jpeg, image/gif" name='file'/>
						                </div>
						            </span>
						        </div>
						      	<?=form_error('file');?>
						    </div>
							<div class="form-group <?=form_error('catatan') ? 'has-error' : ''?>">
							  	<label for='catatan'>Catatan</label>
							  	<textarea name='catatan' id='catatan' class="form-control" cols="30" rows="5"><?=set_value('catatan', $pengeluaran->catatan)?></textarea>
							  	<?=form_error('catatan')?>
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
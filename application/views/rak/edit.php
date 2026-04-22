<div class="content-wrapper">
    <section class="content-header">
  		<h1>Rak</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('rak/index')?>">Rak</a></li>
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
							 	<label for='nama'>Nama Rak</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='nama' name='nama' value="<?=set_value('nama', $rak->nama)?>" placeholder="Enter name">
							  	<?=form_error('nama')?>
							</div>
							<div class="form-group <?=form_error('deskripsi') ? 'has-error' : ''?>">
							  	<label for='deskripsi'>Deskripsi</label> <span class="text-red">*</span>
							  	<textarea name='deskripsi' id='deskripsi' cols="30" rows="5" class="form-control" placeholder="Enter description"><?=set_value('deskripsi', $rak->deskripsi)?></textarea>
							  	<?=form_error('deskripsi')?>
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
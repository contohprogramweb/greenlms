<div class="content-wrapper">
    <section class="content-header">
  		<h1>Rak</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('rack/index')?>">Rak</a></li>
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
							 	<label for="name">Nama Rak</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="name" name="name" value="<?=set_value('name')?>" placeholder="Enter name">
							  	<?=form_error('name')?>
							</div>
							<div class="form-group <?=form_error('description') ? 'has-error' : ''?>">
							  	<label for="description">Deskripsi</label> <span class="text-red">*</span>
							  	<textarea name="description" value="<?=set_value('description')?>" id="" cols="30" rows="5" class="form-control" placeholder="Enter description"><?=set_value('description')?></textarea>
							  	<?=form_error('description')?>
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
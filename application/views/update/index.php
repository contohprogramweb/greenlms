<div class="content-wrapper">
    <section class="content-header">
  		<h1>Update</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a class="active">Update</a></li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="row">
				<div class="col-md-6">
					<form role="form" method="post" enctype="multipart/form-data">
						<div class="box-body">
						    <div class="form-group <?=form_error('upload') ? 'has-error' : ''?>">
						        <label for="upload">Upload </label> <span class="text-red">*</span>
						        <div class="input-group image-preview">
						            <input type="text" class="form-control fileuploadname" disabled="disabled" />
						            <span class="input-group-btn">
						                <div class="btn btn-success image-preview-input">
						                    <span class="fa fa-repeat"></span>
						                    <span class="image-preview-input-title">Browse</span>
						                    <input type="file" name="upload" id="fileupload" accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed"/>
						                </div>
						            </span>
						        </div>
						      	<?=form_error('upload');?>
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
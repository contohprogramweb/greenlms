<div class="content-wrapper">
    <section class="content-header">
  		<h1>Pengaturan Umum</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  			<li class='aktif'>Pengaturan Umum</li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="box-body">
				<form action="<?=base_url('pengaturan_umum/index')?>" method="POST" enctype="multipart/form-data">
					<fieldset class="setting-fieldset">
		                <legend class="setting-legend">Pengaturan Umum</legend>
		                <div class="row">
		                    <div class="col-sm-6 sitename">
		                   		<div class="form-group <?=form_error('sitename') ? 'has-error' : ''?>">
		                            <label for="sitename">
		                                Nama Website <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your sitename"></i>
		                            </label>
		                            <input type="text" class="form-control" id="sitename" name="sitename" value="<?=set_value('sitename', $pengaturan_umum->sitename)?>" />
		                            <?=form_error('sitename'); ?>
				                </div>
				            </div>
		                    <div class="col-sm-6 logo">
				                <div class="form-group <?=form_error('logo') ? 'has-error' : ''?>">
							        <label for="logo">
		                                Logo <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your logo"></i>
		                            </label>
							        <div class="input-group image-preview">
							            <input type="text" class="form-control fileuploadname" value="<?=set_value('logo', $pengaturan_umum->logo)?>" disabled="disabled" />
							            <span class="input-group-btn">
							                <div class="btn btn-success image-preview-input">
							                    <span class="fa fa-repeat"></span>
							                    <span class="image-preview-input-title">Browse</span>
							                    <input type='file' name="logo" id="fileupload"/>
							                </div>
							            </span>
							        </div>
							      	<?=form_error('logo');?>
							    </div>
				            </div>
		                    <div class="col-sm-6 address">
		                   		<div class="form-group <?=form_error('alamat') ? 'has-error' : ''?>">
		                            <label for='alamat'>
		                                Alamat <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your address"></i>
		                            </label>
		                            <textarea class="form-control" name='alamat' id='alamat' cols="30" rows="2"><?=set_value('alamat', $pengaturan_umum->alamat)?></textarea>
		                            <?=form_error('alamat'); ?>
				                </div>
				            </div>
		                    <div class="col-sm-6 copyright_by">
		                   		<div class="form-group <?=form_error('copyright_by') ? 'has-error' : ''?>">
		                            <label for="copyright_by">
		                                Copyright <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your copyright_by"></i>
		                            </label>
		                            <textarea class="form-control" name="copyright_by" id="copyright_by" cols="30" rows="2"><?=set_value('copyright_by', $pengaturan_umum->copyright_by)?></textarea>
		                            <?=form_error('copyright_by'); ?>
				                </div>
				            </div>
		                	<div class="col-sm-6 email">
		                   		<div class="form-group <?=form_error('surel') ? 'has-error' : ''?>">
		                            <label for='surel'>
		                                Email <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your email"></i>
		                            </label>
		                            <input type="text" class="form-control" id='surel' name='surel' value="<?=set_value('surel', $pengaturan_umum->surel)?>" />
		                            <?=form_error('surel'); ?>
				                </div>
				            </div>
		                	<div class="col-sm-6 phone">
		                   		<div class="form-group <?=form_error('telepon') ? 'has-error' : ''?>">
		                            <label for='telepon'>
		                                Nomor Telp. <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your phone"></i>
		                            </label>
		                            <input type="text" class="form-control" id='telepon' name='telepon' value="<?=set_value('telepon', $pengaturan_umum->telepon)?>" />
		                            <?=form_error('telepon'); ?>
				                </div>
				            </div>
		                	<div class="col-sm-6 web_address">
		                   		<div class="form-group <?=form_error('web_address') ? 'has-error' : ''?>">
		                            <label for="web_address">
		                                Alamat Web <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your web address"></i>
		                            </label>
		                            <input type="text" class="form-control" id="web_address" name="web_address" value="<?=set_value('web_address', $pengaturan_umum->web_address)?>" />
		                            <?=form_error('web_address'); ?>
				                </div>
				            </div>
		                </div>
		            </fieldset>

		            <fieldset class="setting-fieldset">
		                <legend class="setting-legend">Pengaturan Halaman Depan</legend>
		                <div class="row">
		                    <div class="col-sm-6 ebook_download">
		                   		<div class="form-group <?=form_error('ebook_download') ? 'has-error' : ''?>">
								  	<label>Download Ebook</label> <span class="text-red">*</span>
								  	<?php 
										$ebookDownloadArray[1] = 'Difungsikan';
										$ebookDownloadArray[0] = 'Tidak Difungsikan';

										echo form_dropdown('ebook_download', $ebookDownloadArray, set_value('ebook_download', $pengaturan_umum->ebook_download),'id="ebook_download" class="form-control"');
									?>
								  	<?=form_error('ebook_download')?>
								</div>
							</div>
		                    <div class="col-sm-6 registration">
		                   		<div class="form-group <?=form_error('registration') ? 'has-error' : ''?>">
								  	<label>Registrasi</label> <span class="text-red">*</span>
								  	<?php 
										$registrationArray[1] = 'Difungsikan';
										$registrationArray[0] = 'Tidak Difungsikan';

										echo form_dropdown('registration', $registrationArray, set_value('registration', $pengaturan_umum->registration),'id="registration" class="form-control"');
									?>
								  	<?=form_error('registration')?>
								</div>
							</div>
		                    <div class="col-sm-6 frontend">
		                   		<div class="form-group <?=form_error('frontend') ? 'has-error' : ''?>">
								  	<label>Front End</label> <span class="text-red">*</span>
								  	<?php 
										$frontendArray[1] = 'Difungsikan';
										$frontendArray[0] = 'Tidak Difungsikan';

										echo form_dropdown('frontend', $frontendArray, set_value('frontend', $pengaturan_umum->frontend),'id="frontend" class="form-control"');
									?>
								  	<?=form_error('frontend')?>
								</div>
							</div>
		                    <div class="col-sm-6 delivery_charge">
		                   		<div class="form-group <?=form_error('delivery_charge') ? 'has-error' : ''?>">
								  	<label>Ongkos Kirim</label> <span class="text-red">*</span>
								  	<input type="text" class="form-control" id="delivery_charge" name="delivery_charge" value="<?=set_value('delivery_charge', $pengaturan_umum->delivery_charge)?>" />
								  	<?=form_error('delivery_charge')?>
								</div>
							</div>
		                    
		                </div>
		            </fieldset>

		            <div class="row">
			            <div class="col-sm-12">
			            	<div class="form-group">
			                    <input type="submit" class="btn btn-mytheme btn-md" value="Update">
			                </div>
			            </div>
		            </div>
	        	</form>
			</div>
		</div>
    </section>
</div>
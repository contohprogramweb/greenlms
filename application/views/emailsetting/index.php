<div class="content-wrapper">
    <section class="content-header">
  		<h1>Pengaturan Email</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/dashboard')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li class='aktif'> Pengaturan Email</li>
  		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="box box-mytheme">
			<div class="box-body">	
				<form method="post">
					<fieldset class="setting-fieldset">
		                <legend class="setting-legend">Pengaturan Email</legend>
		                <div class="row">
		                    <div class="col-sm-4">
		                   		<div class="form-group <?=form_error('mail_driver') ? 'has-error' : ''?>">
		                            <label for="mail_driver">
		                                Driver <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your smtp mail driver"></i>
		                            </label>
		                            <input type="text" class="form-control" id="mail_driver" name="mail_driver" value="<?=set_value('mail_driver', $pengaturan_surel->mail_driver)?>" />
		                            <?=form_error('mail_driver'); ?>
				                </div>
				            </div>
				            <div class="col-sm-4">
		                    	<div class="form-group <?=form_error('mail_host') ? 'has-error' : ''?>">
		                            <label for="mail_host">
		                                Host <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your smtp mail host"></i>
		                            </label>
		                            <input type="text" class="form-control" id="mail_host" name="mail_host" value="<?=set_value('mail_host', $pengaturan_surel->mail_host)?>" />
		                            <?=form_error('mail_host'); ?>
				                </div>
		                    </div>
				            <div class="col-sm-4">
		                    	<div class="form-group <?=form_error('mail_port') ? 'has-error' : ''?>">
		                            <label for="mail_port">
		                                Port <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your smtp mail port"></i>
		                            </label>
		                            <input type="text" class="form-control" id="mail_port" name="mail_port" value="<?=set_value('mail_port', $pengaturan_surel->mail_port)?>" />
		                            <?=form_error('mail_port'); ?>
				                </div>
		                    </div>
				            <div class="col-sm-4">
		                    	<div class="form-group <?=form_error('mail_username') ? 'has-error' : ''?>">
		                            <label for="mail_username">
		                                Username <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your smtp mail password"></i>
		                            </label>
		                            <input type="text" class="form-control" id="mail_username" name="mail_username" value="<?=set_value('mail_username', $pengaturan_surel->mail_username)?>" />
		                            <?=form_error('mail_username'); ?>
				                </div>
		                    </div>
				            <div class="col-sm-4">
		                    	<div class="form-group <?=form_error('mail_password') ? 'has-error' : ''?>">
		                            <label for="mail_password">
		                                Password <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your smtp mail password"></i>
		                            </label>
		                            <input type="text" class="form-control" id="mail_password" name="mail_password" value="<?=set_value('mail_password', $pengaturan_surel->mail_password)?>" />
		                            <?=form_error('mail_password'); ?>
				                </div>
		                    </div>
				            <div class="col-sm-4">
		                    	<div class="form-group <?=form_error('mail_encryption') ? 'has-error' : ''?>">
		                            <label for="mail_encryption">
		                                Enkripsi <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="Set your smtp mail encryption"></i>
		                            </label>
		                            <input type="text" class="form-control" id="mail_encryption" name="mail_encryption" value="<?=set_value('mail_encryption', $pengaturan_surel->mail_encryption)?>" />
		                            <?=form_error('mail_encryption'); ?>
				                </div>
		                    </div>
		                </div>
		            </fieldset>
		            <div class="row">
			            <div class="col-sm-12">
			            	<div class="form-group">
			                    <button class="btn btn-mytheme btn-md" type="submit">Update</button>
			                </div>
			            </div>
		            </div>
		        </form>
			</div>
		</div>
    </section>
</div>
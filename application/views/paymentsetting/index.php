<div class="content-wrapper">
    <section class="content-header">
  		<h1>Pengaturan Pembayaran</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  			<li class='aktif'>Pengaturan Pembayaran</li>
  		</ol>
    </section>
    <section class="content">
		<div class="box box-mytheme">
			<div class="box-body">
				<form action="<?=base_url('paymentsetting/index')?>" method="POST" enctype="multipart/form-data">
					<fieldset class="setting-fieldset">
		                <legend class="setting-legend">Metode Pembayaran</legend>
		                <div class="row">
							<div class="col-sm-6 paypal_payment_method">
		                   		<div class="form-group <?=form_error('paypal_payment_method') ? 'has-error' : ''?>">
								  	<label>Pengaturan Paypal</label> <span class="text-red">*</span>
								  	<?php 
										$paypalArray[1] = 'Difungsikan';
										$paypalArray[0] = 'Tidak Difungsikan';

										echo form_dropdown('paypal_payment_method', $paypalArray, set_value('paypal_payment_method', $pengaturan_umum->paypal_payment_method),'id="paypal_payment_method" class="form-control"');
									?>
								  	<?=form_error('paypal_payment_method')?>
								</div>
							</div>
							<div class="col-sm-6 stripe_payment_method">
		                   		<div class="form-group <?=form_error('stripe_payment_method') ? 'has-error' : ''?>">
								  	<label>Pengaturan Stripe</label> <span class="text-red">*</span>
								  	<?php 
										$stripeArray[1] = 'Difungsikan';
										$stripeArray[0] = 'Tidak Difungsikan';

										echo form_dropdown('stripe_payment_method', $stripeArray, set_value('stripe_payment_method', $pengaturan_umum->stripe_payment_method),'id="stripe_payment_method" class="form-control"');
									?>
								  	<?=form_error('stripe_payment_method')?>
								</div>
							</div>
		                </div>
		            </fieldset>

		            <fieldset class="setting-fieldset">
		                <legend class="setting-legend">Pengaturan Stripe</legend>
		                <div class="row">
		                    <div class="col-sm-6 stripe_key">
		                   		<div class="form-group <?=form_error('stripe_key') ? 'has-error' : ''?>">
								  	<label>Stripe Key</label>
								  	<input type="text" class="form-control" id="stripe_key" name="stripe_key" value="<?=set_value('stripe_key', $pengaturan_umum->stripe_key)?>" />
								  	<?=form_error('stripe_key')?>
								</div>
							</div>
							<div class="col-sm-6 stripe_secret">
		                   		<div class="form-group <?=form_error('stripe_secret') ? 'has-error' : ''?>">
								  	<label>Stripe Secret</label>
								  	<input type="text" class="form-control" id="stripe_secret" name="stripe_secret" value="<?=set_value('stripe_secret', $pengaturan_umum->stripe_secret)?>" />
								  	<?=form_error('stripe_secret')?>
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
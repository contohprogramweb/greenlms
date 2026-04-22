<div class="content-wrapper">
    <section class="content-header">
  		<h1>Anggota</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('member/index')?>">Anggota</a></li>
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
							 	<label for="name">Nama Anggota</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="name" name="name" value="<?=set_value('name')?>" placeholder="Enter name">
							  	<?=form_error('name')?>
							</div>
							<div class="form-group <?=form_error('dateofbirth') ? 'has-error' : ''?>">
								<label for="dateofbirth">Tanggal Lahir</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control datepicker" id="dateofbirth" name="dateofbirth" value="<?=set_value('dateofbirth')?>" placeholder="Enter date of birth">
							  	<?=form_error('dateofbirth')?>
							</div>
							<div class="form-group <?=form_error('gender') ? 'has-error' : ''?>">
							  	<label>Jenis Kelamin</label> <span class="text-red">*</span>
							  	<?php 
									$genderArray[0]        = 'Silakan Pilih';
									$genderArray['Male']   = 'Laki-laki';
									$genderArray['Female'] = 'Perempuan';

									echo form_dropdown('gender', $genderArray, set_value('gender'),'id="gender" class="form-control"');
								?>
							  	<?=form_error('gender')?>
							</div>
							<div class="form-group <?=form_error('religion') ? 'has-error' : ''?>">
							  	<label for="religion">Agama</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="religion" name="religion" value="<?=set_value('religion')?>" placeholder="Enter religion">
							  	<?=form_error('religion')?>
							</div>
							<div class="form-group <?=form_error('email') ? 'has-error' : ''?>">
							  	<label for="email">Email</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="email" name="email" value="<?=set_value('email')?>" placeholder="Enter email">
							  	<?=form_error('email')?>
							</div>
							<div class="form-group <?=form_error('phone') ? 'has-error' : ''?>">
							  	<label for="phone">Nomor Telp.</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="phone" name="phone" value="<?=set_value('phone')?>" placeholder="Enter phone">
							  	<?=form_error('phone')?>
							</div>
							<div class="form-group <?=form_error('bloodgroup') ? 'has-error' : ''?>">
							  	<label>Gol. Darah</label> <span class="text-red">*</span>
							  	<?php 
									$bloodgroupArray[0]     = 'Silakan Pilih';
									$bloodgroupArray['A+']  = 'A+';
									$bloodgroupArray['A-']  = 'A-';
									$bloodgroupArray['B+']  = 'B+';
									$bloodgroupArray['B-']  = 'B-';
									$bloodgroupArray['AB+'] = 'AB+';
									$bloodgroupArray['AB-'] = 'AB-';
									$bloodgroupArray['O+']  = 'O+';
									$bloodgroupArray['O-']  = 'O-';

									echo form_dropdown('bloodgroup', $bloodgroupArray, set_value('bloodgroup'),'id="bloodgroup" class="form-control"');
								?>
							  	<?=form_error('bloodgroup')?>
							</div>
							<div class="form-group <?=form_error('address') ? 'has-error' : ''?>">
							  	<label for="address">Alamat</label> <span class="text-red">*</span>
							  	<textarea name="address" value="<?=set_value('address')?>" id="" cols="30" rows="5" class="form-control" placeholder="Enter address"><?=set_value('address')?></textarea>
							  	<?=form_error('address')?>
							</div>
							<div class="form-group <?=form_error('joinningdate') ? 'has-error' : ''?>">
							  	<label for="joinningdate">Tanggal Daftar</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control datepicker" id="joinningdate" name="joinningdate" value="<?=set_value('joinningdate')?>" placeholder="Enter joinning of date">
							  	<?=form_error('joinningdate')?>
							</div>
							<div class="form-group <?=form_error('photo') ? 'has-error' : ''?>">
						        <label for="photo">Foto</label>
						        <div class="input-group image-preview">
						            <input type="text" class="form-control image-preview-filename" disabled="disabled">
						            <span class="input-group-btn">
						                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
						                    <span class="fa fa-remove"></span>Clear
						                </button>
						                <div class="btn btn-success image-preview-input">
						                    <span class="fa fa-repeat"></span>
						                    <span class="image-preview-input-title">Browse</span>
						                    <input type="file" accept="image/png, image/jpeg, image/gif" name="photo"/>
						                </div>
						            </span>
						        </div>
						      	<?=form_error('photo');?>
						    </div>
							<div class="form-group <?=form_error('roleID') ? 'has-error' : ''?>">
							  	<label for="roleID">Hak Akses</label> <span class="text-red">*</span>
								<?php 
									$roleArray[0] = 'Silakan Pilih';
									if(calculate($roles)) {
										foreach ($roles as $role) {
											$roleArray[$role->roleID] = $role->role;
										}
									}
									echo form_dropdown('roleID', $roleArray,set_value('roleID'),'id="roleID" class="form-control"');
								?>
								<?=form_error('roleID')?>
							</div>
							<div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
							  	<label for="status">Status</label> <span class="text-red">*</span>
							  	<?php 
									$statusArray[0] = 'Silakan Pilih';
									$statusArray[1] = 'Aktif';
									$statusArray[2] = 'Non Aktif';

									echo form_dropdown('status', $statusArray, set_value('status'),'id="status" class="form-control"');
								?>
							  	<?=form_error('status')?>
							</div>
							<div class="form-group <?=form_error('username') ? 'has-error' : ''?>">
							  	<label for="username">Username</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="username" name="username" value="<?=set_value('username')?>" placeholder="Enter username">
							  	<?=form_error('username')?>
							</div>
							<div class="form-group <?=form_error('password') ? 'has-error' : ''?>">
							  	<label for="password">Password</label> <span class="text-red">*</span>
							  	<div class="input-group">
							    	<input type="password" class="form-control" id="password" name="password" value="<?=set_value('password')?>" placeholder="Enter Password">
							    	<span style="cursor: pointer;" class="input-group-addon" id="generate_password"><i class="fa fa-repeat"></i></span>
							    	<span style="cursor: pointer;" class="input-group-addon" id="showpassword"><i class="fa fa-eye" id="eyeicon"></i></span>
							  	</div>
							  	<?=form_error('password')?>
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
<div class="content-wrapper">
    <section class="content-header">
  		<h1>Anggota</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('anggota/index')?>">Anggota</a></li>
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
							 	<label for='nama'>Nama Anggota</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='nama' name='nama' value="<?=set_value('nama', $anggota->nama)?>" placeholder="Enter name">
							  	<?=form_error('nama')?>
							</div>
							<div class="form-group <?=form_error('dateofbirth') ? 'has-error' : ''?>">
								<label for="dateofbirth">Tanggal Lahir</label> <span class="text-red">*</span>
								<?php $dateofbirth = isset($anggota->dateofbirth) ? date('d-m-Y',strtotime($anggota->dateofbirth)) : ''?>
							  	<input type="text" class="form-control datepicker" id="dateofbirth" name="dateofbirth" value="<?=set_value('dateofbirth', $dateofbirth)?>" placeholder="Enter date of birth">
							  	<?=form_error('dateofbirth')?>
							</div>
							<div class="form-group <?=form_error('jenis_kelamin') ? 'has-error' : ''?>">
							  	<label>Jenis Kelamin</label> <span class="text-red">*</span>
							  	<?php 
									$genderArray[0]        = 'Silakan Pilih';
									$genderArray['Male']   = 'Laki-laki';
									$genderArray['Female'] = 'Perempuan';

									echo form_dropdown('jenis_kelamin', $genderArray, set_value('jenis_kelamin', $anggota->jenis_kelamin),'id='jenis_kelamin' class="form-control"');
								?>
							  	<?=form_error('jenis_kelamin')?>
							</div>
							<div class="form-group <?=form_error('agama') ? 'has-error' : ''?>">
							  	<label for='agama'>Agama</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='agama' name='agama' value="<?=set_value('agama', $anggota->agama)?>" placeholder="Enter religion">
							  	<?=form_error('agama')?>
							</div>
							<div class="form-group <?=form_error('surel') ? 'has-error' : ''?>">
							  	<label for='surel'>Email</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='surel' name='surel' value="<?=set_value('surel', $anggota->surel)?>" placeholder="Enter email">
							  	<?=form_error('surel')?>
							</div>
							<div class="form-group <?=form_error('telepon') ? 'has-error' : ''?>">
							  	<label for='telepon'>Nomor Telp.</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='telepon' name='telepon' value="<?=set_value('telepon', $anggota->telepon)?>" placeholder="Enter phone">
							  	<?=form_error('telepon')?>
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

									echo form_dropdown('bloodgroup', $bloodgroupArray, set_value('bloodgroup', $anggota->bloodgroup),'id="bloodgroup" class="form-control"');
								?>
							  	<?=form_error('bloodgroup')?>
							</div>
							<div class="form-group <?=form_error('alamat') ? 'has-error' : ''?>">
							  	<label for='alamat'>Alamat</label> <span class="text-red">*</span>
							  	<textarea name='alamat' id='alamat' cols="30" rows="5" class="form-control" placeholder="Enter address"><?=set_value('alamat', $anggota->alamat)?></textarea>
							  	<?=form_error('alamat')?>
							</div>
							<div class="form-group <?=form_error('joinningdate') ? 'has-error' : ''?>">
							  	<label for="joinningdate">Tanggal Daftar</label> <span class="text-red">*</span>
								<?php $joinningdate = isset($anggota->joinningdate) ? date('d-m-Y',strtotime($anggota->joinningdate)) : ''?>
							  	<input type="text" class="form-control datepicker" id="joinningdate" name="joinningdate" value="<?=set_value('joinningdate', $joinningdate)?>" placeholder="Enter joinning of date">
							  	<?=form_error('joinningdate')?>
							</div>
							<div class="form-group <?=form_error('foto') ? 'has-error' : ''?>">
						        <label for='foto'>Foto</label>
						        <div class="input-group image-preview">
						            <input type="text" class="form-control image-preview-filename" disabled="disabled">
						            <span class="input-group-btn">
						                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
						                    <span class="fa fa-remove"></span>Clear
						                </button>
						                <div class="btn btn-success image-preview-input">
						                    <span class="fa fa-repeat"></span>
						                    <span class="image-preview-input-title">Browse</span>
						                    <input type='file' accept="image/png, image/jpeg, image/gif" name='foto'/>
						                </div>
						            </span>
						        </div>
						        <div class="input-group">
						        	<img class="userprofileimg" src="<?=profile_img($anggota->foto)?>" alt="">
						        </div>
						      	<?=form_error('foto');?>
						    </div>
							<div class="form-group <?=form_error('id_peran') ? 'has-error' : ''?>">
							  	<label for='id_peran'>Hak Akses</label> <span class="text-red">*</span>
								<?php 
									$roleArray[0] = 'Silakan Pilih';
									if(calculate($roles)) {
									  foreach ($roles as $peran) {
									    $roleArray[$peran->id_peran] = $peran->peran;
									  }
									}
									echo form_dropdown('id_peran', $roleArray,set_value('id_peran', $anggota->id_peran),'id='id_peran' class="form-control"');
								?>
								<?=form_error('id_peran')?>
							</div>
							<div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
							  	<label for='status'>Status</label> <span class="text-red">*</span>
							  	<?php 
									$statusArray[0] = 'Silakan Pilih';
									$statusArray[1] = 'Aktif';
									$statusArray[2] = 'Non Aktif';

									echo form_dropdown('status', $statusArray, set_value('status', $anggota->status),'id='status' class="form-control"');
								?>
							  	<?=form_error('status')?>
							</div>
							<div class="form-group <?=form_error('nama_pengguna') ? 'has-error' : ''?>">
							  	<label for='nama_pengguna'>Username</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id='nama_pengguna' name='nama_pengguna' value="<?=set_value('nama_pengguna', $anggota->nama_pengguna)?>" placeholder="Enter username">
							  	<?=form_error('nama_pengguna')?>
							</div>
							<div class="form-group <?=form_error('kata_sandi') ? 'has-error' : ''?>">
							  	<label for='kata_sandi'>Password</label>
							  	<div class="input-group">
							    	<input type='kata_sandi' class="form-control" id='kata_sandi' name='kata_sandi' value="<?=set_value('kata_sandi')?>" placeholder="Enter Password">
							    	<span style="cursor: pointer;" class="input-group-addon" id="generate_password"><i class="fa fa-repeat"></i></span>
							    	<span style="cursor: pointer;" class="input-group-addon" id="showpassword"><i class="fa fa-eye" id="eyeicon"></i></span>
							  	</div>
							  	<?=form_error('kata_sandi')?>
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
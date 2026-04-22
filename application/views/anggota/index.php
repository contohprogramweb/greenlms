<div class="content-wrapper">
    <section class="content-header">
		<h1>Anggota</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class='aktif'>Anggota</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('member_add')) { ?>
                <div class="box-header">
                    <a href="<?=base_url('anggota/add')?>" class="btn btn-inline btn-mytheme btn-md pull-left"><i class="fa fa-plus"></i> Tambah Anggota</a>
                    <div class="col-sm-3 pull-right">
                        <select name='id_peran' id="filterRoleID" data-url="<?=base_url('anggota/index')?>" class="form-control pull-right">
                            <?php if(calculate($roles)) {
                                foreach ($roles as $roleID => $peran) { ?>
                                    <option value="<?=$roleID?>" <?=($roleID==$setroleID) ? 'selected' : ''?>><?=$peran ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Anggota</th>
                                <th>Foto</th>
                                <th>Email</th>
                                <th>Hak Akses</th>
                                <th>Nomor Telp.</th>
                                <?php if(permissionChecker('member_view') || permissionChecker('member_edit') || permissionChecker('member_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($members)) { $i=0; foreach($members as $anggota) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Nama Anggota"><?=$anggota->nama?></td>
                                    <td data-title="Foto"><img src="<?=profile_img($anggota->foto)?>" class="profile_img" alt=""></td>
                                    <td data-title="Email"><?=$anggota->surel?></td>
                                    <td data-title="Hak Akses"><?=isset($roles[$anggota->id_peran]) ? $roles[$anggota->id_peran] : ''?></td>
                                    <td data-title="Nomor Telp."><?=$anggota->telepon?></td>
                                    <?php if(permissionChecker('member_view') || permissionChecker('member_edit') || permissionChecker('member_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('anggota/view/'.$anggota->id_anggota,'Lihat'); ?>
                                            <?=btn_edit('anggota/edit/'.$anggota->id_anggota,'Edit'); ?>
                                            <?=btn_delete('anggota/delete/'.$anggota->id_anggota,'Delete'); ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Anggota</th>
                                <th>Foto</th>
                                <th>Email</th>
                                <th>Hak Akses</th>
                                <th>Nomor Telp.</th>
                                <?php if(permissionChecker('member_view') || permissionChecker('member_edit') || permissionChecker('member_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
          </div>
    </section>
</div>
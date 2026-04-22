<div class="content-wrapper">
    <section class="content-header">
		<h1>Anggota</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class="active">Anggota</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('member_add')) { ?>
                <div class="box-header">
                    <a href="<?=base_url('member/add')?>" class="btn btn-inline btn-mytheme btn-md pull-left"><i class="fa fa-plus"></i> Tambah Anggota</a>
                    <div class="col-sm-3 pull-right">
                        <select name="roleID" id="filterRoleID" data-url="<?=base_url('member/index')?>" class="form-control pull-right">
                            <?php if(calculate($roles)) {
                                foreach ($roles as $roleID => $role) { ?>
                                    <option value="<?=$roleID?>" <?=($roleID==$setroleID) ? 'selected' : ''?>><?=$role ?></option>
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
                            <?php if(calculate($members)) { $i=0; foreach($members as $member) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Nama Anggota"><?=$member->name?></td>
                                    <td data-title="Foto"><img src="<?=profile_img($member->photo)?>" class="profile_img" alt=""></td>
                                    <td data-title="Email"><?=$member->email?></td>
                                    <td data-title="Hak Akses"><?=isset($roles[$member->roleID]) ? $roles[$member->roleID] : ''?></td>
                                    <td data-title="Nomor Telp."><?=$member->phone?></td>
                                    <?php if(permissionChecker('member_view') || permissionChecker('member_edit') || permissionChecker('member_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('member/view/'.$member->memberID,'Lihat'); ?>
                                            <?=btn_edit('member/edit/'.$member->memberID,'Edit'); ?>
                                            <?=btn_delete('member/delete/'.$member->memberID,'Delete'); ?>
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
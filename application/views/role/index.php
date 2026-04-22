<div class="content-wrapper">
    <section class="content-header">
		<h1>Hak Akses</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Hak Akses</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('role_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('role/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i>Tambah Hak Akses</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hak Akses</th>
                                <th>Tanggal Buat</th>
                                <?php if(permissionChecker('role_edit') || permissionChecker('role_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(calculate($roles)) { $i=0; foreach($roles as $role) { $i++; ?>
                            <tr>
                                <td data-title="#"><?=$i?></td>
                                <td data-title="Hak Akses"><?=$role->role?></td>
                                <td data-title="Tanggal Buat"><?=app_date($role->create_date)?></td>
                                <?php if(permissionChecker('role_edit') || permissionChecker('role_delete')) { ?>
                                    <td data-title="Aksi">
                                        <?=btn_edit('role/edit/'.$role->roleID, 'Edit')?>
                                        <?=btn_delete('role/delete/'.$role->roleID, 'Delete')?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Hak Akses</th>
                                <th>Tanggal Buat</th>
                                <?php if(permissionChecker('role_edit') || permissionChecker('role_delete')) { ?>
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
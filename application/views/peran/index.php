<div class="content-wrapper">
    <section class="content-header">
		<h1>Hak Akses</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Hak Akses</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('role_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('peran/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i>Tambah Hak Akses</a>
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
                        <?php if(calculate($roles)) { $i=0; foreach($roles as $peran) { $i++; ?>
                            <tr>
                                <td data-title="#"><?=$i?></td>
                                <td data-title="Hak Akses"><?=$peran->peran?></td>
                                <td data-title="Tanggal Buat"><?=app_date($peran->tanggal_dibuat)?></td>
                                <?php if(permissionChecker('role_edit') || permissionChecker('role_delete')) { ?>
                                    <td data-title="Aksi">
                                        <?=btn_edit('peran/edit/'.$peran->id_peran, 'Edit')?>
                                        <?=btn_delete('peran/delete/'.$peran->id_peran, 'Delete')?>
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
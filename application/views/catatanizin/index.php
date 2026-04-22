<div class="content-wrapper">
    <section class="content-header">
		<h1>Log Izin</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class='aktif'>Log Izin</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('permissionlog_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('catatan_izin/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Log Izin</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Log</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <?php if(permissionChecker('permissionlog_edit') || permissionChecker('permissionlog_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $i=0; if(calculate($permissionlogs)) { foreach($permissionlogs as $catatan_izin) { $i++; ?>
                            <tr>
                                <td data-title="#"><?=$i?></td>
                                <td data-title="Nama Log"><?=$catatan_izin->nama?></td>
                                <td data-title="Deskripsi"><?=$catatan_izin->deskripsi?></td>
                                <td data-title="Status"><?=$catatan_izin->aktif?></td>
                                <?php if(permissionChecker('permissionlog_edit') || permissionChecker('permissionlog_delete')) { ?>
                                    <td data-title="Aksi">
                                        <?=btn_edit('catatan_izin/edit/'.$catatan_izin->permissionlogID, 'Edit')?>
                                        <?=btn_delete('catatan_izin/delete/'.$catatan_izin->permissionlogID, 'Delete')?>
                                    </td>
                                <?php } ?>
                            </tr>
                          <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Log</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <?php if(permissionChecker('permissionlog_edit') || permissionChecker('permissionlog_delete')) { ?>
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
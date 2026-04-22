<div class="content-wrapper">
    <section class="content-header">
		<h1>Template Email</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Template Email</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('emailtemplate_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('templat_surel/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Template Email </a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <?php if(permissionChecker('emailtemplate_edit') || permissionChecker('emailtemplate_delete')) { ?>
                                <th>Aksi</th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($emailtemplates)) { $i=0; foreach($emailtemplates as $templat_surel) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Nama"><?=$templat_surel->nama?></td>
                                    <td data-title="Status"><?=status_button($templat_surel->status)?></td>
                                    <?php if(permissionChecker('emailtemplate_edit') || permissionChecker('emailtemplate_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('templat_surel/view/'.$templat_surel->emailtemplateID, 'Lihat')?>
                                            <?=btn_edit('templat_surel/edit/'.$templat_surel->emailtemplateID, 'Edit')?>
                                            <?=btn_delete('templat_surel/delete/'.$templat_surel->emailtemplateID, 'Delete')?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <?php if(permissionChecker('emailtemplate_edit') || permissionChecker('emailtemplate_delete')) { ?>
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
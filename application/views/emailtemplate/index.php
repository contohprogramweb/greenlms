<div class="content-wrapper">
    <section class="content-header">
		<h1>Template Email</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Template Email</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('emailtemplate_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('emailtemplate/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Template Email </a>
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
                            <?php if(calculate($emailtemplates)) { $i=0; foreach($emailtemplates as $emailtemplate) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Nama"><?=$emailtemplate->name?></td>
                                    <td data-title="Status"><?=status_button($emailtemplate->status)?></td>
                                    <?php if(permissionChecker('emailtemplate_edit') || permissionChecker('emailtemplate_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('emailtemplate/view/'.$emailtemplate->emailtemplateID, 'Lihat')?>
                                            <?=btn_edit('emailtemplate/edit/'.$emailtemplate->emailtemplateID, 'Edit')?>
                                            <?=btn_delete('emailtemplate/delete/'.$emailtemplate->emailtemplateID, 'Delete')?>
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
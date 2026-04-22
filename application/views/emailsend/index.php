<div class="content-wrapper">
    <section class="content-header">
		<h1>Kirim Email</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Kirim Email</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('emailsend_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('kirim_email/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah/Kirim Email</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Email</th>
                            <th>Hak Akses</th>
                            <?php if(permissionChecker('emailsend_view') || permissionChecker('emailsend_delete')) { ?>
                                <th>Aksi</th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($emailsends)) { $i=0; foreach($emailsends as $kirim_email) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Judul Email"><?=$kirim_email->subjek?></td>
                                    <td data-title="Hak Akses"><?=isset($roles[$kirim_email->sender_roleID]) ? $roles[$kirim_email->sender_roleID] : 'tamu' ?></td>
                                    <?php if(permissionChecker('emailsend_view') || permissionChecker('emailsend_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('kirim_email/view/'.$kirim_email->emailsendID, 'Lihat')?>
                                            <?=btn_delete('kirim_email/delete/'.$kirim_email->emailsendID, 'Delete')?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Judul Email</th>
                                <th>Hak Akses</th>
                                <?php if(permissionChecker('emailsend_view') || permissionChecker('emailsend_delete')) { ?>
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
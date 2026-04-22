<div class="content-wrapper">
    <section class="content-header">
		<h1>Pengaturan Perpustakaan</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Pengaturan Perpustakaan</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('libraryconfigure_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('konfigurasi_perpustakaan/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i>  Tambah Pengaturan</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hak Akses</th>
                                <th>Max Buku Dipinjam</th>
                                <th>Max Perpanjangan</th>
                                <th>Batas Hari Perpanjangan</th>
                                <th>Denda Per Hari</th>
                                
                                <?php if(permissionChecker('libraryconfigure_edit') || permissionChecker('libraryconfigure_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(calculate($libraryconfigures)) { $i=0; foreach($libraryconfigures as $konfigurasi_perpustakaan) { $i++; ?>
                            <tr>
                                <td data-title="#" align="center"><?=$i?></td>
                                <td data-title="Hak Akses"><?=isset($roles[$konfigurasi_perpustakaan->id_peran]) ? $roles[$konfigurasi_perpustakaan->id_peran] : '&nbsp;' ?></td>
                                <td data-title="Max Buku Dipinjam" align="center"><?=$konfigurasi_perpustakaan->max_issue_book?></td>
                                <td data-title="Max Perpanjangan" align="center"><?=$konfigurasi_perpustakaan->max_renewed_limit?></td>
                                <td data-title="Batas Hari Perpanjangan" align="center"><?=$konfigurasi_perpustakaan->per_renew_limit_day?></td>
                                <td data-title="Denda Per Hari" align="center"><?=$konfigurasi_perpustakaan->book_fine_per_day?></td>
                                
                                <?php if(permissionChecker('libraryconfigure_edit') || permissionChecker('libraryconfigure_delete')) { ?>
                                    <td data-title="Aksi" align="center" width="60px">
                                        <?=btn_edit('konfigurasi_perpustakaan/edit/'.$konfigurasi_perpustakaan->libraryconfigureID, 'Edit')?>
                                        <?=btn_delete('konfigurasi_perpustakaan/delete/'.$konfigurasi_perpustakaan->libraryconfigureID, 'Delete')?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Hak Akses</th>
                                <th>Max Buku Dipinjam</th>
                                <th>Max Perpanjangan</th>
                                <th>Batas Hari Perpanjangan</th>
                                <th>Denda Per Hari</th> 
                                <?php if(permissionChecker('libraryconfigure_edit') || permissionChecker('libraryconfigure_delete')) { ?>
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
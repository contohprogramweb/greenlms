<div class="content-wrapper">
    <section class="content-header">
        <h1>Pengeluaran</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Pengeluaran</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('expense_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('pengeluaran/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pengeluaran</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>File</th>
                                <th>Catatan</th>
                                <?php if(permissionChecker('expense_view') || permissionChecker('expense_edit') || permissionChecker('expense_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($expenses)) { $i=0; foreach($expenses as $pengeluaran) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Nama Pengeluaran"><?=$pengeluaran->nama?></td>
                                    <td data-title="Tanggal"><?=app_date($pengeluaran->tanggal)?></td>
                                    <td data-title="Jumlah"><?=number_format($pengeluaran->jumlah, 2)?></td>
                                    <td data-title="File">
                                        <?php 
                                            if($pengeluaran->file != '') {
                                                echo btn_download('pengeluaran/download/'.$pengeluaran->id_pengeluaran, $pengeluaran->fileoriginalname);
                                            }
                                        ?>
                                    </td>
                                    <td data-title="Catatan"><?=$pengeluaran->catatan?></td>
                                    <?php if(permissionChecker('expense_view') || permissionChecker('expense_edit') || permissionChecker('expense_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('pengeluaran/view/'.$pengeluaran->id_pengeluaran,'Lihat'); ?>
                                            <?=btn_edit('pengeluaran/edit/'.$pengeluaran->id_pengeluaran,'Edit'); ?>
                                            <?=btn_delete('pengeluaran/delete/'.$pengeluaran->id_pengeluaran,'Delete'); ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Pengeluaran</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>File</th>
                                <th>Catatan</th>
                                <?php if(permissionChecker('expense_view') || permissionChecker('expense_edit') || permissionChecker('expense_delete')) { ?>
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
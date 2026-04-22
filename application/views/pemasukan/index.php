<div class="content-wrapper">
    <section class="content-header">
		<h1>Pendapatan</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class='aktif'>Pendapatan</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('income_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('pemasukan/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Pendapatan</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pendapatan</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>File</th>
                                <th>Catatan</th>
                                <?php if(permissionChecker('income_view') || permissionChecker('income_edit') || permissionChecker('income_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($incomes)) { $i=0; foreach($incomes as $pemasukan) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Nama Pendapatan"><?=$pemasukan->nama?></td>
                                    <td data-title="Tanggal"><?=app_date($pemasukan->tanggal)?></td>
                                    <td data-title="Jumlah"><?=number_format($pemasukan->jumlah, 2)?></td>
                                    <td data-title="File">
                                        <?php 
                                            if($pemasukan->file != '') {
                                                echo btn_download('pemasukan/download/'.$pemasukan->id_pemasukan, $pemasukan->fileoriginalname);
                                            }
                                        ?>
                                    </td>
                                    <td data-title="Catatan"><?=$pemasukan->catatan?></td>
                                    <?php if(permissionChecker('income_view') || permissionChecker('income_edit') || permissionChecker('income_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('pemasukan/view/'.$pemasukan->id_pemasukan,'Lihat'); ?>
                                            <?=btn_edit('pemasukan/edit/'.$pemasukan->id_pemasukan,'Edit'); ?>
                                            <?=btn_delete('pemasukan/delete/'.$pemasukan->id_pemasukan,'Delete'); ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Pendapatan</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>File</th>
                                <th>Catatan</th>
                                <?php if(permissionChecker('income_view') || permissionChecker('income_edit') || permissionChecker('income_delete')) { ?>
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
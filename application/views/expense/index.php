<div class="content-wrapper">
    <section class="content-header">
        <h1>Pengeluaran</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Pengeluaran</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('expense_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('expense/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Pengeluaran</a>
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
                            <?php if(calculate($expenses)) { $i=0; foreach($expenses as $expense) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Nama Pengeluaran"><?=$expense->name?></td>
                                    <td data-title="Tanggal"><?=app_date($expense->date)?></td>
                                    <td data-title="Jumlah"><?=number_format($expense->amount, 2)?></td>
                                    <td data-title="File">
                                        <?php 
                                            if($expense->file != '') {
                                                echo btn_download('expense/download/'.$expense->expenseID, $expense->fileoriginalname);
                                            }
                                        ?>
                                    </td>
                                    <td data-title="Catatan"><?=$expense->note?></td>
                                    <?php if(permissionChecker('expense_view') || permissionChecker('expense_edit') || permissionChecker('expense_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_view('expense/view/'.$expense->expenseID,'Lihat'); ?>
                                            <?=btn_edit('expense/edit/'.$expense->expenseID,'Edit'); ?>
                                            <?=btn_delete('expense/delete/'.$expense->expenseID,'Delete'); ?>
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
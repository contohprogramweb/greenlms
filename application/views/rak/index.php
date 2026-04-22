<div class="content-wrapper">
    <section class="content-header">
		<h1>Rak</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class='aktif'>Rak</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('rack_add')) { ?>
            <div class="box-header">
                <a href="<?=base_url('rak/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> Tambah Rak</a>
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Rak</th>
                                <th>Deskripsi</th>
                                <?php if(permissionChecker('rack_edit') || permissionChecker('rack_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($racks)) { $i=0; foreach($racks as $rak) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=$i?></td>
                                    <td data-title="Nama Rak"><?=$rak->nama?></td>
                                    <td data-title="Deskripsi"><?=$rak->deskripsi?></td>
                                    <?php if(permissionChecker('rack_edit') || permissionChecker('rack_delete')) { ?>
                                        <td data-title="Aksi">
                                            <?=btn_edit('rak/edit/'.$rak->rackID,'Edit'); ?>
                                            <?=btn_delete('rak/delete/'.$rak->rackID,'Delete'); ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Rak</th>
                                <th>Deskripsi</th>
                                <?php if(permissionChecker('rack_edit') || permissionChecker('rack_delete')) { ?>    
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
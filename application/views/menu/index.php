<div class="content-wrapper">
    <section class="content-header">
		<h1>Menu</h1>
		<ol class="breadcrumb">
			<li><a href="<?=base_url('/dashboard')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Menu</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <?php if(permissionChecker('menu_add')) { ?>
            <div class="box-header">
                <!-- <a href="<?=base_url('menu/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i> <?=$this->lang->line('menu_add_menu')?></a> -->
            </div>
            <?php } ?>
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Menu</th>
                                <th>Link</th>
                                <th>Icon</th>
                                <th>Prioritas</th>
                                <th>Parent Menu</th>
                                <th>Status</th>
                        </thead>
                        <tbody>
                            <?php if(calculate($menus)) { $i=0; foreach($menus as $menu) { $i++; ?>
                            <tr>
                                <td data-title="#"><?=$i?></td>
                                <td data-title="Nama Menu"><?=$menu->menuname?></td>
                                <td data-title="Link"><?=$menu->menulink?></td>
                                <td data-title="Icon"><?=$menu->menuicon?></td>
                                <td data-title="Prioritas"><?=$menu->priority?></td>
                                <td data-title="Parent Menu"><?=isset($menusName[$menu->parentmenuID]) ? ucfirst($menusName[$menu->parentmenuID]) : ''?></td>
                                <td data-title="Status"><?=status_button($menu->status)?></td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Menu</th>
                                <th>Link</th>
                                <th>Icon</th>
                                <th>Prioritas</th>
                                <th>Parent Menu</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
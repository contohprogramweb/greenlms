<div class="content-wrapper">
    <section class="content-header">
		<h1>Izin</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class='aktif'>Izin</li>
		</ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <?php if(calculate($roles)) { $i=0; foreach($roles as $peran) { $i++; ?>
                        <li <?=($urlroleID == $peran->id_peran) ? 'class='aktif'' : (($i==1 && $urlroleID == 0) ? 'class='aktif'' : '')?>><a href="#peran<?=$peran->id_peran?>" data-toggle="tab" aria-expanded="false"><?=$peran->peran?></a></li>
                    <?php } } ?>
                    </ul>
                    <div class="tab-content">
                        <?php if(calculate($roles)) { $i=0; foreach($roles as $peran) { $i++; ?>
                            <div class="tab-pane <?=($urlroleID==$peran->id_peran) ? 'aktif' : ($i==1  && $urlroleID == 0) ? 'aktif' : ''?>" id="peran<?=$peran->id_peran?>">
                                <form method="post" action="<?=base_url('/izin/save')?>">
                                    <input type="hidden" name="permissionsroleID" value="<?=$peran->id_peran?>">
                                    <div id="hide-table">
                                        <table class="table table-bordered table-striped mainpermission">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Modul</th>
                                                    <th>Tambah</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                    <th>Lihat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $j=0; if(calculate($permissionsModuleArray)) { foreach($permissionsModuleArray as $permission) { $j++; ?>
                                                    <tr>
                                                        <td data-title="#"> 
                                                            <input type="checkbox" id="<?=$permission->nama?>_<?=$peran->id_peran?>" name="<?=$permission->nama?>" value="<?=$permission->permissionlogID?>"  <?=isset($izin[$peran->id_peran][$permission->permissionlogID]) ? 'checked' : ''?> class="mainmodule"/> 
                                                        </td>
                                                        <td data-title="Nama Modul"><?=ucfirst($permission->nama)?></td>
                                                        <td data-title="Tambah">
                                                        <?php 
                                                            $permissionadd = $permission->nama.'_add';
                                                            if(isset($permissionlogsArray[$permissionadd])) { ?>
                                                                <input type="checkbox" id="<?=$permissionadd?>_<?=$peran->id_peran?>" name="<?=$permissionadd?>" value="<?=$permissionlogsArray[$permissionadd]?>" <?=isset($izin[$peran->id_peran][$permissionlogsArray[$permissionadd]]) ? 'checked' : ''?> />
                                                        <?php } else {
                                                            echo "&nbsp;";
                                                        } ?>
                                                        </td>
                                                        <td data-title="Edit">
                                                        <?php 
                                                            $permissionedit = $permission->nama.'_edit';
                                                            if(isset($permissionlogsArray[$permissionedit])) { ?>
                                                                <input type="checkbox" id="<?=$permissionedit?>_<?=$peran->id_peran?>" name="<?=$permissionedit?>" value="<?=$permissionlogsArray[$permissionedit]?>" <?=isset($izin[$peran->id_peran][$permissionlogsArray[$permissionedit]]) ? 'checked' : ''?> />
                                                        <?php } else {
                                                            echo "&nbsp;";
                                                        } ?>
                                                        </td>
                                                        <td data-title="Delete">
                                                        <?php 
                                                            $permissiondelete = $permission->nama.'_delete';
                                                            if(isset($permissionlogsArray[$permissiondelete])) { ?>
                                                                <input type="checkbox" id="<?=$permissiondelete?>_<?=$peran->id_peran?>" name="<?=$permissiondelete?>" value="<?=$permissionlogsArray[$permissiondelete]?>" <?=isset($izin[$peran->id_peran][$permissionlogsArray[$permissiondelete]]) ? 'checked' : ''?> />
                                                        <?php } else {
                                                            echo "&nbsp;";
                                                        } ?>
                                                        </td>
                                                        <td data-title="Lihat">
                                                        <?php 
                                                            $permissionview = $permission->nama.'_view';
                                                            if(isset($permissionlogsArray[$permissionview])) { ?>
                                                                <input type="checkbox" id="<?=$permissionview?>_<?=$peran->id_peran?>" name="<?=$permissionview?>" value="<?=$permissionlogsArray[$permissionview]?>" <?=isset($izin[$peran->id_peran][$permissionlogsArray[$permissionview]]) ? 'checked' : ''?> />
                                                        <?php } else {
                                                            echo "&nbsp;";
                                                        } ?>
                                                        </td>
                                                    </tr>
                                                <?php } } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Modul</th>
                                                    <th>Tambah</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                    <th>Lihat</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <button class="btn btn-large btn-mytheme">Simpan <span class="text-bold bg-black" style="padding: 2px 5px; border-radius: 5px;"><?=$peran->peran?></span></button>
                                </form>
                            </div>
                        <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
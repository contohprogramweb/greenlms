<div class="content-wrapper">
    <section class="content-header">
        <h1>Peminjaman Buku</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Peminjaman Buku</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="row">
                <div class="bookissuesearchbox">
                    <?php if(permissionChecker('bookissue_add')) { ?>
                    <div class="col-sm-2 col-sm-offset-3">
                        <div class="box-header">
                            <a href="<?=base_url('peminjaman_buku/add')?>" class="btn btn-inline btn-mytheme btn-md"><i class="fa fa-plus"></i>  Tambah Buku Dipinjam </a> 
                        </div>
                    </div> 
                    <?php } ?>
                    <div class="col-sm-4 <?=!(permissionChecker('bookissue_add')) ? 'col-sm-offset-4' : ''?>">
                        <div class="box-body">
                            <form method="POST" action="<?=base_url('peminjaman_buku/index')?>">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?=set_value('id_anggota', $memberID)?>" name='id_anggota' placeholder="Filter By Anggota ID">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search-plus" aria-hidden="true"></i> Cari Buku</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-mytheme">
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomor Anggota</th>
                                <th>Nama Anggota</th>
                                <th>Kategori</th>
                                <th>Judul Buku</th>
                                <th>Nomor Buku</th>
                                <th>Status</th>
                                <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($bookissues)) { $i=0; foreach($bookissues as $peminjaman_buku) { $i++; ?>
                            <tr>
                                <td data-title="#"><?=$i?></td>
                                <td data-title="Nomor Anggota"><?=$peminjaman_buku->id_anggota?></td>
                                <td data-title="Nama Anggota"><?=isset($members[$peminjaman_buku->id_anggota]) ? $members[$peminjaman_buku->id_anggota] : ''?></td>
                                <td data-title="Kategori"><?=isset($kategori_buku[$peminjaman_buku->bookcategoryID]) ? $kategori_buku[$peminjaman_buku->bookcategoryID] : 'Uncategorized'?></td>
                                <td data-title="Judul Buku"><?=isset($buku[$peminjaman_buku->id_buku]) ? $buku[$peminjaman_buku->id_buku] : ''?></td>
                                <td data-title="Nomor Buku"><?=$peminjaman_buku->bookno?></td>
                                <td data-title="Status Buku">
                                    <span class="text-bold text-success">
                                        <?php 
                                            if($peminjaman_buku->status == 0) {
                                                echo 'Dipinjam';              
                                            } elseif ($peminjaman_buku->status == 1) {
                                                echo 'Kembali';              
                                            } elseif ($peminjaman_buku->status == 2) {
                                                echo 'Hilang';
                                            }
                                        ?>
                                    </span>
                                </td>
                                
                                <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
                                <td data-title="Aksi">
                                    <?=btn_view('peminjaman_buku/view/'.$peminjaman_buku->bookissueID,'Lihat'); ?>
                                    <?php if(($peminjaman_buku->status == 0) && ($peminjaman_buku->dihapus_pada == 0) && ($peminjaman_buku->diperbarui == 1)) { 
                                        echo btn_edit('peminjaman_buku/edit/'.$peminjaman_buku->bookissueID, 'Edit'). " ";
                                        echo btn_delete('peminjaman_buku/delete/'.$peminjaman_buku->bookissueID, 'Delete');
                                    } ?>
                            
                                    <?php if($peminjaman_buku->status == 0) { ?>
                                        <a href="<?=base_url('peminjaman_buku/renewandreturn/'.$peminjaman_buku->bookissueID)?>" class="btn btn-info btn-xs mrg" data-placement="auto" data-toggle="tooltip" data-original-title="Perpanjang atau Kembalikan"><i class="fa fa-retweet"></i></a>
                                    <?php } ?>
    
                                    <?php if(permissionChecker('bookissue_add') && ($peminjaman_buku->paidstatus != 2) && ($peminjaman_buku->fineamount > 0)) { ?>
                                        <span data-toggle="tooltip" data-original-title="Pembayaran"><button class="btn btn-mytheme btn-xs mrg paymentamount" data-bookissueid="<?=$peminjaman_buku->bookissueID?>" data-placement="auto" data-toggle="modal" data-target="#paymentmodal"><i class="fa fa-money"></i></button></span>
                                    <?php } ?>
                                    
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nomor Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Kategori</th>
                            <th>Judul Buku</th>
                            <th>Nomor Buku</th>
                            <th>Status</th>
                            <?php if(permissionChecker('bookissue_view') || permissionChecker('bookissue_edit') || permissionChecker('bookissue_delete')) { ?>
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
<?php if(permissionChecker('bookissue_add')) { ?>
    <div class="modal fade" id="paymentmodal" tabindex="-1" peran="dialog" aria-labelledby="paymentmodaltitle">
        <div class="modal-dialog" peran="document">
            <div class="modal-content">
                <form method="POST" id="paymentform">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="paymentmodaltitle">Tambah Pembayaran</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" id="paymentamounterrorDiv">
                                    <label for="paymentamount">Jumlah Bayar</label> <span class="text-red">*</span>
                                    <input type="text" class="form-control" data-paymentamount="0" id="paymentamount" name="paymentamount">
                                    <span class="help-block totalfineamount" style="color: #a94442"></span>
                                    <span id="paymentamounterror"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" id="discountamounterrorDiv">
                                    <label for="discountamount">Diskon</label> <span class="text-red">*</span>
                                    <input type="text" class="form-control" id="discountamount" name="discountamount">
                                    <span id="discountamounterror"></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" id="noteserrorDiv">
                                    <label for="notes">Catatan</label>
                                    <textarea class="form-control" name="notes" id="notes" cols="30" rows="3"></textarea>
                                    <span id="noteserror"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submite" class="btn btn-mytheme submitpaymentamount">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
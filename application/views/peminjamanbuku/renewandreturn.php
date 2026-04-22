<div class="content-wrapper">
    <section class="content-header">
  		<h1>Peminjaman Buku</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('peminjaman_buku/index')?>">Peminjaman Buku</a></li>
  			<li class='aktif'>Perpanjangan</li>
  		</ol>
    </section>
    <section class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="box box-mytheme">
					<form peran="form" method="post" enctype="multipart/form-data">
						<div class="box-body">
							<div class="form-group <?=form_error('bookstatusID') ? 'has-error' : ''?>">
							  	<label for="bookstatusID">Status</label> <span class="text-red">*</span>
								<?php 
									$statusArray[0] = 'Silakan Pilih';
									$statusArray[1] = 'Perpanjang';
									$statusArray[2] = 'Kembalikan';
									$statusArray[3] = 'Hilang';
									echo form_dropdown('bookstatusID', $statusArray, set_value('bookstatusID'),' id="bookstatusID" class="form-control"');
								?>
								<?=form_error('bookstatusID')?>
							</div>
							<div class="form-group <?=form_error('fineamount') ? 'has-error' : ''?>">
								<label for="fineamount">Total Denda</label> <span class="text-red">*</span>
							  	<input type="text" class="form-control" id="fineamount" name="fineamount" value="<?=set_value('fineamount')?>" placeholder="Enter fine amount">
							  	<span class="help-block lostbookerror" style="color: #a94442"></span>
							  	<?=form_error('fineamount')?>
							</div>
							<div class="form-group <?=form_error('notes') ? 'has-error' : ''?>">
							  	<label for="notes">Catatan</label>
							  	<textarea name="notes"  id="notes" cols="30" rows="5" class="form-control" placeholder="Enter Notes"><?=set_value('notes')?></textarea>
							  	<?=form_error('notes')?>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-mytheme">Simpan</button>
						</div>
					</form>
				</div>
				<div class="box box-mytheme">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="<?=profile_img($anggota->foto)?>" alt="<?=$anggota->nama?> profile picture">
                        <h3 class="profile-username text-center"><?=$anggota->nama?></h3>
                        <p class="text-muted text-center"><?=calculate($peran) ? $peran->peran : ''?></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Jenis Kelamin</b> <span class="pull-right"><?=$anggota->jenis_kelamin?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Nomor Telp.</b> <span class="pull-right"><?=$anggota->telepon?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <span class="pull-right"><?=$anggota->surel?></span>
                            </li>
                        </ul>
                    </div>
                </div>
			</div>

			<div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    	<?php if(calculate($riwayat_denda)) { ?>
                        	<li class='aktif'><a href="#renewhistory" data-toggle="tab">History Perpanjangan</a></li>
                       	<?php } ?>
                        <li class="<?=calculate($riwayat_denda) ? '' : 'aktif'?>"><a href="#peminjaman_buku" data-toggle="tab">Buku Dipinjam</a></li>
                        <li><a href="#paymentinformation" data-toggle="tab">Informasi Pembayaran</a></li>
                    </ul>
                    <div class="tab-content">
                    	<?php if(calculate($riwayat_denda)) { ?>
	                        <div class="active tab-pane" id="renewhistory">
	                        	<div class="row">
	                        		<div class="col-md-12">
	                        			<h3 style="margin-top: 0px">History Perpanjangan </h3>
										<div id="hide-table">
						                    <table id="example1" class="table table-bordered table-striped">
						                        <thead>
						                            <tr>
						                                <th>#</th>
						                                <th>Status</th>
						                                <th>Peminjaman</th>
						                                <th>Total Denda</th>
						                            </tr>
						                        </thead>
						                        <tbody>
						                            <?php if(calculate($riwayat_denda)) { $i=0; foreach($riwayat_denda as $fine) { $i++; ?>
						                                <tr>
						                                    <td data-title="#"><?=$i?></td>
						                                    <td data-title="Status">
						                                    	<?php 
						                                    		if($fine->bookstatusID == 0) {
						                                    			echo 'Dipinjam';
						                                    		} else if($fine->bookstatusID == 1) {
						                                    			echo 'Kembali';
						                                    		} else if($fine->bookstatusID == 2) {
						                                    			echo 'Hilang';
						                                    		}
						                                    	?>		
						                                    </td>
						                                    <td data-title="Perpanjangan">#<?=$fine->diperbarui?></td>
						                                    <td data-title="Total Denda"><?=$fine->fineamount?></td>
						                                </tr>
						                            <?php } } ?>
						                        </tbody>
						                        <tfoot>
						                            <tr>
						                                <th>#</th>
						                                <th>Status</th>
						                                <th>Peminjaman</th>
						                                <th>Total Denda</th>
						                            </tr>
						                        </tfoot>
						                    </table>
						                </div>
	                        		</div>
	                        	</div>
	                        </div>
                    	<?php } ?>
                        <div class="<?=calculate($riwayat_denda) ? '' : 'aktif'?> tab-pane" id='peminjaman_buku'>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 style="margin-top: 10px">Informasi Buku Dipinjam :</h3>
                                    <div class="profile_view_item">
                                        <p><b>Judul Buku</b> : <?=calculate($buku) ? $buku->nama : ''?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Kode Buku</b> : <?=calculate($buku) ? $buku->codeno : ''?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Nomor Buku</b> : <?=$peminjaman_buku->bookno?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Status</b>:
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
                                        </p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Tanggal Pinjam</b>: <?=app_date($peminjaman_buku->issue_date)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Tanggal Harus Kembali</b>: <?=app_date($peminjaman_buku->expire_date)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Perpanjangan</b>: <?=$peminjaman_buku->diperbarui." / ".$peminjaman_buku->max_renewed_limit?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Denda Per Hari</b>: <?=$peminjaman_buku->book_fine_per_day?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Total Denda</b>: <?=number_format($peminjaman_buku->fineamount, 2)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Diskon</b>: <?=number_format($peminjaman_buku->discountamount, 2)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Jumlah Bayar</b>: <?=number_format($peminjaman_buku->paymentamount, 2)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Total Tagihan</b>: 
                                            <?php
                                                $totaldueamount = $peminjaman_buku->fineamount - ($peminjaman_buku->paymentamount + $peminjaman_buku->discountamount);
                                                echo number_format($totaldueamount, 2);
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="paymentinformation">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 style="margin-top: 0px">Informasi Pembayaran </h3>
                                    <?php if(calculate($paymentanddiscounts)) { ?>
                                        <div id="hide-table">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal Pinjam</th>
                                                        <th>Jumlah Bayar</th>
                                                        <th>Diskon</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=0; foreach($paymentanddiscounts as $pembayaran_dan_diskon) { $i++; ?>
                                                        <tr>
                                                            <td data-title="#"><?=$i?></td>
                                                            <td data-title="Tanggal Pinjam">
                                                                <?=app_date($pembayaran_dan_diskon->tanggal_dibuat)?>
                                                            </td>
                                                            <td data-title="Jumlah Bayar"><?=number_format($pembayaran_dan_diskon->paymentamount, 2)?></td>
                                                            <td data-title="Diskon"><?=number_format($pembayaran_dan_diskon->discountamount, 2)?></td>
                                                        </tr>
                                                        <?php if($pembayaran_dan_diskon->notes) { ?>
                                                        <tr>
                                                            <td class="text-bold">Catatan</td>
                                                            <td colspan="3" data-title="Catatan"><?=$pembayaran_dan_diskon->notes?></td>
                                                        </tr>
                                                    <?php } } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Tanggal Pinjam</th>
                                                        <th>Jumlah Bayar</th>
                                                        <th>Diskon</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <p class="text-danger">Pembayaran tidak ditemukan.</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
    </section>
</div>

<script type="text/javascript">
    var bookissueID  = "<?=$peminjaman_buku->bookissueID?>";
</script>
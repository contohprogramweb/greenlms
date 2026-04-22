<div class="content-wrapper">
    <section class="content-header">
  		<h1>Peminjaman Buku</h1>
  		<ol class="breadcrumb">
        	<li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('bookissue/index')?>">Peminjaman Buku</a></li>
  			<li class="active">Perpanjangan</li>
  		</ol>
    </section>
    <section class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="box box-mytheme">
					<form role="form" method="post" enctype="multipart/form-data">
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
                        <img class="profile-user-img img-responsive img-circle" src="<?=profile_img($member->photo)?>" alt="<?=$member->name?> profile picture">
                        <h3 class="profile-username text-center"><?=$member->name?></h3>
                        <p class="text-muted text-center"><?=calculate($role) ? $role->role : ''?></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Jenis Kelamin</b> <span class="pull-right"><?=$member->gender?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Nomor Telp.</b> <span class="pull-right"><?=$member->phone?></span>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <span class="pull-right"><?=$member->email?></span>
                            </li>
                        </ul>
                    </div>
                </div>
			</div>

			<div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    	<?php if(calculate($finehistory)) { ?>
                        	<li class="active"><a href="#renewhistory" data-toggle="tab">History Perpanjangan</a></li>
                       	<?php } ?>
                        <li class="<?=calculate($finehistory) ? '' : 'active'?>"><a href="#bookissue" data-toggle="tab">Buku Dipinjam</a></li>
                        <li><a href="#paymentinformation" data-toggle="tab">Informasi Pembayaran</a></li>
                    </ul>
                    <div class="tab-content">
                    	<?php if(calculate($finehistory)) { ?>
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
						                            <?php if(calculate($finehistory)) { $i=0; foreach($finehistory as $fine) { $i++; ?>
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
						                                    <td data-title="Perpanjangan">#<?=$fine->renewed?></td>
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
                        <div class="<?=calculate($finehistory) ? '' : 'active'?> tab-pane" id="bookissue">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 style="margin-top: 10px">Informasi Buku Dipinjam :</h3>
                                    <div class="profile_view_item">
                                        <p><b>Judul Buku</b> : <?=calculate($book) ? $book->name : ''?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Kode Buku</b> : <?=calculate($book) ? $book->codeno : ''?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Nomor Buku</b> : <?=$bookissue->bookno?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Status</b>:
                                            <span class="text-bold text-success">
                                                <?php 
                                                    if($bookissue->status == 0) {
                                                        echo 'Dipinjam';              
                                                    } elseif ($bookissue->status == 1) {
                                                        echo 'Kembali';              
                                                    } elseif ($bookissue->status == 2) {
                                                        echo 'Hilang';
                                                    }
                                                ?>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Tanggal Pinjam</b>: <?=app_date($bookissue->issue_date)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Tanggal Harus Kembali</b>: <?=app_date($bookissue->expire_date)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Perpanjangan</b>: <?=$bookissue->renewed." / ".$bookissue->max_renewed_limit?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Denda Per Hari</b>: <?=$bookissue->book_fine_per_day?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Total Denda</b>: <?=number_format($bookissue->fineamount, 2)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Diskon</b>: <?=number_format($bookissue->discountamount, 2)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Jumlah Bayar</b>: <?=number_format($bookissue->paymentamount, 2)?></p>
                                    </div>
                                    <div class="profile_view_item">
                                        <p><b>Total Tagihan</b>: 
                                            <?php
                                                $totaldueamount = $bookissue->fineamount - ($bookissue->paymentamount + $bookissue->discountamount);
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
                                                    <?php $i=0; foreach($paymentanddiscounts as $paymentanddiscount) { $i++; ?>
                                                        <tr>
                                                            <td data-title="#"><?=$i?></td>
                                                            <td data-title="Tanggal Pinjam">
                                                                <?=app_date($paymentanddiscount->create_date)?>
                                                            </td>
                                                            <td data-title="Jumlah Bayar"><?=number_format($paymentanddiscount->paymentamount, 2)?></td>
                                                            <td data-title="Diskon"><?=number_format($paymentanddiscount->discountamount, 2)?></td>
                                                        </tr>
                                                        <?php if($paymentanddiscount->notes) { ?>
                                                        <tr>
                                                            <td class="text-bold">Catatan</td>
                                                            <td colspan="3" data-title="Catatan"><?=$paymentanddiscount->notes?></td>
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
    var bookissueID  = "<?=$bookissue->bookissueID?>";
</script>
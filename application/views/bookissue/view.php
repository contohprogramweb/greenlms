<div class="content-wrapper">
    <section class="content-header">
        <h1>Peminjaman Buku</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?=base_url('bookissue/index')?>">Peminjaman Buku</a></li>
            <li>Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
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
                        <li class="active"><a href="#bookissue" data-toggle="tab">Buku Dipinjam</a></li>
                        <li><a href="#renewhistory" data-toggle="tab">History Perpanjangan</a></li>
                        <li><a href="#paymentinformation" data-toggle="tab">Informasi Pembayaran</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="bookissue">
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
                        <div class="tab-pane" id="renewhistory">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 style="margin-top: 0px">History Perpanjangan </h3>
                                    <?php if(calculate($finehistory)) { ?>
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
                                                            <td data-title="#" align="center"><?=$i?></td>
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
                                                            <td data-title="Perpanjangan" align="center">#<?=$fine->renewed?></td>
                                                            <td data-title="Total Denda" align="center"><?=$fine->fineamount?></td>
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
                                    <?php } ?>
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
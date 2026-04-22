<div class="content-wrapper">
    <section class="content-header">
		<h1>Pesanan</h1>
		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class="active">Pesanan</li>
		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <div id="hide-table">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pesanan</th>
                                <th>Tanggal Buat</th>
                                <th>Status Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th>Total Pesanan</th>
                                <?php if(permissionChecker('order_view')) { ?>    
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(calculate($orders)) { $i=0; foreach($orders as $order) { $i++; ?>
                                <tr>
                                    <td data-title="#"><?=sprintf("%08d", $order->orderID);?></td>
                                    <td data-title="Nama Pesanan"><?=$order->name?></td>
                                    <td data-title="Tanggal Buat"><?=app_date($order->create_date)?></td>
                                    <td data-title="Status Pembayaran"><?=orderPamentStatus($order->payment_status)?></td>
                                    <td data-title="Status Pesanan"><?=orderStatus($order->status)?></td>
                                    <td data-title="Total Pesanan"><?=$order->total?></td>
                                    <?php if(permissionChecker('order_view')) { ?>    
                                        <td data-title="Aksi">
                                            <?=btn_view('order/view/'.$order->orderID,'Lihat'); ?>
                                            <?php 
                                                if($order->status != 30) {
                                                    echo btn_edit('order/edit/'.$order->orderID,'Edit'). ' '; 
                                                }

                                                if(($order->payment_status != 15) && ($order->status != 10 || $order->status != 15)) {
                                                    echo btn_payment_show('order/payment/'.$order->orderID,'Bayar'); 
                                                }
                                            ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama Pesanan</th>
                                <th>Tanggal Buat</th>
                                <th>Status Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th>Total Pesanan</th>
                                <?php if(permissionChecker('order_view')) { ?>    
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
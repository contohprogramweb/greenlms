<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Data Transaksi</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Laporan Data Transaksi</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <form method="POST" action="<?=base_url('Laporantransaksi/index')?>">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('reportfor') ? 'has-error' : ''?>">
                                <label>Jenis Laporan </label><span class="text-danger"> *</span>
                                <?php 
                                    $reportArray[0]   = 'Silakan Pilih';
                                    $reportArray[1]   = 'Pendapatan';
                                    $reportArray[2]   = 'Pengeluaran';
                                    $reportArray[3]   = 'Penagihan';
                                    $reportArray[4]   = 'Denda';
                                    $reportArray[5]   = 'Diskon';
                                    $reportArray[6]   = 'Keterlambatan';
                                    echo form_dropdown('reportfor', $reportArray, set_value('reportfor'),'id="reportfor" class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('id_peran') ? 'has-error' : ''?>">
                                <label>Hak Akses</label>
                                <?php 
                                    $roleArray[0]   = 'Silakan Pilih';
                                    if(calculate($roles)) {
                                        foreach($roles as $peran) {
                                            $roleArray[$peran->id_peran] = $peran->peran;
                                        }
                                    }
                                    echo form_dropdown('id_peran', $roleArray, set_value('id_peran'),'id='id_peran' class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('id_anggota') ? 'has-error' : ''?>">
                                <label>Anggota</label>
                                <?php 
                                    $memberArray[0]   = 'Silakan Pilih';
                                    if(calculate($members)) {
                                        foreach($members as $anggota) {
                                            $memberArray[$anggota->id_anggota] = $anggota->nama;
                                        }
                                    }
                                    echo form_dropdown('id_anggota', $memberArray, set_value('id_anggota'),'id='id_anggota' class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('fromdate') ? 'has-error' : ''?>">
                                <label>Dari Tanggal</label>
                                <input type="text" class="form-control datepicker" name="fromdate" value="<?=set_value('fromdate')?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('todate') ? 'has-error' : ''?>">
                                <label>Sampai Tanggal</label>
                                <input type="text" class="form-control datepicker" name="todate" value="<?=set_value('todate')?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <button class="btn btn-mytheme" style="margin-top: 25px">Tampilkan</button>
                                <?php if($flag) { ?>
                                    <button class="btn btn-mytheme" onclick="printDiv()" style="margin-top: 25px">Cetak</button>
                                    <a href="<?=base_url('Laporantransaksi/pdf/'.$reportfor.'/'.$roleID.'/'.$memberID.'/'.$fromdate.'/'.$todate)?>" class="btn btn-mytheme" style="margin-top: 25px" target="_blank">PDF</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if($flag) { ?>
            <div class="box box-mytheme">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12" id="printDiv">
                            <?php $this->load->view('laporan/transaction/view')?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
</div>

<script type="text/javascript">

    var globalreportfor = "<?=$reportfor?>"; 

    function printDiv() {
        var oldPage  = document.body.innerHTML;
        var printDiv = document.getElementById('printDiv').innerHTML;
        document.body.innerHTML = '<html><head><title>'+document.title+'</title></head><body>'+printDiv+'</body></html>';
        window.print();
        document.body.innerHTML = oldPage;
        window.location.reload();
    }
   
</script>
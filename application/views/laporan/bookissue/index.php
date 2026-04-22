<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Data Buku Dipinjam</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('Dasbor/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Laporan Data Buku Dipinjam</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <form method="POST" action="<?=base_url('Laporanpeminjamanbuku/index')?>">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('bookcategoryID') ? 'has-error' : ''?>">
                                <label>Kategori</label>
                                <?php 
                                    $bookcategoryArray[0]   = 'Silakan Pilih';
                                    if(calculate($bookcategorys)) {
                                        foreach($bookcategorys as $kategori_buku) {
                                            $bookcategoryArray[$kategori_buku->bookcategoryID] = $kategori_buku->nama;
                                        }
                                    }
                                    echo form_dropdown('bookcategoryID', $bookcategoryArray, set_value('bookcategoryID'),'id="bookcategoryID" class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('id_buku') ? 'has-error' : ''?>">
                                <label>Buku</label>
                                <?php 
                                    $bookArray[0]   = 'Silakan Pilih';
                                    echo form_dropdown('id_buku', $bookArray, set_value('id_buku'),'id='id_buku' class="form-control"');
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
                                            $roleArray[$peran->id_peran]   = $peran->peran;
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
                                    echo form_dropdown('id_anggota', $memberArray, set_value('id_anggota'),'id='id_anggota' class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
                                <label>Status</label>
                                <?php 
                                    $statusArray[0]   = 'Silakan Pilih';
                                    $statusArray[1]   = 'Dipinjam';
                                    $statusArray[2]   = 'Dikembalikan';
                                    $statusArray[3]   = 'Hilang';
                                    echo form_dropdown('status', $statusArray, set_value('status'),'id='status' class="form-control"');
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
                                    <button class="btn btn-mytheme divhide" onclick="printDiv()" style="margin-top: 25px">Cetak</button>
                                    <a target="_blank" href="<?=base_url('Laporanpeminjamanbuku/pdf/'.$bookcategoryID.'/'.$bookID.'/'.$roleID.'/'.$memberID.'/'.$status.'/'.$fromdate.'/'.$todate)?>" class="btn btn-mytheme divhide" style="margin-top: 25px">PDF</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if($flag) { ?>
            <div class="box box-mytheme divhide">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12" id="printDiv">
                            <?php $this->load->view('laporan/peminjaman_buku/view')?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
</div>

<script type="text/javascript">

    function printDiv() {
        var oldPage  = document.body.innerHTML;
        var printDiv = document.getElementById('printDiv').innerHTML;
        document.body.innerHTML = '<html><head><title>'+document.title+'</title></head><body>'+printDiv+'</body></html>';
        window.print();
        document.body.innerHTML = oldPage;
        window.location.reload();
    }
   
</script>
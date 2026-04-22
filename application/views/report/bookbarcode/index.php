<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Data Barcode</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class='aktif'>Laporan Data Barcode</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <form method="POST" action="<?=base_url('bookbarcodereport/index')?>">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('bookcategoryID') ? 'has-error' : ''?>">
                                <label>Kategori</label> <span class="text-red">*</span>
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
                                <label>Buku</label> <span class="text-red">*</span>
                                <?php
                                    $bookArray[0]   = 'Silakan Pilih';
                                    if(calculate($books)) {
                                        foreach($books as $buku) {
                                            $bookArray[$buku->id_buku] = $buku->nama . ' - ' . $buku->codeno;
                                        }
                                    } 
                                    echo form_dropdown('id_buku', $bookArray, set_value('id_buku'),'id='id_buku' class="form-control"');
                                ?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <button class="btn btn-mytheme" style="margin-top: 23px">Tampilkan</button>
                                <?php if($flag) { ?>
                                    <button class="btn btn-mytheme divhide" onclick="printDiv()" style="margin-top: 23px">Cetak</button>
                                    <a href="<?=base_url('bookbarcodereport/pdf/'.$bookcategoryID.'/'.$bookID)?>" class="btn btn-mytheme divhide" style="margin-top: 23px" target="_blank">PDF</a>
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
                            <?php $this->load->view('report/bookbarcode/view')?>
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
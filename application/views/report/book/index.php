<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Data Buku</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Laporan Data Buku</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <form method="POST" action="<?=base_url('bookreport/index')?>">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('bookcategoryID') ? 'has-error' : ''?>">
                                <label>Kategori</label>
                                <?php 
                                    $bookcategoryArray[0]   = 'Silakan Pilih';
                                    if(calculate($bookcategorys)) {
                                        foreach($bookcategorys as $bookcategory) {
                                            $bookcategoryArray[$bookcategory->bookcategoryID] = $bookcategory->name;
                                        }
                                    }
                                    echo form_dropdown('bookcategoryID', $bookcategoryArray, set_value('bookcategoryID'),'id="bookcategoryID" class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('bookID') ? 'has-error' : ''?>">
                                <label>Buku</label>
                                <?php 
                                    $bookArray[0]   = 'Silakan Pilih';
                                    echo form_dropdown('bookID', $bookArray, set_value('bookID'),'id="bookID" class="form-control"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group <?=form_error('status') ? 'has-error' : ''?>">
                                <label>Status</label>
                                <?php 
                                    $statusArray[0]   = 'Silakan Pilih';
                                    $statusArray[1]   = 'Tersedia';
                                    $statusArray[2]   = 'Tidak Tersedia';
                                    echo form_dropdown('status', $statusArray, set_value('status'),'id="status" class="form-control"');
                                ?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <button class="btn btn-mytheme" style="margin-top: 15px">Tampilkan</button>
                                <?php if($flag) { ?>
                                    <button class="btn btn-mytheme divhide" onclick="printDiv()" style="margin-top: 15px">Cetak</button>
                                    <a href="<?=base_url('bookreport/pdf/'.$bookcategoryID.'/'.$bookID.'/'.$status)?>" class="btn btn-mytheme divhide" style="margin-top: 15px" target="_blank">PDF</a>
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
                            <?php $this->load->view('report/book/view')?>
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
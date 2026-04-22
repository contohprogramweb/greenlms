<div class="content-wrapper">
    <section class="content-header">
        <h1>Ebook</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('ebook/index')?>">Ebook</a></li>
            <li class="active">Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="profile_view_item">
                            <p><b>Judul Ebook</b>: <?=$ebook->name?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Penulis</b>: <?=$ebook->author?></p>
                        </div>
                        <div class="profile_view_item">
                            <p><b>Catatan</b>: <?=$ebook->notes?></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div id="pdffile"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    var options = {
        pdfOpenParams: { view: 'Fit', pagemode: 'none', scrollbar: '1', toolbar: '1', statusbar: '1', messages: '1', navpanes: '1' }
    };

    PDFObject.embed("<?=base_url('uploads/ebook/'.$ebook->file)?>", "#pdffile");
</script>
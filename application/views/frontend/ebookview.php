<section class="main-ebookview">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="profile_view_item">
                    <p><b>Judul</b>: <?=$ebook->name?></p>
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
</section>

<script type="text/javascript">
    var options = {
        height: "1000px",
        pdfOpenParams: { pagemode: 'none', scrollbar: '1', toolbar: '0', statusbar: '1', messages: '1', navpanes: '1' }
    };
    PDFObject.embed("<?=base_url('uploads/ebook/'.$ebook->file)?>", "#pdffile", options);

    <?php if($generalsetting->ebook_download == 0) { ?>
        $(document).on({ "contextmenu": function(e) { e.preventDefault(); }});
    <?php } ?>
</script>
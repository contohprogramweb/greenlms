<section class="main-contactus">
    <div class="container">
        <div class="contact-form">
             
            <form method="POST">
                <h3 style="color:#666;">Kirim Pesan</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name='nama' class="form-control <?=form_error('nama') ? 'is-invalid' : ''?>" placeholder="Nama *" value="<?=set_value('nama')?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" name='surel' class="form-control <?=form_error('surel') ? 'is-invalid' : ''?>" placeholder="Email *" value="<?=set_value('surel')?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" name='subjek' class="form-control <?=form_error('subjek') ? 'is-invalid' : ''?>" placeholder="Judul Pesan *" value="<?=set_value('subjek')?>" />
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name='pesan' class="form-control <?=form_error('pesan') ? 'is-invalid' : ''?>" rows="6" placeholder="Isi Pesan *"><?=set_value('pesan')?></textarea>
                        </div>
                    </div>
					<div class="col-md-12">
					<div class="form-group">
                            <input type="submit" name="btnSubmit" class="btnContact" value="Send Message" />
                    </div>
					</div>
                </div>
            </form>
        </div>
    </div>
</section>
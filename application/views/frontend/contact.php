<section class="main-contactus">
    <div class="container">
        <div class="contact-form">
             
            <form method="POST">
                <h3 style="color:#666;">Kirim Pesan</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control <?=form_error('name') ? 'is-invalid' : ''?>" placeholder="Nama *" value="<?=set_value('name')?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control <?=form_error('email') ? 'is-invalid' : ''?>" placeholder="Email *" value="<?=set_value('email')?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" class="form-control <?=form_error('subject') ? 'is-invalid' : ''?>" placeholder="Judul Pesan *" value="<?=set_value('subject')?>" />
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="message" class="form-control <?=form_error('message') ? 'is-invalid' : ''?>" rows="6" placeholder="Isi Pesan *"><?=set_value('message')?></textarea>
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
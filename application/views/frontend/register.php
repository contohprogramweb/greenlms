<section class="main-login">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 offset-md-3">
                <div class="my-login">
                    <h2 class="text-center">Daftar</h2>
                    <hr>
                    <?php if(calculate($errors)) {
                        foreach($errors as $error) {
                            echo "<p class='text-danger'>".$error."</p>";
                        }
                    } ?>
                    <form action="<?=base_url('myaccount/register')?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nama Lengkap</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control <?=form_error('nama') ? 'is-invalid' : ''?>" name='nama' value="<?=set_value('nama')?>" />
                        </div>
                        <div class="form-group">
                            <label>Email</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control <?=form_error('surel') ? 'is-invalid' : ''?>" name='surel' value="<?=set_value('surel')?>" />
                        </div>
                        <div class="form-group">
                            <label>Nomor Telp.</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control <?=form_error('telepon') ? 'is-invalid' : ''?>" name='telepon' value="<?=set_value('telepon')?>" />
                        </div>
                        <div class="form-group">
                            <label>Foto</label> <span class="text-danger">*</span>
                            <div class="custom-file">
                                <input type='file' name='foto' class="custom-file-input" id='foto'>
                                <label class="custom-file-label" for='foto'>Pilih File</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Username</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control <?=form_error('nama_pengguna') ? 'is-invalid' : ''?>" name='nama_pengguna' value="<?=set_value('nama_pengguna')?>" />
                        </div>
                        <div class="form-group">
                            <label>Password</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control <?=form_error('kata_sandi') ? 'is-invalid' : ''?>" name='kata_sandi' value="<?=set_value('kata_sandi')?>" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Kirim</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
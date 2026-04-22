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
                            <input type="text" class="form-control <?=form_error('name') ? 'is-invalid' : ''?>" name="name" value="<?=set_value('name')?>" />
                        </div>
                        <div class="form-group">
                            <label>Email</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control <?=form_error('email') ? 'is-invalid' : ''?>" name="email" value="<?=set_value('email')?>" />
                        </div>
                        <div class="form-group">
                            <label>Nomor Telp.</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control <?=form_error('phone') ? 'is-invalid' : ''?>" name="phone" value="<?=set_value('phone')?>" />
                        </div>
                        <div class="form-group">
                            <label>Foto</label> <span class="text-danger">*</span>
                            <div class="custom-file">
                                <input type="file" name="photo" class="custom-file-input" id="photo">
                                <label class="custom-file-label" for="photo">Pilih File</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Username</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control <?=form_error('username') ? 'is-invalid' : ''?>" name="username" value="<?=set_value('username')?>" />
                        </div>
                        <div class="form-group">
                            <label>Password</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control <?=form_error('password') ? 'is-invalid' : ''?>" name="password" value="<?=set_value('password')?>" />
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
<section class="main-login">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 offset-md-3">
                <div class="my-login">
                    <h2 class="text-center">Login</h2>
                    <hr>
                    <?php if(calculate($errors)) {
                        foreach($errors as $error) {
                            echo "<p class='text-danger'>".$error."</p>";
                        }
                    } ?>
                    <form action="<?=base_url('myaccount/login')?>" method="POST">
                        <div class="form-group">
                            <label for="username_or_email">Username / Email</label> <span class="text-danger">*</span>
                            <input name="username_or_email" type="text" class="form-control <?=form_error('username_or_email') ? 'is-invalid' : ''?>" placeholder="Masukkan Username / Email" id="membername" value="<?=set_value('username_or_email')?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label> <span class="text-danger">*</span>
                            <input name="password" type="password" class="form-control <?=form_error('password') ? 'is-invalid' : ''?>" placeholder="Masukkan password" id="password" value="<?=set_value('password')?>">
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</section>
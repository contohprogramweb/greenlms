<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?=$get_title?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?=base_url('assets/plugins/bootstrap/dist/css/bootstrap.min.css')?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?=base_url('assets/dist/css/AdminLTE.min.css')?>">
        <link rel="stylesheet" href="<?=base_url('assets/custom/css/style.css')?>">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
	<!-- style="background: url('<?=base_url('uploads/default/loginbg.jpg')?>') no-repeat center center fixed;background-size: 100% 100%; " -->
        <div class="login-box">
            <div class="login-logo">
                 <a href="<?=base_url('/')?>"><b><?=$pengaturan_umum->sitename?></b></a>
            </div>
            <div class="login-box-body">
                <h3 style="margin:-20 0 30 0;">REGISTER</h3>
                <form action="<?=base_url('login/registermember')?>" method="post" enctype="multipart/form-data">
                    
					<div class="form-group <?=form_error('nama') ? 'has-error' : ''?>">
                        <label>Nama Lengkap</label> <span class="text-red">*</span>
                        <input type="text" class="form-control" name='nama' value="<?=set_value('nama')?>"/>
                        <?=form_error('nama')?>
                    </div>
                    <div class="form-group <?=form_error('surel') ? 'has-error' : ''?>">
                        <label>Email</label> <span class="text-red">*</span>
                        <input type="text" class="form-control" name='surel' value="<?=set_value('surel')?>"/>
                        <?=form_error('surel')?>
                    </div>
                    <div class="form-group <?=form_error('telepon') ? 'has-error' : ''?>">
                        <label>Nomor Telp.</label> <span class="text-red">*</span>
                        <input type="text" class="form-control" name='telepon' value="<?=set_value('telepon')?>"/>
                        <?=form_error('telepon')?>
                    </div>
                    <div class="form-group <?=form_error('foto') ? 'has-error' : ''?>">
                        <label for='foto'>Foto</label> <span class="text-red">*</span>
                        <div class="input-group image-preview">
                            <input type="text" class="form-control image-preview-filename" disabled="disabled">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                    <span class="fa fa-remove"></span>Clear
                                </button>
                                <div class="btn btn-success image-preview-input">
                                    <span class="fa fa-repeat"></span>
                                    <span class="image-preview-input-title">Browse</span>
                                    <input type='file' accept="image/png, image/jpeg, image/gif" name='foto'/>
                                </div>
                            </span>
                        </div>
                        <?=form_error('foto')?>
                    </div>
                    <div class="form-group <?=form_error('nama_pengguna') ? 'has-error' : ''?>">
                        <label>Username</label> <span class="text-red">*</span>
                        <input type="text" class="form-control" name='nama_pengguna' value="<?=set_value('nama_pengguna')?>"/>
                        <?=form_error('nama_pengguna')?>
                    </div>
                    <div class="form-group <?=form_error('kata_sandi') ? 'has-error' : ''?>">
                        <label>Password</label> <span class="text-red">*</span>
                        <input type="text" class="form-control" name='kata_sandi' value="<?=set_value('kata_sandi')?>"/>
                        <?=form_error('kata_sandi')?>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a type="submit" href="<?=base_url('login/index')?>" class="btn btn-danger btn-block">Kembali ke login</a>
                        </div>
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- jQuery 3 -->
        <script src="<?=base_url('assets/plugins/jquery/dist/jquery.min.js')?>"></script>
        <script src="<?=base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js')?>"></script>
        <script type="text/javascript">
            var globalFilebrowse = "Browse";
        </script>
        <script src="<?=base_url('assets/custom/js/fileupload.js')?>"></script>
    </body>
</html>


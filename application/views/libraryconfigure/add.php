<div class="content-wrapper">
    <section class="content-header">
  		<h1>Pengaturan Perpustakaan</h1>
  		<ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
  			<li><a href="<?=base_url('konfigurasi_perpustakaan')?>">Pengaturan Perpustakaan</a></li>
  			<li class='aktif'>Tambah</li>
  		</ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="row">
                <div class="col-md-6">
                    <form peran="form" method="POST">
                        <div class="box-body">
                            <div class="form-group <?=form_error('id_peran') ? 'has-error' : ''?>">
                                <label for='id_peran'>Hak Akses</label> <span class="text-red">*</span>
                                <?php 
                                    $roleArray[0] = 'Silakan Pilih';
                                    if(calculate($roles)) {
                                      foreach ($roles as $peran) {
                                        $roleArray[$peran->id_peran] = $peran->peran;
                                      }
                                    }
                                    echo form_dropdown('id_peran', $roleArray,set_value('id_peran'),'id='id_peran' class="form-control"');
                                ?>
                                <?=form_error('id_peran')?>
                            </div>
                            <div class="form-group <?=form_error('max_issue_book') ? 'has-error' : ''?>">
                                <label for="max_issue_book">Max Buku Dipinjam</label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="<?=set_value('max_issue_book')?>" id="max_issue_book" name="max_issue_book"/>
                                <?=form_error('max_issue_book')?>
                            </div>
                            <div class="form-group <?=form_error('max_renewed_limit') ? 'has-error' : ''?>">
                                <label for="max_renewed_limit">Max Perpanjangan</label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="<?=set_value('max_renewed_limit')?>" id="max_renewed_limit" name="max_renewed_limit"/>
                                <?=form_error('max_renewed_limit')?>
                            </div>
                            <div class="form-group <?=form_error('per_renew_limit_day') ? 'has-error' : ''?>">
                                <label for="per_renew_limit_day">Batas Hari Perpanjangan</label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="<?=set_value('per_renew_limit_day')?>" id="per_renew_limit_day" name="per_renew_limit_day"/>
                                <?=form_error('per_renew_limit_day')?>
                            </div>
                            <div class="form-group <?=form_error('book_fine_per_day') ? 'has-error' : ''?>">
                                <label for="book_fine_per_day">Denda Per Hari</label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="<?=set_value('book_fine_per_day')?>" id="book_fine_per_day" name="book_fine_per_day"/>
                                <?=form_error('book_fine_per_day')?>
                            </div>
                            <div class="form-group <?=form_error('issue_off_limit_amount') ? 'has-error' : ''?>" style="display:none;">
                                <label for="issue_off_limit_amount">Jumlah Batas Pinjam</label> <span class="text-red">*</span>
                                <input type="text" class="form-control" value="1000" id="issue_off_limit_amount" name="issue_off_limit_amount"/>
                                <?=form_error('issue_off_limit_amount')?>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-mytheme">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">
    $('.form-control').on('keyup', function() {
        var value = convertNumber($(this).val());
        $(this).val(value);
    });
   
    function convertNumber(data) {
        if(parseInt(data)) {
            return parseInt(data);
        }
        return 0;
    }
</script>
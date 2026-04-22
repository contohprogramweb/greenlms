<div class="content-wrapper">
    <section class="content-header">
        <h1>Template Email</h1>
        <ol class="breadcrumb">
            <li><a href="<?=base_url('dashboard/index')?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?=base_url('emailtemplate/index')?>">Template Email</a></li>
            <li class="active">Lihat</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-mytheme">
            <div class="box-body">
                <h3><?=$emailtemplate->name?></h3>
                <p><?=$emailtemplate->template?></p>
            </div>
        </div>
    </section>
</div>
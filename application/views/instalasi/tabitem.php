 <ul class="nav nav-tabs">
    <li peran="presentation" class="<?=(($get_url == 'index') || ($get_url == null)) ? 'aktif' : ''?>">
        <a href="#" title="Check List">
            <span class="round-tab">
                <i class="fa fa-list"></i>
            </span>
        </a>
    </li>
    <li peran="presentation" class="<?=(($get_url == 'purchase')) ? 'aktif' : ''?>">
        <a href="#" title="Purchase">
            <span class="round-tab">
                <i class="fa fa-shield"></i>
            </span>
        </a>
    </li>
    <li peran="presentation" class="<?=(($get_url == 'database')) ? 'aktif' : ''?>">
        <a href="#" title="Database">
            <span class="round-tab">
                <i class="fa fa-database"></i>
            </span>
        </a>
    </li>
    <li peran="presentation" class="<?=(($get_url == 'setting')) ? 'aktif' : ''?>">
        <a href="#" title="Setting">
            <span class="round-tab">
                <i class="fa fa-cogs"></i>
            </span>
        </a>
    </li>
    <li peran="presentation" class="<?=(($get_url == 'complate')) ? 'aktif' : ''?>">
        <a href="#" title="Complete">
            <span class="round-tab">
                <i class="glyphicon glyphicon-ok"></i>
            </span>
        </a>
    </li>
</ul>
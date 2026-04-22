<?php 
if(calculate($chats)) { foreach($chats as $obrolan) { ?>
    <div class="item chatID" data-chatid="<?=$obrolan->id_obrolan?>">
        <?php $memberimage = isset($members[$obrolan->create_memberID]) ? $members[$obrolan->create_memberID]->foto : ''?>
        <img src="<?=profile_img($memberimage)?>" alt="anggota image" class="offline">
        <p class='pesan'>
            <a href="#" class='nama'>
                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?=date("d M Y H:i", strtotime($obrolan->tanggal_dibuat))?></small>
                <?=isset($members[$obrolan->create_memberID]) ? $members[$obrolan->create_memberID]->nama : ""?>
            </a>
            <?=$obrolan->pesan?>
        </p>
    </div>
<?php } } ?>
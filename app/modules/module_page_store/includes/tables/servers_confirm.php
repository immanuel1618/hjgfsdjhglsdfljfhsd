<?php if ($options['use_server_accept']):?>
    <div class="wrapper_server_accept">
        <div class="server_accept_title"><?= $Translate->get_translate_module_phrase( 'module_page_store','_pleaseChooseServer')?></div>
        <hr>
        <div class="servers_accept">
            <?php foreach ($servers as $server):?>
                <div class="server_accept" onclick="showCatalog(<?= $server['id']?>)">
                    <?= $server['name']?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
<?php endif;?>
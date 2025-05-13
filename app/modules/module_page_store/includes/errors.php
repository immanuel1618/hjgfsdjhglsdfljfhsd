<?php
use app\modules\module_page_store\ext\ErrorLog;

(empty($_SESSION['steamid32']) || ! isset( $_SESSION['user_admin'] ) ) && get_iframe( '013','Доступ закрыт' ) && die();

$errors = ErrorLog::getErrors();
?>
<div class="col-md-12">
    <div class="card">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="text-center">№</th>
                
                <th class="text-center"></th>
                <th class="text-center">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_Player')?>
                </th>
                <th class="text-center">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_textException')?>
                </th>
                <th class="text-center">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_trace')?>
                </th>
                <th class="text-center">
                    <?= $Translate->get_translate_module_phrase('module_page_store', '_date')?>
                </th>
            </tr>
            </thead>
            <tbody><?php $count = -1; foreach(array_reverse($errors, true) as $error): $count++; 
                $steam =  $error['steam'] ?  $error['steam'] : 'none';
                $General->get_js_relevance_avatar( $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $steam ) : $steam )?>
                <tr class="pointer" onclick="location.href = '<?= $General->arr_general['site'] ?>profiles/<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $steam ) :$steam?>/?search=1';">
                    <th class="text-center"><?= $count + 1;?></th>
                    <?php if( ! empty( $General->arr_general['avatars'] ) ):?>
                        <th class="text-center tb-avatar">
                            <img class="rounded-circle" id="<?php $General->arr_general['avatars'] === 1 && print con_steam32to64( $steam )?>"<?= $count - 1 < '20' ? 'src' : 'data-src'?>="<?= $General->getAvatar( con_steam32to64( $steam ), 2 )?>">
                        </th>
                    <?php endif;?>
                    <th class="table-text text-center tb-name">
                        <?= action_text_clear( action_text_trim($General->checkName(con_steam32to64( $steam )), 30) )?>
                    </th>
                    <th class="text-center text_exception"><?= $error['text_exception']?></th>
                    <th class="text-center"><?= $error['file']?>: <?= $error['line']?></th>
                    <th class="text-center errors_date"><?= $error['date']?></th>
                </tr><?php endforeach;?></tbody>
        </table>
    </div>
</div>

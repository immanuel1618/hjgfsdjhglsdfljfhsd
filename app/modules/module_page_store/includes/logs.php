<?php

use app\modules\module_page_store\ext\OrderLog;

(empty($_SESSION['steamid32']) || ! isset($_SESSION['user_admin'])) && get_iframe('013', 'Доступ закрыт') && die();

$orderLog = new OrderLog($Db, $Translate);

$page_max = 0;

$page_num = (int) intval(get_section('num', '1'));

$pagination = $orderLog->getAllPagination($page_num, 15);

$page_max = $pagination[1];
$logs = $pagination[0];
if ($page_num == 1 || $page_num == 2) {
    $startPag = 1;
    $pagActive = $page_num;
} else if ($page_num == $page_max) {
    $startPag = $page_max - 4;
    $pagActive = 5;
} else if ($page_num == $page_max - 1) {
    $startPag = $page_max - 4;
    $pagActive = 4;
} else {
    $startPag = $page_num - 2;
    $pagActive = 3;
}?>
<div class="col-md-12">
    <div class="card">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">№</th>
                    <th class="text-center"></th>
                    <th class="text-center"><?= $Translate->get_translate_module_phrase('module_page_store', '_Player') ?></th>
                    <th class="text-center">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_server') ?>
                    </th>
                    <th class="text-center">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_title') ?>
                    </th>

                    <th class="text-center">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_promo') ?>
                    </th>
                    <th class="text-center">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_shopGift') ?>
                    </th>
                    <th class="text-center">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_date') ?>
                    </th>
                    <th class="text-center">
                        <?= $Translate->get_translate_module_phrase('module_page_store', '_status') ?>
                    </th>
                </tr>
            </thead>
            <tbody><?php $count = -1;
                    foreach ($logs as $log): $count++;
                        $General->get_js_relevance_avatar($General->arr_general['only_steam_64'] === 1 ? con_steam32to64($log['steam']) : $log['steam']) ?>
                    <tr class="pointer" onclick="location.href = '<?= $General->arr_general['site'] ?>profiles/<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64($log['steam']) : $log['steam'] ?>/?search=1';">
                        <th class="text-center"><?= $log['id'] ?></th>
                        <?php if (! empty($General->arr_general['avatars'])): ?>
                            <th class="text-center tb-avatar">
                                <img class="rounded-circle" id="<?php $General->arr_general['avatars'] === 1 && print con_steam32to64($log['steam']) ?>" <?= $count - 1 < '20' ? 'src' : 'data-src' ?>="<?= $General->getAvatar(con_steam32to64($log['steam']), 2) ?>">
                            </th>
                        <?php endif ?>
                        <th class="table-text text-center tb-name">
                            <?= action_text_clear(action_text_trim($General->checkName(con_steam32to64($log['steam'])), 30)) ?>
                        </th>
                        <th class="text-center"><?= $log['server'] ?></th>
                        <th class="text-center"><?= $log['title'] ?></th>
                        <th class="text-center"><?= $log['promo'] === null ? '-' : $log['promo'] ?></th>
                        <th class="text-center"><?= $log['gift'] === null ? '-' : $log['gift'] ?></th>
                        <th class="text-center"><?= $log['date'] ?></th>
                        <th class="text-center"><?= $log['status'] ?></th>
                    </tr><?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <?php if ($page_num != 1) : ?>
            <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', 1); ?>"><svg viewBox="0 0 448 512">
                    <path d="M77.25 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C399.6 476.9 407.8 480 416 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"></path>
                </svg></a>
            <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num - 1); ?>"><svg viewBox="0 0 384 512">
                    <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                </svg></a>
        <?php endif; ?>
        <?php if ($page_max < 5) : for ($i = 1; $i <= $page_max; $i++) : ?>
                <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
            <?php endfor;
        else : for ($i = $startPag, $j = 1; $i < $startPag + 5; $i++, $j++) : ?>
                <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
        <?php endfor;
        endif; ?>
        <?php if ($page_num != $page_max) : ?>
            <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num + 1); ?>"><svg viewBox="0 0 384 512">
                    <path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                </svg></a>
            <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $page_max); ?>"><svg viewBox="0 0 448 512">
                    <path d="M246.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C15.63 476.9 23.81 480 32 480s16.38-3.125 22.62-9.375l192-192C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375l192-192C451.1 266.1 451.1 245.9 438.6 233.4z"></path>
                </svg></a>
        <?php endif; ?>
    </div>
</div>
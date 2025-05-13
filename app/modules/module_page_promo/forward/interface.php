<?php 
    if (!isset($_SESSION['user_admin']) || IN_LR != true) {
        header('Location: ' . $General->arr_general['site']);
        exit;
    } 

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $usage = $Admin->Admin_UsagePromo($_GET['promocode_edit'], $limit, $offset);
    $totalUsage = $Admin->Admin_UsagePromoCount($_GET['promocode_edit']);
    $totalPages = ceil($totalUsage / $limit);
?>

<div class="row">
    <div class="col-md-12">
        <div class="block-flex">
            <div class="card">
                <div class="card-header">
                    <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_promo', '_SettingsPromo') ?></h5>
                </div>
                <div class="card-container">
                    <div class="modern_table">
                        <div class="mt_header_2">
                            <li>
                                <span style="display: flex;justify-content: flex-start;"><?= $Translate->get_translate_module_phrase('module_page_promo', '_Promo') ?></span>
                                <span><?= $Translate->get_translate_module_phrase('module_page_promo', '_RewardType') ?></span>
                                <span><?= $Translate->get_translate_module_phrase('module_page_promo', '_RewardValues') ?></span>
                                <span><?= $Translate->get_translate_module_phrase('module_page_promo', '_Limit') ?></span>
                                <span><?= $Translate->get_translate_module_phrase('module_page_promo', '_Snap') ?></span>
                                <span><?= $Translate->get_translate_phrase('_Current_Action') ?></span>
                            </li>
                        </div>
                        <div class="mt_content_2 no-scrollbar">
                            <?php foreach ($Admin->Admin_Promocodes() as $key) : ?>
                                <li>
                                    <span style="display: flex;justify-content: flex-start; max-width: 5rem; overflow: hidden; white-space: nowrap;"><?= $key['names'] ?></span>
                                    <span>
                                        <?php 
                                        switch($key['reward_type']) {
                                            case 'cash': 
                                                echo $Translate->get_translate_module_phrase('module_page_promo', '_Cash'); 
                                                break;
                                            case 'rev_item': 
                                                echo $Translate->get_translate_module_phrase('module_page_promo', '_Inventori'); 
                                                break;
                                            case 'flames_item': 
                                                echo $Translate->get_translate_module_phrase('module_page_promo', '_Inventori'); 
                                                break;
                                        }
                                        ?>
                                    </span>
                                    <span><?= $key['reward_value'] ?></span>
                                    <span><?= $key['limites'] ?></span>
                                    <span><?= $key['activates'] ?></span>
                                    <span>
                                        <a href="<?= set_url_section(get_url(2), 'promocode_edit', $key['id']) ?>">
                                            <?= $Translate->get_translate_phrase('_Change') ?>
                                        </a>
                                    </span>
                                </li>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-width">
                <div class="card">
                    <div class="card-header">
                        <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_promo', '_Options') ?></h5>
                    </div>
                    <div class="card-container">
                        <a class="secondary_btn" href="<?= set_url_section(get_url(2), 'promocode_add', 'promocodes') ?>"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_AddPromocode') ?></a>
                        <form id="create_tables" data-default="true" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="create_tables" value="1">
                            <input name="create_tables" class="secondary_btn w100 m10" type="submit" form="create_tables" value="<?= $Translate->get_translate_module_phrase('module_page_promo', '_CreateTables') ?>">
                        </form>
                    </div>
                </div>
            </div>
            <?php if (!empty($_GET['promocode_edit'])) : $promo = $Admin->Admin_PromoCode($_GET['promocode_edit']); ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_EditPromo') ?> - <?php echo $promo['names'] ?><a data-del="delete" data-get="promocode_edit" class="close_settings"><?= $Translate->get_translate_phrase('_Close') ?></a></h5>
                    </div>
                    <div class="card-container module_block">
                        <form id="promocode_edit" data-default="true" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="editid" value="<?php echo $_GET['promocode_edit'] ?>">
                            <div class="input-form">
                                <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_Name') ?>:</div><input name="editpromo" value="<?php echo $promo['names'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_RewardType') ?>:</div>
                                <select class="custom-select" name="editrewardtype" placeholder="<?php echo $promo['reward_type'] == 'cash' ? $Translate->get_translate_module_phrase('module_page_promo', '_Cash') : ($promo['reward_type'] == 'rev_item' ? $Translate->get_translate_module_phrase('module_page_promo', '_RevItem') : $Translate->get_translate_module_phrase('module_page_promo', '_FlamesItem'));?>">
                                    <option value="cash" <?= $promo['reward_type'] == 'cash' ? 'selected' : '' ?>><?= $Translate->get_translate_module_phrase('module_page_promo', '_Cash') ?></option>
                                    <option value="rev_item" <?= $promo['reward_type'] == 'rev_item' ? 'selected' : '' ?>><?= $Translate->get_translate_module_phrase('module_page_promo', '_RevItem') ?></option>
                                    <option value="flames_item" <?= $promo['reward_type'] == 'flames_item' ? 'selected' : '' ?>><?= $Translate->get_translate_module_phrase('module_page_promo', '_FlamesItem') ?></option>
                                </select>
                            </div>
                            <div class="input-form">
                                <div class="input_text_flex"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_RewardValue') ?>:</div>
                                <input name="editrewardvalue" value="<?php echo $promo['reward_value'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_LimitUsePromo') ?>:</div><input name="editlimit" value="<?php echo $promo['limites'] ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_Created_At') ?>:</div>
                                <input type="datetime-local" name="edit_start_at" value="<?php echo date('Y-m-d\TH:i', $promo['created_at']) ?>">
                            </div>
                            <div class="input-form">
                                <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_Edit_At') ?>:</div>
                                <input type="datetime-local" name="edit_end_at" value="<?php echo date('Y-m-d\TH:i', $promo['end_at']) ?>">
                            </div>
                        </form>
                        <div style="display: flex;align-items: center;justify-content: space-between;">
                            <input class="secondary_btn" type="submit" form="promocode_edit" value="<?php echo $Translate->get_translate_module_phrase('module_page_promo', '_Save') ?>">
                            <button class="secondary_btn btn_delete" type="submit" form="promocode_delete"><?php echo $Translate->get_translate_phrase('_Delete_Action') ?></button>
                        </div>
                        <form data-del="delete" data-get="promocode_edit" id="promocode_delete" data-default="true" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="promocode_delete" value="<?php echo $_GET['promocode_edit'] ?>">
                        </form>
                        <div class="user_pays">
                            <div class="pomo_list no-scrollbar">
                                <?php if (!empty($usage)) : ?>
                                    <?php foreach ($usage as $key) : ?>
                                        <div class="player_promo" onclick="location.href = '<?php echo $General->arr_general['site'] ?>profiles/<?php echo $key['steamid64'] ?>?search=1'">
                                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                                <img class="avatar_frame_small" src="<?= $General->getFrame(con_steam64($key['steamid64'])) ?>" id="frame" frameid="<?= con_steam64($key['steamid64']) ?>">
                                                <img class="avatar" src="<?= $General->getAvatar(con_steam64($key['steamid64']), 3) ?>" id="avatar" avatarid="<?= con_steam64($key['steamid64']) ?>">
                                                <span><?php echo $this->General->checkName($key['steamid64']) ?></span>
                                            </div>
                                            <span><?php echo date('d.m.Y H:i:s', $key['uses_at']) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?php echo $Translate->get_translate_module_phrase('module_page_promo', '_PromoNotUse') ?>
                                <?php endif; ?>
                            </div>
                            <div class="pagination">
                                <?php if ($page > 1) : ?>
                                    <a class="button_pagination current" href="?promocode_edit=<?= $_GET['promocode_edit'] ?>&page=1">
                                        <svg viewBox="0 0 448 512"> <path d="M77.25 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C399.6 476.9 407.8 480 416 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"></path> </svg>
                                    </a>
                                    <a class="button_pagination current" href="?promocode_edit=<?= $_GET['promocode_edit'] ?>&page=<?= $page - 1 ?>">
                                        <svg viewBox="0 0 384 512"> <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path> </svg>
                                    </a>
                                <?php endif; ?>

                                <?php $startPag = max(1, $page - 2); $endPag = min($totalPages, $page + 2); for ($i = $startPag; $i <= $endPag; $i++) : ?>
                                    <a class="button_pagination current <?= $i == $page ? 'active' : '' ?>" href="?promocode_edit=<?= $_GET['promocode_edit'] ?>&page=<?= $i ?>"><?= $i ?></a>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages) : ?>
                                    <a class="button_pagination current" href="?promocode_edit=<?= $_GET['promocode_edit'] ?>&page=<?= $page + 1 ?>">
                                        <svg viewBox="0 0 384 512"> <path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path> </svg>
                                    </a>
                                    <a class="button_pagination current" href="?promocode_edit=<?= $_GET['promocode_edit'] ?>&page=<?= $totalPages ?>">
                                        <svg viewBox="0 0 448 512"> <path d="M246.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C15.63 476.9 23.81 480 32 480s16.38-3.125 22.62-9.375l192-192C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375l192-192C451.1 266.1 451.1 245.9 438.6 233.4z"></path> </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?php if (!empty($_GET['promocode_add'])) : ?>
                <div class="card-width">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_AddPromocode') ?><a data-del="delete" data-get="promocode_add" class="close_settings"><?= $Translate->get_translate_phrase('_Close') ?></a></h5>
                        </div>
                        <div class="card-container module_block">
                            <form id="promocode_add" data-default="true" enctype="multipart/form-data" method="post">
                                <div class="input-form">
                                    <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_AddPromoName') ?></div><input name="addpromo">
                                </div>
                                <div class="input-form">
                                    <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_RewardType') ?>:</div>
                                    <select class="custom-select" name="rewardtype" placeholder="<?= $Translate->get_translate_module_phrase('module_page_promo', '_Cash') ?>">
                                        <option value="cash"><?= $Translate->get_translate_module_phrase('module_page_promo', '_Cash') ?></option>
                                        <option value="rev_item"><?= $Translate->get_translate_module_phrase('module_page_promo', '_RevItem') ?></option>
                                        <option value="flames_item"><?= $Translate->get_translate_module_phrase('module_page_promo', '_FlamesItem') ?></option>
                                    </select>
                                </div>
                                <div class="input-form">
                                    <div class="input_text_flex"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_RewardValue') ?>:</div>
                                    <input name="rewardvalue">
                                </div>
                                <div class="input-form">
                                    <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_LimitUsePromo') ?>:</div><input name="limites">
                                </div>
                                <div class="input-form">
                                    <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_Created_At') ?>:</div>
                                    <input type="datetime-local" name="created_at" value="<?php echo date('Y-m-d\TH:i') ?>">
                                </div>
                                <div class="input-form">
                                    <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_promo', '_End_At') ?>:</div>
                                    <input type="datetime-local" name="end_at" value="<?php echo date('Y-m-d\TH:i') ?>">
                                </div>
                            </form>
                            <input class="secondary_btn" name="promocode_add" type="submit" form="promocode_add" value="<?php echo $Translate->get_translate_module_phrase('module_page_promo', '_AddPromocode') ?>">
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
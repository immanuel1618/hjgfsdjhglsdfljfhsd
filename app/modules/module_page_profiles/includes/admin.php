<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_Information_player'); ?></div>
        </div>
        <div class="card-container">
            <div class="general_info">
                <div class="fill_blocks">
                    <div class="title_head">
                        <?= $Translate->get_translate_module_phrase('module_page_profiles', '_Admin_info'); ?>
                    </div>
                    <div class="adm_container">
                        <div class="adm_column">
                            <div class="title_column"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_Admin_Group'); ?></div>
                            <span class="content_column"><?php if (!empty($Db->db_data['IksAdmin']) || !empty($Db->db_data['AdminSystem'])) {
                                                                $groupFound = false;
                                                                foreach ($Groups as $key) {
                                                                    if ($Admins['group_id'] == -1 || $Admins['group_id'] == 0) {
                                                                        echo $Translate->get_translate_module_phrase('module_page_profiles', '_No_Group');
                                                                        $groupFound = true;
                                                                        break;
                                                                    } else {
                                                                        if ($Admins['group_id'] == $key['id']) {
                                                                            echo $key['name'];
                                                                            $groupFound = true;
                                                                            break;
                                                                        }
                                                                    }
                                                                }
                                                                if (!$groupFound) {
                                                                    echo $Translate->get_translate_module_phrase('module_page_profiles', '_No_Group');
                                                                }
                                                            } ?></span>
                        </div>
                        <div class="adm_column">
                            <div class="title_column"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_Admin_Access'); ?></div>
                            <span class="content_column"><?= ($Admins['end'] == 0) ? $Translate->get_translate_phrase('_Forever') : ($Admins['end'] <= time() ? $Translate->get_translate_module_phrase('module_page_profiles', '_Expired') : date('d.m.Y', $Admins['end'])); ?></span>
                        </div>
                        <div class="adm_column">
                            <div class="title_column"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_Admin_Immunity'); ?></div>
                            <span class="content_column"><?php if (!empty($Db->db_data['IksAdmin']) || !empty($Db->db_data['AdminSystem'])) {
                                                                if ($Admins['immunity'] == -1 || $Admins['immunity'] == 0 || $Admins['immunity'] == null) {
                                                                    foreach ($Groups as $key) {
                                                                        if ($Admins['group_id'] == $key['id']) {
                                                                            echo $key['immunity'];
                                                                        }
                                                                    }
                                                                } else {
                                                                    echo $Admins['immunity'];
                                                                }
                                                            } ?></span>
                        </div>
                    </div>
                    <div class="title_head">
                        <?= $Translate->get_translate_module_phrase('module_page_profiles', '_Admin_activity'); ?>
                    </div>
                    <div class="adm_container">
                        <div class="adm_column">
                            <div class="title_column"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_BansGiven'); ?></div>
                            <span class="content_column"><?= $Admins['bans_count'] ?? 0 ?></span>
                        </div>
                        <div class="adm_column">
                            <div class="title_column"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_CommsGiven'); ?></div>
                            <span class="content_column"><?= $Admins['mutes_count'] ?>/<?= $Admins['gags_count'] ?></span>
                        </div>
                        <?php if (file_exists(MODULES . 'module_page_managersystem/description.json')) : ?>
                            <div class="adm_column">
                                <div class="title_column"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_Admin_Warns'); ?></div>
                                <span class="content_column"><?= $WarnCount ?>/<?php $WarnSettings = require MODULES . 'module_page_managersystem/assets/cache/settings.php';
                                                                                echo $WarnSettings['count_warn'] ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (file_exists(MODULES . 'module_page_reports/description.json')) : ?>
                            <div class="adm_column">
                                <div class="title_column">Рассмотрено репортов</div>
                                <span class="content_column"><?= $RepCount ?? 0 ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (file_exists(MODULES . 'module_page_managersystem/description.json')) : if ($WarnCount != 0) : ?>
                            <div class="title_head">
                                <?= $Translate->get_translate_module_phrase('module_page_profiles', '_Warns_List'); ?>
                            </div>
                            <div class="adm_container" style="height: 95px;padding: 3px !important;flex-direction: column;gap: 3px;">
                                <?php foreach ($Warns as $key) : ?>
                                    <div class="adm_warn_content"><?php if ($key['time'] < time()) {
                                                                        echo $Translate->get_translate_module_phrase('module_page_profiles', '_Expired');
                                                                    } else {
                                                                        echo 'Действителен ' . $Modules->action_time_exchange_exact($key['time'] - time());
                                                                    } ?> | <?= action_text_clear($key['reason'], 30) ?></div>
                                <?php endforeach; ?>
                            </div>
                    <?php endif;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
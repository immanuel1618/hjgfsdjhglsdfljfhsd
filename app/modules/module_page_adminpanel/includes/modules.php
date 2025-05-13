<?php !isset($_SESSION['user_admin']) && get_iframe('013', 'Доступ закрыт') && die() ?>
<div class="col-md-7">
    <div class="card">
        <div class="card-header">
            <div class="flex_adm">
                <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Module_loading') ?></div>
                <div class="select-panel">
                    <select style="display: none;" class="custom-select" onChange="window.location.href=this.value" placeholder="<?= get_section('module_page', 'home') == 'sidebar' ? ' ' : $Translate->get_translate_module_phrase('module_page_adminpanel', '_Page') . ':' ?> <?= get_section('module_page', 'home') ?>">
                        <?php for ($i = 0; $i < $Modules->arr_module_init_page_count; $i++) {
                            $id_module = array_keys($Modules->arr_module_init['page'])[$i] ?>
                            <option value="<?= set_url_section(get_url(2), 'module_page', $id_module) ?>">
                                <a href="<?= set_url_section(get_url(2), 'module_page', $id_module) ?>"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Page') ?>: <?= $id_module ?></a>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-container">
            <?php if (get_section('module_page', 'home') != '') : ?>
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                        <?php
                        if (get_section('module_page', 'home') == 'sidebar') :
                            $c_m_p = sizeof($Modules->arr_module_init['sidebar']);
                        else :
                            $c_m_p = sizeof($Modules->arr_module_init['page'][get_section('module_page', 'home')]['interface'][get_section('module_interface_adjacent', 'afternavbar')]);
                        endif;
                        for ($i = 0; $i < $c_m_p; $i++) {
                            if (get_section('module_page', 'home') == 'sidebar') :
                                $data_id = $Modules->arr_module_init['sidebar'][$i];
                                $data_title = $Modules->array_modules[$Modules->arr_module_init['sidebar'][$i]]['title'];
                            else :
                                $data_id =  $Modules->arr_module_init['page'][get_section('module_page', 'home')]['interface'][get_section('module_interface_adjacent', 'afternavbar')][$i];
                                $data_title = $Modules->array_modules[$Modules->arr_module_init['page'][get_section('module_page', 'home')]['interface'][get_section('module_interface_adjacent', 'afternavbar')][$i]]['title'];
                            endif ?>
                            <li class="dd-item" data-id="<?= $data_id ?>">
                                <a class="module_setting" href="<?= $General->arr_general['site'] ?>adminpanel/?section=modules&options=<?= $data_id ?>">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path>
                                    </svg>
                                </a>
                                <div class="dd-handle"><?= $data_title ?></div>
                            </li>
                        <?php } ?>
                    </ol>
                    <input type="hidden" id="nestable-output">
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Options') ?></div>
        </div>
        <div class="card-container adm_block">
            <form class="form_adm_w100" id="clear_modules_initialization">
                <input class="secondary_btn w100" type="submit" name="clear_modules_initialization" Value="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_ClearallCache') ?>">
            </form>
        </div>
    </div>
</div>
<?php if (!empty($_GET['options'])) : ?>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Mset') ?> <?= $Modules->array_modules[$_GET['options']]['title'] ?></h5>
            </div>
            <form id="settings_modules_core">
                <div class="card-container module_block">
                    <div class="input-form"><div class="input_text"><?= $Translate->get_translate_module_phrase( 'module_page_adminpanel','_MMode')?></div>
                        <select name="module_type" style="display: none;" class="custom-select" placeholder="<?= (int) $Modules->array_modules[$_GET['options']]['setting']['type']?>">
                            <?php for ($ia = 0, $cia = sizeof( $_cia = explode(";", $Modules->array_modules[$_GET['options']]['setting']['available_types'])); $ia < $cia; $ia++ ):?>
                                <option value="<?= $_cia[$ia]?>"><?= $_cia[$ia]?></option>
                            <?php endfor?>
                        </select>
                    </div>
                </div>
                <div class="adm_save">
                    <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Save') ?>">
                </div>
            </form>
            <form id="settings_modules">
                <?php if ($_GET['options'] == 'module_page_leaderboard') : ?>
                    <div class="card-container module_block">
                        <input class="secondary_btn w100" type="submit" value="Очистить статистику">
                    </div>
                <?php endif; ?>
                <?php if ($_GET['options'] == 'module_page_profiles') : ?>
                    <div class="card-container module_block">
                        <?php $option = $Modules->get_settings_modules($_GET['options'], 'settings'); ?>
                        <div class="input-form">
                            <div class="input_text">Faceit API Key</div>
                            <input name="faceit_api_key" value="<?= $option['faceit_api_key'] ?>">
                        </div>
                        <div class="input-form">
                            <input class="border-checkbox" type="checkbox" name="use_all_vips_servers_in_one_table" id="use_all_vips_servers_in_one_table" <?php $option['use_all_vips_servers_in_one_table'] == 1 && print 'checked'; ?>>
                            <label class="border-checkbox-label" for="use_all_vips_servers_in_one_table">Одна база VIP игроков</label>
                        </div>
                        <div class="input-form">
                            <input class="border-checkbox" type="checkbox" name="punishment_all_servers" id="punishment_all_servers" <?php $option['punishment_all_servers'] == 1 && print 'checked'; ?>>
                            <label class="border-checkbox-label" for="punishment_all_servers">Наказания на всех серверах</label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($_GET['options'] == 'module_page_punishment') : ?>
                    <div class="card-container module_block">
                        <?php $option = $Modules->get_settings_modules($_GET['options'], 'settings'); ?>
                        <?php if (!empty($Db->db_data['IksAdmin'])) : ?>
                            <div class="input-form">
                                <div class="input_text">Какая структура базы IksAdmin?</div>
                                <select style="display: none;" class="custom-select" name="iks_db_new" placeholder="<?php if (!empty($option['iks_db_new'])) { echo 'Новая'; } else echo 'Старая (не рекомендуется)'; ?>">
                                    <option value="1">Новая</option>
                                    <option value="0">Старая (не рекомендуется)</option>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class="input-form">
                            <input class="border-checkbox" type="checkbox" name="punishment_all_servers" id="punishment_all_servers" <?php $option['punishment_all_servers'] == 1 && print 'checked'; ?>>
                            <label class="border-checkbox-label" for="punishment_all_servers">Наказания на всех серверах</label>
                        </div>
                        <div class="input-form">
                            <input class="border-checkbox" type="checkbox" name="func_unban" id="func_unban" <?php $option['func_unban'] == 1 && print 'checked'; ?>>
                            <label class="border-checkbox-label" for="func_unban">Включить продажу разбанов</label>
                        </div>
                        <div class="input-form">
                            <div class="input_text">Цена продажи разбанов</div>
                            <input name="price_unban" value="<?= $option['price_unban'] ?>">
                        </div>
                        <div class="input-form">
                            <input class="border-checkbox" type="checkbox" name="func_unmute" id="func_unmute" <?php $option['func_unmute'] == 1 && print 'checked'; ?>>
                            <label class="border-checkbox-label" for="func_unmute">Включить продажу размутов</label>
                        </div>
                        <div class="input-form">
                            <div class="input_text">Цена продажи размутов</div>
                            <input name="price_unmute" value="<?= $option['price_unmute'] ?>">
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ((!isset($_GET['baner_edit']) || $_GET['baner_edit'] === '') && $_GET['options'] == 'module_block_main_banner_slider') : ?>
                    <?php $option = $Modules->get_settings_modules($_GET['options'], 'settings'); ?>
                    <div class="card-container module_block">
                        <div class="input-form">
                            <div class="input_text">Название</div>
                            <input name="title">
                        </div>
                        <div class="input-form">
                            <div class="input_text">Описание</div>
                            <input name="description">
                        </div>
                        <div class="input-form">
                            <div class="input_text">Текст кнопки</div>
                            <input name="button_text">
                        </div>
                        <div class="input-form">
                            <div class="input_text">Ссылка кнопки</div>
                            <input name="button_url">
                        </div>
                        <div class="input-form">
                            <div class="input_text">Картинка</div>
                            <div class="file-upload-container">
                                <input type="file" id="file-input" class="custom-file-input" accept="image/*" name="file">
                                <label for="file-input">Выберите файл</label>
                                <div id="file-info" class="file-upload-info" style="display: block;"></div>
                            </div>
                        </div>
                    </div>
                <?php elseif ((isset($_GET['baner_edit']) || $_GET['baner_edit'] !== '') && $_GET['options'] == 'module_block_main_banner_slider') : $baner_edit = $Admin->info_modules_settings($_GET['baner_edit']); ?>
                    <?php $option = $Modules->get_settings_modules($_GET['options'], 'settings'); ?>
                    <div class="card-container module_block">
                        <div class="input-form">
                            <div class="input_text">Название</div>
                            <input name="title" value="<?= $baner_edit['title'] ?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text">Описание</div>
                            <input name="description" value="<?= $baner_edit['description'] ?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text">Текст кнопки</div>
                            <input name="button_text" value="<?= $baner_edit['button_text'] ?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text">Ссылка кнопки</div>
                            <input name="button_url" value="<?= $baner_edit['button_url'] ?>">
                        </div>
                        <div class="input-form">
                            <div class="input_text">Картинка</div>
                            <div class="file-upload-container">
                                <input type="file" id="file-input" class="custom-file-input" accept="image/*" name="file">
                                <label for="file-input">Выберите файл</label>
                                <div id="file-info" class="file-upload-info" style="display: block;"><?= $baner_edit['img'] ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($_GET['options'] == 'module_block_main_banner_slider' || $_GET['options'] == 'module_page_profiles' || $_GET['options'] == 'module_page_punishment') : ?>
                    <div class="adm_save">
                        <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Save') ?>">
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
<?php endif ?>
<?php if (!empty($_GET['options']) && $_GET['options'] == 'module_block_main_banner_slider') : ?>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h5 class="badge">Список банеров</h5>
                <div class="banners_list">
                    <?php foreach ($option['slides'] as $id => $key) : ?>
                        <div class="banner_content">
                            <div class="banner_rightside">
                                <div class="banner_peview">
                                    <div class="text">
                                        <div class="title"><?= $key['title'] ?></div>
                                        <div class="subtitle"><?= $key['description'] ?></div>
                                    </div>
                                    <div class="link" data-tippy-content="Ссылка" data-tippy-placement="left">
                                        <svg x="0" y="0" viewBox="0 0 277.279 277.279" xml:space="preserve">
                                            <g>
                                                <path d="m149.245 191.671-42.425 42.426-.001.001-.001.001c-17.544 17.545-46.092 17.546-63.638 0-8.5-8.5-13.18-19.801-13.18-31.82 0-12.018 4.68-23.317 13.177-31.817l.003-.003 42.425-42.426c5.857-5.858 5.857-15.356-.001-21.213-5.857-5.857-15.355-5.857-21.213 0l-42.425 42.426-.009.01C7.798 163.42 0 182.251 0 202.279c0 20.033 7.801 38.867 21.967 53.033C36.589 269.933 55.794 277.244 75 277.244c19.206 0 38.412-7.311 53.032-21.932v-.001l.001-.001 42.425-42.426c5.857-5.857 5.857-15.355-.001-21.213-5.856-5.857-15.353-5.857-21.212 0zM277.279 75c0-20.033-7.802-38.867-21.968-53.033-29.243-29.242-76.824-29.241-106.065 0l-.004.005-42.424 42.423c-5.858 5.857-5.858 15.356 0 21.213a14.952 14.952 0 0 0 10.607 4.394c3.838 0 7.678-1.465 10.606-4.394l42.424-42.423.005-.005c17.544-17.544 46.092-17.545 63.638 0 8.499 8.5 13.181 19.801 13.181 31.82 0 12.018-4.68 23.317-13.178 31.817l-.003.003-42.425 42.426c-5.857 5.857-5.857 15.355.001 21.213a14.954 14.954 0 0 0 10.606 4.394c3.839 0 7.678-1.465 10.607-4.394l42.425-42.426.009-.01C269.48 113.859 277.279 95.028 277.279 75z"></path>
                                                <path d="M85.607 191.671a14.954 14.954 0 0 0 10.606 4.394c3.839 0 7.678-1.465 10.607-4.394l84.852-84.852c5.858-5.857 5.858-15.355 0-21.213-5.857-5.857-15.355-5.857-21.213 0l-84.852 84.851c-5.858 5.859-5.858 15.357 0 21.214z"></path>
                                            </g>
                                        </svg>
                                        <?= $key['button_url'] ?>
                                    </div>
                                    <div class="btn"><?= $key['button_text'] ?></div>
                                    <div class="shadow"></div>
                                    <img src="/app/modules/module_block_main_banner_slider/assets/img/<?= $key['img'] ?>" alt="">
                                </div>
                                <div class="banner_actions">
                                    <a class="w100" href="<?= set_url_section(get_url(2), 'baner_edit', $id) ?>">
                                        <button class="secondary_btn w100">
                                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_change_menu') ?>
                                        </button>
                                    </a>
                                    <button class="btn_delete secondary_btn w100" id="baner_del" id_del="<?= $id ?>">
                                        <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_delete') ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
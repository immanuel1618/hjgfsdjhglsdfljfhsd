<?php !isset($_SESSION['user_admin']) && get_iframe('013', 'Доступ закрыт') && die() ?>
<?php if ($_GET['new_navbar'] && !$_GET['edit_categories'] && !$_GET['edit_point']) : ?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $_GET['new_navbar'] == 1 ? 'Создание категории' : 'Создание пункта' ?></h5>
            </div>
            <div class="card-container option_one">
                <form id="add_point">
                    <div class="input-form">
                        <div class="input_text"><?= $_GET['new_navbar'] == 1 ? 'Название категории' : 'Название пункта' ?>
                        </div><input name="title" placeholder="<?= $_GET['new_navbar'] == 1 ? 'Название категории' : 'Название пункта' ?>" required>
                    </div>
                    <div class="input-form">
                        <div class="input_text">
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_icon') ?> <a href="https://fontawesome.com/icons" target="_blank"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Icons_here') ?></a>
                        </div><input name="svg" placeholder="<svg viewBox=0 0 512 512><path d=M49..." required>
                    </div>
                    <?php if ($_GET['new_navbar'] == 2) : ?>
                        <div class="input-form">
                            <div class="input_text">
                                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_link') ?></div>
                            <input name="link" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_link_place') ?>" required>
                        </div>
                        <div class="input-form">
                            <div class="input_text">Категория для этого пункта</div>
                            <select style="display: none;" class="custom-select" name="category" id="categorySelect" placeholder="Если необходимо выберите категорию">
                                <option value="">Не помещать в категорию</option>
                                <?php foreach ($menu_categories as $category) : ?>
                                    <option value="<?= $category['numid'] ?>"><?= $category['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-form" id="descriptionDiv">
                            <div class="input_text">Описание пункта</div><input name="description" placeholder="Топ любимых игроков ❤️">
                        </div>
                        <div class="input-form" id="sortCategoryDiv">
                            <div class="input_text">Порядковый номер пункта в категории</div>
                            <div class="input_wrapper">
                                <div class="number">
                                    <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                    <input name="sort_category" min="1" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_sort_place') ?>" type="number">
                                    <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="input-form" id="sortDiv">
                        <div class="input_text">
                            <?= $_GET['new_navbar'] == 1 ? 'Порядковый номер категории' : $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_sort') . ' пункта' ?>
                        </div>
                        <div class="input_wrapper">
                            <div class="number">
                                <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                <input name="sort" min="1" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_sort_place') ?>" type="number">
                                <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="only_admin" id="only_admin">
                        <label class="border-checkbox-label" for="only_admin">Отображается только админам сайта</label>
                    </div>
                    <input class="secondary_btn mt10" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_add') ?>">
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (!$_GET['new_navbar'] && $_GET['edit_categories'] || $_GET['edit_point']) :
    $_GET['edit_categories'] ? $category_menu = $Admin->GetMenuCategory($_GET['edit_categories']) : $point_menu = $Admin->GetMenuPoint($_GET['edit_point']); ?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $_GET['edit_categories'] ? 'Редактирование категории' : 'Редактирование пункта' ?>
                </h5>
            </div>
            <div class="card-container option_one">
                <form id="edit_point">
                    <input type="hidden" name="editid" value="<?= $_GET['edit_categories'] ? $category_menu['numid'] : $point_menu['id'] ?>">
                    <div class="input-form">
                        <div class="input_text"><?= $_GET['edit_categories'] ? 'Название категории' : 'Название пункта' ?>
                        </div><input name="title" placeholder="<?= $_GET['edit_categories'] ? 'Название категории' : 'Название пункта' ?>" value="<?= $_GET['edit_categories'] ? $category_menu['title'] : $point_menu['title'] ?>" required>
                    </div>
                    <div class="input-form">
                        <div class="input_text">
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_icon') ?> <a href="https://fontawesome.com/icons" target="_blank"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Icons_here') ?></a>
                        </div><input name="svg" placeholder="<svg viewBox=0 0 512 512><path d=M49..." value="<?= $_GET['edit_categories'] ? str_replace('"', "'", $category_menu['svg']) : str_replace('"', "'", $point_menu['svg']) ?>" required>
                    </div>
                    <?php if ($_GET['edit_point']) : ?>
                        <div class="input-form">
                            <div class="input_text">
                                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_link') ?></div>
                            <input name="link" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_link_place') ?>" value="<?= $_GET['edit_categories'] ? $category_menu['link'] : $point_menu['link'] ?>" required>
                        </div>
                        <div class="input-form">
                            <div class="input_text">Категория для этого пункта</div>
                            <select name="category" id="categorySelect">
                                <option value="">Не помещать в категорию</option>
                                <?php foreach ($menu_categories as $category) : ?>
                                    <option <?= $point_menu['category'] == $category['numid'] ? 'selected' : '' ?> value="<?= $category['numid'] ?>"><?= $category['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-form" id="descriptionDiv">
                            <div class="input_text">Описание пункта</div><input name="description" value="<?= $_GET['edit_categories'] ? $category_menu['description'] : $point_menu['description'] ?>" placeholder="Топ любимых игроков ❤️">
                        </div>
                        <div class="input-form" id="sortCategoryDiv">
                            <div class="input_text">Порядковый номер пункта в категории</div>
                            <div class="input_wrapper">
                                <div class="number">
                                    <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                    <input name="sort_category" min="1" value="<?= $_GET['edit_categories'] ? $category_menu['sort_category'] : $point_menu['sort_category'] ?>" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_sort_place') ?>" type="number">
                                    <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="input-form" id="sortDiv">
                        <div class="input_text">
                            <?= $_GET['edit_categories'] ? 'Порядковый номер категории' : $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_sort') . ' пункта' ?>
                        </div>
                        <div class="input_wrapper">
                            <div class="number">
                                <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                <input name="sort" min="1" value="<?= $_GET['edit_categories'] ? $category_menu['sort'] : $point_menu['sort'] ?>" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_sort_place') ?>" type="number">
                                <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="input-form">
                        <input class="border-checkbox" type="checkbox" name="only_admin" id="only_admin" <?= $_GET['edit_categories'] ? ($category_menu['only_admin'] == 1 ? 'checked' : '') : ($point_menu['only_admin'] == 1 ? 'checked' : '') ?>>
                        <label class="border-checkbox-label" for="only_admin">Отображается только админам сайта</label>
                    </div>
                    <input class="secondary_btn mt10" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_add') ?>">
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($_GET['new_navbar'] || $_GET['edit_categories'] || $_GET['edit_point']) : ?>
    <div class="col-md-8"><?php else : ?><div class="col-md-12"><?php endif; ?>
        <div class="card">
            <div class="card-header">
                <h5 class="badge">Навигация
                    <div class="create_buttons">
                        <a href="<?= $General->arr_general['site'] ?>adminpanel/?section=template&new_navbar=1">
                            <button class="secondary_btn">
                                <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                                    <g>
                                        <path d="M28 8H16.13a1 1 0 0 1-.853-.484l-1.84-3.061A3.012 3.012 0 0 0 10.87 3H4a3 3 0 0 0-3 3v20a3 3 0 0 0 3 3h24a3 3 0 0 0 3-3V11a3 3 0 0 0-3-3zm-8 12h-3v3a1 1 0 0 1-2 0v-3h-3a1 1 0 0 1 0-2h3v-3a1 1 0 0 1 2 0v3h3a1 1 0 0 1 0 2z">
                                        </path>
                                        <path d="M27.82 6H16.7l-1.2-2H25a3 3 0 0 1 2.82 2z"></path>
                                    </g>
                                </svg>
                                Создать категорию
                            </button>
                        </a>
                        <a href="<?= $General->arr_general['site'] ?>adminpanel/?section=template&new_navbar=2">
                            <button class="secondary_btn">
                                <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                    <g>
                                        <path d="M14.25 0H2.75C1.23 0 0 1.23 0 2.75v15.5C0 19.77 1.23 21 2.75 21h6.59a8.731 8.731 0 0 1-.84-3.75c0-1.15.22-2.25.63-3.26-.04.01-.08.01-.13.01H4c-.55 0-1-.45-1-1s.45-1 1-1h5c.38 0 .72.22.88.54A8.827 8.827 0 0 1 12.36 10H4c-.55 0-1-.45-1-1s.45-1 1-1h9c.55 0 1 .45 1 1 0 .05 0 .09-.01.13.93-.38 1.95-.6 3.01-.62V2.75C17 1.23 15.77 0 14.25 0zM8 6H4c-.55 0-1-.45-1-1s.45-1 1-1h4c.55 0 1 .45 1 1s-.45 1-1 1z">
                                        </path>
                                        <path d="M17.25 10.5c-3.722 0-6.75 3.028-6.75 6.75S13.528 24 17.25 24 24 20.972 24 17.25s-3.028-6.75-6.75-6.75zM20 18.25h-1.75V20a1 1 0 0 1-2 0v-1.75H14.5a1 1 0 0 1 0-2h1.75V14.5a1 1 0 0 1 2 0v1.75H20a1 1 0 0 1 0 2z">
                                        </path>
                                    </g>
                                </svg>
                                Создать пункт
                            </button>
                        </a>
                    </div>
                </h5>
            </div>
            <div class="card-container">
                <div class="adm_nav_list no-scrollbar">
                    <?php foreach ($combined_menu as $item) : 
                        if ($item['is_category']) : 
                            $category_id = $item['numid'];
                            $menu_items = array_filter($combined_menu, function($menu_item) use ($category_id) {
                                return !$menu_item['is_category'] && $menu_item['category'] == $category_id;
                            });
                            usort($menu_items, function ($a, $b) {
                                return $a['sort_category'] <=> $b['sort_category'];
                            }); ?>
                            <div class="adm_nav_cat_point">
                                <span class="adm_nav_sort_cat_point"><?= $item['sort']; ?></span>
                                <div>
                                    <span class="cat_title">Категория</span>
                                    <span class="cat_name"><?= $item['title']; ?></span>
                                </div>
                                <?= $item['svg']; ?>
                                <div class="adm_cat_point_action">
                                    <a href="<?= $General->arr_general['site'] ?>adminpanel/?section=template&edit_categories=<?= $item['numid'] ?>">
                                        <button class="secondary_btn">Изменить</button>
                                    </a>
                                    <button class="secondary_btn btn_delete" id="category_del" id_del="<?= $item['numid'] ?>">Удалить</button>
                                </div>
                            </div>
                            <?php foreach ($menu_items as $menu_item) : ?>
                                <div class="adm_nav_point">
                                    <div class="point_left">
                                        <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                                            <g>
                                                <path fill-rule="evenodd" d="m448.075 379.743-88.108-88.11a25.88 25.88 0 0 0-36.6 36.6l43.933 43.929H228.1c-66.277 0-120.5-54.226-120.5-120.5V25.639a25.641 25.641 0 0 0-51.282 0c0 75.335-.478 150.719-.478 226.02 0 94.745 77.519 172.264 172.264 172.264h139.2l-43.927 43.928a25.88 25.88 0 0 0 36.6 36.6l87.905-87.905c10.835-10.846 11.207-25.791.193-36.803z">
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="adm_nav_piont_details">
                                        <span class="adm_nav_sort_cat_point"><?= $menu_item['sort_category']; ?></span>
                                        <div class="point_details">
                                            <span class="point_name" data-tippy-content="Ссылка ⤵<br><?= $menu_item['link']; ?>"><?= $menu_item['title']; ?></span>
                                            <?php if (!empty($menu_item['description'])) : ?>
                                                <span class="point_description"><?= $menu_item['description']; ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?= $menu_item['svg']; ?>
                                        </div>
                                        <div class="adm_cat_point_action">
                                            <a href="<?= $General->arr_general['site'] ?>adminpanel/?section=template&edit_point=<?= $menu_item['id'] ?>">
                                                <button class="secondary_btn">Изменить</button>
                                            </a>
                                            <button class="secondary_btn btn_delete" id="point_del" id_del="<?= $menu_item['id'] ?>">Удалить</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: 
                            if (empty($item['category'])) : ?>
                            <div class="adm_nav_cat_point">
                                <span class="adm_nav_sort_cat_point"><?= $item['sort']; ?></span>
                                <div>
                                    <span class="cat_title">Пункт</span>
                                    <span class="cat_name" data-tippy-content="Ссылка ⤵<br><?= $item['link']; ?>"><?= $item['title']; ?></span>
                                </div>
                                <?= $item['svg']; ?>
                                <div class="adm_cat_point_action">
                                    <a href="<?= $General->arr_general['site'] ?>adminpanel/?section=template&edit_point=<?= $item['id'] ?>">
                                        <button class="secondary_btn">Изменить</button>
                                    </a>
                                    <button class="secondary_btn btn_delete" id="point_del" id_del="<?= $item['id'] ?>">Удалить</button>
                                </div>
                            </div>
                        <?php endif;
                        endif;
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<div class="col-md-12">
    <?php if (($Db->mysql_column_search('Core', 0, 0, 'lr_web_notifications', 'title') && $Db->mysql_column_search('Core', 0, 0, 'lr_web_notifications', 'button')) == false) : ?>
        <form id="create_table_noty" style="margin-bottom: 10px;">
            <button class="secondary_btn w100">Обновить таблицы уведомлений</button>
        </form>
    <?php endif; ?>
    <div class="card">
        <div class="card-header">
            <h5 class="badge">
                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Info_social') ?>
            </h5>
        </div>
        <div class="card-container option_one">
            <form id="add_info">
                <div class="custom_flex_inputs">
                    <div class="input-form">
                        <div class="input_text">
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Nav_footer_text') ?>
                        </div><input name="site_name" placeholder="Sitename#CS2" value="<?= $settings_neo['SiteName'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text">
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logo') ?>
                        </div><input name="svg_logo" placeholder="<svg viewBox=0 0 512 512><path d=M49..." value="<?= htmlentities($settings_neo['SVGLogo']) ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text">
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_tech') ?>
                        </div><input name="support_link" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_placeholder') ?>" value="<?= $settings_neo['SupportLink'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text vk">
                            <svg class="vk" viewBox="0 0 448 512">
                                <path d="M31.4907 63.4907C0 94.9813 0 145.671 0 247.04V264.96C0 366.329 0 417.019 31.4907 448.509C62.9813 480 113.671 480 215.04 480H232.96C334.329 480 385.019 480 416.509 448.509C448 417.019 448 366.329 448 264.96V247.04C448 145.671 448 94.9813 416.509 63.4907C385.019 32 334.329 32 232.96 32H215.04C113.671 32 62.9813 32 31.4907 63.4907ZM75.6 168.267H126.747C128.427 253.76 166.133 289.973 196 297.44V168.267H244.16V242C273.653 238.827 304.64 205.227 315.093 168.267H363.253C359.313 187.435 351.46 205.583 340.186 221.579C328.913 237.574 314.461 251.071 297.733 261.227C316.41 270.499 332.907 283.63 346.132 299.751C359.357 315.873 369.01 334.618 374.453 354.747H321.44C316.555 337.262 306.614 321.61 292.865 309.754C279.117 297.899 262.173 290.368 244.16 288.107V354.747H238.373C136.267 354.747 78.0267 284.747 75.6 168.267Z">
                                </path>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_vk') ?>
                        </div>
                        <input name="vk" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_placeholder') ?>" value="<?= $settings_neo['VK'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text tg">
                            <svg class="tg" x="0" y="0" viewBox="0 0 100 100" xml:space="preserve">
                                <g>
                                    <path d="M89.442 11.418c-12.533 5.19-66.27 27.449-81.118 33.516-9.958 3.886-4.129 7.529-4.129 7.529s8.5 2.914 15.786 5.1 11.172-.243 11.172-.243l34.244-23.073c12.143-8.257 9.229-1.457 6.315 1.457-6.315 6.315-16.758 16.272-25.501 24.287-3.886 3.4-1.943 6.315-.243 7.772 6.315 5.343 23.558 16.272 24.53 17.001 5.131 3.632 15.223 8.861 16.758-2.186l6.072-38.13c1.943-12.872 3.886-24.773 4.129-28.173.728-8.257-8.015-4.857-8.015-4.857z">
                                    </path>
                                </g>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_tg') ?>
                        </div>
                        <input name="tg" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_placeholder') ?>" value="<?= $settings_neo['TG'] ?>">
                    </div>
                </div>
                <div class="custom_flex_inputs">
                    <div class="input-form">
                        <div class="input_text ds">
                            <svg class="ds" viewBox="0 0 640 512">
                                <path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z">
                                </path>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_ds') ?>
                        </div>
                        <input name="ds" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_placeholder') ?>" value="<?= $settings_neo['DS'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text steam">
                            <svg class="steam" viewBox="0 0 496 512">
                                <path d="M496 256c0 137-111.2 248-248.4 248-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4 39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5 0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8 384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.79 52.79 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4 5.4-13 5.5-27.3.1-40.3-5.4-13-15.5-23.2-28.5-28.6-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3 62.4 28 62.4 62.3-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8 0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z">
                                </path>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_steam') ?>
                        </div>
                        <input name="steam" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_placeholder') ?>" value="<?= $settings_neo['Steam'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text yt">
                            <svg class="yt" viewBox="0 0 576 512">
                                <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z">
                                </path>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_yt') ?>
                        </div>
                        <input name="yt" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_placeholder') ?>" value="<?= $settings_neo['YT'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text tt">
                            <svg class="tt" viewBox="0 0 448 512">
                                <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z">
                                </path>
                            </svg>
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_tt') ?>
                        </div>
                        <input name="tt" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Link_placeholder') ?>" value="<?= $settings_neo['TT'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text">
                            <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Email') ?>
                        </div><input name="contact_email" placeholder="nameproject@email.com" value="<?= $settings_neo['ContactEmail'] ?>">
                    </div>
                </div>
                <input class='secondary_btn mt10' type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Save') ?>">
            </form>
        </div>
    </div>
</div>
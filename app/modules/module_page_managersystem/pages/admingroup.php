<?php switch ($res_system[$server_group]['admin_mod']) {
    case 'AdminSystem': ?>
        <div class="container_grid">
            <div class="fix_grid">
                <div class="container_text_access">
                    <svg viewBox="0 0 512 512">
                        <path d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z" />
                    </svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListGroup') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListGroupDesc') ?></span>
                    </div>
                </div>
                <div class="card_settings_table">
                    <div class="table_4_group_head">
                        <span class="col_1"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup') ?></span>
                        <span class="col_2"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlags') ?></span>
                        <span class="col_3"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSImmunitet') ?></span>
                        <span class="col_4"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDeystvie') ?></span>
                    </div>
                    <div class="flex_column_gap table_4_scroll scroll">
                        <?php foreach ($Core->AdminCore()->Groups() as $key) : ?>
                            <ul class="table_4_group_list">
                                <li>
                                    <span class="col_1"><?= action_text_clear(action_text_trim($key['name'], 20)) ?></span>
                                    <span class="col_2"><?= $key['flags'] ?></span>
                                    <span class="col_3"><?= $key['immunity'] ?></span>
                                    <span class="col_4">
                                        <button class="btn_del_table" id="ms_admin_group_del" id_del="<?= $key['id'] ?>"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelGroup') ?></button>
                                    </span>
                                </li>
                            </ul>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <form id="ms_admin_group_add">
                <div class="container_text_access2">
                    <svg viewBox="0 0 576 512">
                        <path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                    </svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddGroup') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormAddGroup') ?></span>
                    </div>
                </div>
                <div class="card_settings">
                    <div class="h411_max scroll">
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 576 512">
                                        <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V428.7c-2.7 1.1-5.4 2-8.2 2.7l-60.1 15c-3 .7-6 1.2-9 1.4c-.9 .1-1.8 .2-2.7 .2H240c-6.1 0-11.6-3.4-14.3-8.8l-8.8-17.7c-1.7-3.4-5.1-5.5-8.8-5.5s-7.2 2.1-8.8 5.5l-8.8 17.7c-2.9 5.9-9.2 9.4-15.7 8.8s-12.1-5.1-13.9-11.3L144 381l-9.8 32.8c-6.1 20.3-24.8 34.2-46 34.2H80c-8.8 0-16-7.2-16-16s7.2-16 16-16h8.2c7.1 0 13.3-4.6 15.3-11.4l14.9-49.5c3.4-11.3 13.8-19.1 25.6-19.1s22.2 7.8 25.6 19.1l11.6 38.6c7.4-6.2 16.8-9.7 26.8-9.7c15.9 0 30.4 9 37.5 23.2l4.4 8.8h8.9c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7L384 203.6V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM549.8 139.7c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM311.9 321c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L512.1 262.7l-71-71L311.9 321z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup2') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameGroup') ?>" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="name_group" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameGroup2') ?>" required>
                            </div>
                        </div>
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 448 512">
                                    <path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z" />
                                </svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsGroup') ?>
                            </div>
                            <div class="card_button_flex_more">
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_z" value="z" id="flag_z">
                                    <label for="flag_z" class="border-checkbox-label">Z - ROOT</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_a" value="a" id="flag_a">
                                    <label for="flag_a" class="border-checkbox-label">A - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsA') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_b" value="b" id="flag_b">
                                    <label for="flag_b" class="border-checkbox-label">B - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsB') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_c" value="c" id="flag_c">
                                    <label for="flag_c" class="border-checkbox-label">C - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsC') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_d" value="d" id="flag_d">
                                    <label for="flag_d" class="border-checkbox-label">D - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsD') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_e" value="e" id="flag_e">
                                    <label for="flag_e" class="border-checkbox-label">E - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsE') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_f" value="f" id="flag_f">
                                    <label for="flag_f" class="border-checkbox-label">F - Kill</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_g" value="g" id="flag_g">
                                    <label for="flag_g" class="border-checkbox-label">G - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsF') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_h" value="h" id="flag_h">
                                    <label for="flag_h" class="border-checkbox-label">H - Cvars</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_i" value="i" id="flag_i">
                                    <label for="flag_i" class="border-checkbox-label">I - Config</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_j" value="j" id="flag_j">
                                    <label for="flag_j" class="border-checkbox-label">J - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsG') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_k" value="k" id="flag_k">
                                    <label for="flag_k" class="border-checkbox-label">K - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsK') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_l" value="l" id="flag_l">
                                    <label for="flag_l" class="border-checkbox-label">L - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsL') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_m" value="m" id="flag_m">
                                    <label for="flag_m" class="border-checkbox-label">M - Rcon</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_n" value="n" id="flag_n">
                                    <label for="flag_n" class="border-checkbox-label">N - Cheats</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_o" value="o" id="flag_o">
                                    <label for="flag_o" class="border-checkbox-label">O - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 1</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_p" value="p" id="flag_p">
                                    <label for="flag_p" class="border-checkbox-label">P - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 2</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_m" value="q" id="flag_q">
                                    <label for="flag_q" class="border-checkbox-label">Q - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 3</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_r" value="r" id="flag_r">
                                    <label for="flag_r" class="border-checkbox-label">R - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 4</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_s" value="s" id="flag_s">
                                    <label for="flag_s" class="border-checkbox-label">S - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 5</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_t" value="t" id="flag_t">
                                    <label for="flag_t" class="border-checkbox-label">T - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 6</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_u" value="u" id="flag_u">
                                    <label for="flag_u" class="border-checkbox-label">U - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 7</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_v" value="v" id="flag_v">
                                    <label for="flag_v" class="border-checkbox-label">V - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 8</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_w" value="w" id="flag_w">
                                    <label for="flag_w" class="border-checkbox-label">W - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 9</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_x" value="x" id="flag_x">
                                    <label for="flag_x" class="border-checkbox-label">X - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 10</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_y" value="y" id="flag_y">
                                    <label for="flag_y" class="border-checkbox-label">Y - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 11</label>
                                </div>
                            </div>
                        </div>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSImunnGroup') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <div class="number">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSImunnGroupImput') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                    <input type="number" min="1" max="100" name="immunity_group" placeholder="1-100" required>
                                    <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddGroup') ?>">
                </div>
            </form>
        </div>
    <?php break;
    case 'IksAdmin': ?>
        <div class="container_grid">
            <div class="fix_grid">
                <div class="container_text_access">
                    <svg viewBox="0 0 512 512">
                        <path d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z" />
                    </svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListGroup') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListGroupDesc') ?></span>
                    </div>
                </div>
                <div class="card_settings_table">
                    <div class="table_4_group_head">
                        <span class="col_1"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup') ?></span>
                        <span class="col_2"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlags') ?></span>
                        <span class="col_3"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSImmunitet') ?></span>
                        <span class="col_4"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDeystvie') ?></span>
                    </div>
                    <div class="flex_column_gap table_4_scroll scroll">
                        <?php foreach ($Core->AdminCore()->Groups() as $key) : ?>
                            <ul class="table_4_group_list">
                                <li>
                                    <span class="col_1"><?= action_text_clear(action_text_trim($key['name'], 20)) ?></span>
                                    <span class="col_2"><?= $key['flags'] ?></span>
                                    <span class="col_3"><?= $key['immunity'] ?></span>
                                    <span class="col_4">
                                        <button class="btn_del_table" id="ms_admin_group_del" id_del="<?= $key['id'] ?>"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelGroup') ?></button>
                                    </span>
                                </li>
                            </ul>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <form id="ms_admin_group_add">
                <div class="container_text_access2">
                    <svg viewBox="0 0 576 512">
                        <path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z" />
                    </svg>
                    <div class="container_text_settings_text">
                        <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddGroup') ?></span>
                        <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormAddGroup') ?></span>
                    </div>
                </div>
                <div class="card_settings">
                    <div class="h411_max scroll">
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 576 512">
                                        <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V428.7c-2.7 1.1-5.4 2-8.2 2.7l-60.1 15c-3 .7-6 1.2-9 1.4c-.9 .1-1.8 .2-2.7 .2H240c-6.1 0-11.6-3.4-14.3-8.8l-8.8-17.7c-1.7-3.4-5.1-5.5-8.8-5.5s-7.2 2.1-8.8 5.5l-8.8 17.7c-2.9 5.9-9.2 9.4-15.7 8.8s-12.1-5.1-13.9-11.3L144 381l-9.8 32.8c-6.1 20.3-24.8 34.2-46 34.2H80c-8.8 0-16-7.2-16-16s7.2-16 16-16h8.2c7.1 0 13.3-4.6 15.3-11.4l14.9-49.5c3.4-11.3 13.8-19.1 25.6-19.1s22.2 7.8 25.6 19.1l11.6 38.6c7.4-6.2 16.8-9.7 26.8-9.7c15.9 0 30.4 9 37.5 23.2l4.4 8.8h8.9c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7L384 203.6V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM549.8 139.7c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM311.9 321c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L512.1 262.7l-71-71L311.9 321z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup2') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameGroup') ?>" data-tippy-placement="right">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="name_group" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameGroup2') ?>" required>
                            </div>
                        </div>
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 448 512">
                                    <path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z" />
                                </svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsGroup') ?>
                            </div>
                            <div class="card_button_flex_more">
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_z" value="z" id="flag_z">
                                    <label for="flag_z" class="border-checkbox-label">Z - ROOT</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_b" value="b" id="flag_b">
                                    <label for="flag_b" class="border-checkbox-label">B - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsD') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_k" value="k" id="flag_k">
                                    <label for="flag_k" class="border-checkbox-label">K - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsC') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_m" value="m" id="flag_m">
                                    <label for="flag_m" class="border-checkbox-label">M - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsG') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_g" value="g" id="flag_g">
                                    <label for="flag_g" class="border-checkbox-label">G - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsW') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_u" value="u" id="flag_u">
                                    <label for="flag_u" class="border-checkbox-label">U - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsE') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_s" value="s" id="flag_s">
                                    <label for="flag_s" class="border-checkbox-label">S - Kill</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_t" value="t" id="flag_t">
                                    <label for="flag_t" class="border-checkbox-label">T - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsT') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_c" value="c" id="flag_c">
                                    <label for="flag_c" class="border-checkbox-label">C - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsF') ?></label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_o" value="o" id="flag_o">
                                    <label for="flag_o" class="border-checkbox-label">O - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 1</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_p" value="p" id="flag_p">
                                    <label for="flag_p" class="border-checkbox-label">P - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 2</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_m" value="q" id="flag_q">
                                    <label for="flag_q" class="border-checkbox-label">Q - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 3</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_r" value="r" id="flag_r">
                                    <label for="flag_r" class="border-checkbox-label">R - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 4</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_v" value="v" id="flag_v">
                                    <label for="flag_v" class="border-checkbox-label">V - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 5</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_w" value="w" id="flag_w">
                                    <label for="flag_w" class="border-checkbox-label">W - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 6</label>
                                </div>
                                <div class="check_button_card input-form">
                                    <input class="border-checkbox" type="checkbox" name="flag_x" value="x" id="flag_x">
                                    <label for="flag_x" class="border-checkbox-label">X - <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFlagsDop') ?> 7</label>
                                </div>
                            </div>
                        </div>
                        <div class="input_container">
                            <div class="input_form">
                                <div class="input_text">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0z" />
                                    </svg>
                                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSImunnGroup') ?>
                                </div>
                            </div>
                            <div class="input_wrapper">
                                <div class="number">
                                    <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSImunnGroupImput') ?>" data-tippy-placement="right">
                                        <svg viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                                        </svg>
                                    </span>
                                    <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                    <input type="number" min="1" max="100" name="immunity_group" placeholder="1-100" required>
                                    <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddGroup') ?>">
                </div>
            </form>
        </div>
<?php break;
} ?>
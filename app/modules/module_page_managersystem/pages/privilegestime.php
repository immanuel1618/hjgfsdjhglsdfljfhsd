<div class="container_grid">
    <div class="fix_grid">
        <div class="container_text_access">
            <svg viewBox="0 0 512 512">
                <path
                    d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z" />
            </svg>
            <div class="container_text_settings_text">
                <span
                    class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSListTime') ?></span>
                <span
                    class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPrivTime') ?></span>
            </div>
        </div>
        <div class="card_settings_table">
            <div class="table_3_group_head">
                <span
                    class="col_1"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameGroup') ?></span>
                <span
                    class="col_2"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSTime222') ?></span>
                <span
                    class="col_3"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDeystvie') ?></span>
            </div>
            <div class="flex_column_gap table_4_scroll scroll">
                <?php foreach ($Core->GetCache('privilegestime') as $key): ?>
                    <ul class="table_3_group_list">
                        <li>
                            <span class="col_1"><?= action_text_clear(action_text_trim($key['name_time'], 30)) ?></span>
                            <span class="col_2"><?= $key['duration'] ?></span>
                            <span class="col_3">
                                <button class="btn_del_table" id="ms_privileges_time_del"
                                    id_del="<?= $key['id'] ?>"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDelTime') ?></button>
                            </span>
                        </li>
                    </ul>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <form id="ms_privileges_time_add">
        <div class="container_text_access2">
            <svg viewBox="0 0 640 512">
                <path
                    d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 352h8.2c32.3-39.1 81.1-64 135.8-64c5.4 0 10.7 .2 16 .7V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM320 352H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H360.2C335.1 449.6 320 410.5 320 368c0-5.4 .2-10.7 .7-16l-.7 0zm320 16a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zM496 288c8.8 0 16 7.2 16 16v48h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H496c-8.8 0-16-7.2-16-16V304c0-8.8 7.2-16 16-16z" />
            </svg>
            <div class="container_text_settings_text">
                <span
                    class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddTime222') ?></span>
                <span
                    class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSFormDescTime') ?></span>
            </div>
        </div>
        <div class="card_settings">
            <div class="h411_max scroll">
                <div class="flex_column_gap">
                    <div class="input_container">
                        <div class="input_form">
                            <div class="input_text">
                                <svg viewBox="0 0 576 512">
                                    <path
                                        d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V428.7c-2.7 1.1-5.4 2-8.2 2.7l-60.1 15c-3 .7-6 1.2-9 1.4c-.9 .1-1.8 .2-2.7 .2H240c-6.1 0-11.6-3.4-14.3-8.8l-8.8-17.7c-1.7-3.4-5.1-5.5-8.8-5.5s-7.2 2.1-8.8 5.5l-8.8 17.7c-2.9 5.9-9.2 9.4-15.7 8.8s-12.1-5.1-13.9-11.3L144 381l-9.8 32.8c-6.1 20.3-24.8 34.2-46 34.2H80c-8.8 0-16-7.2-16-16s7.2-16 16-16h8.2c7.1 0 13.3-4.6 15.3-11.4l14.9-49.5c3.4-11.3 13.8-19.1 25.6-19.1s22.2 7.8 25.6 19.1l11.6 38.6c7.4-6.2 16.8-9.7 26.8-9.7c15.9 0 30.4 9 37.5 23.2l4.4 8.8h8.9c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7L384 203.6V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM549.8 139.7c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM311.9 321c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L512.1 262.7l-71-71L311.9 321z" />
                                </svg>
                                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameTime') ?>
                            </div>
                        </div>
                        <div class="input_wrapper">
                            <span
                                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameTimeInput') ?>"
                                data-tippy-placement="right">
                                <svg viewBox="0 0 512 512">
                                    <path
                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z">
                                    </path>
                                </svg>
                            </span>
                            <input type="text" name="name_time"
                                placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameTimeInputYou') ?>"
                                required>
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <?php if ($General->arr_general['theme'] == 'neo'): ?>
                            <div class="number">
                            <?php endif; ?>
                            <span
                                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MS0ForevTime') ?>"
                                data-tippy-placement="right">
                                <svg viewBox="0 0 512 512">
                                    <path
                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z">
                                    </path>
                                </svg>
                            </span>
                            <?php if ($General->arr_general['theme'] == 'neo'): ?>
                                <button class="number-minus" type="button"
                                    onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                <input type="number" min="0" name="duration"
                                    placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>"
                                    required>
                                <button class="number-plus" type="button"
                                    onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                            <?php else: ?>
                                <input type="number" name="duration"
                                    placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSLibTimeSec') ?>"
                                    required>
                            <?php endif; ?>
                        </div>
                        <?php if ($General->arr_general['theme'] == 'neo'): ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <input class="secondary_btn w100" type="submit"
                value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddTime222') ?>">
        </div>
    </form>
</div>
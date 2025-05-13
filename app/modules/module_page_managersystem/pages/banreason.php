<div class="container_grid">
    <div class="fix_grid">
        <div class="container_text_access">
        <svg viewBox="0 0 512 512"><path d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"/></svg>
            <div class="container_text_settings_text">
                <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonList') ?></span>
                <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonListDesc') ?></span>
            </div>
        </div>
        <div class="card_settings_table">
            <div class="table_2_group_head">
                <span class="col_1"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAdd') ?></span>
                <span class="col_2"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDeystvie') ?></span>
            </div>
            <div class="flex_column_gap table_4_scroll scroll">
                <?php foreach ($Core->GetCache('reasonban') as $key) : ?>
                    <ul class="table_2_group_list">
                        <li>
                            <span class="col_1"><?= $key['reason_name'] ?></span>
                            <span class="col_2">
                                <button class="btn_del_table" id="ms_reason_ban_del" id_del="<?= $key['id'] ?>"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonDelForm') ?></button>
                            </span>
                        </li>
                    </ul>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <form id="ms_reason_ban_add">
        <div class="container_text_access2">
        <svg viewBox="0 0 512 512"><path d="M512 416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H192c20.1 0 39.1 9.5 51.2 25.6l19.2 25.6c6 8.1 15.5 12.8 25.6 12.8H448c35.3 0 64 28.7 64 64V416zM232 376c0 13.3 10.7 24 24 24s24-10.7 24-24V312h64c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V200c0-13.3-10.7-24-24-24s-24 10.7-24 24v64H168c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64z"/></svg>
            <div class="container_text_settings_text">
                <span class="settings_header_text_top"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAddCreate') ?></span>
                <span class="settings_header_text_bottom"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonListDescForm') ?></span>
            </div>
        </div>
        <div class="card_settings">
            <div class="h411_max scroll">
                <div class="input_container">
                    <div class="input_form">
                        <div class="input_text">
                            <svg viewBox="0 0 576 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V428.7c-2.7 1.1-5.4 2-8.2 2.7l-60.1 15c-3 .7-6 1.2-9 1.4c-.9 .1-1.8 .2-2.7 .2H240c-6.1 0-11.6-3.4-14.3-8.8l-8.8-17.7c-1.7-3.4-5.1-5.5-8.8-5.5s-7.2 2.1-8.8 5.5l-8.8 17.7c-2.9 5.9-9.2 9.4-15.7 8.8s-12.1-5.1-13.9-11.3L144 381l-9.8 32.8c-6.1 20.3-24.8 34.2-46 34.2H80c-8.8 0-16-7.2-16-16s7.2-16 16-16h8.2c7.1 0 13.3-4.6 15.3-11.4l14.9-49.5c3.4-11.3 13.8-19.1 25.6-19.1s22.2 7.8 25.6 19.1l11.6 38.6c7.4-6.2 16.8-9.7 26.8-9.7c15.9 0 30.4 9 37.5 23.2l4.4 8.8h8.9c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7L384 203.6V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM549.8 139.7c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM311.9 321c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L512.1 262.7l-71-71L311.9 321z"/></svg>
                            <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNamePric') ?>
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameGroup') ?>" data-tippy-placement="right">
                            <svg viewBox="0 0 512 512">
                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="reason_name" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNamePricInput') ?>" required>
                    </div>
                </div>
            </div>
            <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSReasonAddCreate') ?>">
        </div>
    </form>
</div>
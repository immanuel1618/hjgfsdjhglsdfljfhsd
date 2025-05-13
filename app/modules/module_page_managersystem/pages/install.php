<?php /**
* @author -r8 (@r8.dev)
**/

if(!isset($_SESSION['user_admin'])) get_iframe('MS5', 'Администратор сайта не настроил модуль!'); ?>

<form id="save_db">
    <div class="card_settings" style="border-radius: 6px;">
        <div class="input_form">
            <div class="input_text">
                <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPlugin') ?>
            </div>
            <div class="card_button_flex">
                <div class="check_button_card">
                    <input class="check_button_input" type="radio" name="admin_system" id="admin_system0" value="AdminSystem" checked>
                    <label for="admin_system0" class="check_button_label">AdminSystem</label>
                </div>
                <div class="check_button_card">
                    <input class="check_button_input" type="radio" name="admin_system" id="admin_system1" value="IksAdmin">
                    <label for="admin_system1" class="check_button_label">IksAdmin</label>
                </div>
            </div>
        </div>
        <div class="input_container">
            <div class="input_form">
                <div class="input_text">
                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHost') ?>
                </div>
            </div>
            <div class="input_wrapper">
                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIP') ?>" data-tippy-placement="right">
                    <svg viewBox="0 0 512 512">
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                    </svg>
                </span>
                <input type="text" name="host" tabindex="1" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIPInput') ?>" required>
            </div>
        </div>
        <div class="input_container">
            <div class="input_form">
                <div class="input_text">
                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDB') ?>
                </div>
            </div>
            <div class="input_wrapper">
                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDBInput') ?>" data-tippy-placement="right">
                    <svg viewBox="0 0 512 512">
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                    </svg>
                </span>
                <input type="text" name="user" tabindex="2" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameDB') ?>" required>
            </div>
        </div>
        <div class="input_container">
            <div class="input_form">
                <div class="input_text">
                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameDB2') ?>
                </div>
            </div>
            <div class="input_wrapper">
                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameDB2Input') ?>" data-tippy-placement="right">
                    <svg viewBox="0 0 512 512">
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                    </svg>
                </span>
                <input type="text" name="name_db" tabindex="3" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameDB2Input3') ?>" required>
            </div>
        </div>
        <div class="input_container">
            <div class="input_form">
                <div class="input_text">
                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPass') ?>
                </div>
            </div>
            <div class="input_wrapper">
                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPassReal') ?>" data-tippy-placement="right">
                    <svg viewBox="0 0 512 512">
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                    </svg>
                </span>
                <input type="password" name="pass_db" tabindex="4" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPassRealInput') ?>" required>
            </div>
        </div>
        <div class="input_container">
            <div class="input_form">
                <div class="input_text">
                    <svg viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                    <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameServer2') ?>
                </div>
            </div>
            <div class="input_wrapper">
                <span data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInputNameGroup') ?>" data-tippy-placement="right">
                    <svg viewBox="0 0 512 512">
                        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"></path>
                    </svg>
                </span>
                <input type="text" name="name_server" tabindex="5" placeholder="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSNameServer1') ?>" required>
            </div>
        </div>
        <button class="btn w100 btn5px" type="submit"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSavePod') ?></button>
    </div>
</form>
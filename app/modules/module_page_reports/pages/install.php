<div class="row">
    <div class="reports_instal_area">
        <button class="install_btn" data-openmodal="InstallReports">
            Начать установку модуля
        </button>
        <img src="/app/modules/module_page_reports/assets/img/reports.png" alt="" draggable="false">
        <div class="report_name_module">Репорты</div>
    </div>
    <div class="popup_modal" id="InstallReports">
        <div class="popup_modal_content no-close no-scrollbar">
            <div class="popup_modal_head">
                Подключение базы данных
                <span class="popup_modal_close">
                    <svg viewBox="0 0 320 512">
                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                    </svg>
                </span>
            </div>
            <hr>
            <div class="install_body">
                <form id="add_connection" class="report_form">
                    <div class="input-form">
                        <label for="namedatabase" class="input_text">Название</label>
                        <input id="namedatabase" name="namedatabase" type="text" placeholder="Введите название" value="" required>
                    </div>
                    <div class="input-form">
                        <label for="host" class="input_text">Хост</label>
                        <input id="host" name="host" type="text" placeholder="Введите IP/хостинг" value="" required>
                    </div>
                    <div class="input-form">
                        <label for="database" class="input_text">База данных</label>
                        <input id="database" name="database" type="text" placeholder="Введите базу данных" value="" required>
                    </div>
                    <div class="input-form">
                        <label for="user" class="input_text">Пользователь</label>
                        <input id="user" name="user" type="text" placeholder="Введите имя пользователя" value="" required>
                    </div>
                    <div class="input-form">
                        <label for="password_input" class="input_text">Пароль</label>
                        <div class="kostily_ebanye">
                            <input id="password_input" name="password_input" type="password" placeholder="Введите пароль от базы" value="" required>
                            <button id="toggle_eye" onclick="toggleEye(event)">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="15" height="15">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="report_form_buttons">
                        <button type="submit" class="secondary_btn w100">Отправить</button>
                        <button type="reset" class="secondary_btn btn_delete w100">Очистить всё</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
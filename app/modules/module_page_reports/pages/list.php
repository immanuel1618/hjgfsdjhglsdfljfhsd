<div class="row">
    <div class="col-md-3" style="display:flex; flex-direction: column; gap: 10px">
        <div id="work_status"></div>
        <div class="card">
            <div class="card-header">
                <div class="badge">Сортировка репортов</div>
            </div>
            <div class="card-container">
                <div class="reports_status_buttons">
                    <?php if ($Core->ReportCore()->ReportsList(1, 5)) : ?>
                        <div class="status_button" sort_id="5">
                            <div class="status_back status_pending">
                                <svg x="0" y="0" viewBox="0 0 26.349 26.35" xml:space="preserve">
                                    <g>
                                        <circle cx="13.792" cy="3.082" r="3.082"></circle>
                                        <circle cx="13.792" cy="24.501" r="1.849"></circle>
                                        <circle cx="6.219" cy="6.218" r="2.774"></circle>
                                        <circle cx="21.365" cy="21.363" r="1.541"></circle>
                                        <circle cx="3.082" cy="13.792" r="2.465"></circle>
                                        <circle cx="24.501" cy="13.791" r="1.232"></circle>
                                        <path d="M4.694 19.84a2.155 2.155 0 0 0 0 3.05 2.155 2.155 0 0 0 3.05 0 2.155 2.155 0 0 0 0-3.05 2.146 2.146 0 0 0-3.05 0z"></path>
                                        <circle cx="21.364" cy="6.218" r=".924"></circle>
                                    </g>
                                </svg>
                            </div>
                            <div class="button_status_text">
                                <span class="status_title">Я рассматриваю</span>
                                <span class="status_description">Ожидают вердикта</span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="status_button" sort_id="1">
                        <div class="status_back status_all">
                            <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                <g>
                                    <path d="M14.3 2H9.6c-1 0-1.9.8-1.9 1.9v.9c0 1 .8 1.9 1.9 1.9h4.7c1 0 1.9-.8 1.9-1.9v-.9c0-1.1-.8-1.9-1.9-1.9z"></path>
                                    <path d="M17.2 4.8c0 1.6-1.3 2.9-2.9 2.9H9.6C8 7.7 6.7 6.4 6.7 4.8c0-.6-.6-.9-1.1-.7-1.4.8-2.3 2.3-2.3 4v9.4c0 2.5 2 4.5 4.5 4.5h8.5c2.5 0 4.5-2 4.5-4.5V8.1c0-1.7-1-3.2-2.4-3.9-.6-.3-1.2.1-1.2.6zm-4.8 12.1H8c-.4 0-.8-.3-.8-.8 0-.4.3-.7.8-.7h4.4c.4 0 .8.3.8.7-.1.5-.4.8-.8.8zm2.6-4H8c-.4 0-.8-.3-.8-.8s.3-.8.8-.8h7c.4 0 .8.3.8.8s-.4.8-.8.8z"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="button_status_text">
                            <span class="status_title">Все</span>
                            <span class="status_description">Все репорты</span>
                        </div>
                    </div>
                    <div class="status_button" sort_id="2">
                        <div class="status_back status_actual">
                            <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                <g>
                                    <path d="M14.3 2H9.6c-1 0-1.9.8-1.9 1.9v.9c0 1 .8 1.9 1.9 1.9h4.7c1 0 1.9-.8 1.9-1.9v-.9c0-1.1-.8-1.9-1.9-1.9z"></path>
                                    <path d="M17.2 4.8c0 1.6-1.3 2.9-2.9 2.9H9.6C8 7.7 6.7 6.4 6.7 4.8c0-.6-.6-.9-1.1-.7-1.4.8-2.3 2.3-2.3 4v9.4c0 2.5 2 4.5 4.5 4.5h8.5c2.5 0 4.5-2 4.5-4.5V8.1c0-1.7-1-3.2-2.4-3.9-.6-.3-1.2.1-1.2.6zm-1.7 12.7c-.2.2-.3.2-.5.2s-.4-.1-.5-.2l-4.7-4.7V14c0 .4-.3.8-.8.8s-.8-.4-.8-.8v-3c0-.4.3-.8.8-.8h3c.4 0 .8.3.8.8s-.3.8-.8.8h-1.2l4.7 4.7c.3.3.3.7 0 1z"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="button_status_text">
                            <span class="status_title">Актуальные</span>
                            <span class="status_description">Список последних репортов</span>
                        </div>
                    </div>
                    <div class="status_button" sort_id="3">
                        <div class="status_back status_notactual">
                            <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                <g>
                                    <path d="M14.3 2H9.6c-1 0-1.9.8-1.9 1.9v.9c0 1 .8 1.9 1.9 1.9h4.7c1 0 1.9-.8 1.9-1.9v-.9c0-1.1-.8-1.9-1.9-1.9z" class=""></path>
                                    <path d="M17.2 4.8c0 1.6-1.3 2.9-2.9 2.9H9.6C8 7.7 6.7 6.4 6.7 4.8c0-.6-.6-.9-1.1-.7-1.4.8-2.3 2.3-2.3 4v9.4c0 2.5 2 4.5 4.5 4.5h8.5c2.5 0 4.5-2 4.5-4.5V8.1c0-1.7-1-3.2-2.4-3.9-.6-.3-1.2.1-1.2.6zm-2.7 11.9c-.2.1-.3.2-.5.2s-.4-.1-.5-.2L12 15.2l-1.5 1.5c-.2.1-.3.2-.5.2s-.4-.1-.5-.2c-.3-.3-.3-.8 0-1.1l1.5-1.5-1.5-1.4c-.3-.3-.3-.8 0-1.1s.8-.3 1.1 0L12 13l1.4-1.4c.3-.3.8-.3 1.1 0s.3.8 0 1.1l-1.4 1.4 1.5 1.5c.2.3.2.8-.1 1.1z"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="button_status_text">
                            <span class="status_title">Не актуальные</span>
                            <span class="status_description">Список старых репортов</span>
                        </div>
                    </div>
                    <div class="status_button" sort_id="4">
                        <div class="status_back status_considered">
                            <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                <g>
                                    <path d="M14.3 2H9.6c-1 0-1.9.8-1.9 1.9v.9c0 1 .8 1.9 1.9 1.9h4.7c1 0 1.9-.8 1.9-1.9v-.9c0-1.1-.8-1.9-1.9-1.9z"></path>
                                    <path d="M17.2 4.8c0 1.6-1.3 2.9-2.9 2.9H9.6C8 7.7 6.7 6.4 6.7 4.8c0-.6-.6-.9-1.1-.7-1.4.8-2.3 2.3-2.3 4v9.4c0 2.5 2 4.5 4.5 4.5h8.5c2.5 0 4.5-2 4.5-4.5V8.1c0-1.7-1-3.2-2.4-3.9-.6-.3-1.2.1-1.2.6zm-1.9 7.9-4 4c-.1.1-.3.2-.5.2s-.4-.1-.5-.2l-1.5-1.5c-.3-.3-.3-.8 0-1.1s.8-.3 1.1 0l1 1 3.5-3.5c.3-.3.8-.3 1.1 0s.1.8-.2 1.1z"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="button_status_text">
                            <span class="status_title">Рассмотренные</span>
                            <span class="status_description">Список закрытых репортов</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="badge">Выберите сервер</div>
            </div>
                <div class="card-container">
                    <div class="report_servers scroll">
                    <?php if (isset($_SESSION['user_admin'])) : ?>
                        <div class="popup_modal" id="AddServer">
                            <div class="popup_modal_content no-close no-scrollbar">
                                <div class="popup_modal_head">
                                    Добавление сервера
                                    <span class="popup_modal_close">
                                        <svg viewBox="0 0 320 512">
                                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                                        </svg>
                                    </span>
                                </div>
                                <hr>
                                <form id="add_server">
                                    <div class="reports_modal_content" style="margin-bottom:0">
                                        <div class="input-form">
                                            <label class="input_text">Выберите веб-сервер</label>
                                        </div>
                                        <select style="display: none;" class="custom-select" name="web_id" placeholder="Выберите сервер">
                                            <?php foreach ($General->server_list as $key) : ?>
                                                <option value="<?= $key['id'] ?>"><?= $key['name_custom'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="input-form">
                                            <label class="input_text" for="iksSid">Укажите ID сервера</label>
                                            <input type="text" name="iks_id" id="iksSid">
                                        </div>
                                        <div class="input-form">
                                            <label class="input_text" for="pluginDd">Укажите ID сервера из конфига плагина (Report)</label>
                                            <input type="text" name="rs_id" id="pluginDd">
                                        </div>
                                        <button class="secondary_btn">Добавить сервер</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="rp_server_btn add_serv_hidden" data-openmodal="AddServer">
                            <div class="rp_first">
                                <div class="first_top">
                                    <div class="rp_server_title_add">Добавить сервер</div>
                                </div>
                            </div>
                            <div class="reports_add_server">
                                <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                    <g>
                                        <path d="M17.5 11c-3.584 0-6.5 2.916-6.5 6.5s2.916 6.5 6.5 6.5 6.5-2.916 6.5-6.5-2.916-6.5-6.5-6.5zm2.5 7.5h-1.5V20a1 1 0 0 1-2 0v-1.5H15a1 1 0 0 1 0-2h1.5V15a1 1 0 0 1 2 0v1.5H20a1 1 0 0 1 0 2zM19 0H3a3 3 0 1 0 0 6h16a3 3 0 1 0 0-6zM3 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm4 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
                                        <path d="M19 8H3c-1.66 0-3 1.34-3 3s1.34 3 3 3h6.76c1.33-2.95 4.3-5 7.74-5 1.6 0 3.11.45 4.39 1.23A2.974 2.974 0 0 0 19 8zM3 12c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm4 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zM9 17.5c0-.51.05-1.01.14-1.5H3c-1.66 0-3 1.34-3 3s1.34 3 3 3h7.29A8.42 8.42 0 0 1 9 17.5zM3 20c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm4 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($Core->GetServers() as $key => $row) : if (isset($_SESSION['user_admin']) || empty(array_diff(array_column($Core->GetServers(), 'sid'), explode(',', $Core->AccessCore()->GetAdminSid($_SESSION['steamid64'])['GROUP_CONCAT(`sid`)']))) || (count(explode(',', $Core->AccessCore()->GetAdminSid($_SESSION['steamid64'])['GROUP_CONCAT(`sid`)'])) === 1 && empty(explode(',', $Core->AccessCore()->GetAdminSid($_SESSION['steamid64'])['GROUP_CONCAT(`sid`)'])[0])) || in_array($row['sid'], explode(',', $Core->AccessCore()->GetAdminSid($_SESSION['steamid64'])['GROUP_CONCAT(`sid`)']))) : ?>
                        <a class="rp_server_btn <?= $sid == $row['sid'] && $sid != NULL ? 'active_server_btn' : '' ?>" href="/reports/list/<?= $row['sid'] ?>/">
                            <div class="rp_first">
                                <div class="first_top">
                                    <div class="rp_server_title"><?= $row['name_custom'] ?></div>
                                    <div class="rp_new_reports" data-tippy-content="Новых репортов" data-tippy-placement="top" id="server_<?= $key ?>_new">+0</div>
                                </div>
                                <div class="first_bottom">
                                    <div class="rp_server_addres"><?= $row['ip'] ?></div>
                                </div>
                            </div>
                            <div class="rp_second">
                                <div class="rp_all_count" data-tippy-content="Всего репортов" data-tippy-placement="top" id="server_<?= $key ?>_all">0</div>
                                <?php if (isset($_SESSION['user_admin'])) : ?>
                                    <div class="rp_delete_server" server="<?= $row['sid'] ?>">Удалить</div>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endif;
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <div class="badge">Список репортов</div>
            </div>
            <div class="card-container">
                <div class="pr_list_table" id="report_list"></div>
            </div>
        </div>
    </div>
</div>
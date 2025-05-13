<?php if (empty($_SESSION['steamid64'])) {
    header_fix($General->arr_general['site']);
    exit;
} ?>
<?php if (isset($_SESSION['user_admin'])): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="admin_nav">
                <button class="fill_width secondary_btn <?php if ($page == ''): print 'active_btn_adm';
                                                        endif; ?>" onclick="location.href = '<?= $General->arr_general['site'] . 'admins_online/' ?>'">
                    <svg x="0" y="0" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 512 512" xml:space="preserve">
                        <g>
                            <path d="M278.665 0C124.656 0 0 124.635 0 278.665c0 8.292 6.722 15.014 15.014 15.014h263.651c8.292 0 15.014-6.722 15.014-15.014V15.014C293.679 6.722 286.957 0 278.665 0zM171.846 337.086a15.012 15.012 0 0 0-13.167-7.8H69.885a15.015 15.015 0 0 0-14.324 19.511c28.279 90.069 109.845 157.033 208.09 163.202v-112.54a121.785 121.785 0 0 1-91.805-62.373zM348.797 55.562a15.012 15.012 0 0 0-19.511 14.325v88.793a15.015 15.015 0 0 0 7.8 13.166 121.794 121.794 0 0 1 62.372 91.805h112.541c-6.184-98.458-73.346-179.876-163.202-208.089zM399.477 293.678c-6.811 55.148-50.65 98.987-105.798 105.798v112.512c117.153-7.374 210.925-100.997 218.309-218.31H399.477z"></path>
                        </g>
                    </svg>
                    Статистика администраторов
                    <button class="fill_width secondary_btn <?php if ($page == 'settings'): print 'active_btn_adm';
                                                            endif; ?>" onclick="location.href = '<?= $General->arr_general['site'] . 'admins_online/settings/' ?>'">
                        <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                            <g>
                                <path d="M29.21 11.84a3.92 3.92 0 0 1-3.09-5.3 1.84 1.84 0 0 0-.55-2.07 14.75 14.75 0 0 0-4.4-2.55 1.85 1.85 0 0 0-2.09.58 3.91 3.91 0 0 1-6.16 0 1.85 1.85 0 0 0-2.09-.58 14.82 14.82 0 0 0-4.1 2.3 1.86 1.86 0 0 0-.58 2.13 3.9 3.9 0 0 1-3.25 5.36 1.85 1.85 0 0 0-1.62 1.49A14.14 14.14 0 0 0 1 16a14.32 14.32 0 0 0 .19 2.35 1.85 1.85 0 0 0 1.63 1.55A3.9 3.9 0 0 1 6 25.41a1.82 1.82 0 0 0 .51 2.18 14.86 14.86 0 0 0 4.36 2.51 2 2 0 0 0 .63.11 1.84 1.84 0 0 0 1.5-.78 3.87 3.87 0 0 1 3.2-1.68 3.92 3.92 0 0 1 3.14 1.58 1.84 1.84 0 0 0 2.16.61 15 15 0 0 0 4-2.39 1.85 1.85 0 0 0 .54-2.11 3.9 3.9 0 0 1 3.13-5.39 1.85 1.85 0 0 0 1.57-1.52A14.5 14.5 0 0 0 31 16a14.35 14.35 0 0 0-.25-2.67 1.83 1.83 0 0 0-1.54-1.49zM21 16a5 5 0 1 1-5-5 5 5 0 0 1 5 5z"></path>
                            </g>
                        </svg>
                        Настройки
                    </button>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($page != '') : ?>
    <?php require_once MODULES . MODULE_WEB_ROUTES; ?>
<?php else : ?>
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="badge">Онлайн админов</div>
                </div>
                <div class="card-container">
                    <?php if (!empty($admins)): ?>
                        <div class="adm_online_list_admins">
                            <?php foreach ($admins as $admin): ?>
                                <div class="adm_online_general_block">
                                    <div class="adm_online_table">
                                        <img src="<?= $General->getAvatar($admin['steamid'], 3) ?>" alt="">
                                        <a href="https:<?= $General->arr_general['site'] ?>profiles/<?= $admin['steamid'] ?>" target="_blank" class="adm_online_admin_nick"><?= htmlentities($admin['name']) ?></a>
                                        <div>
                                            <span>STEAMID</span>
                                            <span><?= $admin['steamid'] ?></span>
                                        </div>
                                        <div>
                                            <span>Наигранное время</span>
                                            <span>
                                                <?php
                                                $totalPlayedTimeInSeconds = $adminsController->GetPlayedTime($admin['steamid'], $from, $to, $server_id)[0]['total_played_time'];
                                                echo floor($totalPlayedTimeInSeconds / (60 * 60 * 24)) . ' д. ' . gmdate('H ч. i м. s с.', $totalPlayedTimeInSeconds % (60 * 60 * 24));
                                                ?>
                                            </span>
                                        </div>
                                        <div>
                                            <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                                                <g>
                                                    <path d="M2 7a2 2 0 0 1 1.41.59L16 20.17 28.59 7.59a2 2 0 0 1 2.83 2.83l-14 14a2 2 0 0 1-2.83 0l-14-14A2 2 0 0 1 2 7z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                    <ul class="no-scrollbar">
                                        <?php foreach ($adminsController->GetSessionLogs($admin['steamid'], $from, $to, $server_id) as $sessionLog): ?>
                                            <li>
                                                <span>ID сессии: <?= $sessionLog['id'] ?></span>
                                                <span>ID Сервера: <?= $sessionLog['server_id'] ?></span>
                                                <span>Зашел: <?= date('H:i:s d.m.Y', $sessionLog['connect_time']) ?></span>
                                                <span>Вышел: <?= date('H:i:s d.m.Y', $sessionLog['disconnect_time']) ?></span>
                                                <span>Наиграл: <?= gmdate('H ч. i м. s с.', ($sessionLog['disconnect_time'] == -1 ? time() : $sessionLog['disconnect_time']) - $sessionLog['connect_time']) ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="havent_info">Ничего не найдено</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="badge">Фильтр</div>
                </div>
                <div class="card-container">
                    <form style="margin-bottom: 0" id="filter" method="GET" action="https:<?= $General->arr_general['site'] ?>admins_online">
                        <div class="filter_adm_online">
                            <div id="calendar"></div>
                            <hr>
                            <div class="input-form">
                                <div class="input_text">Выберите сервер</div>
                                <select name="server_id" placeholder="Все сервера">
                                    <option value="">Все сервера</option>
                                    <?php foreach ($General->server_list as $server): ?>
                                        <option <?php if (!empty($_GET['server_id']) && $_GET['server_id'] == $server['id']): echo 'selected';
                                                endif; ?> value="<?= $server['id'] ?>"><?= htmlentities($server['name_custom']) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="input-form">
                                <label class="input_text" for="searchadminonline">Найти админа</label>
                                <input id="searchadminonline" name="steamid64" type="text" placeholder="Поиск админа по SteamID64" value="<?php if (!empty($_GET['steamid64'])): echo htmlentities($_GET['steamid64']);
                                                                                                                                            endif; ?>">
                            </div>
                            <input type="hidden" name="from" id="fromDate">
                            <input type="hidden" name="to" id="toDate">
                            <button type="submit" class="secondary_btn w100">Поиск</button>
                            <a href="https:<?= $General->arr_general['site'] ?>admins_online" class="secondary_btn btn_delete btn_request">Очистить</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
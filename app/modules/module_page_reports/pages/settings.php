<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="badge">Создание вердиктов</div>
            </div>
            <div class="card-container">
                <div class="reports_mrg">
                    <form class="report_form" id="add_vedict">
                        <div class="input-form">
                            <label class="input_text" for="VerdictInput">Впишите свой вердикт</label>
                            <div class="number">
                                <input type="text" placeholder="Читер" id="VerdictInput" name="verdict_input">
                            </div>
                        </div>
                        <button type="submit" class="secondary_btn">Добавить новый вердикт</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="badge">Список вердиктов</div>
            </div>
            <div class="card-container">
                <div class="reports_verdict_list scroll">
                    <?php foreach ($Core->GetCache('verdictdone') as $key => $row) : ?>
                        <div class="verdict_item">
                            <?= $row['verdict'] ?>
                            <button class="secondary_btn btn_delete del_list" del="<?= $key ?>">Удалить</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="badge">Основные настройки</div>
            </div>
            <div class="card-container">
                <div class="reports_mrg">
                    <form class="report_form" id="save_one">
                        <div class="input-form" data-tippy-content="Настройка позволяет давать возможность включать или отключать админам уведомления о пришедших репортах прямо на странице репортов" data-tippy-placement="bottom">
                            <input class="border-checkbox" type="checkbox" id="notifyStatus" name="noty" <?= !empty($Core->GetCache('settings')['auto_check_report']) ? 'checked' : '' ?> />
                            <label class="border-checkbox-label" for="notifyStatus">Управлением статусом уведомлений</label>
                        </div>
                        <div class="input-form" data-tippy-content="Настройка позволяет добавлять новые репорты в список репортов без перезагрузки страницы админом. Новый репорт будет самым первым в списке." data-tippy-placement="bottom">
                            <input class="border-checkbox" type="checkbox" id="autoUpdateInfo" name="update" <?= !empty($Core->GetCache('settings')['auto_update_info']) ? 'checked' : '' ?> />
                            <label class="border-checkbox-label" for="autoUpdateInfo">Автоматическое обновление репортов</label>
                        </div>
                        <hr>
                        <div class="input-form" data-tippy-content="Раз в сколько секунд будет обновляться информация о репортах" data-tippy-placement="bottom">
                            <label class="input_text" for="autoUpdateTime">Время обновления репортов (в секундах)</label>
                            <div class="input_wrapper">
                                <div class="number">
                                    <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                    <input type="number" value="<?= $Core->GetCache('settings')['update_time_js'] ?>" placeholder="30" id="autoUpdateTime" name="update_input_js">
                                    <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="input-form" data-tippy-content="Через сколько времени репорт перестанет иметь статус Актуальный" data-tippy-placement="bottom">
                            <label class="input_text" for="timeActual">Актуальность репортов (в секундах)</label>
                            <div class="input_wrapper">
                                <div class="number">
                                    <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                    <input type="number" value="<?= $Core->GetCache('settings')['time_actual'] ?>" placeholder="3600" id="timeActual" name="report_actual">
                                    <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="secondary_btn w100">Сохранить</button>
                    </form>
                    <div class="badge">Настройка админов</div>
                    <div class="report_settings_btns">
                        <button class="secondary_btn w100" id="reload_admin">Обновить</button>
                        <button class="secondary_btn w100" data-openmodal="ShowAdmins">Админы</button>
                    </div>
                    <hr>
                    <form class="report_form" id="save_two">
                        <div class="input-form" data-tippy-content="Настройка позволяет давать возможность включать или отключать админам уведомления о пришедших репортах прямо на странице репортов" data-tippy-placement="bottom">
                            <input class="border-checkbox" type="checkbox" id="admin" name="admin" <?= !empty($Core->GetCache('settings')['auto_update_admin']) ? 'checked' : '' ?> />
                            <label class="border-checkbox-label" for="admin">Автообновление админов</label>
                        </div>
                        <div class="input-form" data-tippy-content="Раз в сколько времени проверять актуальность админов" data-tippy-placement="bottom">
                            <label class="input_text" for="updateTimeAdmins">Время проверки актуальности (в секундах)</label>
                            <div class="input_wrapper">
                                <div class="number">
                                    <button class="number-minus" type="button" onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.onchange();">-</button>
                                    <input type="number" value="<?= $Core->GetCache('settings')['update_time'] ?>" placeholder="3600" id="updateTimeAdmins" name="admin_input">
                                    <button class="number-plus" type="button" onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.onchange();">+</button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="secondary_btn w100">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="badge">Настройки предупреждений</div>
            </div>
            <div class="card-container">
                <div class="reports_mrg">
                    <button class="secondary_btn btn_delete" id="reload_warn">Очистить все истекшие предупреждения</button>
                    <form class="report_form" id="save_three">
                        <div class="input-form" data-tippy-content="Настройка позволяет давать возможность включать или отключать админам уведомления о пришедших репортах прямо на странице репортов" data-tippy-placement="bottom">
                            <input class="border-checkbox" type="checkbox" id="warn" name="warn" <?= !empty($Core->GetCache('settings')['auto_update_warn']) ? 'checked' : '' ?> />
                            <label class="border-checkbox-label" for="warn">Автоматическое снятие предупреждений</label>
                        </div>
                        <hr>
                        <div class="input-form" data-tippy-content="Через какой промежуток времени предупреждение будет автоматически удаляться" data-tippy-placement="bottom">
                            <label class="input_text" for="liveTimeWarn">Время жизни предупреждения (в секундах)</label>
                            <div class="input_wrapper">
                                <div class="number">
                                    <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                    <input type="number" value="<?= $Core->GetCache('settings')['life_time_warn'] ?>" placeholder="30" id="liveTimeWarn" name="life_warn">
                                    <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="input-form" data-tippy-content="Раз в сколько времени проверять актуальность предупреждения" data-tippy-placement="bottom">
                            <label class="input_text" for="checkActualWarn">Актуальность предупреждений (в секундах)</label>
                            <div class="input_wrapper">
                                <div class="number">
                                    <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                    <input type="number" value="<?= $Core->GetCache('settings')['update_time_warn'] ?>" placeholder="3600" id="checkActualWarn" name="warn_input">
                                    <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="input-form" data-tippy-content="Какое максимальное количество предупреждений можно выдать на один репорт" data-tippy-placement="bottom">
                            <label class="input_text" for="maxWarns">Количество предупреждений</label>
                            <div class="input_wrapper">
                                <div class="number">
                                    <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                    <input type="number" value="<?= $Core->GetCache('settings')['max_warn'] ?>" placeholder="1" id="maxWarns" name="max_warn_input">
                                    <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="secondary_btn w100">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="badge">Настройки банов</div>
            </div>
            <div class="card-container">
                <div class="reports_mrg">
                    <button class="secondary_btn btn_delete" id="reload_status">Закрыть все репорты с забаненными</button>
                    <form class="report_form" id="save_four">
                        <div class="input-form" data-tippy-content="Позволяет закрывать репорт, если нарушитель уже забанен на сервере" data-tippy-placement="bottom">
                            <input class="border-checkbox" type="checkbox" id="ban" name="ban" <?= !empty($Core->GetCache('settings')['auto_update_status']) ? 'checked' : '' ?> />
                            <label class="border-checkbox-label" for="ban">Автоматическое обновление статуса репорта</label>
                        </div>
                        <hr>
                        <div class="input-form" data-tippy-content="Раз в сколько времени обновлять информацию о статусе бана нарушителей" data-tippy-placement="bottom">
                            <label class="input_text" for="UpdateTimeStatus">Время проверки банов (в секундах)</label>
                            <div class="input_wrapper">
                                <div class="number">
                                    <button class="number-minus" type="button" onclick="decrementValue(this)">-</button>
                                    <input type="number" value="<?= $Core->GetCache('settings')['update_time_status'] ?>" placeholder="3600" id="UpdateTimeStatus" name="ban_input">
                                    <button class="number-plus" type="button" onclick="incrementValue(this)">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="input-form" data-tippy-content="Настройка позволяет показывать баны нарушителя на других проектах, если они есть, если введён ключ от плагина BlockDB" data-tippy-placement="bottom">
                            <label class="input_text" for="blockdbApikey">BlockDB Api Key</label>
                            <input type="password" value="<?= $Core->GetCache('settings')['blockdb_apikey'] ?>" placeholder="Введите свой ключ apikey" id="blockdbApikey" name="blockdb_input">
                        </div>
                        <button type="submit" class="secondary_btn w100">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
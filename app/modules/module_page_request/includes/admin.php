<?php if ($RQ->access < 10) {
    header('Location: ' . $General->arr_general['site']);
    exit;
} ?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <div class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_Settings') ?></div>
        </div>
        <div class="card-container">
            <form id="settings" method="post" onsubmit="SendAjax('#settings', 'settings', '', '', ''); return false;">
                <div class="input-container">
                    <div class="input-form">
                        <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Discord_notifications') ?></div>
                        <input class="border-checkbox" type="checkbox" name="webhoock_offon" id="webhoock_offon" <?php $data['auth'] && print 'checked'; ?>>
                        <label class="border-checkbox-label" for="webhoock_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                    </div>
                </div>
                <div class="input-container">
                    <div class="input-form">
                        <div class="input_text">Webhook URL:</div>
                        <input class="in_f" name="webhoock_url" value="<?php $data['url'] && print $data['url']; ?>">
                    </div>
                </div>
                <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_request', '_Save') ?>">
            </form>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_ListOfApplications') ?>
                <a class="module_setting close close_req" href="<?= set_url_section(get_url(2), 'request', 'add') ?>">
                    <?= $Translate->get_translate_module_phrase('module_page_request', '_NewApplication') ?>
                </a>
            </h5>
        </div>
        <div class="card-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><?= $Translate->get_translate_module_phrase('module_page_request', '_Applications_sort') ?></th>
                        <th class="text-center"><?= $Translate->get_translate_module_phrase('module_page_request', '_Sorting') ?></th>
                        <th class="text-center"><?= $Translate->get_translate_module_phrase('module_page_request', '_Status') ?></th>
                        </th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($List as $key) : ?>
                        <tr>
                            <td class="text-center"><?= $key['title'] ?></th>
                            <td class="text-center"><?= $key['sort'] ?></td>
                            <td class="text-center">
                                <div class="center_svg">
                                    <?php if (empty($key['status'])) : ?>
                                        <svg data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_OffRequest') ?>" class="xmark" viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" />
                                        </svg>
                                    <?php else : ?>
                                        <svg data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_OnRequest') ?>" class="check" viewBox="0 0 512 512">
                                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" />
                                        </svg>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="text-center req_flex">
                                <a href="<?= set_url_section(get_url(2), 'request', $key['id']) ?>" class="req_btn" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_ToChange') ?></th>" data-tippy-placement="top">
                                    <svg viewBox="0 0 512 512">
                                        <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                    </svg>
                                </a>
                                <a href="<?= $General->arr_general['site'] ?>request/?page=question&qid=<?= $key['id'] ?>" class="req_btn" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_AddQuestions') ?></th>" data-tippy-placement="top">
                                    <svg viewBox="0 0 448 512">
                                        <path d="M206.5 344.7L70.55 200.6C63.97 193.7 62.17 183.4 65.95 174.6C69.75 165.8 78.42 160.1 88 160.1H160V32.02C160 14.33 174.3 0 192 0H256C273.7 0 288 14.33 288 32.02V160.1H360C369.6 160.1 378.2 165.8 382 174.6C385.8 183.4 384 193.7 377.5 200.6L241.5 344.7C232.4 354.3 215.6 354.3 206.5 344.7zM352 512H96C42.98 512 0 469 0 416V352C0 334.3 14.33 319.1 32 319.1C49.67 319.1 64 334.3 64 352V416C64 433.7 78.33 448 96 448H352C369.7 448 384 433.7 384 416V352C384 334.3 398.3 319.1 416 319.1C433.7 319.1 448 334.3 448 352V416C448 469 405 512 352 512z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-md-6">
    <?php if (isset($_GET['request']) && $_GET['request'] == 'add') : ?>
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_AddingApplications') ?>
                    <a class="module_setting close">
                        <svg data-del="delete" data-get="request" viewBox="0 0 320 512">
                            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                        </svg>
                    </a>
                </h5>
            </div>
            <div class="card-container module_block">
                <form id="request_add" method="post" onsubmit="SendAjax('#request_add', 'request_add', '', '', ''); return false;">
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Status') ?></div>
                            <input class="border-checkbox" type="checkbox" name="request_offon" id="request_offon">
                            <label class="border-checkbox-label" for="request_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_ApplicationName') ?></div>
                            <input class="in_f" name="title">
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Sorting') ?></div>
                            <input class="in_f" name="sort">
                        </div>
                    </div>
                    <textarea id="editor" name="message"></textarea>
                    <div class="input-container row">
                        <div class="col-md-6">
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text">VK</div>
                                    <input class="border-checkbox" type="checkbox" name="vk_offon" id="vk_offon">
                                    <label class="border-checkbox-label" for="vk_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text">Discord</div>
                                    <input class="border-checkbox" type="checkbox" name="discord_offon" id="discord_offon">
                                    <label class="border-checkbox-label" for="discord_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text">Telegram</div>
                                    <input class="border-checkbox" type="checkbox" name="telegram_offon" id="telegram_offon">
                                    <label class="border-checkbox-label" for="telegram_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Rules') ?></div>
                                    <input class="border-checkbox" type="checkbox" name="rules_offon" id="rules_offon">
                                    <label class="border-checkbox-label" for="rules_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Age') ?></div>
                                    <input class="border-checkbox" type="checkbox" name="age_offon" id="age_offon">
                                    <label class="border-checkbox-label" for="age_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Criteria') ?></div>
                                    <input class="border-checkbox" type="checkbox" name="criteria_offon" id="criteria_offon">
                                    <label class="border-checkbox-label" for="criteria_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_TimeNextApplication') ?><p class="request_help"><?= $Translate->get_translate_module_phrase('module_page_request', '_SpecifySeconds') ?></p> :</div>
                            <input class="in_f" name="time">
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_MinimumAge') ?> <p class="request_help"><?= $Translate->get_translate_module_phrase('module_page_request', '_SpecifyTheMinimumAge') ?></p> :</div>
                            <input class="in_f" name="age">
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_LimitHours') ?>:</div>
                            <input class="border-checkbox" type="checkbox" name="hours_act" id="hours_act_offon">
                            <label class="border-checkbox-label" for="hours_act_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_MinimumHours') ?>:</div>
                            <input placeholder="<?= $Translate->get_translate_module_phrase('module_page_request', '_PlayToApply') ?>" class="in_f" name="hours">
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_GameServer') ?></div>
                            <input class="border-checkbox" type="checkbox" name="server_offon" id="server_offon">
                            <label class="border-checkbox-label" for="server_offon"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text">
                                <?= $Translate->get_translate_module_phrase('module_page_request', '_ServerPY') ?>
                            </div>
                        </div>
                        <div class="input_radio_buttons">
                            <?php for ($i = 0; $i < sizeof($servers); $i++) : ?>
                                <div class="radio">
                                    <input class="radio__input" name="default_server" type="radio" id="default_server<?= $i ?>" value="<?= $servers[$i]['id']; ?>">
                                    <label class="custom-radio" for="default_server<?= $i ?>"><?= $servers[$i]['name']; ?></label>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text">
                                <?= $Translate->get_translate_module_phrase('module_page_request', '_IgnoreSelectedServers') ?>
                            </div>
                        </div>
                        <div class="input_radio_buttons">
                            <?php for ($i = 0; $i < sizeof($servers); $i++) : ?>
                                <div class="radio">
                                    <input class="radio__input" name="ignore_server[]" type="checkbox" id="ignore_server<?= $i ?>" value="<?= $servers[$i]['id']; ?>">
                                    <label class="custom-radio" for="ignore_server<?= $i ?>"><?= $servers[$i]['name']; ?></label>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <input class="secondary_btn w100" type="submit" value="<?= $Translate->get_translate_module_phrase('module_page_request', '_ToCreate') ?>">
                </form>
            </div>
        </div>
    <?php elseif (!empty($_GET['request'])) : $requestEdit = $RQ->getRequest($_GET['request']);
        $ignore_servers = explode(';', $requestEdit['ignore_servers']); ?>
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_ChangingApplication') ?></h5>
                <a class="module_setting close">
                    <svg data-del="delete" data-get="request" viewBox="0 0 320 512">
                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                    </svg>
                </a>
            </div>
            <div class="card-container module_block">
                <form id="request_edit" method="post" onsubmit="SendAjax('#request_edit', 'request_edit', '', '', ''); return false;">
                    <input type="hidden" name="request_id_edit" value="<?= $_GET['request'] ?>">
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Status') ?></div>
                            <input class="border-checkbox" type="checkbox" name="request_offon_edit" id="request_offon_edit" <?php $requestEdit['status'] && print 'checked'; ?>>
                            <label class="border-checkbox-label" for="request_offon_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_ApplicationName') ?></div>
                            <input class="in_f" name="title_edit" value="<?= $requestEdit['title'] ?>">
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Sorting') ?></div>
                            <input class="in_f" name="sort_edit" value="<?= $requestEdit['sort'] ?>">
                        </div>
                    </div>
                    <textarea id="editor" name="message_edit"><?php if (!empty($requestEdit['text'])) echo $RQ->OpenBB()->convertFromHtml($requestEdit['text']) ?></textarea>
                    <div class="input-container row">
                        <div class="col-md-6">
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text">VK</div>
                                    <input class="border-checkbox" type="checkbox" name="vk_offon_edit" id="vk_offon_edit" <?php $requestEdit['vk'] && print 'checked'; ?>>
                                    <label class="border-checkbox-label" for="vk_offon_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text">Discord</div>
                                    <input class="border-checkbox" type="checkbox" name="discord_offon_edit" id="discord_offon_edit" <?php $requestEdit['discord'] && print 'checked'; ?>>
                                    <label class="border-checkbox-label" for="discord_offon_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text">Telegram</div>
                                    <input class="border-checkbox" type="checkbox" name="telegram_offon_edit" id="telegram_offon_edit" <?php $requestEdit['telegram'] && print 'checked'; ?>>
                                    <label class="border-checkbox-label" for="telegram_offon_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Rules') ?></div>
                                    <input class="border-checkbox" type="checkbox" name="rules_offon_edit" id="rules_offon_edit" <?php $requestEdit['rules'] && print 'checked'; ?>>
                                    <label class="border-checkbox-label" for="rules_offon_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Age') ?></div>
                                    <input class="border-checkbox" type="checkbox" name="age_offon_edit" id="age_offon_edit" <?php $requestEdit['age_act'] && print 'checked'; ?>>
                                    <label class="border-checkbox-label" for="age_offon_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                            <div class="input-container">
                                <div class="input-form">
                                    <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Criteria') ?></div>
                                    <input class="border-checkbox" type="checkbox" name="criteria_offon_edit" id="criteria_offon_edit" <?php $requestEdit['criteria'] && print 'checked'; ?>>
                                    <label class="border-checkbox-label" for="criteria_offon_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_TimeNextApplication') ?> <p class="request_help"><?= $Translate->get_translate_module_phrase('module_page_request', '_SpecifySeconds') ?></p>:</div>
                            <input class="in_f" name="time_edit" value="<?php $requestEdit['time'] && print $requestEdit['time']; ?>">
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_MinimumAge') ?> <p class="request_help"><?= $Translate->get_translate_module_phrase('module_page_request', '_SpecifyTheMinimumAge') ?></p>:</div>
                            <input class="in_f" name="age_edit" value="<?php $requestEdit['age'] && print $requestEdit['age']; ?>">
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_LimitHours') ?>:</div>
                            <input class="border-checkbox" type="checkbox" name="hours_act_edit" id="hours_act_offon_edit" <?php $requestEdit['hours_act'] && print 'checked'; ?>>
                            <label class="border-checkbox-label" for="hours_act_offon_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_MinimumHours') ?>:</div>
                            <input class="in_f" name="hours_edit" value="<?php $requestEdit['hours'] && print $requestEdit['hours']; ?>">
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_GameServer') ?></div>
                            <input class="border-checkbox" type="checkbox" name="server_offon_edit" id="server_offon_edit" <?php $requestEdit['server'] && print 'checked'; ?>>
                            <label class="border-checkbox-label" for="server_offon_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text">
                                <?= $Translate->get_translate_module_phrase('module_page_request', '_ServerPY') ?>
                            </div>
                        </div>
                        <div class="input_radio_buttons">
                            <?php for ($i = 0; $i < sizeof($servers); $i++) : ?>
                                <div class="radio">
                                    <input class="radio__input" name="default_server_edit" type="radio" id="default_server_edit<?= $i ?>" value="<?= $servers[$i]['id']; ?>" <?php ($requestEdit['default_server'] == $servers[$i]['id']) && print 'checked'; ?>>
                                    <label class="custom-radio" for="default_server_edit<?= $i ?>"><?= $servers[$i]['name']; ?></label>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="input-container">
                        <div class="input-form">
                            <div class="input_text">
                                <?= $Translate->get_translate_module_phrase('module_page_request', '_IgnoreSelectedServers') ?>
                            </div>
                        </div>
                        <div class="input_radio_buttons">
                            <div class="input-form">
                                <?php for ($i = 0; $i < sizeof($servers); $i++) : ?>
                                    <div class="radio">
                                        <input class="border-checkbox" name="ignore_server_edit[]" type="checkbox" id="ignore_server_edit<?= $i ?>" value="<?= $servers[$i]['id']; ?>" <?php in_array($servers[$i]['id'], $ignore_servers) && print 'checked'; ?>>
                                        <label class="border-checkbox-label" for="ignore_server_edit<?= $i ?>"><?= $servers[$i]['name']; ?></label>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="case-buttons_bottom">
                    <button type="submit" class="secondary_btn w100" form="request_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_Save') ?></button>
                    <button class="secondary_btn btn_delete w100" onclick="SendAjax('','request_del','<?= $_GET['request'] ?>','','')">
                        <?= $Translate->get_translate_module_phrase('module_page_request', '_DelApplication') ?>
                    </button>
                </div>
            </div>
        </div>
</div>
<?php endif; ?>
</div>
<?php if ($RQ->access < 3) {
    header('Location: ' . $General->arr_general['site']);
    exit;
} ?>
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Сортировка</h5>
        </div>
        <div class="card-container">
            <div class="request_sort_buttons">
                <a href="<?= set_url_section(get_url(2), 'type', 0) ?>">
                    <div class="request_sort_btn <?php if (empty(strip_tags($_GET['type']))) {
                                                        echo 'status_active';
                                                    } ?>">Все заявки <span class="request_sort_btn-count"><?=count($RQ->getAllList())?></span></div>
                </a>
                <?php foreach ($requests as $key) : ?>
                    <a href="<?= set_url_section(get_url(2), 'type', $key['id']) ?>">
                        <div class="request_sort_btn <?php if ($key['id'] == strip_tags($_GET['type'])) {
                                                            echo 'status_active';
                                                        } ?>"><?= $key['title'] ?><span class="request_sort_btn-count"><?=$RQ->getCountList($key['id'])[0]?></span></div>
                    </a>
                <?php endforeach; ?>
            </div>
            <h5 class="badge mb10 mt10">Выбранный статус</h5>
            <select style="display: none;" class="custom-select" onchange="window.location.href=this.value" placeholder="<?= !empty(strip_tags($_GET['status'])) ? $RQ->status[strip_tags($_GET['status']) - 1] : "Все" ?>">
                <option value="<?= set_url_section(get_url(2), 'status', 0) ?>">Все</option>
                <?php for ($i = 0; $i < count($RQ->status); $i++):?>
                    <option value="<?= set_url_section(get_url(2), 'status', $i + 1) ?>"><?=$RQ->status[$i]?></option>
                <?php endfor;?>
            </select>
        </div>
    </div>
</div>
<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_ListApplications') ?></h5>
        </div>
        <div class="card-container">
            <div class="request_list scroll">
                <?php foreach ($List as $key) : $Request = $RQ->getRequest($key['rid']); ?>
                    <div class="popup_modal" id="DeleteRequest-<?= $key['id'] ?>">
                        <div class="popup_modal_content no-close no-scrollbar">
                            <div class="popup_modal_head">
                                Подтверждение
                                <span class="popup_modal_close">
                                    <svg viewBox="0 0 320 512">
                                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                                    </svg>
                                </span>
                            </div>
                            <hr>
                            <div class="request_modal_content">
                                Вы уверены, что хотите удалить заявку? При удалении вернуть заявку будет невозможно.
                            </div>
                            <div class="request_modal_btns">
                                <button class="secondary_btn" onclick="SendAjax('','del_list','<?= $key['id'] ?>','','')">Да, удалить</button>
                                <button class="secondary_btn btn_delete popup_modal_close">Нет, я случайно нажал</button>
                            </div>
                        </div>
                    </div>
                    <div class="request_content">
                        <div class="request_user_info_block">
                            <div class="user_avatar_profile none_span" style="position: relative;">
                                <?= $General->get_js_relevance_avatar(con_steam32to64($key[steamid])) ?>
                                <img style="position: absolute; transform: scale(1.17); border-radius: 0; top: -1px;" src="<?= $General->getFrame(con_steam32to64($key[steamid])) ?>" id="frame" frameid="<?= con_steam32to64($key[steamid]) ?>">
                                <img src="<?= $General->getAvatar(con_steam32to64($key[steamid]), 3) ?>" id="avatar" avatarid="<?= con_steam32to64($key[steamid]) ?>">
                            </div>
                            <div class="request_user_request">
                                <a href="<?= $General->arr_general['site'] ?>profiles/<?= ($key['steamid']) ?>/?search=1/">
                                    <span class="request_user_nickname">
                                        <svg class="none_span" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                                            <g>
                                                <circle cx="256" cy="114.526" r="114.526"></circle>
                                                <path d="M256 256c-111.619 0-202.105 90.487-202.105 202.105 0 29.765 24.13 53.895 53.895 53.895h296.421c29.765 0 53.895-24.13 53.895-53.895C458.105 346.487 367.619 256 256 256z"></path>
                                            </g>
                                        </svg>
                                        <?= action_text_clear(action_text_trim($General->checkName(con_steam32to64($key['steamid'])), 17)) ?></span>
                                </a>
                                <span class="request_name_request none_span">
                                    <svg viewBox="0 0 384 512">
                                        <path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM72 272a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm104-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16s7.2-16 16-16zM72 368a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm88 0c0-8.8 7.2-16 16-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16z"></path>
                                    </svg>
                                    <?= $Request['title'] ?></span>
                            </div>
                        </div>
                        <div class="request_any_info none_span">
                            <span class="request_idnum">ID: <?= $key['id'] ?></span>
                            <span Class="request_date_time">
                                <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                                    <g>
                                        <circle cx="386" cy="210" r="20"></circle>
                                        <path d="M432 40h-26V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-91V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-90V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20H80C35.888 40 0 75.888 0 120v312c0 44.112 35.888 80 80 80h153c11.046 0 20-8.954 20-20s-8.954-20-20-20H80c-22.056 0-40-17.944-40-40V120c0-22.056 17.944-40 40-40h25v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h90v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h91v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h26c22.056 0 40 17.944 40 40v114c0 11.046 8.954 20 20 20s20-8.954 20-20V120c0-44.112-35.888-80-80-80z"></path>
                                        <path d="M391 270c-66.72 0-121 54.28-121 121s54.28 121 121 121 121-54.28 121-121-54.28-121-121-121zm0 202c-44.663 0-81-36.336-81-81s36.337-81 81-81 81 36.336 81 81-36.337 81-81 81z"></path>
                                        <path d="M420 371h-9v-21c0-11.046-8.954-20-20-20s-20 8.954-20 20v41c0 11.046 8.954 20 20 20h29c11.046 0 20-8.954 20-20s-8.954-20-20-20z"></path>
                                        <circle cx="299" cy="210" r="20"></circle>
                                        <circle cx="212" cy="297" r="20"></circle>
                                        <circle cx="125" cy="210" r="20"></circle>
                                        <circle cx="125" cy="297" r="20"></circle>
                                        <circle cx="125" cy="384" r="20"></circle>
                                        <circle cx="212" cy="384" r="20"></circle>
                                        <circle cx="212" cy="210" r="20"></circle>
                                    </g>
                                </svg>
                                <?= date('d.m, H:i', $key['date']) ?></span>
                        </div>
                        <div class="request_server_info none_span">
                            <span class="request_servername">
                                <svg x="0" y="0" viewBox="0 0 100 100" xml:space="preserve" fill-rule="evenodd">
                                    <g>
                                        <path d="M90.553 62.499a9.375 9.375 0 0 0-9.375-9.375H18.87a9.375 9.375 0 0 0-9.375 9.375v15.626A9.375 9.375 0 0 0 18.87 87.5h62.308a9.375 9.375 0 0 0 9.375-9.375zm-63.957 3.125c2.588 0 4.688 2.101 4.688 4.688s-2.1 4.687-4.688 4.687c-2.587 0-4.687-2.1-4.687-4.687s2.1-4.688 4.687-4.688zm14.029 7.813h33.927a3.126 3.126 0 0 0 0-6.25H40.625a3.126 3.126 0 0 0 0 6.25zM90.553 21.875a9.375 9.375 0 0 0-9.375-9.375H18.496a9.375 9.375 0 0 0-9.375 9.375v15.698a9.375 9.375 0 0 0 9.375 9.375h62.682a9.375 9.375 0 0 0 9.375-9.375zm-63.957 3.162c2.588 0 4.688 2.1 4.688 4.687s-2.1 4.688-4.688 4.688c-2.587 0-4.687-2.101-4.687-4.688s2.1-4.687 4.687-4.687zm14.029 7.812h33.927a3.126 3.126 0 0 0 0-6.25H40.625a3.126 3.126 0 0 0 0 6.25z"></path>
                                    </g>
                                </svg>
                                <?= is_numeric($key['server']) ? $RQ->ServerName($key['server']) : $key['server'] ?></span>
                            <span Class="request_playtime">
                                <svg x="0" y="0" viewBox="0 0 64 64" xml:space="preserve">
                                    <g>
                                        <path d="M50.033 14.408c-2.838-2.566-5.053-2.407-7.922-1.54l-1.45 4.77a4.309 4.309 0 0 1-4.14 3.151h-9.042a4.321 4.321 0 0 1-4.15-3.18l-1.35-4.72c-2.907-.865-5.138-1.081-8.012 1.52-5.73 5.04-11.151 18.472-9.74 29.683a8.664 8.664 0 0 0 4.44 6.661c2.73 1.45 6.85 1.87 11.601-3.63a5.968 5.968 0 0 1-2.3-4.71c.142-7.116 10.1-8.206 11.832-1.39a5.94 5.94 0 0 1 .14 2.01 23.632 23.632 0 0 0 4.12 0c-.02-.2-.03-.41-.03-.62a6 6 0 0 1 12.002 0 5.967 5.967 0 0 1-2.3 4.71c4.143 4.557 7.453 5.603 11.601 3.63a8.664 8.664 0 0 0 4.44-6.66c1.411-11.212-4.01-24.644-9.74-29.685zM24.429 29.88a.997.997 0 0 1-1 1h-1.91v1.91a1.003 1.003 0 0 1-1 1.001h-3.531a1.003 1.003 0 0 1-1-1v-1.91h-1.91a.997.997 0 0 1-1-1V26.35a1.003 1.003 0 0 1 1-1h1.91v-1.9a.997.997 0 0 1 1-1h3.53a.997.997 0 0 1 1 1v1.9h1.91a1.003 1.003 0 0 1 1 1zM35.2 36.051h-6.4a1 1 0 0 1 0-2h6.4a1 1 0 0 1 0 2zm6.831-6.37a1.56 1.56 0 0 1 0-3.121 1.56 1.56 0 0 1 0 3.12zm3.52 3.52a1.56 1.56 0 0 1 .001-3.12 1.56 1.56 0 0 1 0 3.12zm0-7.041a1.56 1.56 0 0 1 .001-3.12 1.56 1.56 0 0 1 0 3.12zm3.521 3.52a1.56 1.56 0 0 1 0-3.12 1.56 1.56 0 0 1 0 3.12z"></path>
                                        <path d="M23.969 38.412a4 4 0 0 0 0 8 4 4 0 0 0 0-8zM44.032 42.412a4 4 0 0 0-8.001 0 4 4 0 0 0 8 0zM25.26 17.069a2.317 2.317 0 0 0 2.22 1.72h9.04a2.32 2.32 0 0 0 2.22-1.71c.284-.923.864-2.85 1.151-3.78-2.11.438-10.419.189-12.692.25a20.386 20.386 0 0 1-3.02-.24c.277.93.808 2.84 1.08 3.76zM19.518 26.35v-1.9h-1.53v1.9a.997.997 0 0 1-1 1h-1.91v1.53h1.91a1.003 1.003 0 0 1 1 1v1.91h1.53v-1.91a1.003 1.003 0 0 1 1-1h1.91v-1.53h-1.91a.997.997 0 0 1-1-1z"></path>
                                    </g>
                                </svg>
                                <?= $key['playtime'] . " " . $Translate->get_translate_module_phrase('module_page_request', '_Hours') ?></span>
                        </div>
                        <div class="request_statusbadge">
                            <span class="request_status_block request_status-<?= $key['status'] ?>"><?= $RQ->status[$key['status']] ?></span>
                        </div>
                        <div class="request_action_buttons">
                            <a href="<?= $General->arr_general['site'] ?>request/?page=review&rid=<?= $key['id'] ?>" class="request_action_btn request_accept_btn">
                                <?= $Translate->get_translate_module_phrase('module_page_request', '_ToConsider') ?>
                                <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" fill-rule="evenodd">
                                    <g>
                                        <path d="M11 2H6a4 4 0 0 0-4 4v12a4 4 0 0 0 4 4h12a4 4 0 0 0 4-4v-5a1 1 0 0 0-2 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5a1 1 0 0 0 0-2zm7.586 2H15a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V5.414l-7.293 7.293a1 1 0 0 1-1.414-1.414z"></path>
                                    </g>
                                </svg>
                            </a>
                            <?php if ($RQ->access > 5) : ?>
                                <a class="request_action_btn request_delete_btn none_span" data-tippy-content="Удалить заявку" data-tippy-placement="top" data-openmodal="DeleteRequest-<?= $key['id'] ?>">
                                    <svg viewBox="0 0 448 512">
                                        <path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <div class="pagination">
        <?php if ($page_num != 1) : ?>
            <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', 1); ?>"><svg viewBox="0 0 448 512">
                    <path d="M77.25 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C399.6 476.9 407.8 480 416 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"></path>
                </svg></a>
            <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num - 1); ?>"><svg viewBox="0 0 384 512">
                    <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                </svg></a>
        <?php endif; ?>
        <?php if ($page_max < 5) : for ($i = 1; $i <= $page_max; $i++) : ?>
                <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
            <?php endfor;
        else : for ($i = $startPag, $j = 1; $i < $startPag + 5; $i++, $j++) : ?>
                <a <?php ($i == $page_num ? print "class='button_pagination current active' " : ''); ?>class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $i); ?>"><?= $i; ?></a>
        <?php endfor;
        endif; ?>
        <?php if ($page_num != $page_max) : ?>
            <a class="button_pagination current" href="<?= set_url_section(get_url(2), 'num', $page_num + 1); ?>"><svg viewBox="0 0 384 512">
                    <path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                </svg></a>
            <a class="button_pagination current" href="<?= set_url_section(get_url(3), 'num', $page_max); ?>"><svg viewBox="0 0 448 512">
                    <path d="M246.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C15.63 476.9 23.81 480 32 480s16.38-3.125 22.62-9.375l192-192C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375l192-192C451.1 266.1 451.1 245.9 438.6 233.4z"></path>
                </svg></a>
        <?php endif; ?>
    </div>
</div>
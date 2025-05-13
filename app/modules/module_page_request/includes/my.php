<?php if (!isset($_SESSION['steamid'])) {
    header('Location: ' . $General->arr_general['site']);
    exit;
} ?>
<?php if (isset($_GET['page']) && !isset($_GET['rid'])) : ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_ListMyApplications') ?></h5>
            </div>
            <div class="card-container">
                <div class="request_list scroll">
                    <?php foreach ($myList as $key) : $Request = $RQ->getRequest($key['rid']); ?>
                        <div class="request_content request_my_req">
                            <div class="request_user_info_block">
                                <div class="request_user_request">
                                    <span class="request_name_request">
                                        <svg viewBox="0 0 384 512">
                                            <path d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM72 272a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm104-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16s7.2-16 16-16zM72 368a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm88 0c0-8.8 7.2-16 16-16H304c8.8 0 16 7.2 16 16s-7.2 16-16 16H176c-8.8 0-16-7.2-16-16z"></path>
                                        </svg>
                                        <?= $Request['title'] ?></span>
                                </div>
                            </div>
                            <div class="request_any_info none_span">
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
                                <a href="<?= $General->arr_general['site'] ?>request/?page=my&rid=<?= $key['id'] ?>" class="request_action_btn request_accept_btn">
                                    <?= $Translate->get_translate_module_phrase('module_page_request', '_Open') ?>
                                    <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" fill-rule="evenodd">
                                        <g>
                                            <path d="M11 2H6a4 4 0 0 0-4 4v12a4 4 0 0 0 4 4h12a4 4 0 0 0 4-4v-5a1 1 0 0 0-2 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5a1 1 0 0 0 0-2zm7.586 2H15a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V5.414l-7.293 7.293a1 1 0 0 1-1.414-1.414z"></path>
                                        </g>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
<?php elseif (isset($_GET['rid'])) : ?>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="badge">
                    <?= $Translate->get_translate_module_phrase('module_page_request', '_RequestUser') ?> <?= action_text_clear(action_text_trim($General->checkName(con_steam32to64($List['steamid'])), 17)) ?>
                </div>
            </div>
            <div class="card-container">
                <div class="request_list_info">
                    <div class="request_title_id"><?= $Request['title'] ?> (#<?= $List['id'] ?>)</div>
                    <div class="request_status_block request_status-<?= $List['status'] ?>"><?= $RQ->status[$List['status']] ?></div>
                </div>
                <div class="req_text_title"><?= $Translate->get_translate_module_phrase('module_page_request', '_ApplicationText') ?></div>
                <div class="request_list_info_text">
                    <div class="request_answers"><?= $List['text'] ?></div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header">
                <div class="badge">
                    <?= $Translate->get_translate_module_phrase('module_page_request', '_ResponseToRequest') ?>
                </div>
            </div>
            <div class="card-container module_block">
                <form id="answer" method="post" onsubmit="SendAjax('#answer', 'answer', '', '', ''); return false;">
                    <input type="hidden" name="review_id" value="<?= $_GET['rid'] ?>">
                    <textarea id="editor" name="message"></textarea>
                </form>
                <div class="req_answer_but">
                    <button class="secondary_btn w100" type="submit" form="answer">
                        <?= $Translate->get_translate_module_phrase('module_page_request', '_ToAnswer') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="badge">
                    <?= $Translate->get_translate_module_phrase('module_page_request', '_ResponsesToApplication') ?>
                </div>
            </div>
            <div class="card-container">
                <div class="message_block_of scroll no-scrollbar">
                    <?php foreach ($Review as $key) : ?>
                        <?php if ($key['admin'] == 1) : ?>
                            <div class="message_block">
                                <div class="message_user_text">
                                    <div class="message_nickname"><?= action_text_clear(action_text_trim($General->checkName(con_steam32to64($key['steamid'])), 17)) ?></div>
                                    <div class="message_text"><?= $key['text'] ?></div>
                                </div>
                                <div class="message_date">
                                    <?= date('d.m.Y H:i:s', $key['date']) ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="message_block_player">
                                <div class="message_user_text_player">
                                    <div class="message_nickname_player"><?= action_text_clear(action_text_trim($General->checkName(con_steam32to64($key['steamid'])), 17)) ?></div>
                                    <div class="message_text_player"><?= $key['text'] ?></div>
                                </div>
                                <div class="message_date_player">
                                    <div class="delete_message" onclick="SendAjax('','del_answer','<?= $key['id'] ?>','','')"><?= $Translate->get_translate_module_phrase('module_page_request', '_DelMsg') ?></div>
                                    <?= date('d.m.Y H:i:s', $key['date']) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
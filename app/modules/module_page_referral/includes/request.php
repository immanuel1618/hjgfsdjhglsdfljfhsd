<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-bottom">
                <?= $Translate->get_translate_module_phrase('module_page_referral', '_WithdrawalRequests') ?>
            </div>
            <div class="card-container">
                <div class="ref-request_list scroll">
                    <?php foreach ($request as $item): ?>
                    <div class="ref-request-content">
                        <div class="ref-request-user-info">
                            <div class="user_avatar_profile">
                                <img style="position: absolute; transform: scale(1.17); border-radius: 0; top: -1px;" src="<?= $General->getFrame(con_steam64($item['steam_id'])) ?>" id="frame" frameid="<?= con_steam64($item['steam_id']) ?>" id="frame" frameid="<?= $item['steam_id'] ?>">
                                <img src="<?= $General->getAvatar(con_steam64($item['steam_id']), 3 )?>" id="avatar" avatarid="<?= con_steam64($item['steam_id']) ?>" alt="profile">
                            </div>
                            <div class="ref-request-user-request">
                                <a href="">
                                    <span class="ref-request-user-name">
                                        <svg class="none_span" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve"><g><circle cx="256" cy="114.526" r="114.526"></circle><path d="M256 256c-111.619 0-202.105 90.487-202.105 202.105 0 29.765 24.13 53.895 53.895 53.895h296.421c29.765 0 53.895-24.13 53.895-53.895C458.105 346.487 367.619 256 256 256z"></path></g></svg>
                                        <?= htmlspecialchars($General->checkName($item['steam_id'])); ?>
                                    </span>
                                </a>
                                <span class="ref-request-user-id">
                                    <?= htmlspecialchars($item['steam_id']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="ref-request-any-info">
                            <span class="ref-request-idnum"><?= $Translate->get_translate_module_phrase('module_page_referral', '_ID') ?>: <?= $item['id'] ?></span>
                            <span class="ref-request-date">
                                <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve"><g><circle cx="386" cy="210" r="20"></circle><path d="M432 40h-26V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-91V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20h-90V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v20H80C35.888 40 0 75.888 0 120v312c0 44.112 35.888 80 80 80h153c11.046 0 20-8.954 20-20s-8.954-20-20-20H80c-22.056 0-40-17.944-40-40V120c0-22.056 17.944-40 40-40h25v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h90v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h91v20c0 11.046 8.954 20 20 20s20-8.954 20-20V80h26c22.056 0 40 17.944 40 40v114c0 11.046 8.954 20 20 20s20-8.954 20-20V120c0-44.112-35.888-80-80-80z"></path><path d="M391 270c-66.72 0-121 54.28-121 121s54.28 121 121 121 121-54.28 121-121-54.28-121-121-121zm0 202c-44.663 0-81-36.336-81-81s36.337-81 81-81 81 36.336 81 81-36.337 81-81 81z"></path><path d="M420 371h-9v-21c0-11.046-8.954-20-20-20s-20 8.954-20 20v41c0 11.046 8.954 20 20 20h29c11.046 0 20-8.954 20-20s-8.954-20-20-20z"></path><circle cx="299" cy="210" r="20"></circle><circle cx="212" cy="297" r="20"></circle><circle cx="125" cy="210" r="20"></circle><circle cx="125" cy="297" r="20"></circle><circle cx="125" cy="384" r="20"></circle><circle cx="212" cy="384" r="20"></circle><circle cx="212" cy="210" r="20"></circle></g></svg>
                                <?= date('d.m, H:i', $item['create_date']) ?>
                            </span>
                        </div>
                        <span class="ref-request-withdrawal-text"><?= $item['type'] ?></span>
                        <div class="ref-request-sum-output">
                            <span class="ref-request-currency"><?= $item['cash'] ?> <?= $Translate->get_translate_module_phrase('module_page_referral', '_CurrencyRub') ?></span>
                        </div>
                        <div class="ref-request-status-badge">
                            <span class="ref-request-status-block ref-request-status-<?= $item['status'] === 'pending' ? '0' : ($item['status'] === 'accepted' ? '1' : '2') ?>">
                                <?= $item['status'] === 'pending' ? $Translate->get_translate_module_phrase('module_page_referral', '_Pending') : ($item['status'] === 'accepted' ? $Translate->get_translate_module_phrase('module_page_referral', '_Accepted') : $Translate->get_translate_module_phrase('module_page_referral', '_Declined')) ?>
                            </span>
                        </div>
                        <div class="ref-request-action-buttons">
                        <a class="ref-request-action-btn ref-request-accept-btn" 
                        onclick="loadRequestData(this)"
                        data-openmodal="viewRequestModal"
                        data-id="<?= $item['id'] ?>">
                        <?= $Translate->get_translate_module_phrase('module_page_referral', '_Review') ?>
                        <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" fill-rule="evenodd"><g><path d="M11 2H6a4 4 0 0 0-4 4v12a4 4 0 0 0 4 4h12a4 4 0 0 0 4-4v-5a1 1 0 0 0-2 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5a1 1 0 0 0 0-2zm7.586 2H15a1 1 0 0 1 0-2h6a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V5.414l-7.293 7.293a1 1 0 0 1-1.414-1.414z"></path></g></svg>
                        </a>
                            <button class="ref-request-action-btn ref-request-delete-btn none_span" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_referral', '_DeleteRequest') ?>" data-tippy-placement="top" id="ref-request-delete-btn" id_del="<?= $item['id'] ?>"><svg viewBox="0 0 448 512"><path d="M284.2 0C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2zM31.1 128H416L394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128zM143 272.1L190.1 319.1L143 367C133.7 376.4 133.7 391.6 143 400.1C152.4 410.3 167.6 410.3 176.1 400.1L223.1 353.9L271 400.1C280.4 410.3 295.6 410.3 304.1 400.1C314.3 391.6 314.3 376.4 304.1 367L257.9 319.1L304.1 272.1C314.3 263.6 314.3 248.4 304.1 239C295.6 229.7 280.4 229.7 271 239L223.1 286.1L176.1 239C167.6 229.7 152.4 229.7 143 239C133.7 248.4 133.7 263.6 143 272.1V272.1z"></path></svg></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if ($page_max > 1): ?>
            <div class="pagination">
                <?php if ($page_num != 1) : ?>
                    <a class="button_pagination current" href="?num=1">
                        <svg viewBox="0 0 448 512">
                            <path d="M77.25 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L77.25 256zM269.3 256l169.4-169.4c12.5-12.5 12.5-32.75 0-45.25s-32.75-12.5-45.25 0l-192 192c-12.5 12.5-12.5 32.75 0 45.25l192 192C399.6 476.9 407.8 480 416 480s16.38-3.125 22.62-9.375c12.5-12.5 12.5-32.75 0-45.25L269.3 256z"></path>
                        </svg>
                    </a>
                    <a class="button_pagination current" href="?num=<?= $page_num - 1 ?>">
                        <svg viewBox="0 0 384 512">
                            <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
                        </svg>
                    </a>
                <?php endif; ?>
                
                <?php if ($page_max < 5) : 
                    for ($i = 1; $i <= $page_max; $i++) : ?>
                        <a class="button_pagination current <?= $i == $page_num ? 'active' : '' ?>" href="?num=<?= $i ?>">
                            <?= $i; ?>
                        </a>
                    <?php endfor;
                else : 
                    for ($i = $startPag, $j = 1; $i < $startPag + 5 && $i <= $page_max; $i++, $j++) : ?>
                        <a class="button_pagination current <?= $i == $page_num ? 'active' : '' ?>" href="?num=<?= $i ?>">
                            <?= $i; ?>
                        </a>
                    <?php endfor;
                endif; ?>
                
                <?php if ($page_num != $page_max) : ?>
                    <a class="button_pagination current" href="?num=<?= $page_num + 1 ?>">
                        <svg viewBox="0 0 384 512">
                            <path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                        </svg>
                    </a>
                    <a class="button_pagination current" href="?num=<?= $page_max ?>">
                        <svg viewBox="0 0 448 512">
                            <path d="M246.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L178.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C15.63 476.9 23.81 480 32 480s16.38-3.125 22.62-9.375l192-192C259.1 266.1 259.1 245.9 246.6 233.4zM438.6 233.4l-192-192c-12.5-12.5-32.75-12.5-45.25 0s-12.5 32.75 0 45.25L370.8 256l-169.4 169.4c-12.5 12.5-12.5 32.75 0 45.25C207.6 476.9 215.8 480 224 480s16.38-3.125 22.62-9.375l192-192C451.1 266.1 451.1 245.9 438.6 233.4z"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="popup_modal" id="viewRequestModal">

</div>
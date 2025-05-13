<?php
$currentLevel = $referral['lvl'] ?? 1;
$currentMoney = $referral['money_all'] ?? 0;
$nextLevelRequirement = $levels[$currentLevel]['requirement'] ?? 0;
$prevLevelRequirement = $levels[$currentLevel - 1]['requirement'] ?? 0;

$progress = 0;

if ($currentLevel >= 5) {
    $progress = 100;
    $nextLevelRequirement = $levels[4]['requirement'];
} elseif ($nextLevelRequirement > 0) {
    $progress = min(100, max(0, (($currentMoney - $prevLevelRequirement) / ($nextLevelRequirement - $prevLevelRequirement)) * 100));
}

$minRotation = 315;
$maxRotation = 135; 
$rotation = $minRotation + ($progress / 100) * ($minRotation - $maxRotation);
?>
 
<div class="row">
    <div class="col-md-8">
        <div class="main-gap">
            <div class="card">
                <div class="stats-grid">
                <div class="level-container">
                    <div class="level-circle">
                        <div class="level-border"></div>
                        <div class="level-progress" style="transform: rotate(<?= $rotation ?>deg);"></div>
                        <div class="level-content">
                            <div class="level-number"><?= $currentLevel ?></div>
                                <?= $currentMoney ?>₽ / <?= $nextLevelRequirement ?>₽
                        </div>
                    </div>
                    <a class="secondary_btn w100" data-openmodal="OutputReferral"><?= $Translate->get_translate_module_phrase('module_page_referral', '_OutputReferral') ?></a>
                </div>
                    <div class="ref-center">
                        <div class="ref-balance">
                            <div class="stat-item color-money">
                                <div class="stat-header">
                                    <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve"><g><g><path d="M5 15c-2.21 0-4 1.79-4 4 0 .75.21 1.46.58 2.06C2.27 22.22 3.54 23 5 23s2.73-.78 3.42-1.94c.37-.6.58-1.31.58-2.06 0-2.21-1.79-4-4-4zm1.49 4.73h-.74v.78c0 .41-.34.75-.75.75s-.75-.34-.75-.75v-.78h-.74c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h.74v-.71c0-.41.34-.75.75-.75s.75.34.75.75v.71h.74a.749.749 0 1 1 0 1.5zM21.5 12.5H19c-1.1 0-2 .9-2 2s.9 2 2 2h2.5c.28 0 .5-.22.5-.5v-3c0-.28-.22-.5-.5-.5zM16.53 5.4c.3.29.05.74-.37.74l-8.28-.01c-.48 0-.72-.58-.38-.92l1.75-1.76a3.796 3.796 0 0 1 5.35 0l1.89 1.91.04.04z"></path><path d="M21.87 18.66C21.26 20.72 19.5 22 17.1 22h-6.5c-.39 0-.64-.43-.48-.79.3-.7.49-1.49.49-2.21 0-3.03-2.47-5.5-5.5-5.5-.76 0-1.5.16-2.18.46-.37.16-.82-.09-.82-.49V12c0-2.72 1.64-4.62 4.19-4.94.25-.04.52-.06.8-.06h10c.26 0 .51.01.75.05 2.02.23 3.48 1.46 4.02 3.29.1.33-.14.66-.48.66H19.1c-2.17 0-3.89 1.98-3.42 4.23.33 1.64 1.85 2.77 3.52 2.77h2.19c.35 0 .58.34.48.66z"></path></g></g></svg>
                                     <h4><?= $Translate->get_translate_module_phrase('module_page_referral', '_Balance') ?></h4>
                                </div>
                                <h2 class="stat-value"><?= $referral['money'] ?? 0 ?>₽</h2>
                            </div>
                            <div class="stat-item">
                                <div class="stat-header">
                                <svg xmlns="http://www.w3.org/2000/svg"width="' . $size . '"height="' . $size . '"viewBox="0 0 24 24"fill="none"stroke="currentColor"stroke-width="2"stroke-linecap="round"stroke-linejoin="round"><rect x="3" y="8" width="18" height="4" rx="1" /><path d="M12 8v13" /><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7" /><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 4.8 0 0 1 12 8a4.8 4.8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5" /></svg>
                                    <h4><?= $Translate->get_translate_module_phrase('module_page_referral', '_NewPlayerBonus') ?></h4>
                                </div>
                                <div class="stat-value primary-value"><h2><?= $referralSettings['first_deposit_bonus'] ?>₽</h2></div>
                            </div>
                        </div>
                        <div class="progress-container">
                            <div class="progress-header"> <h4><?= $Translate->get_translate_module_phrase('module_page_referral', '_Withdrawal') ?></h4></div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?= min(100, max(0, ($referral['money'] / $referralSettings['min_withdrawal_amount']) * 100)) ?>%;"></div>
                            </div>
                            <div class="progress-labels">
                                <div><?= $referral['money'] ?? 0 ?>₽</div>
                                <div><?= $Translate->get_translate_module_phrase('module_page_referral', '_Min') ?> <?= $referralSettings['min_withdrawal_amount'] ?>₽</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-bottom">
                    <?= $Translate->get_translate_module_phrase('module_page_referral', '_ReferralClients') ?>
                </div>
                <div class="card-container">
                    <table>
                        <thead>
                            <tr class="ref-table-header">
                                <th><?= $Translate->get_translate_module_phrase('module_page_referral', '_Nickname') ?></th>
                                <th><?= $Translate->get_translate_module_phrase('module_page_referral', '_Amount') ?></th>
                                <th><?= $Translate->get_translate_module_phrase('module_page_referral', '_Percentage') ?></th>
                                <th><?= $Translate->get_translate_module_phrase('module_page_referral', '_Payout') ?></th>
                                <th><?= $Translate->get_translate_module_phrase('module_page_referral', '_DateOfDeposit') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($referralPays)): ?>
                                <?php foreach ($referralPays as $pay): ?>
                                    <tr class="ref-table-body">
                                        <td class="ref-name" onclick="location.href = '<?= $General->arr_general['site'] . 'profiles/' . con_steam64($pay['steam_id']) . '/' . $server_group; ?>';"><?= htmlspecialchars($General->checkName($pay['steam_id'])); ?></td>
                                        <td class="ref-table-pay"><?= number_format($pay['sum'] ?? 0, 2) ?>₽</td>
                                        <td><?= $pay['proccent'] ?? 0 ?>%</td>
                                        <td class="ref-table-balance">+ <?= number_format($pay['sum_proccent'] ?? 0, 2) ?>₽</td>
                                        <td><?= $pay['date_pay']?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;"><?= $Translate->get_translate_module_phrase('module_page_referral', '_NoPaymentData') ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <?php if ($page_max > 1): ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="main-gap">
            <div class="card">
                <div class="card-header border-bottom">
                    <?= $Translate->get_translate_module_phrase('module_page_referral', '_ReferralLevels') ?>
                </div>
                <div class="card-container">
                    <div class="level-list">
                        <?php foreach ($levels as $tier): ?>
                        <div class="level-item <?= $tier['level'] == $currentLevel ? 'current-level' : '' ?>">
                            <div class="ref-level-requirement">
                                <span class="level-label"><?= $tier['level'] ?> LVL</span>
                                <span class="level-requirement">₽<?= $tier['requirement'] ?></span>
                            </div>
                            <div class="level-info">
                                <?php if ($tier['level'] == $currentLevel): ?>
                                    <span class="your-bonus"><?= $Translate->get_translate_module_phrase('module_page_referral', '_YourBonus') ?> <div><?= $tier['bonus'] ?>%</div></span>
                                <?php else: ?>
                                    <span class="level-bonus"><?= $tier['bonus'] ?>%</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-bottom">
                    <?= $Translate->get_translate_module_phrase('module_page_referral', '_Statistics') ?>
                </div>
                <div class="card-container">
                    <div class="stat-flex">
                        <div class="stat">
                            <div class="stat-header" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                                <span class="ref-title"><?= $Translate->get_translate_module_phrase('module_page_referral', '_PaidAmount') ?></span>
                            </div>
                            <div class="ref-number"><?= $referral['money_all_issued'] ?? 0 ?>₽</div>
                        </div>
                        <div class="stat">
                            <div class="stat-header" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span class="ref-title"><?= $Translate->get_translate_module_phrase('module_page_referral', '_PendingPayouts') ?></span>
                            </div>
                            <div class="ref-number"><?= $referral['money_transfer_now'] ?? 0 ?>₽</div>
                        </div>
                        <div class="stat">
                            <div class="stat-header" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                <span class="ref-title"><?= $Translate->get_translate_module_phrase('module_page_referral', '_TodayIncome') ?></span>
                            </div>
                            <div class="ref-number"><?= $todayPayments ?? 0 ?>₽</div>
                        </div>
                        <div class="stat">
                            <div class="stat-header" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                <span class="ref-title"><?= $Translate->get_translate_module_phrase('module_page_referral', '_AllTimeIncome') ?></span>
                            </div>
                            <div class="ref-number"><?= $referral['money_all'] ?? 0 ?>₽</div>
                        </div>
                        <div class="stat">
                            <div class="stat-header" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="m16 11 2 2 4-4"/></svg>
                                <span class="ref-title"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Deposits') ?></span>
                            </div>
                            <div class="ref-number"><?= $referralPaysTotal ?? 0 ?></div>
                        </div>
                        <div class="stat">
                            <div class="stat-header" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                <span class="ref-title"><?= $Translate->get_translate_module_phrase('module_page_referral', '_Activated') ?></span>
                            </div>
                            <div class="ref-number"><?= $activatedReferralsCount ?? 0 ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-bottom">
                    <?= $Translate->get_translate_module_phrase('module_page_referral', '_YourReferralCode') ?>
                </div>
                <div class="card-container">
                    <form id="ref" enctype="multipart/form-data" method="post">
                        <div class="input-form">
                            <input type="text" name="referral_code" placeholder="<?= $Translate->get_translate_module_phrase('module_page_referral', '_EnterCode') ?>" value="<?= htmlentities($referral['referral'] ?? '', ENT_QUOTES) ?>"<?= isset($referral['referral']) ? 'readonly' : '' ?>>
                        </div>
                        <input class="secondary_btn w100 mt10" name="ref-save" type="submit" form="ref" value="<?= $Translate->get_translate_module_phrase('module_page_referral', '_Save') ?>" <?= isset($referral['referral']) ? 'disabled' : '' ?>>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup_modal" id="OutputReferral">
    <div class="popup_modal_content no-close no-scrollbar">
        <div class="popup_modal_head">
            <?= $Translate->get_translate_module_phrase('module_page_referral', '_OutputReferralTitle') ?>
            <span class="popup_modal_close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </span>
        </div>
        <div class="ref-output-modal">
            <div class="output-options">
                <div class="option-box <?= ($referralSettings['withdrawal_switch_type'] == 2) ? 'disabled_ob' : '' ?>" data-type="1" onclick="selectOption(this)">
                    <div class="option-icon"></div>
                    <div class="option-title"><?= $Translate->get_translate_module_phrase('module_page_referral', '_WithdrawReal') ?></div>
                    <img src="/app/modules/module_page_referral/assets/img/pocket.png">
                </div>
                <div class="option-box <?= ($referralSettings['withdrawal_switch_type'] == 1) ? 'disabled_ob' : '' ?>" data-type="2" onclick="selectOption(this)">
                    <div class="option-icon"></div>
                    <div class="option-title"><?= $Translate->get_translate_module_phrase('module_page_referral', '_ToSite') ?></div>
                    <img src="/app/modules/module_page_referral/assets/img/cart.png">
                </div>
            </div>
            <form id="real-withdrawal-form" class="ref_window withdrawal-form" style="display: none;" enctype="multipart/form-data" method="post">
                <div class="input-form ref-input-modal">
                    <select class="custom-select" placeholder="<?= $Translate->get_translate_module_phrase('module_page_referral', '_Choose') ?>" name="withdrawal_output_type" required>
                        <?php foreach (explode(',', $referralSettings['available_withdrawal_types']) as $type): ?>
                            <option value="<?= htmlspecialchars(trim($type)) ?>"><?= htmlspecialchars(trim($type)) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="details" 
       placeholder="<?= $Translate->get_translate_module_phrase('module_page_referral', '_DetailsOutput') ?>" 
       pattern="[0-9]+" 
       title="Введите только цифры (номер карты или телефона)" 
       required
       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <div class="input-flex-number">
                        <input type="number" name="real_withdraw_amount" placeholder="<?= $Translate->get_translate_module_phrase('module_page_referral', '_WithdrawalAmount') ?>" min="1" required oninput="document.getElementById('amount-value').textContent = Math.round(this.value - (this.value * <?= $referralSettings['commission_output'] ?> / 100)) + ' ₽'">
                        <div class="amount-display">
                            <div id="amount-label" class="amount-label"><?= $Translate->get_translate_module_phrase('module_page_referral', '_AmountToReceive') ?></div>
                            <div id="amount-value" class="amount-value">0 ₽</div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="secondary_btn w100 mt10" onclick="submitWithdrawalForm(1)"><?= $Translate->get_translate_module_phrase('module_page_referral', '_WithdrawToRealButton') ?></button>
            </form>
            <form id="site-withdrawal-form" class="ref_window withdrawal-form" style="display: none;" enctype="multipart/form-data" method="post">
                <div class="input-form ref-input-modal">
                    <div class="input-flex-number">
                        <input type="number" name="site_withdraw_amount" placeholder="<?= $Translate->get_translate_module_phrase('module_page_referral', '_WithdrawalAmount') ?>" min="1" required oninput="document.getElementById('site-amount-value').textContent = Math.round(this.value - (this.value * <?= $referralSettings['percentage_converting'] ?> / 100)) + ' ₽'">
                        <div class="amount-display">
                            <div id="site-amount-label" class="amount-label"><?= $Translate->get_translate_module_phrase('module_page_referral', '_AmountToReceive') ?></div>
                            <div id="site-amount-value" class="amount-value">0 ₽</div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="secondary_btn w100 mt10" onclick="submitWithdrawalForm(2)"><?= $Translate->get_translate_module_phrase('module_page_referral', '_WithdrawToSiteButton') ?></button>
            </form>
        </div>
    </div>
</div>
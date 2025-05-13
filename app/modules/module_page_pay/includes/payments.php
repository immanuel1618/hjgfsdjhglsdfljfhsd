<?php

if (IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
}
if (isset($_SESSION['user_admin'])) :
    $pays = $LK->LkGetAllPays(); ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="badge">
                    <?php echo $Translate->get_translate_module_phrase('module_page_pay', '_PaymentsList') ?>          
                </div>
            </div>
            <div class="card-container">
                <?php if (!empty($pays)) : ?>
                    <div class="lk_scroll scroll">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">Steam</th>
                                    <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Date') ?></th>
                                    <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Gateways') ?></th>
                                    <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Amount') ?></th>
                                    <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Promo') ?></th>
                                    <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Status') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pays as $key) : ?>
                                    <tr id="p<?php echo $key['pay_order'] ?>">
                                        <th class="text-left"><?php echo $key['pay_order'] ?></th>
                                        <th class="text-left"><?php echo $key['pay_auth'] ?></th>
                                        <th class="text-left"><?php echo $key['pay_data'] ?></th>
                                        <th class="text-left"><img src="<?php echo $General->arr_general['site'] ?>app/modules/module_page_pay/assets/gateways/<?php echo mb_strtolower($key['pay_system']) ?>.svg"></th>
                                        <th class="text-left"><?php echo $key['pay_summ'] ?></th>
                                        <th class="text-left"><?php echo $key['pay_promo'] ?></th>
                                        <th class="text-left"><?php echo $LK->status($key['pay_status']) ?></th>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    Нет платежей
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php elseif (isset($_SESSION['steamid32']) && !isset($_SESSION['user_admin'])) :
    $pays = $LK->LkGetUserPays($_SESSION['steamid32']); ?>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_PaymentsList') ?></h5>
            </div>
            <div class="card-container module_block">
                <?php if (!empty($pays)) : ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-left">#</th>
                                <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Date') ?></th>
                                <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Gateways') ?></th>
                                <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Amount') ?></th>
                                <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Promo') ?></th>
                                <th class="text-left"><?php echo $Translate->get_translate_module_phrase('module_page_pay', '_Status') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pays as $key) : ?>
                                <tr id="p<?php echo $key['pay_order'] ?>">
                                    <th class="text-left"></a><?php echo $key['pay_order'] ?></th>
                                    <th class="text-left"><?php echo $key['pay_data'] ?></th>
                                    <th class="text-left"><img src="<?php echo $General->arr_general['site'] ?>app/modules/module_page_pay/assets/gateways/<?php echo mb_strtolower($key['pay_system']) ?>.svg"></th>
                                    <th class="text-left"><?php echo $key['pay_summ'] ?></th>
                                    <th class="text-left"><?php echo $key['pay_promo'] ?></th>
                                    <th class="text-left"><?php echo $LK->status($key['pay_status']) ?></th>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    Вы еще не пополняли свой баланс
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?><style type="text/css">
    .table-hover tr:target {
        background-color: rgba(242, 123, 38, 0.16);
    }
</style>
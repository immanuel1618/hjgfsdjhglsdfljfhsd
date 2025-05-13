<?php
if (isset($_POST['button'])) {
    if(isset($_SESSION['user_admin'])){
        if($_POST['button'] == 'add-server'){
            exit(json_encode($Server->create($_POST), true));
        }
        if($_POST['button'] == 'edit-ajax-server'){
            exit(json_encode($Server->getById($_POST['params']), true));
        }
        if($_POST['button'] == 'delete-server'){
            exit(json_encode($Server->deleteById($_POST['params']), true));
        }
        if($_POST['button'] == 'edit-server'){
            exit(json_encode($Server->updateById($_POST['params'], $_POST), true));
        }
        if($_POST['button'] == 'add-promo'){
            exit(json_encode($Promocode->create($_POST), true));
        }
        if($_POST['button'] == 'edit-promo'){
            exit(json_encode($Promocode->updateById($_POST['params'], $_POST), true));
        }
        if($_POST['button'] == 'delete-promo'){
            exit(json_encode($Promocode->deleteById($_POST['params']), true));
        }
        if($_POST['button'] == 'edit-ajax-promo'){
            exit(json_encode($Promocode->getById($_POST['params']), true));
        }
        if($_POST['button'] == 'add-cat'){
            exit(json_encode($Category->create($_POST), true));
        }
        if($_POST['button'] == 'edit-cat'){
            exit(json_encode($Category->updateById($_POST['params'], $_POST), true));
        }
        if($_POST['button'] == 'delete-cat'){
            exit(json_encode($Category->deleteById($_POST['params']), true));
        }
        if($_POST['button'] == 'edit-ajax-cat'){
            exit(json_encode($Category->getById($_POST['params']), true));
        }
        if($_POST['button'] == 'discount'){
            exit(json_encode($Discount->updateOrCreate($_POST['params'], $_POST), true));
        }
        if($_POST['button'] == 'amount-value'){
            exit(json_encode($ShopOptions->update($_POST), true));
        }
        if($_POST['button'] == 'gradient-update'){
            exit(json_encode($ShopOptions->update($_POST), true));
        }
        if($_POST['button'] == 'delete-table-property'){
            exit(json_encode($TableProperty->deleteById($_POST['params']), true));
        }
        if($_POST['button'] == 'delete-card-property'){
            exit(json_encode($CardProperty->deleteById($_POST['params']), true));
        }
        if(explode('_', $_POST['button'])[0] == 'edit-table-property'){
            exit(json_encode($TableProperty->updateById($_POST['params'], $_POST), true));
        }
        if(explode('_', $_POST['button'])[0] == 'edit-card-property'){
            exit(json_encode($CardProperty->updateById($_POST['params'], $_POST), true));
        }
        if(explode('_', $_POST['button'])[0] == 'create-table-property'){
            exit(json_encode($TableProperty->create($_POST), true));
        }
        if(explode('_', $_POST['button'])[0] == 'create-card-property'){
            exit(json_encode($CardProperty->create($_POST), true));
        }
        if($_POST['button'] == 'add-price-options'){
            exit(json_encode($OptionPrice->create($_POST), true));
        }
        if($_POST['button'] == 'update-price-options'){
            exit(json_encode($OptionPrice->updateById($_POST['params'], $_POST), true));
        }
        if($_POST['button'] == 'delete-price-options'){
            exit(json_encode($OptionPrice->deleteById($_POST['params']), true));
        }
        if($_POST['button'] == 'edit-ajax-price-options'){
            exit(json_encode($OptionPrice->getById($_POST['params']), true));
        }
        if($_POST['button'] == 'edit-price-options'){
            exit(json_encode($OptionPrice->updateById($_POST['params'], $_POST), true));
        }
        if($_POST['button'] == 'add-product'){
            exit(json_encode($Product->create($_POST), true));
        }
        if($_POST['button'] == 'delete-product'){
            exit(json_encode($Product->deleteById($_POST['params']), true));
        }
        if($_POST['button'] == 'edit-ajax-product'){
            exit(json_encode($Product->getById($_POST['params']), true));
        }
        if($_POST['button'] == 'edit-product'){
            exit(json_encode($Product->updateById($_POST['params'], $_POST), true));
        }
        if($_POST['button'] == 'copy-product'){
            exit(json_encode($Product->CopyById($_POST['params'], $_POST), true));
        }
        if($_POST['button'] == 'copy-product-properties'){
            exit(json_encode($Product->CopyPropertyByProductId($_POST['params'], $_POST), true));
        }
        if($_POST['button'] == 'discord-webhook'){
            exit(json_encode($ShopOptions->update($_POST), true));
        }
        if($_POST['button'] == 'vk-message'){
            exit(json_encode($ShopOptions->update($_POST), true));
        }
        if($_POST['button'] == 'only-admin'){
            exit(json_encode($ShopOptions->update($_POST), true));
        }
        if($_POST['button'] == 'use-server-accept'){
            exit(json_encode($ShopOptions->update($_POST), true));
        }
        if($_POST['button'] == 'extend-cards'){
            exit(json_encode($ShopOptions->update($_POST), true));
        }
    }

    if($_POST['button'] == 'get-ajax-table'){
        exit(json_encode($TableProperty->findByProductIds([$_POST['params']]), true));
    }

    if($_POST['button'] == 'add-product-basket'){
        exit(json_encode($Basket->create($_POST['params']), true));
    }
    if($_POST['button'] == 'delete-product-basket'){
        exit(json_encode($Basket->deleteById($_POST['params']), true));
    }

    if($_POST['button'] == 'pay-order') {
        exit(json_encode(
            $Order->paymentProcessing($_POST['steam'], $_POST['promo'] ?? ''), true
        ));
    }
}

<?php !defined("IN_LR") && die() ?>
<div class="bd_back">
    <div class="db_title"><?= $options['language'] == 'EN' ? 'Administrator' : 'Администратор' ?></div>
    <hr>
    <?php if (empty($data['avatar'])) : ?>
        <form enctype="multipart/form-data" method="post">
            <div class="webkey_form">
                <div class="input-form">
                    <div class="input_text">
                        <input name="admin" value="" placeholder="STEAM_1:1:390... / 7656119803... / [U:1:1234234] / https://steamcommunity.com/profiles/...">
                    </div>
                </div>
                <input class="secondary_btn w100" name="check_admin_steam" type="submit" value="<?= $options['language'] == 'EN' ? 'Check' : 'Проверить' ?>">
            </div>
        </form>
    <?php else : ?>
        <form enctype="multipart/form-data" method="post">
            <div class="webkey_form">
                <div class="admin_zone">
                    <img src="<?= $data['avatarfull'] ?>">
                    <div class="admin_name"><?= $data['personaname'] ?></div>
                    <hr>
                    <div class="admin_que">
                        <div class="admin_text"><?= $options['language'] == 'EN' ? 'This is your account?' : 'Это ваш аккаунт?' ?></div>
                        <div class="admin_buttons">
                            <input class="secondary_btn admin_yes w100" name="check_admin_steam_da" type="submit" value="<?= $options['language'] == 'EN' ? 'Yes' : 'Да' ?>">
                            <input class="secondary_btn btn_delete admin_no w100" name="check_admin_steam_net" type="submit" value="<?= $options['language'] == 'EN' ? 'No' : 'Нет' ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif ?>
</div>
<?php !defined("IN_LR") && die() ?>
<div class="bd_back">
    <div class="db_title"><?= $options['language'] == 'EN' ? 'Site Info' : 'Информация о сайте' ?></div>
    <form enctype="multipart/form-data" method="post">
        <div class="svrname_form">
            <div class="webkey_input">
                <div class="input-form">
                    <label class="input_text" for="srv_name"><?= $options['language'] == 'EN' ? 'Short Name' : 'Название сайта' ?></label>
                    <input id="srv_name" name="servers_name" value="" placeholder="<?= $options['language'] == 'EN' ? 'My awesome site' : 'Мой потрясающий сайт' ?>" required>
                </div>
                <div class="input-form">
                    <label class="input_text" for="srv_short_name"><?= $options['language'] == 'EN' ? 'Short Name' : 'Короткое название' ?></label>
                    <input id="srv_short_name" name="servers_name" value="" placeholder="<?= $options['language'] == 'MAS' ? 'Waffle' : 'МПС' ?>" required>
                </div>
                <div class="input-form">
                    <label class="input_text" for="srv_full_name"><?= $options['language'] == 'EN' ? 'Full Name' : 'Полное название' ?></label>
                    <input id="srv_full_name" name="servers_full_name" value="" placeholder="<?= $options['language'] == 'EN' ? 'My awesome site - Neo' : 'Мой потрясающий сайт - Neo' ?>" required>
                </div>
                <div class="input-form">
                    <label class="input_text" for="srv_dsc"><?= $options['language'] == 'EN' ? 'Info' : 'Описание' ?></label>
                    <input id="srv_dsc" name="servers_info" value="" placeholder="<?= $options['language'] == 'EN' ? 'The best Neo template for my unique project' : 'Самый лучший шаблон Neo для моего уникального проекта' ?>" required>
                </div>
            </div>
            <input class='secondary_btn w100' name="servers_info_save" type="submit" value="<?= $options['language'] == 'EN' ? 'Save' : 'Сохранить' ?>">
        </div>
    </form>
</div>
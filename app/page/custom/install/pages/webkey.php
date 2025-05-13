<?php !defined("IN_LR") && die() ?>
<div class="bd_back">
    <div class="db_title">STEAM WEB API KEY</div>
    <form enctype="multipart/form-data" method="post">
        <div class="webkey_form">
            <div class="webkey_input">
                <div class="input-form">
                    <div class="input_text">
                        <input name="web_key" value="<?php !empty($error) && $error == true && print 'WEB API KEY - ERROR' ?>" placeholder="Введите STEAM WEB API KEY">
                    </div>
                </div>
            </div>

            <input class="secondary_btn w100" name="check" type="submit" value="<?= $options['language'] == 'EN' ? 'Check' : 'Проверить' ?>">

        </div>
    </form>
</div>
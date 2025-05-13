<?php !defined("IN_LR") && die() ?>
<div class="bd_back">
    <div class="db_title"><?= $options['language'] == 'EN' ? 'Database setup' : 'Настройка базы данных' ?></div>
    <hr>
    <form enctype="multipart/form-data" method="post">
        <div class="db_left">
            <div class="input-form">
                <div class="input_text">HOST</div><input name="HOST" value="<?php !empty($_POST['HOST']) && print $_POST['HOST'] ?>" required>
            </div>
            <div class="input-form">
                <div class="input_text">USER</div><input name="USER" value="<?php !empty($_POST['USER']) && print $_POST['USER'] ?>" required>
            </div>
            <div class="input-form">
                <div class="input_text">DATABASE</div><input name="DATABASE" value="<?php !empty($_POST['DATABASE']) && print $_POST['DATABASE'] ?>" required>
            </div>
            <div class="input-form">
                <div class="input_text">PASS</div><input type="password" name="PASS" value="<?php !empty($_POST['PASS']) && print $_POST['PASS'] ?>" required>
            </div>
            <div class="check"><input class='secondary_btn w100' name="db_check" type="submit" value="<?= $options['language'] == 'EN' ? 'Check' : 'Проверить' ?>"></div>
        </div>
    </form>
</div>
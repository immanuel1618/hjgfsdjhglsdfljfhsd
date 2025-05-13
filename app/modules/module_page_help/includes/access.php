<div class="popup_modal" id="modal_access">
  <div class="popup_modal_content no-close no-scrollbar">
    <div class="popup_modal_head">
      <div>Управление доступом</div>
      <span class="popup_modal_close">
        <svg viewBox="0 0 320 512">
          <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
        </svg>
      </span>
    </div>
    <div class="h3_help">Список админов</div>
    <div class="input-form access_list">
      <?php foreach ($help->getAllAccess() as $key): ?>
        <div class="access_admin">
          <input value="<?= $key['steamid'] ?>" readonly>
          <div class="help_access_buttons">
            <div class="delete_access" onclick="Ajax('del_access', <?= $key['id'] ?>)">
              <svg viewBox="0 0 320 512">
                <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
              </svg>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <br>
    <div class="h3_help">Добавление</div>
    <form id="access_form" class="input-form">
      <label for="steamid" class="help_label_name">SteamID 64</label>
      <input type="text" id="steamid" name="steamid" value="">
    </form>
    <div class="help_accetp_buttons">
      <div class="secondary_btn" onclick="Ajax('add_access')">Добавить</div>
      <div class="secondary_btn btn_delete popup_modal_close"><?= $Translate->get_translate_module_phrase('module_page_help', '_Back') ?></div>
    </div>
  </div>
</div>
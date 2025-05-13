<div class="popup_modal" id="modal_editor">
  <div class="popup_modal_content no-close no-scrollbar">
    <div class="popup_modal_head">
      <div id="modal_editor_title">Добавление</div>
      <span class="popup_modal_close">
        <svg viewBox="0 0 320 512">
          <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
        </svg>
      </span>
    </div>
    <form id="content_form" class="input-form">
      <label for="content_title" class="help_label_name"><?=$Translate->get_translate_module_phrase('module_page_help', '_TitleContent')?></label>
      <input type="text" id="content_title" name="title" value="">
      <label for="content_svg" class="help_label_name"><?=$Translate->get_translate_module_phrase('module_page_help', '_Svg')?></label>
      <input type="text" id="content_svg" name="svg" value="">
      <label for="content_cat" class="help_label_name"><?=$Translate->get_translate_module_phrase('module_page_help', '_Category')?></label>
      <select id="content_cat" name="category"></select>
      <label for="content_sort" class="help_label_name"><?=$Translate->get_translate_module_phrase('module_page_help', '_Sort')?></label>
      <input type="text" id="content_sort" name="sort" value="">
    </form>
    <div id="editor"></div>
    <div class="help_accetp_buttons">
      <div class="secondary_btn" id="modal_editor_btn" onclick="Ajax('add_content')"><?=$Translate->get_translate_module_phrase('module_page_help', '_Save')?></div>
      <div class="secondary_btn btn_delete popup_modal_close"><?=$Translate->get_translate_module_phrase('module_page_help', '_Back')?></div>
    </div>
  </div>
</div>
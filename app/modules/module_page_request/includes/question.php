<?php if ($RQ->access < 5) {
  header('Location: ' . $General->arr_general['site']);
  exit;
}
$qid = $_GET['qid'];
$RequestQuestion = $RQ->getRequestQuestionAdmin($qid); ?>
<div class="col-md-9">
  <div class="card">
    <div class="card-header">
      <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_ApplicationQuestions') ?></h5>
    </div>
    <div class="card-container">
      <div class="modern_table">
        <div class="mt_header">
          <li>
            <span class="none_span">#</span>
            <span><?= $Translate->get_translate_module_phrase('module_page_request', '_Question') ?></span>
            <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_request', '_Description') ?></span>
            <span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_request', '_Hint') ?></span>
            <span></span>
          </li>
        </div>
        <div class="mt_content no-scrollbar">
          <?php foreach ($RequestQuestion as $key) : ?>
            <li>
              <span class="none_span"><?= $key['sort'] ?></span>
              <span><?= $key['question'] ?></span>
              <span class="none_span"><?= $key['desc'] ?></span>
              <span class="none_span"><?= $key['clue'] ?></span>
              <span>
                <a href="<?= set_url_section(get_url(2), 'question', $key['id']) ?>" class="req_btn" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_ToChange') ?>" data-tippy-placement="left">
                  <svg viewBox="0 0 512 512">
                    <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                  </svg>
                </a>
              </span>
            </li>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-md-3">
  <div class="card">
    <div class="card-header">
      <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_Settings') ?></h5>
    </div>
    <div class="card-container">
      <a class="secondary_btn w100" href="<?= set_url_section(get_url(2), 'question', 'add') ?>"><?= $Translate->get_translate_module_phrase('module_page_request', '_Add') ?> <?= $Translate->get_translate_module_phrase('module_page_request', '_Question') ?></a>
    </div>
  </div>
</div>
<?php if (isset($_GET['question']) && $_GET['question'] == 'add') : ?>
  <div class="col-md-9">
    <div class="card">
      <div class="card-header">
        <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_AddingQuestion') ?></h5>
        <a class="module_setting close">
          <svg data-del="delete" data-get="question" viewBox="0 0 320 512">
            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
          </svg>
        </a>
      </div>
      <div class="card-container module_block">
        <form id="question_add" method="post" onsubmit="SendAjax('#question_add', 'question_add', '', '', ''); return false;">
          <input type="hidden" name="request_id_question" value="<?= $qid ?>">
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Question') ?></div>
              <input class="in_f" name="question">
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Description') ?></div>
              <input class="in_f" name="desc">
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Hint') ?></div>
              <input class="in_f" name="clue">
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Sorting') ?></div>
              <input class="in_f" name="sort">
            </div>
          </div>
          <button type="submit" class="secondary_btn w100"><?= $Translate->get_translate_module_phrase('module_page_request', '_Add') ?></button>
        </form>
      </div>
    </div>
  </div>
<?php elseif (!empty($_GET['question'])) : $questionEdit = $RQ->getQuestionData($_GET['question']); ?>
  <div class="col-md-9">
    <div class="card">
      <div class="card-header">
        <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_ChangingQuestion') ?></h5>
        <a class="module_setting close">
          <svg data-del="delete" data-get="question" viewBox="0 0 320 512">
            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
          </svg>
        </a>
      </div>
      <div class="card-container module_block">
        <form id="question_edit" method="post" onsubmit="SendAjax('#question_edit', 'question_edit', '', '', ''); return false;">
          <input type="hidden" name="question_id_edit" value="<?= $_GET['question'] ?>">
          <input type="hidden" name="request_id_edit" value="<?= $qid ?>">
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Question') ?></div>
              <input class="in_f" name="question_edit" value="<?= $questionEdit['question'] ?>">
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Description') ?></div>
              <input class="in_f" name="desc_edit" value="<?= $questionEdit['desc'] ?>">
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Hint') ?></div>
              <input class="in_f" name="clue_edit" value="<?= $questionEdit['clue'] ?>">
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Sorting') ?></div>
              <input class="in_f" name="sort_edit" value="<?= $questionEdit['sort'] ?>">
            </div>
          </div>
        </form>
        <div class="case-buttons_bottom">
          <button type="submit" form="question_edit" class="secondary_btn w100"><?= $Translate->get_translate_module_phrase('module_page_request', '_Save') ?></button>
          <button class="secondary_btn w100 btn_delete" onclick="SendAjax('','question_del','<?= $_GET['question'] ?>','<?= $qid ?>','')">
            <?= $Translate->get_translate_module_phrase('module_page_request', '_Del') ?>
          </button>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
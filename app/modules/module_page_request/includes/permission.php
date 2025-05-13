<?php if ($RQ->access < 7) {
  header('Location: ' . $General->arr_general['site']);
  exit;
} ?>
<div class="col-md-<?php isset($_GET['admin']) ? print '8' : print '12' ?>">
  <div class="card">
    <div class="card-header">
      <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_ListAdmins') ?>
        <a class="module_setting close close_perm" href="<?= set_url_section(get_url(2), 'admin', 'add') ?>">
          <?= $Translate->get_translate_module_phrase('module_page_request', '_NewAdmin') ?>
        </a>
      </h5>
    </div>
    <div class="card-container">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th class="text-center"><?= $Translate->get_translate_module_phrase('module_page_request', '_NicknameTg') ?></th>
            <th class="text-center"><?= $Translate->get_translate_module_phrase('module_page_request', '_Applications_send') ?></th>
            <th class="text-center"><?= $Translate->get_translate_module_phrase('module_page_request', '_AccessApplications') ?></th>
            <th class="text-center"></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($Admins as $key) : ?>
            <tr>
              <td class="text-center">
                <?= $key['aid'] ?>
              </td>
              <td class="text-center">
                <a href="<?= $General->arr_general['site'] ?>profiles/<?= ($key['steamid']) ?>/?search=1/">
                  <?= action_text_clear(action_text_trim($General->checkName($key['steamid']), 17)) ?>
                </a>
              </td>
              <td class="text-center">
                <div class="center_svg">
                  <?php if (empty($key['request'])) : ?>
                    <svg class="xmark" viewBox="0 0 384 512">
                      <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                    </svg>
                  <?php else : ?>
                    <svg class="check" viewBox="0 0 448 512">
                      <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                    </svg>
                  <?php endif; ?>
                </div>
              </td>
              <td class="text-center">
                <div class="center_svg">
                  <?php if (empty($key['review'])) : ?>
                    <svg class="xmark" viewBox="0 0 384 512">
                      <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                    </svg>
                  <?php else : ?>
                    <svg class="check" viewBox="0 0 448 512">
                      <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                    </svg>
                  <?php endif; ?>
                </div>
              </td>
              <td>
                <a href="<?= set_url_section(get_url(2), 'admin', $key['aid']) ?>" class="req_btn" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_request', '_ToChange') ?>" data-tippy-placement="left">
                  <svg viewBox="0 0 512 512">
                    <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                  </svg>
                </a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php if (isset($_GET['admin']) && $_GET['admin'] == 'add') : ?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_AddingAdmin') ?></h5>
        <a class="module_setting close">
          <svg data-del="delete" data-get="admin" viewBox="0 0 320 512">
            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
          </svg>
        </a>
      </div>
      <div class="card-container module_block">
        <form id="perm_add" method="post" onsubmit="SendAjax('#perm_add', 'perm_add', '', '', ''); return false;">
          <div class="input-container">
            <div class="input-form">
              <div class="input_text">steamid 64</div>
              <input class="in_f" name="steamid">
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Applications_send') ?></div>
              <input class="border-checkbox" type="checkbox" name="request" id="request">
              <label class="border-checkbox-label" for="request"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_AccessApplications') ?></div>
              <input class="border-checkbox" type="checkbox" name="review" id="review">
              <label class="border-checkbox-label" for="review"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
            </div>
          </div>
          <button type="submit" class="secondary_btn w100"><?= $Translate->get_translate_module_phrase('module_page_request', '_Add') ?></button>
        </form>
      </div>
    </div>
  </div>
<?php elseif (!empty($_GET['admin'])) : $AdminEdit = $RQ->getAdmin($_GET['admin']); ?>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_request', '_ChangingAdmin') ?></h5>
        <a class="module_setting close">
          <svg data-del="delete" data-get="admin" viewBox="0 0 320 512">
            <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
          </svg>
        </a>
      </div>
      <div class="card-container module_block">
        <form id="perm_edit" method="post" onsubmit="SendAjax('#perm_edit', 'perm_edit', '', '', ''); return false;">
          <input type="hidden" name="admin_id_edit" value="<?= $_GET['admin'] ?>">
          <div class="input-container">
            <div class="input-form">
              <div class="input_text">steamid 64</div>
              <input class="in_f" name="steamid_edit" value="<?= $AdminEdit['steamid'] ?>">
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_Applications_sort') ?></div>
              <input class="border-checkbox" type="checkbox" name="request_edit" id="request_edit" <?php $AdminEdit['request'] && print 'checked'; ?>>
              <label class="border-checkbox-label" for="request_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
            </div>
          </div>
          <div class="input-container">
            <div class="input-form">
              <div class="input_text"><?= $Translate->get_translate_module_phrase('module_page_request', '_AccessApplications') ?></div>
              <input class="border-checkbox" type="checkbox" name="review_edit" id="review_edit" <?php $AdminEdit['review'] && print 'checked'; ?>>
              <label class="border-checkbox-label" for="review_edit"><?= $Translate->get_translate_module_phrase('module_page_request', '_OffOn') ?></label>
            </div>
          </div>
        </form>
        <div class="case-buttons_bottom">
          <button type="submit" form="perm_edit" class="secondary_btn w100"><?= $Translate->get_translate_module_phrase('module_page_request', '_Save') ?></button>
          <button class="secondary_btn btn_delete w100" onclick="SendAjax('', 'perm_del', '<?= $_GET['admin'] ?>', '', '')">
            <?= $Translate->get_translate_module_phrase('module_page_request', '_Del') ?>
          </button>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
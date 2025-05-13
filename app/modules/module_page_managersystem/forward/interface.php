<?php if (isset($_SESSION['user_admin'])):
  if ($General->arr_general['theme'] == 'neo'): ?>
    <div class="row">
      <div class="col-md-12">
        <div class="admin_nav">
          <?php if ($Core->TableSearch()): elseif (!empty($res_system[0]['admin_mod'])): ?>
            <button
              class="fill_width secondary_btn <?php ($page == 'addadmin' || $page == 'addwarn') && print 'active_btn_adm' ?>"
              onclick="location.href = '/managersystem/addadmin'">
              <svg viewBox="0 0 448 512">
                <path
                  d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z" />
              </svg>
              <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmins') ?>
            </button>
            <?php if (!empty($Db->db_data['AdminReward'])): ?>
              <button class="fill_width secondary_btn <?php $page == 'onlineadmins' && print 'active_btn_adm' ?>"
                onclick="location.href = '/managersystem/onlineadmins'">
                <svg viewBox="0 0 512 512">
                  <path
                    d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z">
                  </path>
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnlineAdmin') ?>
              </button>
            <?php endif; ?>
            <?php if (!empty($Db->db_data['Vips'])): ?>
              <button class="fill_width secondary_btn <?php $page == 'addvip' && print 'active_btn_adm' ?>"
                onclick="location.href = '/managersystem/addvip'">
                <svg viewBox="0 0 576 512">
                  <path
                    d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z" />
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSVips') ?>
              </button>
            <?php endif; ?>
            <button class="fill_width secondary_btn <?php $page == 'addban' && print 'active_btn_adm' ?>"
              onclick="location.href = '/managersystem/addban'">
              <svg viewBox="0 0 512 512">
                <path
                  d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
              </svg>
              <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSBans') ?>
            </button>
            <button class="fill_width secondary_btn <?php $page == 'addmute' && print 'active_btn_adm' ?>"
              onclick="location.href = '/managersystem/addmute'">
              <svg viewBox="0 0 640 512">
                <path
                  d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zm362.5 407l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4c20.4-2.8 39.7-9.1 57.3-18.2z" />
              </svg>
              <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPMutes') ?>
            </button>
            <button
              class="fill_width secondary_btn <?php ($page == 'settings' || $page == 'access' || $page == 'admingroup' || $page == 'vipgroup' || $page == 'punishmenttime' || $page == 'privilegestime' || $page == 'banreason' || $page == 'mutereason') && print 'active_btn_adm' ?>"
              onclick="location.href = '/managersystem/settings'">
              <svg viewBox="0 0 512 512">
                <path
                  d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336c44.2 0 80-35.8 80-80s-35.8-80-80-80s-80 35.8-80 80s35.8 80 80 80z">
                </path>
              </svg>
              <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings') ?>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php else: ?>
    <aside class="sidebar-right unshow">
      <section class="sidebar">
        <div class="user-sidebar-right-block">
          <div class="info">
            <div class="admin_type">
              <svg viewBox="0 0 512 512">
                <path
                  d="M78.6 5C69.1-2.4 55.6-1.5 47 7L7 47c-8.5 8.5-9.4 22-2.1 31.6l80 104c4.5 5.9 11.6 9.4 19 9.4h54.1l109 109c-14.7 29-10 65.4 14.3 89.6l112 112c12.5 12.5 32.8 12.5 45.3 0l64-64c12.5-12.5 12.5-32.8 0-45.3l-112-112c-24.2-24.2-60.6-29-89.6-14.3l-109-109V104c0-7.5-3.5-14.5-9.4-19L78.6 5zM19.9 396.1C7.2 408.8 0 426.1 0 444.1C0 481.6 30.4 512 67.9 512c18 0 35.3-7.2 48-19.9L233.7 374.3c-7.8-20.9-9-43.6-3.6-65.1l-61.7-61.7L19.9 396.1zM512 144c0-10.5-1.1-20.7-3.2-30.5c-2.4-11.2-16.1-14.1-24.2-6l-63.9 63.9c-3 3-7.1 4.7-11.3 4.7H352c-8.8 0-16-7.2-16-16V102.6c0-4.2 1.7-8.3 4.7-11.3l63.9-63.9c8.1-8.1 5.2-21.8-6-24.2C388.7 1.1 378.5 0 368 0C288.5 0 224 64.5 224 144l0 .8 85.3 85.3c36-9.1 75.8 .5 104 28.7L429 274.5c49-23 83-72.8 83-130.5zM104 432c0 13.3-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24z" />
              </svg>
            </div>
          </div>
        </div>
        <div class="menu">
          <ul class="nav">
            <?php if ($Core->TableSearch()): elseif (!empty($res_system[0]['admin_mod'])): ?>
              <li data-tippy-placement="left"
                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmins') ?>"
                <?php ($page == 'addadmin' || $page == 'addwarn') && print 'class="active_m"' ?>
                onclick="location.href = '/managersystem/addadmin'">
                <svg viewBox="0 0 448 512">
                  <path
                    d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z" />
                </svg>
              </li>
              <?php if (!empty($Db->db_data['AdminReward'])): ?>
                <li data-tippy-placement="left"
                  data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnlineAdmin') ?>"
                  <?php $page == 'onlineadmins' && print 'class="active_m"' ?>
                  onclick="location.href = '/managersystem/onlineadmins'">
                  <svg viewBox="0 0 576 512">
                    <path
                      d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z" />
                  </svg>
                </li>
              <?php endif; ?>
              <?php if (!empty($Db->db_data['Vips'])): ?>
                <li data-tippy-placement="left"
                  data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSVips') ?>"
                  <?php $page == 'addvip' && print 'class="active_m"' ?> onclick="location.href = '/managersystem/addvip'">
                  <svg viewBox="0 0 576 512">
                    <path
                      d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z" />
                  </svg>
                </li>
              <?php endif; ?>
              <li data-tippy-placement="left"
                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSBans') ?>"
                <?php $page == 'addban' && print 'class="active_m"' ?> onclick="location.href = '/managersystem/addban'">
                <svg viewBox="0 0 512 512">
                  <path
                    d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                </svg>
              </li>
              <li data-tippy-placement="left"
                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPMutes') ?>"
                <?php $page == 'addmute' && print 'class="active_m"' ?> onclick="location.href = '/managersystem/addmute'">
                <svg viewBox="0 0 640 512">
                  <path
                    d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zm362.5 407l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4c20.4-2.8 39.7-9.1 57.3-18.2z" />
                </svg>
              </li>
              <li data-tippy-placement="left"
                data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSSettings') ?>"
                <?php ($page == 'settings' || $page == 'access' || $page == 'admingroup' || $page == 'vipgroup' || $page == 'punishmenttime' || $page == 'privilegestime' || $page == 'banreason' || $page == 'mutereason') && print 'class="active_m"' ?> onclick="location.href = '/managersystem/settings'">
                <svg viewBox="0 0 512 512">
                  <path
                    d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336c44.2 0 80-35.8 80-80s-35.8-80-80-80s-80 35.8-80 80s35.8 80 80 80z">
                  </path>
                </svg>
              </li>
            <?php endif; ?>
            <li data-tippy-placement="left"
              data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSDev') ?>">
              <svg viewBox="0 0 512 512">
                <path
                  d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
              </svg>
            </li>
          </ul>
        </div>
      </section>
    </aside>
  <?php endif; ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card_header">
        <div class="svg_text_header">
          <div class="svg_header">
            <?php switch (true):
              case ($page == 'addadmin'):
                echo '<svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"/></svg>';
                break;
              case ($page == 'addwarn'):
                echo '<svg viewBox="0 0 512 512"><path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"></path></svg>';
                break;
              case ($page == 'addvip'):
                echo '<svg viewBox="0 0 576 512"><path d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z"/></svg>';
                break;
              case ($page == 'addban'):
                echo '<svg viewBox="0 0 512 512"><path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z"/></svg>';
                break;
              case ($page == 'addmute'):
                echo '<svg viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zm362.5 407l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4c20.4-2.8 39.7-9.1 57.3-18.2z"/></svg>';
                break;
              case ($page == 'onlineadmins'):
                echo '<svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg>';
                break;
              default:
                echo '<svg viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336c44.2 0 80-35.8 80-80s-35.8-80-80-80s-80 35.8-80 80s35.8 80 80 80z"></path></svg>';
                break;
            endswitch; ?>
          </div>
          <div class="header_text">
            <div class="flex_header_top">
              <?php switch (true):
                case ($page == 'install'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSInstallHeader');
                  break;
                case ($page == 'addadmin'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAdmin');
                  break;
                case ($page == 'addwarn'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYprPred');
                  break;
                case ($page == 'addvip'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderVip');
                  break;
                case ($page == 'addban'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderBan');
                  break;
                case ($page == 'addmute'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderMute');
                  break;
                case ($page == 'onlineadmins'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnlineAdmin');
                  break;
                default:
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderSetting');
                  break;
              endswitch; ?>
            </div>
            <div class="flex_header_bottom">
              <?php switch (true):
                case ($page == 'install'):
                  echo 'ManagerSystem by -r8 (<a href="https://discordapp.com/users/545261363631751174/" target="_blank">@r8.dev</a>)';
                  break;
                case ($page == 'addadmin'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAdminInfo');
                  break;
                case ($page == 'addwarn'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPredDesc');
                  break;
                case ($page == 'addvip'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderVipInfo');
                  break;
                case ($page == 'addban'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderBanInfo');
                  break;
                case ($page == 'addmute'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderMuteInfo');
                  break;
                case ($page == 'onlineadmins'):
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnlineDesc');
                  break;
                default:
                  echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderSettingInfo');
                  break;
              endswitch; ?>
            </div>
          </div>
        </div>
        <?php if (in_array($page, ['addadmin', 'addwarn'])): ?>
          <div class="block_buttons">
            <a class="button_add_func<?= ($page == 'addadmin') ? ' active_button' : '' ?>"
              href="/managersystem/addadmin"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdmin1') ?></a>
            <a class="button_add_func<?= ($page == 'addwarn') ? ' active_button' : '' ?>"
              href="/managersystem/addwarn"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddPred1') ?></a>
          </div>
        <?php endif; ?>
        <?php if ($page == 'addvip'): ?>
          <div class="block_buttons">
            <div class="button_add_func" id="ms_expires_del">
              <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSIstecPlayVip') ?></div>
          </div>
        <?php endif; ?>
        <?php if ($page == 'onlineadmins'): ?>
          <div class="block_buttons">
            <div class="button_add_func" id="ms_ar_moon_del">
              <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllMesStat') ?></div>
          </div>
        <?php endif; ?>
      </div>
      <?php if (in_array($page, ['settings', 'admingroup', 'vipgroup', 'banreason', 'mutereason', 'punishmenttime', 'privilegestime', 'access'])) {
        echo '<div class="settings_buttons_card"><div class="w1366 scroll"><div class="settings_buttons">';
        echo '<a class="settings_button' . (($page == 'settings') ? ' active_button' : '') . '" href="/managersystem/settings"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings1') . '</span></a>';
        if (!$Core->TableSearch()) {
          echo '<a class="settings_button' . (($page == 'access') ? ' active_button' : '') . '" href="/managersystem/access"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings2') . '</span></a>';
        }
        if ($Core->GetCache('settings')['group_choice_admin'] == 1 && $Core->GetCache('settings')['group_choice_vip'] == 0) {
          $page_group = 'admingroup';
          $href_group = '/managersystem/admingroup';
        } elseif ($Core->GetCache('settings')['group_choice_admin'] == 0 && $Core->GetCache('settings')['group_choice_vip'] == 1) {
          $page_group = 'vipgroup';
          $href_group = '/managersystem/vipgroup';
        } elseif ($Core->GetCache('settings')['group_choice_admin'] == 1 && $Core->GetCache('settings')['group_choice_vip'] == 1) {
          $page_group = 'admingroup';
          $href_group = '/managersystem/admingroup';
        }
        if (isset($page_group)) {
          echo '<a class="settings_button' . (($page == $page_group || $page == 'vipgroup') ? ' active_button' : '') . '" href="' . $href_group . '"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings3') . '</span></a>';
        }
        if ($Core->GetCache('settings')['reason_ban'] == 1 && $Core->GetCache('settings')['reason_mute'] == 0) {
          $page_reason = 'banreason';
          $href_reason = '/managersystem/banreason';
        } elseif ($Core->GetCache('settings')['reason_ban'] == 0 && $Core->GetCache('settings')['reason_mute'] == 1) {
          $page_reason = 'mutereason';
          $href_reason = '/managersystem/mutereason';
        } elseif ($Core->GetCache('settings')['reason_ban'] == 1 && $Core->GetCache('settings')['reason_mute'] == 1) {
          $page_reason = 'banreason';
          $href_reason = '/managersystem/banreason';
        }
        if (isset($page_reason)) {
          echo '<a class="settings_button' . (($page == $page_reason || $page == 'mutereason') ? ' active_button' : '') . '" href="' . $href_reason . '"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings4') . '</span></a>';
        }
        if ($Core->GetCache('settings')['time_choice_punishment'] == 1 && $Core->GetCache('settings')['time_choice_privileges'] == 0) {
          $page_time = 'punishmenttime';
          $href_time = '/managersystem/punishmenttime';
        } elseif ($Core->GetCache('settings')['time_choice_punishment'] == 0 && $Core->GetCache('settings')['time_choice_privileges'] == 1) {
          $page_time = 'privilegestime';
          $href_time = '/managersystem/privilegestime';
        } elseif ($Core->GetCache('settings')['time_choice_punishment'] == 1 && $Core->GetCache('settings')['time_choice_privileges'] == 1) {
          $page_time = 'punishmenttime';
          $href_time = '/managersystem/punishmenttime';
        }
        if (isset($page_time)) {
          echo '<a class="settings_button' . (($page == $page_time || $page == 'privilegestime') ? ' active_button' : '') . '" href="' . $href_time . '"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings5') . '</span></a>';
        }
        echo '</div></div></div>';
      } else {
        echo '';
      } ?>
      <?php if (in_array($page, ['admingroup', 'vipgroup'])) {
        echo '<div class="settings_buttons_card"><div class="settings_buttons_bottom">';
        if ($Core->GetCache('settings')['group_choice_admin'] == 1 && $Core->GetCache('settings')['group_choice_vip'] == 0) {
          echo '<a class="settings_button_bottom' . (($page == 'admingroup') ? ' active_button' : '') . '" href="/managersystem/admingroup"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings31') . '</span></a>';
        } elseif ($Core->GetCache('settings')['group_choice_admin'] == 0 && $Core->GetCache('settings')['group_choice_vip'] == 1) {
          echo '<a class="settings_button_bottom' . (($page == 'vipgroup') ? ' active_button' : '') . '" href="/managersystem/vipgroup"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings32') . '</span></a>';
        } elseif ($Core->GetCache('settings')['group_choice_admin'] == 1 && $Core->GetCache('settings')['group_choice_vip'] == 1) {
          echo '<a class="settings_button_bottom' . (($page == 'admingroup') ? ' active_button' : '') . '" href="/managersystem/admingroup"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings31') . '</span></a>';
          echo '<a class="settings_button_bottom' . (($page == 'vipgroup') ? ' active_button' : '') . '" href="/managersystem/vipgroup"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings32') . '</span></a>';
        }
        echo '</div></div>';
      } ?>
      <?php if (in_array($page, ['banreason', 'mutereason'])) {
        echo '<div class="settings_buttons_card"><div class="settings_buttons_bottom">';
        if ($Core->GetCache('settings')['reason_ban'] == 1 && $Core->GetCache('settings')['reason_mute'] == 0) {
          echo '<a class="settings_button_bottom' . (($page == 'banreason') ? ' active_button' : '') . '" href="/managersystem/banreason"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings41') . '</span></a>';
        } elseif ($Core->GetCache('settings')['reason_ban'] == 0 && $Core->GetCache('settings')['reason_mute'] == 1) {
          echo '<a class="settings_button_bottom' . (($page == 'mutereason') ? ' active_button' : '') . '" href="/managersystem/mutereason"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings42') . '</span></a>';
        } elseif ($Core->GetCache('settings')['reason_ban'] == 1 && $Core->GetCache('settings')['reason_mute'] == 1) {
          echo '<a class="settings_button_bottom' . (($page == 'banreason') ? ' active_button' : '') . '" href="/managersystem/banreason"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings41') . '</span></a>';
          echo '<a class="settings_button_bottom' . (($page == 'mutereason') ? ' active_button' : '') . '" href="/managersystem/mutereason"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings42') . '</span></a>';
        }
        echo '</div></div>';
      } ?>
      <?php if (in_array($page, ['punishmenttime', 'privilegestime'])) {
        echo '<div class="settings_buttons_card"><div class="settings_buttons_bottom">';
        if ($Core->GetCache('settings')['time_choice_punishment'] == 1 && $Core->GetCache('settings')['time_choice_privileges'] == 0) {
          echo '<a class="settings_button_bottom' . (($page == 'punishmenttime') ? ' active_button' : '') . '" href="/managersystem/punishmenttime"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings51') . '</span></a>';
        } elseif ($Core->GetCache('settings')['time_choice_punishment'] == 0 && $Core->GetCache('settings')['time_choice_privileges'] == 1) {
          echo '<a class="settings_button_bottom' . (($page == 'privilegestime') ? ' active_button' : '') . '" href="/managersystem/privilegestime"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings52') . '</span></a>';
        } elseif ($Core->GetCache('settings')['time_choice_punishment'] == 1 && $Core->GetCache('settings')['time_choice_privileges'] == 1) {
          echo '<a class="settings_button_bottom' . (($page == 'punishmenttime') ? ' active_button' : '') . '" href="/managersystem/punishmenttime"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings51') . '</span></a>';
          echo '<a class="settings_button_bottom' . (($page == 'privilegestime') ? ' active_button' : '') . '" href="/managersystem/privilegestime"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings52') . '</span></a>';
        }
        echo '</div></div>';
      } ?>
      <?php if (in_array($page, ['addadmin', 'addban', 'addmute']) && ($res_system[$server_group]['admin_mod'] == 'IksAdmin' || $res_system[$server_group]['admin_mod'] == 'AdminSystem')): ?>
        <div class="settings_buttons_card">
          <div class="w1366 scroll">
            <div class="settings_buttons">
              <a class="settings_button <?php if ($server_id == 'all') echo 'active_button'; ?>" href="/managersystem/<?= $page; ?>/all/">
                <span>
                  <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') ?>
                </span>
              </a>
              <?php if (($Core->GetCache('settings')['add_punishment_all']) && in_array($page, ['addban', 'addmute'])): ?>
              <?php else: ?>
                <?php foreach ($Core->GetCache('serversiks') as $key): ?>
                  <a class="settings_button <?php if ($server_id == $key["server_id"]) echo 'active_button'; ?>" href="/managersystem/<?= $page; ?>/<?= $key["server_id"]; ?>/">
                    <span>
                      <?= $key["server_name"]; ?>
                    </span>
                  </a>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php if ($page === 'onlineadmins'): ?>
        <div class="settings_buttons_card">
          <div class="w1366 scroll">
            <div class="settings_buttons"><a class="settings_button <?php if ($SRV_ID == 'all')
                                                                      echo 'active_button'; ?>"
                href="/managersystem/<?= $page; ?>/all/"><span><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') ?></span></a><?php foreach ($ARServer as $key): ?><a
                  class="settings_button <?php if ($SRV_ID == $key["SRV_ID"])
                                                                                                                                                                          echo 'active_button'; ?>"
                  href="/managersystem/<?= $page; ?>/<?= $key["SRV_ID"]; ?>/"><span><?= $key["srvname"]; ?></span></a><?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php if ($page === 'addvip' && empty($Core->GetCache('settings')['vip_one_table'])): ?>
        <div class="settings_buttons_card">
          <div class="w1366 scroll">
            <div class="settings_buttons"><?php for ($b = 0, $_c = sizeof($res_vip); $b < $_c; $b++): ?><a class="settings_button <?php if (($res_vip[$b]['Name']) == ($res_vip[$server_group_vip]['Name'])) {
                                                                                                                                    echo 'active_button';
                                                                                                                                  } ?>"
                  href="<?php echo set_url_section(get_url(2), 'server_id_vip', $b) ?>"><span><?php echo $res_vip[$b]['Name'] ?></span></a><?php endfor; ?>
            </div>
          </div>
        </div>
      <?php elseif ($page === 'addvip' && $Core->GetCache('settings')['vip_one_table'] == 1): ?>
        <div class="settings_buttons_card">
          <div class="w1366 scroll">
            <div class="settings_buttons"><a class="settings_button <?php if ($sid == 'all')
                                                                      echo 'active_button'; ?>"
                href="/managersystem/<?= $page; ?>/all/"><span><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') ?></span></a><?php foreach ($Core->GetCache('serversvip') as $key): ?><a
                  class="settings_button <?php if ($sid == $key["server_id"])
                                                                                                                                                                          echo 'active_button'; ?>"
                  href="/managersystem/<?= $page; ?>/<?= $key["server_id"]; ?>/"><span><?= $key["server_name"]; ?></span></a><?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php require MODULES . "module_page_managersystem/pages/{$page}.php"; ?>
    </div>
  </div>
  <?php else:
  if (!empty($Access)):
    foreach ($Access as $admin):
      if ($admin['steamid_access'] == $_SESSION['steamid64']):
        if ($General->arr_general['theme'] == 'neo'): ?>
          <div class="row">
            <div class="col-md-12">
              <div class="admin_nav">
                <?php if (!empty($res_system[0]['admin_mod'])): ?>
                  <?php
                  if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_admin_access'] == 1): ?>
                    <button
                      class="fill_width secondary_btn <?php ($page == 'addadmin' || $page == 'addwarn') && print 'active_btn_adm' ?>"
                      onclick="location.href = '/managersystem/addadmin'">
                      <svg viewBox="0 0 448 512">
                        <path
                          d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z" />
                      </svg>
                      <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmins') ?>
                    </button>
                  <?php
                  endif; ?>
                  <?php if (!empty($Db->db_data['AdminReward'])): ?>
                    <?php
                    if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_timecheck_access'] == 1): ?>
                      <button class="fill_width secondary_btn <?php $page == 'onlineadmins' && print 'active_btn_adm' ?>"
                        onclick="location.href = '/managersystem/onlineadmins'">
                        <svg viewBox="0 0 512 512">
                          <path
                            d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z">
                          </path>
                        </svg>
                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnlineAdmin') ?>
                      </button>
                    <?php
                    endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($Db->db_data['Vips'])): ?>
                  <?php
                  if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_vip_access'] == 1): ?>
                    <button class="fill_width secondary_btn <?php $page == 'addvip' && print 'active_btn_adm' ?>"
                      onclick="location.href = '/managersystem/addvip'">
                      <svg viewBox="0 0 576 512">
                        <path
                          d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z" />
                      </svg>
                      <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSVips') ?>
                    </button>
                  <?php
                  endif; ?>
                <?php endif; ?>
                <?php if (!empty($res_system[0]['admin_mod'])): ?>
                  <?php
                  if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_ban_access'] == 1): ?>
                    <button class="fill_width secondary_btn <?php $page == 'addban' && print 'active_btn_adm' ?>"
                      onclick="location.href = '/managersystem/addban'">
                      <svg viewBox="0 0 512 512">
                        <path
                          d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                      </svg>
                      <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSBans') ?>
                    </button>
                  <?php
                  endif; ?>
                  <?php
                  if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_mute_access'] == 1): ?>
                    <button class="fill_width secondary_btn <?php $page == 'addmute' && print 'active_btn_adm' ?>"
                      onclick="location.href = '/managersystem/addmute'">
                      <svg viewBox="0 0 640 512">
                        <path
                          d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zm362.5 407l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4c20.4-2.8 39.7-9.1 57.3-18.2z" />
                      </svg>
                      <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPMutes') ?>
                    </button>
                  <?php
                  endif; ?>
                  <?php
                  if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_access'] == 1): ?>
                    <button class="fill_width secondary_btn <?php $page == 'access' && print 'active_btn_adm' ?>"
                      onclick="location.href = '/managersystem/access'">
                      <svg viewBox="0 0 512 512">
                        <path
                          d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z" />
                      </svg>
                      <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPageAccess') ?>
                    </button>
                  <?php
                  endif; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php else: ?>
          <aside class="sidebar-right unshow">
            <section class="sidebar">
              <div class="user-sidebar-right-block">
                <div class="info">
                  <div class="admin_type">
                    <svg viewBox="0 0 512 512">
                      <path
                        d="M78.6 5C69.1-2.4 55.6-1.5 47 7L7 47c-8.5 8.5-9.4 22-2.1 31.6l80 104c4.5 5.9 11.6 9.4 19 9.4h54.1l109 109c-14.7 29-10 65.4 14.3 89.6l112 112c12.5 12.5 32.8 12.5 45.3 0l64-64c12.5-12.5 12.5-32.8 0-45.3l-112-112c-24.2-24.2-60.6-29-89.6-14.3l-109-109V104c0-7.5-3.5-14.5-9.4-19L78.6 5zM19.9 396.1C7.2 408.8 0 426.1 0 444.1C0 481.6 30.4 512 67.9 512c18 0 35.3-7.2 48-19.9L233.7 374.3c-7.8-20.9-9-43.6-3.6-65.1l-61.7-61.7L19.9 396.1zM512 144c0-10.5-1.1-20.7-3.2-30.5c-2.4-11.2-16.1-14.1-24.2-6l-63.9 63.9c-3 3-7.1 4.7-11.3 4.7H352c-8.8 0-16-7.2-16-16V102.6c0-4.2 1.7-8.3 4.7-11.3l63.9-63.9c8.1-8.1 5.2-21.8-6-24.2C388.7 1.1 378.5 0 368 0C288.5 0 224 64.5 224 144l0 .8 85.3 85.3c36-9.1 75.8 .5 104 28.7L429 274.5c49-23 83-72.8 83-130.5zM104 432c0 13.3-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24z" />
                    </svg>
                  </div>
                </div>
              </div>
              <div class="menu">
                <ul class="nav">
                  <?php if (!empty($res_system[0]['admin_mod'])): ?>
                    <?php if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_admin_access'] == 1): ?>
                      <li data-tippy-placement="left"
                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAdmins') ?>"
                        <?php $page == 'addadmin' && print 'class="active_m"' ?> onclick="location.href = '/managersystem/addadmin'">
                        <svg viewBox="0 0 640 512">
                          <path
                            d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                        </svg>
                      </li>
                    <?php endif; ?>
                    <?php if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_timecheck_access'] == 1): ?>
                      <li data-tippy-placement="left"
                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnlineAdmin') ?>"
                        <?php $page == 'onlineadmins' && print 'class="active_m"' ?>
                        onclick="location.href = '/managersystem/onlineadmins'">
                        <svg viewBox="0 0 512 512">
                          <path
                            d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z">
                          </path>
                        </svg>
                      </li>
                    <?php endif; ?>
                  <?php endif; ?>
                  <?php if (!empty($Db->db_data['Vips'])): ?>
                    <?php if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_vip_access'] == 1): ?>
                      <li data-tippy-placement="left"
                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSVips') ?>"
                        <?php $page == 'addvip' && print 'class="active_m"' ?> onclick="location.href = '/managersystem/addvip'">
                        <svg viewBox="0 0 576 512">
                          <path
                            d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z" />
                        </svg>
                      </li>
                    <?php endif; ?>
                  <?php endif; ?>
                  <?php if (!empty($res_system[0]['admin_mod'])): ?>
                    <?php if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_ban_access'] == 1): ?>
                      <li data-tippy-placement="left"
                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSBans') ?>"
                        <?php $page == 'addban' && print 'class="active_m"' ?> onclick="location.href = '/managersystem/addban'">
                        <svg viewBox="0 0 512 512">
                          <path
                            d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
                        </svg>
                      </li>
                    <?php endif; ?>
                    <?php if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_mute_access'] == 1): ?>
                      <li data-tippy-placement="left"
                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPMutes') ?>"
                        <?php $page == 'addmute' && print 'class="active_m"' ?> onclick="location.href = '/managersystem/addmute'">
                        <svg viewBox="0 0 640 512">
                          <path
                            d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zm362.5 407l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4c20.4-2.8 39.7-9.1 57.3-18.2z" />
                        </svg>
                      </li>
                    <?php endif; ?>
                    <?php if ($admin['steamid_access'] == $_SESSION['steamid64'] && $admin['add_access'] == 1): ?>
                      <li data-tippy-placement="left"
                        data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPageAccess') ?>"
                        <?php $page == 'access' && print 'class="active_m"' ?> onclick="location.href = '/managersystem/access'">
                        <svg viewBox="0 0 512 512">
                          <path
                            d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z" />
                        </svg>
                      </li>
                    <?php endif; ?>
                  <?php endif; ?>
                </ul>
              </div>
            </section>
          </aside>
        <?php endif; ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card_header">
              <div class="svg_text_header">
                <div class="svg_header">
                  <?php switch (true):
                    case ($page == 'addadmin'):
                      echo '<svg viewBox="0 0 448 512"><path d="M230.1 .8l152 40c8.6 2.3 15.3 9.1 17.3 17.8s-1 17.8-7.8 23.6L368 102.5v8.4c0 10.7-5.3 20.8-15.1 25.2c-24.1 10.8-68.6 24-128.9 24s-104.8-13.2-128.9-24C85.3 131.7 80 121.6 80 110.9v-8.4L56.4 82.2c-6.8-5.8-9.8-14.9-7.8-23.6s8.7-15.6 17.3-17.8l152-40c4-1.1 8.2-1.1 12.2 0zM227 48.6c-1.9-.8-4-.8-5.9 0L189 61.4c-3 1.2-5 4.2-5 7.4c0 17.2 7 46.1 36.9 58.6c2 .8 4.2 .8 6.2 0C257 114.9 264 86 264 68.8c0-3.3-2-6.2-5-7.4L227 48.6zM98.1 168.8c39.1 15 81.5 23.2 125.9 23.2s86.8-8.2 125.9-23.2c1.4 7.5 2.1 15.3 2.1 23.2c0 70.7-57.3 128-128 128s-128-57.3-128-128c0-7.9 .7-15.7 2.1-23.2zM134.4 352c2.8 0 5.5 .9 7.7 2.6l72.3 54.2c5.7 4.3 13.5 4.3 19.2 0l72.3-54.2c2.2-1.7 4.9-2.6 7.7-2.6C387.8 352 448 412.2 448 486.4c0 14.1-11.5 25.6-25.6 25.6H25.6C11.5 512 0 500.5 0 486.4C0 412.2 60.2 352 134.4 352zM352 408c-3.5 0-6.5 2.2-7.6 5.5L339 430.2l-17.4 0c-3.5 0-6.6 2.2-7.6 5.5s.1 6.9 2.9 9L331 454.8l-5.4 16.6c-1.1 3.3 .1 6.9 2.9 9s6.6 2 9.4 0L352 470.1l14.1 10.3c2.8 2 6.6 2.1 9.4 0s4-5.7 2.9-9L373 454.8l14.1-10.2c2.8-2 4-5.7 2.9-9s-4.2-5.5-7.6-5.5l-17.4 0-5.4-16.6c-1.1-3.3-4.1-5.5-7.6-5.5z"/></svg>';
                      break;
                    case ($page == 'addwarn'):
                      echo '<svg viewBox="0 0 512 512"><path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"></path></svg>';
                      break;
                    case ($page == 'addvip'):
                      echo '<svg viewBox="0 0 576 512"><path d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z"/></svg>';
                      break;
                    case ($page == 'addban'):
                      echo '<svg viewBox="0 0 512 512"><path d="M367.2 412.5L99.5 144.8C77.1 176.1 64 214.5 64 256c0 106 86 192 192 192c41.5 0 79.9-13.1 111.2-35.5zm45.3-45.3C434.9 335.9 448 297.5 448 256c0-106-86-192-192-192c-41.5 0-79.9 13.1-111.2 35.5L412.5 367.2zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z"/></svg>';
                      break;
                    case ($page == 'addmute'):
                      echo '<svg viewBox="0 0 640 512"><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L472.1 344.7c15.2-26 23.9-56.3 23.9-88.7V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 21.2-5.1 41.1-14.2 58.7L416 300.8V96c0-53-43-96-96-96s-96 43-96 96v54.3L38.8 5.1zm362.5 407l-43.1-33.9C346.1 382 333.3 384 320 384c-70.7 0-128-57.3-128-128v-8.7L144.7 210c-.5 1.9-.7 3.9-.7 6v40c0 89.1 66.2 162.7 152 174.4V464H248c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H344V430.4c20.4-2.8 39.7-9.1 57.3-18.2z"/></svg>';
                      break;
                    case ($page == 'onlineadmins'):
                      echo '<svg viewBox="0 0 512 512"><path d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path></svg>';
                      break;
                    default:
                      echo '<svg viewBox="0 0 512 512"><path d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"></path></svg>';
                      break;
                  endswitch; ?>
                </div>
                <div class="header_text">
                  <div class="flex_header_top">
                    <?php switch (true):
                      case ($page == 'addadmin'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAdmin');
                        break;
                      case ($page == 'addwarn'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSYprPred');
                        break;
                      case ($page == 'addvip'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderVip');
                        break;
                      case ($page == 'addban'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderBan');
                        break;
                      case ($page == 'addmute'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderMute');
                        break;
                      case ($page == 'onlineadmins'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnlineAdmin');
                        break;
                      default:
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAccess');
                        break;
                    endswitch; ?>
                  </div>
                  <div class="flex_header_bottom">
                    <?php switch (true):
                      case ($page == 'addadmin'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAdminInfo');
                        break;
                      case ($page == 'addwarn'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSPredDesc');
                        break;
                      case ($page == 'addvip'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderVipInfo');
                        break;
                      case ($page == 'addban'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderBanInfo');
                        break;
                      case ($page == 'addmute'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderMuteInfo');
                        break;
                      case ($page == 'onlineadmins'):
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSOnlineDesc');
                        break;
                      default:
                        echo $Translate->get_translate_module_phrase('module_page_managersystem', '_MSHeaderAccessInfo');
                        break;
                    endswitch; ?>
                  </div>
                </div>
              </div>
              <?php foreach ($Access as $access):
                if ($access['steamid_access'] == $_SESSION['steamid64'] && $access['add_warn_access'] == 1): ?>
                  <?php if (in_array($page, ['addadmin', 'addwarn'])): ?>
                    <div class="block_buttons">
                      <a class="button_add_func<?= ($page == 'addadmin') ? ' active_button' : '' ?>"
                        href="/managersystem/addadmin"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddAdmin1') ?></a>
                      <a class="button_add_func<?= ($page == 'addwarn') ? ' active_button' : '' ?>"
                        href="/managersystem/addwarn"><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAddPred1') ?></a>
                    </div>
              <?php endif;
                endif;
              endforeach; ?>
            </div>
            <?php if ($page == 'access') {
              echo '<div class="settings_buttons_card"><div class="settings_buttons">';
              echo '<a class="settings_button' . (($page == 'access') ? ' active_button' : '') . '" href="/managersystem/access"><span>' . $Translate->get_translate_module_phrase('module_page_managersystem', '_MSButtonSettings2') . '</span></a>';
              echo '</div></div>';
            } else {
              echo '';
            } ?>
            <?php if (in_array($page, ['addadmin', 'addban', 'addmute'])  && ($res_system[$server_group]['admin_mod'] == 'AdminSystem' || $res_system[$server_group]['admin_mod'] == 'IksAdmin')): ?>
              <div class="settings_buttons_card">
                <div class="w1366 scroll">
                  <div class="settings_buttons">
                    <a class="settings_button <?php if ($server_id == 'all') echo 'active_button'; ?>" href="/managersystem/<?= $page; ?>/all/">
                      <span>
                        <?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') ?>
                      </span>
                    </a>
                    <?php if (($Core->GetCache('settings')['add_punishment_all']) && in_array($page, ['addban', 'addmute'])): ?>
                    <?php else: ?>
                      <?php foreach ($Core->GetCache('serversiks') as $key): ?>
                        <a class="settings_button <?php if ($server_id == $key["server_id"]) echo 'active_button'; ?>" href="/managersystem/<?= $page; ?>/<?= $key["server_id"]; ?>/">
                          <span>
                            <?= $key["server_name"]; ?>
                          </span>
                        </a>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <?php if ($page === 'addvip' && empty($Core->GetCache('settings')['vip_one_table'])): ?>
              <div class="settings_buttons_card">
                <div class="w1366 scroll">
                  <div class="settings_buttons"><?php for ($b = 0, $_c = sizeof($res_vip); $b < $_c; $b++): ?><a class="settings_button <?php if (($res_vip[$b]['Name']) == ($res_vip[$server_group_vip]['Name'])) {
                                                                                                                                          echo 'active_button';
                                                                                                                                        } ?>"
                        href="<?php echo set_url_section(get_url(2), 'server_id_vip', $b) ?>"><span><?php echo $res_vip[$b]['Name'] ?></span></a><?php endfor; ?>
                  </div>
                </div>
              </div>
            <?php elseif ($page === 'addvip' && $Core->GetCache('settings')['vip_one_table'] == 1): ?>
              <div class="settings_buttons_card">
                <div class="w1366 scroll">
                  <div class="settings_buttons"><a class="settings_button <?php if ($sid == 'all')
                                                                            echo 'active_button'; ?>"
                      href="/managersystem/<?= $page; ?>/all/"><span><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') ?></span></a><?php foreach ($Core->GetCache('serversvip') as $key): ?><a
                        class="settings_button <?php if ($sid == $key["server_id"])
                                                                                                                                                                                echo 'active_button'; ?>"
                        href="/managersystem/<?= $page; ?>/<?= $key["server_id"]; ?>/"><span><?= $key["server_name"]; ?></span></a><?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <?php if ($page === 'onlineadmins'): ?>
              <div class="settings_buttons_card">
                <div class="w1366 scroll">
                  <div class="settings_buttons"><a class="settings_button <?php if ($SRV_ID == 'all')
                                                                            echo 'active_button'; ?>"
                      href="/managersystem/<?= $page; ?>/all/"><span><?= $Translate->get_translate_module_phrase('module_page_managersystem', '_MSAllServers') ?></span></a><?php foreach ($ARServer as $key): ?><a
                        class="settings_button <?php if ($SRV_ID == $key["SRV_ID"])
                                                                                                                                                                                echo 'active_button'; ?>"
                        href="/managersystem/<?= $page; ?>/<?= $key["SRV_ID"]; ?>/"><span><?= $key["srvname"]; ?></span></a><?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <?php require MODULES . "module_page_managersystem/pages/{$page}.php"; ?>
          </div>
        </div>
<?php endif;
    endforeach;
  endif;
endif; ?>
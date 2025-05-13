<?php
!isset($_SESSION['user_admin']) && get_iframe('013', 'Доступ закрыт') ?>
<div class="row">
    <div class="col-md-12">
        <div class="admin_nav">
            <button class="fill_width secondary_btn <?php get_section('section', 'general') == 'general' && print 'active_btn_adm' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'general') ?>'">
                <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                    <g>
                        <path d="M29.21 11.84a3.92 3.92 0 0 1-3.09-5.3 1.84 1.84 0 0 0-.55-2.07 14.75 14.75 0 0 0-4.4-2.55 1.85 1.85 0 0 0-2.09.58 3.91 3.91 0 0 1-6.16 0 1.85 1.85 0 0 0-2.09-.58 14.82 14.82 0 0 0-4.1 2.3 1.86 1.86 0 0 0-.58 2.13 3.9 3.9 0 0 1-3.25 5.36 1.85 1.85 0 0 0-1.62 1.49A14.14 14.14 0 0 0 1 16a14.32 14.32 0 0 0 .19 2.35 1.85 1.85 0 0 0 1.63 1.55A3.9 3.9 0 0 1 6 25.41a1.82 1.82 0 0 0 .51 2.18 14.86 14.86 0 0 0 4.36 2.51 2 2 0 0 0 .63.11 1.84 1.84 0 0 0 1.5-.78 3.87 3.87 0 0 1 3.2-1.68 3.92 3.92 0 0 1 3.14 1.58 1.84 1.84 0 0 0 2.16.61 15 15 0 0 0 4-2.39 1.85 1.85 0 0 0 .54-2.11 3.9 3.9 0 0 1 3.13-5.39 1.85 1.85 0 0 0 1.57-1.52A14.5 14.5 0 0 0 31 16a14.35 14.35 0 0 0-.25-2.67 1.83 1.83 0 0 0-1.54-1.49zM21 16a5 5 0 1 1-5-5 5 5 0 0 1 5 5z"></path>
                    </g>
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_General_settings') ?>
            </button>
            <button class="fill_width secondary_btn <?php get_section('section', 'general') == 'template' && print 'active_btn_adm' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'template') ?>'">
                <svg x="0" y="0" viewBox="0 0 384 384" xml:space="preserve">
                    <g>
                        <path d="M192 0C85.973 0 0 85.973 0 192s85.973 192 192 192c17.707 0 32-14.293 32-32 0-8.32-3.093-15.787-8.32-21.44-5.013-5.653-8-13.013-8-21.227 0-17.707 14.293-32 32-32h37.653c58.88 0 106.667-47.787 106.667-106.667C384 76.373 298.027 0 192 0zM74.667 192c-17.707 0-32-14.293-32-32s14.293-32 32-32 32 14.293 32 32-14.294 32-32 32zm64-85.333c-17.707 0-32-14.293-32-32s14.293-32 32-32 32 14.293 32 32-14.294 32-32 32zm106.666 0c-17.707 0-32-14.293-32-32s14.293-32 32-32 32 14.293 32 32-14.293 32-32 32zm64 85.333c-17.707 0-32-14.293-32-32s14.293-32 32-32 32 14.293 32 32-14.293 32-32 32z"></path>
                    </g>
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Template_settings') ?>
            </button>
            <button class="fill_width secondary_btn <?php get_section('section', 'general') == 'modules' && print 'active_btn_adm' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'modules') ?>'">
                <svg viewBox="0 0 512 512">
                    <path d="M256 248C233.9 248 216 265.9 216 288s17.91 40 40 40S296 310.1 296 288S278.1 248 256 248zM464 96h-192l-64-64h-160C21.5 32 0 53.5 0 80v352C0 458.5 21.5 480 48 480h416c26.5 0 48-21.5 48-48v-288C512 117.5 490.5 96 464 96zM366.9 352c-4.457 7.719-9.781 14.55-15.56 20.86c-2.506 2.738-6.633 3.281-9.846 1.422l-23.46-13.54C309.2 368.3 299.1 374.2 288 378.1v27.02c0 3.711-2.531 7.016-6.154 7.812C273.5 414.8 264.9 416 256 416c-8.912 0-17.49-1.195-25.84-3.047C226.5 412.2 224 408.9 224 405.1v-27.02c-11.12-3.957-21.19-9.867-29.99-17.38L170.6 374.3c-3.215 1.859-7.34 1.316-9.848-1.422C154.9 366.6 149.6 359.7 145.1 352c-4.455-7.719-7.709-15.75-10.29-23.91C133.7 324.6 135.3 320.7 138.6 318.9l23.21-13.4C160.7 299.8 160 293.1 160 288s.7129-11.78 1.76-17.46L138.6 257.1C135.3 255.3 133.7 251.4 134.9 247.9C137.4 239.7 140.7 231.7 145.1 224c4.457-7.719 9.783-14.55 15.56-20.86C163.2 200.4 167.3 199.9 170.6 201.7l23.45 13.54C202.8 207.7 212.9 201.8 224 197.9V170.9c0-3.711 2.531-7.016 6.156-7.816C238.5 161.2 247.1 160 256 160c8.914 0 17.49 1.195 25.85 3.043C285.5 163.8 288 167.1 288 170.9v27.02c11.12 3.957 21.19 9.867 29.99 17.38l23.46-13.54c3.213-1.859 7.34-1.316 9.846 1.422C357.1 209.4 362.4 216.3 366.9 224s7.711 15.75 10.29 23.91c1.119 3.539-.4766 7.383-3.689 9.234l-23.21 13.4C351.3 276.2 352 282 352 288s-.7129 11.78-1.76 17.46l23.21 13.4c3.213 1.852 4.809 5.695 3.691 9.234C374.6 336.3 371.3 344.3 366.9 352z" />
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Configuring_modules') ?>
            </button>
            <button class="fill_width secondary_btn <?php get_section('section', 'general') == 'servers' && print 'active_btn_adm' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'servers') ?>'">
                <svg viewBox="0 0 512 512">
                    <path d="M64 32C28.7 32 0 60.7 0 96v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM344 152c-13.3 0-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24zm96-24c0 13.3-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24zM64 288c-35.3 0-64 28.7-64 64v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V352c0-35.3-28.7-64-64-64H64zM344 408c-13.3 0-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24zm104-24c0 13.3-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24z" />
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Server_setting') ?>
            </button>
            <button class="fill_width secondary_btn <?php get_section('section', 'general') == 'db' && print 'active_btn_adm' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'db') ?>'">
                <svg x="0" y="0" viewBox="0 0 32 32" xml:space="preserve">
                    <g>
                        <ellipse cx="14" cy="8" rx="10" ry="5" style="stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="1"></ellipse>
                        <ellipse cx="14" cy="8" rx="11" ry="6"></ellipse>
                        <path d="M14 24c-4.8 0-8.8-1.4-11-3.6V24c0 3.4 4.8 6 11 6 .9 0 1.8-.1 2.7-.2-1.5-1.5-2.4-3.6-2.7-5.8zM3 12.4V16c0 3.4 4.8 6 11 6h.1c.2-2.4 1.4-4.6 3-6.2-1 .1-2 .2-3.1.2-4.8 0-8.8-1.4-11-3.6zM31.7 20.9c-.1-.5-.7-.8-1.2-.7-.7.2-1.2 0-1.3-.2s0-.7.5-1.3c.4-.4.4-1 0-1.4-1-1-2.2-1.7-3.6-2.1-.5-.1-1.1.2-1.2.7-.2.7-.6 1-.9 1s-.6-.4-.9-1c-.2-.5-.7-.8-1.2-.7-1.4.4-2.6 1.1-3.6 2.1-.4.4-.4 1 0 1.4.5.5.6 1 .5 1.3-.1.2-.6.4-1.3.2-.5-.1-1.1.2-1.2.7-.2.7-.3 1.4-.3 2.1s.1 1.4.3 2.1c.1.5.7.8 1.2.7.7-.2 1.2 0 1.3.2s0 .7-.5 1.3c-.4.4-.4 1 0 1.4 1 1 2.2 1.7 3.6 2.1.5.1 1.1-.2 1.2-.7.2-.7.6-1 .9-1s.6.4.9 1c.1.4.5.7 1 .7h.3c1.4-.4 2.6-1.1 3.6-2.1.4-.4.4-1 0-1.4-.5-.5-.6-1-.5-1.3.1-.2.6-.4 1.3-.2.5.1 1.1-.2 1.2-.7.2-.7.3-1.4.3-2.1s-.2-1.4-.4-2.1zM24 26c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"></path>
                    </g>
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Database_settings') ?>
            </button>
            <button class="fill_width secondary_btn <?php get_section('section', 'general') == 'stats' && print 'active_btn_adm' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'stats') ?>'">
                <svg x="0" y="0" viewBox="0 0 480 480" xml:space="preserve">
                    <g>
                        <path d="M316.1 150.7h-238c-26.5 0-48.1-21.5-48.1-48.1 0-26.5 21.5-48.1 48.1-48.1h238c26.5 0 48.1 21.5 48.1 48.1s-21.6 48.1-48.1 48.1zM401.9 288.1H78.1C51.5 288.1 30 266.5 30 240s21.5-48.1 48.1-48.1H402c26.5 0 48.1 21.5 48.1 48.1-.1 26.5-21.6 48.1-48.2 48.1zM182.8 425.4H78.1c-26.5 0-48.1-21.5-48.1-48.1 0-26.5 21.5-48.1 48.1-48.1h104.8c26.5 0 48.1 21.5 48.1 48.1-.1 26.6-21.6 48.1-48.2 48.1z"></path>
                    </g>
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Site_stats') ?>
            </button>
            <button class="fill_width secondary_btn <?php echo (get_section('section', 'general') == 'logsweb' || get_section('section', 'general') == 'logslk' || get_section('section', 'general') == 'logsshop') ? 'active_btn_adm' : '' ?>" onclick="location.href = '<?= set_url_section(get_url(2), 'section', 'logsweb') ?>'">
                <svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
                    <g>
                        <g data-name="Layer 2">
                            <g data-name="Document File Format">
                                <path d="M456 147v73H56V25A25 25 0 0 1 81 0h228v127a20 20 0 0 0 20 20zM56 460h400v27a25 25 0 0 1-25 25H81a25 25 0 0 1-25-25z"></path>
                                <path d="M456 126.96H329.04V0zM252.09 300.48a11.84 11.84 0 0 0-2.89-6c-1.47-1.59-3.8-2.38-7-2.38q-4.42 0-6.63 2.38a11.84 11.84 0 0 0-2.89 6 42.44 42.44 0 0 0-.68 7.73v66.3a48.16 48.16 0 0 0 .6 7.65 11.66 11.66 0 0 0 2.72 6.12c1.41 1.59 3.71 2.38 6.88 2.38s5.5-.79 7-2.38a11.91 11.91 0 0 0 2.89-6.12 42.93 42.93 0 0 0 .68-7.65v-66.3a42.44 42.44 0 0 0-.68-7.73zm0 0a11.84 11.84 0 0 0-2.89-6c-1.47-1.59-3.8-2.38-7-2.38q-4.42 0-6.63 2.38a11.84 11.84 0 0 0-2.89 6 42.44 42.44 0 0 0-.68 7.73v66.3a48.16 48.16 0 0 0 .6 7.65 11.66 11.66 0 0 0 2.72 6.12c1.41 1.59 3.71 2.38 6.88 2.38s5.5-.79 7-2.38a11.91 11.91 0 0 0 2.89-6.12 42.93 42.93 0 0 0 .68-7.65v-66.3a42.44 42.44 0 0 0-.68-7.73zM487 240H25a25 25 0 0 0-25 25v150a25 25 0 0 0 25 25h462a25 25 0 0 0 25-25V265a25 25 0 0 0-25-25zM191.74 410.21h-62.05v-137.7h30.43v117.13h31.62zm92.14-43.35q0 14.11-3.91 24.31a30.34 30.34 0 0 1-13 15.64q-9.11 5.44-24.74 5.44-15.47 0-24.48-5.44a30.43 30.43 0 0 1-12.92-15.64q-3.92-10.2-3.91-24.31v-51.17q0-14.28 3.91-24.31A30 30 0 0 1 217.75 276q9-5.36 24.48-5.36 15.65 0 24.74 5.36a30 30 0 0 1 13 15.38q3.91 10 3.91 24.31zm98.43 43.35h-20.06l-1.7-11.39a24.75 24.75 0 0 1-8 9.61q-5.26 3.82-14.28 3.82-14.28 0-22.52-5.95A32.09 32.09 0 0 1 304 389.56a80.92 80.92 0 0 1-3.49-24.91v-46.24q0-14.62 3.74-25.33a31.36 31.36 0 0 1 12.84-16.57q9.09-5.86 24.73-5.87 15.3 0 24.06 5.1a28.77 28.77 0 0 1 12.49 14.11 54.77 54.77 0 0 1 3.74 21.08v8.84h-29.72v-11.22a52.85 52.85 0 0 0-.59-8.16 11.31 11.31 0 0 0-2.72-6q-2.13-2.3-6.89-2.3-4.94 0-7.14 2.64a12.9 12.9 0 0 0-2.8 6.54 53.83 53.83 0 0 0-.6 8.16v63.75a37.32 37.32 0 0 0 .94 8.59 13.09 13.09 0 0 0 3.4 6.46q2.46 2.46 7.05 2.46 4.75 0 7.31-2.55a13.92 13.92 0 0 0 3.57-6.63 35.64 35.64 0 0 0 1-8.67v-16.18h-12.39v-17.85h39.78zM249.2 294.44c-1.47-1.59-3.8-2.38-7-2.38q-4.42 0-6.63 2.38a11.84 11.84 0 0 0-2.89 6 42.44 42.44 0 0 0-.68 7.73v66.3a48.16 48.16 0 0 0 .6 7.65 11.66 11.66 0 0 0 2.72 6.12c1.41 1.59 3.71 2.38 6.88 2.38s5.5-.79 7-2.38a11.91 11.91 0 0 0 2.89-6.12 42.93 42.93 0 0 0 .68-7.65v-66.3a42.44 42.44 0 0 0-.68-7.73 11.84 11.84 0 0 0-2.89-6z"></path>
                            </g>
                        </g>
                    </g>
                </svg>
                <?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Site_logs') ?>
            </button>
        </div>
    </div>
</div>
<div class="row row_admins">
    <?php switch (get_section('section', 'general')) {
        case 'modules':
            require MODULES . 'module_page_adminpanel' . '/includes/modules.php';
            break;
        case 'servers':
            require MODULES . 'module_page_adminpanel' . '/includes/servers.php';
            break;
        case 'db':
            require MODULES . 'module_page_adminpanel' . '/includes/db.php';
            break;
        case 'template':
            require MODULES . 'module_page_adminpanel' . '/includes/template.php';
            break;
        case 'stats':
            require MODULES . 'module_page_adminpanel' . '/includes/stats.php';
            break;
        case 'logsweb':
            require MODULES . 'module_page_adminpanel' . '/includes/logsweb.php';
            break;
        case 'logslk':
            require MODULES . 'module_page_adminpanel' . '/includes/logslk.php';
            break;
        case 'logsshop':
            require MODULES . 'module_page_adminpanel' . '/includes/logsshop.php';
            break;
        case 'logsref':
            require MODULES . 'module_page_adminpanel' . '/includes/logsref.php';
            break;   
        default:
            require MODULES . 'module_page_adminpanel' . '/includes/general.php';
            break;
    } ?>
</div>
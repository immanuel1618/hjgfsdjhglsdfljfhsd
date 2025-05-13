<?php !isset($_SESSION['user_admin']) && get_iframe('013', 'Доступ закрыт') && die() ?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_General_settings') ?></h5>
        </div>
        <div class="card-container option_one">
            <form id="options_one" enctype="multipart/form-data" method="post">
                <div class="custom_flex_inputs">
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Full_name') ?></div><input name="full_name" value="<?php echo $General->arr_general['full_name'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Short_name') ?></div><input name="short_name" value="<?php echo $General->arr_general['short_name'] ?>">
                    </div>
                </div>
                <div class="custom_flex_inputs">
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Basic_information') ?></div><input name="info" value="<?php echo $General->arr_general['info'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Language') ?></div>
                        <select style="display: none;" class="custom-select" name="language" placeholder="<?php echo $Translate->get_translate_phrase('_' . $General->arr_general['language']) ?>">
                            <?php for ($i = 0; $i < $Translate->arr_languages_count; $i++) : ?>
                                <option value="<?php echo $Translate->arr_languages[$i] ?>"><?php echo $Translate->get_translate_phrase('_' . $Translate->arr_languages[$i]) ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                </div>
                <div class="custom_flex_inputs">
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Steam_web_api') ?></div><input name="web_key" type="password" value="<?php echo $General->arr_general['web_key'] ?>">
                    </div>
                    <div class="input-form">
                        <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Timecache_avatars') ?></div><input name="avatars_cache_time" value="<?php echo $General->arr_general['avatars_cache_time'] ?>">
                    </div>
                </div>
            </form>
            <input class='secondary_btn w100 mt10' name="option_one_save" type="submit" form="options_one" value="<?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Save') ?>">
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Extra_settingss') ?></h5>
        </div>
        <div class="card-container">
            <div class="template_version"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_TemplateVersion') ?>: <?= VERSION ?></div>
            <?php $palettes = $Modules->scan_templates; ?>
            <div style="display: flex; gap: 10px;">
                <div class="input-form">
                    <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Template') ?></div>
                    <select style="display: none;" class="custom-select" name="theme" onChange="set_options_data_select( getAttribute('name'), value )" placeholder="<?= $General->arr_general['theme'] ?>">
                        <?php foreach ($Modules->scan_templates as $key => $val) : ?>
                            <option value="<?php echo $val ?>"><?php echo $val ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-form">
                    <div class="input_text"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Template_rangs') ?></div>
                    <select style="display: none;" class="custom-select" name="rank_pack" onChange="set_options_data_select( getAttribute('name'), value )" placeholder="<?php if (empty($General->arr_general['rank_pack'])) { echo 'Выберите формат'; } else echo $General->arr_general['rank_pack']; ?>">
                        <option value="svg">SVG</option>
                        <option value="png">PNG</option>
                        <option value="webp">WEBP</option>
                    </select>
                </div>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="thoseworks" id="thoseworks" <?php $General->arr_general['thoseworks'] === 1 && print 'checked' ?>>
                <label class="border-checkbox-label" for="thoseworks"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_EnabletechWork') ?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="antivpn" id="antivpn" <?php $General->arr_general['antivpn'] === 1 && print 'checked' ?>>
                <label class="border-checkbox-label" for="antivpn">Anti-VPN</label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="css_off_cache" id="css_off_cache" <?php $General->arr_general['css_off_cache'] === 1 && print 'checked' ?>>
                <label class="border-checkbox-label" for="css_off_cache"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Css_off_cache') ?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="session_check" id="session_check" <?php $General->arr_general['session_check'] === 1 && print 'checked' ?>>
                <label class="border-checkbox-label" for="session_check"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Session_check') ?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'css')" class="border-checkbox" type="checkbox" name="auth_cock" id="auth_cock" <?php $General->arr_general['auth_cock'] === 1 && print 'checked' ?>>
                <label class="border-checkbox-label" for="auth_cock"><?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Cockie') ?></label>
            </div>
        </div>
    </div>
</div>
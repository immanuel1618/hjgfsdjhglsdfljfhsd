<?php

/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_adminpanel\ext;

use mysqli;

class Admin
{
    function __construct($General, $Modules, $Db, $Translate)
    {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        // Ведущая проверка.
        (empty($_SESSION['steamid32']) || !isset($_SESSION['user_admin'])) && get_iframe('013', 'Доступ закрыт') && die();

        $this->General = $General;

        $this->Modules = $Modules;

        $this->Db = $Db;

        $this->Translate = $Translate;
    }

    //Позволяет обновить страницу без проблем с кавычками
    function ReloadPage()
    {
        header("Location: ?" . $_SERVER['QUERY_STRING']);
    }

    //Немного видоизмененная функция взятая с $Modules, для получения списка модулей.
    public function GetArrModules()
    {
        $result = [];

        // Сканирование папки с модулями.
        $modules_list = array_diff(scandir(MODULES, 1), array('..', '.', 'disabled'));

        // Подсчёт количества модулей.
        $modules_count = sizeof($modules_list);

        if ($modules_count != 0) {
            // Цикл перебора описания модулей.
            for ($i = 0; $i < $modules_count; $i++) {
                // Получение описания определенного модуля.
                $result[$modules_list[$i]] = json_decode(file_get_contents(MODULES . $modules_list[$i] . '/description.json'), true);
            }
        }
        return $result;
    }

    function arr_k_last($array)
    {
        if (!is_array($array) || empty($array)) {
            return NULL;
        }

        return array_keys($array)[count($array) - 1];
    }

    /**
     * Очистить порядок загрузки модулей.
     */
    function action_clear_modules_initialization()
    {
        //Получение всех модулей, и их кол-во
        $array_modules = $this->GetArrModules();
        $count_modules = sizeof($array_modules);

        //Итоговый цикл по всем модулям
        for ($i = 0; $i < $count_modules; $i++):
            $module = array_keys($array_modules)[$i];
            if ($array_modules[$module]['setting']['status'] == 1 && $array_modules[$module]['page'] != 'all'):
                if (!empty($array_modules[$module]['setting']['interface']) && $array_modules[$module]['setting']['interface'] == 1):
                    $result['page'][$array_modules[$module]['page']]['interface'][empty($array_modules[$module]['setting']['interface_adjacent']) ? 'afternavbar' : $array_modules[$module]['setting']['interface_adjacent']][] = $module;
                endif;
                if (!empty($array_modules[$module]['setting']['interface_always']) && $array_modules[$module]['setting']['interface_always'] == 1):
                    $result['interface_always'][empty($array_modules[$module]['setting']['interface_always_adjacent']) ? 'afternavbar' : $array_modules[$module]['setting']['interface_always_adjacent']][] = ['name' => $module];
                endif;
                !empty($array_modules[$module]['setting']['data']) && $array_modules[$module]['setting']['data'] == 1 && $result['page'][$array_modules[$module]['page']]['data'][] = $module;
                !empty($array_modules[$module]['setting']['data_always']) && $array_modules[$module]['setting']['data_always'] == 1 && $result['data_always'][] = $module;
                !empty($array_modules[$module]['setting']['js']) && $array_modules[$module]['setting']['js'] == 1 && $result['page'][$array_modules[$module]['page']]['js'][] = ['name' => $module, 'type' => $array_modules[$module]['setting']['type']];
                !empty($array_modules[$module]['setting']['css']) && $array_modules[$module]['setting']['css'] == 1 && $result['page'][$array_modules[$module]['page']]['css'][] = ['name' => $module, 'type' => $array_modules[$module]['setting']['type']];
                !empty($array_modules[$module]['sidebar']) && $result['sidebar'][] = $module;
            endif;
        endfor;

        if (file_exists(SESSIONS . 'modules_initialization.php')) {
            $cache = require SESSIONS . 'modules_initialization.php';

            foreach ($result['page']['home']['interface']['afternavbar'] as $key => $val) {
                $search = array_search($val, $cache['page']['home']['interface']['afternavbar']);
                if ($cache['page']['home']['interface']['afternavbar'][$search] == $val)
                    $restwo[$search] = $val;
                else
                    $restwo[$this->arr_k_last($result['page']['home']['interface']['afternavbar'])] = $val;
            }

            ksort($restwo);

            $result['page']['home']['interface']['afternavbar'] = array_values($restwo);
        }

        file_put_contents(SESSIONS . 'modules_initialization.php', '<?php return ' . var_export_min($result, true) . ";");

        $cache_files = [
            'modules_cache' => SESSIONS . 'modules_cache.php',
            'translator_cache' => SESSIONS . 'translator_cache.php',
        ];

        // Очищаем кэш каждого модуля.
        for ($i = 0; $i < $this->Modules->array_modules_count; $i++):
            $module = array_keys($this->Modules->array_modules)[$i];

            // При существовании файла кэша, удалить его.
            file_exists(MODULES . $module . '/temp/cache.php') && unlink(MODULES . $module . '/temp/cache.php');
        endfor;

        // Удаляем файл с описанием каждого модуля.
        file_exists($cache_files['modules_cache']) && unlink($cache_files['modules_cache']);

        // Удаляем файл с переводами.
        file_exists($cache_files['translator_cache']) && unlink($cache_files['translator_cache']);

        // Удаляем файл с переводами.
        file_exists(MODULES . 'module_page_adminpanel/temp/stats.php') && unlink(MODULES . 'module_page_adminpanel/temp/stats.php');

        return ['status' => 'success', 'text' => 'Вы успешно очистили кэш!'];
    }

    /**
     * Редактирования порядка загрузки модулей.
     */
    function edit_modules_initialization()
    {
        $array = $this->Modules->arr_module_init;

        $data = json_decode($_POST['data'], true);

        for ($i2 = 0, $c = sizeof($data); $i2 < $c; $i2++) {
            $_data[] = $data[$i2]['id'];
        }

        get_section('module_page', 'home') == 'sidebar' ? $array['sidebar'] = $_data : $array['page'][get_section('module_page', 'home')]['interface'][get_section('module_interface_adjacent', 'afternavbar')] = $_data;

        file_put_contents(SESSIONS . 'modules_initialization.php', '<?php return ' . var_export_min($array, true) . ";");
    }

    function edit_options()
    {

        $arr = $this->General->arr_general;

        $option = [
            'full_name' => $_POST['full_name'],
            'short_name' => $_POST['short_name'],
            'info' => $_POST['info'],
            'language' => $_POST['language'],
            'web_key' => $_POST['web_key'],
            'avatars_cache_time' => (int) $_POST['avatars_cache_time']
        ];

        // Обновление файла.
        file_put_contents(SESSIONS . 'options.php', '<?php return ' . var_export_min(array_replace($arr, $option), true) . ";");

        return ['status' => 'success', 'text' => 'Данные сохранены!'];
    }

    /**
     * Изменение параметров в '/storage/cache/sessions/options.php'.
     */
    function action_db_add_mods()
    {

        $db = require SESSIONS . '/db.php';

        $db += [$_POST['mod'] => []];
        // Обновление файла.
        file_put_contents(SESSIONS . 'db.php', '<?php return ' . var_export_opt($db, true) . ";");

        // Обновление страницы.
        $this->ReloadPage();
    }

    function EditServer($post)
    {
        $db = require SESSIONS . '/db.php';
        $edit_info = explode(";", $post['mod_info_edit']);
        $db[$edit_info[0]][$edit_info[1]]['HOST'] = $post['host_edit'];
        $db[$edit_info[0]][$edit_info[1]]['PORT'] = $post['port_edit'] ?? '3306';
        $db[$edit_info[0]][$edit_info[1]]['USER'] = $post['username_edit'];
        $db[$edit_info[0]][$edit_info[1]]['PASS'] = $post['password_edit'];
        $db[$edit_info[0]][$edit_info[1]]['DB'][$edit_info[2]]['DB'] = $post['db_name_edit'];
        $db[$edit_info[0]][$edit_info[1]]['DB'][$edit_info[2]]['Prefix'][$edit_info[3]]['table'] = $post['table_name_edit'] ?? '';
        if (isset($db[$edit_info[0]][$edit_info[1]]['DB'][$edit_info[2]]['Prefix'][$edit_info[3]]['ranks_pack'])) {
            $db[$edit_info[0]][$edit_info[1]]['DB'][$edit_info[2]]['Prefix'][$edit_info[3]]['ranks_pack'] = $post['rank_pack_edit'];
        }
        $db[$edit_info[0]][$edit_info[1]]['DB'][$edit_info[2]]['Prefix'][$edit_info[3]]['name'] = $post['server_name_edit'] ?? '';
        // Обновление файла.
        file_put_contents(SESSIONS . 'db.php', '<?php return ' . var_export_opt($db, true) . ";");
        return ['status' => 'success', 'text' => 'Данные изменены!'];
    }

    function action_db_add_connection()
    {
        $db = require SESSIONS . '/db.php';
        if ($_POST['function'] == 'add_conection') {
            $mod = $_POST['mod'];
            if (empty($_POST['host']))
                return exit(json_encode(['error' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_error_host')]));
            else
                $host = $_POST['host'];
            if (empty($_POST['db_name']))
                return exit(json_encode(['error' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_error_db')]));
            else
                $db_name = $_POST['db_name'];
            if (empty($_POST['password']))
                return exit(json_encode(['error' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_error_password')]));
            else
                $password = $_POST['password'];
            if (empty($_POST['username']))
                return exit(json_encode(['error' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_error_username')]));
            else
                $username = $_POST['username'];
            if (empty($_POST['port']))
                return exit(json_encode(['error' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_error_port')]));
            else
                $port = $_POST['port'];
            if (empty($_POST['table_name']))
                return exit(json_encode(['error' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_error_name_table')]));
            else
                $table_name = $_POST['table_name'];
            $server_name = empty($_POST['server_name']) ? '' : $_POST['server_name'];
            $steam_mod = 1;
            $game_mod = 730;
            if ($mod == 'LevelsRanks' && empty($_POST['rank_pack'])) {
                return exit(json_encode(['error' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_error_rank_pack')]));
            } else
                $rank_pack = $_POST['rank_pack'];

            $query = ['HOST' => $host, 'PORT' => $port, 'USER' => $username, 'PASS' => $password, 'DB' => [0 => ['DB' => $db_name, 'Prefix' => [0 => ['table' => $table_name, 'name' => $server_name, 'mod' => $game_mod, 'steam' => $steam_mod]]]]];
            if ($mod == 'LevelsRanks') {
                $query['DB'][0]['Prefix'][0]['ranks_pack'] = $rank_pack;
            }

            $mysqli = new mysqli($host, $username, $password, $db_name, $port);

            if ($mysqli->connect_error)
                return exit(json_encode(['error' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_error_con_db')]));

            $mysqli->close();

            if (empty($db[$mod])) {
                $db[$mod] = [0 => $query];
                file_put_contents(SESSIONS . 'db.php', '<?php return ' . var_export_opt($db, true) . ";");
                return exit(json_encode(['success' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_success_mod_created')]));
            } else {
                $db[$mod][] = $query;
                file_put_contents(SESSIONS . 'db.php', '<?php return ' . var_export_opt($db, true) . ";");
                return exit(json_encode(['success' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_success_db_created')]));
            }
        }

        if ($_POST['function'] == 'delete') {
            if (!empty($_POST['table'])) {
                $db_info = explode(";", $_POST['table']);
                if (!empty($db[$db_info[0]])) {
                    if (count($db[$db_info[0]]) == 1) {
                        if (count($db[$db_info[0]][$db_info[1]]['DB']) == 1) {
                            unset($db[$db_info[0]]);
                        } else {
                            unset($db[$db_info[0]][$db_info[1]]['DB'][$db_info[2]]);
                        }
                    } else {
                        unset($db[$db_info[0]][$db_info[1]]);
                    }
                }
                unset($db[$_POST['table']]);
                file_put_contents(SESSIONS . 'db.php', '<?php return ' . var_export_opt($db, true) . ";");
                return;
            }
        }
        return exit(json_encode(['error' => $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_error_not_found')]));
    }

    /**
     * Добавление сервера
     */
    function action_get_server($id)
    {
        if (!preg_match('/^[0-9]{1,3}$/', $id))
            return;
        $params = ['id' => $id];
        $server = $this->Db->query('Core', 0, 0, "SELECT * FROM lvl_web_servers WHERE id = :id", $params);
        return $server;
    }
    function action_add_server()
    {
        $ip_port_array = explode(':', $_POST['server_ip_port']);
        $url = "https://ipinfo.io/{$ip_port_array[0]}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        $city = $data['city'] ?? '';
        $country = $data['country'] ?? '';

        $params = [
            'server_ip_port' => $_POST['server_ip_port'] ?? 0,
            'server_ip_port_fake' => $_POST['server_ip_port_fake'] ?? 0,
            'server_name' => $_POST['server_name'] ?? 0,
            'server_name_custom' => $_POST['server_name_custom'] ?? 0,
            'server_rcon' => $_POST['server_rcon'] ?? 0,
            'server_stats' => $_POST['server_stats'] ?? 0,
            'server_vip' => $_POST['server_vip'] ?? 0,
            'server_vip_id' => $_POST['server_vip_id'] ?? 0,
            'server_sb' => $_POST['server_sb'] ?? 0,
            'server_sb_id' => $_POST['server_sb_id'] ?? 0,
            'server_shop' => $_POST['server_shop'] ?? 0,
            'server_lk' => $_POST['server_lk'] ?? 0,
            'server_mod' => $_POST['server_mod'],
            'server_country' => $country,
            'server_city' => $city,
            'server_bage' => $_POST['server_bage']
        ];

        $this->Db->query('Core', 0, 0, "INSERT INTO `lvl_web_servers` VALUES (NULL,
                                                              :server_ip_port,
                                                              :server_ip_port_fake,
                                                              :server_name,
                                                              :server_name_custom,
                                                              :server_rcon,
                                                              :server_stats,
                                                              :server_vip,
                                                              :server_vip_id,
                                                              :server_sb,
                                                              :server_sb_id,
                                                              :server_shop,
                                                              :server_lk, :server_mod, :server_country, :server_city, :server_bage);", $params);

        // Обновление страницы.
        $this->ReloadPage();
    }

    /**
     * Добавление сервера
     */
    function action_edit_server()
    {
        $ip_port_array = explode(':', $_POST['server_ip_port_edit']);
        $url = "https://ipinfo.io/{$ip_port_array[0]}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        $city = $data['city'] ?? '';
        $country = $data['country'] ?? '';

        $params = [
            'server_id' => $_POST['server_id_edit'] ?? 0,
            'server_ip_port' => $_POST['server_ip_port_edit'] ?? 0,
            'server_ip_port_fake' => $_POST['server_ip_port_fake_edit'] ?? 0,
            'server_name' => $_POST['server_name_edit'] ?? 0,
            'server_name_custom' => $_POST['server_name_custom_edit'] ?? 0,
            'server_rcon' => $_POST['server_rcon_edit'] ?? 0,
            'server_stats' => $_POST['server_stats_edit'] ?? 0,
            'server_vip' => $_POST['server_vip_edit'] ?? 0,
            'server_vip_id' => $_POST['server_vip_id_edit'] ?? 0,
            'server_sb' => $_POST['server_sb_edit'] ?? 0,
            'server_sb_id' => $_POST['server_sb_id_edit'] ?? 0,
            'server_shop' => $_POST['server_shop_edit'] ?? 0,
            'server_lk' => $_POST['server_lk_edit'] ?? 0,
            'server_mod' => $_POST['server_mod_edit'],
            'server_country' => $country,
            'server_city' => $city,
            'server_bage' => $_POST['server_bage_edit']
        ];

        $this->Db->query('Core', 0, 0, "UPDATE lvl_web_servers SET `ip` = :server_ip_port,
                                                                    `fakeip` = :server_ip_port_fake,
                                                                    `name` = :server_name,
                                                                    `name_custom` = :server_name_custom,
                                                                    `rcon` = :server_rcon,
                                                                    `server_stats` = :server_stats,
                                                                    `server_vip` = :server_vip,
                                                                    `server_vip_id` = :server_vip_id,
                                                                    `server_sb` = :server_sb,
                                                                    `server_sb_id` = :server_sb_id,
                                                                    `server_shop` = :server_shop,
                                                                    `server_lk` = :server_lk,
                                                                    `server_mod` = :server_mod,
                                                                    `server_country` = :server_country,
                                                                    `server_city` = :server_city,
                                                                    `server_bage` = :server_bage
                                                                    WHERE `id` = :server_id", $params);

        // Обновление страницы.
        $this->ReloadPage();
    }

    /**
     * Удаление сервера
     */
    function action_del_server()
    {
        $params = ['id' => $_POST['del_server']];

        $this->Db->query('Core', 0, 0, 'DELETE FROM `lvl_web_servers` WHERE `id` = :id', $params);
    }

    public function info_modules_settings($id)
    {
        $settings = $this->Modules->get_settings_modules('module_block_main_banner_slider', 'settings');

        foreach ($settings['slides'] as $key_id => $key) {
            if (isset($id) && $id == $key_id) {
                return $key;
            }
        }
        return null;
    }

    /**
     * Редактирование параметров определенного модуля.
     */
    function edit_module($POST, $GET, $FILES)
    {
        if ($GET['options'] == 'module_block_main_banner_slider' && (!isset($GET['baner_edit']) || $GET['baner_edit'] === '')) {
            chmod(MODULES . 'module_block_main_banner_slider/settings.php', 0777);
            if (isset($FILES['file']) && $FILES['file']['error'] == UPLOAD_ERR_OK) {
                if (exif_imagetype($FILES['file']['tmp_name']) !== false) {
                    $extension = pathinfo($FILES['file']['name'], PATHINFO_EXTENSION);
                    $newFileName = uniqid() . '.' . $extension;
                    if (move_uploaded_file($FILES['file']['tmp_name'], MODULES . 'module_block_main_banner_slider/assets/img/' . $newFileName)) {
                        $newSlide = [
                            'img' => $newFileName,
                            'title' => $POST['title'],
                            'description' => $POST['description'],
                            'button_text' => $POST['button_text'],
                            'button_url' => $POST['button_url']
                        ];
                        $settings = $this->Modules->get_settings_modules($GET['options'], 'settings');
                        $settings['slides'][] = $newSlide;
                        $this->Modules->put_settings_modules($GET['options'], 'settings', $settings);
                        return ['status' => 'success', 'text' => 'Новый слайд создан!'];
                    } else {
                        return ['status' => 'error', 'text' => 'Произошла ошибка при перемещении файла в папку'];
                    }
                } else {
                    return ['status' => 'error', 'text' => 'Выбранный файл не является изображением'];
                }
            } else {
                return ['status' => 'error', 'text' => 'Произошла ошибка при загрузке файла'];
            }
        }
        if ($GET['options'] == 'module_block_main_banner_slider' && (isset($GET['baner_edit']) || $GET['baner_edit'] !== '')) {
            chmod(MODULES . 'module_block_main_banner_slider/settings.php', 0777);
            if (!empty($FILES['file']['name'])) {
                if (isset($FILES['file']) && $FILES['file']['error'] == UPLOAD_ERR_OK) {
                    if (exif_imagetype($FILES['file']['tmp_name']) !== false) {
                        $extension = pathinfo($FILES['file']['name'], PATHINFO_EXTENSION);
                        $newFileName = uniqid() . '.' . $extension;
                        if (move_uploaded_file($FILES['file']['tmp_name'], MODULES . 'module_block_main_banner_slider/assets/img/' . $newFileName)) {
                            $settings = $this->Modules->get_settings_modules($GET['options'], 'settings');
                            foreach ($settings['slides'] as $id => $key) {
                                if ($id == $GET['baner_edit']) {
                                    $EditSlide = [
                                        'img' => $newFileName,
                                        'title' => $POST['title'],
                                        'description' => $POST['description'],
                                        'button_text' => $POST['button_text'],
                                        'button_url' => $POST['button_url']
                                    ];
                                    $settings['slides'][$id] = $EditSlide;
                                }
                            }
                            $this->Modules->put_settings_modules($GET['options'], 'settings', $settings);
                            return ['status' => 'success', 'text' => 'Слайд отредактирован!'];
                        } else {
                            return ['status' => 'error', 'text' => 'Произошла ошибка при перемещении файла в папку'];
                        }
                    } else {
                        return ['status' => 'error', 'text' => 'Выбранный файл не является изображением'];
                    }
                } else {
                    return ['status' => 'error', 'text' => 'Произошла ошибка при загрузке файла'];
                }
            } else {
                chmod(MODULES . 'module_block_main_banner_slider/settings.php', 0777);
                $settings = $this->Modules->get_settings_modules($GET['options'], 'settings');
                foreach ($settings['slides'] as $id => $key) {
                    if ($id == $GET['baner_edit']) {
                        $EditSlide = [
                            'img' => $key['img'],
                            'title' => $POST['title'],
                            'description' => $POST['description'],
                            'button_text' => $POST['button_text'],
                            'button_url' => $POST['button_url']
                        ];
                        $settings['slides'][$id] = $EditSlide;
                    }
                }
                $this->Modules->put_settings_modules($GET['options'], 'settings', $settings);
                return ['status' => 'success', 'text' => 'Слайд отредактирован!'];
            }
        }
        if ($GET['options'] == 'module_page_profiles') {
            chmod(MODULES . 'module_page_profiles/settings.php', 0777);
            $options = $this->Modules->get_settings_modules($GET['options'], 'settings');

            $options['faceit_api_key'] = $POST['faceit_api_key'];
            $options['use_all_vips_servers_in_one_table'] = $POST['use_all_vips_servers_in_one_table'] == 'on' ? 1 : 0;
            $options['punishment_all_servers'] = $POST['punishment_all_servers'] == 'on' ? 1 : 0;

            $this->Modules->put_settings_modules($GET['options'], 'settings', $options);
            return ['status' => 'success', 'text' => 'Настройки сохранены!'];
        }
        if ($GET['options'] == 'module_page_punishment') {
            chmod(MODULES . 'module_page_punishment/settings.php', 0777);
            $options = $this->Modules->get_settings_modules($GET['options'], 'settings');

            $options['iks_db_new'] = $POST['iks_db_new'];
            $options['punishment_all_servers'] = $POST['punishment_all_servers'] == 'on' ? 1 : 0;
            $options['func_unban'] = $POST['func_unban'] == 'on' ? 1 : 0;
            $options['price_unban'] = $POST['price_unban'];
            $options['func_unmute'] = $POST['func_unmute'] == 'on' ? 1 : 0;
            $options['price_unmute'] = $POST['price_unmute'];

            $this->Modules->put_settings_modules($GET['options'], 'settings', $options);
            return ['status' => 'success', 'text' => 'Настройки сохранены!'];
        }
        if ($GET['options'] == 'module_page_leaderboard') {
            for ($d = 0; $d < $this->Db->table_count['LevelsRanks']; $d++) {
                $this->Db->queryAll('LevelsRanks', $this->Db->db_data['LevelsRanks'][$d]['USER_ID'], $this->Db->db_data['LevelsRanks'][$d]['DB_num'], "UPDATE " . $this->Db->db_data['LevelsRanks'][$d]['Table'] . " SET `value` = 0, `rank` = 0, `kills` = 0, `deaths` = 0, `shoots` = 0, `hits` = 0, `headshots` = 0, `assists` = 0, `round_win` = 0, `round_lose` = 0");
            }
            return ['status' => 'success', 'text' => 'Статистика очищена!'];
        }
    }

    function edit_module_core($POST, $GET)
    {
        $Module_data = $this->Modules->array_modules[$GET['options']];
        $Module_data['setting']['type'] = (int) $POST['module_type'] ?? 0;
        file_put_contents(MODULES . $GET['options'] . '/description.json', json_encode($Module_data, JSON_UNESCAPED_UNICODE));
        $modules_init = $this->Modules->arr_module_init;
        if (!empty($Module_data['sidebar']) && !in_array($GET['options'], $modules_init['sidebar'])) {
            $modules_init['sidebar'] = +$GET['options'];
        }
        file_put_contents(SESSIONS . '/modules_initialization.php', '<?php return ' . var_export($modules_init, true) . ";");
        $this->action_clear_modules_initialization();
        return ['status' => 'success', 'text' => 'Настройки сохранены!'];
    }

    public function DelSettingsBaner($POST)
    {
        chmod(MODULES . 'module_block_main_banner_slider/settings.php', 0777);
        $options = $this->Modules->get_settings_modules('module_block_main_banner_slider', 'settings');

        $indexToDelete = null;
        foreach ($options['slides'] as $index => $item) {
            if ($index == $POST['id_del']) {
                $indexToDelete = $index;
                $imgdel = $item['img'];
                break;
            }
        }

        if ($indexToDelete !== null) {
            unlink('module_block_main_banner_slider/assets/img/' . $imgdel);
            unset($options['slides'][$indexToDelete]);
            $this->Modules->put_settings_modules('module_block_main_banner_slider', 'settings', $options);
            return ['status' => 'success', 'text' => 'Банер удален!'];
        } else {
            return ['status' => 'error', 'text' => 'Банер с указанным ID не найден!'];
        }
    }


    public function GetMenuPoint($id)
    {
        $menu = $this->General->get_neo_menu();

        foreach ($menu as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }

    public function GetMenuCategory($id)
    {
        $categories = $this->General->get_neo_menu_categories();

        foreach ($categories as $item) {
            if (isset($item['numid']) && $item['numid'] == $id) {
                return $item;
            }
        }
        return null;
    }

    public function AddMenuPoint($POST, $GET)
    {
        chmod(MODULESCACHE . 'template_neo/menu_point.php', 0777);
        chmod(MODULESCACHE . 'template_neo/menu_categories.php', 0777);
        if ($GET['new_navbar'] == 1) {
            $categories = $this->General->get_neo_menu_categories();
            if (empty($POST['title']))
                return ['status' => 'error', 'text' => 'Вы забыли указать название категории!'];
            if (empty($POST['svg']))
                return ['status' => 'error', 'text' => 'Вы забыли указать SVG!'];
            if (empty($POST['sort']))
                return ['status' => 'error', 'text' => 'Вы забыли указать порядковый номер!'];

            $currentId = 0;
            foreach ($categories as $item) {
                if ($item['numid'] > $currentId) {
                    $currentId = $item['numid'];
                }
            }
            $newItemId = ++$currentId;

            $newItem = array(
                'title' => $POST['title'],
                'svg' => $POST['svg'],
                'sort' => (int) $POST['sort'],
                'numid' => (int) $newItemId,
                'only_admin' => empty($POST['only_admin']) ? 0 : 1,
            );
            $categories[] = $newItem;

            file_put_contents(MODULESCACHE . 'template_neo/menu_categories.php', '<?php return ' . var_export($categories, true) . ';');
            return ['status' => 'success', 'text' => 'Категория успешно создана!'];
        } else {
            $menu = $this->General->get_neo_menu();
            if (empty($POST['title']))
                return ['status' => 'error', 'text' => 'Вы забыли указать название пункта!'];
            if (empty($POST['link']))
                return ['status' => 'error', 'text' => 'Вы забыли указать ссылку!'];
            if (empty($POST['svg']))
                return ['status' => 'error', 'text' => 'Вы забыли указать SVG!'];

            $currentId = 0;
            foreach ($menu as $item) {
                if ($item['id'] > $currentId) {
                    $currentId = $item['id'];
                }
            }
            $newItemId = ++$currentId;

            $newItem = array(
                'title' => $POST['title'],
                'link' => $POST['link'],
                'description' => $POST['description'] ?? '',
                'svg' => $POST['svg'],
                'sort' => $POST['sort'] ?? '',
                'id' => (int) $newItemId,
                'only_admin' => empty($POST['only_admin']) ? 0 : 1,
                'category' => (int) $POST['category'] ?? 0,
                'sort_category' => $POST['sort_category'] ?? '',
            );
            $menu[] = $newItem;

            file_put_contents(MODULESCACHE . 'template_neo/menu_point.php', '<?php return ' . var_export($menu, true) . ';');
            return ['status' => 'success', 'text' => 'Пункт успешно создан!'];
        }
    }

    public function EditMenuPoint($POST, $GET)
    {
        chmod(MODULESCACHE . 'template_neo/menu_point.php', 0777);
        chmod(MODULESCACHE . 'template_neo/menu_categories.php', 0777);
        if ($GET['edit_categories']) {
            $categories = $this->General->get_neo_menu_categories();
            if (empty($POST['title']))
                return ['status' => 'error', 'text' => 'Вы забыли указать название категории!'];
            if (empty($POST['svg']))
                return ['status' => 'error', 'text' => 'Вы забыли указать SVG!'];
            for ($i = 0; $i < count($categories); $i++) {
                if ($categories[$i]['numid'] == $POST['editid']) {
                    $categories[$i]['title'] = $POST['title'];
                    $categories[$i]['svg'] = $POST['svg'];
                    $categories[$i]['sort'] = $POST['sort'] ?? '';
                    $categories[$i]['only_admin'] = empty($POST['only_admin']) ? 0 : 1;
                    break;
                }
            }
            file_put_contents(MODULESCACHE . 'template_neo/menu_categories.php', '<?php return ' . var_export($categories, true) . ';');
            return ['status' => 'success', 'text' => 'Категория изменена!'];
        } else {
            $menu = $this->General->get_neo_menu();
            if (empty($POST['title']))
                return ['status' => 'error', 'text' => 'Вы забыли указать название пункта!'];
            if (empty($POST['link']))
                return ['status' => 'error', 'text' => 'Вы забыли указать ссылку!'];
            if (empty($POST['svg']))
                return ['status' => 'error', 'text' => 'Вы забыли указать SVG!'];

            for ($i = 0; $i < count($menu); $i++) {
                if ($menu[$i]['id'] == $POST['editid']) {
                    $menu[$i]['title'] = $POST['title'];
                    $menu[$i]['link'] = $POST['link'];
                    $menu[$i]['description'] = $POST['description'] ?? '';
                    $menu[$i]['svg'] = $POST['svg'];
                    $menu[$i]['sort'] = $POST['sort'] ?? '';
                    $menu[$i]['only_admin'] = empty($POST['only_admin']) ? 0 : 1;
                    $menu[$i]['category'] = (int) $POST['category'] ?? 0;
                    $menu[$i]['sort_category'] = $POST['sort_category'] ?? '';
                    break;
                }
            }

            file_put_contents(MODULESCACHE . 'template_neo/menu_point.php', '<?php return ' . var_export($menu, true) . ';');
            return ['status' => 'success', 'text' => 'Пункт изменен!'];
        }
    }

    public function DeleteMenuPoint($POST)
    {
        chmod(MODULESCACHE . 'template_neo/menu_point.php', 0777);
        $menu = $this->General->get_neo_menu();

        $indexToDelete = null;
        foreach ($menu as $index => $item) {
            if ($item['id'] == $POST['id_del']) {
                $indexToDelete = $index;
                break;
            }
        }

        if ($indexToDelete !== null) {
            unset($menu[$indexToDelete]);
            $menu = array_values($menu);

            file_put_contents(MODULESCACHE . 'template_neo/menu_point.php', '<?php return ' . var_export($menu, true) . ';');
            return ['status' => 'success', 'text' => 'Пункт удален!'];
        } else {
            return ['status' => 'error', 'text' => 'Пункт с указанным ID не найден!'];
        }
    }

    public function DeleteMenuCategory($POST)
    {
        chmod(MODULESCACHE . 'template_neo/menu_categories.php', 0777);
        $menu = $this->General->get_neo_menu_categories();

        $indexToDelete = null;
        foreach ($menu as $index => $item) {
            if ($item['numid'] == $POST['id_del']) {
                $indexToDelete = $index;
                break;
            }
        }

        if ($indexToDelete !== null) {
            unset($menu[$indexToDelete]);
            $menu = array_values($menu);

            file_put_contents(MODULESCACHE . 'template_neo/menu_categories.php', '<?php return ' . var_export($menu, true) . ';');
            return ['status' => 'success', 'text' => 'Категория удалена!'];
        } else {
            return ['status' => 'error', 'text' => 'Категория с указанным ID не найдена!'];
        }
    }

    public function AddInfo($POST)
    {
        chmod(MODULESCACHE . 'template_neo/settings_neo.php', 0777);
        $option = $this->General->get_neo_options();
        if (empty($POST['site_name']))
            return ['status' => 'error', 'text' => 'Вы забыли указать название сайта!'];

        $option['SiteName'] = $POST['site_name'];
        $option['SVGLogo'] = empty($POST['svg_logo']) ? '' : $POST['svg_logo'];
        $option['SupportLink'] = $POST['support_link'];
        $option['VK'] = $POST['vk'];
        $option['TG'] = $POST['tg'];
        $option['DS'] = $POST['ds'];
        $option['Steam'] = $POST['steam'];
        $option['YT'] = $POST['yt'];
        $option['TT'] = $POST['tt'];
        $option['ContactEmail'] = $POST['contact_email'];

        file_put_contents(MODULESCACHE . 'template_neo/settings_neo.php', '<?php return ' . var_export($option, true) . ';');
        return ['status' => 'success', 'text' => 'Информация сохранена!'];
    }

    public function CreateTable()
    {
        $result = $this->Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_mod');
        $result1 = $this->Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_country');
        $result2 = $this->Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_city');
        $result3 = $this->Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_sb_id');
        $result4 = $this->Db->mysql_column_search('Core', 0, 0, 'lvl_web_servers', 'server_bage');
        if ($result && $result1 && $result2 && $result3 && $result4 == true) {
            return ['status' => 'error', 'text' => 'Таблица уже обновлена!'];
        } else {
            $this->Db->query('Core', 0, 0, "ALTER TABLE `lvl_web_servers` ADD COLUMN `server_mod` VARCHAR(255)");
            $this->Db->query('Core', 0, 0, "ALTER TABLE `lvl_web_servers` ADD COLUMN `server_country` VARCHAR(255)");
            $this->Db->query('Core', 0, 0, "ALTER TABLE `lvl_web_servers` ADD COLUMN `server_city` VARCHAR(255)");
            $this->Db->query('Core', 0, 0, "ALTER TABLE `lvl_web_servers` ADD COLUMN `server_bage` VARCHAR(255)");
            $this->Db->query('Core', 0, 0, "ALTER TABLE `lvl_web_servers` ADD COLUMN `server_sb_id` VARCHAR(255) AFTER `server_sb`");
            $this->Db->queryAll('Core', 0, 0, "UPDATE `lvl_web_servers` SET server_mod = 'Отредактируйте сервер!'");
            return ['status' => 'success', 'text' => 'Таблица создана! Данные обновлены.'];
        }
    }

    public function CreateTableNoty()
    {
        $result = $this->Db->mysql_column_search('Core', 0, 0, 'lr_web_notifications', 'title');
        $result1 = $this->Db->mysql_column_search('Core', 0, 0, 'lr_web_notifications', 'button');
        if ($result && $result1 == true) {
            return ['status' => 'error', 'text' => 'Таблица уже обновлена!'];
        } else {
            $this->Db->query('Core', 0, 0, "ALTER TABLE `lr_web_notifications` ADD COLUMN `title` VARCHAR(255)");
            $this->Db->query('Core', 0, 0, "ALTER TABLE `lr_web_notifications` ADD COLUMN `button` VARCHAR(255)");
            return ['status' => 'success', 'text' => 'Таблица создана! Данные обновлены.'];
        }
    }

    public function SettingsSaveHide($POST)
    {
        chmod(MODULESCACHE . 'template_neo/settings_neo.php', 0777);
        $option = require MODULESCACHE . 'template_neo/settings_neo.php';
        empty($POST['hide_filter']) ? $hide = 0 : $hide = 1;
        $option['hide_filter'] = $hide;
        file_put_contents(MODULESCACHE . 'template_neo/settings_neo.php', '<?php return ' . var_export($option, true) . ';');
        return ['status' => 'success', 'text' => 'Изменения применены'];
    }

    public function SettingsSaveStretch($POST)
    {
        chmod(MODULESCACHE . 'template_neo/settings_neo.php', 0777);
        $option = require MODULESCACHE . 'template_neo/settings_neo.php';
        empty($POST['stretch_filter']) ? $stretch = 0 : $stretch = 1;
        $option['stretch_filter'] = $stretch;
        file_put_contents(MODULESCACHE . 'template_neo/settings_neo.php', '<?php return ' . var_export($option, true) . ';');
        return ['status' => 'success', 'text' => 'Изменения применены'];
    }

    public function SettingsSaveHideCity($POST)
    {
        chmod(MODULESCACHE . 'template_neo/settings_neo.php', 0777);
        $option = require MODULESCACHE . 'template_neo/settings_neo.php';
        empty($POST['hide_city']) ? $stretch = 0 : $stretch = 1;
        $option['hide_city'] = $stretch;
        file_put_contents(MODULESCACHE . 'template_neo/settings_neo.php', '<?php return ' . var_export($option, true) . ';');
        return ['status' => 'success', 'text' => 'Изменения применены'];
    }

    public function SettingsSaveHideCountry($POST)
    {
        chmod(MODULESCACHE . 'template_neo/settings_neo.php', 0777);
        $option = require MODULESCACHE . 'template_neo/settings_neo.php';
        empty($POST['hide_country']) ? $stretch = 0 : $stretch = 1;
        $option['hide_country'] = $stretch;
        file_put_contents(MODULESCACHE . 'template_neo/settings_neo.php', '<?php return ' . var_export($option, true) . ';');
        return ['status' => 'success', 'text' => 'Изменения применены'];
    }

    public function InfoStatsCached()
    {
        $stats = [
            'CountPlayers' => 0,
            'CountAdmins' => 0,
            'CountBans' => 0,
            'CountMutes' => 0,
            'CountVip' => 0,
            'CountMoney' => 0,
            'CountMoneyMonth' => 0,
            'Time' => time() + 10800,
        ];

        $data = $this->Modules->get_module_cache('module_page_adminpanel', 'stats');
        if (time() > ($data['Time'] ?? 0)) {
            for ($i = 0; $i < $this->Db->table_count['LevelsRanks']; $i++) {
                $stats['CountPlayers'] += $this->Db->queryNum('LevelsRanks', $this->Db->db_data['LevelsRanks'][$i]['USER_ID'], $this->Db->db_data['LevelsRanks'][$i]['DB_num'], 'SELECT COUNT(*) FROM ' . $this->Db->db_data['LevelsRanks'][$i]['Table'] . ' LIMIT 1')[0];
            }
            if (!empty($this->Db->db_data['lk'])) {
                $stats['CountMoney'] = $this->Db->query('lk', 0, 0, "SELECT SUM(`all_cash`) AS `cash_summ` FROM `lk` WHERE `all_cash` > 1 ORDER BY `all_cash` DESC");
                $stats['CountMoneyMonth'] = $this->Db->query('lk', 0, 0, "SELECT SUM(`pay_summ`) AS `total_earned` FROM `lk_pays` WHERE MONTH(STR_TO_DATE(`pay_data`, '%d.%m.%Y %H:%i:%s')) = MONTH(NOW()) AND YEAR(STR_TO_DATE(`pay_data`, '%d.%m.%Y %H:%i:%s')) = YEAR(NOW()) AND `pay_status` = 1");
            }
            if (!empty($this->Db->db_data['AdminSystem'])) {
                for ($i = 0; $i < $this->Db->table_count['AdminSystem']; $i++) {
                    $countBanMutes = $this->Db->query(
                        'AdminSystem',
                        $this->Db->db_data['AdminSystem'][$i]['USER_ID'],
                        $this->Db->db_data['AdminSystem'][$i]['DB_num'],
                        "SELECT 
                            (SELECT COUNT(*) FROM `as_admins` WHERE `id` != 1 LIMIT 1) AS count_admins, 
                            (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = '1' LIMIT 1) AS count_mutes,
                            (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = '2' LIMIT 1) AS count_gags,
                            (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = '3' LIMIT 1) AS count_silence,
                            (SELECT COUNT(*) FROM `as_punishments` WHERE `punish_type` = '0' LIMIT 1) AS count_bans"
                    );
                    $stats['CountMutes'] += $countBanMutes['count_mutes'] + $countBanMutes['count_gags'] + $countBanMutes['count_silence'];
                    $stats['CountAdmins'] += $countBanMutes['count_admins'];
                    $stats['CountBans'] += $countBanMutes['count_bans'];
                }
            }
            if (!empty($this->Db->db_data['IksAdmin'])) {
                for ($i = 0; $i < $this->Db->table_count['IksAdmin']; $i++) {
                    $countBanMutes = $this->Db->query(
                        'IksAdmin',
                        $this->Db->db_data['IksAdmin'][$i]['USER_ID'],
                        $this->Db->db_data['IksAdmin'][$i]['DB_num'],
                        "SELECT 
                            (SELECT COUNT(*) FROM `iks_admins` LIMIT 1) AS count_admins, 
                            (SELECT COUNT(*) FROM `iks_comms` WHERE (`mute_type` = 0 OR `mute_type` = 2) LIMIT 1) AS count_mutes,
                            (SELECT COUNT(*) FROM `iks_comms` WHERE (`mute_type` = 1 OR `mute_type` = 2) LIMIT 1) AS count_gags
                            (SELECT COUNT(*) FROM `iks_bans` LIMIT 1) AS count_bans"
                    );
                    $stats['CountMutes'] += $countBanMutes['count_mutes'] + $countBanMutes['count_gags'];
                    $stats['CountAdmins'] += $countBanMutes['count_admins'];
                    $stats['CountBans'] += $countBanMutes['count_bans'];
                }
            }
            if (!empty($this->Db->db_data['Vips'])) {
                for ($i = 0; $i < $this->Db->table_count['Vips']; $i++) {
                    $stats['CountVip'] += $this->Db->queryNum('Vips', $this->Db->db_data['Vips'][$i]['USER_ID'], $this->Db->db_data['Vips'][$i]['DB_num'], "SELECT COUNT(*) FROM `vip_users` LIMIT 1")[0];
                }
            }
            $this->Modules->set_module_cache('module_page_adminpanel', $stats, 'stats');
        }

        return $data;
    }

    public function InfoStats()
    {
        $stats = [
            'CountPlayers24' => 0,
            'LastPay' => [],
            'CountVisit' => 0,
            'LastShopPay' => [],
            'VisitsUsers' => [],
            'VisitsUsersCount' => 0,
        ];

        for ($i = 0; $i < $this->Db->table_count['LevelsRanks']; $i++) {
            $stats['CountPlayers24'] += $this->Db->queryNum('LevelsRanks', $this->Db->db_data['LevelsRanks'][$i]['USER_ID'], $this->Db->db_data['LevelsRanks'][$i]['DB_num'], 'SELECT COUNT(*) FROM ' . $this->Db->db_data['LevelsRanks'][$i]['Table'] . ' WHERE `lastconnect` >= UNIX_TIMESTAMP(CURDATE()) LIMIT 1')[0];
        }
        if (!empty($this->Db->db_data['lk'])) {
            $stats['LastPay'] = $this->Db->queryAll('lk', 0, 0, "SELECT `pay_order`, `pay_auth`, `pay_summ`, `pay_data`, pay_system, `pay_status` FROM `lk_pays` WHERE `pay_status` = 1 AND NOT `pay_system` = 'admin' ORDER BY `pay_id` DESC LIMIT 10");
        }
        if (file_exists(MODULES . 'module_page_store/description.json')) {
            $stats['LastShopPay'] = $this->Db->queryAll('Core', 0, 0, "SELECT * FROM `lvl_web_shop_logs` ORDER BY `id` DESC LIMIT 10");
        }
        $stats['CountVisit'] = $this->Db->query('Core', 0, 0, "SELECT * FROM `lr_web_attendance` WHERE `date` = " . date('m.Y', time()) . "");
        if (file_exists(MODULES . 'module_page_store/cache/logs_cache.php')) {
            $stats['LastShopPay'] = array_reverse(array_slice(require MODULES . 'module_page_store/cache/logs_cache.php', -10, 10));
        }
        $stats['VisitsUsers'] = $this->Db->queryAll('Core', 0, 0, "SELECT `user`, `ip`, `time` FROM `lr_web_online` ORDER BY CASE WHEN `user` != 'guest' THEN 0 ELSE 1 END");
        $stats['VisitsUsersCount'] = $this->Db->queryNum('Core', 0, 0, "SELECT COUNT(*) FROM `lr_web_online` LIMIT 1")[0];

        return $stats;
    }

    public function DelAllLogsWeb()
    {
        chmod(APP . 'logs/', 0777);
        if (is_dir(__DIR__ . '/../../../logs/')) {
            $files = glob(__DIR__ . '/../../../logs/' . '*');
            if ($files !== false) {
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
                return ['status' => 'success', 'text' => 'Все логи успешно удалены!'];
            } else {
                return ['status' => 'error', 'text' => 'Не удалось получить список файлов в папке!'];
            }
        } else {
            return ['status' => 'error', 'text' => 'Папка с логами не существует!'];
        }
    }

    public function DelLogWeb($POST)
    {
        chmod(APP . 'logs/', 0777);
        if (isset($POST['id'])) {
            if (file_exists(__DIR__ . '/../../../logs/' . $POST['id'])) {
                if (unlink(__DIR__ . '/../../../logs/' . $POST['id'])) {
                    return ['status' => 'success', 'text' => 'Лог ' . $POST['id'] . ' успешно удален!'];
                } else {
                    return ['status' => 'error', 'text' => 'Ошибка при удалении лога ' . $POST['id'] . ''];
                }
            } else {
                return ['status' => 'error', 'text' => 'Лог ' . $POST['id'] . ' не найден'];
            }
        } else {
            return ['status' => 'error', 'text' => 'Название файла не получено'];
        }
    }

    public function DelAllLogsRef()
    {
        chmod(APP . 'logs/referral/', 0777);
        if (is_dir(__DIR__ . '/../../../logs/referral/')) {
            $files = glob(__DIR__ . '/../../../logs/referral/' . '*');
            if ($files !== false) {
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
                return ['status' => 'success', 'text' => 'Все логи успешно удалены!'];
            } else {
                return ['status' => 'error', 'text' => 'Не удалось получить список файлов в папке!'];
            }
        } else {
            return ['status' => 'error', 'text' => 'Папка с логами не существует!'];
        }
    }

    public function DelLogRef($POST)
    {
        chmod(APP . 'logs/referral/', 0777);
        if (isset($POST['id'])) {
            if (file_exists(__DIR__ . '/../../../logs/referral/' . $POST['id'])) {
                if (unlink(__DIR__ . '/../../../logs/referral/' . $POST['id'])) {
                    return ['status' => 'success', 'text' => 'Лог ' . $POST['id'] . ' успешно удален!'];
                } else {
                    return ['status' => 'error', 'text' => 'Ошибка при удалении лога ' . $POST['id'] . ''];
                }
            } else {
                return ['status' => 'error', 'text' => 'Лог ' . $POST['id'] . ' не найден'];
            }
        } else {
            return ['status' => 'error', 'text' => 'Название файла не получено'];
        }
    }

    public function ShopLogs()
    {
        chmod(MODULES . 'module_page_store/cache/', 0777);
        if (file_exists(MODULES . 'module_page_store/cache/logs_cache.php')) {
            return require MODULES . 'module_page_store/cache/logs_cache.php';
        } elseif ($this->Db->mysql_table_search('Core', 0, 0, "lvl_web_shop_logs")) {
            return $this->Db->queryAll('Core', 0, 0, "SELECT `id`, `steam`, `title`, `promo`, `date`, `status` FROM `lvl_web_shop_logs` WHERE `status` = 1");
        }
    }

    public function LkLogs()
    {
        $alllogs = $this->Db->queryAll('lk', $this->Db->db_data['lk'][0]['USER_ID'], $this->Db->db_data['lk'][0]['DB_num'], "SELECT DISTINCT log_name FROM lk_logs");
        return array_reverse($alllogs);
    }

    public function LkLogContent($log)
    {
        if (!preg_match('/^[0-9]{2}\_[0-9]{2}\_[0-9]{4}+$/i', $log)) {
            return ['status' => 'error', 'text' => 'Название файла не получено'];
        }
        $param = ['log_name' => $log];
        $contentLog = $this->Db->queryAll('lk', $this->Db->db_data['lk'][0]['USER_ID'], $this->Db->db_data['lk'][0]['DB_num'], "SELECT * FROM lk_logs WHERE log_name = :log_name", $param);
        if (!empty($contentLog)) {
            return $contentLog;
        } else {
            return ['status' => 'error', 'text' => 'Лог не найден'];
        }
    }

    public function LkLogdelete($log)
    {
        if (!preg_match('/^[0-9]{2}\_[0-9]{2}\_[0-9]{4}+$/i', $log['id'])) {
            return ['status' => 'error', 'text' => 'Название файла не получено'];
        }
        $param = ['log_name' => $log['id']];
        $this->Db->query('lk', $this->Db->db_data['lk'][0]['USER_ID'], $this->Db->db_data['lk'][0]['DB_num'], "DELETE FROM lk_logs WHERE log_name = :log_name", $param);
        return ['status' => 'success', 'text' => 'Лог ' . $log['id'] . ' успешно удален!'];
    }

    public function LkCleanLogs()
    {
        $this->Db->query('lk', $this->Db->db_data['lk'][0]['USER_ID'], $this->Db->db_data['lk'][0]['DB_num'], "DELETE FROM lk_logs WHERE log_name");
        return ['status' => 'success', 'text' => 'Все логи успешно удалены!'];
    }

    public function getMonthName($Month)
    {
        switch ($Month) {
            case 1:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Jan');
            case 2:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Feb');
            case 3:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Mar');
            case 4:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Apr');
            case 5:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_May');
            case 6:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Jun');
            case 7:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Jul');
            case 8:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Aug');
            case 9:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Sep');
            case 10:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Oct');
            case 11:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Nov');
            case 12:
                return $this->Translate->get_translate_module_phrase('module_page_adminpanel', '_Dec');
            default:
        }
    }
}

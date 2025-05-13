<?php /**
  * @author -r8 (@r8.dev)
  **/

namespace app\modules\module_page_reports\ext;

use app\modules\module_page_reports\ext\Core;

class SettingsCore extends Core
{
    protected $Db, $General, $Translate, $Modules, $Notifications;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
    }

    public function TableSearchReports()
    {
        $checkTable = array('rs_reports', 'rs_chatlogging', 'rs_admins', 'rs_servers', 'rs_warns');
        foreach ($checkTable as $key) {
            $result = $this->Db->mysql_table_search('Reports', 0, 0, $key);
            if ($result == 0) {
                return true;
            }
        }
        return false;
    }

    public function InstallMod($POST)
    {
        if (empty($POST['namedatabase']) && empty($POST['host']) && empty($POST['database']) && empty($POST['user']) && empty($POST['password_input']) && empty($POST['port'])) {
            return ['status' => 'error', 'text' => 'Кажется вы что-то забыли...'];
        }

        $this->Db->change_db(
            "Reports",
            $POST['host'],
            $POST['user'],
            $POST['password_input'],
            $POST['database'],
            'rs_',
            0,
            [
                'name' => $POST['namedatabase'],
            ]
        );

        return ['status' => 'success', 'text' => 'Вы успешно установили модуль!'];
    }

    public function ChangeSettingsOne($POST) 
    {
        chmod(MODULES . 'module_page_reports/assets/cache/settings.php', 0777);
        $settings = Core::GetCache('settings');

        $settings['auto_check_report'] = empty($POST['noty']) ? '0' : '1';
        $settings['auto_update_info'] = empty($POST['update']) ? '0' : '1';
        $settings['update_time_js'] = $POST['update_input_js'];
        $settings['time_actual'] = $POST['report_actual'];
        
        Core::PutCache('settings', $settings);
        return ['status' => 'success', 'text' => 'Вы сохранили настройки #1!'];
    }

    public function ChangeSettingsTwo($POST) 
    {
        chmod(MODULES . 'module_page_reports/assets/cache/settings.php', 0777);
        $settings = Core::GetCache('settings');

        $settings['auto_update_admin'] = empty($POST['admin']) ? '0' : '1';
        $settings['update_time'] = $POST['admin_input'];
        
        Core::PutCache('settings', $settings);
        return ['status' => 'success', 'text' => 'Вы сохранили настройки #2!'];
    }

    public function ChangeSettingsThree($POST) 
    {
        chmod(MODULES . 'module_page_reports/assets/cache/settings.php', 0777);
        $settings = Core::GetCache('settings');

        $settings['auto_update_warn'] = empty($POST['warn']) ? '0' : '1';
        $settings['update_time_warn'] = $POST['warn_input'];
        $settings['life_time_warn'] = $POST['life_warn'];
        $settings['max_warn'] = $POST['max_warn_input'];
        
        Core::PutCache('settings', $settings);
        return ['status' => 'success', 'text' => 'Вы сохранили настройки #3!'];
    }

    public function ChangeSettingsFour($POST) 
    {
        chmod(MODULES . 'module_page_reports/assets/cache/settings.php', 0777);
        $settings = Core::GetCache('settings');

        $settings['auto_update_status'] = empty($POST['ban']) ? '0' : '1';
        $settings['update_time_status'] = $POST['ban_input'];
        $settings['blockdb_apikey'] = $POST['blockdb_input'];
        
        Core::PutCache('settings', $settings);
        return ['status' => 'success', 'text' => 'Вы сохранили настройки #4!'];
    }

    public function SaveDoneVerdict($POST) {
        chmod(MODULES . 'module_page_reports/assets/cache/verdictdone.php', 0777);
        $verdict = Core::GetCache('verdictdone');

        if (empty($POST['verdict_input'])) {
            return ['status' => 'error', 'text' => 'Вы забыли указать вердикт!'];
        }

        $mass = array(
            'verdict' => $POST['verdict_input'],
        );
        $verdict[] = $mass;

        Core::PutCache('verdictdone', $verdict);
        return ['status' => 'success', 'text' => 'Вердикт добавлен!'];
    }

    public function DelDoneVerdict($POST) {
        chmod(MODULES . 'module_page_reports/assets/cache/verdictdone.php', 0777);
        $verdict = Core::GetCache('verdictdone');
    
        if (array_key_exists($POST['id'], $verdict)) {
            unset($verdict[$POST['id']]);
            Core::PutCache('verdictdone', $verdict);
            return ['status' => 'success', 'text' => 'Вердикт удален!'];
        } else {
            return ['status' => 'error', 'text' => 'Такого вердикта не существует!'];
        }
    }    
}
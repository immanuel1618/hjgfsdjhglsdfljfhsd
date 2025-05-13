<?php /**
  * @author -r8 (@r8.dev)
  **/

$actions = [
    'add_connection' => fn($data) => $Core->SettingsCore()->InstallMod($data),
    'load_list' => fn($data) => $Core->ReportCore()->RenderList($data['sort'], $data['limit']),
    'load_stat' => fn($data) => $Core->ReportCore()->ReportsList(3),
    'new_report' => fn($data) => $Core->ReportCore()->ProcessingNewReport(),
    'noty_report' => fn($data) => $Core->ReportCore()->NewReportSend($data),
    'reload_admins' => fn($data) => $Core->AccessCore()->UpdateAdminUser(),
    'set_update' => fn($data) => $Core->AccessCore()->SetUpdate(),
    'btn_click' => fn($data) => $Core->ReportCore()->ClickBtnStatus($data),
    'put_status' => fn($data) => $Core->ReportCore()->PutStatusReport(),
    'option_info' => fn($data) => $Core->ReportCore()->PutOptionalInfo(),
    'warn_btn' => fn($data) => $Core->ReportCore()->WarnAdd(),
    'verdict' => fn($data) => $Core->ReportCore()->VerdictTo($data),
    'noty_btn' => fn($data) => $Core->ReportCore()->RenderNotyBtn(),
    'noty_click' => fn($data) => $Core->ReportCore()->NotyChange($data),
    'reload_status' => fn($data) => $Core->ReportCore()->UpdateReportBan(),
    'set_update_status' => fn($data) => $Core->ReportCore()->SetBanUpdate(),
    'add_server' => fn($data) => $Core->AddServer($data),
    'server_del' => fn($data) => $Core->DelServer($data),
    'save_one' => fn($data) => $Core->SettingsCore()->ChangeSettingsOne($data),
    'save_two' => fn($data) => $Core->SettingsCore()->ChangeSettingsTwo($data),
    'save_four' => fn($data) => $Core->SettingsCore()->ChangeSettingsFour($data),
    'save_three' => fn($data) => $Core->SettingsCore()->ChangeSettingsThree($data),
    'reload_warn' => fn($data) => $Core->ReportCore()->UpdateReportWarn($data),
    'set_update_warn' => fn($data) => $Core->ReportCore()->SetWarnUpdate($data),
    'add_vedict' => fn($data) => $Core->SettingsCore()->SaveDoneVerdict($data),
    'verdict_del' => fn($data) => $Core->SettingsCore()->DelDoneVerdict($data)
];

foreach ($actions as $key => $action) {
    if (isset($_POST[$key])) {
        try {
            $response = $action($_POST);
            exit(json_encode($response, true));
        } catch (Exception $e) {
            exit(json_encode(['status' => 'error', 'text' => $e->getMessage()], true));
        }
    }
}
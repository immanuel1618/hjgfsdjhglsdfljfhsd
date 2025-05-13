<?php /**
  * @author -r8 (@r8.dev)
  **/

namespace app\modules\module_page_reports\ext;

use app\modules\module_page_reports\ext\Core;

class ReportCore extends Core
{
    protected $Db, $General, $Translate, $Modules, $Notifications, $sid, $rid;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications, $sid, $rid)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
        $this->sid = $sid;
        $this->rid = $rid;
        $this->AccessCore = new AccessCore($Db, $General);
        $this->ApiCore = new ApiCore($General);
    }

    public function ReportsList($option, $sort = '', $limit = '', $steam = '', $id = '')
    {
        if ($option == 1) {
            if ($sort == 1) {
                return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_reports` WHERE `sid` = " . $this->sid . " ORDER BY `time` DESC LIMIT 0, " . $limit . "");
            } elseif ($sort == 2) {
                return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_reports` WHERE `sid` = " . $this->sid . " AND (`time` >= UNIX_TIMESTAMP(NOW()) - " . Core::GetCache('settings')['time_actual'] . " AND `status` != 1) ORDER BY `time` DESC LIMIT 0, " . $limit . "");
            } elseif ($sort == 3) {
                return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_reports` WHERE `sid` = " . $this->sid . " AND (`time` <= UNIX_TIMESTAMP(NOW()) - " . Core::GetCache('settings')['time_actual'] . " OR `status` = 1) ORDER BY `time` DESC LIMIT 0, " . $limit . "");
            } elseif ($sort == 4) {
                return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_reports` WHERE `sid` = " . $this->sid . " AND `status` = 1 ORDER BY `time` DESC LIMIT 0, " . $limit . "");
            } elseif ($sort == 5) {
                return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_reports` WHERE `steamid_admin_verdict` = " . $_SESSION['steamid64'] . " AND `status` = 0 ORDER BY `time` DESC LIMIT 1");
            }
        } elseif ($option == 2) {
            if ($sort == 1) {
                return $this->Db->query('Reports', 0, 0, "SELECT COUNT(*) FROM `rs_reports` WHERE `sid` = " . $this->sid . " AND `time` >= UNIX_TIMESTAMP(NOW()) - " . Core::GetCache('settings')['time_actual'] . " AND `status` != 1 LIMIT 1");
            } elseif ($sort == 2) {
                return $this->Db->query('Reports', 0, 0, "SELECT * FROM `rs_reports` WHERE `id` = $id");
            } elseif ($sort == 3) {
                return $this->Db->query('Reports', 0, 0, "SELECT COUNT(*) FROM `rs_reports` WHERE `sid` = " . $this->sid . " LIMIT 1");
            } elseif ($sort == 4) {
                return $this->Db->query('Reports', 0, 0, "SELECT COUNT(*) FROM `rs_reports` WHERE `steamid_intruder` = " . $steam . " LIMIT 1");
            }
        } elseif ($option == 3) {
            $stat = [
                "count" => 0
            ];
            $count = count(Core::GetServers());
            $stat['count'] += $count;
            
            foreach (Core::GetServers() as $key => $row) {
                $rep_count = $this->Db->query('Reports', 0, 0, "SELECT 
                    (SELECT COUNT(*) FROM `rs_reports` WHERE `sid` = " . $row['sid'] . " LIMIT 1) AS total_reports,
                    (SELECT COUNT(*) FROM `rs_reports` WHERE `sid` = " . $row['sid'] . " AND `time` >= UNIX_TIMESTAMP(NOW()) - " . Core::GetCache('settings')['time_actual'] . " AND `status` != 1 LIMIT 1) AS active_reports;
                ");

                $stat[$key] = [
                    "new_rep" => $rep_count['active_reports'],
                    "all_rep" => $rep_count['total_reports'],
                ];
            }
            return $stat;
        } elseif ($option == 4) {
            return $this->Db->query('Reports', 0, 0, "SELECT 
                (SELECT COUNT(*) FROM `rs_reports` WHERE `sid` = " . $this->sid . " LIMIT 1) AS total_reports,
                (SELECT COUNT(*) FROM `rs_reports` WHERE `sid` = " . $this->sid . " AND `time` >= UNIX_TIMESTAMP(NOW()) - " . Core::GetCache('settings')['time_actual'] . " AND `status` != 1 LIMIT 1) AS active_reports;
            ");
        }
    }

    public function RenderList($sort, $limit) {
        $sort_foreach = $this->ReportsList(1, $sort, $limit);
        $reports_info = $this->ReportsList(4);
        $total_reports = $reports_info['total_reports'];
        $total_reports2 = $reports_info['active_reports'];
        $null = '';
        if ($this->sid == NULL) {
            $null = <<<HTML
                <div class="reports_empty">Выберите сервер 👈</div>
            HTML;
        } else {
            if (empty(count($sort_foreach))) {
                $null = <<<HTML
                    <div class="reports_empty">Репортов нет 😉</div>
                HTML;
            }
        }
        $pagination = '';
        if ($sort != 5) {
            if ($sort != 2 && $total_reports > $limit) {
                $pagination = <<<HTML
                    <div class="load_container"><div id="load_next">Загрузить еще</div><div class="update_element"><svg class="spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg></div></div>
                HTML;
            } elseif ($sort == 2 && $total_reports2 > $limit) {
                $pagination = <<<HTML
                    <div class="load_container"><div id="load_next">Загрузить еще</div><div class="update_element"><svg class="spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg></div></div>
                HTML;
            }
        }
        foreach($sort_foreach as $key => $row) {
            $date = date('d.m, H:i', $row['time']);
            $name = empty($row['name_intruder']) ? action_text_clear($this->General->checkName($row['steamid_intruder'])) : action_text_clear($row['name_intruder']);
            $steamid = $row['steamid_intruder'];
            $reason = action_text_clear($row['reason']);
            $id = $row['id'];
            $sid = $row['sid'];
            $server_name = Core::GetServerSid($sid)['name_custom'];
            $server_ip = Core::GetServerSid($sid)['ip'];
            $time = $this->GetPlayTime($steamid) ?? 0;
            $kill = $row['kills'];
            $deaths = $row['deaths'];
            if ($deaths == 0) {
                $kd = $kill == 0 ? 0 : round($kill / ($deaths + 1), 2); 
            } else {
                $kd = round($kill / $deaths, 2);
            }
            $statuskd = ''; 
            if ($kd < 2) { 
                $statuskd = 'normal_value'; 
            } elseif ($kd < 5) { 
                $statuskd = 'suspect_value'; 
            } else { 
                $statuskd = 'unacceptable_value'; 
            }
            $alredy = '';
            $html = <<<HTML
                <span class="report_none" data-tippy-content="Дата" data-tippy-placement="top">
                    <div class="date_time_report">{$date}</div>
                </span>
                <span data-tippy-content="Подозреваемый" data-tippy-placement="top">
                    <div class="user_data">
                        <img class="report_none" style="position: absolute; transform: scale(1.17);" src="{$this->General->getFrame($steamid)}" id="frame" frameid="{$steamid}">
                        <img class="report_none" src="{$this->General->getAvatar($steamid, 3)}" id="avatar" avatarid="{$steamid}">
                        <div class="report_intruder_user">
                            <div class="intruder_report_name">{$name}</div>
                            <div class="intruder_report_steamid report_none copybtn" data-clipboard-text="{$steamid}">{$steamid}
                                <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                    <g>
                                        <path d="M5.452 22h9.096c1.748 0 3.182-1.312 3.406-3h.594A3.456 3.456 0 0 0 22 15.548V5.452A3.456 3.456 0 0 0 18.548 2H9.452A3.456 3.456 0 0 0 6 5.452V6h-.548A3.456 3.456 0 0 0 2 9.452v9.096A3.456 3.456 0 0 0 5.452 22zM8 5.452C8 4.652 8.651 4 9.452 4h9.096c.8 0 1.452.651 1.452 1.452v10.096c0 .8-.651 1.452-1.452 1.452H18V9.452A3.456 3.456 0 0 0 14.548 6H8zm-4 4C4 8.652 4.651 8 5.452 8h9.096c.8 0 1.452.651 1.452 1.452v9.096c0 .8-.651 1.452-1.452 1.452H5.452C4.652 20 4 19.349 4 18.548z"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </span>
                <span data-tippy-content="Причина" data-tippy-placement="top">
                    <div class="reason_report scroll no-scrollbar">{$reason}</div>
                </span>
                <span class="play_info report_none">
                    <div class="{$statuskd}" data-tippy-content="Убил: {$kill} | Умер: {$deaths}" data-tippy-placement="top">KD: {$kd}</div>
                    <div class="project_time" data-tippy-content="Наиграно часов" data-tippy-placement="bottom">
                        <svg x="0" y="0" viewBox="0 0 64 64" xml:space="preserve">
                            <g>
                                <path d="M50.033 14.408c-2.838-2.566-5.053-2.407-7.922-1.54l-1.45 4.77a4.309 4.309 0 0 1-4.14 3.151h-9.042a4.321 4.321 0 0 1-4.15-3.18l-1.35-4.72c-2.907-.865-5.138-1.081-8.012 1.52-5.73 5.04-11.151 18.472-9.74 29.683a8.664 8.664 0 0 0 4.44 6.661c2.73 1.45 6.85 1.87 11.601-3.63a5.968 5.968 0 0 1-2.3-4.71c.142-7.116 10.1-8.206 11.832-1.39a5.94 5.94 0 0 1 .14 2.01 23.632 23.632 0 0 0 4.12 0c-.02-.2-.03-.41-.03-.62a6 6 0 0 1 12.002 0 5.967 5.967 0 0 1-2.3 4.71c4.143 4.557 7.453 5.603 11.601 3.63a8.664 8.664 0 0 0 4.44-6.66c1.411-11.212-4.01-24.644-9.74-29.685zM24.429 29.88a.997.997 0 0 1-1 1h-1.91v1.91a1.003 1.003 0 0 1-1 1.001h-3.531a1.003 1.003 0 0 1-1-1v-1.91h-1.91a.997.997 0 0 1-1-1V26.35a1.003 1.003 0 0 1 1-1h1.91v-1.9a.997.997 0 0 1 1-1h3.53a.997.997 0 0 1 1 1v1.9h1.91a1.003 1.003 0 0 1 1 1zM35.2 36.051h-6.4a1 1 0 0 1 0-2h6.4a1 1 0 0 1 0 2zm6.831-6.37a1.56 1.56 0 0 1 0-3.121 1.56 1.56 0 0 1 0 3.12zm3.52 3.52a1.56 1.56 0 0 1 .001-3.12 1.56 1.56 0 0 1 0 3.12zm0-7.041a1.56 1.56 0 0 1 .001-3.12 1.56 1.56 0 0 1 0 3.12zm3.521 3.52a1.56 1.56 0 0 1 0-3.12 1.56 1.56 0 0 1 0 3.12z"></path>
                                <path d="M23.969 38.412a4 4 0 0 0 0 8 4 4 0 0 0 0-8zM44.032 42.412a4 4 0 0 0-8.001 0 4 4 0 0 0 8 0zM25.26 17.069a2.317 2.317 0 0 0 2.22 1.72h9.04a2.32 2.32 0 0 0 2.22-1.71c.284-.923.864-2.85 1.151-3.78-2.11.438-10.419.189-12.692.25a20.386 20.386 0 0 1-3.02-.24c.277.93.808 2.84 1.08 3.76zM19.518 26.35v-1.9h-1.53v1.9a.997.997 0 0 1-1 1h-1.91v1.53h1.91a1.003 1.003 0 0 1 1 1v1.91h1.53v-1.91a1.003 1.003 0 0 1 1-1h1.91v-1.53h-1.91a.997.997 0 0 1-1-1z"></path>
                            </g>
                        </svg>
                        {$time} ч.
                    </div>
                </span>
                <span class="report_none" data-tippy-content="Сервер" data-tippy-placement="top">
                    <div class="server_name">{$server_name}</div>
                    <div class="server_address_block copybtn2" data-clipboard-text="{$server_ip}">
                        <div class="server_addres">{$server_ip}</div>
                        <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                            <g>
                                <path d="M5.452 22h9.096c1.748 0 3.182-1.312 3.406-3h.594A3.456 3.456 0 0 0 22 15.548V5.452A3.456 3.456 0 0 0 18.548 2H9.452A3.456 3.456 0 0 0 6 5.452V6h-.548A3.456 3.456 0 0 0 2 9.452v9.096A3.456 3.456 0 0 0 5.452 22zM8 5.452C8 4.652 8.651 4 9.452 4h9.096c.8 0 1.452.651 1.452 1.452v10.096c0 .8-.651 1.452-1.452 1.452H18V9.452A3.456 3.456 0 0 0 14.548 6H8zm-4 4C4 8.652 4.651 8 5.452 8h9.096c.8 0 1.452.651 1.452 1.452v9.096c0 .8-.651 1.452-1.452 1.452H5.452C4.652 20 4 19.349 4 18.548z"></path>
                            </g>
                        </svg>
                    </div>
                </span>
                <span>
                    <div class="report_flop_btn" onclick="location.href='/reports/report/{$this->sid}/{$id}/'">
                        Перейти
                    </div>
                </span>
            HTML;
            $aname = empty($row['name_admin_verdict']) ? action_text_clear($this->General->checkName($row['steamid_admin_verdict'])) : $row['name_admin_verdict'];
            if ($row['steamid_admin_verdict'] && $row['steamid_admin_verdict'] != $_SESSION['steamid64'] && $row['status'] == 0) {
                $alredy = <<<HTML
                    <span class="report_is_pending">Репорт уже рассматривается админом {$aname}!</span>
                HTML;
                $html = <<<HTML
                    <span class="report_none" style="cursor: default; user-select: none;">
                        <div class="date_time_report">{$date}</div>
                    </span>
                    <span>
                        <div class="user_data">
                            <img class="report_none" style="position: absolute; transform: scale(1.17);" src="{$this->General->getFrame($steamid)}" id="frame" frameid="{$steamid}">
                            <img class="report_none" src="{$this->General->getAvatar($steamid, 3)}" id="avatar" avatarid="{$steamid}">
                            <div class="report_intruder_user">
                                <div class="intruder_report_name" style="cursor: default; user-select: none;">{$name}</div>
                                <div class="intruder_report_steamid report_none" style="cursor: default; user-select: none;">{$steamid}
                                    <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                        <g>
                                            <path d="M5.452 22h9.096c1.748 0 3.182-1.312 3.406-3h.594A3.456 3.456 0 0 0 22 15.548V5.452A3.456 3.456 0 0 0 18.548 2H9.452A3.456 3.456 0 0 0 6 5.452V6h-.548A3.456 3.456 0 0 0 2 9.452v9.096A3.456 3.456 0 0 0 5.452 22zM8 5.452C8 4.652 8.651 4 9.452 4h9.096c.8 0 1.452.651 1.452 1.452v10.096c0 .8-.651 1.452-1.452 1.452H18V9.452A3.456 3.456 0 0 0 14.548 6H8zm-4 4C4 8.652 4.651 8 5.452 8h9.096c.8 0 1.452.651 1.452 1.452v9.096c0 .8-.651 1.452-1.452 1.452H5.452C4.652 20 4 19.349 4 18.548z"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </span>
                    <span>
                        <div class="reason_report scroll no-scrollbar" style="cursor: default; user-select: none;">{$reason}</div>
                    </span>
                    <span class="play_info report_none">
                        <div class="{$statuskd}" style="cursor: default; user-select: none;">KD: {$kd}</div>
                        <div class="project_time" style="cursor: default; user-select: none;">
                            <svg x="0" y="0" viewBox="0 0 64 64" xml:space="preserve">
                                <g>
                                    <path d="M50.033 14.408c-2.838-2.566-5.053-2.407-7.922-1.54l-1.45 4.77a4.309 4.309 0 0 1-4.14 3.151h-9.042a4.321 4.321 0 0 1-4.15-3.18l-1.35-4.72c-2.907-.865-5.138-1.081-8.012 1.52-5.73 5.04-11.151 18.472-9.74 29.683a8.664 8.664 0 0 0 4.44 6.661c2.73 1.45 6.85 1.87 11.601-3.63a5.968 5.968 0 0 1-2.3-4.71c.142-7.116 10.1-8.206 11.832-1.39a5.94 5.94 0 0 1 .14 2.01 23.632 23.632 0 0 0 4.12 0c-.02-.2-.03-.41-.03-.62a6 6 0 0 1 12.002 0 5.967 5.967 0 0 1-2.3 4.71c4.143 4.557 7.453 5.603 11.601 3.63a8.664 8.664 0 0 0 4.44-6.66c1.411-11.212-4.01-24.644-9.74-29.685zM24.429 29.88a.997.997 0 0 1-1 1h-1.91v1.91a1.003 1.003 0 0 1-1 1.001h-3.531a1.003 1.003 0 0 1-1-1v-1.91h-1.91a.997.997 0 0 1-1-1V26.35a1.003 1.003 0 0 1 1-1h1.91v-1.9a.997.997 0 0 1 1-1h3.53a.997.997 0 0 1 1 1v1.9h1.91a1.003 1.003 0 0 1 1 1zM35.2 36.051h-6.4a1 1 0 0 1 0-2h6.4a1 1 0 0 1 0 2zm6.831-6.37a1.56 1.56 0 0 1 0-3.121 1.56 1.56 0 0 1 0 3.12zm3.52 3.52a1.56 1.56 0 0 1 .001-3.12 1.56 1.56 0 0 1 0 3.12zm0-7.041a1.56 1.56 0 0 1 .001-3.12 1.56 1.56 0 0 1 0 3.12zm3.521 3.52a1.56 1.56 0 0 1 0-3.12 1.56 1.56 0 0 1 0 3.12z"></path>
                                    <path d="M23.969 38.412a4 4 0 0 0 0 8 4 4 0 0 0 0-8zM44.032 42.412a4 4 0 0 0-8.001 0 4 4 0 0 0 8 0zM25.26 17.069a2.317 2.317 0 0 0 2.22 1.72h9.04a2.32 2.32 0 0 0 2.22-1.71c.284-.923.864-2.85 1.151-3.78-2.11.438-10.419.189-12.692.25a20.386 20.386 0 0 1-3.02-.24c.277.93.808 2.84 1.08 3.76zM19.518 26.35v-1.9h-1.53v1.9a.997.997 0 0 1-1 1h-1.91v1.53h1.91a1.003 1.003 0 0 1 1 1v1.91h1.53v-1.91a1.003 1.003 0 0 1 1-1h1.91v-1.53h-1.91a.997.997 0 0 1-1-1z"></path>
                                </g>
                            </svg>
                            {$time} ч.
                        </div>
                    </span>
                    <span class="report_none">
                        <div class="server_name" style="cursor: default; user-select: none;">{$server_name}</div>
                        <div class="server_address_block" style="cursor: default; user-select: none;">
                            <div class="server_addres">{$server_ip}</div>
                            <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                <g>
                                    <path d="M5.452 22h9.096c1.748 0 3.182-1.312 3.406-3h.594A3.456 3.456 0 0 0 22 15.548V5.452A3.456 3.456 0 0 0 18.548 2H9.452A3.456 3.456 0 0 0 6 5.452V6h-.548A3.456 3.456 0 0 0 2 9.452v9.096A3.456 3.456 0 0 0 5.452 22zM8 5.452C8 4.652 8.651 4 9.452 4h9.096c.8 0 1.452.651 1.452 1.452v10.096c0 .8-.651 1.452-1.452 1.452H18V9.452A3.456 3.456 0 0 0 14.548 6H8zm-4 4C4 8.652 4.651 8 5.452 8h9.096c.8 0 1.452.651 1.452 1.452v9.096c0 .8-.651 1.452-1.452 1.452H5.452C4.652 20 4 19.349 4 18.548z"></path>
                                </g>
                            </svg>
                        </div>
                    </span>
                    <span>
                        <div class="report_flop_btn {$btn_vip}" style="cursor: default; user-select: none;">
                            Перейти
                        </div>
                    </span>
                HTML;
            }
            $html_list[$key] = <<<HTML
                <ul>
                    {$alredy}
                    {$html}
                </ul>
            HTML;
        }
        return ["html" => $html_list, "null" => $null, "pagination" => $pagination];
    }

    public function ProcessingNewReport() {
        $newrep = $this->Db->query('Reports', 0, 0, "SELECT * FROM rs_reports WHERE noty = 0 ORDER BY id DESC LIMIT 1");
        
        if (!empty($newrep)) {
            $noty[] = [
                'id' => $newrep['id'],
                'sid' => $newrep['sid'],
                'iname' => $newrep['name_intruder'],
                'sname' => $newrep['name_sender'],
                'reason' => $newrep['reason'],
            ];
            return ["noty" => $noty];
        }
    
        return ["noty" => []];
    }
    
    public function NewReportSend($POST) {
        $processing = [];
        
        foreach ($this->AccessCore->GetAccess() as $key) {
            if ($key['working'] == 1 && $key['sid'] == $POST['sid']) {
                if (!in_array($key['steamid'], $processing)) {
                    $this->Notifications->SendNotification(
                        $key['steamid'],
                        '_Report',
                        '_ReportNotyText',
                        [
                            'module_translation' => 'module_page_reports',
                            'id' => $POST['id'],
                            'sid' => Core::GetServerSid($POST['sid'])['name_custom'],
                            'iname' => action_text_clear($POST['iname']),
                            'sname' => action_text_clear($POST['sname']),
                            'reason' => $POST['reason']
                        ],
                        $this->General->arr_general['site'] . 'reports/report/' . $POST['sid'] . '/' . $POST['id'] . '/',
                        'reports',
                        '_Go'
                    );
                    $processing[] = $key['steamid'];
                }
            }
        }

        $this->Db->query('Reports', 0, 0, "UPDATE rs_reports SET noty = 1 WHERE id = :id", ['id' => $POST['id']]);
    }
    
    public function RenderNotyBtn() {
        $noty = '';
        if (Core::GetCache('settings')['auto_check_report'] == 1) {
            foreach ($this->AccessCore->GetAccess() as $access) {
                if ($access['steamid'] == $_SESSION['steamid64']) {
                    if ($access['working'] == 1) {
                        $noty = <<<HTML
                            <div class="report_notify_btn" btn="0">
                                <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                    <g>
                                        <path d="M12 24a3.756 3.756 0 0 0 3.674-3H8.326A3.756 3.756 0 0 0 12 24zM5 9v2.788a6.705 6.705 0 0 1-2.388 5.133A1.752 1.752 0 0 0 3.75 20h13.068L5.047 8.228A7.033 7.033 0 0 0 5 9zM23.707 22.293l-2.562-2.562c.506-.307.855-.847.855-1.481 0-.512-.223-.996-.622-1.337A6.7 6.7 0 0 1 19 11.788V9c0-3.519-2.614-6.432-6-6.92V1a1 1 0 1 0-2 0v1.08a6.998 6.998 0 0 0-4.664 2.842L1.707.293A.999.999 0 1 0 .293 1.707l22 22a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414z"></path>
                                    </g>
                                </svg>
                                <div class="report_notify_text">
                                    <span class="notify_btn_title">Уведомления</span>
                                    <span class="notify_btn_desc">Не получать новые репорты</span>
                                </div>
                            </div>
                        HTML;
                        break;
                    } elseif ($access['working'] == 0) {
                        $noty = <<<HTML
                            <div class="report_notify_btn" btn="1">
                                <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                    <g>
                                        <path d="M22 10.882a1 1 0 0 1-1-1c0-2.805-1.092-5.441-3.075-7.425a.999.999 0 1 1 1.414-1.414A12.418 12.418 0 0 1 23 9.882a1 1 0 0 1-1 1zM2 10.882a1 1 0 0 1-1-1c0-3.339 1.3-6.478 3.661-8.839a.999.999 0 1 1 1.414 1.414A10.432 10.432 0 0 0 3 9.882a1 1 0 0 1-1 1zM21.379 16.913A6.698 6.698 0 0 1 19 11.788V9c0-3.519-2.614-6.432-6-6.92V1a1 1 0 1 0-2 0v1.08C7.613 2.568 5 5.481 5 9v2.788a6.705 6.705 0 0 1-2.388 5.133A1.752 1.752 0 0 0 3.75 20h16.5c.965 0 1.75-.785 1.75-1.75 0-.512-.223-.996-.621-1.337zM12 24a3.756 3.756 0 0 0 3.674-3H8.326A3.756 3.756 0 0 0 12 24z"></path>
                                    </g>
                                </svg>
                                <div class="report_notify_text">
                                    <span class="notify_btn_title">Уведомления</span>
                                    <span class="notify_btn_desc">Получать новые репорты</span>
                                </div>
                            </div>
                        HTML;
                        break;
                    }
                }
            }
        }
        
        return ['noty' => $noty];
    }
    
    public function NotyChange($POST) {
        if (empty(array_filter($POST))) {
            return ['status' => 'error', 'text' => 'В массиве не хватает данных!'];
        } else {
            $param = [
                "work" => $POST['btn'],
                "steama" => $_SESSION['steamid64'],
            ];
            $this->Db->queryAll('Reports', 0, 0, "UPDATE `rs_admins` SET `working` = :work WHERE `steamid` = :steama", $param);
    
            if ($POST['btn'] == 1) {
                return ['status' => 'success', 'text' => 'Вы включили уведомления!'];
            } else {
                return ['status' => 'success', 'text' => 'Вы выключили уведомления!'];
            }
        }
    }    

    public function PutApiReport() {
        $info = $this->ReportsList(2, 2, '', '', $this->rid);
        $data = $this->ApiCore->GetTimeCreatedAcc($info['steamid_intruder']);
        $data2 = $this->ApiCore->GetBanPlayer($info['steamid_intruder']);
        $data3 = $this->ApiCore->GetTimePlayCS2($info['steamid_intruder']);
        $time = !empty($data) ? date('d.m.Y', $data) : 'Неизвестно';
        $playtime = !empty($data3) ? $data3 : 'Неизвестно';
        $bans = '';
        $bansdata = '';
        if (!empty($data2) && !empty(Core::GetCache('settings')['blockdb_apikey'])) {
            foreach ($data2 as $key) {
                $ctime = date('d.m.Y', $key['created_at']);
                $pname = $key['project_name'];
                $reason = $key['reason'];
                $bansdata .= <<<HTML
                <div class="blockdb_item">
                    <span>
                        <li>{$ctime}</li>
                        <li>Проект: {$pname}</li>
                    </span>
                    <span>
                        <li>Причина</li>
                        <li class="blockdb_reason">{$reason}</li>
                    </span>
                </div>
                HTML;
            }
        }
        if (!empty($data2) && !empty(Core::GetCache('settings')['blockdb_apikey'])) {
            $bans = <<<HTML
                <div class="report_intruder_blockdb">
                    <svg x="0" y="0" viewBox="0 0 100 100" xml:space="preserve">
                        <g>
                            <path d="M50 2.5C23.766 2.5 2.5 23.766 2.5 50S23.766 97.5 50 97.5 97.5 76.234 97.5 50 76.234 2.5 50 2.5zM14.375 50c.017-19.675 15.98-35.611 35.656-35.594a35.625 35.625 0 0 1 20.631 6.604c-.118.104-.252.178-.37.297L21.306 70.291c-.119.12-.193.253-.297.372A35.402 35.402 0 0 1 14.375 50zM50 85.625a35.402 35.402 0 0 1-20.662-6.635c.118-.104.252-.178.37-.297l48.985-48.984c.119-.12.193-.253.297-.371C90.4 45.365 86.66 67.609 70.632 79.02A35.625 35.625 0 0 1 50 85.625z"></path>
                        </g>
                    </svg>
                    Баны игрока в CS2
                </div>
                <div class="blockdb_list">
                    {$bansdata}
                </div>
            HTML;
        }

        return ['string' => $time, 'bans' => $bans, 'string2' => $playtime];
    }

    public function PutStatusReport() {
        $info = $this->ReportsList(2, 2, '', '', $this->rid);
        $steam = $info['steamid_admin_verdict'];
        $name = empty($info['name_admin_verdict']) ? action_text_clear($this->General->checkName($info['steamid_admin_verdict'])) : $info['name_admin_verdict'];
        $timeverdict = date('d.m, H:i', $info['time_verdict']);
        $timetake = date('d.m, H:i', $info['time_take']);
        $verdict = $info['verdict'];
        $html = '';
        $form = '';
        $btn = '';
        $connect = '';
        if ($info['steamid_admin_verdict'] && $info['status'] == 0 && $info['steamid_admin_verdict'] == $_SESSION['steamid64'] ) {
            $btn = <<<HTML
                <div class="report_deny_buton btn_click" btn="0">Отказаться</div>
            HTML;
            $connect = <<<HTML
                Присоединиться к серверу
                <svg viewBox="0 0 384 512">
                    <path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"></path>
                </svg>
            HTML;
        } elseif (!$info['steamid_admin_verdict'] && $info['status'] == 0) {
            $btn = <<<HTML
                <div class="report_accept_buton btn_click" btn="1">Взяться за репорт</div>
            HTML;
        }
        if (!$info['steamid_admin_verdict'] && $info['status'] == 0) {
            $html = <<<HTML
                <div class="report_status report_not_reviewed">
                    <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                        <g>
                            <path d="m14.828 12 5.303-5.303a1.5 1.5 0 0 0 0-2.121l-.707-.707a1.5 1.5 0 0 0-2.121 0L12 9.172 6.697 3.868a1.5 1.5 0 0 0-2.121 0l-.708.707a1.5 1.5 0 0 0 0 2.121L9.172 12l-5.303 5.303a1.5 1.5 0 0 0 0 2.121l.707.707a1.5 1.5 0 0 0 2.121 0L12 14.828l5.303 5.303a1.5 1.5 0 0 0 2.121 0l.707-.707a1.5 1.5 0 0 0 0-2.121z"></path>
                        </g>
                    </svg>
                    Не рассмотрен
                </div>
            HTML;
        } elseif ($info['steamid_admin_verdict'] && $info['status'] == 1) {
            $html = <<<HTML
                <div class="report_status report_reviewed">
                    <svg x="0" y="0" viewBox="0 0 511.985 511.985" xml:space="preserve">
                        <g>
                            <path d="M500.088 83.681c-15.841-15.862-41.564-15.852-57.426 0L184.205 342.148 69.332 227.276c-15.862-15.862-41.574-15.862-57.436 0-15.862 15.862-15.862 41.574 0 57.436l143.585 143.585c7.926 7.926 18.319 11.899 28.713 11.899 10.394 0 20.797-3.963 28.723-11.899l287.171-287.181c15.862-15.851 15.862-41.574 0-57.435z"></path>
                        </g>
                    </svg>
                    Рассмотрен
                </div>
                <div class="report_status_text">
                    <span>
                        <li>Админ:</li>
                        <li><a href="/profiles/{$steam}?search=1">{$name}</a></li>
                    </span>
                    <span>
                        <li>STEAMID:</li>
                        <li class="copy_steamid_admin copybtn" data-clipboard-text="{$steam}">{$steam}
                            <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                <g>
                                    <path d="M5.452 22h9.096c1.748 0 3.182-1.312 3.406-3h.594A3.456 3.456 0 0 0 22 15.548V5.452A3.456 3.456 0 0 0 18.548 2H9.452A3.456 3.456 0 0 0 6 5.452V6h-.548A3.456 3.456 0 0 0 2 9.452v9.096A3.456 3.456 0 0 0 5.452 22zM8 5.452C8 4.652 8.651 4 9.452 4h9.096c.8 0 1.452.651 1.452 1.452v10.096c0 .8-.651 1.452-1.452 1.452H18V9.452A3.456 3.456 0 0 0 14.548 6H8zm-4 4C4 8.652 4.651 8 5.452 8h9.096c.8 0 1.452.651 1.452 1.452v9.096c0 .8-.651 1.452-1.452 1.452H5.452C4.652 20 4 19.349 4 18.548z"></path>
                                </g>
                            </svg>
                        </li>
                    </span>
                    <span>
                        <li>Рассмотрен:</li>
                        <li>{$timeverdict}</li>
                    </span>
                    <span>
                        <li>Вердикт:</li>
                        <li>{$verdict}</li>
                    </span>
                </div>
            HTML;
        } elseif ($info['steamid_admin_verdict'] && $info['status'] == 0) {
            $html = <<<HTML
                <div class="report_status report_in_reviewed">
                    <svg x="0" y="0" viewBox="0 0 26.349 26.35" xml:space="preserve">
                        <g>
                            <circle cx="13.792" cy="3.082" r="3.082"></circle>
                            <circle cx="13.792" cy="24.501" r="1.849"></circle>
                            <circle cx="6.219" cy="6.218" r="2.774"></circle>
                            <circle cx="21.365" cy="21.363" r="1.541"></circle>
                            <circle cx="3.082" cy="13.792" r="2.465"></circle>
                            <circle cx="24.501" cy="13.791" r="1.232"></circle>
                            <path d="M4.694 19.84a2.155 2.155 0 0 0 0 3.05 2.155 2.155 0 0 0 3.05 0 2.155 2.155 0 0 0 0-3.05 2.146 2.146 0 0 0-3.05 0z"></path>
                            <circle cx="21.364" cy="6.218" r=".924"></circle>
                        </g>
                    </svg>
                    На рассмотрении
                </div>
                <div class="report_status_text">
                    <span>
                        <li>Админ:</li>
                        <li><a href="/profiles/{$steam}?search=1">{$name}</a></li>
                    </span>
                    <span>
                        <li>STEAMID:</li>
                        <li class="copy_steamid_admin copybtn" data-clipboard-text="{$steam}">{$steam}
                            <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                                <g>
                                    <path d="M5.452 22h9.096c1.748 0 3.182-1.312 3.406-3h.594A3.456 3.456 0 0 0 22 15.548V5.452A3.456 3.456 0 0 0 18.548 2H9.452A3.456 3.456 0 0 0 6 5.452V6h-.548A3.456 3.456 0 0 0 2 9.452v9.096A3.456 3.456 0 0 0 5.452 22zM8 5.452C8 4.652 8.651 4 9.452 4h9.096c.8 0 1.452.651 1.452 1.452v10.096c0 .8-.651 1.452-1.452 1.452H18V9.452A3.456 3.456 0 0 0 14.548 6H8zm-4 4C4 8.652 4.651 8 5.452 8h9.096c.8 0 1.452.651 1.452 1.452v9.096c0 .8-.651 1.452-1.452 1.452H5.452C4.652 20 4 19.349 4 18.548z"></path>
                                </g>
                            </svg>
                        </li>
                    </span>
                    <span>
                        <li>Взят на рассмотрение</li>
                        <li>{$timetake}</li>
                    </span>
                </div>
            HTML;
            $verdictfor = '';
            foreach (Core::GetCache('verdictdone') as $key) {
                $verdictfor .= '<div class="verdict_btn" data-verdict="' . $key['verdict'] . '">' . $key['verdict'] . '</div>';
            }
            if ($info['steamid_admin_verdict'] == $_SESSION['steamid64']) {
                $form = <<<HTML
                    <div class="report_badge">
                        Вердикт
                    </div>
                    <div class="report_verdict">
                        <div class="report_verdict_btns">
                            {$verdictfor}
                        </div>
                        <hr>
                        <div class="custom_verdict input-form">
                            <label for="verdict" class="input_text">Укажите свой вердикт, если необходимо</label>
                            <textarea autocomplete="off" id="verdict" name="verdict" minlength="5" placeholder="Если ваш вердикт не совпадает с заготовленными, то вы можете написать его здесь"></textarea>
                        </div>
                        <hr>
                        <div class="verdict_description">
                        <svg x="0" y="0" viewBox="0 0 286.054 286.054" xml:space="preserve"><g><path d="M143.027 0C64.04 0 0 64.04 0 143.027c0 78.996 64.04 143.027 143.027 143.027 78.996 0 143.027-64.022 143.027-143.027C286.054 64.04 222.022 0 143.027 0zm0 259.236c-64.183 0-116.209-52.026-116.209-116.209S78.844 26.818 143.027 26.818s116.209 52.026 116.209 116.209-52.026 116.209-116.209 116.209zm.009-196.51c-10.244 0-17.995 5.346-17.995 13.981v79.201c0 8.644 7.75 13.972 17.995 13.972 9.994 0 17.995-5.551 17.995-13.972V76.707c-.001-8.43-8.001-13.981-17.995-13.981zm0 124.997c-9.842 0-17.852 8.01-17.852 17.86 0 9.833 8.01 17.843 17.852 17.843s17.843-8.01 17.843-17.843c-.001-9.851-8.001-17.86-17.843-17.86z"></path></g></svg>
                        Перед закрытием репорта обязательно выдайте предупреждение или наказание нарушителю, если требуется.</div>
                        <div class="verdict_action_buttons">
                            <button class="secondary_btn verdict_warn">Выдать предупреждение</button>
                            <button onclick="window.open('/managersystem', '_blank')" class="secondary_btn verdict_punish">Выдать наказание</button>
                            <button class="secondary_btn verdict_do">Закрыть репорт</button>
                        </div>
                    </div>
                HTML;
            }
        }

        return ['html' => $html, 'form' => $form, 'btn' => $btn, 'connect' => $connect];
    }

    public function PutOptionalInfo() {
        $info = $this->ReportsList(2, 2, '', '', $this->rid);
        $data = $this->GetWarn($info['steamid_intruder']);
        $warns_pred = 0;
        $warns_res = '';
        foreach ($data as $key) {
            $warns_pred += $key['count'];
            $reason = $this->ReportsList(2, 2, '', '', $key['rid'])['reason'];
            $warns_res .= '<li>' . action_text_clear($reason) . '</li>';
        }
    
        $warns = '';
        if (!empty($data)) {
            $warns = <<<HTML
                {$warns_res}
            HTML;
        }
    
        return ['warns' => $warns, 'warns_num' => $warns_pred];
    }    
    
    public function GetWarn($steam = '', $sort = 1, $rid = '') {
        if ($sort == 1) {
            $param = [
                "steam" => $steam
            ];
            return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_warns` WHERE `steamid` = :steam", $param);
        } elseif ($sort == 2) {
            $param = [
                "rid" => $rid
            ];
            return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_warns` WHERE `rid` = :rid", $param);
        }
        
    }

    public function GetMessage($rid) {
        $param = [
            "rid" => $rid
        ];
        return $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_chatlogging` WHERE `rid` = :rid", $param);
    }

    public function ClickBtnStatus($POST) {
        if (empty(array_filter($POST))) {
            return ['status' => 'error', 'text' => 'В массиве не хватает данных!'];
        } else {
            if ($POST['btn'] == 0) {
                $param = [
                    "id" => $this->rid,
                ];
                $this->Db->query('Reports', 0, 0, "UPDATE `rs_reports` SET `steamid_admin_verdict` = NULL, `name_admin_verdict` = NULL, `time_take` = NULL WHERE `id` = :id LIMIT 1", $param);
                $result = Core::Rcons('mm_rsr_cs ' . $this->rid);
                if ($result['status'] == 'success') {
                    return ['status' => 'success', 'text' => 'Вы отказались от репорта!'];
                } else {
                    return ['status' => $result['status'], 'text' => $result['text']];
                }
            }
            if ($this->ReportsList(2, 2, '', '', $this->rid)['time_take'] == NULL) {
                if (empty(count($this->ReportsList(1, 5)))) {
                    if ($POST['btn'] == 1) {
                        $param = [
                            "id" => $this->rid,
                            "steama" => $_SESSION['steamid64'],
                            "time" => time(),
                            "namea" => $this->General->checkName($_SESSION['steamid64']),
                        ];
                        $this->Db->query('Reports', 0, 0, "UPDATE `rs_reports` SET `steamid_admin_verdict` = :steama, `name_admin_verdict` = :namea, `time_take` = :time WHERE `id` = :id LIMIT 1", $param);
                        $result = Core::Rcons('mm_rsr_cs ' . $this->rid);
                        if ($result['status'] == 'success') {
                            return ['status' => 'success', 'text' => 'Вы успешно взяли репорт!'];
                        } else {
                            return ['status' => $result['status'], 'text' => $result['text']];
                        }
                    }
                } else {
                    return ['status' => 'error', 'text' => 'У вас уже есть активный репорт!'];
                }
            } else {
                return ['status' => 'error', 'text' => 'Этот репорт уже рассматривается!'];
            }
        }
    }

    public function WarnAdd() {
        $info = $this->ReportsList(2, 2, '', '', $this->rid);
        $data = $this->GetWarn('', 2, $info['id']);
        if (empty(count($data))) {
            $param = [
                "rid" => $info['id'],
                "steam" => $info['steamid_intruder'],
                "count" => 1,
                "sid" => $info['sid']
            ];
            $this->Db->query('Reports', 0, 0, "INSERT INTO `rs_warns` (`steamid`, `count`, `rid`, `time`, `sid`) VALUES (:steam, :count, :rid, " . time() . ", :sid)", $param);
            $result = Core::Rcons('mm_rsw_reload');
            if ($result['status'] == 'success') {
                return ['status' => 'success', 'text' => 'Вы успешно выдали предупреждение!'];
            } else {
                return ['status' => $result['status'], 'text' => $result['text']];
            }            
        } else {
            if ($data[0]['count'] < Core::GetCache('settings')['max_warn']) {
                $param = [
                    "rid" => $info['id'],
                    "sid" => $info['sid']
                ];
                $this->Db->query('Reports', 0, 0, "UPDATE `rs_warns` SET `count` = `count` + 1, `time` = " . time() . ", `sid` = :sid WHERE `rid` = :rid LIMIT 1", $param);
                $result = Core::Rcons('mm_rsw_reload');
                if ($result['status'] == 'success') {
                    return ['status' => 'success', 'text' => 'Вы успешно выдали предупреждение!'];
                } else {
                    return ['status' => $result['status'], 'text' => $result['text']];
                }    
            } else {
                return ['status' => 'error', 'text' => 'Вы выдали максимальное кол-во предупреждений на этот репорт!'];
            }
        }
    }

    public function UpdateReportWarn() {
        $updatefile = MODULES . 'module_page_reports/temp/warn_update_status.php';
        $updatedata = require $updatefile;
        
        if (!$updatedata['update_needed'] && (time() - $updatedata['last_update']) < Core::GetCache('settings')['warn_update_status']) {
            return;
        }

        $warn = $this->Db->queryAll('Reports', 0, 0, "SELECT * FROM `rs_warns`");
        
        foreach ($warn as $w) {
            if ((time() - $w['time']) > Core::GetCache('settings')['life_time_warn']) {
                $this->Db->query('Reports', 0, 0, "DELETE FROM `rs_warns` WHERE `time` = {$w['time']}");
            }
        }

        $updatedata = [
            'last_update' => time(),
            'update_needed' => false
        ];
        file_put_contents($updatefile, '<?php return ' . var_export_min($updatedata, true) . ';');
    }
    
    public function SetWarnUpdate() {
        $updatefile = MODULES . 'module_page_reports/temp/warn_update_status.php';
        
        $updatedata = require $updatefile;
        $updatedata['update_needed'] = true;
        file_put_contents($updatefile, '<?php return ' . var_export_min($updatedata, true) . ';');
        return ['status' => 'success', 'text' => 'Удаление истекших варнов запущено!']; 
    }

    public function VerdictTo($POST) {
        if (empty(array_filter($POST))) {
            return ['status' => 'error', 'text' => 'В массиве не хватает данных!'];
        } else {
            $param = [
                "verdict" => $POST['verdict'],
                "id" => $this->rid,
                "status" => 1,
                "time" => time(),
                "name" => $this->General->checkName($_SESSION['steamid64']),
            ];
            if (strlen($POST['verdict']) < 5) {
                return ['status' => 'error', 'text' => 'Пожалуйста, укажите вердикт не менее 5 символов'];
            } else {
                $this->Db->query('Reports', 0, 0, "UPDATE `rs_reports` SET `time_verdict` = :time, `verdict` = :verdict, `name_admin_verdict` = :name, `status` = :status WHERE `id` = :id LIMIT 1", $param);
                $info = $this->ReportsList(2, 2, '', '', $this->rid);
                $this->Notifications->SendNotification(
                    $info['steamid_sender'],
                    '_Report',
                    '_ReportNotyText2',
                    ['module_translation' => 'module_page_reports', 'name' => action_text_clear($info['name_intruder']), 'verdict' => $POST['verdict']],
                    '',
                    'reports',
                    ''
                );
                $result = Core::Rcons('mm_rsr_cs ' . $this->rid);
                if ($result['status'] == 'success') {
                    return ['status' => 'success', 'text' => 'Вы успешно закрыли репорт!'];
                } else {
                    return ['status' => $result['status'], 'text' => $result['text']];
                }
            }
        }
    }

    public function CheckBan($steam) {
        if (!empty($this->Db->db_data['AdminSystem'])) {
            return $this->Db->queryAll('AdminSystem', 0, 0, "SELECT * FROM `as_punishments` WHERE `steamid` = :steam AND (`expires` = 0 OR `expires` > UNIX_TIMESTAMP()) AND `unpunish_admin_id` IS NULL AND `punish_type` = 0", ['steam' => $steam]);
        }
    }

    public function getAdminID($id){
        if (!empty($this->Db->db_data['AdminSystem'])) {
            return $this->Db->query('AdminSystem', 0, 0, "SELECT * FROM `as_admins` WHERE `id` = :id", ['id' => $id]);
        }
    }

    public function UpdateReportBan() {
        $updatefile = MODULES . 'module_page_reports/temp/ban_update_status.php';
        $updatedata = require $updatefile;
        
        if (!$updatedata['update_needed'] && (time() - $updatedata['last_update']) < Core::GetCache('settings')['update_time_status']) {
            return;
        }
    
        $reports = $this->Db->queryAll('Reports', 0, 0, "SELECT `id`, `steamid_intruder` FROM `rs_reports` WHERE `status` != 1");
        $steams = array_column($reports, 'steamid_intruder', 'id');
        
        if (empty($steams)) {
            return;
        }
    
        foreach ($steams as $id => $steam) {
            $baninfo = $this->CheckBan($steam);
            if (count($baninfo) > 0) {
                $admininfo = $this->getAdminID($baninfo[0]['admin_id']);
                $param = [
                    "verdict" => "Нарушитель наказан",
                    "time" => time(),
                    "status" => 1,
                    "sa" => $admininfo['steamid'],
                    "na" => $admininfo['name'],
                    "s" => $steam
                ];
                $this->Db->query('Reports', 0, 0, "UPDATE `rs_reports` SET `status` = :status, `time_take` = :time, `verdict` = :verdict, `time_verdict` = :time, `steamid_admin_verdict` = :sa, `name_admin_verdict` = :na WHERE `steamid_intruder` = :s AND `status` != 1", $param);
                Core::Rcons('mm_rsr_cs ' . $id);
            }
        }
    
        $updatedata = [
            'last_update' => time(),
            'update_needed' => false
        ];
        file_put_contents($updatefile, '<?php return ' . var_export_min($updatedata, true) . ';');
    }    
    
    public function SetBanUpdate() {
        $updatefile = MODULES . 'module_page_reports/temp/ban_update_status.php';
        
        $updatedata = require $updatefile;
        $updatedata['update_needed'] = true;
        file_put_contents($updatefile, '<?php return ' . var_export_min($updatedata, true) . ';');
        return ['status' => 'success', 'text' => 'Закрытие репортов с банами запущено!']; 
    }

    public function GetPlayTime($steam) {
        $totalTime = 0;
        for ($d = 0; $d < $this->Db->table_count['LevelsRanks']; $d++) {
            $query = "SELECT `playtime` FROM " . $this->Db->db_data['LevelsRanks'][$d]['Table'] . " WHERE `steam` LIKE '%" . con_steam32($steam) . "%'";
            $play = $this->Db->query('LevelsRanks', $this->Db->db_data['LevelsRanks'][$d]['USER_ID'], $this->Db->db_data['LevelsRanks'][$d]['DB_num'], $query);
            foreach ($play as $row) {
                $totalTime += $row;
            }
        }
        return round($totalTime/60/60);
    }
}
<?php
namespace app\modules\module_page_referral\ext;
use app\modules\module_page_referral\ext\log;

class Request
{
    protected $Db, $General, $Translate, $Modules;

    public function __construct($Db, $General, $Translate, $Modules, $Notifications)
    {
        $this->Db = $Db;
        $this->General = $General;
        $this->Translate = $Translate;
        $this->Modules = $Modules;
        $this->Notifications = $Notifications;
    }

    public function getReferralOutput($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $result = $this->Db->queryAll("Core", 0, 0, "SELECT o.*, u.steam_id, u.referral FROM lvl_web_referrals_output o LEFT JOIN lvl_web_referrals_users u ON o.referral_id = u.id ORDER BY o.id DESC LIMIT $offset, $perPage");
        $total = $this->Db->query('Core', 0, 0, "SELECT COUNT(*) as count FROM lvl_web_referrals_output")['count'];
        $pageMax = ceil($total / $perPage);
        
        return [
            'data' => $result ?: [],
            'total' => $total,
            'page_num' => $page,
            'page_max' => $pageMax,
            'per_page' => $perPage
        ];
    }

    public function DeleteRequest($POST)
    {
        $requestId = $POST['id_del'];
        $this->Db->queryAll("Core", 0, 0, "DELETE FROM lvl_web_referrals_output WHERE id = :id", ['id' => $requestId]);
        
        return ['status' => 'success','text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_RequestDeletedSuccessfully')];
    }

    public function updateRequestStatus($POST)
    {
        $requestId = $POST['request_id'] ?? 0;
        $action = $POST['action'] ?? '';
        $reason = $POST['reason'] ?? '';
        if (!in_array($action, ['accept', 'declined'])) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_InvalidAction')];
        }
    
        $status = ($action === 'accept') ? 'accepted' : 'declined';
        $RefSuccessMessage = $this->Translate->get_translate_module_phrase('module_page_referral', '_RefSuccessMessage');
        $notificationReason = ($status === 'accepted') ? $RefSuccessMessage : "отклонен причина: " . $reason;
        $this->Db->query('Core', 0, 0, "UPDATE lvl_web_referrals_output SET status = :status, reason = :reason WHERE id = :id",
        ['status' => $status, 'reason' => $reason, 'id' => $requestId]);
    
        $request = $this->Db->query('Core', 0, 0, "SELECT referral_id, cash FROM lvl_web_referrals_output WHERE id = :id", ['id' => $requestId]);
        
        $this->Db->query('Core', 0, 0, "UPDATE lvl_web_referrals_users SET money_transfer_now = money_transfer_now - :amount WHERE id = :id",
        ['amount' => $request['cash'], 'id' => $request['referral_id']]);
    
        if ($action === 'declined') {
            if ($request) {
                $commission = $this->Db->query('Core', 0, 0, "SELECT commission_output FROM lvl_web_referrals_settings")['commission_output'] ?? 0;
    
                $originalAmount = round($request['cash'] / (1 - ($commission / 100)), 0);
    
                $this->Db->query('Core', 0, 0, 
                    "UPDATE lvl_web_referrals_users SET money = money + :amount WHERE id = :id",
                    ['amount' => $originalAmount, 'id' => $request['referral_id']]
                );
            }
        }
    
        $userData = $this->Db->query('Core', 0, 0, "SELECT steam_id FROM lvl_web_referrals_users WHERE id = :id", ['id' => $request['referral_id']]);
        $steamId = $userData['steam_id'] ?? 0;
        
        $this->Notifications->SendNotification($steamId, '_RefPageName', '_RefReason', ['reason' => $notificationReason, 'module_translation' => 'module_page_referral' ], '', 'ms', '_Go');
    
        $log = new log($this->Db, $this->General, $this->Translate, $this->Modules, $this->Notifications);
        if ($action === 'accept') {
            $log->writeLog("Заявка #{$requestId} успешно выплачена", 'success');
        } else {
            $log->writeLog("Заявка #{$requestId} была отклонена", 'success');
            $log->writeLog("Причина: {$reason}", 'success');
            if ($request) {
                $log->writeLog("Возвращено средств: {$originalAmount}", 'success');
            }
        }
    
        return ['status' => 'success', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_RequestUpdatedSuccessfully')];
    }


    public function getReferralInfo($POST)
    {
        $requestId = $POST['request_id'] ?? 0;
        $request = $this->Db->query('Core', 0, 0, "SELECT o.*, u.steam_id FROM lvl_web_referrals_output o LEFT JOIN lvl_web_referrals_users u ON o.referral_id = u.id WHERE o.id = :id", 
        ['id' => $requestId]);
        if (!$request) {
            return ['status' => 'error', 'text' => $this->Translate->get_translate_module_phrase('module_page_referral', '_RequestNotFound')];
        }
        $requestDate = date('d.m.Y H:i', $request['create_date']);
        $statusText = '';
        $statusSvg = '';
        switch ($request['status']) {
            case 'pending':
                $statusText = $this->Translate->get_translate_module_phrase('module_page_referral', '_Pending');
                $statusSvg = <<<SVG
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
                SVG;
                break;
            case 'declined':
                $statusText = $this->Translate->get_translate_module_phrase('module_page_referral', '_Declined');
                $statusSvg = <<<SVG
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                SVG;
                break;
            case 'accepted':
                $statusText = $this->Translate->get_translate_module_phrase('module_page_referral', '_Accepted');
                $statusSvg = <<<SVG
                    <svg x="0" y="0" viewBox="0 0 511.985 511.985" xml:space="preserve"><g><path d="M500.088 83.681c-15.841-15.862-41.564-15.852-57.426 0L184.205 342.148 69.332 227.276c-15.862-15.862-41.574-15.862-57.436 0-15.862 15.862-15.862 41.574 0 57.436l143.585 143.585c7.926 7.926 18.319 11.899 28.713 11.899 10.394 0 20.797-3.963 28.723-11.899l287.171-287.181c15.862-15.851 15.862-41.574 0-57.435z"></path></g></svg>
                SVG;
                break;
        }
        $inputBlock = '';
        if ($request['status'] == 'pending') {
            $inputBlock = <<<HTML
            <div class="input-form ref-input-modal">
                <input type="text" name="reason" placeholder="{$this->Translate->get_translate_module_phrase('module_page_referral', '_DeclinedReason')}">
                <div class="modal-footer">
                    <a type="button" class="secondary_btn w100 btn-success" onclick="processRequest('accept')">{$this->Translate->get_translate_module_phrase('module_page_referral', '_Accept')}</a>
                    <a type="button" class="secondary_btn w100 btn-danger" onclick="processRequest('declined')">{$this->Translate->get_translate_module_phrase('module_page_referral', '_Declined')}</a>
                </div>
            </div>
            HTML;
        } elseif ($request['status'] == 'declined') {
            $reason = htmlspecialchars($request['reason'] ?? '');
            $inputBlock = <<<HTML
            <div class="input-form ref-input-modal">
                <input type="text" name="reason" placeholder="{$this->Translate->get_translate_module_phrase('module_page_referral', '_DeclinedReason')}" value="{$reason}" readonly>
            </div>
            HTML;
        }
        $html = <<<HTML
        <div class="popup_modal_content">
            <div class="popup_modal_head">
                <div>{$this->Translate->get_translate_module_phrase('module_page_referral', '_ViewRequest')} #{$requestId}</div>
                <span class="popup_modal_close">
                    <svg viewBox="0 0 320 512">
                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                    </svg>
                </span>
            </div>
            <div class="modal-body">
                <div class="modal-content-block">
                    <div class="modal-conteiner-flex">
                        <div class="modal-ref-w100">
                            <div class="stat-item"><h4>{$this->Translate->get_translate_module_phrase('module_page_referral', '_WithdrawalType')}</h4> <h2>{$request['type']}</h2></div>
                        </div>
                        <div class="modal-ref-w100">
                            <div class="stat-item color-money w200"><h4>{$this->Translate->get_translate_module_phrase('module_page_referral', '_Amount')}</h4> <h2>{$request['cash']}₽</h2></div>
                        </div>
                        <div class="modal-ref-w100">
                            <div class="stat-item"><h3>{$this->Translate->get_translate_module_phrase('module_page_referral', '_Date')}</h3><h4>{$requestDate}</h4></div>
                        </div>
                    </div>
                    <div class="modal-conteiner-flex">
                        <div class="modal-text-flex">
                            <div><strong>{$this->Translate->get_translate_module_phrase('module_page_referral', '_Details')}:</strong> {$request['details']}</div>
                        </div>
                        <div class="modal-status-ref modal-ref-{$request['status']}">
                            {$statusText}
                            {$statusSvg}
                        </div>
                    </div>
                </div>
            </div>
            <form>
                {$inputBlock}
            </form>
        </div>
        HTML;
        
        return ['status' => 'success', 'html' => $html];
    }
}
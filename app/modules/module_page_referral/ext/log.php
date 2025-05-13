<?php
namespace app\modules\module_page_referral\ext;

class log
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
    public function writeLog($message, $logType = 'info')
    {
        $logDir = __DIR__ . '/../../../logs/referral/';
        
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logFile = $logDir . date('d-m-Y') . '.txt';
        
        $logEntry = '[' . date('H:i:s') . '][' . strtoupper($logType) . '] ' . $message . PHP_EOL;
        
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }

}
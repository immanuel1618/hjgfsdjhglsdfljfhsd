<?php
namespace app\modules\module_page_store\ext\Controllers;

use app\modules\module_page_store\ext\Services\WebServerService;

class WebServerController
{
    private $service;

    public function __construct($Db, $Translate)
    {
        $this->service = new WebServerService($Db, $Translate);
    }

    public function getAll(): array
    {
        return $this->service->getAll();
    }
}

<?php
namespace app\modules\module_page_store\ext\Services;
use app\modules\module_page_store\ext\Repositories\LK\LkImpulseRepository;

class LkService
{
    private $Db;
    private $Translate;
    private $LkImpulseRep;

    public function __construct($Db, $Translate)
    {
        $this->Db = $Db;
        $this->Translate = $Translate;
        $this->LkImpulseRep = new LkImpulseRepository($this->Db, $this->Translate);
    }

    public function getBalanceForCurrentUser(): int
    {
        if(!isset($_SESSION['steamid32'])){
            return 0;
        }

        preg_match('/:[0-9]{1}:\d+/i', $_SESSION['steamid32'], $auth);

        return $this->LkImpulseRep->getBalanceByAuth('%'.$auth[0].'%');
    }

    public function updateBalanceByCurrentUser(int $decreaseValue): bool
    {
        if(!isset($_SESSION['steamid32'])){
            return false;
        }

        preg_match('/:[0-9]{1}:\d+/i', $_SESSION['steamid32'], $auth);

        $currentBalance = $this->getBalanceForCurrentUser();

        return $this->LkImpulseRep->updateBalanceByAuth('%'.$auth[0].'%', $currentBalance - $decreaseValue);
    }
}

<?php
namespace app\modules\module_page_store\ParameterObjects;

class Pagination
{
    private $page;
    private $perPage;

    public function __construct(int $page = 1, int $perPage = 30)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    public function __get(string $property): int
    {
        return $this->$property;
    }
}

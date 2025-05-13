<?php
namespace app\modules\module_page_store\ext\Services;

use app\modules\module_page_store\ext\ErrorLog;
use app\modules\module_page_store\ext\Repositories\OptionPriceRepository;

class OptionPriceService
{
    private $rep;

    public function __construct($Db, $Translate)
    {
        $this->rep = new OptionPriceRepository($Db, $Translate);
    }

    public function getAll(): array
    {
        $items = $this->rep->getAll();

        $result = [];
        foreach ($items as $item) {
            $item['options'] = json_decode($item['options'], true);
            $result[$item['product_id']][] = $item;
        }

        return $result;
    }

    public function getById(int $id): array
    {
        $result = $this->rep->getById($id);

        if (empty($result[0])) {
            ErrorLog::add(new \Exception("Не удалось найти настройки цены по переданному ID: $id"));
            return [];
        }

        $result[0]['options'] = json_decode($result[0]['options'], true);

        return $result[0];
    }

    public function GetByProductId(int $id): array
    {
        $items = $this->rep->GetByProductId($id);

        foreach ($items as $key => $item) {
            $items[$key]['options'] = json_decode($item['options'], true);
        }
        return $items;
    }

    public function findByIds(array $ids): array
    {
        $items = $this->rep->findByIds($ids);

        foreach ($items as $key => $item) {
            $items[$key]['options'] = json_decode($item['options'], true);
        }

        return $items;
    }

    public function create(array $fields): ?array
    {
        if (empty($fields = $this->prepareFields($fields))) {
            ErrorLog::add(new \Exception('Не удалось создать цену, так как неправильно указаны поля'));
            return null;
        }

        if (empty($result = $this->rep->create($fields))) {
            ErrorLog::add(new \Exception('Произошла ошибка при создании цены'));
            return null;
        }

        return $result;
    }

    public function updateById(int $id, array $fields): bool
    {
        if (empty($fields = $this->prepareFields($fields))) {
            ErrorLog::add(new \Exception('Не удалось обновить настройки цены, так как неправильно указаны поля'));
            return false;
        }

        return $this->rep->updateById($id, $fields);
    }

    public function deleteById(int $id): bool
    {
        return $this->rep->deleteById($id);
    }

    public function prepareFields(array $fields): array
    {
        if (isset($fields['product_id']) && isset($fields['price'])) {
            $result = [
                'product_id' => $fields['product_id'],
                'price' => $fields['price']
            ];

            if (!empty($fields['rcon']) && !empty($fields['title'])) {
                $result['options']['rcon'] = $fields['rcon'];
                $result['options']['all_servers'] = isset($fields['all_servers']) ? 1 : 0;
                $result['options']['title'] = $fields['title'];
                $result['options'] = json_encode($result['options']);

                return $result;
            }

            if (!empty($fields['amount']) && !empty($fields['amount_value'])) {
                $result['options']['amount'] = $fields['amount'];
                $result['options']['amount_value'] = $fields['amount_value'];
                $result['options'] = json_encode($result['options']);

                return $result;
            }

            if ($fields['time'] !== '' && !empty($fields['time_value']) && !empty($fields['group'])) {
                $result['options']['time'] = $fields['time'];
                $result['options']['group'] = $fields['group'];
                $result['options']['time_value'] = $fields['time_value'];

                if ($fields['web_group_id'] !== '') {
                    $result['options']['web_group_id'] = $fields['web_group_id'];
                }

                $result['options'] = json_encode($result['options']);

                return $result;
            }
        }

        return [];
    }
}

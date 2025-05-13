<?php
namespace app\modules\module_page_store\ext;

class Dictionary
{
    public static function get(string $type): array
    {
        return require MODULES . 'module_page_store/includes/dictionaries/dictionary_' . $type . '.php';
    }
}

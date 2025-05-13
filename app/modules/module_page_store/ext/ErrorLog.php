<?php

namespace app\modules\module_page_store\ext;

class ErrorLog
{
    public static function getErrors()
    {
        $file = MODULES . 'module_page_store/cache/errors.json';
        
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (!file_exists($file)) {
            file_put_contents($file, json_encode([]));
            $data = [];
        } else {
            $json_data = file_get_contents($file);
            $data = json_decode($json_data, true);
        }

        return $data;
    }

    public static function add(\Exception $error = null)
    {
        $errors = self::getErrors();

        $errors[] = [
            'steam' => $_SESSION['steamid'] ?? 'external_process',
            'text_exception' => $error->getMessage() ?? '',
            'code' => $error->getCode() ?? '',
            'file' => $error->getFile() ?? '',
            'line' => $error->getLine() ?? '',
            'date' => date("Y-m-d H:i:s")
        ];

        $jsonData = json_encode($errors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents(MODULES . 'module_page_store/cache/errors.json', $jsonData);
    }
}

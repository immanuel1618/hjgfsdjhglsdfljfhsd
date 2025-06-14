<?php
namespace app\modules\module_page_store\ext;

class Key
{
    const MAIN_KEY = 'license.key';
    const ENCRYPT_METHOD = "AES-192-CBC";

    public static function decodeSecret(string $keyName)
    {
        $encrypted = self::getByName($keyName);
        $privateKey = self::getByName(self::MAIN_KEY);

        if (!($decrypted = @openssl_decrypt($encrypted, self::ENCRYPT_METHOD, $privateKey, 0, $privateKey))) {
            ErrorLog::add(new \Exception('Произошла ошибка при дешифровании ключа'));

            return false;
        }

        return $decrypted;
    }

    public static function encodeSecret(string $keyName, string $secretKey): bool
    {
        $privateKey = self::getByName(self::MAIN_KEY);

        if (!($encrypted = @openssl_encrypt($secretKey, self::ENCRYPT_METHOD, $privateKey, 0, $privateKey))) {
            ErrorLog::add(new \Exception('Произошла ошибка при шифровании ключа'));

            return false;
        }

        if (!self::putByName($keyName, $encrypted)) {
            ErrorLog::add(new \Exception('Произошла ошибка при создании файла ключа'));

            return false;
        }

        return true;
    }

    public static function getByName(string $name): string
    {
        return file_get_contents(MODULES . 'module_page_store/data/' . $name);
    }

    public static function putByName(string $name, string $data): bool
    {
        return file_put_contents(MODULES . 'module_page_store/data/' . $name, $data);
    }

    public static function isExists(array $names): bool
    {
        foreach ($names as $name) {
            if (!file_exists(MODULES . 'module_page_store/data/' . $name)) {
                return false;
            }
        }

        return true;
    }

    public static function deleteByNames(array $names): bool
    {
        foreach ($names as $name) {
            if (self::isExists([$name]) && !unlink(MODULES . 'module_page_store/data/' . $name)) {
                return false;
            }
        }

        return true;
    }
}

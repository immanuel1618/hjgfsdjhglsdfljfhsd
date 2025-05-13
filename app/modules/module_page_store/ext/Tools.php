<?php

namespace app\modules\module_page_store\ext;

class Tools
{
    public const SHOP_URL = '/store/';

    public static function generateBillId()
    {
        $bytes = '';
        for ($i = 1; $i <= 16; $i++) {
            $bytes .= chr(mt_rand(0, 255));
        }

        $hash = bin2hex($bytes);

        return sprintf(
            '%08s-%04s-%04s-%02s%02s-%012s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            str_pad(dechex(hexdec(substr($hash, 12, 4)) & 0x0fff & ~(0xf000) | 0x4000), 4, '0', STR_PAD_LEFT),
            str_pad(dechex(hexdec(substr($hash, 16, 2)) & 0x3f & ~(0xc0) | 0x80), 2, '0', STR_PAD_LEFT),
            substr($hash, 18, 2),
            substr($hash, 20, 12)
        );

    }

    public static function getCurrentURL(): string
    {
        $url = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http';
        $url .= '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = explode('?', $url)[0];

        return $url;
    }

    public static function timestampByDays(int $days): int
    {
        return $days === 0 ? 0 : time() + $days * 24 * 60 * 60;
    }

    public static function getNicknameBySteam(string $steam): ?string
    {
        $options = require SESSIONS . '/options.php';
        
        $steam = con_steam32to64($steam);

        $apiKey = $options['web_key'];

        $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$apiKey&steamids=$steam";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        return isset($data['response']['players'][0]) ? $data['response']['players'][0]['personaname'] : null;
    }
}

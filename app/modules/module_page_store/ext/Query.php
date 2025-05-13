<?php

namespace app\modules\module_page_store\ext;

class Query
{
    const GET = 'GET';

    const POST = 'POST';

    public static function get(string $url, array $params, array $headers = [])
    {
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return self::query($url, self::GET, $headers, null);
    }

    public static function post(string $url, array $params, array $headers = [], bool $withoutJson = false)
    {
        return self::query($url, self::POST, $headers, $params, $withoutJson);
    }

    private static function query(string $url, string $method, array $headers, ?array $body, bool $withoutJson = false)
    {
        $curl = curl_copy_handle(curl_init());

        if (true !== empty($body) && self::GET !== $method) {
            $body    = json_encode($body, JSON_UNESCAPED_UNICODE);
            $headers = array_merge(
                $headers,
                [
                    'Content-Type: application/json;charset=UTF-8',
                    'Content-Length: '.strlen($body),
                ]
            );
        }

        curl_setopt_array(
            $curl,
            [
                CURLOPT_URL            => $url,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_CUSTOMREQUEST  => $method,
                CURLOPT_POSTFIELDS     => $body,
                CURLOPT_RETURNTRANSFER => 1,
            ]
        );

        $response = curl_exec($curl);

        if ($response) {
            return $withoutJson ? $response : json_decode($response, true);
        }

        return null;
    }
}
<?php


class API
{

    static string $_url = "http://localhost:5001";

    public static function fetch($uri = "/", $fields)
    {
        $url = API::$_url . $uri;

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        $body = http_build_query($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        return curl_exec($ch);
    }
}

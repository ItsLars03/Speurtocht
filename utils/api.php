<?php


class API
{

    static string $_url = "http://localhost:5001";

    public static function get($uri = "/", $fields)
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

        $result = curl_exec($ch);
        return gettype($result) == "string" ? json_decode($result) : null;
    }

    public static function post($uri = "/", $fields)
    {
        $url = API::$_url . $uri;

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        $body = http_build_query($fields);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        return gettype($result) == "string" ? json_decode($result) : null;
    }
}

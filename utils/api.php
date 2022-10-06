<?php


class API {

    static string $_url = "http://localhost:5001";

    public static function get($uri = "/", $fields) {
        $url = API::$_url . $uri;

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        $body = json_encode($fields);

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

    public static function post($uri = "/", $fields) {
        $url = API::$_url . $uri;

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        $body = json_encode($fields);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        return gettype($result) == "string" ? json_decode($result) : null;
    }

    public static function postFile($uri = "/", $fields = array(), $filePath, $type, $postedFileName) {
        $url = API::$_url . $uri;

        $image = new CURLFile($filePath, $type, $postedFileName);
        $fields["image"] = $image;

        $headers = array(
            'Accept: application/json',
            'Content-Type: multipart/form-data',
        );


        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        return gettype($result) == "string" ? json_decode($result) : null;
    }

    public static function delete($uri = "/", $fields) {
        $url = API::$_url . $uri;

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        $body = json_encode($fields);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        return gettype($result) == "string" ? json_decode($result) : null;
    }

    public static function put($uri = "/", $fields) {
        $url = API::$_url . $uri;

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        $body = json_encode($fields);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        return gettype($result) == "string" ? json_decode($result) : null;
    }
}
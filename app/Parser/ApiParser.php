<?php

require 'Parser.php';

abstract class ApiParser implements Parser
{
    public function requestAPI($url, $method, $data = false)
    {
        $curl = curl_init();
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array("Content-type: application/json"));
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;

            case "GET":
                if (!empty(json_decode(file_get_contents($url), false))) {
                    return json_decode(file_get_contents($url), false);
                }
                break;

        }
        $response = curl_exec($curl);
        if ($response === false) {
            throw new Exception(curl_error($curl), curl_errno($curl));
        }
        curl_close($curl);
        return json_decode($response, false);
    }

    abstract function parse();
}
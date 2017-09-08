<?php

namespace GustavTrenwith\Curl;

/**
 * Class Curl
 * @package gustavtrenwith\curl
 * @author Gustav Trenwith <gtrenwith@gmail.com>
 */
class Curl
{
    /**
     * Performs a GET request
     * @param string $url The Fully Qualified Domain Name to send the request to
     * @param int $timeout In seconds
     * @param array $headers Additional data to be passed in the headers
     * @param array $auth Username and password to be passed as basic auth headers
     * @param string $userAgent
     * @return mixed
     */
    public static function get($url, $timeout = 30, $headers = [], $auth = [], $userAgent = "php-curl-client")
    {
        return self::send($url, [], "GET", $timeout, $headers, $auth, $userAgent);
    }

    /**
     * Performs a POST request
     * @param string $url The Fully Qualified Domain Name to send the request to
     * @param array $fields Data to send with the request
     * @param int $timeout In seconds
     * @param array $headers Additional data to be passed in the headers
     * @param array $auth Username and password to be passed as basic auth headers
     * @param string $userAgent
     * @return mixed
     */
    public static function post($url, $fields = [], $timeout = 30, $headers = [], $auth = [], $userAgent = "php-curl-client")
    {
        return self::send($url, $fields, "POST", $timeout, $headers, $auth, $userAgent);
    }

    /**
     * Performs a PUT request
     * @param string $url The Fully Qualified Domain Name to send the request to
     * @param array $fields Data to send with the request
     * @param int $timeout In seconds
     * @param array $headers Additional data to be passed in the headers
     * @param array $auth Username and password to be passed as basic auth headers
     * @param string $userAgent
     * @return mixed
     */
    public static function put($url, $fields = [], $timeout = 30, $headers = [], $auth = [], $userAgent = "php-curl-client")
    {
        return self::send($url, $fields, "PUT", $timeout, $headers, $auth, $userAgent);
    }

    /**
     * Performs a PATCH request
     * @param string $url The Fully Qualified Domain Name to send the request to
     * @param array $fields Data to send with the request
     * @param int $timeout In seconds
     * @param array $headers Additional data to be passed in the headers
     * @param array $auth Username and password to be passed as basic auth headers
     * @param string $userAgent
     * @return mixed
     */
    public static function patch($url, $fields = [], $timeout = 30, $headers = [], $auth = [], $userAgent = "php-curl-client")
    {
        return self::send($url, $fields, "PATCH", $timeout, $headers, $auth, $userAgent);
    }

    /**
     * Performs a UPDATE request
     * @param string $url The Fully Qualified Domain Name to send the request to
     * @param array $fields Data to send with the request
     * @param int $timeout In seconds
     * @param array $headers Additional data to be passed in the headers
     * @param array $auth Username and password to be passed as basic auth headers
     * @param string $userAgent
     * @return mixed
     */
    public static function update($url, $fields = [], $timeout = 30, $headers = [], $auth = [], $userAgent = "php-curl-client")
    {
        return self::send($url, $fields, "UPDATE", $timeout, $headers, $auth, $userAgent);
    }

    /**
     * Performs a DELETE request
     * @param string $url The Fully Qualified Domain Name to send the request to
     * @param array $fields Data to send with the request
     * @param int $timeout In seconds
     * @param array $headers Additional data to be passed in the headers
     * @param array $auth Username and password to be passed as basic auth headers
     * @param string $userAgent
     * @return mixed
     */
    public static function delete($url, $fields = [], $timeout = 30, $headers = [], $auth = [], $userAgent = "php-curl-client")
    {
        return self::send($url, $fields, "DELETE", $timeout, $headers, $auth, $userAgent);
    }

    /**
     * @param string $url The Fully Qualified Domain Name to send the request to
     * @param array $fields Data to send with the request
     * @param string $method GET|POST|PUT|PATCH|UPDATE|DELETE
     * @param int $timeout In seconds
     * @param array $headers Additional data to be passed in the headers
     * @param array $auth Username and password to be passed as basic auth headers
     * @param string $userAgent The user agent identifier
     * @return mixed
     */
    protected static function send($url, $fields, $method, $timeout, $headers, $auth, $userAgent)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT ,20);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FTP_USE_EPRT, false);
        curl_setopt($curl, CURLOPT_FTP_USE_EPSV, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_AUTOREFERER,    true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_ENCODING ,"UTF-8");
        curl_setopt($curl, CURLOPT_TRANSFERTEXT, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);

        switch (strtoupper($method)) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ( ! empty($fields)) {
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
                }
                break;
            case "PATCH":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
                if ( ! empty($fields)) {
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
                }
                break;
            case "UPDATE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "UPDATE");
                if ( ! empty($fields)) {
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
                }
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                if ( ! empty($fields)) {
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));
                }
                break;
            case "GET":
            default:
                break;
        }

        if (isset($auth["username"]) && isset($auth["password"])) {
            curl_setopt($curl, CURLOPT_USERPWD, $auth["username"].":".$auth["password"]);
        }

        if (isset($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        $return = curl_exec($curl);
        curl_close ($curl);
        return $return;
    }
}

<?php

namespace CodeLink\Booster\Mixins;

class StringMixin
{
    public function otp()
    {
        return function($length = 4) {

            $isDev = app()->isDev();

            $otp = '';
            for($i = 0; $i < $length; $i++) {
                $otp .= $isDev
                ? 0
                : rand(0, 9);
            }

            return $otp;
        };
    }

    public function urlParser()
    {
        return function(string $url) {
            $parsedData = [];

            $params = explode('&', parse_url($url, PHP_URL_QUERY));

            foreach ($params as $queryParam) {
                if($queryParam) {
                    $queryParamItem = explode('=', $queryParam);
                    $parsedData[$queryParamItem[0]] = $queryParamItem[1];
                }
            }

            return $parsedData;
        };
    }
}

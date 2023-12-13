<?php

namespace CodeLink\Booster\Mixins;

class AppMixin
{
    public function isDev()
    {
        return fn() => app()->isLocal()  || str_contains(url(''), config('booster.develop_server_url'));
    }
}

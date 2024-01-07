<?php

namespace CodeLink\Booster\Contracts;

interface FcmContract
{
    public function send(string $title, string $body, ?string $target, ?string $targetId);
}

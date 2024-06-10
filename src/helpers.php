<?php

use Alirezax5\Zarinpal\Zarinpal;

if (!function_exists('zarinpal')) {
    function zarinpal(): Zarinpal
    {
        return new Zarinpal();
    }
}
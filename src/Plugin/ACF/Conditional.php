<?php

namespace Adwisemedia\Plugin\ACF;

class Conditional
{
    public static function hasAcf()
    {
        return defined('ACF_BASENAME');
    }
}

<?php

namespace AppBundle\Utils;

class DurationConverter
{
    public function getDisplayFormat($minutes)
    {
        $hh = str_pad((int) ($minutes / 60), 2, "0", STR_PAD_LEFT);
        $mm = str_pad((int) ($minutes % 60), 2, "0", STR_PAD_LEFT);
        return $hh . ":" . $mm;
    }
}

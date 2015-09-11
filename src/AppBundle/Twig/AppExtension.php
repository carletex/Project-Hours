<?php

namespace AppBundle\Twig;

use AppBundle\Utils\DurationConverter;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('duration', array(new DurationConverter(), 'getDisplayFormat')),
        );
    }

    public function getName()
    {
        return 'app_extension';
    }
}

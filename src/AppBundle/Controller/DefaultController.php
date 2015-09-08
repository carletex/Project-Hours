<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {

        dump($this->getUser());
        // Get user day && week hours. Use record entity repository
        $day = '4';
        $week = '25';

        return $this->render('AppBundle::index.html.twig', array(
          'day_hours' => $day,
          'week_hours' => $week
        ));
    }
}

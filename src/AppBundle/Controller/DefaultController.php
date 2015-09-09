<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $day = $em->getRepository('AppBundle:Record')->getDayTimeUser($this->getUser());
        $week = $em->getRepository('AppBundle:Record')->getWeekTimeUser($this->getUser());

        return $this->render('AppBundle::index.html.twig', array(
          'day_hours' => $day,
          'week_hours' => $week
        ));
    }
}

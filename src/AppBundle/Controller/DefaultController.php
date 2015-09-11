<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $converter = $this->get('app.dconverter');

        $em = $this->getDoctrine()->getManager();
        $day = $converter->getDisplayFormat($em->getRepository('AppBundle:Record')->getDayTimeUser($this->getUser()));
        $week = $converter->getDisplayFormat($em->getRepository('AppBundle:Record')->getWeekTimeUser($this->getUser()));

        return $this->render('AppBundle::index.html.twig', array(
          'day_hours' => $day,
          'week_hours' => $week
        ));
    }
}

<?php

namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Client;
use AppBundle\Entity\Project;

class LoadFakeData implements FixtureInterface
{
    /**
     * Loads fake data for testing the app
     */
    public function load(ObjectManager $manager)
    {

    }
}

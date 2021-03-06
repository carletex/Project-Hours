<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

class RecordRepository extends EntityRepository
{
    public function getDayTimeUser(User $user)
    {
        // Today date
        $date = date('Y-m-d', time());

        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT SUM(r.duration)
                FROM AppBundle:Record r
                WHERE r.user = :user_id AND r.date = :current_date'
            )
            ->setParameters(array(
                  'user_id' => $user->getId(),
                  'current_date' => $date,
                )
              )
            ->getSingleScalarResult();

        return $result ? $result : 0;
    }

    public function getWeekTimeUser(User $user)
    {
        // Last sunday date
        $lastSunday = date('Y-m-d', strtotime('last Sunday'));

        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT SUM(r.duration)
                FROM AppBundle:Record r
                WHERE r.user = :user_id AND r.date > :last_sunday'
            )
            ->setParameters(array(
                  'user_id' => $user->getId(),
                  'last_sunday' => $lastSunday,
                )
              )
            ->getSingleScalarResult();

        return $result ? $result : 0;
    }
}

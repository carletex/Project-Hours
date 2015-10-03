<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function getTotalHoursByUser(Project $project)
    {
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT SUM(r.duration) as time, u.username
                FROM AppBundle:Record r, AppBundle:user u
                WHERE r.project = :project_id AND r.user = u.id
                GROUP BY r.user'
            )
            ->setParameters(array(
                  'project_id' => $project->getId()
                )
              )
            ->getResult();

        return $result;
    }

}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function getTotalHours(Project $project)
    {

        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT SUM(r.duration)
                FROM AppBundle:Record r
                WHERE r.project = :project_id'
            )
            ->setParameters(array(
                  'project_id' => $project->getId()
                )
              )
            ->getSingleScalarResult();

        return $result ? $result : 0;
    }

}

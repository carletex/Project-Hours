<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class RecordType extends AbstractType{

    protected $em;

    public function __construct(EntityManager $em)
    {
      $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $query = $this->em->createQueryBuilder()
        //   ->select('p','c')
        //   ->from('AppBundle:Project', 'p')
        //   ->innerJoin('p.client','c')
        //   ->getQuery();
        //
        // $projects = $query->getResult();
        //
        // $choices = array();
        // foreach ($projects as $project) {
        //   $choices[$project->getId()] = $project->getName() . ' (' . $project->getClient()->getName() . ')';
        // }

        $builder
            // ->add('project', 'choice', array(
            //   'choices' => $choices,
            //   'placeholder' => '',
            // ))
            ->add('project')
            ->add('description')
            ->add('duration')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Record'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_record';
    }
}

<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class RecordType extends AbstractType{

    protected $em;
    protected $action;

    public function __construct(EntityManager $em, $action = NULL)
    {
      $this->em = $em;
      $this->action = $action;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $date = array(
          'format' => 'ddMMyyyy'
        );

        if ($this->action == 'create') {
          $date['data'] = new \Datetime('now');
        }

        $builder
            ->add('project', 'entity', array(
              'class' => 'AppBundle:Project',
              'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('p')
                  ->innerJoin('p.client','c')
                  ->orderBy('c.name', 'ASC');
              },
              'group_by' => 'client',
              'placeholder' => ''
            ))
            ->add('date', 'date', $date)
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

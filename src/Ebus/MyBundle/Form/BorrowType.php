<?php

namespace Ebus\MyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BorrowType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFrom')
            ->add('dateUntil')
            //->add('furniture', null, array('attr' => array('style' => 'display:none')))
            //->add('leaser', null, array('attr' => array('style' => 'display:none')))
            //->add('lessor', null, array('attr' => array('style' => 'display:none')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ebus\MyBundle\Entity\Borrow'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ebus_mybundle_borrow';
    }
}

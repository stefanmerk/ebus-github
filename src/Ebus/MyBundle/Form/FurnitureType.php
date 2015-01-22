<?php

namespace Ebus\MyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FurnitureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('file')
            ->add('price')
            ->add('category')
            //->add('user', null, array('attr' => array('style' => 'display:block')))
            ->add('condition')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ebus\MyBundle\Entity\Furniture'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ebus_mybundle_furniture';
    }
}

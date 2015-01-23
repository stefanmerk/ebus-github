<?php
namespace Ebus\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->add('firstName', null, array("label" => "Vorname"));
        $builder->add('lastName', null, array("label" => "Nachname"));
        $builder->add('street', null, array("label" => "Straße"));
        $builder->add('streetNumber', null, array("label" => "Hausnummer"));
        $builder->add('zip', null, array("label" => "PLZ"));
        $builder->add('town', null, array("label" => "Ort"));
        $builder->remove('current_password');
        $builder->remove('username');
        $builder->remove('email');
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'app_user_profile';
    }
}

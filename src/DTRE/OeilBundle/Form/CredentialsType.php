<?php
/**
 * Created by PhpStorm.
 * User: kafim
 * Date: 07/05/2017
 * Time: 12:16
 */

namespace DTRE\OeilBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class CredentialsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login');
        $builder->add('password');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'DTRE\OeilBundle\Entity\Credentials',
            'csrf_protection' => false
        ]);
    }
}
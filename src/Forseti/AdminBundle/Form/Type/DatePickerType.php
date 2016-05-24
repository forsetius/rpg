<?php
namespace Forseti\AdminBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatePickerType extends DateType
{
    private static $widgets = array(
        'text' => 'Symfony\Component\Form\Extension\Core\Type\TextType',
    );
    
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults(array(
            'format' => 'YYYY-MM-DD'
        ));
    }
    
    public function getBlockPrefix()
    {
        return 'datePicker';
    }
    
    public function getName()
    {
        return 'date';
    }
}
    
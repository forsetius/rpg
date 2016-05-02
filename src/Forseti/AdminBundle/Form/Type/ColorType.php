<?php
namespace Forseti\AdminBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class ColorType extends TextType
{
    public function getBlockPrefix()
    {
        return 'color';
    }
}
<?php
namespace Forseti\AdminBundle\Controller\Traits;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

trait GroupAdminTrait {

    public function createGroupEntityFormBuilder($entity, $view)
    {
        $choices = [];$preferred = [];
        $vals = array_keys($this->container->getParameter('security.role_hierarchy.roles'));
        foreach ($vals as $val) {
            if ($val == 'ROLE_SUPER_ADMIN') {
                $label = 'Super Admin';
            } else {
                $str = array_pad(explode('_',  strtolower($val), 3), 3, '');
                $separator = ($str[2] != '') ? ':' : '';
                $label = ucfirst($str[1]) . $separator . ucfirst(str_replace('_', ' ',$str[2]));
                if ($str[2] =='all') $preferred[] = $label;
            }
            $choices[] = $label;
        }
        $formBuilder = parent::createEntityFormBuilder($entity, $view);
        $formBuilder->add('roles', ChoiceType::class, ['choices'=>array_combine($choices, $vals), 'preferred_choices'=>$preferred, 'multiple'=>true, 'expanded'=>false]);
        return $formBuilder;
    }

}
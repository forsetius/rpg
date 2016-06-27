<?php 
namespace Eg\AdminBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;

class ColorConverterTwigExtension extends \Twig_Extension
{

    public function getName()
    {
        return 'Color Converter';
    }

    public function getFilters()
    {
        return array(
            'hexToRgb' => new Twig_Filter_Method($this, 'hexToRgb'),
        );
    }

    public function hexToRgb($hex, $returnAsArray = true)
    {

	    $hex = str_replace("#", "", $hex);

	    if(strlen($hex) == 3) {
		    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	    } else {
		    $r = hexdec(substr($hex,0,2));
		    $g = hexdec(substr($hex,2,2));
		    $b = hexdec(substr($hex,4,2));
	    }

	    $rgb = array('r' => $r, 'g' => $g, 'b' => $b);

	    return $returnAsArray ? $rgb : implode(",", $rgb);

    }
}
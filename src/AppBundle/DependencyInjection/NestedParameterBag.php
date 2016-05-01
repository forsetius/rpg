<?php
namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class NestedParameterBag extends ParameterBag
{

    /**
     * wire $this->set() logic into add() too
     *
     * @param array $parameters
     */
    public function add( array $parameters )
    {
        foreach ( $parameters as $name => $value ) {
            $this->set( $name, $value );
        }
    }

    /**
     * sets all levels of nested array parameters with dot notation
     * - loggly[host: loggly.com] will be translated this way:
     *  - loggly: [host: loggly.com] - standard array parameter will be left as is
     *  - loggly.host: loggly.com - nested variables ar translated so you can access them directly too as parent.variable
     *
     * @param string $name
     * @param mixed $value
     */
    public function set( $name, $value )
    {
        if ( $this->has( $name ) ) {
            // this is required because of array values
            // we can have arrays defined there, so we need to remove them first
            // otherwise some subvalues would to remain in the system and as a result, arrays would be merged, not overwriten by set()
            $this->remove( $name );
        }
        $this->setNested( $name, $value );
    }

    /**
     * remove checks even if name is not array
     *
     * @param string $name
     */
    public function remove( $name )
    {
        $value = $this->get( $name );
        if ( is_array( $value ) ) {
            foreach ( $value as $k => $v ) {
                $this->remove( $name . '.' . $k, $v );
            }
        }
        if ( strpos( $name, '.' ) !== FALSE ) {
            $parts = explode( '.', $name );
            $nameTopLevel = reset( $parts );
            array_shift( $parts );
            $topLevelData = $this->removeKeyByAddress( $this->get( $nameTopLevel ), $parts );
            ksort( $topLevelData );
            $this->setNested( $nameTopLevel, $topLevelData );
        }
        parent::remove( $name );
    }

    /**
     * @param array $data
     * @param array $addressParts
     *
     * @return array
     */
    private function removeKeyByAddress( $data, $addressParts )
    {
        $updatedLevel = & $data;
        $i = 1;
        foreach ( $addressParts as $part ) {
            if ( $i === count( $addressParts ) ) {
                unset( $updatedLevel[$part] );
            } else {
                $updatedLevel = & $updatedLevel[$part];
                $i++;
            }
        }
        return $data;
    }

    /**
     * @see set()
     *
     * @param string $name
     * @param mixed $value
     */
    private function setNested( $name, $value )
    {
        if ( is_array( $value ) ) {
            foreach ( $value as $k => $v ) {
                $this->setNested( $name . '.' . $k, $v );
            }
        }
        parent::set( $name, $value );
    }

}
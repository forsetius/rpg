<?php
namespace Forseti\AdminBundle\Security;

class AccessMap
{
    const ACCESS_NO = 0;
    const ACCESS_OWN = 1;
    const ACCESS_YES = 255;
    
    protected $map = [];
    protected $permissions;
    protected $roleHierarchy;
    protected $expandedRoles = [];
    
    public function __construct($permissions, $roleHierarchy)
    {
        $this->permissions = $permissions;
        $this->roleHierarchy = $roleHierarchy;
    }
    
    public function hasRights($roles, $entity, $action)
    {
        if ($this->hasKey([$entity, $action], $this->map))
            return $this->map[$entity][$action];

        $entityClass = "Eg\OsmAdminBundle\Entity\\$entity";
        $roles = $this->expandRoles($roles);
        foreach ($roles as $role) {
            if ($this->permissions[$role][$entity] == 'all') {
                $this->map[$entity] = \array_fill_keys($entityClass::ENTITY_ACTIONS, self::ACCESS_YES);
                break;
            } else {
                $right = $this->hasKey([$role, $entity, $action], $this->permissions) ? $this->permissions[$role][$entity][$action] : '';
                switch($right) {
                    case 'yes':
                        $this->map[$entity][$action] = self::ACCESS_YES; break 2;
                    case 'own':
                        $this->map[$entity][$action] = self::ACCESS_OWN; break;
                    default:
                        if ($this->map[$entity][$action] < $right) {
                            $this->map[$entity][$action] = $right;
                        }
                }
            }
        }
        return $this->map[$entity][$action];
    }
    
    /**
     * Checks if array has nested keys.
     * For $array['ROLE_USER']['User']['edit'] use $keys = ['ROLE_USER', 'User', 'edit']
     *
     * @param array $keys keys hierarchy in scalar array
     * @param array $array array that should have such nested keys
     * @return boolean
     */
    public function hasKey(array $keys, $array)
    {
        foreach ($keys as $key) {
            if (! \array_key_exists($key, $array)) return false;
            $array = $array[$key];
        }
        return true;
    }
    
    protected function expandRoles($roles)
    {
        $result = [];
        foreach ($roles as $role) {
            $role = $role->getRole();
            if (\array_key_exists($role, $this->expandedRoles))
                return $this->expandedRoles[$role];
            
            $this->addParentRole($role, $result);
        }
        return $this->expandedRoles[$role] = \array_keys($result);
    }
    
    protected function addParentRole($role, &$result)
    {
        $result[$role] = null;
        if (\array_key_exists($role, $this->roleHierarchy)) {
            foreach ((array) $this->roleHierarchy[$role] as $r) {
                $this->addParentRole($this->roleHierarchy[$r], $result);
            }
        }
    }
}
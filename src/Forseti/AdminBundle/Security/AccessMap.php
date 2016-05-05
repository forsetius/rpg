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
        \dump($entity);\dump($action);
        if ($this->hasKey([$entity['name'], $action], $this->map))
            return $this->map[$entity['name']][$action];

        $roles = $this->expandRoles($roles);
        foreach ($roles as $role) {
            if ($this->hasKey([$role, $entity['name']], $this->permissions)) {
                if ($this->permissions[$role][$entity['name']] == 'all') {
                    $this->map[$entity['name']] = \array_fill_keys($entity['class']::ENTITY_ACTIONS, self::ACCESS_YES);
                    break;
                } else {
                    $right = \array_key_exists($action, $this->permissions) ? $this->permissions[$role][$entity['name']][$action] : self::ACCESS_NO;
                    switch($right) {
                        case 'yes':
                            $this->map[$entity['name']][$action] = self::ACCESS_YES; break 2;
                        case 'own':
                            $this->map[$entity['name']][$action] = self::ACCESS_OWN; break;
                        default:
                            if ($this->map[$entity['name']][$action] < $right) {
                                $this->map[$entity['name']][$action] = $right;
                            }
                    }
                }
            }
        }
        return ($this->hasKey([$entity['name'], $action], $this->map))
                ? $this->map[$entity['name']][$action]
                : self::ACCESS_NO;
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
        foreach ($roles as $role) {
            $role = $role->getRole();
            if (\array_key_exists($role, $this->expandedRoles))
                continue;
            
            $this->addParentRole($role);
        }
        
        return \array_keys($this->expandedRoles);
    }
    
    protected function addParentRole($role)
    {
        $this->expandedRoles[$role] = null;
        if (\array_key_exists($role, $this->roleHierarchy)) {
            foreach ((array) $this->roleHierarchy[$role] as $r) {
                $this->addParentRole($r);
            }
        }
    }
}
<?php

namespace DMEntity;

abstract class AbstractEntity
{
    protected $_values = array(); 
    protected $_allowedFields = array();
    
    /**
     * Class constructor
     * @param Array 
     */
    public function __construct(array $data)
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
    }
    
    /**
     * Assign a value to the specified field via the corresponding mutator (if it exists); 
     * otherwise, assign the value directly to the '$_values' protected array 
     */
    public function __set($name, $value)
    {   
        if (!in_array($name, $this->_allowedFields)) {
            throw new EntityException('The field ' . $name . ' is not allowed for this entity.');  
        }
        $mutator = 'set' . ucfirst($name);
        if (method_exists($this, $mutator) && is_callable(array($this, $mutator))) {
            $this->$mutator($value);           
        }
        else {
            $this->_values[$name] = $value;
        }    
    }
    
    /**
     * Get the value assigned to the specified field via the corresponding getter (if it exists);
     * otherwise, get the value directly from the '$_values' protected array
     */
    public function __get($name)
    {
        if (!in_array($name, $this->_allowedFields)) {
            throw new EntityException('The field ' . $name . ' is not allowed for this entity.');    
        }
        $accessor = 'get' . ucfirst($name);
        if (method_exists($this, $accessor) && is_callable(array($this, $accessor))) {
            return $this->$accessor;    
        }
        if (isset($this->_values[$name])) {
            return $this->_values[$name];   
        }
        throw new EntityException('The field ' . $name . ' has not been set for this entity yet.');
    }

    /**
     * Check if the specified field has been assigned to the entity
     */
    public function __isset($name)
    {
        if (!in_array($name, $this->_allowedFields)) {
            throw new EntityException('The field ' . $name . ' is not allowed for this entity.');
        }
        return isset($this->_values[$name]);
    }

    /**
     * Unset the specified field from the entity
     */
    public function __unset($name)
    {
        if (!in_array($name, $this->_allowedFields)) {
            throw new EntityException('The field ' . $name . ' is not allowed for this entity.');
        }
        if (isset($this->_values[$name])) {
            unset($this->_values[$name]);
        }
    }

    /**
     * Get an associative array with the values assigned to the fields of the entity
     */ 
    public function toArray()
    {
        return $this->_values;
    }              
}
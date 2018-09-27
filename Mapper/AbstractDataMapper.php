<?php

namespace DMMapper;

use DMDatabase;
use DMCollection;

abstract class AbstractDataMapper implements DataMapperInterface{

    protected $_adapter;
    protected $_collection=[];
    protected $_entityTable;
    protected $_entityClass;

    /**
     * Constructor
     */
    public function __construct(DatabaseAdapterInterface $adapter, array $entityOptions = array()){

            $this->_adapter = $adapter;

            if( isset($entityOptions['entityTable']) ){
                $this->_setEntityTable($entityOptions['entityTable']);
            }

            if( isset($entityOptions['entityClass']) ){
                $this->_setEntityClass($entityOptions['entityClass']);
            }
    }

    /**
     * Get the Database Adapter
     * @return _adapter
     */

    public function getAdapter(){
        return $this->_adapter;
    }

    /**
     * Get the collection
     * @return _collection
     */

    public function getCollection(){
        return $this->_collection;
    }

    /**
     * Set the entity table
     * @param $entityTable -- Table name of entity
     * @throws DataMapperException
     */

    public function setEntityTable($entityTable){
        if( !(is_string($entityTable)) || empty($entityTable) ){
            throw new DataMapperException('The specific entity table is invalid');
        }
        $this->_entityTable = $entityTable;
    }

    /**
     * Get the entity table
     * @return _entityTable
     */

    public function getEntityTable(){
        return $this->_entityTable;
    }

    /**
     * Set the entity Class
     * @param $entityClass (Entity Class)
     * @throws DataMapperException
     */

    public function setEntityClass($entityClass){
        if( !class_exist($entityClass) ){
            throw new DataMapperException('The specific entity class is invalid');
        }
        $this->_entityClass = $entityClass;
    }

    /**
     * Get the entity Class
     * @return _entityClass
     */
    public function getEntityClass(){
        return $this->_entityClass;
    }

    /**
     * Find the entity by its ID
     * @return (NULL || _entityClass)
     */
    public function findById($id){
        $this->_adapter->select($this->_entityTable,"id={$id}");
        if( $data = $this->_adapter->fetch() ){
            return new $this->_entityClass($data);
        }
        return NULL;
    }

    /**
     * Find all the entities
     * @return Array collection of record
     */
    public function findAll(){
        $this->_adapter->select($this->_entityTable);
        while( $data = $this->_adapter->fetch() ){
            $this->_collection[] = new $this->_entityClass($data);
        }
        return $this->_collection;
    }

    /**
     * Find all the entities that match specific criteria
     * @param Array array of criteria
     * @return Array Collection of record
     */

    public function search($criteria){
        $this->_adapter->select($this->_entityTable, $criteria);
        while( $data = $this->_adapter->fetch() ){
            $this->_collection[] = new $this->_entityClass($data);
        }
        return $this->_collection;
    }

    /**
     * Insert a new row in the table corresponding to specific entity
     * @param Object New Entity Object
     * @throws DataMapperException
     * @return  
     */
    public function insert($entity){
        if( $entity instanceof $this->_entityClass ){
            return $this->_adapter->insert($this->_entityTable, $entity->toArray());
        }
        else {
            throw new DataMapperException('The specific entry is not allowed for this mapper');
        }
    }

    /**
     * Update an existing row in the table corresponding to specific entity
     * @param Object Update Entity Object
     * @throws DataMapperException
     * @return  
     */
    public function update($entity){
        if( $entity instanceof $this->_entityClass ){
            return $this->_adapter->update($this->_entityTable, $entity->toArray());
        }
        else {
            throw new DataMapperException('The specific entry is not allowed for this mapper');
        }
    }

    /**
     * Delete an existing row in the table corresponding to specific entity
     * @param Object Delete Entity Object
     * @throws DataMapperException
     * @return  
     */
    public function delete($entity){
        if( $entity instanceof $this->_entityClass ){
            $id = $entity->id;
            return $this->_adapter->delete($this->_entityTable, "id={$id}");
        }
        else {
            throw new DataMapperException('The specific entry is not allowed for this mapper');
        }
    }

}
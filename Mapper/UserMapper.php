<?php

namespace DMMapper;

use DMDatabase;
use DMCollection;

class UserMapper extends AbstractDataMapper{

    protected $_entityClass = "User";
    protected $_entityTable = "users";
    
    /**
     * Constructor
     */
    public function __construct(DatabaseAdapterInterface $adapter){
        parent::__construct($adapter, [
            'entityTable' => $this->_entityTable,
            'entityClass' => $this->_entityClass
        ]);
    }
}
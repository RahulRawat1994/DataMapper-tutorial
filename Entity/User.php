<?php

namespace Entity;

class User extends AbstractEntity
{
    protected $_allowedFields = array('id', 'fname', 'lname', 'email');

    /**
     * constructor
     */
    public function __construct(array $data = null)
    {
        if (!is_null($data)) {
            parent::__construct($data);
        }
    }
    /**
     * Set the user's ID
     */
    public function setId($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 999999)))) {
            throw new EntityException('The specified ID is invalid.');
        }
        $this->_values['id'] = $id;
    }

    /**
     * Set the user's first name
     */
    public function setFname($fname)
    {
        if (strlen($fname) < 2 || strlen($fname) > 32) {
            throw new EntityException('The specified first name is invalid.');
        }
        $this->_values['fname'] = $fname;
    }

    /**
     * Set the user's last name
     */
    public function setLname($lname)
    {
        if (strlen($lname) < 2 || strlen($lname) > 32) {
            throw new EntityException('The specified last name is invalid.');
        }
        $this->_values['lname'] = $lname;
    }

    /**
     * Set the user's email address
     */
    public function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EntityException('The specified email address is invalid.');
        }
        $this->_values['email'] = $email;
    }
}

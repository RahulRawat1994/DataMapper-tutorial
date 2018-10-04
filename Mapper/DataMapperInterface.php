<?php

namespace App\Mapper;

interface DataMapperInterface
{
    public function findByID($id);

    public function findAll();

    public function search($certeria);

    public function insert($entity);

    public function update($entity);

    public function delete($entity);
}

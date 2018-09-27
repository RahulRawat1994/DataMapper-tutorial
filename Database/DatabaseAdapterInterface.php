<?php

namespace DMDatabase;

Interface DatabaseAdapterInterface {

    public function select($table, $whr = NULL, $fields = NULL);

    public function insert($table, $fields);

    public function update($table, $fields, $whr);

    public function delete($table, $id);

}
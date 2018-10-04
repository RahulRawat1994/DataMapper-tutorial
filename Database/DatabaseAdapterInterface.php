<?php

namespace App\Database;

interface DatabaseAdapterInterface
{
    public function select(string $table, array $whr = null, array $fields = null);

    public function insert(string $table, array $fields);

    public function update(string $table, array $fields, array $whr);

    public function delete(string $table, int $id);
}

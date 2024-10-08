<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function list($data);
    public function get(string $uuid);
    public function delete(string $uuid);
    public function create(array $data);
    public function update(string $uuid, array $newData);
}

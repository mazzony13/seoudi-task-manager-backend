<?php

namespace App\Interfaces;

interface TaskRepositoryInterface
{
    public function list(array $data);
    public function get(string $uuid);
    public function delete(string $uuid);
    public function create(array $data);
    public function update(string $uuid, array $newData);
}

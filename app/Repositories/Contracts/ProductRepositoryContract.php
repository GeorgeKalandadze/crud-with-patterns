<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryContract
{
    public function getAll();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getById(int $id);

}

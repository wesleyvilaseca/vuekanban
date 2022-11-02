<?php

namespace App\Repositories\Contracts;


interface BoardRepositoryInterface
{
    public function getBoardsByProjectId(int $id);
    public function store(array $data);
    public function delete(int $id);
    public function deleteByProjectId(int $id);
    public function getById(int $id);
}

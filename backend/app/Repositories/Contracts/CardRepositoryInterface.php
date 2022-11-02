<?php

namespace App\Repositories\Contracts;


interface CardRepositoryInterface
{
    public function getById(int $id);
    public function updateCard(int $id, $data);
    public function deleteByBoardId(int $id);
    public function delete(int $id);
    public function getCardsByBoardId(int $id);
    public function store(array $data);
}

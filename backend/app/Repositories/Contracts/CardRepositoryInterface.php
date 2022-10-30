<?php

namespace App\Repositories\Contracts;


interface CardRepositoryInterface
{
    public function getById(int $id);
    public function updateCard(int $id, $data);
}

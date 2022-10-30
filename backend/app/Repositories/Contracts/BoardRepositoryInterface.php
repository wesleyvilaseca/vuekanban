<?php

namespace App\Repositories\Contracts;


interface BoardRepositoryInterface
{
    public function getBoardsByProjectId(int $id);
}

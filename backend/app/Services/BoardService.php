<?php

namespace App\Services;

use App\Repositories\Contracts\BoardRepositoryInterface;

class BoardService
{

    private $repository;

    public function __construct(BoardRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getBoardsByProjectId(int $id)
    {
        return $this->repository->getBoardsByProjectId($id);
    }
}

<?php

namespace App\Services;

use App\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectService
{

    private $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(int $per_page)
    {
        return $this->repository->getAll($per_page);
    }

    public function get(int $id)
    {
        return $this->repository->get($id);
    }
}

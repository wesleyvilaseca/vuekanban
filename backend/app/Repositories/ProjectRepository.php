<?php

namespace App\Repositories;


use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    protected $entity;

    public function __construct(Project $project)
    {
        $this->entity = $project;
    }

    public function get(int $id)
    {
        return $this->entity->find($id);
    }
}

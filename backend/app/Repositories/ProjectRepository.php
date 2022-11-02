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

    public function getAll(int $per_page)
    {
        return $this->entity->paginate($per_page);
    }

    public function get(int $id)
    {
        return $this->entity->find($id);
    }

    public function store(array $data)
    {
        return $this->entity->create($data);
    }

    public function delete(int $id)
    {
        return $this->entity->where('id', $id)->delete();
    }
}

<?php

namespace App\Repositories;


use App\Models\Board;
use App\Repositories\Contracts\BoardRepositoryInterface;

class BoardRepository implements BoardRepositoryInterface
{
    protected $entity;

    public function __construct(Board $board)
    {
        $this->entity = $board;
    }

    public function getBoardsByProjectId(int $id)
    {
        return $this->entity->where('project_id', $id)->get();
    }

    public function store(array $data)
    {
        return $this->entity->create($data);
    }

    public function deleteByProjectId(int $id)
    {
        return $this->entity->where('project_id', $id)->delete();
    }

    public function delete(int $id)
    {
        return $this->entity->where('id', $id)->delete();
    }

    public function getById(int $id)
    {
        return $this->entity->find($id);
    }
}

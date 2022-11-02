<?php

namespace App\Services;

use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ProjectService
{

    private $repository;
    private $boardService;

    public function __construct(ProjectRepositoryInterface $repository, BoardService $boardService)
    {
        $this->repository = $repository;
        $this->boardService = $boardService;
    }

    public function getAll(int $per_page)
    {
        return $this->repository->getAll($per_page);
    }

    public function get(int $id)
    {
        return $this->repository->get($id);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $res = $this->repository->store($data);
            if ($res) {
                $newData = [];
                $newData['project_id'] = $res->id;
                $newData['title'] = 'Back Log';
                $this->boardService->store($newData);
            }

            DB::commit();
            return response()->json(['msg' => 'projeto criado com sucesso'], 200);
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function update(int $id, array $data)
    {
        $project = $this->get($id);
        if (!$project) return response()->json(['error' => 'projeto não localizado', 'data' => $id], 400);

        $res = $this->repository->update($id, $data);
        if (!$res) return response()->json(['error' => 'erro ao editar o projeto'], 400);

        return response()->json(['msg' => 'projeto editado com sucesso'], 200);
    }

    public function delete(int $id)
    {
        $project = $this->get($id);

        if (!$project) return response()->json(['error' => 'projeto não localizado'], 400);

        $has_boards = $this->boardService->getBoardsByProjectId($project->id);

        if ($has_boards) {
            $res = $this->boardService->deleteByProjectId($project->id);
            if (!$res) return response()->json(['error' => 'erro ao tentar apagar o projeto'], 400);
        }

        $res = $this->repository->delete($id);
        if (!$res) return response()->json(['error' => 'erro ao tentar apagar o projeto'], 400);

        return response()->json(['msg' => 'projeto apagado com sucesso'], 200);
    }
}

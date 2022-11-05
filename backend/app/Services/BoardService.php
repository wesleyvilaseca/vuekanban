<?php

namespace App\Services;

use App\Repositories\Contracts\BoardRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class BoardService
{

    private $repository;
    protected $cardService;
    protected $projectService;

    public function __construct(BoardRepositoryInterface $repository, CardService $cardService, ProjectService $projectService)
    {
        $this->repository = $repository;
        $this->cardService = $cardService;
        $this->projectService = $projectService;
    }

    public function getById(int $id)
    {
        return $this->repository->getById($id);
    }

    public function getBoardsByProjectId(int $id)
    {
        return $this->repository->getBoardsByProjectId($id);
    }

    public function store(array $data)
    {
        $project = $this->projectService->get($data['project_id']);
        if (!$project) return response()->json(['error' => 'Projeto inexistente'], 400);

        $res = $this->repository->store($data);
        if (!$res) return response()->json(['error' => 'erro ao criar o board'], 400);

        return response()->json(['board criado com sucesso'], 200);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    public function deleteByProjectId(int $id)
    {
        $has_boards = $this->getBoardsByProjectId($id);

        if ($has_boards) {
            foreach ($has_boards as $board) {
                $has_cards = $this->cardService->getCardsByBoardId($board->id);
                if ($has_cards)
                    $this->cardService->deleteByBoardId($board->id);
            }

            return $this->repository->deleteByProjectId($id);
        }
    }
}

<?php

namespace App\Services;

use App\Models\Board;
use App\Models\Project;
use App\Repositories\Contracts\CardRepositoryInterface;

class CardService
{

    private $repository;

    public function __construct(CardRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getById(int $id)
    {
        return $this->repository->getById($id);
    }

    public function getCardsByBoardId(int $id)
    {
        return $this->repository->getCardsByBoardId($id);
    }

    public function updateCard(int $id, $data)
    {
        $card = $this->getById($id);
        if (!$card) return response()->json(['message' => 'Card Not Found'], 404);

        $board = Board::find($data['board_id']);
        if (!$board) return response()->json(['error' => 'board não exist'], 400);

        $this->repository->updateCard($id, $data);

        return response()->json([
            'updated' => true,
        ])->setStatusCode(202);
    }

    public function store(array $data)
    {
        $project = Project::find($data['project_id']);
        if (!$project) return response()->json(['error' => 'projeto não encontrado'], 400);

        $board = Board::where('project_id', $project->id)->orderBy('id', 'ASC')->first();
        $data['board_id'] = $board->id;

        $res = $this->repository->store($data);

        if (!$res) return response()->json(['error' => 'erro ao criar a atividade'], 400);

        return response()->json(['message' => 'atividade criada com sucesso'], 200);
    }

    public function deleteByBoardId(int $id)
    {
        return $this->repository->deleteByBoardId($id);
    }

    public function delete(int $id)
    {
        $card_exist = $this->getById($id);
        if (!$card_exist) return response()->json(['error' => 'card não existe'], 400);

        $res = $this->repository->delete($id);
        if (!$res) response()->json(['error' => 'Houve um problema ao deletar o card'], 400);

        return response()->json(['message' => 'card apagado com sucesso'], 200);
    }
}

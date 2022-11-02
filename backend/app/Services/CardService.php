<?php

namespace App\Services;

use App\Models\Board;
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
        if (!$card) {
            return response()->json(['message' => 'Card Not Found'], 404);
        }

        $this->repository->updateCard($id, $data);

        return response()->json([
            'updated' => true,
        ])->setStatusCode(202);
    }

    public function store(array $data)
    {
        $board = Board::where('project_id', $data['project_id'])->orderBy('id', 'ASC')->first();
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
        return $this->repository->delete($id);
    }
}

<?php

namespace App\Services;

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
}

<?php

namespace App\Services;

use App\Repositories\Contracts\BoardRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class BoardService
{

    private $repository;
    protected $cardService;

    public function __construct(BoardRepositoryInterface $repository, CardService $cardService)
    {
        $this->repository = $repository;
        $this->cardService = $cardService;
    }

    public function getById(int $id)
    {
        return $this->repository->getById($id);
    }

    public function getBoardsByProjectId(int $id)
    {
        return $this->repository->getBoardsByProjectId($id);
    }

    public function store($request)
    {
        return $this->repository->store($request);
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

<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\Contracts\BoardRepositoryInterface;

class BoardService
{

    private $repository;
    protected $cardService;
    /* protected $projectService;*/

    public function __construct(BoardRepositoryInterface $repository, CardService $cardService/*,  ProjectService $projectService*/)
    {
        $this->repository = $repository;
        $this->cardService = $cardService;
        /*$this->projectService = $projectService;*/
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
        $project_exist = Project::find($request['project_id']);
        // for some reason this service wont work
        // $project_exist = $this->projectService->get($request['project_id']);

        if (!$project_exist) return response()->json(['error' => 'projeto não existe'], 400);

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

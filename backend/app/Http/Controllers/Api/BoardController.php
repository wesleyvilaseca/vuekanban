<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardResource;
use Illuminate\Http\Request;
use App\Services\BoardService;
use App\Services\ProjectService;

class BoardController extends Controller
{
    protected $boardService;
    protected $projectService;

    public function __construct(BoardService $boardService, ProjectService $projectService)
    {
        $this->boardService = $boardService;
        $this->projectService = $projectService;
    }

    public function store(Request $request)
    {
        return $this->boardService->store($request);
    }

    public function getByProject(Request $request, $id)
    {
        $project = $this->projectService->get($id);
        if (!$project) {
            return response()->json(['message' => 'Brand Not Found'], 404);
        }

        return BoardResource::collection($this->boardService->getBoardsByProjectId($id));
    }
}

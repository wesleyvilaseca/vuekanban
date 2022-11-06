<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardResource;
use Illuminate\Http\Request;
use App\Services\BoardService;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Validator;

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
        $validate = Validator::make($request->all(), [
            'title'      => ['required'],
            'project_id' => ['required'],
        ]);

        if ($validate->fails()) return response()->json(['error' => $validate->errors()], 400);

        return $this->boardService->store($request->all());
    }

    public function getByProject(Request $request, $id)
    {
        $project = $this->projectService->get($id);
        if (!$project) {
            return response()->json(['message' => 'Brand Not Found'], 404);
        }

        return BoardResource::collection($this->boardService->getBoardsByProjectId($id));
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title'      => ['required'],
            'project_id' => ['required'],
        ]);

        if ($validate->fails()) return response()->json(['error' => $validate->errors()], 400);

        return $this->boardService->update($id, $request->all());
    }

    public function delete($id)
    {
        return $this->boardService->delete($id);
    }
}

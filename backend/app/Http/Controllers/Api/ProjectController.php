<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeUpdateProject;
use App\Http\Resources\ProjectResouce;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request)
    {
        $per_page = $request->get('per_page', 15);
        return ProjectResouce::collection($this->projectService->getAll($per_page));
    }

    public function store(storeUpdateProject $request)
    {
        return $this->projectService->store($request->all());
    }

    public function delete($id)
    {
        return $this->projectService->delete($id);
    }
}

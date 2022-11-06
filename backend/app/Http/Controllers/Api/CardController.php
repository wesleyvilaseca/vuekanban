<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCard;
use App\Services\CardService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CardController extends Controller
{
    protected $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    public function store(Request $request)
    {
        /**
         * to create a card dont need a board id cause, aways the card gona be inserted in a backlog board
         */
        $validate = Validator::make($request->all(), [
            'title'      => ['required'],
            'description' => ['nullable'],
            'project_id' => ['required']
        ]);

        if ($validate->fails()) return response()->json(['error' => $validate->errors()], 400);

        return $this->cardService->store($request->all());
    }

    public function delete($id)
    {
        return $this->cardService->delete($id);
    }

    public function update(StoreUpdateCard $request, $id)
    {
        return $this->cardService->updateCard($id, $request->all());
    }
}

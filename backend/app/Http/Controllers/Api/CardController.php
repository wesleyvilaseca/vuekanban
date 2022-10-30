<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCard;
use App\Services\CardService;
use Illuminate\Http\Request;

class CardController extends Controller
{
    protected $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    public function update(StoreUpdateCard $request, $id)
    {
        return $this->cardService->updateCard($id, $request->all());
    }
}

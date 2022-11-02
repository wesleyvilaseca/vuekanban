<?php

namespace App\Repositories;


use App\Models\Card;
use App\Repositories\Contracts\CardRepositoryInterface;

class CardRepository implements CardRepositoryInterface
{
    protected $entity;

    public function __construct(Card $card)
    {
        $this->entity = $card;
    }

    public function getById(int $id)
    {
        return $this->entity->find($id);
    }

    public function updateCard(int $id, $data)
    {
        return $this->entity->where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return $this->entity->where('id', $id)->delete();
    }

    public function deleteByBoardId(int $id)
    {
        return $this->entity->where('board_id', $id)->delete();
    }

    public function getCardsByBoardId(int $id)
    {
        return $this->entity->where('board_id', $id)->get();
    }
}

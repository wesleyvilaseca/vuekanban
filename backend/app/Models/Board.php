<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'project_id'];

    public function cards()
    {
        return $this->hasMany(Card::class)->orderBy('index', 'ASC');
    }
}

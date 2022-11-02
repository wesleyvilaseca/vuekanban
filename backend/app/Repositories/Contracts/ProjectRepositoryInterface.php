<?php

namespace App\Repositories\Contracts;


interface ProjectRepositoryInterface
{
    public function get(int $id);
    public function getAll(int $per_page);
}

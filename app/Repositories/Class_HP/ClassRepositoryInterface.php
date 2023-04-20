<?php

namespace App\Repositories\Class_HP;

use App\Repositories\RepositoryInterface;

interface ClassRepositoryInterface extends RepositoryInterface
{
    public function getAllClass($request);

    public function getClassDKHP($request);

    public function getAllUserInClass($id);
}

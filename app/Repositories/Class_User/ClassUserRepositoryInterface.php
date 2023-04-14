<?php

namespace App\Repositories\Class_User;

use App\Repositories\RepositoryInterface;

interface ClassUserRepositoryInterface extends RepositoryInterface
{

    public function getAllClassUser($request);

    public function phanGiang($request);

}

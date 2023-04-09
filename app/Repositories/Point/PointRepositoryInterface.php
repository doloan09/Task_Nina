<?php

namespace App\Repositories\Point;

use App\Repositories\RepositoryInterface;

interface PointRepositoryInterface extends RepositoryInterface
{
    public function getAllPoint($request);
}

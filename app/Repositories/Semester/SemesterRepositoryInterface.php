<?php

namespace App\Repositories\Semester;

use App\Repositories\RepositoryInterface;

interface SemesterRepositoryInterface extends RepositoryInterface
{
    public function createSemester($request);

    public function updateSemester($request, $id);

}

<?php

namespace App\Repositories\Semester;

use App\Repositories\BaseRepository;

class SemesterRepository extends BaseRepository implements SemesterRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Semester::class;
    }

}

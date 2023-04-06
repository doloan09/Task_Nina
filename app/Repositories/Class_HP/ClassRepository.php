<?php

namespace App\Repositories\Class_HP;

use App\Repositories\BaseRepository;

class ClassRepository extends BaseRepository implements ClassRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Class_HP::class;
    }

}

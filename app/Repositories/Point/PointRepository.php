<?php

namespace App\Repositories\Point;

use App\Repositories\BaseRepository;

class PointRepository extends BaseRepository implements PointRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Point::class;
    }

}

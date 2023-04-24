<?php

namespace App\Repositories\Semester;

use App\Models\Semester;
use App\Repositories\BaseRepository;

class SemesterRepository extends BaseRepository implements SemesterRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Semester::class;
    }

    public function createSemester($request)
    {
        $item = Semester::query()->orderByDesc('id')->first();

        if (($request['start_time'] < $item->end_time) || ($request['end_time'] < $request['start_time'])){
            return false;
        }

        return $this->model->create($request);
    }

    public function updateSemester($request, $id)
    {
        if ($request['end_time'] < $request['start_time']){
            return false;
        }

        $result = $this->find($id);
        if ($result) {
            $result->update($request);
            return $result;
        }

        return false;
    }
}

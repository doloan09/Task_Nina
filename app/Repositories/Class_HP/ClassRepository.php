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

    public function getAllClass($request)
    {
        $list = $this->model->join('subjects', 'classes.id_subject', '=', 'subjects.id')
            ->join('semesters', 'classes.id_semester', '=', 'semesters.id')
            ->select('classes.*', 'subjects.name_subject', 'semesters.name_semester', 'semesters.year_semester');

        if ($request['id_semester']) $list = $list->where('id_semester', $request['id_semester']);
        if ($request['id_subject'])  $list = $list->where('id_subject', $request['id_subject']);

        return $list->get();
    }
}

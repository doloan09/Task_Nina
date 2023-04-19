<?php

namespace App\Repositories\Class_HP;

use App\Models\Class_HP;
use App\Models\ClassUser;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

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
            ->join('semesters', 'classes.id_semester', '=', 'semesters.id');

        $list_role = $list->select('classes.*', 'subjects.name_subject', 'subjects.number_of_credits', 'semesters.name_semester', 'semesters.year_semester');

        if ($request['id_user']){
            $list = $list->join('class_users', 'class_users.id_class', '=', 'classes.id')
                ->select('classes.*', 'subjects.name_subject', 'subjects.number_of_credits', 'semesters.name_semester', 'semesters.year_semester', 'class_users.id as id_class_user')
                ->where('class_users.id_user', $request['id_user']);
        }

        if ($request['id_semester']) $list = $list_role->where('id_semester', $request['id_semester']);
        if ($request['id_subject'])  $list = $list_role->where('id_subject', $request['id_subject']);

        return $list->get();
    }

    public function getClassDKHP($request)
    {
        $list_class = ClassUser::query()->where('id_user', $request['id_user'])->pluck('id_class');

        $list_class_dkhp = $this->model->whereNotIn('id', $list_class)->get();

        return $list_class_dkhp;
    }
}

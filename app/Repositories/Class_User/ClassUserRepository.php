<?php

namespace App\Repositories\Class_User;

use App\Models\ClassUser;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class ClassUserRepository extends BaseRepository implements ClassUserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\ClassUser::class;
    }

    public function getAllClassUser($request)
    {
        $list = $this->model->join('classes', 'classes.id', '=', 'class_users.id_class')
            ->join('users', 'users.id', '=', 'class_users.id_user')
            ->join('semesters', 'semesters.id', '=', 'classes.id_semester')
            ->select('class_users.*', 'users.name', 'users.code_user', 'classes.name_class', 'classes.code_class', 'classes.id_semester', 'semesters.name_semester', 'semesters.year_semester');

        if (Auth::user()->hasRole('teacher')){
            $list = $list->where('class_users.id_user', Auth::id());
        }

        if ($request['id_semester']) $list = $list->where('classes.id_semester', $request['id_semester']);

        return $list->get();
    }

    public function phanGiang($request)
    {
        $item = ClassUser::query()->where('id_class', $request['id_class'])->where('id_user', $request['id_user'])->first();

        if ($item){
            return false;
        }

        return $this->model->create($request);
    }
}

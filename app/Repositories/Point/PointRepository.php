<?php

namespace App\Repositories\Point;

use App\Models\ClassUser;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class PointRepository extends BaseRepository implements PointRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Point::class;
    }

    public function getAllPoint($request)
    {
        $list = $this->model->join('users', 'points.id_user', '=', 'users.id')
            ->join('classes', 'classes.id', '=', 'points.id_class')
            ->select('points.*', 'users.name as name_user', 'users.code_user', 'classes.name_class', 'classes.code_class');

        if ($request['id_user']) $list = $list->where('id_user', $request['id_user']);
        if ($request['id_class']) $list = $list->where('id_class', $request['id_class']);
        if (Auth::user()->hasRole('teacher')){
            $classes = ClassUser::query()->where('id_user', Auth::id())->select('id_class')->get();
            $list_class = [];
            foreach ($classes as $item){
                $list_class[] = $item->id_class;
            }

            $list = $list->whereIn('points.id_class', $list_class);
        }

        return $list->get();
    }

}

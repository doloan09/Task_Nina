<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function getUser()
    {
        return $this->model->select('id', 'name', 'email')->take(5)->get();
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteAvatar($id)
    {
        $user = $this->model->find($id);
        if ($user->avatar){
            return Storage::delete($user->avatar);
        }

        return false;
    }

    public function filterByRole($request)
    {
        $list = $this->model->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*', 'roles.name as name_role');

        if ($request['role'])       $list = $list->where('name_role', $request['role']);
        if ($request['code_user'])  $list = $list->where('code_user', $request['code_user']);

        return $list->get();
    }
}

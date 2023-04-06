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

}

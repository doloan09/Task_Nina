<?php

namespace App\Repositories\Notification;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Notification::class;
    }

    public function getNewest()
    {
        if (Auth::user()->hasRole('admin')) {
            $list = $this->model->orderBy('id', 'desc')->paginate(5);
        } else {
            $list = Auth::user()->notifications()->orderBy('notifications.id', 'desc')->paginate();
        }

        return $list;
    }

}

<?php

namespace App\Repositories\Notification;

use App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Notification::class;
    }

}

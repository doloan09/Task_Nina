<?php

namespace App\Providers;

use App\Repositories\Class_HP\ClassRepository;
use App\Repositories\Class_HP\ClassRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Point\PointRepository;
use App\Repositories\Point\PointRepositoryInterface;
use App\Repositories\Semester\SemesterRepository;
use App\Repositories\Semester\SemesterRepositoryInterface;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        UserRepositoryInterface::class         => UserRepository::class,
        NotificationRepositoryInterface::class => NotificationRepository::class,
        ClassRepositoryInterface::class        => ClassRepository::class,
        PointRepositoryInterface::class        => PointRepository::class,
        SemesterRepositoryInterface::class     => SemesterRepository::class,
        SubjectRepositoryInterface::class      => SubjectRepository::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // cach 1
//        $this->app->singleton(
//            UserRepositoryInterface::class,
//            UserRepository::class,
//        );
//
//        $this->app->singleton(
//            NotificationRepositoryInterface::class,
//            NotificationRepository::class,
//        );

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

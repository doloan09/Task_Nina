<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\FailedCollection;
use App\Http\Resources\SuccessCollection;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        try {
            $users = $this->userRepo->filterByRole($request);

            return Datatables::of($users)
                ->editColumn('avatar', function ($user) {
                    return '<img src="'. $user->url_avatar .'" alt="" class="img-avatar-list" style="width: 50px; height: 50px;" alt="avatar">';
                })
                ->editColumn('action', function ($user) {
                    return '<a href="' . route('users.edit', ['id' => $user->id]) . '" class="btn btn-xs btn-warning" style="margin: 0px 10px;">Update</a><button onclick="deleteUser('. $user->id .')" class="btn btn-xs btn-danger btn-delete">Delete</button>';
                })
                ->rawColumns(['avatar', 'action'])
                ->make(true);

        }catch (\Exception $e){
            return new FailedCollection($e);
        }
    }

    public function topSV(Request $request)
    {
        try {
            $users = $this->userRepo->topStudent($request);

            return Datatables::of($users)
                ->editColumn('avatar', function ($user) {
                    return '<img src="'. $user->url_avatar .'" alt="" class="img-avatar-list" style="width: 50px; height: 50px;" alt="avatar">';
                })
                ->rawColumns(['avatar'])
                ->make(true);

        }catch (\Exception $e){
            return new FailedCollection($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('user.create');
    }

    public function show($id)
    {
        try {
            $user = $this->userRepo->find($id);

            return new SuccessCollection($user);
        }catch (\Exception $e){
            return new FailedCollection($e);
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $data = request(['name', 'email', 'address', 'code_user', 'date_of_birth', 'sex', 'avatar', 'phone']);
            $time = new Carbon($request->get('date_of_birth'));
            $password = (($time->day < 10) ? ('0' . $time->day) : ($time->day)) . (($time->month < 10) ? ('0' . $time->month) : ($time->day)) . $time->year;
            $data['password'] = Hash::make($password);

            if ($request->hasFile('avatar')) {
//                $name = $request->file('avatar')->getClientOriginalName();
                $name = 'avatar_' . $request->get('name') . '_' . $request->get('code_user') . '_' . rand(0, 100) . '.' . $request->file('avatar')->extension();
                $path = $request->file('avatar')->storeAs('profile', $name);
                $data['avatar'] = $path;
            }

            $user = $this->userRepo->create($data);

            $role = $request->get('role');
            if ($role === 'admin'){
                $user->assignRole('admin');
            }elseif ($role === 'teacher'){
                $user->assignRole('teacher');
            }elseif ($role === 'student'){
                $user->assignRole('student');
            }

            return new SuccessCollection($user);
        }catch (\Exception $e){
            return new FailedCollection($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = $this->userRepo->find($id);
        return view('user.update', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('avatar')) {
                $this->userRepo->deleteAvatar($id);
                $name = 'avatar_' . $request->get('name') . '_' . $request->get('code_user') . '_' . rand(0, 100) . '.' . $request->file('avatar')->extension();
                $path = $request->file('avatar')->storeAs('profile', $name);
                $data['avatar'] = $path;
            }

            $user = $this->userRepo->update($id, $data);
            return new SuccessCollection($user);
        }catch (\Exception $e){
            return new FailedCollection($e);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->userRepo->find($id);
            $this->userRepo->deleteAvatar($id);
            $this->userRepo->delete($id);

            return new SuccessCollection($user);
        }catch (\Exception $e){
            return new FailedCollection($e);
        }
    }

    /**
     * Show the form for list a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list(){
        return $this->userRepo->viewList('user.list');
    }

}

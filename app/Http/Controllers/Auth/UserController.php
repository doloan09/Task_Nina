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
use Illuminate\Support\Facades\Storage;
use Symfony\Component\ErrorHandler\Debug;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Editor\Fields\Image;

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

    public function index()
    {
        try {
            $users = $this->userRepo->getAll();

            return Datatables::of($users)
                ->editColumn('avatar', function ($user) {
                    return '<img src="'. Storage::url($user->avatar) .'" alt="" class="img-avatar-list" style="width: 50px; height: 50px;" alt="avatar">';
                })
                ->editColumn('action', function ($user) {
                    return '<a href="' . route('users.edit', ['id' => $user->id]) . '" class="btn btn-xs btn-warning">Update</a><button onclick="deleteUser('. $user->id .')" class="btn btn-xs btn-danger btn-delete">Delete</button>';
                })
                ->rawColumns(['avatar', 'action'])
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

//            dd($request->all());

            if ($request->hasFile('avatar')) {
//                $name = $request->file('avatar')->getClientOriginalName();
                $name = 'avatar_' . $request->get('name') . '_' . $request->get('code_user') . '_' . rand(0, 100) . '.' . $request->file('avatar')->extension();
                $path = $request->file('avatar')->storeAs('public/profile', $name);
                $data['avatar'] = $path;
            }

            $user = $this->userRepo->create($data);

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
        return view('user.update');
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            $user = $this->userRepo->update($id, $data);
            return new SuccessCollection($user);
        }catch (\Exception $e){
            return new FailedCollection($e);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->userRepo->delete($id);

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

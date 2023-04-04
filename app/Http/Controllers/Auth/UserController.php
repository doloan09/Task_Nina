<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\FailedCollection;
use App\Http\Resources\SuccessCollection;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

            return new SuccessCollection($users);
        }catch (\Exception $e){
            return new FailedCollection($e);
        }
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
            $data = request(['name', 'email', 'password']);
            $data['password'] = Hash::make($request->get('password'));

            $user = $this->userRepo->create($data);

            return new SuccessCollection($user);
        }catch (\Exception $e){
            return new FailedCollection($e);
        }
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
}

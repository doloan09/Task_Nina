<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassUserRequest;
use App\Http\Resources\FailedCollection;
use App\Http\Resources\SuccessCollection;
use App\Models\Point;
use App\Repositories\Class_User\ClassUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ClassUserController extends Controller
{
    protected ClassUserRepositoryInterface $classUserRepo;

    public function __construct(ClassUserRepositoryInterface $classUserRepo)
    {
        $this->classUserRepo = $classUserRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return FailedCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $list = $this->classUserRepo->getAllClassUser($request);

            if (Auth::user()->hasRole('admin')) {
                return Datatables::of($list)
                    ->editColumn('name_class', function ($item) {
                        return $item->name_class;
                    })
                    ->editColumn('action', function ($item) {
                        return '<button onclick="setValuePhanGiang(' . $item->id . ', ' . $item->id_class . ', ' . $item->id_user . ')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#PhanGiang" style="margin: 0px 20px;">Sửa</button>
                                <button onclick="deleteClassUser(' . $item->id_class . ')" class="btn btn-xs btn-danger btn-delete">Xóa</button>';
                    })
                    ->rawColumns(['name_semester', 'action'])
                    ->make(true);
            }else{
                return Datatables::of($list)
                    ->editColumn('name_semester', function ($item) {
                        return '<p>' . $item->name_semester . '_' . $item->year_semester . '</p>';
                    })
                    ->editColumn('action', function ($item) {
                        return '<button class="btn btn-xs btn-warning" style="margin: 0px 20px;" disabled="disabled">Sửa</button>
                                <button class="btn btn-xs btn-danger btn-delete" disabled="disabled">Xóa</button>';
                    })
                    ->rawColumns(['name_semester', 'action'])
                    ->make(true);
            }
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\Response
     */
    public function store(ClassUserRequest $request)
    {
        try {
            $data = $request->only(['id_class', 'id_user']);

            $item = $this->classUserRepo->phanGiang($data);
            if ($item) {
                return new SuccessCollection($item);
            }

            return new FailedCollection(collect([]));
        }catch (\Exception $exception){
            return new FailedCollection(collect([$exception]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            $item = $this->classUserRepo->update($id, $data);
            return new SuccessCollection($item);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return FailedCollection|SuccessCollection|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->classUserRepo->find($id);
            $check = Point::query()->where('id_user', $item->id_user)->where('id_class', $item->id_class)->first();
            if ($check){
                return new FailedCollection(collect([]));
            }else {
                $this->classUserRepo->delete($id);

                return new SuccessCollection($item);
            }
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
    }

    public function list(){
        return $this->classUserRepo->viewList('classes.list_phan_giang');
    }

}

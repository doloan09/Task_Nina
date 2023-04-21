<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRequest;
use App\Http\Resources\FailedCollection;
use App\Http\Resources\SuccessCollection;
use App\Repositories\Class_HP\ClassRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ClassHPController extends Controller
{
    protected ClassRepositoryInterface $classRepo;

    public function __construct(ClassRepositoryInterface $classRepo)
    {
        $this->classRepo = $classRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return FailedCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->query('dkph')){
                $list = $this->classRepo->getClassDKHP($request);
            }else {
                $list = $this->classRepo->getAllClass($request);
            }

            if (Auth::user()->hasRole('admin')) {
                return Datatables::of($list)
                    ->editColumn('name_semester', function ($item) {
                        return $item->name_semester . '_' . $item->year_semester;
                    })
                    ->editColumn('action', function ($item) {
                        $name = "'" . $item->name_class . "'";
                        $code = "'" . $item->code_class . "'";

                        return '<a href="' . route('classes.show', ['id' => $item->id, 'name_class' => $item->name_class]) . '" class="btn btn-xs btn-info">Xem</a>
                                <button onclick="setValue(' . $item->id . ', ' . $name . ', ' . $code . ', ' . $item->id_subject . ', ' . $item->id_semester . ')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createClass" style="margin: 0px 10px;">Sửa</button>
                                <button onclick="deleteClass(' . $item->id . ')" class="btn btn-xs btn-danger btn-delete">Xóa</button>';
                    })
                    ->rawColumns(['name_semester', 'action'])
                    ->make(true);
            }else{
                return Datatables::of($list)
                    ->editColumn('name_semester', function ($item) {
                        return $item->name_semester . '_' . $item->year_semester;
                    })
                    ->editColumn('action', function ($item) {

                        return '<button onclick="deleteDK_HP(' . $item->id_class_user . ')" class="btn btn-xs btn-danger btn-delete">Hủy ĐK</button>';
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
    public function store(ClassRequest $request)
    {
        try {
            $data = request(['name_class', 'code_class', 'id_subject', 'id_semester']);

            $item = $this->classRepo->create($data);

            return new SuccessCollection($item);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return FailedCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $list = $this->classRepo->getAllUserInClass($id);
            return Datatables::of($list)
                ->editColumn('action', function ($item) {
                    return '<button onclick="deleteDK_HP(' . $item->id_class_user . ')" class="btn btn-xs btn-danger btn-delete" style="margin-left: 20px;">Xóa</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
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
    public function update(ClassRequest $request, $id)
    {
        try {
            $data = $request->all();

            $item = $this->classRepo->update($id, $data);
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
            $item = $this->classRepo->find($id);
            $this->classRepo->delete($id);

            return new SuccessCollection($item);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
        }
    }

    /**
     * Show the form for list a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list(){
        return $this->classRepo->viewList('classes.list');
    }

    public function view_show(){
        return $this->classRepo->viewList('classes.list_user_class');
    }

}

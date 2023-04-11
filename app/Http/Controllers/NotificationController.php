<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Http\Resources\FailedCollection;
use App\Http\Resources\SuccessCollection;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NotificationController extends Controller
{
    protected NotificationRepositoryInterface $notiRepo;

    public function __construct(NotificationRepositoryInterface $notiRepo)
    {
        $this->notiRepo = $notiRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return FailedCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $list = $this->notiRepo->getAll();

            return Datatables::of($list)
                ->editColumn('content', function ($item) {
                    return '<p style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden; width: 500px;">' . $item->content . '</p>';
                })
                ->editColumn('action', function ($item) {
                    $title = "'" . $item->title . "'";
                    $content = "'" . $item->content . "'";
                    return '<button onclick="setValue('. $item->id .', '. $title .', '. $content .')" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createNoti" style="margin: 0px 10px;">Update</button><button onclick="deleteNoti('. $item->id .')" class="btn btn-xs btn-danger btn-delete">Delete</button>';
                })
                ->rawColumns(['content', 'action'])
                ->make(true);
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
    public function store(NotificationRequest $request)
    {
        try {
            $data = request(['title', 'content']);

            $item = $this->notiRepo->create($data);

            return new SuccessCollection($item);
        }catch (\Exception $e){
            return new FailedCollection(collect([$e]));
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

            $user = $this->notiRepo->update($id, $data);
            return new SuccessCollection($user);
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
            $item = $this->notiRepo->find($id);
            $this->notiRepo->delete($id);

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
        return $this->notiRepo->viewList('notifications.list');
    }
}

@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý điểm </h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <a href="#" class="btn btn-xs btn-warning">Create</a>
        </div>
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Điểm thành phần</th>
                <th>Điểm thi</th>
                <th>Điểm tổng kết</th>
                <th>Mã sinh viên</th>
                <th>Mã lớp học phần</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
            </thead>
        </table>
    </div>
@stop

@push('scripts')
    <script>
        $(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('points.index') !!}',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'score_component', name: 'score_component'},
                    {data: 'score_test', name: 'score_test'},
                    {data: 'score_final', name: 'score_final'},
                    {data: 'id_user', name: 'id_user'},
                    {data: 'id_class', name: 'id_class'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'}
                ]
            });
        });
    </script>
@endpush

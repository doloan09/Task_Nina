@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý lớp học phần</h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <a href="#" class="btn btn-xs btn-warning">Create</a>
        </div>
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Tên lớp học phần</th>
                <th>Mã lớp học phần</th>
                <th>Mã môn học</th>
                <th>Mã kỳ học</th>
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
                    url: '{!! route('classes.index') !!}',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name_class', name: 'name_class'},
                    {data: 'code_class', name: 'code_class'},
                    {data: 'id_subject', name: 'id_subject'},
                    {data: 'id_semester', name: 'id_semester'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'}
                ]
            });
        });
    </script>
@endpush

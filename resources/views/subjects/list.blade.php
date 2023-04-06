@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý môn học</h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <a href="#" class="btn btn-xs btn-warning">Create</a>
        </div>
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Tên môn học</th>
                <th>Mã môn học</th>
                <th>Số tín chỉ</th>
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
                    url: '{!! route('subjects.index') !!}',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name_subject', name: 'name_subject'},
                    {data: 'code_subject', name: 'code_subject'},
                    {data: 'number_of_credits', name: 'number_of_credits'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'}
                ]
            });
        });
    </script>
@endpush

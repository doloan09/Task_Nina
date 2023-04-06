@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý người dùng</h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <a href="{{ route('users.create') }}" class="btn btn-xs btn-warning">Create</a>
        </div>
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Avatar</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Ngày sinh</th>
                <th>Địa chỉ</th>
                <th>Giới tính</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
@stop

@push('scripts')
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('v1.users.index') !!}',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'avatar', name: 'avatar' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'date_of_birth', name: 'date_of_birth' },
                    { data: 'address', name: 'address' },
                    { data: 'sex', name: 'sex' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: '' },
                ]
            });
        });

        function deleteUser(id){
            if (confirm('Ban co muon xoa khong?') === true) {
                $.ajax({
                    url: `http://nina-soft.com/api/v1/users/` + id,
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "DELETE",
                    success: function (data) {
                        alert("Successful delete");
                        window.location = "/users";
                    },
                    error: function (err) {
                        alert('error');
                    }
                })
            }
        }
    </script>
@endpush

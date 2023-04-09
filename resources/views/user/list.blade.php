@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý người dùng</h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <div style="float: left;">
                <a href="{{ route('users.create') }}" class="btn btn-xs btn-warning">Create</a>
            </div>
            <div style="margin-top: 20px; margin-bottom: 20px; float: right; display: flex">
                <p style="margin-right: 10px;">Vai trò:</p>
                <select id="filter_role">
                    <option value="">- Tất cả -</option>
                    <option value="admin">admin</option>
                    <option value="teacher">teacher</option>
                    <option value="student">student</option>
                </select>
            </div>
        </div>
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Avatar</th>
                <th>Họ tên</th>
                <th>MSV / MNV</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Ngày sinh</th>
                <th>Địa chỉ</th>
                <th>Giới tính</th>
                <th>Chức vụ</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
@stop

@push('scripts')
    <script>
        $('#filter_role').on('change', function() {
            let role = document.getElementById('filter_role').value;
            console.log(role);
            getData(role);
        });

        var tableUser = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'http://nina-soft.com/api/v1/users?role=',
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'avatar', name: 'avatar'},
                {data: 'name', name: 'name'},
                {data: 'code_user', name: 'code_user'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {
                    data: 'date_of_birth',
                    render: function (date_of_birth){
                        date = new Date(date_of_birth);
                        return pad(date.getDate()) + '-' + pad(date.getMonth() + 1) + '-' + date.getFullYear();
                    }
                },
                {data: 'address', name: 'address'},
                {data: 'sex', name: 'sex'},
                {data: 'name_role', name: 'name_role'},
                {data: 'action', name: ''},
            ]
        });

        function pad(num){
            return (num <= 9) ? '0' + num : num;
        }

        function getData(role = '') {
            tableUser
                .columns([9])
                .search(role)
                .draw();
        }

        function deleteUser(id){
            if (confirm('Ban co muon xoa khong?') === true) {
                $.ajax({
                    url: `http://nina-soft.com/api/v1/users/` + id,
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}',
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "DELETE",
                    success: function (data) {
                        window.location = "{{ route('users.list') }}";
                    },
                    error: function (err) {
                        alert('error');
                        console.log(err);
                    }
                });
            }
        }
    </script>
@endpush

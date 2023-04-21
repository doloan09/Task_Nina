@extends('layouts.master')

@section('title', 'Quản lý người dùng')

<style>
    #users-table_filter input{
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }

    #users-table_filter input:focus-visible{
        outline: none;
    }

    #users-table_length select{
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        background-color: white;
    }

    #users-table_length select:focus-visible{
        outline: none;
    }

    #users-table_paginate {
        margin-top: 20px;
    }

</style>

@section('content')
    <div style="margin-top: 70px;">
        <p style="color: #707070; font-size: 25px;">Quản lý người dùng</p>
        <div style="margin-top: 20px; margin-bottom: 20px; display: flex; justify-content: right;">
            <div class="dropdown" style="margin-right: 10px;">
                <button class="dropbtn">Bộ lọc</button>
                <div class="dropdown-content" style="padding: 30px 20px;">
                    <span style="margin-right: 10px;">Vai trò:</span>
                    <select id="filter_role" style="border: 1px #ccc solid; border-radius: 5px; background-color: white; margin-top: 10px; padding: 5px;">
                        <option value="">---</option>
                        <option value="admin">admin</option>
                        <option value="teacher">teacher</option>
                        <option value="student">student</option>
                    </select>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Thao tác</button>
                <div class="dropdown-content">
                    <div style="padding: 10px 12px;">
                        <a href="{{ route('users.create') }}" style="color: black; ">Thêm mới</a>
                    </div>
                </div>
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
                <th style="width: 10%;">Action</th>
            </tr>
            </thead>
        </table>
    </div>
@stop

@push('scripts')
    <script>
        $('#users-table').removeClass('table-bordered');
        $('#users-table').addClass('table-striped table-hover');

        $('#filter_role').on('change', function() {
            let role = document.getElementById('filter_role').value;
            console.log(role);
            getData(role);
        });

        var tableUser = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            "bInfo" : false,
            order: [[9, 'desc']],
            language: {
                paginate: {
                    next: '>',
                    previous: '<'
                }
            },
            ajax: {
                url: '{{ env('URL_API') }}' + 'users?role=',
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'avatar', name: 'avatar', orderable: false, searchable: false},
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
                {data: 'action', name: '', orderable: false, searchable: false},
            ],
            "columnDefs": [
                { className: "my_class", "targets": [ 0, 3, 5, 6, 8, 10 ] }
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
            if (confirm('Bạn có muốn xóa không?') === true) {
                $.ajax({
                    url: '{{ env('URL_API') }}' + `users/` + id,
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}',
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "DELETE",
                    success: function (data) {
                        if (data.response.code === 500){
                            toastr.error('Bạn không thể xóa người dùng này! Có nhiều dữ liệu ràng buộc!', 'Error');
                        }else {
                            toastr.success('Xóa người dùng thành công!', 'Success');
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error: function (err) {
                        toastr('Có lỗi khi xóa thông tin người dùng!', 'Error');
                        console.log(err);
                    }
                });
            }
        }
    </script>
@endpush

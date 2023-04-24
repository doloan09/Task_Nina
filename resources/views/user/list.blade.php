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
                    <select id="filter_role" style="border: 1px #ccc solid; border-radius: 5px; background-color: white; margin-top: 10px; padding: 5px; width: 150px;">
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
                        <p data-toggle="modal" data-target="#importUser" onclick="setErrImportDefaul()" style="margin-top: 15px;">Import</p>
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

    <!-- Modal import -->
    <div class="modal fade" id="importUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; justify-content: center">
                    <h3 class="modal-title" id="exampleModalLabel">Import thông tin người dùng</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="import-user" enctype="multipart/form-data" style="margin: 0px 20px;">
                        @csrf
                        <div class="row">
                            <div class="" style="padding-right: 0;">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label" style="width: 100%;">Chọn file</label>
                                    <input type="file" name="file" id="input-import">
                                </div>
                            </div>
                            <div class="" style="padding-right: 0; margin-top: 30px;">
                                <p for="example-text-input" class="form-control-label" style="width: 100%;" id="message-err"></p>
                                <div style="margin-top: 5px; " id="div_err_err">

                                </div>
                                <div style="margin-top: 5px; " id="div_err_errData">

                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 20px; margin-bottom: 20px; display: flex; justify-content: right; font-size: small;">
                            <button type="submit" class="btn btn-xs btn-warning" style="padding: 8px;" id="btn-import">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

        function setErrImportDefaul(){
            $('#message-err').html('');
            $('#div_err_err').html('');
            $('#div_err_errData').html('');
        }

        $("#import-user").submit(function (e) {
            e.preventDefault();

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: '{{ route('v1.users.import') }}',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "POST",
                data: formData,
                success: function (data) {
                    if (data.status === 200) {
                        toastr.success('Import thành công!', 'Success');
                        setTimeout(function (){
                            window.location.reload();
                        }, 1000);
                    }
                    else if (data.status === 404){
                        toastr.error('Vui lòng chọn file trước khi import!');
                    }
                    else if (data.status === 500){
                        toastr.error(data.Err_Message, 'Error');
                        let err = data.err;
                        let errData = data.errData;

                        if (err.length || errData.length){
                            $('#message-err').html('>> Có lỗi khi import:');
                        }
                        if (err.length){
                            let str_err = '';
                            for (let key in err) {
                                str_err += `<p style="color: red; font-size: small;">* Hàng ` + err[key]['row'] + ` - ` + err[key]['err'] + `</p>`;
                            }
                            $("#div_err_err").html(str_err);
                        }

                        if (errData.length){
                            let str_err = '';
                            for (let key in errData) {
                                str_err += `<p style="color: red; font-size: small;">* Hàng ` + errData[key]['row'] + ` - ` + errData[key]['err'] + `</p>`;
                            }
                            $("#div_err_errData").html(str_err);
                        }
                    }
                },
                error: function (err) {
                    if (err.status === 500){
                        toastr.error(err.statusText);
                        console.log(err);
                    }
                },
            });
            return true;
        });

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

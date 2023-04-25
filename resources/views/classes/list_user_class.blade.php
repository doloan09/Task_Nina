@extends('layouts.master')
@section('title', 'Quản lý lớp học phần')

<style>
    #user-class-table_filter input{
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }

    #user-class-table_filter input:focus-visible{
        outline: none;
    }

    #user-class-table_length select{
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        background-color: white;
    }

    #user-class-table_length select:focus-visible{
        outline: none;
    }

    #user-class-table_paginate {
        margin-top: 20px;
    }

    #user-class-table tbody tr td{
        padding: 15px 0;
    }

</style>

@section('content')
    <div style="margin-top: 70px;">
        <div style="margin-bottom: 80px;">
            <p style="color: #707070; font-size: 25px;">Danh sách lớp học phần: {{ $_GET['name_class'] }}</p>
            <p style="font-size: 16px;" id="sum-user">

            </p>
        </div>
        <table class="table table-bordered" id="user-class-table">
            <thead>
            <tr>
                <th>Họ tên</th>
                <th>Mã sinh viên</th>
                <th>Email</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th style="width: 10%;">Action</th>
            </tr>
            </thead>
        </table>
    </div>

@endsection

@push('scripts')
    <script>
        $('#user-class-table').removeClass('table-bordered');
        $('#user-class-table').addClass('table-striped table-hover');

        getSumUser();

        var table_user = $('#user-class-table').DataTable({
            processing: true,
            serverSide: true,
            "bInfo": false,
            language: {
                paginate: {
                    next: '>',
                    previous: '<'
                }
            },
            ajax: {
                url: '{{ env('URL_API') }}' + 'classes/' + '{{ $_GET['id'] }}',
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'code_user', name: 'code_user'},
                {data: 'email', name: 'email'},
                {
                    data: 'date_of_birth',
                    render: function (date_of_birth){
                        date = new Date(date_of_birth);
                        return pad(date.getDate()) + '-' + pad(date.getMonth() + 1) + '-' + date.getFullYear();
                    }
                },
                {data: 'sex', name: 'sex'},
                {data: 'action', name: '', orderable: false, searchable: false},
            ],
            "columnDefs": [
                { className: "my_class", "targets": [ 1, 3, 4 ] }
            ]
        });

        function pad(num){
            return (num <= 9) ? '0' + num : num;
        }

        function getSumUser(){
            $.ajax({
                url: '{{ env('URL_API') }}' + 'classes/' + '{{ $_GET['id'] }}',
                processData: false,
                contentType: false,
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "GET",
                success: function (data) {
                    let list = data.data;

                    $('#sum-user').text('Tổng sinh viên: ' + list.length);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        function deleteDK_HP(id){
            if (confirm('Ban co muon xoa khong?') === true) {
                $.ajax({
                    url: '{{ env('URL_API') }}' + `class-user/` + id,
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}',
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "DELETE",
                    success: function (data) {
                        if (data.response.code === 500){
                            toastr.error('Bạn không thể xóa sinh viên này ra khỏi lớp học!', 'Error');
                        }else {
                            toastr.success('Xóa bản ghi thành công!');
                            setTimeout(function (){
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error: function (err) {
                        toastr.error(err.statusText);
                        console.log(err);
                    }
                });
            }
        }

     </script>
@endpush

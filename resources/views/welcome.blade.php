@extends('layouts.master')

@section('content')
    <div style="display: flex; margin-top: 20px;">
        <div style="height: 200px; background-color: royalblue; border-radius: 10px; color: white; margin: 10px 0; width: 22%;">
            <p class="text-center" style="padding-top: 15px; font-size: 20px; ">Người dùng</p>
            <p class="text-center" style="font-size: 35px; padding-top: 30px;">141509</p>
        </div>
        <div style="height: 200px; background-color: #eea236; border-radius: 10px; color: white; margin: 10px 20px; width: 22%;">
            <p class="text-center" style="padding-top: 15px; font-size: 20px; ">Lớp học phần</p>
            <p class="text-center" style="font-size: 35px; padding-top: 30px;">140998</p>
        </div>
        <div style="height: 200px; background-color: #b44593; border-radius: 10px; color: white; margin:10px 20px 10px 0; width: 22%;">
            <p class="text-center" style="padding-top: 15px; font-size: 20px; ">Môn học</p>
            <p class="text-center" style="font-size: 35px; padding-top: 30px;">150901</p>
        </div>
        <div style="height: 200px; background-color: forestgreen; border-radius: 10px; color: white; margin: 10px 0; width: 22%;">
            <p class="text-center" style="padding-top: 15px; font-size: 20px; ">Thông báo</p>
            <p class="text-center" style="font-size: 35px; padding-top: 30px;">2198</p>
        </div>
    </div>
    <div style="margin: 20px 0;">
        <p style="font-size: 25px; ">Sinh viên</p>
        <p style="margin-bottom: 30px;">Top 10 sinh viên có điểm tổng kết cao nhất</p>
        <table class="table table-bordered" id="users-top-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Avatar</th>
                <th>Họ tên</th>
                <th>MSV / MNV</th>
                <th>Email</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
{{--                <th>Điểm tổng kết</th>--}}
            </tr>
            </thead>
        </table>
    </div>
    <div style="margin: 40px 0;">
        <p style="font-size: 25px; ">Thông báo</p>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#users-top-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'http://nina-soft.com/api/v1/users/top',
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
                    {
                        data: 'date_of_birth',
                        render: function (date_of_birth){
                            date = new Date(date_of_birth);
                            return pad(date.getDate()) + '-' + pad(date.getMonth() + 1) + '-' + date.getFullYear();
                        }
                    },
                    {data: 'sex', name: 'sex'},
                    // {data: '', name: ''},
                ],
                "searching": false,
                "paging": false,
                "bInfo" : false,
            });
        });

        function pad(num){
            return (num <= 9) ? '0' + num : num;
        }
    </script>
@endpush

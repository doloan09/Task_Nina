@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')
    <div style="display: flex; margin-top: 70px;">
        <div style="height: 200px; background-color: royalblue; border-radius: 10px; color: white; margin: 10px 0; width: 24%;">
            <p class="text-center" style="padding-top: 15px; font-size: 20px; ">Người dùng</p>
            <p class="text-center" style="font-size: 35px; padding-top: 30px;">{{ count(\App\Models\User::query()->select('id')->get()) }}</p>
        </div>
        <div style="height: 200px; background-color: #eea236; border-radius: 10px; color: white; margin: 10px 20px; width: 24%;">
            <p class="text-center" style="padding-top: 15px; font-size: 20px; ">Lớp học phần</p>
            <p class="text-center" style="font-size: 35px; padding-top: 30px;">{{ count(\App\Models\Class_HP::query()->select('id')->get()) }}</p>
        </div>
        <div style="height: 200px; background-color: #b44593; border-radius: 10px; color: white; margin:10px 20px 10px 0; width: 24%;">
            <p class="text-center" style="padding-top: 15px; font-size: 20px; ">Môn học</p>
            <p class="text-center" style="font-size: 35px; padding-top: 30px;">{{ count(\App\Models\Subject::query()->select('id')->get()) }}</p>
        </div>
        <div style="height: 200px; background-color: forestgreen; border-radius: 10px; color: white; margin: 10px 0; width: 24%;">
            <p class="text-center" style="padding-top: 15px; font-size: 20px; ">Thông báo</p>
            <p class="text-center" style="font-size: 35px; padding-top: 30px;">{{ count(\App\Models\Notification::query()->select('id')->get()) }}</p>
        </div>
    </div>
    <div style="margin: 20px 0;">
        <p style="font-size: 25px; color: #707070;">Sinh viên</p>
        <p style="margin-bottom: 30px;">>> Top 5 sinh viên có điểm tổng kết trung bình cao nhất</p>
        <table class="table table-bordered" id="users-top-table">
            <thead>
            <tr>
                <th>Id User</th>
                <th>Avatar</th>
                <th>Họ tên</th>
                <th>MSV / MNV</th>
                <th>Email</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Điểm trung bình</th>
            </tr>
            </thead>
        </table>
    </div>
    <div style="margin: 40px 0;">
        <p style="font-size: 25px; color: #707070; ">Thông báo</p>
        <div>
            <p>>> Thông báo mới</p>
            <div style="margin-left: 40px;">
                <ul id="list-noti">
                    <li style="margin-bottom: 10px;">
                        <a href="#">Tiêu đề thông báo 1</a>
                    </li>
                    <li style="margin-bottom: 10px;">
                        <a href="#">Tiêu đề thông báo 2</a>
                    </li>
                    <li style="margin-bottom: 10px;">
                        <a href="#">Tiêu đề thông báo 3</a>
                    </li>
                    <li style="margin-bottom: 10px;">
                        <a href="#">Tiêu đề thông báo 4</a>
                    </li>
                    <li style="margin-bottom: 10px;">
                        <a href="#">Tiêu đề thông báo 5</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#users-top-table').removeClass('table-bordered');
        $('#users-top-table').addClass('table-striped table-hover');

        showNoti();
        function showNoti(){
            $.ajax({
                url: '{{ route('v1.notifications.newest') }}',
                processData: false,
                contentType: false,
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "GET",
                success: function (data) {
                    let list = data.data;
                    let str = '';
                    for (let item in list){
                        let url = '{{ env('APP_URL') }}' + 'notifications/' + list[item]['id'];

                        str += `<li style="margin-bottom: 10px;">
                                    <a href="`+ url + `">` + list[item]['title'] + `</a>
                                </li>`;
                    }

                    $('#list-noti').html(str);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        $(function() {
            $('#users-top-table').DataTable({
                processing: true,
                serverSide: true,
                order: [[7, 'desc']],
                ajax: {
                    url: '{{ env('URL_API') }}' + 'users/top',
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
                    {data: 'diemTB', name: 'diemTB'},
                ],
                "searching": false,
                "paging": false,
                "bInfo" : false,
                "columnDefs": [
                    { className: "my_class", "targets": [ 0, 3, 5, 6, 7 ] }
                ]
            });
        });

        function pad(num){
            return (num <= 9) ? '0' + num : num;
        }
    </script>
@endpush

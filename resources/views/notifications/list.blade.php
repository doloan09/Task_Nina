@extends('layouts.master')

@section('title', 'Quản lý thông báo')

<style>
    #notifications-table_filter input{
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }

    #notifications-table_filter input:focus-visible{
        outline: none;
    }

    #notifications-table_length select{
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        background-color: white;
    }

    #notifications-table_length select:focus-visible{
        outline: none;
    }

    #notifications-table_paginate {
        margin-top: 20px;
    }

</style>

@section('content')

    {{--  admin  --}}
    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
        <div>
            <p style="color: #707070; font-size: 25px;">Quản lý thông báo</p>
            <div style="margin-top: 20px; margin-bottom: 20px; display: flex; justify-content: right;">
                <div class="dropdown">
                    <button class="dropbtn">Thao tác</button>
                    <div class="dropdown-content">
                        <p data-toggle="modal" data-target="#createNoti">Thêm mới</p>
                    </div>
                </div>
            </div>
            <table class="table table-bordered" id="notifications-table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th style="width: 15%;">Action</th>
                </tr>
                </thead>
            </table>
        </div>

        <!-- Modal create -->
        <div class="modal fade" id="createNoti" tabindex="-1" role="dialog" data-target=".bd-example-modal-" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="display: flex; justify-content: center">
                        <h3 class="modal-title" id="exampleModalLabel">Nội dung thông báo</h3>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="create-notification" enctype="multipart/form-data" style="margin: 0px 20px;">
                            @csrf
                            <div class="row">
                                <input id="id_noti" name="id_noti" class="form-control" type="text" style="display: none;">
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tiêu đề thông báo</label>
                                        <input id="title" name="title" class="form-control" type="text" placeholder="Nhập vào tiêu đề thông báo ..." required>
                                        <div style="margin-top: 5px; " id="div_err_title">

                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nội dung thông báo</label>
                                        <textarea rows="25" id="content" name="content" class="form-control" type="text" placeholder="Nhập vào nội dung thông báo ... " required></textarea>
                                        <div style="margin-top: 5px; " id="div_err_content">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 20px; margin-bottom: 20px; display: flex; justify-content: right; font-size: small;">
                                <button type="submit" class="btn btn-xs btn-warning" style="padding: 8px;">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal gui thong bao -->
        <div class="modal fade" id="sendNotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="display: flex; justify-content: center">
                        <h3 class="modal-title" id="exampleModalLabel">Gửi thông báo</h3>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="send-notification" enctype="multipart/form-data" style="padding-right: 0;">
                            @csrf
                            <input hidden="hidden" value="" id="id_noti_send">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label" style="width: 100%;">Thông báo:</label>
                                <p id="content-noti">
                                    Thông báo Lịch thu LỆ PHÍ THI ĐÁNH GIÁ TRÌNH ĐỘ NGOẠI NGỮ - Học kỳ II - Năm học 2022-2023 sinh viên các khóa 62 trở về trước (đợt học 9) (10/03/2023)
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label" style="width: 100%;">Đối tượng gửi thông báo: </label>
                                <div style="display: flex;">
                                    <div style="margin-right: 20px;">
                                        <input type="radio" name="role" value="teacher" checked>
                                        <label for="html">Giảng viên</label><br>
                                    </div>
                                    <div>
                                        <input type="radio" name="role" value="student">
                                        <label for="css">Sinh viên</label><br>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: right; margin-top: 40px; ">
                                <button type="submit" class="btn btn-xs btn-warning" style="padding: 5px 10px">
                                    Gửi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endif

    {{--  teacher --}}
    @if(\Illuminate\Support\Facades\Auth::user()->hasRole('teacher'))
        <div style="">
            <p style="font-size: 25px; color: #707070; ">Danh sách thông báo</p>
            <div>
                <div style="margin-left: 40px;">
                    <ul id="list-noti">

                    </ul>
                </div>
            </div>
        </div>
    @endif
@stop

@push('scripts')
    <script>

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
                    console.log(list);
                    let str = '';
                    for (let item in list){
                        let url = '{{ env('APP_URL') }}' + 'notifications/' + list[item]['id_notification'];

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

        function setValueNoti(id, title){
            $('#id_noti_send').val(id);
            $('#content-noti').html(title);
        }

        $(function() {
            $('#notifications-table').DataTable({
                processing: true,
                serverSide: true,
                "bInfo" : false,
                language: {
                    paginate: {
                        next: '>',
                        previous: '<'
                    }
                },
                ajax: {
                    url: '{!! route('v1.notifications.index') !!}',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'content', name: 'content' },
                    // {
                    //     data: 'content', render: function (content){
                    //         return '<p style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden; width: 500px;">' + content +'</p>'
                    //     }
                    // },
                    { data: 'action', name: '', orderable: false, searchable: false},
                ]
            });
        });

        $("#create-notification").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('title', $("#title").val());
            formData.append('content', $("#content").val());

            $.ajax({
                url: '{{ route('v1.notifications.store') }}',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                method: "POST",
                data: formData,
                success: function (data) {
                    if (data.response.code === 200) {
                        toastr.success('Thêm mới thông báo thành công!', 'Success');
                        window.location = "{{ route('notifications.list') }}";
                    }
                },
                error: function (err) {
                    if (err.status === 422) {
                        let errList = err.responseJSON.Err_Message;

                        for (let key in errList) {
                            $("#div_err_" + key).html(`<p style="color: red; font-size: small;">* ` + errList[key] + `</p>`);
                        }

                        console.log(err);
                    }else if (err.status === 500){
                        toastr.error(err.statusText);
                        console.log(err);
                    }
                },
            });
            return true;
        });

        $("#send-notification").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('id', $("#id_noti_send").val());
            formData.append('role', $('input[name="role"]:checked').val());

            $.ajax({
                url: '{{ route('v1.notifications.send') }}',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                method: "POST",
                data: formData,
                success: function (data) {
                    if (data.response.code === 200) {
                        toastr.success('Gửi thông báo thành công!', 'Success');
                        {{--window.location = "{{ route('notifications.list') }}";--}}
                    }else {
                        toastr.error('Thông báo này đã được gửi! Bạn không thể gửi lần 2!');
                    }
                },
                error: function (err) {
                    if (err.status === 422) {
                        let errList = err.responseJSON.Err_Message;

                        for (let key in errList) {
                            $("#div_err_" + key).html(`<p style="color: red; font-size: small;">* ` + errList[key] + `</p>`);
                        }

                        console.log(err);
                    }else if (err.status === 500){
                        toastr.error(err.statusText);
                        console.log(err);
                    }
                },
            });
            return true;
        });

        function deleteNoti(id){
            if (confirm('Ban co muon xoa khong?') === true) {
                $.ajax({
                    url: '{{ env('URL_API') }}' + `notifications/` + id,
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}',
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "DELETE",
                    success: function (data) {
                        if (data.response.code === 500){
                            toastr.error('Bạn không thể xóa! Thông báo này đã được gửi!', 'Error');
                        }else{
                            window.location = "{{ route('notifications.list') }}";
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

@extends('layouts.master')
@section('title', 'Quản lý lớp học phần')

@section('content')
    <div>
        <p style="color: #707070; font-size: 25px; ">Danh sách phân giảng</p>
        <div style="margin-top: 20px; margin-bottom: 20px; display: flex; justify-content: right;">
            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
                <div class="dropdown">
                    <button class="dropbtn">Thao tác</button>
                    <div class="dropdown-content" style="min-width: 120px;">
                        <p data-toggle="modal" data-target="#PhanGiang" id="phan_giang_btn">Phân giảng</p>
                    </div>
                </div>
            @endif
        </div>
        <table class="table table-bordered" id="class-users-table">
            <thead>
            <tr>
                <th>Tên lớp học phần</th>
                <th>Mã lớp học phần</th>
                <th>Giảng viên</th>
                <th style="width: 10%;">Action</th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- Modal phan giang -->
    <div class="modal fade" id="PhanGiang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; justify-content: center">
                    <h3 class="modal-title" id="exampleModalLabel">Thông tin phân giảng lớp học phần</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="phan-giang-form" enctype="multipart/form-data" style="margin: 0px 20px;">
                        @csrf
                        <div class="row">
                            <div style="margin-top: 5px; " id="div_err_form">

                            </div>
                            <input id="id_class_user_pg" name="id_class_user_pg" class="form-control" type="text" style="display: none;">
                            <div style="padding-left: 0;">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label" style="width: 100%;">Lớp học phần</label>
                                    <select style="width: 100%; padding: 6px;" id="id_class_pg">

                                    </select>
                                    <div style="margin-top: 5px; " id="div_err_id_class">

                                    </div>
                                </div>
                            </div>
                            <div style="padding-right: 0;">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label" style="width: 100%;">Giảng viên</label>
                                    <select style="width: 100%; padding: 6px;" id="id_user_gv">

                                    </select>
                                    <div style="margin-top: 5px; " id="div_err_id_user">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 20px; margin-bottom: 20px; display: flex; justify-content: right; font-size: small;">
                            <button type="submit" class="btn btn-xs btn-warning" style="padding: 8px;" id="create-pg-btn">Create</button>
                            <button type="submit" class="btn btn-xs btn-warning" style="padding: 8px; display: none;" id="update-pg-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        getClass();
        getUser();

        $('#phan_giang_btn').on('click', function (){
            getClass();
            getUser();
        });

        function setValuePhanGiang(id, id_class, id_user){
            $('#id_class_user_pg').val(id);
            $('#id_class_pg').val(id_class);
            $('#id_user_gv').val(id_user);
            $("#create-pg-btn").hide();
            $("#update-pg-btn").show();
        };

        function getClass(id = ''){
            $.ajax({
                url: '{{ env('URL_API') }}' + 'classes?id_subject=' + id,
                processData: false,
                contentType: false,
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "GET",
                success: function (data) {
                    let list = data.data;
                    let str = '<option value="">---</option>';
                    for (let item in list){
                        str += '<option value="' + list[item]['id'] + '">' + list[item]['name_class'] + '</option>'
                    }

                    $('#id_class_pg').html(str);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        function getUser(){
            $.ajax({
                url: '{{ env('URL_API') }}' + 'users?role=teacher',
                processData: false,
                contentType: false,
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "GET",
                success: function (data) {
                    let list = data.data;
                    let str = '<option value="">---</option>';
                    for (let item in list){
                        str += '<option value="' + list[item]['id'] + '">' + list[item]['name'] + '</option>'
                    }

                    $('#id_user_gv').html(str);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        var tableClassUser = $('#class-users-table').DataTable({
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
                url: '{{ env('URL_API') }}' + 'class-user',
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
            },
            columns: [
                {data: 'name_class', name: 'name_class'},
                {data: 'code_class', name: 'code_class'},
                {data: 'name', name: 'name'},
                {data: 'action', name: '', orderable: false, searchable: false},
            ]
        });

        $("#phan-giang-form").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('id_class', $("#id_class_pg").val());
            formData.append('id_user', $("#id_user_gv").val());

            let url = '{{ route('v1.class-user.store') }}';
            let noti = 'Phân giảng thành công!';

            if ($('#id_class_user_pg').val()){
                url = '{{ env('URL_API') }}' + 'class-user/update/' + $('#id_class_user_pg').val();
                noti = 'Cập nhật thông tin lớp học phần thành công!';
            }

            console.log(url);

            $.ajax({
                url: url,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "POST",
                data: formData,
                success: function (data) {
                    console.log(data);
                    if (data.response.code === 200) {
                        toastr.success(noti, 'Success');
                        window.location = "{{ route('class-user.list') }}";
                    }
                    else if (data.response.code === 500){
                        $("#div_err_form").html(`<p style="color: red; font-size: small;">* Lớp học phần : `+ $('#id_class_pg option:selected').text() +` đã được phân giảng rồi! Nếu muốn thay đổi vui lòng nhấn sửa phía dưới danh sách!</p>`);
                    }
                },
                error: function (err) {
                    console.log(err);
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

        function deleteClassUser(id){
            if (confirm('Ban co muon xoa khong?') === true) {
                $.ajax({
                    url: '{{ env('URL_API') }}' + `class-user/` + id,
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}',
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "DELETE",
                    success: function (data) {
                        window.location = "{{ route('classes.list') }}";
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

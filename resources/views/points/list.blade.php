@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý điểm </h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <button type="button" id="btn" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createPoint">
                Create
            </button>
            <div style="margin-top: 20px; margin-bottom: 20px; float: right; display: flex">
                <p style="margin-right: 10px;">Lớp học phần:</p>
                <select id="filter_semester">
                    <option value="">- Tất cả -</option>
                </select>
            </div>
        </div>
        <table class="table table-bordered" id="points-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Tên lớp học phần</th>
                <th>Mã lớp học phần</th>
                <th>Tên sinh viên</th>
                <th>Mã sinh viên</th>
                <th>Điểm thành phần</th>
                <th>Điểm thi</th>
                <th>Điểm tổng kết</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- Modal create -->
    <div class="modal fade" id="createPoint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; justify-content: center">
                    <h3 class="modal-title" id="exampleModalLabel">Thông tin điểm học phần</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('v1.classes.store') }}" id="create-point" enctype="multipart/form-data" style="margin: 0px 20px;">
                        @csrf
                        <div class="row">
                            <div class="col-md-6" style="padding-left: 0;">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label" style="width: 100%;">Môn học</label>
                                    <select style="width: 100%; padding: 6px;" id="subject">
                                        <option value="">---</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-right: 0;">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label" style="width: 100%;">Lớp học phần</label>
                                    <select style="width: 100%; padding: 6px;" id="id_class">
                                        <option value="">---</option>
                                    </select>
                                    <div style="margin-top: 5px; " id="div_err_id_class">

                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mã sinh viên</label>
                                    <input id="code_user" name="code_user" class="form-control" type="text" placeholder="Nhập vào mã sinh viên ..." required>
                                    <div style="margin-top: 5px; " id="div_err_code_user">

                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Tên sinh viên</label>
                                    <input id="name_user" name="name_user" class="form-control" type="text" value="Do Thi Loan" readonly>
                                    <input id="id_user" name="id_user" class="form-control" type="text" value="" style="display: none;">
                                    <div style="margin-top: 5px; " id="div_err_name_user">

                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Điểm thành phần</label>
                                    <input id="score_component" name="score_component" class="form-control" type="text" placeholder="Nhập vào điểm thành phần ..." required>
                                    <div style="margin-top: 5px; " id="div_err_score_component">

                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Điểm thi</label>
                                    <input id="score_test" name="score_test" class="form-control" type="text" placeholder="Nhập vào điểm thi ... " required>
                                    <div style="margin-top: 5px; " id="div_err_score_test">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding: 0px;">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Hệ số điểm thành phần:</label>
                                    <input id="hs_diem_tp" name="hs_diem_tp" class="form-control" type="text" value="0.3" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Hệ số điểm thi:</label>
                                    <input id="hs_diem_thi" name="hs_diem_thi" class="form-control" type="text" value="0.7" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Điểm tổng kết</label>
                                    <input id="score_final" name="score_final" class="form-control" type="text" value="10" readonly>
                                    <div style="margin-top: 5px; " id="div_err_score_final">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 20px; margin-bottom: 20px; display: flex; justify-content: right; font-size: small;">
                            <button type="submit" class="btn btn-xs btn-success" style="padding: 8px;">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $('#btn').on('click', function (){
            getSubject();
        });

        $('#subject').on('change', function() {
            let id_subject = document.getElementById('subject').value;
            getClass(id_subject);
        });

        $('#code_user').on('keyup', function() {
            let id_subject = document.getElementById('code_user').value;
            getUser(id_subject);
        });

        function getSubject(){
            $.ajax({
                url: '{{ route('v1.subjects.index') }}',
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
                        str += '<option value="' + list[item]['id'] + '">' + list[item]['name_subject'] + '</option>'
                    }

                    $('#subject').append(str);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        function getClass(id){
            $.ajax({
                url: 'http://nina-soft.com/api/v1/classes?id_subject=' + id,
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
                        str += '<option value="' + list[item]['id'] + '">' + list[item]['name_class'] + '</option>'
                    }

                    $('#id_class').html(str);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        function getUser(code_user){
            $.ajax({
                url: 'http://nina-soft.com/api/v1/users?code_user=' + code_user,
                processData: false,
                contentType: false,
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "GET",
                success: function (data) {
                    let list = data.data;
                    for (let item in list){
                        $('#name_user').val(list[item]['name']);
                        $('#id_user').val(list[item]['id']);
                    }

                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        $(function () {
            $('#points-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'http://nina-soft.com/api/v1/points',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name_class', name: 'id_class'},
                    {data: 'code_class', name: 'code_class'},
                    {data: 'name_user', name: 'id_user'},
                    {data: 'code_user', name: 'code_user'},
                    {data: 'score_component', name: 'score_component'},
                    {data: 'score_test', name: 'score_test'},
                    {data: 'score_final', name: 'score_final'},
                    {data: 'action', name: ''},
                ]
            });
        });

        $("#create-point").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('score_component', $("#score_component").val());
            formData.append('score_test', $("#score_test").val());
            formData.append('score_final', $("#score_final").val());
            formData.append('id_user', $("#id_user").val());
            formData.append('id_class', $("#id_class").val());

            $.ajax({
                url: '{{ route('v1.points.store') }}',
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
                        toastr.success('Thêm mới thành công!', 'Success');
                        window.location = "{{ route('points.list') }}";
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

        function deleteClass(id){
            if (confirm('Ban co muon xoa khong?') === true) {
                $.ajax({
                    url: `http://nina-soft.com/api/v1/points/` + id,
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}',
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "DELETE",
                    success: function (data) {
                        window.location = "{{ route('points.list') }}";
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

@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý điểm </h3>
        <div style="margin-top: 20px; margin-bottom: 40px;">
            <button type="button" id="btn" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createPoint" style="padding: 5px">
                Create
            </button>
            <div style="float: right; display: flex">
                <div style="margin-right: 10px; display: flex">
                    <p style="margin-right: 10px;">Môn học:</p>
                    <select id="filter_subject" style="width: 150px;">

                    </select>
                </div>
                <div style="margin-right: 10px; display: flex">
                    <p style="margin-right: 10px;">Lớp học phần:</p>
                    <select id="filter_class" style="width: 150px;">
                        <option value="">---</option>
                    </select>
                </div>
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
                <th style="width: 15%;">Action</th>
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
                                    <div style="margin-top: 5px; " id="div_err_hs_diem_tp">

                                    </div>
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
                                    <input id="score_final" name="score_final" class="form-control" type="text" value="" readonly>
                                    <div style="margin-top: 5px; " id="div_err_score_final">

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
@stop

@push('scripts')
    <script>
        getSubject('');

        $('#btn').on('click', function (){
            getSubject();
        });

        $('#subject').on('change', function() {
            let id_subject = $('#subject').val();
            getClass(id_subject);
        });

        $('#filter_subject').on('change', function() {
            let id_subject = $('#filter_subject').val();
            getClass(id_subject);
        });

        $('#filter_class').on('change', function() {
            let id_class = $('#filter_class').val();
            getData(id_class);
        });

        $('#code_user').on('keyup', function() {
            let id_subject = $('#code_user').val();
            getUser(id_subject);
        });

        $('#score_component').on('keyup', function() {
            let score = $('#score_component').val();
            checkPoint(score, 'score_component');
        });

        $('#score_test').on('keyup', function() {
            let score = $('#score_test').val();
            checkPoint(score, 'score_test');
        });

        $('#hs_diem_tp').on('keyup', function() {
            let hs_tp = $('#hs_diem_tp').val();
            if (!hs_tp){
                $("#div_err_hs_diem_tp").html(`<p style="color: red; font-size: small;">* Hệ số điểm thành phần không được bỏ trống!</p>`);
            }
            else if (parseFloat(hs_tp) < 0.1 || parseFloat(hs_tp) > 1.0){
                $("#div_err_hs_diem_tp").html(`<p style="color: red; font-size: small;">* Hệ số điểm thành phần không hợp lệ!</p>`);
            }else {
                $("#div_err_hs_diem_tp").html(``);
                let hs_diem_thi = 1.0 - hs_tp;
                $('#hs_diem_thi').val(parseFloat(hs_diem_thi).toFixed(1));
                setPointFinal();
            }
        });

        function getData(id_class = '') {
            tablePoint
                .columns([2])
                .search(id_class)
                .draw();
        }

        function setPointFinal(){
            let diem_tp = $('#score_component').val();
            let diem_thi = $('#score_test').val();
            let hs_tp = $('#hs_diem_tp').val();
            let hs_thi = $('#hs_diem_thi').val();
            if (diem_tp || diem_thi || hs_tp || hs_thi){
                let score_final = (diem_tp * hs_tp) + (diem_thi * hs_thi);
                $('#score_final').val(parseFloat(score_final).toFixed(2));
            }else {
                $('#score_final').val(0);
            }
        }

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
                    let str = '<option value="">---</option>';
                    for (let item in list){
                        str += '<option value="' + list[item]['id'] + '">' + list[item]['name_subject'] + '</option>'
                    }

                    $('#subject').html(str);
                    $('#filter_subject').html(str);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        function getClass(id){
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

                    $('#id_class').html(str);
                    $('#filter_class').html(str);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        function getUser(code_user){
            $.ajax({
                url: '{{ env('URL_API') }}' + 'users?code_user=' + code_user,
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

        function checkPoint(point, id_input){
            if (point < 0 || point > 10){
                $("#div_err_" + id_input).html(`<p style="color: red; font-size: small;">* Điểm không hợp lệ!</p>`);
            }else {
                $("#div_err_" + id_input).html(``);
                setPointFinal();
            }
        }

        var tablePoint = $('#points-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ env('URL_API') }}' + 'points',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name_class', name: 'id_class'},
                    {data: 'code_class', name: 'id_class'},
                    {data: 'name_user', name: 'id_user'},
                    {data: 'code_user', name: 'code_user'},
                    {data: 'score_component', name: 'score_component'},
                    {data: 'score_test', name: 'score_test'},
                    {data: 'score_final', name: 'score_final'},
                    {data: 'action', name: '', orderable: false, searchable: false},
                ],
            });

        // tablePoint.button().add( 0, {
        //     action: function ( e, dt, button, config ) {
        //         dt.ajax.reload();
        //     },
        //     text: 'Reload table'
        // });

        $("#create-point").submit(function (e) {
            e.preventDefault();

            let score_component = $("#score_component").val();
            let score_test = $("#score_test").val();
            let score_final = $("#score_final").val();

            if (Number(score_component) < 0 || Number(score_component) > 10){
                $("#div_err_score_component").html(`<p style="color: red; font-size: small;">* Điểm thành phần không hợp lệ!</p>`);
            }
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
                    url: '{{ env('URL_API') }}' + `points/` + id,
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

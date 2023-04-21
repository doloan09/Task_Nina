@extends('layouts.master')
@section('title', 'Quản lý điểm sinh viên ')

<style>
    #points-table_filter input{
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }

    #points-table_filter input:focus-visible{
        outline: none;
    }

    #points-table_length select{
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ccc;
        background-color: white;
    }

    #points-table_length select:focus-visible{
        outline: none;
    }

    #points-table_paginate {
        margin-top: 20px;
    }

    #points-table tbody tr td{
        padding: 15px 0;
    }

</style>
@section('content')
    <div style="margin-top: 70px;">
        <p style="color: #707070; font-size: 25px;">Quản lý điểm</p>
        @isset($message)
            <script> alert('Không thể xuất file! Không tồn tại sinh viên này!'); window.location.reload();</script>
        @endisset
        <div style="margin-top: 20px; margin-bottom: 20px; display: flex; justify-content: right;">
            <div class="dropdown" style="margin-right: 10px;">
                <button class="dropbtn">Bộ lọc</button>
                <div class="dropdown-content" style="padding: 30px 20px; margin-left: -50px;">
                    <div>
                        <div style="margin-right: 10px;">Kỳ học:</div>
                        <select id="filter_semester" style="border: 1px #ccc solid; border-radius: 5px; background-color: white; margin-top: 10px; padding: 5px;">

                        </select>
                    </div>
                    <div>
                        <div style="margin-right: 10px; margin-top: 20px;">Lớp học:</div>
                        <select id="filter_class" class="focus-visible: none" style="border: 1px #ccc solid; border-radius: 5px; background-color: white; width: 150px; margin-top: 10px; padding: 5px; float: left;">

                        </select>
                    </div>
                </div>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->hasAnyRole(['admin', 'teacher']))
                <div class="dropdown">
                    <button class="dropbtn">Thao tác</button>
                    <div class="dropdown-content">
                        <p data-toggle="modal" data-target="#createPoint" onclick="setValueDefaul()">Thêm mới</p>
                        <p data-toggle="modal" data-target="#importPoint" onclick="setErrImportDefaul()">Import</p>
                        <p data-toggle="modal" data-target="#exportPoint" onclick="setErrExportDefaul()">Export</p>
                    </div>
                </div>
            @endif
        </div>
        <table class="table table-bordered" id="points-table">
            <thead>
            <tr>
                <th>Id</th>
{{--                <th style="width: 150px;">Kỳ học</th>--}}
                <th>Tên lớp học phần</th>
                <th>Mã lớp học phần</th>
                <th>Tên sinh viên</th>
                <th>Mã sinh viên</th>
                <th>Điểm thành phần</th>
                <th>Điểm thi</th>
                <th>Điểm tổng kết</th>
                <th style="width: 10%;">Action</th>
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
                    <form method="POST" action="" id="create-point" enctype="multipart/form-data" style="margin: 0px 20px;">
                        @csrf
                        <div class="row">
                            <div style="margin-top: 5px; " id="div_err_point_unique">

                            </div>
                            <input id="id_point" name="id_point" class="form-control" type="text" style="display: none;">
                            <div class="" style="padding-right: 0;">
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
                                    <input id="name_user" name="name_user" class="form-control" type="text" value="" readonly>
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
                            <button type="submit" class="btn btn-xs btn-warning" style="padding: 8px;" id="create-btn">Create</button>
                            <button type="submit" class="btn btn-xs btn-warning" style="padding: 8px; display: none;" id="update-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal import -->
    <div class="modal fade" id="importPoint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; justify-content: center">
                    <h3 class="modal-title" id="exampleModalLabel">Import danh sách điểm học phần</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="import-point" enctype="multipart/form-data" style="margin: 0px 20px;">
                        @csrf
                        <div class="row">
                            <div class="" style="padding-right: 0;">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label" style="width: 100%;">Chọn file</label>
                                    <input type="file" name="file" id="input-import">
                                    <div style="margin-top: 5px; " id="div_err_id_class">

                                    </div>
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

    <!-- Modal export -->
    <div class="modal fade" id="exportPoint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; justify-content: center">
                    <h3 class="modal-title" id="exampleModalLabel">Xuất bảng điểm</h3>
                </div>
                <div class="modal-body">
                    <div class="" style="padding-right: 0;">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label" style="width: 100%;">Xuất file theo: </label>
                            <div style="display: flex;">
                                <div style="margin-right: 20px;">
                                    <input type="radio" name="choose" value="class" checked>
                                    <label for="html">Lớp học phần</label><br>
                                </div>
                                <div>
                                    <input type="radio" name="choose" value="user">
                                    <label for="css">Một sinh viên</label><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="class_export">
                            <label for="example-text-input" class="form-control-label" style="width: 100%;">Lớp học phần</label>
                            <select style="width: 100%; padding: 6px;" id="id_class_export">
                                <option value="">---</option>
                            </select>
                            <div style="margin-top: 5px; " id="div_err_id_class_export">

                            </div>
                        </div>
                        <div class="form-group" id="user_export" style="display: none; ">
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mã sinh viên</label>
                                    <input id="code_user_export" name="code_user_export" class="form-control" type="text" placeholder="Nhập vào mã sinh viên ..." required>
                                    <div style="margin-top: 5px; " id="div_err_code_user_export">

                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Tên sinh viên</label>
                                    <input id="name_user_export" name="name_user_export" class="form-control" type="text" value="" readonly>
                                    <input id="id_user_export" name="id_user_export" class="form-control" type="text" value="" style="display: none;">
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: right; margin-top: 40px; ">
                            <button type="button" class="btn btn-xs btn-warning" style="padding: 5px" onclick="exportFile()">
                                <a style="color: white;" href="#" id="export_point">Export</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('scripts')
    <script>
        getClass();
        getSemester();
        create_table();

        $(document).ready(function() {
            $('#filter_class').select2();
        });

        $('#points-table').removeClass('table-bordered');
        $('#points-table').addClass('table-striped table-hover');

        $('#btn').on('click', function() {
            $('#id_point').val('');
            $('#score_component').val('');
            $('#score_test').val('');
            $('#score_final').val('');
            $('#id_user').val('');
            $('#id_class').val('');
            $('#code_user').val('');
            $('#name_user').val('');
            $('#code_user').attr('readonly', false);
            $("#create-btn").show();
            $("#update-btn").hide();
        });

        $('#btn-export').on('click', function() {
            getClass();
        });

        $('input[name="choose"]').on('change', function() {
            let choose = $('input[name="choose"]:checked').val();

            if (choose === 'class'){
                $('#class_export').css('display', 'block');
                $('#user_export').css('display', 'none');
            }if (choose === 'user') {
                $('#class_export').css('display', 'none');
                $('#user_export').css('display', 'block');
            }
        });

        $('#filter_class').on('change', function() {
            let id_class = $('#filter_class').val();
            getData(id_class);
        });

        $('#filter_semester').on('change', function() {
            let semester = $('#filter_semester').val();
            getDataBySemester(semester);
        });

        $('#id_class_export').on('change', function() {
            $('#export_point').attr('href', '{{ env('URL_API') }}' + 'points/export?id_class=' + $('#id_class_export').val() + '&code_user=');
        });

        $('#code_user').on('keyup', function() {
            let code = $('#code_user').val();
            getUser(code);
        });

        $('#code_user_export').on('keyup', function() {
            let code = $('#code_user_export').val();
            getUser(code, '', 'export');
            if ($('#name_user_export').val() !== '') {
                $('#export_point').attr('href', ($('#code_user_export').val() !== '') ? ('{{ env('URL_API') }}' + 'points/export?id_class=&code_user=' + $('#code_user_export').val()) : '#');
            }
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
            if ( $.fn.DataTable.isDataTable('#points-table') ) {
                $('#points-table').DataTable().destroy();
            }

            $('#points-table tbody').empty();

            let url = '{{ env('URL_API') }}' + 'points?id_class=' + id_class + '&id_semester=' + $("#filter_semester").val();
            create_table(url);
        }

        function getDataBySemester(id_semester = '') {
            if ( $.fn.DataTable.isDataTable('#points-table') ) {
                $('#points-table').DataTable().destroy();
            }

            $('#points-table tbody').empty();

            let url = '{{ env('URL_API') }}' + 'points?id_class=' + $('#filter_class').val() + '&id_semester=' + id_semester;
            create_table(url);
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

        getPointInfo();
        function getPointInfo(){
            $.ajax({
                url: '{{ env('URL_API') }}' + 'users/point-info?id_user=' + '{{ \Illuminate\Support\Facades\Auth::id() }}',
                processData: false,
                contentType: false,
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "GET",
                success: function (data) {
                    if (data.response.code === 200){
                        let list = data.data;
                        if (list.length > 0){

                        }
                    }
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

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

                    $('#id_class').html(str);
                    $('#filter_class').html(str);
                    $('#id_class_export').html(str);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        function getUser(code_user='', id_user='', exp=''){
            $.ajax({
                url: '{{ env('URL_API') }}' + 'users?code_user=' + code_user + '&id_user=' + id_user,
                processData: false,
                contentType: false,
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "GET",
                success: function (data) {
                    let list = data.data;
                    if (list.length > 0) {
                        if (exp === 'export'){
                            for (let item in list) {
                                $('#name_user_export').val(list[item]['name']);
                                $('#id_class_export').val(list[item]['id']);
                            }
                        }else {
                            for (let item in list) {
                                $('#name_user').val(list[item]['name']);
                                $('#id_user').val(list[item]['id']);
                                $('#code_user').val(list[item]['code_user']);
                            }
                        }
                    }
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        function getSemester(){
            $.ajax({
                url: '{{ route('v1.semesters.index') }}',
                processData: false,
                contentType: false,
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "GET",
                success: function (data) {
                    let list = data.data;
                    let str = '';
                    let str2 = '<option value="">---</option>';
                    for (let item in list){
                        str += '<option value="' + list[item]['id'] + '">' + list[item]['name_semester'] + '_' + list[item]['year_semester'] + '</option>'
                    }

                    str2 += str;
                    $('#id_semester').html(str);
                    $('#filter_semester').html(str2);
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

        function create_table(url = '') {
            let url_main;
            if (url){
                url_main = url;
            }else {
                url_main = '{{ env('URL_API') }}' + 'points';
            }

            $('#points-table').DataTable({
                processing: true,
                serverSide: true,
                "bInfo": false,
                order: [[1, 'desc']],
                language: {
                    paginate: {
                        next: '>',
                        previous: '<'
                    }
                },
                ajax: {
                    url: url_main,
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    // {data: 'name_semester', name: 'id_semester'},
                    {data: 'name_class', name: 'id_class'},
                    {data: 'code_class', name: 'id_class'},
                    {data: 'name_user', name: 'id_user'},
                    {data: 'code_user', name: 'code_user'},
                    {data: 'score_component', name: 'score_component'},
                    {data: 'score_test', name: 'score_test'},
                    {data: 'score_final', name: 'score_final'},
                    {data: 'action', name: '', orderable: false, searchable: false},
                ],
                "columnDefs": [
                    { className: "my_class", "targets": [ 0, 4, 5, 6, 7, 8 ] }
                ]
            });
        }

        function setErrImportDefaul(){
            $('#message-err').html('');
            $('#div_err_err').html('');
            $('#div_err_errData').html('');
            $('#div_err_id_class_export').html('');
            $('#div_err_code_user_export').html('');
        }

        function setErrExportDefaul(){
            $('#id_class_export').val('');
            $('#div_err_id_class_export').html('');
            $('#code_user_export').val('');
            $('#div_err_code_user_export').html('');
            $('#name_user_export').val('');
        }

        function setValueDefaul(){
            $('#id_point').val('');
            $('#score_component').val('');
            $('#score_test').val('');
            $('#score_final').val('');
            $('#id_user').val('');
            $('#code_user').val('');
            $('#name_user').val('');
            $('#id_class').val('');
            $('#div_err_point_unique').html('');
        };

        function setValue(id_point, score_component, score_test, score_final, id_user, id_class){
            $('#id_point').val(id_point);
            $('#score_component').val(score_component);
            $('#score_test').val(score_test);
            $('#score_final').val(score_final);
            $('#id_user').val(id_user);
            $('#id_class').val(id_class);
            $('#code_user').attr('readonly', true);
            $("#create-btn").hide();
            $("#update-btn").show();
        };

        function update(id){
            $.ajax({
                url: '{{ env('URL_API') }}' + 'points/' + id,
                processData: false,
                contentType: false,
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
                method: "GET",
                success: function (data) {
                    let item = data.data;
                    setValue(item['id'], item['score_component'], item['score_test'], item['score_final'], item['id_user'], item['id_class']);
                    getUser('', item['id_user']);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        $("#create-point").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('score_component', $("#score_component").val());
            formData.append('score_test', $("#score_test").val());
            formData.append('score_final', $("#score_final").val());
            formData.append('id_user', $("#id_user").val());
            formData.append('id_class', $("#id_class").val());

            let url = '{{ route('v1.points.store') }}';
            let noti = 'Thêm mới thành công!';
            if ($('#id_point').val()){
                url = '{{ env('URL_API') }}' + 'points/update/' + $('#id_point').val();
                noti = 'Cập nhật thành công!';
            }

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
                    if (data.response.code === 200) {
                        toastr.success(noti, 'Success');
                        if ($('#id_point').val() === ''){
                            setValueDefaul();
                        }else {
                            $('#id_point').val('');
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        }
                    }
                    if (data.response.code === 500){
                        let errList = data.error;
                        $("#div_err_point_unique").html(`<p style="color: red; font-size: small;">* ` + (errList[0]['point_unique'] ?? errList[0]['user_not_class']) + `</p>`);
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

        $("#import-point").submit(function (e) {
            e.preventDefault();

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: '{{ route('v1.points.import') }}',
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

        function exportFile(){
            let id_class = $('#id_class_export').val();
            let code_user = $('#code_user_export').val();
            let choose = $('input[name="choose"]:checked').val();

            if (!id_class && choose === 'class'){
                toastr.error('Vui lòng chọn lớp học phần trước khi xuất file!');
            }
            else if (!code_user && choose === 'user'){
                toastr.error('Vui lòng nhập mã sinh viên trước khi xuất file!');
            }else if (choose === 'user' && $('#name_user_export').val() === '') {
                let url = '{{ env('URL_API') }}' + 'points/export?id_class=' + $('#id_class_export') + '&code_user=' + $('#code_user_export');
                toastr.error('Vui lòng nhập mã sinh viên trước khi xuất file!');
            }
        }

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
                        toastr.success('Xóa bản ghi thành công!');
                        setTimeout(function (){
                            window.location.reload();
                        }, 1000);
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

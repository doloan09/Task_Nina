@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý lớp học phần</h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <button type="button" id="btn" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createClass">
                Create
            </button>
            <div style="margin-top: 20px; margin-bottom: 20px; float: right; display: flex">
                <p style="margin-right: 10px;">Kỳ học:</p>
                <select id="filter_semester">
                    <option value="">- Tất cả -</option>
                </select>
            </div>
        </div>
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Tên lớp học phần</th>
                <th>Mã lớp học phần</th>
                <th>Mã môn học</th>
                <th>Mã kỳ học</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- Modal create -->
    <div class="modal fade" id="createClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; justify-content: center">
                    <h3 class="modal-title" id="exampleModalLabel">Thông tin lớp học phần</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('v1.classes.store') }}" id="create-class" enctype="multipart/form-data" style="margin: 0px 20px;">
                        @csrf
                        <div class="row">
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Tên lớp học phần</label>
                                    <input id="name_class" name="name_class" class="form-control" type="text" placeholder="Nhập vào tên lớp học phần..." required>
                                    <div style="margin-top: 5px; " id="div_err_name_class">

                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mã lớp học phần</label>
                                    <input id="code_class" name="code_class" class="form-control" type="text" placeholder="Nhập vào mã lớp học phần ... " required>
                                    <div style="margin-top: 5px; " id="div_err_code_class">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-left: 0;">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label" style="width: 100%;">Môn học</label>
                                    <select style="width: 100%; padding: 6px;" id="id_subject">

                                    </select>
                                    <div style="margin-top: 5px; " id="div_err_id_subject">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-right: 0;">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label" style="width: 100%;">Kỳ học</label>
                                    <select style="width: 100%; padding: 6px;" id="id_semester">

                                    </select>
                                    <div style="margin-top: 5px; " id="div_err_id_semester">

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
@endsection

@push('scripts')
    <script>

        getSemester();

        $('#btn').on('click', function (){
            getSubject();
            getSemester();
        });

        $('#filter_semester').on('change', function() {
            let semester = document.getElementById('filter_semester').value;
            getData(semester);
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

                    $('#id_subject').html(str);
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
                    for (let item in list){
                        str += '<option value="' + list[item]['id'] + '">' + list[item]['name_semester'] + '_' + list[item]['year_semester'] + '</option>'
                    }

                    $('#id_semester').html(str);
                    $('#filter_semester').append(str);
                },
                error: function (err) {
                    toastr.error(err.statusText);
                    console.log(err);
                },
            });
        }

        var tableClass = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'http://nina-soft.com/api/v1/classes?id_semester=',
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                },
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name_class', name: 'name_class'},
                {data: 'code_class', name: 'code_class'},
                {data: 'name_subject', name: 'name_subject'},
                {data: 'name_semester', name: 'id_semester'},
                {data: 'action', name: ''},
            ]
        });

        function getData(semester = '') {
            tableClass
                .columns([4])
                .search(semester)
                .draw();
        }

        $("#create-class").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('name_class', $("#name_class").val());
            formData.append('code_class', $("#code_class").val());
            formData.append('id_subject', $("#id_subject").val());
            formData.append('id_semester', $("#id_semester").val());

            $.ajax({
                url: '{{ route('v1.classes.store') }}',
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
                        toastr.success('Thêm mới lớp học phần thành công!', 'Success');
                        window.location = "{{ route('classes.list') }}";
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
                    url: `http://nina-soft.com/api/v1/classes/` + id,
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
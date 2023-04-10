@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý môn học</h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createSubject" style="padding: 5px">
                Create
            </button>
        </div>
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Tên môn học</th>
                <th>Mã môn học</th>
                <th>Số tín chỉ</th>
                <th style="width: 15%;">Action</th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- Modal create -->
    <div class="modal fade" id="createSubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; justify-content: center">
                    <h3 class="modal-title" id="exampleModalLabel">Thông tin môn học</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="create-subject" enctype="multipart/form-data" style="margin: 0px 20px;">
                        @csrf
                        <div class="row">
                            <input id="id_subject" name="id_subject" class="form-control" type="text" style="display: none">
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Tên môn học</label>
                                    <input id="name_subject" name="name_subject" class="form-control" type="text" placeholder="Nhập vào tên môn học ..." required>
                                    <div style="margin-top: 5px; " id="div_err_name_subject">

                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mã môn học</label>
                                    <input id="code_subject" name="code_subject" class="form-control" type="text" placeholder="Nhập vào mã môn học ... " required>
                                    <div style="margin-top: 5px; " id="div_err_code_subject">

                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Số tín chỉ</label>
                                    <input id="number_of_credits" name="number_of_credits" class="form-control" type="text" placeholder="Nhập vào số tín chỉ ... " required>
                                    <div style="margin-top: 5px; " id="div_err_number_of_credits">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 20px; margin-bottom: 20px; display: flex; justify-content: right; font-size: small;">
                            <button type="submit" class="btn btn-xs btn-warning" style="padding: 8px;" id="create-sub">Create</button>
                            <button type="submit" class="btn btn-xs btn-warning" style="padding: 8px; display: none;" id="update-sub">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function setValue(id, name, code, number){
            $('#id_subject').val(id);
            $('#name_subject').val(name);
            $('#code_subject').val(code);
            $('#number_of_credits').val(number);
            $("#create-sub").hide();
            $("#update-sub").show();
        };

        $(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('v1.subjects.index') !!}',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name_subject', name: 'name_subject'},
                    {data: 'code_subject', name: 'code_subject'},
                    {data: 'number_of_credits', name: 'number_of_credits'},
                    {data: 'action', name: '', orderable: false, searchable: false},
                ]
            });
        });

        $("#create-subject").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('name_subject', $("#name_subject").val());
            formData.append('code_subject', $("#code_subject").val());
            formData.append('number_of_credits', $("#number_of_credits").val());

            let url = '{{ route('v1.subjects.store') }}';
            if ($('#id_subject').val()){
                url = 'http://nina-soft.com/api/v1/subjects/update/' + $('#id_subject').val();
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
                        toastr.success('Thêm mới môn học thành công!', 'Success');
                        window.location = "{{ route('subjects.list') }}";
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

        function deleteSub(id){
            if (confirm('Ban co muon xoa khong?') === true) {
                $.ajax({
                    url: `http://nina-soft.com/api/v1/subjects/` + id,
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}',
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "DELETE",
                    success: function (data) {
                        window.location = "{{ route('subjects.list') }}";
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

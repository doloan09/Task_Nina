@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý học kỳ</h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#createSemester" style="padding: 5px">
                Create
            </button>
        </div>
        <table class="table table-bordered" id="semesters-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Kỳ</th>
                <th>Năm học</th>
                <th style="width: 15%;">Action</th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- Modal create -->
    <div class="modal fade" id="createSemester" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="display: flex; justify-content: center">
                    <h3 class="modal-title" id="exampleModalLabel">Thông tin học kỳ</h3>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="create-semester" enctype="multipart/form-data" style="margin: 0px 20px;">
                        @csrf
                        <div class="row">
                            <input id="id_semester" name="id_semester" class="form-control" type="text" style="display: none;">
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Kỳ</label>
                                    <input id="name_semester" name="name_semester" class="form-control" type="text" placeholder="Nhập vào tên kỳ học ..." required>
                                    <div style="margin-top: 5px; " id="div_err_name_semester">

                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Năm học</label>
                                    <input id="year_semester" name="year_semester" class="form-control" type="text" placeholder="Nhập vào năm học ... " required>
                                    <div style="margin-top: 5px; " id="div_err_year_semester">

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

@endsection

@push('scripts')
    <script>

        function setValue(id, name, year){
            $('#id_semester').val(id);
            $('#name_semester').val(name);
            $('#year_semester').val(year);
            $("#create-btn").hide();
            $("#update-btn").show();
        };

        $(function() {
            $('#semesters-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('v1.semesters.index') !!}',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name_semester', name: 'name_semester' },
                    { data: 'year_semester', name: 'year_semester' },
                    { data: 'action', name: '', orderable: false, searchable: false},

                    // {
                    //     data: 'action',
                    //     render: function (id) {
                    //         return '<a href="#" class="btn btn-xs btn-warning" style="margin: 0px 10px;">Update</a><button class="btn btn-xs btn-danger btn-delete">Delete</button>';
                    //     }
                    // },
                ]
            });
        });

        $("#create-semester").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('name_semester', $("#name_semester").val());
            formData.append('year_semester', $("#year_semester").val());

            let url = '{{ route('v1.semesters.store') }}';
            let noti = 'Thêm mới học kỳ thành công!';

            if ($('#id_semester').val()){
                url = '{{ env('URL_API') }}' + 'semesters/update/' + $('#id_semester').val();
                noti = 'Cập nhât thông tin học kỳ thành công!';
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
                        window.location = "{{ route('semesters.list') }}";
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

        function deleteSemester(id){
            if (confirm('Ban co muon xoa khong?') === true) {
                $.ajax({
                    url: '{{ env('URL_API') }}' + `semesters/` + id,
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}',
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "DELETE",
                    success: function (data) {
                        window.location = "{{ route('semesters.list') }}";
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

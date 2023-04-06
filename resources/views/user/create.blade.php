@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p class="text-uppercase text-sm">Thông tin người dùng</p>
                    <form method="POST" action="{{ route('v1.users.create') }}" id="create-user" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Họ tên</label>
                                    <input id="name" name="name" class="form-control" type="text" placeholder="Nhập vào họ tên người dùng..." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email</label>
                                    <input id="email" name="email" class="form-control" type="email" placeholder="Nhập vào email ..." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Mã nhân viên/Mã sinh viên</label>
                                    <input id="code_user" name="code_user" class="form-control" type="text" placeholder="Mã sinh viên hoặc mã nhân viên" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Ngày sinh</label>
                                    <input id="date_of_birth" name="date_of_birth" class="form-control" type="date" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Địa chỉ</label>
                                    <input id="address" name="address" class="form-control" type="text" placeholder="Thông tin địa chỉ người dùng ..." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Số điện thoại</label>
                                    <input id="phone" name="phone" class="form-control" type="text" placeholder="số điện thoại" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Giới tính</label>
                                    <br>
                                    <input type="radio" id="nam" name="sex" value="nam" checked>
                                    <label for="html">Nam</label><br>
                                    <input type="radio" id="nu" name="sex" value="nữ">
                                    <label for="css">Nữ</label><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="example-text-input">Ảnh thẻ </label>
                                    <input id="avatar" name="avatar" type="file">
                                </div>
                            </div>
                        </div>
                        <div style="margin-bottom: 20px; margin-top: 20px; display: none;" id="div-err">
                            <p>Có lỗi:</p>
                            <div style="color: red; font-size: small" id="content-err">

                            </div>
                        </div>
                        <div style="margin-top: 20px; margin-bottom: 20px;">
                            <button type="submit" class="btn btn-xs btn-warning">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $("#create-user").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('_token', '{{ csrf_token() }}');
            formData.append('name', $("#name").val());
            formData.append('email', $("#email").val());
            formData.append('code_user', $("#code_user").val());
            formData.append('date_of_birth', $("#date_of_birth").val());
            formData.append('sex', $("#sex").val());
            formData.append('address', $("#address").val());
            formData.append('phone', $("#phone").val());
            formData.append('avatar', $("#avatar")[0].files[0]);

            $.ajax({
                url: '{{ route('v1.users.store') }}',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                method: "POST",
                data: formData,
                success: function (data) {
                    if (data.response.code === 200) {
                        alert('Thêm mới người dùng thành công!');
                        window.location = "{{ route('users.list') }}";
                    }
                },
                error: function (err) {
                    // str = '';
                    // errList = err.responseJSON.Err_Message;
                    //
                    // for(key in errList){
                    //     str += `<p>* ` + errList[key] + `</p>` ;
                    // }
                    //
                    // $("#content-err").html(str);
                    // $("#div-err").show();
                    console.log(err);
                },
            });
            return true;
        });
    </script>
@endpush

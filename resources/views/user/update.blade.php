@extends('layouts.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Cập nhật thông tin người dùng</p>
                        <form method="POST" action="{{ route('v1.users.updated', ['id' => $user->id]) }}" id="update-user" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Họ tên</label>
                                        <input id="name" name="name" class="form-control" type="text" placeholder="Nhập vào họ tên người dùng..." value="{{ $user->name }}" required>
                                        <div style="margin-top: 5px; " id="div-err-name">
                                            {{--                                        <span style="font-size: smaller; color: red;">* Họ tên không được bỏ trống</span>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email</label>
                                        <input id="email" name="email" class="form-control" type="email" placeholder="Nhập vào email ..." value="{{ $user->email }}" readonly>
                                        <div style="margin-top: 5px; " id="div-err-email">
                                            {{--                                        <span style="font-size: smaller; color: red;">* Email không được bỏ trống</span>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Mã nhân viên/Mã sinh viên</label>
                                        <input id="code_user" name="code_user" class="form-control" type="text" placeholder="Mã sinh viên hoặc mã nhân viên" value="{{ $user->code_user }}" readonly>
                                        <div style="margin-top: 5px; " id="div-err-code_user">
                                            {{--                                        <span style="font-size: smaller; color: red;">* Mã nhân viên/Mã sinh viên không được bỏ trống</span>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Ngày sinh</label>
                                        <input id="date_of_birth" name="date_of_birth" class="form-control" type="date" value="{{ $user->date_of_birth }}" required>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Địa chỉ</label>
                                        <input id="address" name="address" class="form-control" type="text" placeholder="Thông tin địa chỉ người dùng ..." value="{{ $user->address }}" required>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Số điện thoại</label>
                                        <input id="phone" name="phone" class="form-control" type="text" placeholder="số điện thoại" value="{{ $user->phone }}" required>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Giới tính</label>
                                        <br>
                                        <input type="radio" id="nam" name="sex" value="nam">
                                        <label for="html">Nam</label><br>
                                        <input type="radio" id="nu" name="sex" value="nữ">
                                        <label for="css">Nữ</label><br>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="">
                                        <label for="example-text-input">Ảnh thẻ </label>
                                        <input id="avatar" name="avatar" type="file">
                                        <img src="{{ $user->url_avatar }}" style="width: 100px; margin-top: 20px;">
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 20px; margin-bottom: 20px;">
                                <button type="submit" class="btn btn-xs btn-warning">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        check();
        function check() {
            if('{{ $user->sex }}' === 'nữ' ) {
                document.getElementById("nu").checked = true;
            }else {
                document.getElementById("nam").checked = true;
            }
        }

        $("#update-user").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('name', $("#name").val());
            formData.append('date_of_birth', $("#date_of_birth").val());
            formData.append('sex', $('input[name="sex"]').val());
            formData.append('address', $("#address").val());
            formData.append('phone', $("#phone").val());

            var file =   $("#avatar")[0].files[0];
            if (file) formData.append('avatar', $("#avatar")[0].files[0] );

            $.ajax({
                url: 'http://nina-soft.com/api/v1/users/update/' + '{{ $user->id }}',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                method: "POST",
                data: formData,
                success: function (data) {
                    if (data.response.code === 200) {
                        toastr.success('Cập nhật tài khoản thành công!', 'Success');
                        window.location = "{{ route('users.list') }}";
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

    </script>
@endpush

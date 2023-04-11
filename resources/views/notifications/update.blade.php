@extends('layouts.master')

@section('title', 'Quản lý thông báo')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <p class="text-uppercase text-sm" style="font-size: 20px;">Cập nhật thông báo</p>
                        <form method="POST" action="" id="update-notification" enctype="multipart/form-data" style="padding-left: 20px; padding-top: 20px;">
                            @csrf
                            <div class="row">
                                <input id="id_noti" name="id_noti" class="form-control" type="text" style="display: none;" value="{{ $notification->id }}">
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tiêu đề thông báo</label>
                                        <input id="title" name="title" class="form-control" type="text" placeholder="Nhập vào tiêu đề thông báo ..." value="{{ $notification->title }}" required>
                                        <div style="margin-top: 5px; " id="div_err_title">

                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nội dung thông báo</label>
                                        <textarea rows="25" id="content" name="content" class="form-control" type="text" placeholder="Nhập vào nội dung thông báo ... " required>{{ $notification->content }}</textarea>
                                        <div style="margin-top: 5px; " id="div_err_content">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 40px; margin-bottom: 20px; margin-left: -10px;">
                                <button type="submit" class="btn btn-xs btn-warning" style="padding: 5px;">Cập nhật</button>
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

        $("#update-notification").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('title', $("#title").val());
            formData.append('content', $("#content").val());

            $.ajax({
                url: '{{ env('URL_API') }}' + 'notifications/update/' + $('#id_noti').val(),
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                method: "POST",
                data: formData,
                success: function (data) {
                    if (data.response.code === 200) {
                        toastr.success('Cập nhật thông báo thành công!', 'Success');
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

    </script>
@endpush

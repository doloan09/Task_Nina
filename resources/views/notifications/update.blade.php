@extends('layouts.master')

@section('title', 'Quản lý thông báo')

<style>
    #container {
        width: 1000px;
        margin: 20px auto;
    }
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 500px;
    }

    .ck-content .image {
        /* block images */
        max-width: 80%;
        margin: 20px auto;
    }
</style>

@section('content')
    <div class="container-fluid py-4" style="margin-top: 70px;">
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
                                        <label for="example-text-input" class="form-control-label">Tiêu đề thông báo <span style="color: red; ">*</span></label>
                                        <input id="title" name="title" class="form-control" type="text" placeholder="Nhập vào tiêu đề thông báo ..." value="{{ $notification->title }}" required>
                                        <div style="margin-top: 5px; " id="div_err_title">

                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nội dung thông báo <span style="color: red; ">*</span></label>
                                        <div id="content-noti">
                                            <div id="children">
                                                {!! $notification->content !!}
                                            </div>
                                        </div>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/super-build/ckeditor.js"></script>
    <script>
        let editor;

        ClassicEditor
            .create( document.querySelector( '#content-noti'))
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>

    <script type="module">

        $("#update-notification").submit(function (e) {
            e.preventDefault();

            var formData = new FormData();

            formData.append('title', $("#title").val());
            formData.append('content', editor.getData());

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
                        setTimeout(function () {
                            window.location = "{{ route('notifications.list') }}";
                        }, 1000);
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

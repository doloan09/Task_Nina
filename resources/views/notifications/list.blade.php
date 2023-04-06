@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý thông báo</h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <a href="#" class="btn btn-xs btn-warning">Create</a>
        </div>
        <table class="table table-bordered" id="notifications-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
            </thead>
        </table>
    </div>
@stop

@push('scripts')
    <script>
        $(function() {
            $('#notifications-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! route('notification.index') !!}',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'content', name: 'content' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' }
                ]
            });
        });
    </script>
@endpush

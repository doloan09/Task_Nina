@extends('layouts.master')

@section('content')
    <div>
        <h3>Quản lý học kỳ</h3>
        <div style="margin-top: 20px; margin-bottom: 20px;">
            <a href="#" class="btn btn-xs btn-warning">Create</a>
        </div>
        <table class="table table-bordered" id="semesters-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Kỳ</th>
                <th>Năm học</th>
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
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' }
                ]
            });
        });
    </script>
@endpush

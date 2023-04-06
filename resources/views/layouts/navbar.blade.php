<div style="margin-bottom: 20px; border-bottom: 1px solid; padding-bottom: 20px;">
    <a href="{{ route('users.list') }}" class="btn btn-xs btn-warning">Users</a>
    <a href="{{ route('subjects.list') }}" class="btn btn-xs btn-warning">Subjects</a>
    <a href="{{ route('semesters.list') }}" class="btn btn-xs btn-warning">Semesters</a>
    <a href="{{ route('notifications.list') }}" class="btn btn-xs btn-warning">Notifications</a>
    <a href="{{ route('classes.list') }}" class="btn btn-xs btn-warning">Classes</a>
    <a href="{{ route('points.list') }}" class="btn btn-xs btn-warning">Point</a>
    <button class="btn btn-xs btn-warning" onclick="logout()">Logout</button>
</div>

@push('scripts')
    <script>
        function logout(){
            if (localStorage.getItem("token") != null) {
                $.ajax({
                    url: '{{ route('logout') }}',
                    headers: {
                        "Authorization": "Bearer " + localStorage.getItem("token"),
                    },
                    method: "GET",
                    success: function (data) {
                        localStorage.removeItem("token");
                        localStorage.removeItem("token_type");
                        window.location = "/login";
                    },
                    error: function (err) {
                        console.log(err);
                        alert('error logout');
                    }
                })
            }
        };
    </script>
@endpush

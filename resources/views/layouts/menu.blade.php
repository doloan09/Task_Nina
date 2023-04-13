<style>
    /* Google Fonts - Poppins */
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        min-height: 100%;
        /*background: #e3f2fd;*/
    }

    nav {
        /*position: fixed;*/
        top: 0;
        left: 0;
        height: 70px;
        width: 100%;
        display: flex;
        align-items: center;
        background: #fff;
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.1);
    }

    nav .logo {
        display: flex;
        align-items: center;
        /*margin: 0 24px;*/
    }

    .logo .menu-icon {
        color: #333;
        font-size: 24px;
        margin-right: 14px;
        cursor: pointer;
    }

    .logo .logo-name {
        color: #333;
        font-size: 22px;
        font-weight: 500;
    }

    nav .sidebar {
        /*position: fixed;*/
        top: 0;
        left: -100%;
        height: 100%;
        width: 260px;
        padding: 20px 0;
        background-color: #fff;
        box-shadow: 0 5px 1px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
    }

    .sidebar {
        display: flex;
        height: 100%;
        flex-direction: column;
        justify-content: space-between;
        padding: 0px 16px;
        background-color: #fff;
    }

    .sidebar-content {
        display: flex;
        height: 100%;
        flex-direction: column;
        justify-content: space-between;
        background-color: #fff;
    }

    .list .nav-link {
        display: flex;
        align-items: center;
        margin: 8px 0;
        padding: 14px 12px;
        border-radius: 8px;
        text-decoration: none;
    }

    .lists .nav-link:hover {
        background-color: #eea236;
    }

    .nav-link .icon {
        margin-right: 14px;
        font-size: 20px;
        color: #707070;
    }

    .nav-link .link {
        font-size: 16px;
        color: #707070;
        font-weight: 400;
    }

    .lists .nav-link:hover .icon,
    .lists .nav-link:hover .link {
        color: #fff;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: -100%;
        height: 1000vh;
        width: 200%;
        opacity: 0;
        pointer-events: none;
        transition: all 0.4s ease;
        background: rgba(0, 0, 0, 0.3);
    }

    nav.open ~ .overlay {
        opacity: 1;
        left: 260px;
        pointer-events: auto;
    }

</style>

<nav>
    <div class="sidebar" style="padding-top: 0px;">
        <div class="logo" style="padding: 20px 0px; border-right: 1px solid #eea236;">
            <i class="bx bx-menu menu-icon"></i>
            <span class="logo-name">CodingLab</span>
        </div>
        <div class="sidebar-content">
            <div class="lists" style="border-right: 1px solid #eea236; padding-right: 5px;">
                @if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
                    <div class="list">
                        <a href="{{ route('home') }}" class="nav-link" id="page_home">
                            <i class="bx bx-home-alt icon" id="icon_home"></i>
                            <span class="link" id="link_home">Trang chủ</span>
                        </a>
                    </div>
                    <div class="list">
                        <a href="{{ route('users.list') }}" class="nav-link" id="page_users">
                            <i class="bx bx-bar-chart-alt-2 icon" id="icon_users"></i>
                            <span class="link" id="link_users">Người dùng</span>
                        </a>
                    </div>
                    <div class="list">
                        <a href="{{ route('subjects.list') }}" class="nav-link" id="page_subjects">
                            <i class="bx bx-folder-open icon" id="icon_subjects"></i>
                            <span class="link" id="link_subjects">Môn học</span>
                        </a>
                    </div>
                    <div class="list">
                        <a href="{{ route('semesters.list') }}" class="nav-link" id="page_semesters">
                            <i class="bx bx-message-rounded icon" id="icon_semesters"></i>
                            <span class="link" id="link_semesters">Kỳ học</span>
                        </a>
                    </div>
                    <div class="list">
                        <a href="{{ route('classes.list') }}" class="nav-link" id="page_classes">
                            <i class="bx bx-pie-chart-alt-2 icon" id="icon_classes"></i>
                            <span class="link" id="link_classes">Lớp học phần</span>
                        </a>
                    </div>
                    <div class="list">
                        <a href="{{ route('points.list') }}" class="nav-link" id="page_points">
                            <i class="bx bx-heart icon" id="icon_points"></i>
                            <span class="link" id="link_points">Điểm sinh viên</span>
                        </a>
                    </div>
                    <div class="list">
                        <a href="{{ route('notifications.list') }}" class="nav-link" id="page_notifications">
                            <i class="bx bx-bell icon" id="icon_notifications"></i>
                            <span class="link" id="link_notifications">Thông báo</span>
                        </a>
                    </div>
                    <div class="list">
                        <a href="#" class="nav-link">
                            <i class="bx bx-cog icon"></i>
                            <span class="link">Settings</span>
                        </a>
                    </div>
                @elseif(\Illuminate\Support\Facades\Auth::user()->hasRole('teacher'))
                    <div class="list">
                        <a href="{{ route('subjects.list') }}" class="nav-link" id="page_subjects">
                            <i class="bx bx-folder-open icon" id="icon_subjects"></i>
                            <span class="link" id="link_subjects">Môn học</span>
                        </a>
                    </div>
                    <div class="list">
                        <a href="{{ route('classes.list') }}" class="nav-link" id="page_classes">
                            <i class="bx bx-pie-chart-alt-2 icon" id="icon_classes"></i>
                            <span class="link" id="link_classes">Lớp học phần</span>
                        </a>
                    </div>
                    <div class="list">
                        <a href="{{ route('points.list') }}" class="nav-link" id="page_points">
                            <i class="bx bx-heart icon" id="icon_points"></i>
                            <span class="link" id="link_points">Điểm sinh viên</span>
                        </a>
                    </div>
                @endif
                <div class="list">
                    <a href="#" class="nav-link" onclick="logout()">
                        <i class="bx bx-log-out icon"></i>
                        <span class="link">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        checkPath();

        function checkPath() {
            let path = location.pathname
            if (path.includes('users')) path = 'users';
            else if (path.includes('classes')) path = 'classes';
            else if (path.includes('subjects')) path = 'subjects';
            else if (path.includes('semesters')) path = 'semesters';
            else if (path.includes('notifications')) path = 'notifications';
            else if (path.includes('points')) path = 'points';
            else path = 'home';

            $("#page_" + path).css("background-color", "#eea236");
            $("#link_" + path).css("color", "white");
            $("#icon_" + path).css("color", "white");

        }

        function logout() {
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

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')

    <title>Login</title>
</head>
<body>
<section class="h-full bg-gray-200 md:h-screen">
    <div class="container mx-auto py-12 px-6 h-full">
        <div class="flex justify-center items-center h-full text-gray-800">
            <div class="xl:w-1/2">
                <div class="block bg-white shadow-lg rounded-lg">
                    <div class="px-4 md:px-0">
                        <div class="md:p-12 md:mx-6">
                            <div class="text-center">
                                <img
                                    class="mx-auto w-48"
                                    src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp"
                                    alt="logo"
                                />
                                <h4 class="text-xl font-semibold mt-1 mb-12 pb-1">Amara Store</h4>
                            </div>
                            <form id="login" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="flex flex-row items-center justify-center lg:justify-start mb-4">
                                    <p class="mb-0 mr-4">Sign in with</p>
                                    <a href="#"
                                       style="background: linear-gradient(to right, #d8363a, #dd3675, #b44593);"
                                       type="button"
                                       data-mdb-ripple="true"
                                       data-mdb-ripple-color="light"
                                       class="inline-block p-3 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mx-1"
                                    >
                                        <!-- Facebook -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-4 h-4">
                                            <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                            <path
                                                fill="currentColor"
                                                d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                                            />
                                        </svg>
                                    </a>

                                    <a href="#"
                                       style="background: linear-gradient(to right, #ee7724, #b44593);"
                                       type="button"
                                       data-mdb-ripple="true"
                                       data-mdb-ripple-color="light"
                                       class="inline-block p-3 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mx-1"
                                    >
                                        <!-- Google -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512" class="w-4 h-4"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                fill="currentColor"
                                                d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/>
                                        </svg>
                                    </a>

                                    <a href="#"
                                       style="background: linear-gradient(to right, #d8363a, #ee7724, #dd3675);"
                                       type="button"
                                       data-mdb-ripple="true"
                                       data-mdb-ripple-color="light"
                                       class="inline-block p-3 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mx-1"
                                    >
                                        <!-- Twitter -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                                            <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                            <path
                                                fill="currentColor"
                                                d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"
                                            />
                                        </svg>
                                    </a>

                                </div>

                                <div
                                    class="flex items-center my-8 before:flex-1 before:border-t before:border-gray-300 before:mt-0.5 after:flex-1 after:border-t after:border-gray-300 after:mt-0.5"
                                >
                                    <p class="text-center font-semibold mx-4 mb-0">Or</p>
                                </div>

                                <div class="text-red-600 text-sm mb-2 text-center" id="HelpText">

                                </div>

                                <div class="mb-4">
                                    @if(\Session::has('errorEmail'))
                                        <div class="text-red-600 px-3 text-xs mb-2">
                                            {{\Session::get('errorEmail')}}
                                        </div>
                                    @endif
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        class="form-control block w-full px-3 py-1.5 text-base border border-gray-300 rounded m-0 focus:outline-none"
                                        placeholder="Email"
                                        required
                                    />
                                </div>
                                <div class="mb-4">
                                    @if(\Session::has('errorPassword'))
                                        <div class="text-red-600 px-3 text-xs mb-2">
                                            {{\Session::get('errorPassword')}}
                                        </div>
                                    @endif
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        class="form-control block w-full px-3 py-1.5 text-base border border-gray-300 rounded m-0 focus:outline-none"
                                        placeholder="Password"
                                        required
                                    />
                                </div>
                                <div class="text-center pt-1 mb-20 pb-1">
                                    <button
                                        class="inline-block px-6 py-2.5 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg transition duration-150 ease-in-out w-full mb-3"
                                        type="submit"
                                        data-mdb-ripple="true"
                                        data-mdb-ripple-color="light"
                                        style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);"
                                    >
                                        Log In
                                    </button>
                                    <a class="text-gray-500" href="{{ route('password.request') }}">Forgot password?</a>
                                </div>

                                <div class="flex justify-center pb-6">
                                    <p class="mb-0 mr-2">Don't have an account? <a href="{{ route('register.request') }}" class="text-pink-700">Sign up</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>

    $("#login").submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route('login') }}',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            method: "POST",
            data: {
                email: $("#email").val(),
                password: $("#password").val(),
            },
            success: function (data) {
                if (data.status_code === 200) {
                    localStorage.setItem("token", data.access_token);
                    localStorage.setItem("token_type", data.token_type);

                    window.location = "/users";
                } else {
                    console.log(data);
                    $("#HelpText").html('Tài khoản hoặc mật khẩu không đúng');
                }
            },
            error: function (err) {
                alert('error');
                console.log(err);
            },
        });
        return true;
    });
</script>
</body>
</html>


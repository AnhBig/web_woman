<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ !empty($meta_title) ? $meta_title : 'TN - SHOP' }}</title>

    @if (!empty($meta_keywords))
        <meta name="keywords" content="{{ $meta_keywords }}">
    @endif

    @if (!empty($meta_description))
        <meta name="description" content="{{ $meta_description }}">
    @endif

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/') }}assets_fe/images/logo-icon.png">

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('/') }}assets_fe/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets_fe/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets_fe/css/plugins/magnific-popup/magnific-popup.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('/') }}assets_fe/css/style.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets_fe/css/fontawsome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('style')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>
    <div class="page-wrapper">
        <!-- End .header -->
        @include('user.layout.header')

        @yield('main')
        <!-- End .main -->

        @include('user.layout.footer')
        <!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div>

    @include('user.layout.mobile_menu')

    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin"
                                        role="tab" aria-controls="signin" aria-selected="true">Đăng nhập</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register"
                                        role="tab" aria-controls="register" aria-selected="false">Đăng kí</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                {{-- Sign In --}}
                                <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                    aria-labelledby="signin-tab">
                                    <form action="#" method="POST" id="SubmitFormLogin">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <label for="signin-email">Email <b class="text-danger">*</b></label>
                                            <input type="text" class="form-control" placeholder="Nhập email"
                                                id="signin-email" name="signin_email">
                                            <p class="text-danger" id="email_signin_error"></p>
                                        </div>
                                        <!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="signin-password">Mật khẩu *</label>
                                            <input type="password" class="form-control" placeholder="Nhập mật khẩu"
                                                id="signin-password" name="signin_password">
                                            <p class="text-danger" id="password_signin_error"></p>
                                            <p class="text-danger" id="error_login"></p>
                                        </div>
                                        <!-- End .form-group -->
                                        <div class="form-group">
                                            <input type="checkbox" id="signin-remember" name="remember">
                                            <label for="signin-remember">Nhớ tôi</label>
                                        </div>
                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>Đăng nhập</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <a href="{{ route('forgot_password') }}"
                                                class="forgot-link float-end">Quên mật khẩu ?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">Đăng nhập bằng</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="{{ route('loginGoogle') }}" class="btn btn-login btn-g">
                                                    <i class="icon-google"></i>
                                                    Đăng nhập bằng Google
                                                </a>
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Đăng nhập bằng facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->

                                {{-- Register --}}
                                <div class="tab-pane fade" id="register" role="tabpanel"
                                    aria-labelledby="register-tab">
                                    <form action="#" id="SubmitFormRegister" method="POST">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="register-email">Email <b class="text-danger">*</b></label>
                                            <input type="email" class="form-control" placeholder="Nhập email"
                                                id="register-email" name="register_email">
                                            <p class="text-danger" id="email_error"></p>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register-password">Mật khẩu <b
                                                    class="text-danger">*</b></label>
                                            <input type="password" class="form-control" placeholder="Nhập mật khẩu"
                                                id="register-password" name="register_password">
                                            <p class="text-danger" id="password_error"></p>

                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>Đăng kí</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy">Tôi đồng ý
                                                    với <a href="#">chính sách bảo mật</a> *</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <div class="form-choice">
                                        <p class="text-center">Đăng nhập bằng</p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="{{ route('loginGoogle') }}" class="btn btn-login btn-g">
                                                    <i class="icon-google"></i>
                                                    Đăng nhập bằng Google
                                                </a>
                                            </div><!-- End .col-6 -->
                                            <div class="col-sm-6">
                                                <a href="#" class="btn btn-login  btn-f">
                                                    <i class="icon-facebook-f"></i>
                                                    Đăng nhập bằng Facebook
                                                </a>
                                            </div><!-- End .col-6 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .form-choice -->
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div>
                    <!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div>
    <!-- End .modal -->


    <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="{{ asset('/') }}assets_fe/images/popup/newsletter/logo.png" class="logo"
                                alt="logo" width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Subscribe to the Molla eCommerce newsletter to receive timely updates from your favorite
                                products.</p>
                            <form action="#">
                                <div class="input-group input-group-round">
                                    <input type="email" class="form-control form-control-white"
                                        placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><span>go</span></button>
                                    </div><!-- .End .input-group-append -->
                                </div><!-- .End .input-group -->
                            </form>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                <label class="custom-control-label" for="register-policy-2">Do not show this popup
                                    again</label>
                            </div><!-- End .custom-checkbox -->
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5 ">
                        <img src="{{ asset('/') }}assets_fe/images/popup/newsletter/img-1.jpg"
                            class="newsletter-img" alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Plugins JS File -->
    <script src="{{ asset('/') }}assets_fe/js/jquery.min.js"></script>
    <script src="{{ asset('/') }}assets_fe/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/') }}assets_fe/js/jquery.hoverIntent.min.js"></script>
    <script src="{{ asset('/') }}assets_fe/js/jquery.waypoints.min.js"></script>
    <script src="{{ asset('/') }}assets_fe/js/superfish.min.js"></script>
    <script src="{{ asset('/') }}assets_fe/js/owl.carousel.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('/') }}assets_fe/js/main.js"></script>

    @yield('script')

    <script>
        $(document).ready(function() {
            function showSuccessToast(title) {
                Swal.fire({
                    title: title,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1800
                });
            }

            var pathname = window.location.pathname;

            // Register
            $("body").delegate("#SubmitFormRegister", "submit", function(e) {
                e.preventDefault();
                // alert("Đăng ký thành công");

                var signin_tab = $("#signin-tab");
                var register_email = $('#register-email')
                var register_password = $('#register-password')
                var email_error = $('#email_error')
                var password_error = $('#password_error')


                function handleErrors(errors) {
                    if (errors.register_email) {
                        $('#register-email').addClass('is-invalid');
                        $('#email_error').text(errors.register_email);
                    } else {
                        $('#register-email').removeClass('is-invalid');
                        $('#email_error').text('');
                    }

                    if (errors.register_password) {
                        $('#register-password').addClass('is-invalid');
                        $('#password_error').text(errors.register_password);
                    } else {
                        $('#register-password').removeClass('is-invalid');
                        $('#password_error').text('');
                    }
                }

                function resetErrors() {
                    register_email.val('')
                    register_password.val('')
                }


                $.ajax({
                    type: "POST",
                    url: "{{ route('user_register') }}",
                    dataType: "JSON",
                    __csrf: "{{ csrf_token() }}",
                    data: $(this).serialize(),
                    success: function(res) {
                        if (res.status == true) {
                            resetErrors()
                            showSuccessToast(res.message)
                            signin_tab.click();
                        } else {
                            handleErrors(res.errors);
                        }
                    }
                })
            })

            // Signin
            $("body").delegate("#SubmitFormLogin", "submit", function(e) {
                e.preventDefault();

                var btn_close = $(".close");
                var sigin_email = $('#signin-email')
                var sigin_password = $('#signin-password')
                var email_signin_error = $('#email_signin_error')
                var remember = $('#remember')
                var password_signin_error = $('#password_signin_error')
                var error_login = $('#error_login')

                function handleErrors(errors) {
                    if (errors.signin_email) {
                        $('#signin-email').addClass('is-invalid');
                        $('#email_signin_error').text(errors.signin_email);
                    } else {
                        $('#signin-email').removeClass('is-invalid');
                        $('#email_signin_error').text('');
                    }

                    if (errors.signin_password) {
                        $('#signin-password').addClass('is-invalid');
                        $('#password_signin_error').text(errors.signin_password);
                    } else {
                        $('#signin-password').removeClass('is-invalid');
                        $('#password_signin_error').text('');
                    }
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('user_signin') }}",
                    dataType: "JSON",
                    __csrf: "{{ csrf_token() }}",
                    data: $(this).serialize(),
                    success: function(res) {
                        if (res.status == true) {
                            btn_close.click()
                            showSuccessToast(res.message);
                            setTimeout(() => {
                                location.reload();
                                if (pathname == '/dang-nhap') {
                                    window.location.href = "{{ url('/') }}";
                                }
                            }, 1500);
                        } else {
                            error_login.text(res.message);
                            handleErrors(res.errors);
                            sigin_email.val('');
                            sigin_password.val('');
                        }
                    }
                })
            })
        })
    </script>


</body>


<!-- molla/index-2.html  22 Nov 2019 09:55:42 GMT -->

</html>

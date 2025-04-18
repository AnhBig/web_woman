@extends('user.layout.main')

@section('style')
@endsection

@section('main')
    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('{{ asset('') }}assets_fe/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Thanh toán</h1>
            </div>

            @if (Session::has('error'))
                <script>
                    Swal.fire({
                        title: "{{ Session::get('error') }}",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1600
                    });
                </script>
            @endif

            <!-- End .container -->
        </div>
        <!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cart') }}">Giỏ hàng</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                </ol>
            </div>
            <!-- End .container -->
        </nav>
        <!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="checkout">
                <div class="container">
                    <!-- End .checkout-discount -->
                    <form action="{{ route('place_order') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <h2 class="checkout-title">Địa chỉ nhận hàng</h2>
                                <div class="render_address_default">
                                    @include('user.payment.address_default')
                                </div>

                                <label class="pt-2">Ghi chú <i class="text-info">(không bắt buộc)</i></label>
                                <textarea class="form-control m-0" cols="20" name="note" rows="4" placeholder="Ghi chú">{{ old('note') }}</textarea>
                                <b class="text-danger">{{ $errors->first('note') }}</b>
                            </div>

                            <!-- End .col-lg-9 -->
                            <aside class="col-lg-4">
                                <div class="summary">
                                    <h3 class="summary-title">Đơn hàng của bạn</h3>
                                    <!-- End .summary-title -->

                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach (Cart::getContent() as $cart)
                                                <tr>
                                                    <td>
                                                        @php
                                                            $getProductImage = \App\Models\Product::singleImage(
                                                                $cart->id,
                                                            );
                                                        @endphp
                                                        <div class="d-flex">
                                                            <a href="#">
                                                                <img width="70"
                                                                    src="{{ $getProductImage->checkImage() }}"
                                                                    alt="{{ $cart->name }}">
                                                            </a>
                                                            <a class="ms-2"
                                                                href="#">{{ Str::limit($cart->name, 40) }}</a>
                                                        </div>
                                                        <p>{{ $cart->attributes['name_color'] }}</p>
                                                        <p>Size: {{ $cart->attributes['name_size'] }} *
                                                            {{ $cart->quantity }}</p>
                                                    </td>
                                                    <td>{{ number_format($cart->price * $cart->quantity, '0', ',', '.') }}₫
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr class="summary-subtotal">
                                                <td>Tổng phụ:</td>
                                                <td>{{ number_format(Cart::getSubTotal(), '0', ',', '.') }}₫</td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">
                                                    <div class="cart-discount">
                                                        <div class="input-group">
                                                            <input type="text" id="getVoucher" name="discount_code"
                                                                autocomplete="off" class="form-control"
                                                                placeholder="Nhập mã giảm giá ...">
                                                            <div class="input-group-append">
                                                                <button type="button" id="ApplyVoucher"
                                                                    class="btn btn-outline-primary-2"
                                                                    style="height: 40px;"><i
                                                                        class="icon-long-arrow-right"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr id="useDiscountCode">

                                            </tr>

                                            <tr class="summary-total">
                                                <td>Tổng thanh toán:</td>
                                                <td data-total="{{ number_format(Cart::getSubTotal(), '0', ',', '.') }}₫"
                                                    id="totalCart">{{ number_format(Cart::getTotal(), '0', ',', '.') }}₫
                                                </td>
                                            </tr>

                                            <!-- End .summary-total -->
                                        </tbody>
                                    </table>
                                    <!-- End .table table-summary -->

                                    <div class="accordion-summary" id="accordion-payment">
                                        <div class="custome-control custom-radio payment_item">
                                            <input type="radio" name="payment_method" value="cash"
                                                @checked(true) class="type_payment" id="payment_cash">
                                            <label class="custome-control-label label_payment" for="payment_cash">Tiền
                                                mặt</label>
                                        </div>
                                        <div class="custome-control custom-radio payment_item">
                                            <input type="radio" name="payment_method" value="vnpay" class="type_payment"
                                                id="payment_vnpay">
                                            <label class="custome-control-label label_payment" for="payment_vnpay">VN
                                                PAY</label>
                                        </div>
                                        <div class="custome-control custom-radio payment_item">
                                            <input type="radio" name="payment_method" class="type_payment"
                                                id="payment_momo" value="momo">
                                            <label class="custome-control-label label_payment"
                                                for="payment_momo">Momo</label>
                                        </div>

                                    </div>

                                    <!-- End .accordion -->
                                    <div class="render_btn_place_order">
                                        @if ($addressDefault)
                                            <button type="submit" name="redirect"
                                                class="btn btn-outline-primary-2 btn-order btn-block">
                                                <span class="btn-text">Đặt hàng</span>
                                                <span class="btn-hover-text">Đặt hàng</span>
                                            </button>
                                        @else
                                            <a href="#add-address" id="auto_new_address" data-toggle="modal"
                                                class="btn btn-outline-primary-2 btn-order btn-block">
                                                <span class="btn-text">Đặt hàng</span>
                                                <span class="btn-hover-text">Đặt hàng</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <!-- End .summary -->
                            </aside>
                            <!-- End .col-lg-3 -->
                        </div>
                        <!-- End .row -->
                    </form>
                </div>
                <!-- End .container -->
            </div>
            <!-- End .checkout -->
        </div>
        <!-- End .page-content -->
    </main>


    {{-- list change address --}}
    <div class="modal fade" id="list_address" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                    <div class="form-box">
                        <div class="modal-header">
                            <h5 class="modal-title">Địa chỉ nhận hàng</h5>
                            <a href="#add-address" data-toggle="modal" class="pr-5 mr-5 text-info"><b>Thêm mới</b></a>
                        </div>
                        <div class="render_address_checkout">
                            @include('user.payment.list_address_checkout')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- add address --}}
    <div class="modal fade" id="add-address" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="dialog">
            <div class="modal-content">
                <div class="modal-body ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="modal-header">
                            <h4>Địa chỉ mới</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Họ và tên</label>
                                    <input type="text" class="form-control" placeholder="Họ tên" id="name_address"
                                        name="name">
                                    <p class="text-danger" id="error_name_address"></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Số điện thoại</label>
                                    <input type="text" class="form-control" placeholder="Số điện thoại"
                                        id="phone_address" name="phone">
                                    <p class="text-danger" id="error_phone_address"></p>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label>Tỉnh/Thành phố <b class="text-danger">*</b></label>
                                <select class="form-select m-0 " name="city" id="city">
                                    <option value="" selected disabled>Thành phố</option>
                                </select>
                                <p class="text-danger" id="error_city"></p>

                            </div>
                            <div class="col-lg-6">
                                <label>Thành phố/Huyện <b class="text-danger">*</b></label>
                                <select class="form-select m-0" name="district" id="district">
                                    <option value="" selected disabled>Thành phố</option>
                                </select>
                                <p class="text-danger" id="error_district"></p>

                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label>Phường/Xã <b class="text-danger">*</b></label>
                            <select class="form-select m-0" name="ward" id="ward">
                                <option value="" selected disabled>Khu vực</option>
                            </select>
                            <p class="text-danger" id="error_ward"></p>
                        </div>

                        <div class="form-group">
                            <label for="">Địa chỉ cụ thể</label>
                            <textarea class="form-control" id="home_address" name="home_address"></textarea>
                            <p class="text-danger" id="error_home_address"></p>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-info" class="close" data-dismiss="modal"
                                aria-label="Close">Trở về</button>
                            <button type="button" class="btn btn-primary" id="save_address">Hoàn thành</button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- edit address --}}
    <div class="modal fade" id="edit-address" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="dialog">
            <div class="modal-content">
                <div class="modal-body ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="render_edit_address">
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // auto complete newaddress
            $("#auto_new_address").click();

            // address checkout
            let data = {};
            $.ajax({
                url: "{{ asset('assets_fe/address/db_country.json') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    data = response;
                    // console.log(data);
                    populateCities();
                },
                error: function(xhr, status, error) {
                    console.error('There was a problem with the AJAX request:', status, error);
                }
            });

            // Populate cities select
            function populateCities() {
                const citySelect = $('#city');
                citySelect.empty();
                citySelect.append('<option value="" selected disabled>Chọn tỉnh thành</option>');
                $.each(data, function(index, city) {
                    citySelect.append(
                        `<option data-id="${city.Id}" value="${city.Name}" {{ old('city') ? 'selected' : '' }}>${city.Name}</option>`
                    );
                });
            }

            // Event listener for city select change
            $('#city').on('change', function() {
                const cityId = $('#city option:selected').data('id');
                // console.log(cityId);
                populateDistricts(cityId);
                $('#ward').empty().append('<option value="" selected disabled>Chọn phường xã</option>');
            });

            // Populate districts select
            function populateDistricts(cityId) {
                const districtSelect = $('#district');
                districtSelect.empty();
                districtSelect.append('<option value="" selected disabled>Chọn quận huyện</option>');

                const city = data.find(city => city.Id == cityId);
                if (city) {
                    $.each(city.Districts, function(index, district) {
                        districtSelect.append(
                            `<option data-id="${district.Id}" value="${district.Name}">${district.Name}</option>`
                        );
                    });
                }
            }

            // Event listener for district select change
            $('#district').on('change', function() {
                const cityId = $('#city option:selected').data('id');
                const districtId = $('#district option:selected').data('id');
                // console.log(cityId, districtId);
                populateWards(cityId, districtId);
            });

            // Populate wards select
            function populateWards(cityId, districtId) {
                const wardSelect = $('#ward');
                wardSelect.empty();
                wardSelect.append('<option value="" selected>Chọn phường xã</option>');

                const city = data.find(city => city.Id == cityId);
                if (city) {
                    const district = city.Districts.find(district => district.Id == districtId);
                    if (district) {
                        $.each(district.Wards, function(index, ward) {
                            wardSelect.append(`<option value="${ward.Name}">${ward.Name}</option>`);
                        });
                    }
                }
            }

            // address default
            $(document).on('click', '.btn_address_default', function() {
                var id = $(this).data('id');
                // alert("Địa chỉ mặc định: " + id);

                $.ajax({
                    url: "{{ route('checkOutAddressDefault') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        // alert(response);

                        $(".render_address_checkout").html(response.view);
                        $(".render_address_default").html(response.viewAddressDefault);

                    },
                    error: function(xhr, status, error) {
                        console.error('There was a problem with the AJAX request:',
                            status, error);
                    }
                })
            })

            // add new address
            $("#save_address").on('click', function() {
                var name_address = $('#name_address').val();
                var phone_address = $('#phone_address').val();
                var city = $('#city').val();
                var district = $('#district').val();
                var ward = $('#ward').val();
                var home_address = $('#home_address').val();

                var isValid = true;

                if (name_address == "") {
                    $("#error_name_address").text("Vui lòng nhập họ và tên!");
                    $("#name_address").focus();
                    $("#name_address").addClass("is-invalid");
                    isValid = false;
                } else {
                    $("#error_name_address").text("");
                    $("#name_address").removeClass("is-invalid");
                }

                if (phone_address == "") {
                    $("#error_phone_address").text("Vui lòng nhập số điện thoại!");
                    $("#phone_address").focus();
                    $("#phone_address").addClass("is-invalid");
                    isValid = false;
                } else {
                    $("#error_phone_address").text("");
                    $("#phone_address").removeClass("is-invalid");
                }

                if (city == "" || city == null) {
                    $("#error_city").text("Vui lòng chọn thành phố!");
                    $("#city").focus();
                    $("#city").addClass("is-invalid");
                    isValid = false;
                } else {
                    $("#error_city").text("");
                    $("#city").removeClass("is-invalid");
                }

                if (district == "" || district == null) {
                    $("#error_district").text("Vui lòng chọn quận huyện!");
                    $("#district").focus();
                    $("#district").addClass("is-invalid");
                    isValid = false;
                } else {
                    $("#error_district").text("");
                    $("#district").removeClass("is-invalid");
                }

                if (ward == "" || ward == null) {
                    $("#error_ward").text("Vui lòng chọn phường xã!");
                    $("#ward").focus();
                    $("#ward").addClass("is-invalid");
                    isValid = false;
                } else {
                    $("#error_ward").text("");
                    $("#ward").removeClass("is-invalid");
                }

                if (home_address == "") {
                    $("#error_home_address").text("Vui lòng nhập địa chỉ nhà!");
                    $("#home_address").focus();
                    $("#home_address").addClass("is-invalid");
                    isValid = false;
                } else {
                    $("#error_home_address").text("");
                    $("#home_address").removeClass("is-invalid");
                }

                if (isValid) {
                    $.ajax({
                        url: "{{ route('checkOutNewAddress') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name_address: name_address,
                            phone_address: phone_address,
                            city: city,
                            district: district,
                            ward: ward,
                            home_address: home_address
                        },
                        success: function(response) {
                            // console.log(response);

                            $("#name_address").val("");
                            $("#phone_address").val("");
                            $("#city").val("");
                            $("#district").val("");
                            $("#ward").val("");
                            $("#home_address").val("");

                            Swal.fire({
                                title: "Thêm địa chỉ thành công",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1600
                            });



                            $(".btn-outline-info").click();
                            $(".render_address_checkout").html(response.view);
                            $(".render_address_default").html(response.viewAddressDefault);

                            var btn_html = `
                                <button type="submit" name="redirect"
                                    class="btn btn-outline-primary-2 btn-order btn-block">
                                    <span class="btn-text">Đặt hàng</span>
                                    <span class="btn-hover-text">Đặt hàng</span>
                                </button>
                            `
                            $(".render_btn_place_order").html(btn_html);


                        },
                        error: function(xhr, status, error) {
                            console.error('There was a problem with the AJAX request:', status,
                                error);
                        }
                    })
                }
            })

            //edit address
            $(document).on('click', '.btn_edit_address', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: "{{ route('checkOutEditAddress') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        // console.log(response);
                        $(".render_edit_address").html(response.view);

                        let dataEdit = {};
                        $.ajax({
                            url: "{{ asset('assets_fe/address/db_country.json') }}",
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                dataEdit = response;
                                // console.log(dataEdit);
                                populateCitiesEdit();
                            },
                            error: function(xhr, status, error) {
                                console.error(
                                    'There was a problem with the AJAX request:',
                                    status, error);
                            }
                        });

                        // Populate cities select
                        function populateCitiesEdit() {
                            const citySelectEdit = $('#city_edit');
                            $.each(dataEdit, function(index, city) {
                                citySelectEdit.append(
                                    `<option data-id="${city.Id}" value="${city.Name}">${city.Name}</option>`
                                );
                            });
                        }

                        // Event listener for city select change
                        $('#city_edit').on('change', function() {
                            const cityIdEdit = $('#city_edit option:selected').data(
                                'id');
                            populateDistrictsEdit(cityIdEdit);
                            $('#ward_edit').empty().append(
                                '<option value="" selected disabled>Chọn phường xã</option>'
                            );
                        });

                        // Populate districts select
                        function populateDistrictsEdit(cityId) {
                            const districtSelectEdit = $('#district_edit');
                            districtSelectEdit.empty();
                            districtSelectEdit.append(
                                '<option value="" selected disabled>Chọn quận huyện</option>'
                            );

                            const cityEdit = dataEdit.find(city => city.Id == cityId);
                            if (cityEdit) {
                                $.each(cityEdit.Districts, function(index, district) {
                                    districtSelectEdit.append(
                                        `<option data-id="${district.Id}" value="${district.Name}">${district.Name}</option>`
                                    );
                                });
                            }
                        }

                        // Event listener for district select change
                        $('#district_edit').on('change', function() {
                            const cityId = $('#city_edit option:selected').data('id');
                            const districtId = $('#district_edit option:selected').data(
                                'id');
                            populateWardsEdit(cityId, districtId);
                        });

                        // Populate wards select
                        function populateWardsEdit(cityId, districtId) {
                            const wardSelect = $('#ward_edit');
                            wardSelect.empty();
                            wardSelect.append(
                                '<option value="" selected>Chọn phường xã</option>');

                            const city = dataEdit.find(city => city.Id == cityId);
                            if (city) {
                                const district = city.Districts.find(district => district.Id ==
                                    districtId);
                                if (district) {
                                    $.each(district.Wards, function(index, ward) {
                                        wardSelect.append(
                                            `<option value="${ward.Name}">${ward.Name}</option>`
                                        );
                                    });
                                }
                            }
                        }

                        // update address
                        $("#update_address").on('click', function() {
                            var id = $(this).data('id');
                            var edit_name_address = $("#name_address_edit").val();
                            var edit_phone_address = $("#phone_address_edit").val();
                            var edit_city = $("#city_edit").val();
                            var edit_district = $("#district_edit").val();
                            var edit_ward = $("#ward_edit").val();
                            var edit_home_address = $("#home_address_edit").val();

                            var isValidEdit = true;

                            if (edit_name_address == "") {
                                $("#error_edit_name_address").text(
                                    "Vui lòng điền đầy đủ họ tên!");
                                $("#name_address_edit").focus();
                                $("#name_address_edit").addClass("is-invalid");
                                isValidEdit = false;
                            } else if (edit_name_address.length < 5) {
                                $("#error_edit_name_address").text(
                                    "Nhập đầy đủ họ và tên !");
                                $("#name_address_edit").focus();
                                $("#name_address_edit").addClass("is-invalid");
                                isValidEdit = false;
                            } else {
                                $("#error_edit_name_address").text("");
                                $("#edit_name_address").removeClass("is-invalid");
                            }

                            if (edit_phone_address == "") {
                                $("#error_edit_phone_address").text(
                                    "Vui lòng nhập số điện thoại!");
                                $("#edit_phone_address").focus();
                                $("#edit_phone_address").addClass("is-invalid");
                                isValidEdit = false;
                            } else if (!/^\d{10}$/.test(
                                    edit_phone_address)) {
                                $("#error_edit_phone_address").text(
                                    "Số điện thoại không hợp lệ!");
                                $("#edit_phone_address").focus();
                                $("#edit_phone_address").addClass("is-invalid");
                                isValidEdit = false;
                            } else {
                                $("#error_edit_phone_address").text("");
                                $("#edit_phone_address").removeClass("is-invalid");
                            }

                            if (edit_district == null) {
                                $("#district_edit").addClass("is-invalid");
                                $("#error_edit_district").text(
                                    "Vui lòng chọn quận huyện!");
                                $("#edit_district").focus();
                                isValidEdit = false;
                            }
                            if (edit_ward == null) {
                                $("#ward_edit").addClass("is-invalid");
                                $("#error_edit_ward").text("Vui lòng chọn phường xã!");
                                $("#ward_edit").focus();
                                isValidEdit = false;
                            }

                            if (edit_home_address == "") {
                                $("#error_edit_home_address").text(
                                    "Vui lòng nhập địa chỉ cụ thể !");
                                $("#edit_home_address").focus();
                                $("#edit_home_address").addClass("is-invalid");
                                isValidEdit = false;
                            } else {
                                $("#error_edit_home_address").text("");
                                $("#edit_home_address").removeClass("is-invalid");
                            }


                            if (isValidEdit) {
                                $.ajax({
                                    url: "{{ route('checkOutUpdateAddress') }}",
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: id,
                                        name_address: edit_name_address,
                                        phone_address: edit_phone_address,
                                        city: edit_city,
                                        district: edit_district,
                                        ward: edit_ward,
                                        home_address: edit_home_address
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            title: "Cập nhật địa chỉ thành công",
                                            icon: "success",
                                            showConfirmButton: false,
                                            timer: 1800
                                        });

                                        $(".btn-outline-info").click();

                                        $(".render_address_checkout").html(
                                            response.view);

                                        $(".render_address_default").html(
                                            response.viewAddressDefault);

                                    },
                                    error: function(xhr, status, error) {
                                        console.error(
                                            'There was a problem with the AJAX request:',
                                            status, error);
                                    }
                                })
                            }

                        });



                    },
                    error: function(xhr, status, error) {
                        console.error('There was a problem with the AJAX request:',
                            status,
                            error);
                    }
                });

            })


        });
    </script>

    {{-- apply voucher --}}
    <script>
        function formatToVND(price) {
            return formattedPrice = Math.abs(price).toLocaleString('vi-VN') + '₫';
        }

        $(document).ready(function() {
            $("body").delegate("#ApplyVoucher", "click", function() {
                var voucher = $("#getVoucher").val();
                var deducted_amount = $('#useDiscountCode')
                let latestRequestTime = 0;
                let totalCart = $("#totalCart");
                if (voucher != "" && voucher != null) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('thanh-toan/apply-voucher') }}",
                        data: {
                            voucher: voucher,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "JSON",
                        success: function(data) {
                            const currentRequestTime = Date.now();
                            if (currentRequestTime > latestRequestTime) {
                                latestRequestTime = currentRequestTime;
                                deducted_amount.empty();
                                if (data.status == true) {
                                    var newRoww = `
                                        <td><b class="text-danger">${data.message}</b></td>
                                        <td><b class="text-danger">-${formatToVND(data.deducted_amount)}</b></td>
                                    `
                                    deducted_amount.append(newRoww)
                                    totalCart.text(formatToVND(data.newTotal));
                                } else {
                                    deducted_amount.empty();

                                    var newRoww = `
                                        <td><b class="text-danger">${data.message}</b></td>
                                        <td></td>
                                    `
                                    deducted_amount.append(newRoww)
                                    var totalCartOld = totalCart.attr("data-total");
                                    totalCart.text(totalCartOld);
                                    // console.log(totalCartOld);
                                }
                            }
                        }
                    })

                } else {
                    deducted_amount.empty();
                    var newRoww = `
                                <td><b class="text-danger">Vui lòng nhập mã giảm giá</b></td>
                                <td></td>
                            `
                    deducted_amount.append(newRoww)
                }



            })
        });
    </script>
@endsection

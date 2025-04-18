@extends('admin.layout.app')
@section('title', 'Mã giảm giá')

@section('main')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1600
            });
        </script>
    @endif

    <!-- begin row -->
    <div class="row">
        <div class="col-md-12 m-b-30">
            <!-- begin page title -->
            <div class="d-block d-sm-flex flex-nowrap align-items-center">
                <div class="page-title mb-2 mb-sm-0">
                    <h1>Danh sách mã giảm giá</h1>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <nav>
                        <ol class="breadcrumb p-0 m-b-0">
                            <li class="breadcrumb-item">
                                <a href="index.html"><i class="ti ti-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Admin
                            </li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Danh sách mã giảm giá
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a class="btn btn-primary mt-2" href="{{ route('discount_code.create') }}">Thêm mã giảm giá</a>
            <!-- end page title -->
        </div>
    </div>
    <!-- end row -->
    <!-- begin row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="datatable-wrapper table-responsive">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th>Mã code</th>
                                    <th>Loại</th>
                                    <th>Số tiền giảm giá</th>
                                    <th>Hạn sử dụng</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark">
                                @foreach ($discount_code as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->name_code }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->percent_amount }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->expire_date)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            @if ($item->status == 1)
                                                <b class="badge badge-success">Hiện</b>
                                            @else
                                                <b class="badge badge-danger">Ẩn</b>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('discount_code.edit', ['discount_code' => $item->id]) }}"
                                                    class="btn btn-info  ">Sửa</a>
                                                <button type="button" data-id="{{ $item->id }}"
                                                    class="btn btn-danger delete-discount_code">Xóa</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <script>
        $(document).ready(function() {
            $(".delete-discount_code").each(function() {
                $(this).click(function() {
                    var id = $(this).attr('data-id');

                    var row = $(this).closest('tr');

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: "btn btn-success",
                            cancelButton: "btn btn-danger"
                        },
                        buttonsStyling: false
                    });
                    swalWithBootstrapButtons.fire({
                        title: "Bạn có muốn xóa không ?",
                        text: "Bạn sẽ không thể hoàn nguyên điều này!!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Xóa",
                        cancelButtonText: "Hủy",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            row.fadeOut();

                            $.ajax({
                                url: "{{ route('discount_code.destroy', ':id') }}"
                                    .replace(':id', id),
                                type: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                },
                                success: function(response) {
                                    swalWithBootstrapButtons.fire({
                                        title: "Đã xóa",
                                        text: "Xóa không thành công !",
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1400
                                    });
                                }
                            })


                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire({
                                title: "Đã hủy",
                                text: "Xóa không thành công !",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 1400
                            });
                        }
                    });

                })
            })
        })
    </script>

@endsection

 {{-- <table class="table table-striped table-bordered">
     <thead class="table-dark">
         <tr>
             <th>Tên</th>
             <th>Slug</th>
             <th>Danh mục</th>
             <th>Danh mục phụ</th>
             <th>Thương hiệu</th>
             <th>Giá cũ</th>
             <th>Giá</th>
             <th>Nguời tạo</th>
             <th>Mô tả ngắn</th>
             <th>Mô tả</th>
             <th>Thông tin thêm</th>
             <th>Đơn vị trả hàng</th>
             <th>Thời gian tạo</th>
             <th>Trạng thái</th>
         </tr>
     </thead>
     <tbody class="text-dark">
         <tr>
             <td>{{ Illuminate\Support\Str::limit($seeProductDetail->title, 20, '...') }}</td>
             <td>{{ Illuminate\Support\Str::limit($seeProductDetail->slug, 20, '...') }}</td>
             <td>{{ $seeProductDetail->category_name }}</td>
             <td>{{ $seeProductDetail->sub_category_name }}</td>
             <td>{{ $seeProductDetail->brand_name }}</td>
             <td>{{ $seeProductDetail->old_price }}</td>
             <td>{{ $seeProductDetail->price }}</td>
             <td>Tớ tạo</td>
             <td>
                 {{ strlen($seeProductDetail->short_description) >= 50 ? substr($seeProductDetail->short_description, 0, 50) . '...' : $seeProductDetail->short_description }}
             </td>
             <td>{{ Illuminate\Support\Str::limit($seeProductDetail->description, 50, '...') }}</td>
             <td>{{ Illuminate\Support\Str::limit($seeProductDetail->additional_information, 50, '...') }}
             </td>
             <td>
                 {{ strlen($seeProductDetail->shipping_returns) >= 50 ? substr($seeProductDetail->shipping_returns, 0, 50) . '...' : $seeProductDetail->shipping_returns }}
             </td>
             <td>{{ date('Y-m-d', strtotime($seeProductDetail->created_at)) }}</td>
             <td>
                 @if ($seeProductDetail->status == 1)
                     <b class="badge badge-success">Hiện</b>
                 @else
                     <b class="badge badge-danger">Ẩn</b>
                 @endif
             </td>

         </tr>
     </tbody>
 </table> --}}


 <div class="row account-contant">
     <div class="col-12">
         <div class="card card-statistics">
             <div class="card-body p-0">
                 <div class="row no-gutters">
                     <div class="col-xl-3 pb-xl-0 p-3 border-right">
                         {{-- <div class="m-auto">
                             <img src="https://down-vn.img.susercontent.com/file/324eea1a2e59ae4fa5c7c8c9a352bed9"
                                 class="img-fluid" alt="users-avatar">
                         </div> --}}

                         <div class="layout">
                             <ul class="slider">
                                 @foreach ($seeProductDetail->productImage as $img)
                                     <li>
                                         <img style="width: 100%" height="600px" src="{{ $img->checkImage() }}"
                                             alt="{{ $img->title }}" />
                                     </li>
                                 @endforeach
                             </ul>
                         </div>


                     </div>
                     <div class="col-xl-5 col-md-6 col-12 border-t border-right">
                         <div class="page-account-form">
                             <div class="form-titel border-bottom p-3">
                                 <h5 class="mb-0 py-2">Bạn đang xem chi tiết sản phẩm: {{ $seeProductDetail->title }}
                                 </h5>
                             </div>
                             <div class="p-4">
                                 <form>
                                     <div class="form-row">
                                         <div class="form-group col-md-12">
                                             <label for="name1">Tên sản phẩm</label>
                                             <input type="text" class="form-control" readonly id="name1"
                                                 value="{{ $seeProductDetail->title }}">
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="title1">Slug</label>
                                             <input type="text" class="form-control" readonly id="title1"
                                                 value="{{ $seeProductDetail->slug }}">
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="phone1">Danh mục</label>
                                             <input type="text" class="form-control" readonly id="phone1"
                                                 value="{{ $seeProductDetail->category->name }}">
                                         </div>
                                         <div class="form-group col-md-12">
                                             <label for="email1">Danh mục phụ</label>
                                             <input type="email" class="form-control" readonly id="email1"
                                                 value="{{ $seeProductDetail->subcategory->name }}">
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label for="add2">Thương hiệu</label>
                                         <input type="text" class="form-control" readonly id="add2"
                                             value="{{ $seeProductDetail->brand->name }}">
                                     </div>
                                     <div class="form-group">
                                         <label for="add1">Giá cũ</label>
                                         <input type="text" class="form-control" readonly id="add1"
                                             value="{{ number_format($seeProductDetail->old_price, 0, ',', '.') }}₫">
                                     </div>
                                     <div class="form-group">
                                         <label for="add2">Giá mua</label>
                                         <input type="text" class="form-control" readonly id="add2"
                                             value="{{ number_format($seeProductDetail->price, 0, ',', '.') }}₫">
                                     </div>

                                     <div class="form-group">
                                         <label for="br">Mô tả ngắn:</label>
                                         <textarea name="" class="form-control" readonly cols="10" rows="3">
                                            {{ $seeProductDetail->short_description }}  
                                        </textarea>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                     <div class="col-xl-4 col-md-6 border-t col-12">
                         <div class="page-account-form">
                             <div class="p-4">
                                 <form>
                                     <label for="tr">Màu sắc:</label>

                                     <div class="d-flex">
                                         @foreach ($imageColor as $color)
                                             <div class="card m-2 p-2 text-center">
                                                 <img width="60px" src="{{ $color->checkImage() }}" alt="">
                                                 <p class="pt-2">{{ $color->color_name }}</p>
                                             </div>
                                         @endforeach

                                     </div>
                                     <div class="form-group">
                                         <label for="tr">Kích thước:</label>
                                         @foreach ($product_size as $size)
                                             <input type="text" class="form-control" readonly
                                                 value="{{ $size->name }} - {{ number_format($size->price, 0, ',', '.') }}">
                                         @endforeach

                                     </div>

                                     <div class="form-group">
                                         <label for="br">Mô tả:</label>
                                         <textarea name="" class="form-control" readonly cols="10" rows="5">
                                            {!! $seeProductDetail->description !!}                        
                                        </textarea>
                                     </div>
                                     <div class="form-group">
                                         <label for="br">Thông tin thêm:</label>
                                         <textarea name="" class="form-control" readonly cols="10" rows="5">
                                                              {!! $seeProductDetail->additional_information !!}
                                            </textarea>
                                     </div>
                                     <div class="form-group">
                                         <label for="br">Vận chuyển trả hàng:</label>
                                         <textarea name="" class="form-control" readonly cols="10" rows="5">
                                                               {!! $seeProductDetail->shipping_returns !!}
                                                            </textarea>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>



 <script>
     $(document).ready(function() {
         (function($) {
             $(function() {


                 $('.slider').slick({
                     dots: true,
                     prevArrow: '<a class="slick-prev slick-arrow" href="#" style=""><div class="icon icon--ei-arrow-left"><svg class="icon__cnt"><use xlink:href="#ei-arrow-left-icon"></use></svg></div></a>',
                     nextArrow: '<a class="slick-next slick-arrow" href="#" style=""><div class="icon icon--ei-arrow-right"><svg class="icon__cnt"><use xlink:href="#ei-arrow-right-icon"></use></svg></div></a>',
                     customPaging: function(slick, index) {
                         var targetImage = slick.$slides.eq(index).find('img').attr(
                             'src');
                         return '<img src=" ' + targetImage + ' "/>';
                     }
                 });


             });
         })(jQuery);
     })
 </script>

 <aside class="app-navbar">
     <!-- begin sidebar-nav -->
     <div class="sidebar-nav scrollbar scroll_light">
         <ul class="metismenu " id="sidebarNav">
             <li class="nav-static-title">RIÊNG TƯ</li>
             {{-- <li class="{{ request()->is('admin/*') ? 'active' : '' }}"> --}}
             <li class="{{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                 <a href="{{ route('dashboard') }}" aria-expanded="false">
                     <i class="nav-icon ti ti-rocket"></i>
                     <span class="nav-title">Thống kê</span>
                 </a>
             </li>
             <li class="{{ request()->segment(2) == 'user' ? 'active' : '' }}">
                 <a href="{{ route('user.index') }}" aria-expanded="false">
                     <i class="nav-icon fa fa-users"></i>
                     <span class="nav-title">Admin</span>
                 </a>
             </li>
             <li class="{{ request()->segment(2) == 'category' ? 'active' : '' }}">
                 <a href="{{ url('admin/category') }}" aria-expanded="false">
                     <i class="nav-icon ti ti-menu-alt"></i>
                     <span class="nav-title">Danh mục</span>
                 </a>
             </li>
             <li class="{{ request()->segment(2) == 'sub_category' ? 'active' : '' }}">
                 <a href="{{ route('sub_category.index') }}" aria-expanded="false">
                     <i class="nav-icon ti ti-menu"></i>
                     <span class="nav-title">Danh mục phụ</span>
                 </a>
             </li>
             <li class="{{ request()->segment(2) == 'brand' ? 'active' : '' }}">
                 <a href="{{ route('brand.index') }}" aria-expanded="false">
                     <i class="nav-icon ion ion-ios-megaphone"></i>
                     <span class="nav-title">Thương hiệu</span>
                 </a>
             </li>

             <li class="{{ request()->segment(2) == 'product' ? 'active' : '' }}">
                 <a href="{{ route('product.index') }}" aria-expanded="false">
                     <i class="nav-icon fa fa-product-hunt"></i>
                     <span class="nav-title">Sản phẩm</span>
                 </a>
             </li>
             <li class="{{ request()->segment(2) == 'discount_code' ? 'active' : '' }}">
                 <a href="{{ route('discount_code.index') }}" aria-expanded="false">
                     <i class="nav-icon fa fa-product-hunt"></i>
                     <span class="nav-title">Mã giảm giá</span>
                 </a>
             </li>

             <li @if (request()->segment(2) == 'order' ||
                     request()->segment(2) == 'order_confirm' ||
                     request()->segment(2) == 'order_shipping' ||
                     request()->segment(2) == 'order_waiting' ||
                     request()->segment(2) == 'order_success' ||
                     request()->segment(2) == 'order_cancelled' ||
                     request()->segment(2) == 'order_return') class="active" @endif><a class="has-arrow" href="javascript:void(0)"
                     aria-expanded="false"><i class="nav-icon ti ti-calendar"></i><span class="nav-title">Đơn
                         hàng</span></a>
                 <ul aria-expanded="false">
                     <li class="{{ request()->segment(2) == 'order' ? 'active' : '' }}"> <a
                             href="{{ route('adminOrder') }}">Tất cả đơn hàng</a> </li>
                     <li class="{{ request()->segment(2) == 'order_confirm' ? 'active' : '' }}"> <a
                             href="{{ route('orderConfirm') }}">Chờ xác nhận</a> </li>
                     <li class="{{ request()->segment(2) == 'order_shipping' ? 'active' : '' }}"> <a
                             href='{{ route('orderShipping') }}'>Vận chuyển</a></li>
                     <li class="{{ request()->segment(2) == 'order_waiting' ? 'active' : '' }}"> <a
                             href='{{ route('orderWaiting') }}'>Chờ giao hàng</a></li>
                     <li class="{{ request()->segment(2) == 'order_success' ? 'active' : '' }}"> <a
                             href='{{ route('orderSuccess') }}'>Hoàn thành</a></li>
                     <li class="{{ request()->segment(2) == 'order_cancelled' ? 'active' : '' }}"> <a
                             href='{{ route('orderCanceled') }}'>Đã hủy</a></li>
                     <li class="{{ request()->segment(2) == 'order_return' ? 'active' : '' }}"> <a
                             href='{{ route('orderReturn') }}'>Hoàn trả</a></li>
                 </ul>
             </li>

         </ul>
     </div>
     <!-- end sidebar-nav -->
 </aside>

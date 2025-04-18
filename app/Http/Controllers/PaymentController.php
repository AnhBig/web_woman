<?php

namespace App\Http\Controllers;

// use App\Models\Color;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSize;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\ColorImage;
use App\Events\OrderUserSuccess;
use App\Mail\OrderUser;

use App\Mail\MailOrder;


class PaymentController extends Controller
{
    public function cart(Request $request)
    {
        return view('user.payment.cart');
    }


    public function addProductToCart(Request $request)
    {
        $product = Product::where('id', $request->product_id)->where('status', 1)->first();
        $total = $product->price;
        $size_id = 0;
        if (!empty($product)) {
            $size_id = $request->size_id;
            $getSize = ProductSize::find($size_id);

            $size_price = !empty($getSize->price) ? $getSize->price : 0;
            $total = $total + $size_price;
        } else {
            $size_id = 0;
        }

        $color_id = !empty($request->color_id) ? $request->color_id : 0;


        $name_color = ColorImage::where('id', $request->color_id)->first();
        $name_size = ProductSize::where('id', $request->size_id)->first();

        $unique_id = $product->id . '-' . $color_id . '-' . $size_id;

        $cartItem = Cart::get($unique_id);
        if ($cartItem) {
            Cart::update($unique_id, [
                'quantity' => [
                    'relative' => false,
                    'value' => $cartItem->quantity + $request->qty
                ]
            ]);
        } else {
            Cart::add([
                'id' => $unique_id,
                'name' => $product->title,
                'price' => $total,
                'quantity' => $request->qty,
                'attributes' => [
                    'product_id' => $product->id,
                    'imgColor' => $name_color->image_name,
                    'color_id' => $color_id,
                    'name_color' => $name_color->color_name,
                    'name_size' => $name_size->name,
                    'size_id' => $size_id,
                    'create_at' => time()
                ],
            ]);
        }


        return response()->json(
            [
                "success" => view("user.product.add_cart")->render(),
            ],
            200
        );
    }

    public function updateCart(Request $request)
    {
        if (!empty($request->id && !empty($request->quantity))) {
            Cart::update($request->id, [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ]
            ]);
        }
    }
    public function deleteCart(Request $request)
    {
        empty(!$request->id) ? Cart::remove($request->id) : Cart::remove($request->id);
    }

    public function checkOut()
    {
        $addressDefault = Address::where('user_id', Auth::user()->id)->where('type', 1)->first();
        $address = Address::where('user_id', Auth::user()->id)->orderBy('type', "desc")->get();
        return view('user.payment.checkout', compact('addressDefault', 'address'));
    }

    // address default
    public function checkOutAddressDefault(Request $request)
    {
        if (!empty($request->id)) {
            foreach (Address::where('user_id', Auth::user()->id)->get() as $address) {
                $address->type = 0;
                $address->save();
            }

            $address = Address::find($request->id);
            $address->type = 1;
            $address->save();

            $getAddress = Address::where("user_id", auth()->user()->id)->OrderBy("type", "desc")->OrderBy('id', 'desc')->get();


            $view = view("user.payment.list_address_checkout", [
                "address" => $getAddress
            ])->render();

            $addressDefault = Address::where('user_id', Auth::user()->id)->where('type', 1)->first();
            $viewAddressDefault = view("user.payment.address_default", [
                "addressDefault" => $addressDefault
            ])->render();

            return response()->json([
                'view' => $view,
                'viewAddressDefault' => $viewAddressDefault,
                'status' => 'success'
            ], 200);
        }
    }

    public function checkOutEditAddress(Request $request)
    {
        if (!empty($request->id)) {
            $address = Address::find($request->id);
            $view = view("user.acount.address.edit", [
                "address" => $address
            ])->render();

            return response()->json([
                'view' => $view,
                'status' => 'success'
            ], 200);
        }
    }

    public function checkOutUpdateAddress(Request $request)
    {
        $address = Address::find($request->id);
        $address->name = $request->name_address;
        $address->phone = $request->phone_address;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->ward = $request->ward;
        $address->home_address = $request->home_address;
        $address->save();

        $getAddress = Address::where('user_id', Auth::user()->id)->orderBy('type', 'desc')->orderBy('id', 'desc')->get();
        $view = view("user.payment.list_address_checkout", [
            "address" => $getAddress
        ])->render();

        $addressDefault = Address::where('user_id', Auth::user()->id)->where('type', 1)->first();
        $viewAddressDefault = view("user.payment.address_default", [
            "addressDefault" => $addressDefault
        ])->render();

        if ($addressDefault) {
            return response()->json([
                'view' => $view,
                'viewAddressDefault' => $viewAddressDefault,
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'view' => $view,
                'status' => 'success'
            ], 200);
        }
    }

    // new address
    public function checkOutNewAddress(Request $request)
    {
        $addressCount = Address::where('user_id', Auth::user()->id)->get();
        if (count($addressCount) > 0) {
            $address = new Address();
            $address->user_id = auth()->user()->id;
            $address->name = $request->name_address;
            $address->phone = $request->phone_address;
            $address->city = $request->city;
            $address->district = $request->district;
            $address->ward = $request->ward;
            $address->home_address = $request->home_address;
            $address->save();
        } else {
            $address = new Address();
            $address->user_id = auth()->user()->id;
            $address->name = $request->name_address;
            $address->phone = $request->phone_address;
            $address->city = $request->city;
            $address->district = $request->district;
            $address->ward = $request->ward;
            $address->home_address = $request->home_address;
            $address->type = 1;
            $address->save();
        }


        $getAddress = Address::where('user_id', Auth::user()->id)->orderBy('type', 'desc')->orderBy('id', 'desc')->get();

        $view = view("user.payment.list_address_checkout", [
            "address" => $getAddress
        ])->render();

        $addressDefault = Address::where('user_id', Auth::user()->id)->where('type', 1)->first();
        $viewAddressDefault = view("user.payment.address_default", [
            "addressDefault" => $addressDefault
        ])->render();

        if ($addressDefault) {
            return response()->json([
                'view' => $view,
                'viewAddressDefault' => $viewAddressDefault,
                'status' => 'success'
            ], 200);
        }

        return response()->json([
            'view' => $view,
            'status' => 'success'
        ], 200);
    }
    
    public function checkOutApplyVoucher(Request $request)
    {
        $discountCode = DiscountCode::checkDiscount($request->voucher);
        $total = Cart::getTotal();

        if (!empty($discountCode)) {
            $json['status'] = true;
            if ($discountCode->type == 'percent') {
                $json['deducted_amount'] = ($discountCode->percent_amount / 100) * $total;
                $json['newTotal'] = $total - $json['deducted_amount'];
                $json['message'] = "Đã sử dụng " . $discountCode->name;
            } else {
                $json['newTotal'] = $total - $discountCode->percent_amount;
                $json['deducted_amount'] = $total - $json['newTotal'];
                $json['message'] = "Đã sử dụng " . $discountCode->name;
            }
        } else {
            $json['status'] = false;
            $json['message'] = "Mã giảm giá không hợp lệ";
        }

        echo json_encode($json);
    }

    // place order
    public function placeOder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'payment_method' => 'required',
            'discount_code' => 'nullable',
            'shipping_id' => 'nullable',
            'note' => 'nullable',
        ], [
            'required' => 'Vui lòng nhập đầy đủ thông tin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $findAddress = Address::find($request->address_id);
        $merge_info_order = array_merge($request->all(), $findAddress->toArray());

        Session::put('info_order', $merge_info_order);
        Session::save();

        if ($request->payment_method == 'cash') {
            $total = Cart::getTotal();

            $newTotal = 0;
            $deducted_amount = 0;

            if (!empty($request->discount_code)) {
                $check_discountCosde = DiscountCode::checkDiscount($request->discount_code);
                if (!empty($check_discountCosde)) {
                    if ($check_discountCosde->type == 'percent') {
                        $deducted_amount = ($check_discountCosde->percent_amount / 100) * $total;
                        $newTotal = $total - $deducted_amount;
                    } else {
                        $newTotal = $total - $check_discountCosde->percent_amount;
                        $deducted_amount = $total - $newTotal;
                    }
                }
            } else {
                $newTotal = $total;
            }

            // for ($i = 0; $i <= 2; $i++) {
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->code_order = Str::upper(Str::random(10));
            $order->name = $findAddress->name;
            $order->phone = $findAddress->phone;
            $order->city = $findAddress->city;
            $order->district = $findAddress->district;
            $order->ward = $findAddress->ward;
            $order->home_address = $findAddress->home_address;
            $order->payment = $request->payment_method;
            $order->discount_code = $request->discount_code;
            $order->total_price = $newTotal;
            $order->total_amount = $deducted_amount;
            $order->note = $request->note;

            $order->save();
            $order_id = $order->id;

            foreach (Cart::getContent() as $item) {
                $order_item = new OrderItem();
                $order_item->order_id = $order_id;
                $order_item->product_id = $item->id;
                $order_item->quantity = $item->quantity;
                $order_item->price = $item->price;

                $order_item->size_name = $item->attributes->name_size;

                $size_id = $item->attributes->size_id;
                if (!empty($size_id)) {
                    $productSize = ProductSize::where('id', $size_id)->first();
                    $order_item->size_amount = $productSize->price;
                    $order_item->color_name = $item->attributes->name_color;
                }

                $order_item->total_price = $item->price;
                $order_item->save();
            }
            // }

            $user = auth()->user();
            $dataOrder = Cart::getContent();

            OrderUserSuccess::dispatch($user, $dataOrder, $order);

            Cart::clear();
            return view('user.thank.payment_success');
        } elseif ($request->payment_method == 'vnpay') {

            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('paymentVnpaySuccess');
            $vnp_TmnCode = "8ZDRBDI8"; //Mã website tại VNPAY 
            $vnp_HashSecret = "ZD3NR5W5IV5DT0NJ7I8ZYYGCMEHP9445"; //Chuỗi bí mật

            $vnp_TxnRef = Str::upper(Str::random(10));
            $vnp_OrderInfo = "Thanh toán hóa đơn";
            $vnp_OrderType = "TN SHOP";
            $vnp_Amount = Cart::getTotal() * 100;
            $vnp_Locale = "VN";
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            //Add Params of 2.0.1 Version

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            // var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;

            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url
            );
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
        } elseif ($request->payment_method == 'momo') {
            header('Content-type: text/html; charset=utf-8');
            function execPostRequest($url, $data)
            {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data)
                    )
                );
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                //execute post
                $result = curl_exec($ch);
                //close connection
                curl_close($ch);
                return $result;
            }

            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

            $orderInfo = "Thanh toán đơn hàng";
            $amount = Cart::getTotal();
            $orderId = Str::upper(Str::random(10));
            // $orderId = time() . "";
            $redirectUrl = route("paymentMomoSuccess");
            $ipnUrl = route("paymentMomoSuccess");
            $extraData = "";

            $requestId = time() . "";
            $requestType = "payWithATM";
            // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");

            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            $result = execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json

            // header('Location: ' . $jsonResult['payUrl']);
            return redirect($jsonResult['payUrl']);
        }
    }

    public function paymentVnpaySuccess()
    {
        if (isset($_GET["vnp_Amount"]) && $_GET['vnp_ResponseCode'] == '00') {
            $info_order = Session::get('info_order');

            $total = Cart::getTotal();

            $newTotal = 0;
            $deducted_amount = 0;
            if (!empty($info_order['discount_code'])) {
                $check_discountCosde = DiscountCode::checkDiscount($info_order['discount_code']);
                if (!empty($check_discountCosde)) {
                    if ($check_discountCosde->type == 'percent') {
                        $deducted_amount = ($check_discountCosde->percent_amount / 100) * $total;
                        $newTotal = $total - $deducted_amount;
                    } else {
                        $newTotal = $total - $check_discountCosde->percent_amount;
                        $deducted_amount = $total - $newTotal;
                    }
                }
            } else {
                $newTotal = $total;
            }

            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->code_order = Str::upper(Str::random(10));
            $order->name = $info_order['name'];
            $order->phone = $info_order['phone'];
            $order->city = $info_order['city'];
            $order->district = $info_order['district'];
            $order->ward = $info_order['ward'];
            $order->home_address = $info_order['home_address'];
            $order->payment = $info_order['payment_method'];
            $order->discount_code = $info_order['discount_code'];
            $order->total_price = $newTotal;
            $order->total_amount = $deducted_amount;
            ;
            $order->note = $info_order['note'];

            $order->save();
            $order_id = $order->id;

            foreach (Cart::getContent() as $item) {
                $order_item = new OrderItem();
                $order_item->order_id = $order_id;
                $order_item->product_id = $item->id;
                $order_item->quantity = $item->quantity;
                $order_item->price = $item->price;

                $order_item->size_name = $item->attributes->name_size;

                $size_id = $item->attributes->size_id;
                if (!empty($size_id)) {
                    $productSize = ProductSize::where('id', $size_id)->first();
                    $order_item->size_amount = $productSize->price;
                    $order_item->color_name = $item->attributes->name_color;
                }

                $order_item->total_price = $item->price;
                $order_item->save();
            }

            $user = auth()->user();
            $dataOrder = Cart::getContent();

            OrderUserSuccess::dispatch($user, $dataOrder, $order);

            Cart::clear();
            return view('user.thank.payment_success');
        } else {
            return redirect()->route('checkOut')->with('error', 'Đã hủy thanh toán');
        }
    }

    public function paymentMomoSuccess()
    {
        if (isset($_GET["message"]) && $_GET['resultCode'] == '0') {
            $info_order = Session::get('info_order');
            $total = Cart::getTotal();

            $newTotal = 0;
            $deducted_amount = 0;

            if (!empty($info_order['discount_code'])) {
                $check_discountCosde = DiscountCode::checkDiscount($info_order['discount_code']);
                if (!empty($check_discountCosde)) {
                    if ($check_discountCosde->type == 'percent') {
                        $deducted_amount = ($check_discountCosde->percent_amount / 100) * $total;
                        $newTotal = $total - $deducted_amount;
                    } else {
                        $newTotal = $total - $check_discountCosde->percent_amount;
                        $deducted_amount = $total - $newTotal;
                    }
                }
            } else {
                $newTotal = $total;
            }

            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->code_order = Str::upper(Str::random(10));
            $order->name = $info_order['name'];
            $order->phone = $info_order['phone'];
            $order->city = $info_order['city'];
            $order->district = $info_order['district'];
            $order->ward = $info_order['ward'];
            $order->home_address = $info_order['home_address'];
            $order->payment = $info_order['payment_method'];
            $order->discount_code = $info_order['discount_code'];
            $order->total_price = $newTotal;
            $order->total_amount = $deducted_amount;
            ;
            $order->note = $info_order['note'];

            $order->save();
            $order_id = $order->id;

            foreach (Cart::getContent() as $item) {
                $order_item = new OrderItem();
                $order_item->order_id = $order_id;
                $order_item->product_id = $item->id;
                $order_item->quantity = $item->quantity;
                $order_item->price = $item->price;

                $order_item->size_name = $item->attributes->name_size;

                $size_id = $item->attributes->size_id;
                if (!empty($size_id)) {
                    $productSize = ProductSize::where('id', $size_id)->first();
                    $order_item->size_amount = $productSize->price;
                    $order_item->color_name = $item->attributes->name_color;
                }

                $order_item->total_price = $item->price;
                $order_item->save();
            }

            $user = auth()->user();
            $dataOrder = Cart::getContent();

            OrderUserSuccess::dispatch($user, $dataOrder, $order);

            Cart::clear();
            return view('user.thank.payment_success');
        } else {
            return redirect()->route('checkOut')->with('error', 'Đã hủy thanh toán');
        }
    }
}

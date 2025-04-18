<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Mail;
use App\Events\RegisterMaillSuccess;
use App\Events\RessetPassWordSuccess;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

use Exception;

class AuthController extends Controller
{
    public function login_admin()
    {

        if (!empty(Auth::check() && Auth::user()->is_admin == 1)) {
            return redirect('admin/dashboard');
        }
        return view('admin.auth.login');
    }

    public function auth_login_admin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => 1, 'status' => 1], $remember)) {
            return redirect('admin/dashboard')->with('success', 'Đăng nhập thành công');
        } else {
            return back()->with('error', 'Email hoặc mật khẩu không đúng !');
        }
    }
    public function logout_admin()
    {
        Auth::logout();
        return redirect('admin');
    }


    // user
    public function user_register(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'register_password' => [
                    'required',
                    'string',
                    'min:8', // Độ dài tối thiểu 8 ký tự
                    'regex:/[a-z]/', // Phải có ít nhất một chữ cái viết thường
                    'regex:/[A-Z]/', // Phải có ít nhất một chữ cái viết hoa
                    'regex:/[0-9]/', // Phải có ít nhất một chữ số
                    'regex:/[@$!%*#?&]/' // Phải có ít nhất một ký tự đặc biệt
                ],
                'register_email' => 'required|email|unique:users,email',
            ],
            [
                'register_email.required' => 'Vui lòng nhập email !',
                'register_email.email' => 'Vui lòng nhập đúng định dạng email !',
                'register_email.unique' => 'Email đã có người đăng ký !',
                'register_password.required' => 'Vui lòng nhập mật khẩu !',
                'register_password.min' => 'Mật khẩu phải lớn hơn 8 kí tự !',
                'register_password.regex' => 'Mật khẩu phải có một chữ cái viết thường, viết hoa và kí tự đặc biệt !',
            ]
        );

        if (!$validator->fails()) {
            $user = new User();

            $name = Str::random(10);
            $user->name = $name;
            $user->email = $request->register_email;
            $user->password = Hash::make($request->register_password);
            $user->save();

            RegisterMaillSuccess::dispatch($user);

            return response()->json(
                [
                    "status" => true,
                    "message" => "Đăng ký thành công"
                ]
            );
        } else {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Đăng ký không thành công",
                    "errors" => $validator->errors()
                ]
            );
        }
    }


    public function user_signin(Request $request)
    {
        // return response()->json($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'signin_email' => 'required|email',
                'signin_password' => [
                    'required',
                    'string',
                    'min:8', // Độ dài tối thiểu 8 ký tự
                    'regex:/[a-z]/', // Phải có ít nhất một chữ cái viết thường
                    'regex:/[A-Z]/', // Phải có ít nhất một chữ cái viết hoa
                    'regex:/[0-9]/', // Phải có ít nhất một chữ số
                    'regex:/[@$!%*#?&]/' // Phải có ít nhất một ký tự đặc biệt
                ],
            ],
            [
                'signin_email.required' => 'Vui lòng nhập email!',
                'signin_email.email' => 'Vui lòng nhập đúng định dạng email!',
                'signin_password.required' => 'Vui lòng nhập mật khẩu!',
                'signin_password.min' => 'Mật khẩu phải có độ dài tối thiểu 8 ký tự ! ',
                'signin_password.regex' => 'Mật khẩu phải bao gồm ít nhất một chữ cái viết thường, một chữ cái viết hoa, một chữ số và một ký tự đặc biệt!',
            ]
        );

        $remember = $request->has('remember') ? true : false;
        $checkAuth = Auth::attempt([
            'email' => $request->signin_email,
            'password' => $request->signin_password,
            'status' => 1
        ], $remember);

        if (!$validator->fails() && $checkAuth) {
            return response()->json(
                [
                    "status" => true,
                    "message" => "Đăng nhập thành công !"
                ]
            );
            // if (!empty(Auth::user()->email_verified_at)) {
            // } else {
            //     return response()->json(
            //         [
            //             "status" => false,
            //             "message" => "Vui lòng xác thực email !"
            //         ]
            //     );
            // }
        } else {
            return response()->json(
                [
                    "status" => false,
                    "message" => "Email hoặc mật khẩu không đúng !",
                    "errors" => $validator->errors(),

                ]
            );
        }
    }

    public function user_logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    // verify email resgister
    public function activate_email($id)
    {
        $id = base64_decode($id);
        $user = User::find($id);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect('dang-nhap')->with('success', 'Xác thức email thành công');
    }

    public function user_auth()
    {

        return view('user.auth.user_auth');
    }

    public function user_forgot_password()
    {
        return view('user.auth.forgot');
    }

    // verify email forgot password
    public function auth_verify_email(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'Vui lòng nhập email !',
                'email.email' => 'Vui lòng nhập đúng định dạng email !',
            ]
        );

        if (!$validator->fails()) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $tokenRandom = Str::random(10);
                $token = Str::upper($tokenRandom);
                $user->remember_token = $token;
                $user->save();

                Session::put('email', $user->email);
                RessetPassWordSuccess::dispatch($user);
                return response()->json(
                    [
                        "status" => true,
                        "router" => route('verify_success')
                    ]
                );
            } else {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Email chưa đăng kí tài khoản !",
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    "status" => false,
                    "errors" => $validator->errors(),
                ]
            );
        }
    }

    public function verify_success()
    {
        return view('user.thank.resset_password');
    }

    public function verify_token($token)
    {
        $user = User::where('remember_token', $token)->where('status', 1)->first();

        if ($user) {
            return view('user.auth.new_password', compact('token'));
        } else {
            abort(404);
        }
    }

    public function auth_update_password(Request $request)
    {
        if (!empty($request->new_password) && !empty($request->token)) {
            $user = User::where('remember_token', $request->token)->where('status', 1)->first();
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json([
                "status" => true
            ]);
        }
    }

    // login gg
    public function redirectToGoogle()
    {
        Session::put('previousUrl', url()->previous());
        Session::save();
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $previousUrl = Session::pull('previousUrl', route('home'));
            // dd($previousUrl);

            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) { // Nếu đã có tài khoản
                $finduser->name = $user->name;
                $finduser->email = $user->email;
                $finduser->avatar = $user->avatar;
                $finduser->save();

                Auth::login($finduser);
            } else {
                $newUser = new User();
                $newUser->name = $user->name;
                $newUser->email = $user->email;
                $newUser->avatar = $user->avatar;
                $newUser->google_id = $user->id;
                $newUser->password = encrypt('123456789');
                $newUser->save();

                Auth::login($newUser);
            }

            // return redirect()->back();

            if ($previousUrl == route('user_auth')) {
                return redirect()->route('home');
            }

            return redirect()->intended($previousUrl);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}

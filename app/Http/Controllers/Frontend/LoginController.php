<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\ConfirmOtpRequest;
use App\Library\Common;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\Mail as FacadesMail;
use App\Models\Code;
use App\Models\Customer;
use App\Models\User;

class LoginController extends Controller
{

    protected $expireTime;

    public function __construct($expireTime = 5)
    {
        $this->expireTime = $expireTime;
    }

    public function login()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('frontend.create_ticket');
        }
        return view('frontend_v2.general.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $cusData = [
            'email' => $request->username,
            'password' => $request->input('password')
        ];
        $remember = $request->remember ?? false;

        if (Auth::guard('customer')->attempt($cusData, $remember)) {
            session()->flash('success', __('general.welcomBack'));
            return redirect()->route('frontend.create_ticket');
        } else {
            session()->flash('error', __('general.wrongCredentials'));
            return back();
        }
    }



    public function register()
    {
        echo '<h3>Die is Called - register frontend</h3>';
        die;
        return view('frontend_v2.pages.register');
    }

    public function forgotPassword()
    {
        return view('frontend_v2.general.forgot-pass');
    }

    public function doForgot(Request $request)
    {
        $common = new Common();

        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ]);

        $user = Customer::where('email', $request->email)->first();

        // Tạo OTP và lưu vào database
        $otp = $common->createCode(0, 'resetpass', $user);

        // Send OTP to mail
        \Mail::to($user->email)->send(new \App\Mail\SendOtp(trans('general.otpSubject'), $otp));

        return view('frontend_v2.general.otp-verify', ['email' => $request->email]);
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->input('email');
        return view('frontend_v2.general.otp-verify', compact('email'));
    }

    public function otpVerify(Request $request)
    {
        try {
            $common = new Common();
            $email = $request->input('email');
            $code = implode('', $request->input('otp'));
            $code = intval($code);
            $type = 'resetpass';
            $codeData = $common->checkCode(0, $type, $code, $email);

            if ($codeData) {
                $createAt = $codeData->created_at;
                $expireTime = $createAt->addMinute($this->expireTime);

                if ($expireTime < now()) {
                    $codeData->delete();
                    session()->flash('error', __('general.otp_expired'));
                    return redirect()->route('frontend.show_otp', compact('email'));
                }

                $codeData->delete();
                return redirect()->route('frontend.reset_password', compact('email'));
            } else {
                session()->flash('error', __('general.otp_not_match'));
                return view('frontend_v2.general.otp-verify', compact('email'));
            }
        } catch (\Throwable $th) {
            // Log::error($th);
            return response()->json([
                "status" => 0,
                "msg" => trans('general.error') . $th->getMessage(),
            ], 400);
        }
    }

    public function showCheckPassForm(Request $request)
    {
        $email = $request->input('email');
        return view('frontend_v2.general.reset-pass', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'rePassword' => 'required|same:password',
        ], [
            'password.required' => trans('validation.required', ['attribute' => trans('general.password')]),
            'password.min' => trans('validation.min.string', ['attribute' => trans('general.password'), 'min' => 8]),
            'rePassword.required' => trans('validation.required', ['attribute' => trans('general.rePassword')]),
            'rePassword.same' => trans('validation.same', ['attribute' => trans('general.rePassword')]),
        ]);

        $email = $request->input('email');
        $newPassword = $request->input('password');
        $rePassword = $request->input('rePassword');

        if ($newPassword !== $rePassword) {
            return redirect()->route('frontend.reset_password')->with('email', $email);
        } else {
            $customer = Customer::where('email', $email)->first();
            $customer->password = bcrypt($newPassword);
            $customer->save();
        }
        Auth::guard('customer')->login($customer);
        return redirect()->route('frontend.create_ticket');
    }



    public function logout()
    {
        Auth::guard('customer')->logout();
        session()->flush();
        return redirect()->route('frontend.home');
    }
}

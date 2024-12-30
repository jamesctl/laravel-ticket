<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use App\Http\Requests\Admin\ConfirmOtpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Library\Common;
use App\Models\MailTemplate;
use App\Models\User;
use App\Models\Code;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller {
    
    /**
     * @var Object MailService
     */
    // private $__mailService;

    /**
     * @param MailService $mailService
     * 
     */
    public function __construct()
    {
        // $this->__mailService = $mailService;
    }

    public function index() {
    }

    public function login() {
        if (Auth::user()) {
            if (Auth::user()->is_admin == 'yes') {
                return Redirect::to('admin');
            }
        }
        return view('admin.login');
    }

    public function doLogin(LoginRequest $request) {
        $userData = [
            'password' => $request->input('password'),
            'is_admin'  => 'yes',
            'status'   => 'active',
            'email' => $request->username
        ];
        $remember = $request->remember ?? false;


        if (Auth::attempt($userData, $remember)) {
            session()->flash('success', __('general.welcomBack'));
            return redirect()->intended(route('admin.dashboard'));
        } else {
            session()->flash('error', __('general.wrongCredentials'));
            return back();
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/authentication');
    }

    public function register() {
        return view('admin.register');
    }

    public function doRegister(RegisterRequest $request) {
        $common = new Common();
        $userData['password'] = bcrypt($request->password);
        $userData['description'] = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            // 'password' => $userData['password'],
            'password' => $request->password,
            'gender' => $request->gender,
        ];
        $userData['email'] = $request->email;
        $userData['password'] = $request->password;

        // Send Mail
        $code = $common->createCode(0, 'register', $userData);
        $template = MailTemplate::getMailTemplate('when_sending_otp_during_account_registration');
        $title = @$template['title'] ?? '';
        $content = @$template['content'] ?? '';
        $htmlContent = strtr($content, [
            '{{confirmationCode}}' => $code,
        ]);

        $mailConfig = json_decode(app()->get('emailSetting')->setting_value); 
        FacadesMail::send([], [], function ($message) use ($request, $title, $htmlContent, $mailConfig) {
            $message->to($request->email)->subject($title);
            $message->html($htmlContent, 'text/html');
            $message->from($mailConfig->from_address, $mailConfig->from_name);
        });

        return view('admin.otp_register', ['email' => $request->email]);
    }

    public function otpRegister(ConfirmOtpRequest $request) {
        try {
            $common = new common;
            $code = $request->input('otp');
            
            $code = intval($code);
            $email = $request->input('email');
            $type = 'register';
            $checkCode = $common->checkCode(0, $type, $code, $email);

            if ($checkCode) {
                $user = new User;
                $codeInfo = new Code;
                $codeInfo = $codeInfo->where('email', $email)->where('type', $type)
                                    ->where('code', $code)->orderBy('id', 'DESC')->first();
                $description = unserialize($codeInfo->description);

                // Save DB
                $user->name = $description['name'];
                $user->email = $email;
                $user->phone = $description['phone'];
                $user->gender = $description['gender'];
                $user->password = bcrypt($description['password']);
                $user->save();

                //login account
                $remember = true;
                $userdata = array(
                    'email' => strtolower($email),
                    'password' => $description['password'],
                );

                $codeInfo = new Code;
                $codeInfo->where('email', $email)->delete();

                if (Auth::attempt($userdata, $remember)) {
                    session()->flash('success', __('general.welcomBack'));
                    return redirect()->intended(route('admin.dashboard'));
                } else {
                    session()->flash('error', __('general.wrongCredentials'));
                    return back();
                }
            } else {
                session()->flash('error', __('general.otp_not_match'));
                return back();
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                "status" => 0,
                "msg" => trans('general.error') . $th->getMessage(),
            ], 400);
        }

    }

}

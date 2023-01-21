<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\LogInfo;
use App\Models\User;
use App\Notifications\Admin\TwoFactorCode;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class   TwoFactorController extends Controller
{

    protected $screen;

    protected $count = 1;

    use ThrottlesLogins;

    public function __construct()
    {
        //ログインしたこと、認証コード発行された後、
        $this->middleware(['auth:admin', 'twofactor']);
        $this->middleware('throttle:5,1')->only('store', 'resend');
        $this->screen = 'Admin/Auth/TwoFactor';
    }

    /**
     * 画面初期表示
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $auth = Auth::guard('admin');
        try {
            if ($auth->check()) {
                if ($auth->user()->two_factor_code) {
                    return inertia($this->screen);
                } else {
                    //認証が正常になった後、
                    return redirect('admin/dashboard');
                }
            }
        } catch (\Exception $exception) {
            //ログ記録
            $model = new LogInfo();
            $model->createLog(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, $this->screen);
            //ログアウト
            Auth::guard('admin')->logout();
            //認証コードがnullにする
            $auth->user()->resetTwoFactorCode();
            //エラーメッセージ発生
            return redirect('admin/login')->withErrors(Lang::get('messages.errors_system'));
        }
    }

    /**
     * 認証コードを確認する
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //再確認、バリデート
        $request->validate([
            'two_factor_code' => 'integer|required'
        ]);

        $user = auth()->user();
        try {
            //カウント
            $count = $request->session()->get('count_store');
            //通信認証コードとDBのコードを比べる
            if ($request->input('two_factor_code') == $user->two_factor_code) {
                //カラムは空白に再現する
                $user->resetTwoFactorCode();
                //Luc nay two_factor_code da la null cho nen middleware\TwoFactor next()
                return redirect()->route('admin.dashboard');
            }
            //失敗：3回
            if($count == 2) {
                //ログアウト
                auth()->logout();
                //resendカウントを削除する
                $request->session()->forget('count_store');
                //resendカウントを記録する
                return redirect()->route('admin.login')->withErrors(Lang::get('auth.throttle'));
            }
            $request->session()->put('count_store', $count + 1);
            //エラーメッセージ発生
            return redirect()->back()->withErrors(Lang::get('messages.errors_otp_not_match'));
        } catch (\Exception $exception) {
            //ログ記録
            $model = new LogInfo();
            $model->createLog(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, $this->screen);
            //ログアウト
            Auth::guard('admin')->logout();
            //認証コードがnullにする
            $user->resetTwoFactorCode();
            //エラーメッセージ発生
            return redirect('admin/login')->withErrors(Lang::get('messages.errors_system'));
        }

    }

    /**
     * 認証コードを再発行する
     * @return mixed
     */
    public function resend(Request $request)
    {
        //Models/User.phpを取得する
        $user = auth()->user();
        try {
            //カウント
            $count = $request->session()->get('count_resend');
            //認証コードを再発
            $user->generateTwoFactorCode();
            //認証コードを送信する
            $user->notify(new TwoFactorCode());
            //失敗：3回
            if($count == 2) {
                //ログアウト
                auth()->logout();
                //resendカウントを削除する
                $request->session()->forget('count_resend');
                return redirect()->route('admin.login')->withErrors(Lang::get('auth.throttle'));
            }
            //resendカウントを記録する
            $request->session()->put('count_resend', $count + 1);
            //再発行メッセージ
            return redirect()->back()->withSuccess(Lang::get('messages.errors_otp_send_again'));
        } catch (\Exception $exception) {
            //ログ記録
            $model = new LogInfo();
            $model->createLog(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, $this->screen);
            //ログアウト
            Auth::guard('admin')->logout();
            //認証コードがnullにする
            $user->resetTwoFactorCode();
            //エラーメッセージ発生
            return redirect('admin/login')->withErrors(Lang::get('messages.errors_system'));
        }
    }
}

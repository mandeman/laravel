<?php namespace App\Http\Controllers;

use App\User, App\Admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Captcha, Hash, Request, Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * 登录页面显示
     */
    public function login()
    {
        return view('auth.login');
    }

    public function loginTo()
    {
        $rules = [
            'captcha' => 'required|captcha',
        ];
        $validator = Validator::make(Request::all(), $rules);
        if ($validator->fails()) {
            return failure('验证码错误');
        }
        if (Auth::attempt(['username' => Request::input('username'), 'password' => Request::input('passwd')])) {
            $user = Auth::user();
            $user->last_sign_in_ip = ip2long(Request::getClientIp());
            $user->last_sign_in_at = Carbon::now();
            $user->sign_in_cnt += 1;
            $user->user_tokens = md5($user->username);
            $user->save();
            return success('登录成功');
        }
        
        return failure('用户名或密码错误');
    }
    /**
     * 获取验证码
     */
    public function getCode()
    {
        return Captcha::src();
    }

    public function register(){
        $user = User::saveData([
            'username'  => 'admin',
            'password'  => Hash::make('123456'),
            'nickname'  => '赵四',
            'category'  => 1,
            'type'      => 1,
            'ancestry_depth' => 0,
            'parent_id' => 0
        ]);

        $admin = [
            'username' => 'admin',
            'password'  => Hash::make('123456'),
            'name'      => 'admin',
            'status'    => 0,
            'user_id'   => $user->id
        ];

        $a = Admin::saveData($admin);

        if ($a)
            return 1;
        else
            return 0;
    }
}

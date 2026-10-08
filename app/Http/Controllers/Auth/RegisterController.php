<?php

namespace App\Http\Controllers\Auth;

use App\Events\Registered;
use App\Http\Controllers\Controller;
use App\Methods\ReCaptchaValidation;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::USER;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new admin notification
     *
     * @return // save data
     */
    public function createAdminNotify($user)
    {
        $title = $user->username . ' ' . admin_trans('has registered');
        $image = asset($user->avatar);
        $link = route('admin.members.users.edit', $user->id);
        return adminNotify($title, $image, $link);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        return theme_view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $indisposable = settings('actions')->disposable_emails_status
        ? ['required', 'string', 'email', 'indisposable', 'max:100', 'unique:users', 'block_patterns']
        : ['required', 'string', 'email', 'max:100', 'unique:users', 'block_patterns'];
        $rules = [
            'username' => ['required', 'string', 'alpha_dash', 'min:5', 'max:50', 'unique:users', 'block_patterns'],
            'email' => $indisposable,
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['sometimes', 'required'],
        ];
        $captchaValidationRules = ReCaptchaValidation::validate();
        return Validator::make($data, array_merge($rules, $captchaValidationRules));
    }

    /**
     * Before register a new user
     *
     * @return //redirect
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        $referrer = null;
        if ($request->hasCookie('_ref')) {
            $referrer = User::where('username', $request->cookie('_ref'))->first();
        }
        event(new Registered($user, $referrer));
        $this->guard()->login($user);
        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $username = strtolower($data['username']);
        $avatar = 'images/avatars/default.png';
        $user = User::create([
            'name' => $username,
            'username' => $username,
            'email' => $data['email'],
            'downloads_earnings' => settings('earnings')->bonus->users,
            'avatar' => $avatar,
            'password' => Hash::make($data['password']),
        ]);
        if ($user) {
            $this->createAdminNotify($user);
            $user->setLog();
        }
        return $user;
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Userclient;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, User $user)
{
    if ($user->hasRole('client')) {
        return redirect('/maps');
    } elseif ($user->status) {
        return redirect()->intended($this->redirectTo);
    } else {
        $this->guard()->logout();
        return redirect()
                    ->route('login')
                    ->with(['flashMsg' => ['msg' => 'Your account is deactivated.', 'type' => 'danger']]);
    }
}

// public function login(Request $request)
// {
//     $credentials = $request->only('email', 'password');

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();

//         if ($user && $user->hasRole('client')) {
//             return response()->json(['redirect' => '/maps', 'name' => $user->name]);
//         } else {
//             return response()->json(['error' => 'you don\'t have access in this app.']);
//         }
//     } else {
//         return response()->json(['error' => 'email or password is incorrect.']);
//     }
// }


public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user instanceof Userclient ) {
            return response()->json(['redirect' => '/maps', 'name' => $user->name]);
        } else {
            return response()->json(['error' => 'You don\'t have access to this app.']);
        }
    } else {
        return response()->json(['error' => 'Email or password is incorrect.']);
    }
}



}

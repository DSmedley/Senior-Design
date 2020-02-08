<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class AdminLoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct(){
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm(){
        return view('auth.admin-login');
    }

/*    public function login(Request $request){
        //Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        //Attempt to log the user in
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => '1', 'blocked' => '0'], $request->remember)){
            //If successful, then redirect to their intended location
            return redirect()->intended(route('admin.dashboard'));
        }
        //If unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email'. 'remember'));
    }*/

    public function login(Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        //Check if email and password match
        //Check if the user is an Admin
        //Check if the user is banned or not
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => '1', 'blocked' => '0'], $request->remember)){
            //If successful, then redirect to their intended location
            return redirect()->intended(route('admin.dashboard'));
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(){
        //logout of only the admin account
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}

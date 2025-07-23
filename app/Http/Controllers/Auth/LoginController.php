<?php
namespace App\Http\Controllers\Auth;

use Adldap\Auth\BindException;
use Adldap\Laravel\Facades\Adldap;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    // public function username()
    // {
    //     return 'emp_id';
    // }

    public function login(Request $request)
    {
        // Validate email and password
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            // Search for user in LDAP
            $ldapUser = Adldap::search()->where('mail', $credentials['email'])->first();

            if ($ldapUser) {
                // Authenticate against LDAP
                if (Adldap::auth()->attempt($ldapUser->getDn(), $credentials['password'])) {
                    return $this->handleLocalUser($ldapUser, $credentials['password']);
                }

                return back()->withErrors(['email' => 'Invalid credentials. Please try again.'])->withInput();
            }
        } catch (BindException $e) {
            // LDAP is down — fallback to local DB
            return $this->fallbackToLocalAuth($credentials);
        }

        return back()->withErrors(['email' => 'User not found in the directory. Please check your email and try again.'])->withInput();
    }

    // Handle local user sync and login
    private function handleLocalUser($ldapUser, $password)
    {
        $localUser = User::where('email', $ldapUser->getEmail())->first();

        if (! $localUser) {
            return back()->withErrors(['email' => 'Access denied. You are not authorized to use this system.']);
        }

        // Sync fullname if changed
        $newFullname = $ldapUser->getCommonName();
        if ($localUser->fullname !== $newFullname) {
            $localUser->update(['name' => $newFullname]);
        }

        // Sync password if different and password sync is enabled
        if (env('LDAP_PASSWORD_SYNC') && ! Hash::check($password, $localUser->password)) {
            $localUser->update(['password' => Hash::make($password)]);
        }

        // Log the user in
        Auth::login($localUser);
        return redirect()->intended('home');
    }

    // Fallback to local database authentication
    private function fallbackToLocalAuth($credentials)
    {
        $localUser = User::where('email', $credentials['email'])->first();

        if ($localUser && Hash::check($credentials['password'], $localUser->password)) {
            Auth::login($localUser);
            return redirect()->intended('home');
        }

        return back()->withErrors(['email' => 'Invalid credentials or directory service unavailable. Please try again later.'])->withInput();
    }

    // protected function authenticated(Request $request, $user)
    // {
    //     $user->generateTwoFactorCode();

    //     // Notification::send($user, new TwoFactorCode());
    //     // Notification::route('mail', $request['email'])->notify(new TwoFactorCode($user->two_factor_code));
    // }

    // public function logout()
    // {
    //     $is_logged_in = MsGraphToken::query()
    //         ->where('user_id', Auth::user()->id)
    //         ->delete();

    //     if($is_logged_in)
    //     {
    //         Auth::logout();
    //         Session()->flush();

    //         return redirect('login');
    //     }
    // }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        $this->middleware('auth')->only('logout');
    }

    /**
     * The user has been logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect('/login'); // Redirige al usuario a la página de login
    }

    // protected function sendFailedLoginResponse(Request $request)
    // {
    //     // Si la solicitud es Ajax (para el toastr)
    //     if ($request->expectsJson()) {
    //         return response()->json(['error' => 'Credenciales incorrectas'], 422);
    //     }

    //     // Mensaje en sesión para Toastr
    //     return redirect()->back()
    //         ->withInput($request->only('email', 'remember'))
    //         ->with('error', 'Las credenciales ingresadas son incorrectas.');
    // }


    // protected function sendFailedLoginResponse(Request $request)
    // {
    //     throw ValidationException::withMessages([
    //         'error' => ['Las credenciales proporcionadas son incorrectas.'],
    //     ]);
    // }

}

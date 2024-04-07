<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

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
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            // Récupérer l'adresse e-mail de l'utilisateur
            $email = $request->email;

            // Récupérer l'URL de réinitialisation du mot de passe
            $resetPasswordUrl = url('/reset-password');

            // Envoyer l'e-mail de réinitialisation de mot de passe
            Mail::send('emails.reset_password', ['resetPasswordUrl' => $resetPasswordUrl], function ($message) use ($email) {
                $message->to($email)->subject('Réinitialisation de mot de passe');
            });

            return redirect($this->redirectPath())->with('status', trans($response));
        } else {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => trans($response)]);
        }
    }
}

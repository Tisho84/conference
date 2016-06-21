<?php

namespace App\Http\Controllers\Auth;

use App\Classes\Template;
use App\Department;
use App\EmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ConferenceBaseController;
use App\User;
use Carbon\Carbon;

class PasswordController extends ConferenceBaseController// implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /*
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function postEmail(Request $request, TokenRepositoryInterface $token)
    {
        $department = $this->getDepartment();
        $this->validate($request, ['email' => 'required|email|exists:users,email,department_id,' . $department->id]);

        $template = new Template();
        $user = User::where('email', $request->get('email'))
            ->where('department_id', $department->id)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'error');
        }

        $settings = $user->department->settings()->key('email_password_reset');
        if (!isset($settings->value) || !$settings->value) {
            return redirect()->back()->with('error', 'no-template');
        }

        $emailTemplate = EmailTemplate::findOrFail($settings->value);
        $emailTemplate->body = $template->parser($emailTemplate->body, [
            'name' => $user->name,
            'expire' => Carbon::now()->addMinutes(config('auth.password.expire'))->format('d.m.Y H:i'),
            'link' => route('department::auth::reset_token', $user->department->keyword) . '/' . $token->create($user)
        ]);

        Mail::send('layouts.partials.email', ['body' => $emailTemplate->body], function ($message) use ($emailTemplate, $user) {
            $message->subject($emailTemplate->subject);
            $message->to($user->email);
        });

        return redirect()->back()->with('success', 'email-send');
    }

    public function getReset(Department $department, $token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('auth.reset')->with('token', $token);
    }

    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
        $credentials['department_id'] = $this->getDepartment()->id;

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect($this->redirectPath())->with('success', 'password-changed');

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

    public function redirectPath()
    {
        return route('department::index', [$this->getDepartment()->keyword]);
    }


}

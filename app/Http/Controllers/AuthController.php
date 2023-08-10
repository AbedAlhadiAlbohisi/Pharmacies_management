<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    //

    public function showLoginView(Request $request)
    {
        $request->merge(['guard' => $request->guard]);
        $validator = Validator($request->all(), [
            'guard' => 'required|string|in:admin,user,pharmacist'
        ]);
        session()->put('guard', $request->input('guard'));
        if (!$validator->fails()) {
            return response()->view('cms.auth.login', [
                'guard' => $request->input('guard'),
            ]);
        } else {
            return abort(404, 'Not Found');
        }
    }

    public function login(Request $request)
    {
        $validator = validator([
            'email' => 'required|email',
            'password' => 'required|string|min:3',
            'remember' => 'required|boolean'
        ]);
        $guard = session()->get('guard');

        if (!$validator->fails()) {
            $crednrtials = [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];
            if (Auth::guard($guard)->attempt($crednrtials, $request->input('remember'))) {
                $user = auth($guard)->user();

                if (!$user->blocked) {
                    return response()->json(
                        [
                            'message' => __('cms.sucess_login')
                        ],
                        Response::HTTP_OK
                    );
                } else {
                    return response()->json(
                        [
                            'message' => 'تم حظر الحساب يرجى التواصل مع الدعم'
                        ],
                        Response::HTTP_BAD_REQUEST
                    );
                }
            } else {
                return response()->json(
                    [
                        'message' => __('cms.login_failed')
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }


    public function logout(Request $request)
    {
        $guard = session('guard');

        $user = auth($guard)->user();
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        return redirect()->route('auth.login', $guard);
    }


    public function showForgotpassword($guard)
    {
        return response()->view('auth.forgot', ['guard' => $guard]);
    }


    public function sendRestLink(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => 'required|email',
            'guard' => 'required|in:admin,user,pharmacist|string',

        ]);
        if (!$validator->fails()) {
            if ($request->get('guard') == 'admin') {
                $email =  Admin::where('email', $request->get('email'))->first();
                $broker = 'admins';
            } else if ($request->get('guard') == 'user') {

                $email =  User::where('email', $request->get('email'))->first();
                $broker = 'user';
            } else if ($request->get('guard') == 'pharmacist') {

                $email =  Pharmacist::where('email', $request->get('email'))->first();
                $broker = 'pharmacist';
            }

            if (!is_null($email)) {
                $status = Password::broker($broker)->sendResetLink(
                    $request->only('email')
                );

                return $status === Password::RESET_LINK_SENT
                    ? response()->json(['message' => __($status)], Response::HTTP_OK)
                    : response()->json(['message' => __($status)], Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json(['message' => 'البريد الإلكتروني غير موجود'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(
                ["message" => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function shoewResetPassword($guard, $token)
    {

        $validator = Validator(['guard' => $guard], [
            'guard' => 'required|in:admin,user,pharmacist|string',

        ]);
        if (!$validator->fails()) {
            return response()->view('auth.reset', ['token' => $token, 'guard' => $guard]);
        } else {
            abort(Response::HTTP_FORBIDDEN);
        }
    }

    public function resetPassword(Request $request)
    {
        //
        $validator = validator($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
            'guard' => 'required|in:admin,user,pharmacist|string',

        ]);
        if (!$validator->fails()) {
            if ($request->get('guard') == 'admin') {
                $broker = 'admins';
            } else if ($request->get('guard') == 'employee') {
                $broker = 'employees';
            } else {
                $broker = 'reformers';
            }
            $status = Password::broker($broker)->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
                    $user->save();
                    event(new PasswordReset($user));
                }
            );

            return $status === Password::PASSWORD_RESET
                ? response()->json(['message' => __($status)], Response::HTTP_OK)
                : response()->json(['message' => __($status)], Response::HTTP_BAD_REQUEST);

            // $status = Password::reset(
            //     $request->only(
            //         'email',
            //         'token',
            //         'password',
            //         'password_confirmation'
            //     ),
            //     function ($user, $password) {
            //         $user->password = Hash::make($password);
            //         $user->save();
            //     }
            // );
            // return response()->json(
            //     ['message' => __($status)],
            //     $status === Password::PASSWORD_RESET
            //         ? Response::HTTP_OK
            //         : Response::HTTP_BAD_REQUEST
            // );
        } else {
            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }



    public function updatePassword(Request $request)
    {
        $guard = session('guard');
        $guard = auth($guard)->check() ? $guard : null;
        $validator = validator($request->all(), [
            'password' => 'required|current_password:' . $guard,
            'new_password' =>  ['required', 'confirmed'],
        ]);

        if (!$validator->fails()) {
            $superAdmin = $request->user();
            $superAdmin->forceFill([
                'password' => Hash::make($request->input('new_password')),
            ]);
            $isSaved = $superAdmin->save();
            return response()->json(
                ['message' => $isSaved ? __('cms.change_success') : __('cms.change_falid')],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }
}

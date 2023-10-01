<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Http\Requests\UserLoginRequest;
use App\Mail\SendInvitation;
use App\Models\User;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AuthController extends Controller
{

    use ApiResponser;


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function sendInvitation(Request $request)
    {
        $payload = $request->all();
        $email = $payload['email'];
        if ($email) {
            $user = User::getUserDecripted($email);
            if ($user) {
                return $this->error('Email já está cadastrado', 400);
            }
            try {
                return   DB::transaction(function () use ($email, $payload) {
                    $password = bcrypt($email);

                    // $user = User::create([
                    //     "email" => $email,
                    //     "name" => $payload['name'],
                    //     "password" => $password
                    // ]);

                    $request = new SendMailRequest([
                        'email' => $email,
                        'name' => $payload['name'],
                        'isInvite' => true
                    ]);

                    $result = SendMailController::send($request);

                    return $result;
                    $email = explode('@', $email);
                    return $this->success(null, 'Email enviado para:  ' . substr($email[0], 0, 3) . '*****@' . substr($email[1], 0, 3) . '*****');
                });
            } catch (\Exception $e) {
                return $this->error($e->getMessage(), 400);
            }
        }

        return $this->error('Email inválido', 400);
    }

    public function checkEmailExistente($email)
    {
        $user = User::getUserDecripted($email);

        if ($user) {
            try {
                $response = Http::accept('application/json')->post(env('API_SEND_EMAIL'), [
                    'email' => $email,
                    'name' => $user->name,
                    'isInvite' => false
                ]);

                return $response;
                $user->token = $response['token'];
                $user->token_time = now();
                $user->update();
                $email = explode('@', $user['email']);
                return $this->success(null, $response);
            } catch (GuzzleException $e) {
                return response($e->getMessage());
            }
        }

        return $this->error('Email não encontrado', 404);
    }





    public function codeValidation($code)
    {
        try {
            $user = User::where('token', 'like', substr($code, 0, 3) . '%' . substr($code, -3))->first();
            if ($user) {
                $date1 = Carbon::create($user->token_time);
                $date2 = Carbon::create(now());
                if ($date1->diffInHours($date2) <= 24) {
                    $user->token = null;
                    $user->update();
                    return $this->success('Usuário', $user->build());
                }
            } else {
                return $this->error('codigo inválido ou expirado', 404);
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }



    public function login(UserLoginRequest $request)
    {
        try {
            $payload = $request->all();

            $user = User::getUserDecripted($payload['email']);

            if ($user) {
                if (!Hash::check($payload['password'], $user->password)) {
                    return $this->error('Credenciais incorretas', 403);
                }

                // $this->logout($user);
                Auth::login($user);

                return $this->success('Wellcome ' . $user->name, [
                    'user' => $user->build($user),
                    'token' => $user->createToken('API Token')->plainTextToken,
                ]);
            }

            return $this->error('User não cadastrado', 404);
        } catch (Throwable $e) {
            return $request;
        }
    }


    public function updatePassword(Request $request, User $user)
    {

        if ($user) {
            $user->password = bcrypt($request->input('password'));
            $user->update();
        }

        Auth::login($user);

        return $this->success('Wellcome ' . $user->name, [
            'user' => $user->build($user),
            'token' => $user->createToken('API Token')->plainTextToken,
        ]);
    }



    public function logout(User $user)
    {
        if ($user) {
            $user->tokens()->delete();
        }
    }
}


//CommitTestDaniel

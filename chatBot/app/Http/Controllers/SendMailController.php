<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Mail\RecoverCode2;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function send(SendMailRequest $request)
    {
        $payload = $request->all();
        $payload += ["token" => Str::random(40)];
        // return new SendMail($payload);->to($this->playload['email'], $this->playload['name'])
        Mail::to('silvaengcomp@gmail.com')->send(new SendMail($payload));
        $email = explode('@', $payload['email']);
        return  [
            "email" => 'Email enviado para:  ' . substr($email[0], 0, 3) . '*****@' . substr($email[1], 0, 3) . '*****',
            "token" => substr($payload['token'], 0, 3) . substr($payload['token'], -3)
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {
        return 'hi';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

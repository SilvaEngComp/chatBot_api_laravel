<?php

namespace App\Http\Controllers;

use App\Models\Responser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Traits\ApiResponser;

class UserController extends Controller
{

    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::get();
        // return Responser::success(null, 'Users');
        return User::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $payload = $request->all();
        $payload["password"] = bcrypt($payload["password"]);

        $user = User::create($payload);
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user) {
            return $user;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($user) {
            if ($request->has('name')) {
                $user->name = $request->input('name');
            }

            if ($request->has('email')) {
                $user->email = $request->input('email');
            }
            if ($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->update();
            return $this->success('User updated', $user);
        }

        return $this->error('User not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user) {
            $user->delete();
        }
    }
}
//pushtest

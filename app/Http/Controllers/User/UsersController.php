<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;

class UsersController extends ApiController
{

    public function index()
    {
        $users = User::all();

        return $this->showAll($users);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->input('password'));
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::NORMAL_USER;

        $user = User::query()->create($data);

        //return response()->json(['data' => $user], 201);
        return $this->showOne($user, 201);
    }

    public function show($id)
    {
        $user = User::query()->findOrFail($id);

        return $this->showOne($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::query()->findOrFail($id);

        $this->validate($request, [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::NORMAL_USER . '',
        ]);

        if ($request->exists('name')) {
            $user->name = $request->name;
        }

        if ($request->exists('email') && $request->email != $user->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if ($request->exists('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->exists('admin')) {
            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify the admin field.', 409);
            }

            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update.', 422);
        }

        $user->update();

        return $this->showOne($model);
    }

    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);

        $user->delete();

        return $this->showOne($user);
    }
}

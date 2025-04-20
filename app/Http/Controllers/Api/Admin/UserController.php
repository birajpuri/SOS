<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends BaseApiController
{
    public function index()
    {
        $users = User::where('is_admin', false)->latest()->paginate(10);
        return $this->successResponse($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'phone' => ['required', 'string', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        return $this->createdResponse($user);
    }

    public function show(User $user)
    {
        return $this->successResponse($user->load(['bookings']));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['sometimes', 'required', 'string', 'unique:users,phone,' . $user->id],
            'password' => ['sometimes', 'required', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        $data = $request->only(['name', 'email', 'phone']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return $this->successResponse($user, 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return $this->errorResponse('Cannot delete admin user');
        }

        $user->delete();
        return $this->noContentResponse();
    }
}
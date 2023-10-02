<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('user index')) {
            abort(403);
        }
        $users = User::paginate(10);

        return response([
            'users' => $users,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        if (!auth()->user()->hasPermissionTo('user store')) {
            abort(403);
        }
        $data = $request->validated();
        $user = User::create($data);
        $userData = "Password: {$data['password']}\n";
        $userData .= "Email: {$data['email']}\n";
        $userData .= "Name: {$data['name']}\n";
        $userData .= "------------------------\n";

        Storage::append('users.txt', $userData);

        return response([
            'users' => $user,
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (!auth()->user()->hasPermissionTo('user show')) {
            abort(403);
        }
        return response([
            'User' => $user,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        if (!auth()->user()->hasPermissionTo('user update')) {
            abort(403);
        }
        $user->update($request->validated());

        return response([
            'users' => $user->refresh(),
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->hasPermissionTo('user destroy')) {
            abort(403);
        }
        $user->delete();

        return response([
            'message' => 'User deleted',
        ], 200);
    }
}
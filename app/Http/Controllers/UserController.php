<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function list() {
        if(auth()->user()->cannot('user-list')) {
            abort(403);
        }

        $users = User::paginate(10);

        return view('dashboard.users.list', compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function add() {
        if(auth()->user()->cannot('user-add')) {
            abort(403);
        }

        $domains = Domain::whereStatus('published')->get();

        return view('dashboard.users.add', compact('domains'));
    }

    /**
     * @param $user_id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($user_id) {
        if(auth()->user()->cannot('user-edit')) {
            abort(403);
        }

        $user = User::findOrFail($user_id);
        $domains = Domain::whereStatus('published')->get();

        return view('dashboard.users.edit', compact('user', 'domains'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function create(Request $request) {
        if(auth()->user()->cannot('user-create')) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:12'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = new User;
        $user->role_id = 2;
        $user->name = $request->name;
        $user->email = $request->email;

        $user->password = Hash::make($request->password);

        if($request->filled('expired')) {
            $user->expired_at = $request->expired;
        }

        if($user->saveOrFail()) {
            if($request->filled('domain')) {
                $user->permission()->attach($request->domain);
            }

            return redirect()->route('dashboard.users')->with('success', 'User created');
        }
    }

    /**
     * @param Request $request
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $user_id) {
        if(auth()->user()->cannot('user-update')) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:12'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user_id],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user = User::findOrFail($user_id);
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if($request->filled('domain')) {
            $user->permission()->sync($request->domain);
        }

        if($request->filled('expired')) {
            $user->expired_at = $request->expired;
        }

        if($user->saveOrFail()) {
            return redirect()->route('dashboard.users')->with('success', 'User updated');
        }
    }
}

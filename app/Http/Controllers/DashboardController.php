<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $post_count = Post::count();
        $user_count = User::count();
        $domain_count = Domain::count();

        $domains = Auth::user()->permission;

        return view('dashboard.home', compact('post_count', 'user_count', 'domain_count', 'domains'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? response([], 204)
            : redirect()->route('dashboard');
    }
}

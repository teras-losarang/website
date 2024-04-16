<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function process(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required|min:6|max:100"
        ]);

        $user = $this->user->whereEmail($request->email)->first();
        if (!$user) {
            return back()->with("error", "email or password wrong!")->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with("error", "email or password wrong!")->withInput();
        }

        $request->session()->regenerate();
        if (Auth::attempt([
            "email" => $request->email,
            "password" => $request->password,
        ])) {
            return redirect()->intended('/');
        }

        return back()->with("error", "email or password wrong!")->withInput();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\User;
use App\Http\Requests\ChangePasswordRequest;
class UserController extends Controller
{
    public function __construct () {
        $this->middleware('auth');
    }

    public function index(User $user) {
        return view('auth.userSettings', ['user' => $user]);
    }

    public function store(ChangePasswordRequest $request, User $user) {
        $messages = collect(__('passwords.user_updated'));
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->has('old_password') && $request->old_password != "") {
            $user->password = Hash::make($request->new_password);
            $request->session()->regenerate();
            $messages->push(__('passwords.reset'));
        }
        $user->save();
        return redirect()->back()->with('success', $messages);
    }
}

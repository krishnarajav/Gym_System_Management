<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Trainer;
use App\Models\Equipment;
use App\Models\Plan;
use App\Models\Sessions;
use App\Models\Pay_Transaction;

class AppManager extends Controller {
    function login() {
        if (Auth::check()) {
            return redirect(route('homepage'));
        }
        return view('login');
    }

    function registration() {
        if (Auth::check()) {
            return redirect(route('homepage'));
        }
        return view('registration');
    }

    function loginPost(Request $request) {
        $credentials  = $request->only('id', 'password');
        if(Auth::attempt($credentials)) {
            return redirect()->intended(route('homepage'));
        }
        return redirect(route('login'))->with('error', 'Login details are not valid.');
    }

    function registrationPost(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:Admin,id|max:10',
            'password' => 'required|min:5|confirmed',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return redirect(route('registration'))->with('error', $errorMessage);
        }

        $data['id'] = $request->id;
        $data['password'] = Hash::make($request->password);
        $data['name'] = $request->name;
        $admin = Admin::create($data);
        if(!$admin){
            return redirect(route('registration'))->with('error', 'Registration failed, try again.');
        }
        return redirect(route('login'))->with('success', 'Registration successful. Login to access the application.');
    }

    function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }

    public function showProfile()
{
    $user = Auth::Admin; 
    return view('profile', ['user' => $user]);
}
}
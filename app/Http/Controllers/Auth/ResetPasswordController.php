<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * After password reset & login, redirect user to /home
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }
}

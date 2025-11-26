<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Jika admin → ke dashboard admin
        if(Auth::user()->role == 'admin'){
            return redirect('/admin/dashboard');
        }

        // Jika user → ke dashboard user
        return redirect('/user/dashboard');
    }
}

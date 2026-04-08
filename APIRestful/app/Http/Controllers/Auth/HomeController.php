<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Muestra el dashboard de la aplicación.
     */
    public function index(): View
    {
        return view('home');
    }
}

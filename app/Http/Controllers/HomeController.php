<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Με την παρακάτω εντολή το function ψάχνει μέσα στον φάκελο resources/views το αρχείο με όνομα home.blade.php και το επιστρέφει για εμφάνιση
        return view('home');
    }
}

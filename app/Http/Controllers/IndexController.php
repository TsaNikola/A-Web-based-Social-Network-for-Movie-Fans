<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Banner;
use DB;
use \Input as Input;
use App\Quotation;
use \Illuminate\Foundation\Exceptions\Handler;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Admin;
use Image;
use App\Movie;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;





class IndexController extends Controller
{
    public function home()
    {
       $movies= Movie::orderBy('popularity', 'desc') ->orderBy('releaseDate', 'desc')->paginate(60);
        return view('home',compact('movies'));
    }
}
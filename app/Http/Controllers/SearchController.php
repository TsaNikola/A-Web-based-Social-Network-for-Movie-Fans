<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use \Input as Input;
use App\Quotation;
use \Illuminate\Foundation\Exceptions\Handler;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Admin;
use Image;
use App\Movie;
use App\Person;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;





class SearchController extends Controller
{
    public function menuSearch(Request $request)
    {
        $input = $request->all();
        $findThis=$input['menusearch'];
        $movies= Movie::where("title","LIKE","%$findThis%")->orderBy('popularity', 'desc') ->orderBy('releaseDate', 'desc')->get();
        $users= User::where("username","LIKE","%$findThis%")->orderBy('username', 'asc')->get();
        $credits= Person::where("name","LIKE","%$findThis%")->orderBy('name', 'asc')->get();
        $type='menu';
        return view('search',compact('movies','credits','users','type'));
    }

    public function adminSearch(Request $request)
    {

         $input = $request->all();
        if(isset($input['title'])) {
            $findThis = $input['title'];
            $movies = Movie::where("title", "LIKE", "%$findThis%")->orderBy('popularity', 'desc')->orderBy('releaseDate', 'desc')->get();
            $type = 'admin';

            return view('search', compact('movies', 'type'));
        }
        if(isset($input['username'])) {
            $findThis=$input['username'];
            $users= User::where("username","LIKE","%$findThis%")->orderBy('username', 'asc')->get();
            $type='admin';

            return view('search',compact('users','type'));
        }
    }
    public function adminSearchUsers(Request $request)
    {

        $input = $request->all();
        $findThis=$input['username'];
        $users= User::where("username","LIKE","%$findThis%")->orderBy('username', 'asc')->get();
        $type='admin';

        return view('search',compact('users','type'));
    }

}
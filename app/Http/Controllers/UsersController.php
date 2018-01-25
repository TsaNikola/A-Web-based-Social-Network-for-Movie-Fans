<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Pagination\Paginator;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Movie;
use App\User;
use App\Comment;
use App\Person;

class UsersController extends Controller
{
    function profile($id='')
    {

        if($id==Auth::user()->idUser){
            return redirect(route('profile'));
        }

        if($id=='' && Auth::check()){
            $id=Auth::user()->idUser;

        }elseif($id=='' && !Auth::check()){
            return redirect(route('home'));
        }

        $currentUser=User::getUser($id);
        if(isset($currentUser[0])) {
            $currentUser = $currentUser[0];
        }else{
            return response()->view('notFound', [], 404);
        }
        $comments=Comment::getUserComments($id);
        $followers= User::getFollowers($id);
        $follows=User::getFollows($id);
        $movies=Movie::getFollows($id);
        foreach ($movies as $key => $movie) {
            $genres = collect(array("genres"=>Movie::getGenres($movie['idMovie'])));
            $movies[$key] = $genres->merge($movies[$key]);
        }
        $genres=User::getGenres($id);
        $recentActivity=paginate(User::getLatestActivity($id),25);
        $news=array();
        $followersids=array();
        foreach ($followers as $follower) {
            array_push($followersids, $follower['idUser']);
        }
            foreach ($follows as $key => $follow) {

                $activity = User::getLatestActivity($follow['idUser']);
                if (isset($activity[0])) {
                    foreach ($activity as $key => $actvt) {
                        $activity[$key] = array_merge($activity[$key], array('user' => $follow));
                    }
                    $news = array_merge($news, $activity);
                }
            }
        foreach ($movies as $key => $follow) {
            $activity = Movie::getLatestActivity($follow['idMovie']);
            if (isset($activity[0])) {
                $news = array_merge($news, $activity);
            }
        }

        $latestNews=array();
        $sort = array();
        foreach ($news as $key => $row)
        {
            $sort[$key] = $row['date'];
        }
        array_multisort($sort, SORT_DESC, $news);
        foreach($news as $key=>$act){
            array_push($latestNews, $act);
        }
        $lntmp=array();
        foreach($latestNews as $key=>$ln){
            if(isset($ln['idComment'])) {
                $lntmp[$key] = $ln['idComment'];
            }
        }
        $lntmp=  array_diff_key($lntmp,array_unique($lntmp));

        foreach($lntmp as $key=>$rem){
            unset($latestNews[$key]);
        }

        return view('users.profile',compact('latestNews','currentUser','recentActivity','genres','followers','follows','followersids','movies','comments','id'));

    }

    function profilesettings(Request $request){
        if(Auth::check()) {
            $input = $request->all();
            $fileName = null;
            if(isset($input['save'])) {

                $validator = Validator::make($input, [
                    'email' => 'string|email|max:255|unique:users|nullable ',
                    'oldpassword' => 'string|min:6|nullable ',
                    'password' => 'string|min:6|confirmed|nullable ',
                    'aboutme' => 'string|nullable ',
                    'userimage' => 'image|nullable ',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $user = User::where('idUser',Auth::user()->idUser)->firstOrFail();
                if (isset($input['userimage'])) {
                    $image = $input['userimage'];
                    if ($image->isValid()) {
                        $destinationPath = public_path('uploads/users/images');
                        $extension = $image->getClientOriginalExtension();
                        $fileName = uniqid() . '.' . $extension;

                        $image->move($destinationPath, $fileName);
                    }
                }
                $user->image = $fileName;
                if(isset($input['password'])){
                    if (Hash::check($input['password'], $user->password)) {
                        if($input['password']===$input['password_confirmation']) {
                            $user->password = bcrypt($input['password']);
                        }
                    }

                }
                if(isset($input['email'])) {
                    $user->email = $input['email'];
                }
                if(isset($input['aboutme'])) {
                    $user->info = $input['aboutme'];
                }
               $user->save();

            }
            $currentUser=User::getUser(Auth::user()->idUser);
            $currentUser=$currentUser[0];

            return view('users.settings',compact('currentUser'));
        }
    }

    function followmovie(Request $request){
        $input = $request->all();

        User::followMovie($input['movieid']);
        return redirect()->back();
    }

    function followuser(Request $request){
        $input = $request->all();

        User::followUser($input['userid']);
        return redirect()->back();
    }

    function commentsubmit(Request $request)
    {
        $input = $request->all();
        if(strlen ($input['comment'])>0) {
            Comment::submitComment($input['dbid'], $input['comment']);
            return redirect()->back();
        }
    }


    function allusers(){
        $allusers=DB::table('users')->paginate(50);

        return view('users.allusers',compact('allusers'));

    }
}


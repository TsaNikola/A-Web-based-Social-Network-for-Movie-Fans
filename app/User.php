<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;
use App\Comment;
use App\Movie;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'idUser';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'image', 'info',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getUser($id)
    {
        $user=User::where('idUser',$id)->get();

        return $user;
    }

    public static function followMovie($id)
    {
        $action= DB::table('user_movie')->where([
            ['movieUserId',$id],
            ['userMovieId',Auth::User()->idUser],
            ])->get();
        if(isset($action[0])){
            DB::table('user_movie')->where([
                ['movieUserId',$id],
                ['userMovieId',Auth::User()->idUser],
            ])->delete();
        }else{
        DB::table('user_movie')->insert([
            'movieUserId' => $id,
            'userMovieId' => Auth::User()->idUser,
            'followDate' => date("Y-m-d H:i:s", time()),
        ]);
        }
    }

    public static function followUser($id)
    {
        $action= DB::table('user_user')->where([
            ['idUserFollows',$id],
            ['idUserFollower',Auth::User()->idUser],
        ])->get();

        if(isset($action[0])){
            DB::table('user_movie')->where([
                ['idUserFollows',$id],
                ['idUserFollower',Auth::User()->idUser],
            ])->delete();
        }else{
            DB::table('user_user')->insert([
                'idUserFollower' => Auth::User()->idUser,
                'idUserFollows' => $id,
                'followDate' => date("Y-m-d H:i:s", time()),
            ]);
        }

    }

    public static function getGenres($id)
    {
       $movieids= DB::table('user_movie')->where('userMovieId', $id)->pluck('movieUserId');
        $allgenres=array();
        $genres=array();
       foreach ($movieids as $movieid){
           $moviegenres=Movie::getGenres($movieid);
           $moviegenres = json_decode($moviegenres, True);
           $allgenres=array_merge($allgenres,$moviegenres);
       }
       $genrescnt= array_count_values($allgenres);
        $sum=0;
        foreach($genrescnt as $gcnt){
            $sum+= $gcnt;
        }
        foreach($genrescnt as $key=>$gcnt){
            $genres{$key}=array('count'=> $gcnt,'percent'=>number_format($gcnt/$sum*100, 2, ',', '.'));
        }
//        return $sum;
      return $genres;
    }

    public static function getFollowers($id)
    {
       $followersids= DB::table('user_user')->where('idUserFollows',$id)->orderBy('followDate','desc')->get();
       $followers=array();
        foreach ($followersids as $followersid){
            $id=$followersid->idUserFollower;
            $date=$followersid->followDate;
            $follower= User::getUser($id);
            $follower = json_decode($follower[0], True);
            $follower=array_merge($follower,array('followDate'=>$date));
            array_push($followers,$follower);
        }
        return $followers;
    }
    public static function getFollows($id)
    {
        $followsids= DB::table('user_user')->where('idUserFollower',$id)->orderBy('followDate','desc')->get();
        $follows=array();
        foreach ($followsids as $followsid){
            $id=$followsid->idUserFollows;
            $date=$followsid->followDate;
            $follow= User::getUser($id);
            $follow = json_decode($follow[0], True);
            $follow=array_merge($follow,array('followDate'=>$date));
            array_push($follows,$follow);
        }
        return $follows;
    }

    public static function getMovieFollows($id)
    {
        $followsids= DB::table('user_movie')->where('userMovieId',$id)->orderBy('followDate','desc')->get();
        $follows=array();
        foreach ($followsids as $followsid){
            $id=$followsid->movieUserId;
            $date=$followsid->followDate;
            $follow= Movie::getMovie($id);
            $follow = json_decode($follow[0], True);
            $follow=array_merge($follow,array('followDate'=>$date));
            array_push($follows,$follow);
        }
        return $follows;
    }

    public static function getLatestActivity($id){
        $follows=User::getFollows($id);
        $comments=Comment::getUserComments($id);
        $latestActivity=array();
        $activity=array();
        foreach($follows as $follow){
            $date=strtotime($follow['followDate']);
            $follow=array_merge($follow,array('date'=>$date));
            array_push($activity,$follow);
        }
        foreach($comments as $comment){
            $date=strtotime($comment['publishDate']);
            $comment=array_merge($comment,array('date'=>$date));
            array_push($activity,$comment);
        }
        $sort = array();
        foreach ($activity as $key => $row)
        {
            $sort[$key] = $row['date'];
        }
        array_multisort($sort, SORT_DESC, $activity);
        foreach($activity as $key=>$act){

                array_push($latestActivity, $act);
        }
        return $latestActivity;
    }
}

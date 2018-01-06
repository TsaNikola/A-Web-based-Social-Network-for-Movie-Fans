<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;
use App\User;
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
        DB::talbe('user_movie')->insert([
            'userMovieId' => $id,
            'movieUserId' => Auth::User()->idUser,
            'followDate' => date("Y-m-d H:i:s", time()),
        ]);
    }

    public static function followUser($id)
    {
        DB::talbe('user_user')->insert([
            'idUserFollower' => Auth::User()->idUser,
            'idUserFollows' => $id,
            'followDate' => date("Y-m-d H:i:s", time()),
        ]);
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

}

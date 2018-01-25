<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
use App\Movie;
use App\Pesron;

class Comment extends Model
{

    //δηλώνουμε σε ποιόν πίνακα της βάσης θα βλέπει το συγκεκριμένο model
    protected $table = 'comments';
    //επιστρέφει τα δεδομένα για τα σχόλια που έχουμε για έναν χρήστη μεσα στον πίνακα comments με βάση το id
    public static function getUserComments($userid)
    {
        //Ψάχνει στην βάση στον πίνακα που έχουμε δηλώσει στο model Comment εκεί που το πεδίο userCommentId έχει την τιμή της
        // μεταβλήτης $userid παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
        $comments=  Comment::where('userCommentId',$userid)->get();
        //μετατροπή του object σε πίνακα
        $comments = json_decode($comments, True);
        foreach($comments as $key=>$comment) {
            //καλεί την function getMovie του model Movie
            $movie = Movie::getMovie($comment['movieCommentId']);
            //μετατροπή του object σε πίνακα
            $movie = json_decode($movie[0], True);
            //Βάζουμε τα δεδομένα της τρέχουσας ταινίας στον πίνακα με τα δεδομένα του σχολίου
            $comments[$key]= array_merge($comments[$key],$movie);
        }
        //επιστρέφει τον πίνακα με όλα τα σχόλια του χρήστη και τα δεδομένα τους
        return $comments;
    }

    public static function getMovieComments($movieid)
    {

        $comments=  Comment::where('movieCommentId',$movieid)->get();
        $comments = json_decode($comments, True);
        foreach($comments as $key=>$comment) {
            $user = User::getUser($comment['userCommentId']);
            $user = json_decode($user[0], True);
            $comments[$key]= array_merge($comments[$key],$user);
        }
        return $comments;
    }
    public static function getUserMovieComments($userid,$movieid)
    {
        $comments = Comment::where([
            ['userCommentId', $userid],
            ['movieCommentId', $movieid],
        ])->get();
        $movie = Movie::getMovie($movieid);
        $user = User::getUser($userid);
        //μετατροπή του object σε πίνακα
        $comments = json_decode($comments, True);
        $movie = json_decode($movie, True);
        $user = json_decode($user, True);
        foreach ($comments as $k => $comment) {
            $comments[$k] = array_merge($comments[$k], array('user' => $user[0]));
            $comments[$k] = array_merge($comments[$k], $movie[0]);
        }

        //επιστρέφει τον πίνακα με όλα τα σχόλια του χρήστη και τα δεδομένα τους
        return $comments;
    }

    public static function getLatestComments($id='',$type='')
    {

            if($id!=''){
                if($type=='movie'){
                    $comments=  Comment::where('movieCommentId',$id)->orderBy('publishDate','desc')->get();
                    $comments = json_decode($comments, True);
                    foreach($comments as $key=>$comment) {
                        $user = User::getUser($comment['userCommentId']);
                        $user = json_decode($user[0], True);
                        $comments[$key]= array_merge($comments[$key],array('user'=>$user));
                    }
                    return $comments;
                }elseif($type=='user'){
                    $comments=  Comment::where('userCommentId',$id)->orderBy('publishDate','desc')->get();
                    $comments = json_decode($comments, True);
                    foreach($comments as $key=>$comment) {
                        $movie = Movie::getMovie($comment['movieCommentId']);
                        $movie = json_decode($movie[0], True);
                        $comments[$key]= array_merge($comments[$key],$movie);
                    }
                    return $comments;
                }
            }

        $comments=Comment::orderBy('publishDate','desc')->get();
        return $comments;
    }

    public static function submitComment($comment,$id){
        DB::table('comments')->insert([
            'content' => $comment,
            'movieCommentId' => $id,
            'userCommentId' => Auth::user()->idUser,
            'publishDate' => date("Y-m-d H:i:s", time())
        ]);
    }

    public static function getAllComments(){
        $movies=Movie::get();
        $news=array();
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
        return $latestNews;
    }

}

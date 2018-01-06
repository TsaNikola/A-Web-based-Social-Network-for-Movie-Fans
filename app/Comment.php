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

    public static function getLatestComments($id='',$type='')
    {
        if(isset($id)){
            if($id!=''){
                if($type=='movie'){
                    $comments=  Comment::where('movieCommentId',$id)->orderBy('publishDate','desc')->get();
                    $comments = json_decode($comments, True);
                    foreach($comments as $key=>$comment) {
                        $user = User::getUser($comment['userCommentId']);
                        $user = json_decode($user[0], True);
                        $comments[$key]= array_merge($comments[$key],$user);
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
        }
        $comments=Comment::orderBy('publishDate','desc')->get();
        return $comments;
    }

//    public static function saveComment($movieid,$userid,$comment)
//    {
//        $comments=Comment::where('movieCommentId',$id)->get();
//        return $comments;
//    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
use App\Comment;
use App\Pesron;


class Movie extends Model
{
    //δηλώνουμε σε ποιόν πίνακα της βάσης θα βλέπει το συγκεκριμένο model
    protected $table = 'movie';

    //επιστρέφει τα δεδομένα που έχουμε για μια ταινία μεσα στον πίνακα movie με βάση το id της
    public static function getMovie($id)
    {
        //Ψάχνει στην βάση στον πίνακα που έχουμε δηλώσει στο model Movie εκεί που το πεδίο idMovie έχει την τιμή της
        // μεταβλήτης $id παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
        $movie=Movie::where('idMovie',$id)->get();
        return $movie;
    }

    //επιστρέφει τα σχόλια που έχουμε για μια ταινία με βάση το id της
    public static function getComments($id)
    {
        //καλεί την function getMovieComments που βρίσκεται στο model Comment
        $comments=Comment::getMovieComments($id);
        return $comments;
    }

    //επιστρέφει τους ακόλουθους που έχουμε για μια ταινία με βάση το id της
    public static function getFollowers($id)
    {
        //Ψάχνει στην βάση στον πίνακα user_movie εκεί που το πεδίο movieUserId έχει την τιμή που βρίσκεται στην
        // μεταβήτη $id και παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
        //Μέσα στο object είναι τα ids των ακόλουθων της ταινίας.
        $followersids=DB::table('user_movie')->where('movieUserId',$id)->get();
        //Έναρξη δημιουργίας πίνακα με τα δεδομένα των ακόλουθων της ταινίας
        $followers=array();
        foreach($followersids as $fid){
            //Ψάχνει στην βάση στον πίνακα που έχουμε δηλώσει στο model User εκεί που το πεδίο idUser έχει την τιμή που βρίσκεται
            //στο $fid->userMovieId και παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
            $followertemp=User::where('idUser',$fid->userMovieId)->get();
            //μετατροπή του object σε πίνακα
            $followertemp = json_decode($followertemp, True);
            //δημιουργία πίνακα όπου κρατάει τα δεδομένα του τρέχωντος χρήστη
            $follower=array_merge($followertemp[0],array("follow_date" => $fid->followDate));
            //Βάζουμε τα δεδομένα στον πίνακα που περιέχει όλους τους χρήστες
            array_push($followers,$follower);
        }
        //επιστρέφει τον πίνακα με όλους τους χρήστες
        return $followers;
    }

    public static function getFollows($id)
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
        $follows=Movie::getFollows($id);
        $comments=array();
        foreach ($follows as $follow){
            $comment=Comment::getLatestComments($follow['idMovie'],'movie');
            if(isset($comment[0])) {
         foreach($comment as $key=>$comm){
             $follow = Movie::getMovie($follow['idMovie']);
             $follow = json_decode($follow[0], True);
             $comment[$key]= array_merge($comment[$key],array('date'=>strtotime($comm['publishDate'])));
             $comment[$key] = array_merge($follow,$comment[$key] );
         }
                $comments=    array_merge($comments, $comment);
            }
        }

        $latestActivity=array();

        $sort = array();
        foreach ($comments as $key => $row)
        {
            $sort[$key] = $row['publishDate'];
        }
        array_multisort($sort, SORT_DESC, $comments);
        foreach($comments as $key=>$act){
            array_push($latestActivity, $act);
        }
        return $latestActivity;
    }

    //επιστρέφει τα trailers που έχουμε για μια ταινία με βάση το id της
    public static function getTrailers($id)
    {
        //Ψάχνει στην βάση στον πίνακα trailer εκεί που το πεδίο movieTrailerId έχει την τιμή που βρίσκεται στην
        // μεταβλήτη $id και παίρνει όλα τα δεδομένα των πεδίω εκείνης της εγγραφής και τα επιστρέφει σαν object.
        $trailers=DB::table('trailer')->where('movieTrailerId',$id)->get();
        //επιστρέφει τον πίνακα με όλα τα trailers
        return $trailers;
    }

    //επιστρέφει τις ταπετσαρίες που έχουμε για μια ταινία με βάση το id της
    public static function getWallpapers($id)
    {
        //Ψάχνει στην βάση στον πίνακα wallpaper εκεί που το πεδίο movieWallpaperId έχει την τιμή που βρίσκεται στην
        // μεταβλήτη $id και επιστρέφει σε πίνακα τις τιμές που υπάρχουν στο πεδίο filename.
        $wallpapers=DB::table('wallpaper')->where('movieWallpaperId',$id)->pluck('filename');
        //επιστρέφει τον πίνακα με όλα τα wallpapers
        return $wallpapers;
    }

    //επιστρέφει τα είδη της ταινίας με βάση το id της
    public static function getGenres($id)
    {
        //Ψάχνει στην βάση στον πίνακα wallpaper εκεί που το πεδίο genreMovieId έχει την τιμή που βρίσκεται στην
        // μεταβλήτη $id και επιστρέφει σε πίνακα τις τιμές που υπάρχουν στο πεδίο genreName.
        $genres=DB::table('movie_genre')->where('genreMovieId',$id)->pluck('genreName');
        //επιστρέφει τον πίνακα με όλα τα genres
        return $genres;
    }

    public static function getAllGenres()
    {
        $moviesar= Movie::pluck('IdMovie');
        $allgenres=array();
        foreach ($moviesar as $movieid) {
            $genres=Movie::getGenres($movieid);
            foreach ($genres as $genre) {
                array_push($allgenres, $genre);
            }
        }
        $allgenres=array_unique($allgenres);

        return $allgenres;
    }
    //Ψάχνει στην βάση να βρεί ταινίες που έχουν έστω και ένα απο τα είδη που βρίσγονται στον πίνακα $genres
    public static function findGenres($genres)
    {
        //Δημιουργια πίνακα που θα μπούν οι ταινίες και τα δεδομένα τους
        $movies=array();
        foreach ($genres as $genre) {
            //Ψάχνει στην βάση στον πίνακα movie_genre εκεί που το πεδίο genreName έχει την τιμή που βρίσκεται στην
            // μεταβλήτη $genre και επιστρέφει σε πίνακα τις τιμές που υπάρχουν στο πεδίο genreMovieId.
            $movieids = DB::table('movie_genre')->where('genreName', $genre)->pluck('genreMovieId');
            $movieids = json_decode($movieids, True);
            //Σβήνουμε πιθανές διπλοεγγραφές του πινακα.
            $movieids=array_unique($movieids);
            //παίρνουμε τα δεδομένα για κάθε id ταινίας που βρήκαμε
            foreach($movieids as $key=>$movieid) {
                //καλεί την function getMovie του model Movie
                $movie = Movie::getMovie($movieid);
                //μετατροπή του object σε πίνακα
                $movie = json_decode($movie, True);
                //καλεί την function getGenres του model Movie
                $moviegenres = Movie::getGenres($movieid);
                //μετατροπή του object σε πίνακα
                $moviegenres = json_decode($moviegenres, True);
                //Βάζουμε τα genres στον πίνακα με τα δεδομένα της τρέχουσας ταινίας
                $movie[0]= array_merge($movie[0], array("genres"=>$moviegenres));
                //καλεί την function getFollowers του model Movie και μετράει τον αριθμό των εγγραφών του πίνακα (δηλ. πόσοι ακολουθούν την ταινία)
                $followersum = count(Movie::getFollowers($movieid));
                //Βάζουμε τον αριθμό που βρήκαμε στον πίνακα με τα δεδομένα της τρέχουσας ταινίας
                $movie[0]= array_merge($movie[0], array("followers"=>$followersum));
                //Βάζουμε τα δεδομένα της τρέχουσας ταινίας στον πίνακα με τις υπόλοιπες ταινίες
                $movies = array_merge($movies, $movie);
            }
        }
        //επιστρέφει τον πίνακα με όλες τις ταινίες που βρέθηκαν και τα δεδομένα τους
        return $movies;
    }

    //επιστρέφει τους ηθοποιούς της ταινίας με βάση το id της
    public static function getCast($id)
    {
        //καλεί την function getMovieCast του model Person
        return Person::getMovieCast($id);
    }

    //επιστρέφει τους υπόλοιπους συντελεστές της ταινίας με βάση το id της
    public static function getCrew($id)
    {
        //καλεί την function getMovieCrew του model Person
        return  Person::getMovieCrew($id);
    }

    //επιστρέφει όλα τα δεδομένα που έχουμε για μια ταινία με βάση το id της
    public static function getAll($id)
    {
        //Ψάχνει στην βάση στον πίνακα που έχουμε δηλώσει στο model Movie εκεί που το πεδίο idMovie έχει την τιμή της
        // μεταβλήτης $id παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
        $movie= Movie::where("idMovie",$id)->get();
        //μετατροπή του object σε πίνακα
        $movie = json_decode($movie, True);
        //καλεί την function getGenres του model Movie
        $genres=Movie::getGenres($id);
        //Βάζουμε τα δεδομένα που βρήκαμε στον πίνακα με τα δεδομένα της ταινίας
        if(isset($movie[0])) {
            $movie = array_merge($movie[0], array("genres" => $genres));
            //καλεί την function getWallpapers του model Movie
            $wallpapers = Movie::getWallpapers($id);
            //Βάζουμε τα δεδομένα που βρήκαμε στον πίνακα με τα δεδομένα της ταινίας
            $movie = array_merge($movie, array("wallpapers" => $wallpapers));

            //καλεί την function getTrailers του model Movie
            $trailers = Movie::getTrailers($id);
            //μετατροπή του object σε πίνακα
            $trailers = json_decode($trailers, True);
            //Βάζουμε τα δεδομένα που βρήκαμε στον πίνακα με τα δεδομένα της ταινίας
            $movie = array_merge($movie, array("trailers" => $trailers));

            //καλεί την function getCast του model Movie
            $cast = Movie::getCast($id);
            //Βάζουμε τα δεδομένα που βρήκαμε στον πίνακα με τα δεδομένα της ταινίας
            $movie = array_merge($movie, array("cast" => $cast));

            //καλεί την function getCrew του model Movie
            $crew = Movie::getCrew($id);
            //Βάζουμε τα δεδομένα που βρήκαμε στον πίνακα με τα δεδομένα της ταινίας
            $movie = array_merge($movie, array("crew" => $crew));

            //καλεί την function getFollowers του model Movie
            $followers = Movie::getFollowers($id);
            //Βάζουμε τα δεδομένα που βρήκαμε στον πίνακα με τα δεδομένα της ταινίας
            $movie = array_merge($movie, array("followers" => $followers));

            //καλεί την function getComments του model Movie
            $comments = Movie::getComments($id);
            //Βάζουμε τα δεδομένα που βρήκαμε στον πίνακα με τα δεδομένα της ταινίας
            $movie = array_merge($movie, array("comments" => $comments));
        }else{
            $movie=array();
        }

        //επιστρέφει τον πίνακα την ταινία και όλα τα δεδομένα της
        return $movie;

    }

    public static function getPopular($page=1, $genres=null,$fromYear=null, $toYear=null)
    {
        $movies=array();
        $moviesar = Movie::orderBy("popularity", "desc")->paginate(25);
        $moviesar = json_decode(json_encode($moviesar), True);
        foreach ($moviesar['data'] as $key => $movie) {
            $genres = Movie::getGenres($movie['idMovie']);
            array_push($moviesar['data'][$key], array("genres" => $genres));
        }

        return $movies;
    }

    public static function getTopRated()
    {
        $movies=array();
        $moviesar= Movie::orderBy("rating","desc")->paginate(25);
        $moviesar = json_decode(json_encode($moviesar), True);
        foreach ($moviesar['data'] as $key=>$movie){
            $genres=Movie::getGenres($movie['idMovie']);
            $movies[$key]=array_merge($movie,array("genres" => $genres));
        }
        return  $movies;
    }

    public static function getLatest()
    {
        $movies=array();
        $moviesar= Movie::where("releaseDate","<=",date("Y-m-d"))->orderBy("releaseDate","desc")->paginate(25);
        $moviesar = json_decode(json_encode($moviesar), True);
        foreach ($moviesar['data'] as $key=>$movie){
            $genres=Movie::getGenres($movie['idMovie']);
            $movies[$key]=array_merge($movie,array("genres" => $genres));
        }
        $movies= Movie::where("releaseDate","<=",date("Y-m-d"))->orderBy("releaseDate","desc")->get();
        return  $movies;
    }

    public static function getUpcomming()
    {
        $movies=array();
        $moviesar=Movie::where("releaseDate",">=",date("Y-m-d"))->orderBy("releaseDate","asc")->paginate(25);
        $moviesar = json_decode(json_encode($moviesar), True);

        foreach ($moviesar['data'] as $key=>$movie){
            $genres=Movie::getGenres($movie['idMovie']);
            $movies[$key]=array_merge($movie,array("genres" => $genres));
        }
        return  $movies;
    }

}

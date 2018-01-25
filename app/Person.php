<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
use App\Comment;
use App\Movie;

class Person extends Model
{
    //δηλώνουμε σε ποιόν πίνακα της βάσης θα βλέπει το συγκεκριμένο model
    protected $table = 'person';

    //επιστρέφει τα δεδομένα που έχουμε για έναν συντελεστή μεσα στον πίνακα movie με βάση το id
    public static function getInfo($id)
    {
        //Ψάχνει στην βάση στον πίνακα που έχουμε δηλώσει στο model Person εκεί που το πεδίο idPerson έχει την τιμή της
        // μεταβλήτης $id παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
       $info=Person::where('idPerson',$id)->get();
        $info = json_decode($info[0], True);
        return $info;
    }
    //επιστρέφει τις ταινίες που συμμετείχε ο ηθοποιός με βάση το id του
    public static function getPersonCast($id)
    {
        //Ψάχνει στην βάση στον πίνακα movie_person εκεί που το πεδίο personMovieId έχει την τιμή που βρίσκεται στην
        // μεταβλήτη $id και παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
        //Μέσα στο object είναι τα ids των ταινιών του συντελεστή.
        $moviestmp=DB::table('movie_person')->where('personMovieId',$id)->get();
        //μετατροπή του object σε πίνακα
        $movies = json_decode($moviestmp, True);
        //Δημιουργία του πίνακα που θα περιέχει τις ταινίες και τα δεδομένα τους
        $cast=array();
        foreach($movies as $movie){
            //Αν ο συντελεστης είναι ηθοποιός
            if($movie['part']=='cast'){
                //καλεί την function getMovie του model Movie
                $movietmp=Movie::getMovie($movie['moviePersonId']);
                //μετατροπή του object σε πίνακα
                $movietmp = json_decode($movietmp, True);
                //Βάζουμε τον χαρακτήρα του ηθοποιού στον πίνακα με τα δεδομένα της τρέχουσας ταινίας
                $movietmp[0]=array_merge($movietmp[0],array("character" => $movie['character']));
                //Βάζουμε τα δεδομένα της τρέχουσας ταινίας στον πίνακα με τις υπόλοιπες ταινίες
                $cast=array_merge($cast,$movietmp);
            }
        }
        //επιστρέφει τον πίνακα με όλες τις ταινίες που βρέθηκαν και τα δεδομένα τους
        return $cast;
    }
    //επιστρέφει τις ταινίες που συμμετείχε ο συντελεστής βάση το id του
    public static function getPersonCrew($id)
    {
        //Ψάχνει στην βάση στον πίνακα movie_person εκεί που το πεδίο personMovieId έχει την τιμή που βρίσκεται στην
        // μεταβλήτη $id και παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
        //Μέσα στο object είναι τα ids των ταινιών του συντελεστή.
        $moviestmp=DB::table('movie_person')->where('personMovieId',$id)->get();
        //μετατροπή του object σε πίνακα
        $movies = json_decode($moviestmp, True);
        //Δημιουργία του πίνακα που θα περιέχει τις ταινίες και τα δεδομένα τους
        $crew=array();
        foreach($movies as $movie){
            //Αν είναι άλλος συντελεστής (εκτός ηθοποιού)
            if($movie['part']=='crew'){
                //καλεί την function getMovie του model Movie
                $movietmp=Movie::getMovie($movie['moviePersonId']);
                //μετατροπή του object σε πίνακα
                $movietmp = json_decode($movietmp, True);
                //Βάζουμε τον χαρακτήρα του ηθοποιού στον πίνακα με τα δεδομένα της τρέχουσας ταινίας
                $movietmp[0]=array_merge($movietmp[0],array("character" => $movie['character']));
                //Βάζουμε τα δεδομένα της τρέχουσας ταινίας στον πίνακα με τις υπόλοιπες ταινίες
                $crew=array_merge($crew,$movietmp);
            }
        }
        //επιστρέφει τον πίνακα με όλες τις ταινίες που βρέθηκαν και τα δεδομένα τους
        return $crew;
    }

    public static function getPersonMovies($id)
    {
        //Ψάχνει στην βάση στον πίνακα movie_person εκεί που το πεδίο personMovieId έχει την τιμή που βρίσκεται στην
        // μεταβλήτη $id και παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
        //Μέσα στο object είναι τα ids των ταινιών του συντελεστή.
        $moviestmp=DB::table('movie_person')->where('personMovieId',$id)->get();
        //μετατροπή του object σε πίνακα
        $movies = json_decode($moviestmp, True);
        //Δημιουργία του πίνακα που θα περιέχει τις ταινίες και τα δεδομένα τους
        $crew=array();
        foreach($movies as $key=>$movie) {
            //καλεί την function getMovie του model Movie
            $movietmp = Movie::getMovie($movie['moviePersonId']);
            //μετατροπή του object σε πίνακα
            $movietmp = json_decode($movietmp, True);
            $moviegenres=Movie::getGenres($movie['moviePersonId']);
            $moviegenres = json_decode($moviegenres, True);
            //Βάζουμε τον χαρακτήρα του ηθοποιού στον πίνακα με τα δεδομένα της τρέχουσας ταινίας
            $movietmp[0] = array_merge($movietmp[0], $movie);
            $movietmp[0] = array_merge($movietmp[0], array("genres" => $moviegenres));
            //Βάζουμε τα δεδομένα της τρέχουσας ταινίας στον πίνακα με τις υπόλοιπες ταινίες


//            $movies[$key]['genres']=array();
//            $movies[$key]['genres']=array_merge($movies[$key]['genres'],$moviegenres);
            $crew = array_merge($crew, $movietmp);
        }

        //επιστρέφει τον πίνακα με όλες τις ταινίες που βρέθηκαν και τα δεδομένα τους
        return $crew;
    }

    //επιστρέφει τους ηθοποιούς μιας ταινίας με βάση το id της
    public static function getMovieCast($id)
    {
        //Ψάχνει στην βάση στον πίνακα movie_person εκεί που το πεδίο moviePersonId έχει την τιμή που βρίσκεται στην
        // μεταβλήτη $id και παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
        //Μέσα στο object είναι τα ids των ηθοποιών της ταινίας.
        $peopletmp=DB::table('movie_person')->where('moviePersonId',$id)->get();
        //μετατροπή του object σε πίνακα
        $people = json_decode($peopletmp, True);
        //Δημιουργία του πίνακα που θα περιέχει τους ηθοποιούς και τα δεδομένα τους
        $cast=array();
        foreach($people as $person){
            //Αν ο συντελεστης είναι ηθοποιός
            if($person['part']=='cast'){
                //Ψάχνει στην βάση στον πίνακα που έχουμε δηλώσει στο model Person εκεί που το πεδίο idPerson έχει την τιμή που βρίσκεται
                // στο πεδίο personMovieId του πίνακα $person και παίρνει όλα τα δεδομένα των πεδίων της βάσης εκείνης της εγγραφής και τα επιστρέφει σαν object.
                $persontmp=Person::where('idPerson',$person['personMovieId'])->get();
                //μετατροπή του object σε πίνακα
                $persontmp = json_decode($persontmp, True);
                //Βάζουμε τον χαρακτήρα του τρέχωντος ηθοποιού στον πίνακα με τα υπόλοιπα δεδομένα του
                $persontmp[0]=array_merge($persontmp[0],array("character" => $person['character']));
                //Βάζουμε τα δεδομένα του τρέχωντος ηθοποιού στον πίνακα με τους υπόλοιπους ηθοποιούς
                $cast=array_merge($cast,$persontmp);
            }
        }
        //επιστρέφει τον πίνακα με όλους τους ηθοποιούς που βρέθηκαν και τα δεδομένα τους
        return $cast;
    }

    public static function getMovieCrew($id)
    {
        //Ψάχνει στην βάση στον πίνακα movie_person εκεί που το πεδίο moviePersonId έχει την τιμή που βρίσκεται στην
        // μεταβλήτη $id και παίρνει όλα τα δεδομένα των πεδίων εκείνης της εγγραφής και τα επιστρέφει σαν object.
        //Μέσα στο object είναι τα ids των συντελεστών της ταινίας.
        $peopletmp=DB::table('movie_person')->where('moviePersonId',$id)->get();
        //μετατροπή του object σε πίνακα
        $people = json_decode($peopletmp, True);
        //Δημιουργία του πίνακα που θα περιέχει τους συντελεστές και τα δεδομένα τους
        $crew=array();
        foreach($people as $person){
            //Αν είναι άλλος συντελεστής (εκτός ηθοποιού)
            if($person['part']=='crew'){
                //Ψάχνει στην βάση στον πίνακα που έχουμε δηλώσει στο model Person εκεί που το πεδίο idPerson έχει την τιμή που βρίσκεται
                // στο πεδίο personMovieId του πίνακα $person και παίρνει όλα τα δεδομένα των πεδίων της βάσης εκείνης της εγγραφής και τα επιστρέφει σαν object.
                $persontmp=Person::where('idPerson',$person['personMovieId'])->get();
                //μετατροπή του object σε πίνακα
                $persontmp = json_decode($persontmp, True);
                //Βάζουμε τον χαρακτήρα του τρέχωντος συντελεστή στον πίνακα με τα υπόλοιπα δεδομένα του
                $persontmp[0]=array_merge($persontmp[0],array("character" => $person['character']));
                //Βάζουμε τα δεδομένα του τρέχωντος συντελεστή στον πίνακα με τους υπόλοιπους συντελεστές
                $crew=array_merge($crew,$persontmp);
            }
        }
        return $crew;
    }

}

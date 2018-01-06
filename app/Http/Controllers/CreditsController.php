<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Movie;
use App\User;
use App\Comment;
use App\Person;

use \Illuminate\Pagination\Paginator;

class CreditsController extends Controller
{
    function allcast($firstChar){
        $alphabet=array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","misc");
        $firstChar=strtolower($firstChar);
        if(!(in_array($firstChar, $alphabet) || ( filter_var($firstChar, FILTER_VALIDATE_INT) && ($firstChar<=9 && $firstChar>=0)))){
            if(strlen($firstChar)!==1) {
                $firstChar = substr($firstChar, 0, 1);
                return redirect(route('allcast',array($firstChar)));
            }
        }
        if(in_array($firstChar, $alphabet)) {
            if($firstChar=='misc'){
                $cast = Person::where('name', 'not REGEXP',  '^[a-zA-Z]')->get();
            }else {
                $cast = Person::where('name', 'LIKE', $firstChar . '%')->get();
            }
        }else{
            abort(404);
        }
        $credits=array();
        foreach($cast as $person){
            $rolecheck=DB::table('movie_person')->where([
                ['personMovieId',$person->idPerson],
                ['part','cast'],
            ])->get();
            if(isset($rolecheck[0])){
                array_push($credits,$person);
            }
        }
//        Paginator::currentPageResolver(function() use ($currentPage) {
//            return $currentPage;
//        });
        $credits= paginate($credits,90)->setPath(route('allcast',array($firstChar)));
//        return $credits;
        $creditype='cast';
        return view('credits.allcredits',compact('credits','alphabet','firstChar','creditype'));

    }


    function allcrew($firstChar){
        $alphabet=array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","misc");
        $firstChar=strtolower($firstChar);
        if(!(in_array($firstChar, $alphabet) || ( filter_var($firstChar, FILTER_VALIDATE_INT) && ($firstChar<=9 && $firstChar>=0)))){
            if(strlen($firstChar)!==1) {
                $firstChar = substr($firstChar, 0, 1);
                return redirect(route('allcast',array($firstChar)));
            }
        }
        if(in_array($firstChar, $alphabet)) {
            if($firstChar=='misc'){
                $crew = Person::where('name', 'not REGEXP',  '^[a-zA-Z]')->get();
            }else {
                $crew = Person::where('name', 'LIKE', $firstChar . '%')->get();
            }
        }else{
            abort(404);
        }
        $credits=array();
        foreach($crew as $person){
            $rolecheck=DB::table('movie_person')->where([
                ['personMovieId',$person->idPerson],
                ['part','crew'],
            ])->get();
            if(isset($rolecheck[0])){
                array_push($credits,$person);
            }
        }
//        Paginator::currentPageResolver(function() use ($currentPage) {
//            return $currentPage;
//        });
        $credits= paginate($credits,90)->setPath(route('allcast',array($firstChar)));

        $creditype='crew';
        return view('credits.allcredits',compact('credits','alphabet','firstChar','creditype'));
    }
}

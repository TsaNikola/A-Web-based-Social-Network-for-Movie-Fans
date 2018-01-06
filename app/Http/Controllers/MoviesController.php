<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Pagination\Paginator;
use DB;
use App\Movie;
use App\User;
use App\Comment;
use App\Person;

class MoviesController extends Controller
{
    function movie($id)
    {
        //Καλούμε την function getAll από το model με όνομα Movie. Όλα τα models βρίσκονται στον φάκελο App (πχ. Movie.php)
        $movie= Movie::getAll($id);
        //παίρνουμε το object με τις ταπετσαρίες και του μετατρέπουμε σε πίνακα για να μπορέσουμε να δουλεψουμε με τις έτοιμες λειτουργίες που έχει η php για πίνακες
        $backgrounds= $movie['wallpapers'];
        $backgrounds = json_decode($backgrounds, True);

        //Με την παρακάτω εντολή το function ψάχνει μέσα στον φάκελο resources/views το αρχείο με όνομα movie.blade.php και το επιστρέφει για εμφάνιση στον περιηγητή
        //Στο compact() αναφέρουμε τα ονόματα από τις μεταβλητές και τα δεδομένα που θέλουμε (πχ πίνακες) και περνάνε στο αντίστοιχο blade αρχείο
        return view('movies.movie',compact('movie','backgrounds'));
    }
    function popular(){
        $movies = Movie::orderBy("popularity", "desc")->paginate(25);
//        $moviesar = json_decode(json_encode($movies), True);
        foreach ($movies as $key => $movie) {
            $genres = collect(array("genres"=>Movie::getGenres($movie['idMovie'])));
            $movies[$key] = $genres->merge($movies[$key]);
//            $moviesar['data'][$key]= array_merge($moviesar['data'][$key], array("genres" => $genres));
        }
        $allgenres=Movie::getAllGenres();
//        $movies= collect($movies);

//        $custom = collect(['my_data' => 'My custom data here']);
        $genres=array();
        $currentPage =1;
        $order="popularity";
        $fromYear='1900';
        $list="popular";
        $toYear=date("Y");
        return view('movies.movielist',compact('movies','moviesar','allgenres','order','genres','currentPage','fromYear','toYear','list'));

}

    function toprated(){
        $movies = Movie::orderBy("rating", "desc")->paginate(25);
//        $moviesar = json_decode(json_encode($movies), True);
        foreach ($movies as $key => $movie) {
            $genres = collect(array("genres"=>Movie::getGenres($movie['idMovie'])));
            $movies[$key] = $genres->merge($movies[$key]);
//            $moviesar['data'][$key]= array_merge($moviesar['data'][$key], array("genres" => $genres));
        }
        $allgenres=Movie::getAllGenres();
//        $movies= collect($movies);

//        $custom = collect(['my_data' => 'My custom data here']);
        $genres=array();
        $currentPage =1;
        $order="rating";
        $list="toprated";
        $fromYear='1900';
        $toYear=date("Y");
        return view('movies.movielist',compact('movies','moviesar','allgenres','order','genres','currentPage','fromYear','toYear','list'));

    }

    function latest(){
        $movies = Movie::orderBy("releaseDate", "desc")->paginate(25);
//        $moviesar = json_decode(json_encode($movies), True);
        foreach ($movies as $key => $movie) {
            $genres = collect(array("genres"=>Movie::getGenres($movie['idMovie'])));
            $movies[$key] = $genres->merge($movies[$key]);
//            $moviesar['data'][$key]= array_merge($moviesar['data'][$key], array("genres" => $genres));
        }
        $allgenres=Movie::getAllGenres();
//        $movies= collect($movies);

//        $custom = collect(['my_data' => 'My custom data here']);
        $genres=array();
        $currentPage =1;
        $order="releaseDate";
        $fromYear='1900';
        $list="latest";
        $toYear=date("Y");
        return view('movies.movielist',compact('movies','moviesar','allgenres','order','genres','currentPage','fromYear','toYear','list'));

    }

    function upcomming(){
        $movies = Movie::where('releaseDate','>=',date("Y-m-d",time()))->orderBy("releaseDate", "asc")->paginate(25);
//        $moviesar = json_decode(json_encode($movies), True);
        $toYear=date("Y");
        foreach ($movies as $key => $movie) {
            $genres = collect(array("genres"=>Movie::getGenres($movie['idMovie'])));
            $movies[$key] = $genres->merge($movies[$key]);
//            $moviesar['data'][$key]= array_merge($moviesar['data'][$key], array("genres" => $genres));
            if(substr($movie['releaseDate'],0,4)> $toYear){
                $toYear=substr($movie['releaseDate'],0,4);
            }
        }
        $allgenres=Movie::getAllGenres();
//        $movies= collect($movies);

//        $custom = collect(['my_data' => 'My custom data here']);
        $genres=array();
        $currentPage =1;
        $order="upcomming";
        $list="upcomming";
        $fromYear='1900';

        return view('movies.movielist',compact('movies','moviesar','allgenres','order','genres','currentPage','fromYear','toYear','list'));

    }


    function postMovielist(Request $request){
        $allgenres=Movie::getAllGenres();
        $data=$request->all();
//        return $data;
        $fromYear=$data['fromyear'];
        $toYear=$data['toyear'];
        if($fromYear>$toYear){
            $fromYear=$data['toyear'];
            $toYear=$data['fromyear'];
        }
        $genres=array();
        if(isset($data['genres'])) {
            $genres = $data['genres'];
        }
        $list=$data['pagelist'];
        $order=$data['order'];
//        $moviesar = array('current_page'=>$page,'data'=>array(),'first_page_url'=>route('popular',array('page'=>$page)),'from'=>'','last_page'=>'','last_page_url'=>'','next_page_url'=>'','path'=>route('home'),'per_page'=>'','prev_page_url'=>'','to'=>'','total'=>'');
        $movies=array();
        if(isset($genres[0]) && ($fromYear!=1900 || $toYear!=date("Y"))){
//            $genres=array('action');
            $moviesartemp = Movie::findGenres($genres);
            $sort = array();
            foreach ($moviesartemp as $key => $row)
            {
                if($order=='upcomming') {
                    $sort[$key] = $row['releaseDate'];
                }else{
                    $sort[$key] = $row[$order];
                }
            }
            $movids=array();
            if($order=='upcomming') {
                array_multisort($sort, SORT_ASC, $moviesartemp);
            }else{
                array_multisort($sort, SORT_DESC, $moviesartemp);
            }
            foreach($moviesartemp as $key=>$movie){
                $yearar=explode('-',$movie['releaseDate']);
                if($yearar[0]>=$fromYear && $yearar[0]<=$toYear){
                    if(!in_array($movie['idMovie'],$movids)) {
                        array_push($movids, $movie['idMovie']);
                        if ($order == 'upcomming') {
                            if ($movie['releaseDate'] >= date("Y-m-d", time())) {
                                array_push($movies, $movie);
                            }
                        } else {
                            array_push($movies, $movie);
                        }
                    }
                }
            }

        }elseif($fromYear!=1900 || $toYear!=date("Y")){


            if($order=='upcomming'){
                $movies = Movie::where([
                    ["releaseDate",">=","$fromYear-1-1"],
                    ["releaseDate","<=","$toYear-12-31"],
                    ["releaseDate",">=",date("Y-m-d",time())],
                ])->orderBy('releaseDate','asc')->get();
            }else{
                $movies = Movie::where([
                    ["releaseDate",">=","$fromYear-1-1"],
                    ["releaseDate","<=","$toYear-12-31"],
                ])->orderBy($order,'desc')->get();
            }

//return $moviesartemp;
             foreach($movies as $key=>$movie){
               $moviegenres=Movie::getGenres($movie['idMovie']);
                 $moviegenres = json_decode(($moviegenres), True);
                 $movies[$key]['genres']=array();
                 $movies[$key]['genres']=array_merge($movies[$key]['genres'],$moviegenres);


             }
//            return $movies;
        }elseif(isset($genres[0])){
            $moviesartemp = Movie::findGenres($genres);
            $sort = array();
            foreach ($moviesartemp as $key => $row)
            {
                if($order=='upcomming') {
                    $sort[$key] = $row['releaseDate'];
                }else{
                    $sort[$key] = $row[$order];
                }
            }
            if($order=='upcomming') {
                array_multisort($sort, SORT_ASC, $moviesartemp);
            }else{
                array_multisort($sort, SORT_DESC, $moviesartemp);
            }
            $movids=array();
            foreach($moviesartemp as $key=>$movie){
                if(!in_array($movie['idMovie'],$movids)) {
                    array_push($movids, $movie['idMovie']);
                    if ($order == 'upcomming') {
                        if ($movie['releaseDate'] >= date("Y-m-d", time())) {
                            array_push($movies, $movie);
                        }
                    } else {
                        array_push($movies, $movie);
                    }
                }
            }


        }else{
            return redirect()->route($list);
        }
        $currentPage=1;
        if (isset($data['page'])) {
            $currentPage=$data['page'];
        }
       Paginator::currentPageResolver(function() use ($currentPage) {
            return $currentPage;
        });
            $movies= paginate($movies,25);
//        return  $movies;


        return view('movies.movielist',compact('movies','allgenres','genres','currentPage','order','fromYear','toYear','list'));

    }

    function allmovies(){
        $movies=array();
        $allgenres=array();
        $moviesar=Movie::paginate(25);
        $moviesar = json_decode(json_encode($moviesar), True);

        foreach ($moviesar['data'] as $key=>$movie){
            $genres=Movie::getGenres($movie['idMovie']);
            $movies[$key]=array_merge($movie,array("genres" => $genres));
            foreach ($genres as $genre) {
                array_push($allgenres, $genre);
            }
        }
        $allgenres=array_unique($allgenres);
        return $allgenres;
//        foreach
//        return $movies;
    }
}

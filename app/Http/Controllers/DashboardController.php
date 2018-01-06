<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Banner;
use DB;
use \Input as Input;
use App\Quotation;
use \Illuminate\Foundation\Exceptions\Handler;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Admin;
use Image;
use App\Site;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;





class DashboardController extends Controller
{
    public function fillDB($from='',$to=''){


        $apiKey='ca6195d93c2383688c52a44efc497f26';
        $popUrl='https://api.themoviedb.org/3/movie/popular?api_key='.$apiKey;

        $page=1;
        $total_pages=1000;

        if($from!='' || $from=0){
            $page=$from;
        }

        if($to!='' || $to=0){
            $total_pages=$to;
        }

        function getTmdbData($url){
            $i=0;
            $results="";
            while($results=="" && $i<=20){
                sleep(2);
                $results=file_get_contents($url);
                $i++;
                if($results=='') {
                    sleep(5);
                }
            }
            return $results;
        }


        function movieImport($tmdbid)
        {
            $errortxt = '';
            $url = "http://api.themoviedb.org/3/movie/$tmdbid?api_key=ca6195d93c2383688c52a44efc497f26";
//echo "$url<br>";
            $content = getTmdbData($url);
            if ($content != '') {
                $movieInfo = json_decode($content);
                $title = $movieInfo->title;
                if ($title === NULL) {
                    $title = '';
                }
                $description = $movieInfo->overview;
                if ($description === NULL) {
                    $description = '';
                }
                $poster = $movieInfo->poster_path;

                if ($poster === NULL) {
                    $poster = '';
                }


                $rating = $movieInfo->vote_average;
                if ($rating === NULL) {
                    $rating = '';
                }
                $popularity = $movieInfo->popularity;
                if ($popularity === NULL) {
                    $popularity = '';
                }
                $releaseDate = $movieInfo->release_date;


                DB::table('movie')->insert([
                    'tmdbId' => $tmdbid,
                    'description' => $description,
                    'poster' => $poster,
                    'title' => $title,
                    'releaseDate' => $releaseDate,
                    'rating' => $rating,
                    'popularity' => $popularity
                ]);
                echo "<br><hr><br>[$tmdbid] $title ($releaseDate)-->IMPORT<br>
description:$description<br>
rating:$rating, popularity:$popularity, poster:$poster<br>
";
                $movieDbId = DB::table('movie')->where('tmdbId', $tmdbid)->value('idMovie');

                $wurl = "http://api.themoviedb.org/3/movie/$tmdbid/images?api_key=ca6195d93c2383688c52a44efc497f26";
                $content = getTmdbData($wurl);
                if ($content != '') {
                    $wallpapers = json_decode($content);
                    echo "wallpapers:<br>";
                    foreach ($wallpapers->backdrops as $wallpaper) {
                        $wallpaperExists = DB::table('wallpaper')->where('filename', $wallpaper->file_path)->get();
                        if(!isset($wallpaperExists[0])) {
                            DB::table('wallpaper')->insert([
                                'filename' => $wallpaper->file_path,
                                'movieWallpaperId' => $movieDbId
                            ]);
                            echo $wallpaper->file_path . "<br>";
                        }
                    }

                } else {
                    if ($errortxt == '') {
                        $errortxt = '<center>';
                    }
                    $errortxt .= "Failed to get TMDB data about images for $tmdbid<br>";
                    echo "Failed to get TMDB data about images for $tmdbid<br>";
                }

                $purl = "http://api.themoviedb.org/3/movie/$tmdbid/credits?api_key=8bd247a8ea746fe24d32b57de4256438";
                $content = getTmdbData($purl);
                if ($content != '') {
                    $people = json_decode($content);
                    foreach ($people->cast as $actor) {
                        $personExists = DB::table('person')->where('tmdbid', $actor->id)->get();
                        if (!isset($personExists[0])) {
                            personImport($actor->id);
                        }
                        $personDbId = DB::table('person')->where('tmdbid', $actor->id)->value('idPerson');
                        if ($personDbId != '') {
                            $moviePersonExists = DB::table('movie_person')->where([
                                ['moviePersonId', $personDbId],
                                ['personMovieId', $movieDbId],
                            ])->get();
                            if(!isset($moviePersonExists[0])) {
                                DB::table('movie_person')->insert([
                                    'moviePersonId' => $movieDbId,
                                    'personMovieId' => $personDbId,
                                    'part' => 'cast',
                                    'character' => $actor->character
                                ]);
                                echo '->as ' . $actor->character . "<br>";
                            }
                        }
                    }
                    foreach ($people->crew as $member) {
                        $personExists = DB::table('person')->where('tmdbid', $member->id)->get();
                        if (!isset($personExists[0])) {
                            personImport($member->id);
                        }
                        $personDbId = DB::table('person')->where('tmdbid', $member->id)->value('idPerson');
                        if ($personDbId != '') {
                            $moviePersonExists = DB::table('movie_person')->where([
                                ['moviePersonId', $personDbId],
                                ['personMovieId', $movieDbId],
                            ])->get();
                            if(!isset($moviePersonExists[0])) {
                                DB::table('movie_person')->insert([
                                    'moviePersonId' => $movieDbId,
                                    'personMovieId' => $personDbId,
                                    'part' => 'crew',
                                    'character' => $member->job
                                ]);
                                echo '->as ' . $member->job . "<br>";
                            }
                        }
                    }
                } else {
                    if ($errortxt == '') {
                        $errortxt = '
           ';
                    }
                    $errortxt .= "Failed to get TMDB data about cast for $tmdbid
             ";
                    echo "Failed to get TMDB data about cast for $tmdbid";
                }

                echo "genres: ";
                foreach ($movieInfo->genres as $genre) {

                    DB::table('movie_genre')->insert([
                        'genreMovieId' => $movieDbId,
                        'genreName' => $genre->name
                    ]);
                    echo $genre->name . ", ";
                }
                echo "<br>";
                $url = "http://api.themoviedb.org/3/movie/$tmdbid/videos?api_key=8bd247a8ea746fe24d32b57de4256438";
                $content = getTmdbData($url);
                if ($content != '') {
                    $trailers = json_decode($content);
                    echo "trailers: ";
                    foreach ($trailers->results as $trailer) {
                        if ($trailer->site == "YouTube" && $trailer->type == "Trailer") {
                            DB::table('trailer')->insert([
                                'movieTrailerId' => $movieDbId,
                                'filename' => $trailer->key,
                                'tag' => $trailer->name
                            ]);
                            echo "<br>" . $trailer->name;
                        }
                    }
                } else {
                    if ($errortxt == '') {
                        $errortxt = '
        ';
                    }
                    $errortxt .= "Failed to get TMDB data about trailers for $tmdbid
             ";
                    echo "Failed to get TMDB data about trailers for $tmdbid";
                }
            } else {

                if ($errortxt == '') {
                    $errortxt = '<center>';
                }
                $errortxt .= "Failed to get TMDB data in general<br>";
                echo "Failed to get TMDB data in general<br>";
            }
//            return $errortxt;
        }


        function movieUpdate($tmdbid)
            {

                $errortxt = '';
                $movieDbId = DB::table('movie')->where('tmdbId', $tmdbid)->value('idMovie');
                $url = "http://api.themoviedb.org/3/movie/$tmdbid?api_key=ca6195d93c2383688c52a44efc497f26";
                $content = getTmdbData($url);
                if ($content != '') {
                    $movieInfo = json_decode($content);
                    $title = $movieInfo->title;

                    if ($title === NULL) {
                        $title = '';
                    }

                    $description = $movieInfo->overview;
                    if ($description === NULL) {
                        $description = '';
                    }

                    $poster = $movieInfo->poster_path;
                    if ($poster === NULL) {
                        $poster = '';
                    }

                    $url = "http://api.themoviedb.org/3/movie/$tmdbid/images?api_key=ca6195d93c2383688c52a44efc497f26";
                    $wallpapers = '';
                    $content = '';
                    $content = getTmdbData($url);
                    if ($content != '') {
                        $wallpapers = json_decode($content);
                        foreach ($wallpapers->backdrops as $wallpaper) {
                            $wallpaperExists = DB::table('wallpaper')->where('filename', $wallpaper->file_path)->get();
                            if (!isset($wallpaperExists[0])) {
                                DB::table('wallpaper')->insert([
                                    'filename' => $wallpaper->file_path,
                                    'movieWallpaperId' => $movieDbId
                                ]);
                            }
                        }
                    } else {

                        if ($errortxt == '') {
                            $errortxt = '
        ';
                        }
                        $errortxt .= "Failed to get TMDB data about images for $tmdbid
             ";
                    }


                    if ($movieInfo->genres != '') {
                        foreach ($movieInfo->genres as $genre) {
                            $genreExists = DB::table('movie_genre')->where([
                                ['genreMovieId', $movieDbId],
                                ['genreName', $genre->name],
                            ])->get();
                            if (!isset($genreExists[0])) {
                                DB::table('movie_genre')->insert([
                                    'genreMovieId' => $movieDbId,
                                    'genreName' => $genre->name,
                                ]);
                            }
                        }
                    }

                    $rating = $movieInfo->vote_average;
                    if ($rating === NULL) {
                        $rating = 0;
                    }

                    $popularity = $movieInfo->popularity;
                    if ($popularity === NULL) {
                        $popularity = 0;
                    }


                    $releaseDate = $movieInfo->release_date;
                    if ($releaseDate == '') {
                        $releaseDate = NULL;
                    }

                    $url = "http://api.themoviedb.org/3/movie/$tmdbid/videos?api_key=8bd247a8ea746fe24d32b57de4256438";
                    $content = getTmdbData($url);
                    if ($content != '') {
                        $trailers = json_decode($content);
                        foreach ($trailers->results as $trailer) {
                            if ($trailer->site == "YouTube" && $trailer->type == "Trailer") {
                                $trailerExists = DB::table('trailer')->where([
                                    ['movieTrailerId', $movieDbId],
                                    ['filename', $trailer->key],
                                    ['tag', $trailer->name],
                                ])->get();
                                if (!isset($trailerExists[0])) {
                                    DB::table('trailer')->insert([
                                        'movieTrailerId' => $movieDbId,
                                        'filename' => $trailer->key,
                                        'tag' => $trailer->name
                                    ]);
                                }
                            }
                        }
                    } else {
                        if ($errortxt == '') {
                            $errortxt = '
        ';
                        }
                        $errortxt .= "Failed to get TMDB data about trailers for $tmdbid
             ";
                    }

                    if ($title != '') {
                        DB::table('movie')
                            ->where([
                                ['idMovie', $movieDbId],
                            ])->update([
                                'title' => $title,
                            ]);
                    }

                    echo "[$tmdbid] $title ($releaseDate)---->Updated";
//                    return 'ok';
                    DB::table('movie')
                        ->where([
                            ['idMovie', $movieDbId],
                        ])->update([
                            'tmdbId' => $tmdbid,
                            'poster' => $poster,
                            'description' =>$description,
                            'releaseDate' => $releaseDate,
                            'rating' => $rating,
                            'popularity' => $popularity
                        ]);
//                    return 'ok';
                    $url = "http://api.themoviedb.org/3/movie/$tmdbid/credits?api_key=ca6195d93c2383688c52a44efc497f26";
                    $content = getTmdbData($url);
                    if ($content != '') {
                        $people = json_decode($content);

                        foreach ($people->cast as $actor) {
                            $personExists = DB::table('person')->where('tmdbid', $actor->id)->get();
                            if (!isset($personExists[0])) {
                                personImport($actor->id);
                            } else {
//                                personUpdate($actor->id);
                            }
                            $personDbId = DB::table('person')->where('tmdbid', $actor->id)->value('idPerson');
                            $personMovie = DB::table('movie_person')->where([
                                ['personMovieId', $personDbId],
                                ['moviePersonId', $movieDbId],
                            ])->get();
                            if (!isset($personMovie[0])) {
                                DB::table('movie_person')->insert([
                                    'moviePersonId' => $movieDbId,
                                    'personMovieId' => $personDbId,
                                    'part' => 'cast',
                                    'character' => $actor->character
                                ]);
                                echo $actor->name .'->as ' . $actor->character . "<br>";
                            }
                        }
                        foreach ($people->crew as $member) {
                            $personExists = DB::table('person')->where('tmdbid', $member->id)->get();
                            if (!isset($personExists[0])) {
                                personImport($member->id);
                            } else {
//                                personUpdate($member->id);
                            }
                            $personDbId = DB::table('person')->where('tmdbid', $member->id)->value('idPerson');

                            $personMovie = DB::table('movie_person')->where([
                                ['personMovieId', $personDbId],
                                ['moviePersonId', $movieDbId],
                            ])->get();

                            if (!isset($personMovie[0])) {
                                DB::table('movie_person')->insert([
                                    'moviePersonId' => $movieDbId,
                                    'personMovieId' => $personDbId,
                                    'part' => 'crew',
                                    'character' => $member->job
                                ]);
                                echo  $member->name .'->as ' . $member->job . "<br>";
                            }
                        }
                    } else {

                        if ($errortxt == '') {
                            $errortxt = '
        ';
                        }
                        $errortxt .= "Failed to get TMDB data for cast
             ";
                    }

                } else {

                    if ($errortxt == '') {
                        $errortxt = '
        ';
                    }
                    $errortxt .= "Failed to get TMDB data in general
             ";
                }

                // if($errortxt!=''){$errortxt.='</center>';}
//                return $errortxt;

            }


        function personImport($id)
            {

                $url = "http://api.themoviedb.org/3/person/$id?api_key=ca6195d93c2383688c52a44efc497f26";

                $content = getTmdbData($url);

                if ($content != '') {
                    $personInfo = json_decode($content);
                    $name = $personInfo->name;
                    if(isset($personInfo->place_of_birth)) {
                        $birthplace = $personInfo->place_of_birth;
                    }else{
                        $birthplace='';
                    }
                    if(isset($personInfo->birthday)) {
                        $birthday=null;
                        if(stripos($personInfo->birthday,'-')!==false){
                            $birthday = $personInfo->birthday;
                        }
                    }else{
                        $birthday=null;
                    }
                    $picture = $personInfo->profile_path;
                    $biography = $personInfo->biography;
                    if(isset($personInfo->homepage)) {
                        $website=$personInfo->homepage;
                    }else{
                        $website='';
                    }
                    echo "-  -  -  -  -  -  -  -  -  -  -  -  <br>
[$id] $name ($birthday)--->IMPORT<br>
birthplace:$birthplace, picture:$picture, website:$website<br>
bio:$biography<br>
-  -  -  -  -  -  -  -  -  -  -  -";
                    DB::table('person')->insert([
                        'tmdbId' => $id,
                        'name' => $name,
                        'birthplace' => $birthplace,
                        'birthday' => $birthday,
                        'biography' => $biography,
                        'picture' => $picture,
                        'website' => $website,
                    ]);

                }
            }


        function personUpdate($id){

            $url="http://api.themoviedb.org/3/person/$id?api_key=ca6195d93c2383688c52a44efc497f26";
            $personDbId=DB::table('person')->where('tmdbId',$id)->value('idPerson');

            $content=getTmdbData($url);

            if($content!='') {
                $personInfo = json_decode($content);
                $name=$personInfo->name;
                if(isset($personInfo->birthday)) {
                    $birthday=null;
                    if(stripos($personInfo->birthday,'-')!==false){
                        $birthday = $personInfo->birthday;
                    }
                }else{
                    $birthday=null;
                }
                if(isset($personInfo->place_of_birth)) {
                    $birthplace = $personInfo->place_of_birth;
                }else{
                    $birthplace='';
                }
                $picture=$personInfo->profile_path;
                $biography=$personInfo->biography;
                if(isset($personInfo->homepage)) {
                    $website=$personInfo->homepage;
                }else{
                    $website='';
                }


                echo "-  -  -  -  -  -  -  -  -  -  -  -  <br>
[$id] $name ($birthday)--->Updated
-  -  -  -  -  -  -  -  -  -  -  -";

                DB::table('person')  ->where([
                    ['idMovie', $personDbId],
                ])->update([
                    'tmdbId' =>$id,
                    'name' =>$name,
                    'birthday' =>$birthday,
                    'birthplace' =>$birthplace,
                    'biography' =>$biography,
                    'picture' =>$picture,
                    'website' =>$website,
                ]);

            }


        }


        while($page<=$total_pages) {


            $pageurl = $popUrl . "&page=" . $page;
            $cont = getTmdbData($pageurl);
            if ($cont != '') {
                ECHO $pageurl."<br><br>";
                $pagecont = json_decode($cont);

                if ($pagecont->total_pages != '' && $to=='') {
                    $total_pages = $pagecont->total_pages;
                }
                foreach ($pagecont->results as $movie) {
                    $MovieExists = DB::table('movie')->where('tmdbid', $movie->id)->get();
                    if (!isset($MovieExists[0])) {
//                        return $MovieExists;
                        movieImport($movie->id);
                    } else {
                        movieUpdate($movie->id);
//                        echo $movie->title." already exists<br>";
                    }
                }
            }
//            return $cont;
            $page++;
        }
//        return view('fillDB',compact(''));
    }
}
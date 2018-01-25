<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
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
use App\Movie;
use App\Person;
use Illuminate\Support\Facades\Hash;



class DashboardController extends Controller
{

    public function editMovies( Request $request){



        function getTmdbData($url)
        {
            $i = 0;
            $results = "";
            $headers = get_headers($url);
            $response= substr($headers[0], 9, 3);

                while ($results == "" && $i <= 20 && $response!='404') {
                    sleep(2);
                    if ($response=='200') {
                        $results = file_get_contents($url);
                    }
                    $i++;
                    if ($results == '') {
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

                if($releaseDate!='' && $title!='') {
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
                            if (!isset($wallpaperExists[0])) {
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

                    $purl = "http://api.themoviedb.org/3/movie/$tmdbid/credits?api_key=ca6195d93c2383688c52a44efc497f26";
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
                                if (!isset($moviePersonExists[0])) {
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
                                if (!isset($moviePersonExists[0])) {
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
                    $url = "http://api.themoviedb.org/3/movie/$tmdbid/videos?api_key=ca6195d93c2383688c52a44efc497f26";
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
                $releaseDate = $movieInfo->release_date;
                if ($releaseDate == '') {
                    $releaseDate = NULL;
                }

                if($releaseDate!='' && $title!='') {
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



                    $url = "http://api.themoviedb.org/3/movie/$tmdbid/videos?api_key=ca6195d93c2383688c52a44efc497f26";
                    $content = getTmdbData($url);
                    if ($content != '') {
                        $trailers = json_decode($content);
                        foreach ($trailers->results as $trailer) {
                            if ($trailer->site == "YouTube" && $trailer->type == "Trailer") {
                                $trailerExists = DB::table('trailer')->where([
                                    ['movieTrailerId', $movieDbId],
                                    ['filename', $trailer->key],
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
                            'description' => $description,
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
                                echo $actor->name . '->as ' . $actor->character . "<br>";
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
                                echo $member->name . '->as ' . $member->job . "<br>";
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
                if (isset($personInfo->place_of_birth)) {
                    $birthplace = $personInfo->place_of_birth;
                } else {
                    $birthplace = '';
                }
                if (isset($personInfo->birthday)) {
                    $birthday = null;
                    if (stripos($personInfo->birthday, '-') !== false) {
                        $birthday = $personInfo->birthday;
                    }
                } else {
                    $birthday = null;
                }
                $picture = $personInfo->profile_path;
                $biography = $personInfo->biography;
                if (isset($personInfo->homepage)) {
                    $website = $personInfo->homepage;
                } else {
                    $website = '';
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


        function personUpdate($id)
        {

            $url = "http://api.themoviedb.org/3/person/$id?api_key=ca6195d93c2383688c52a44efc497f26";
            $personDbId = DB::table('person')->where('tmdbId', $id)->value('idPerson');

            $content = getTmdbData($url);

            if ($content != '') {
                $personInfo = json_decode($content);
                $name = $personInfo->name;
                if (isset($personInfo->birthday)) {
                    $birthday = null;
                    if (stripos($personInfo->birthday, '-') !== false) {
                        $birthday = $personInfo->birthday;
                    }
                } else {
                    $birthday = null;
                }
                if (isset($personInfo->place_of_birth)) {
                    $birthplace = $personInfo->place_of_birth;
                } else {
                    $birthplace = '';
                }
                $picture = $personInfo->profile_path;
                $biography = $personInfo->biography;
                if (isset($personInfo->homepage)) {
                    $website = $personInfo->homepage;
                } else {
                    $website = '';
                }


                echo "-  -  -  -  -  -  -  -  -  -  -  -  <br>
[$id] $name ($birthday)--->Updated
-  -  -  -  -  -  -  -  -  -  -  -";

                DB::table('person')->where([
                    ['idMovie', $personDbId],
                ])->update([
                    'tmdbId' => $id,
                    'name' => $name,
                    'birthday' => $birthday,
                    'birthplace' => $birthplace,
                    'biography' => $biography,
                    'picture' => $picture,
                    'website' => $website,
                ]);

            }


        }


        $editmov='0';
        $backgrounds='';
        $title='';
        $updatemov='0';
        $deletemov='0';
        $dbid=0;
        $error=0;
        $apiKey = 'ca6195d93c2383688c52a44efc497f26';
        $errortxt='';
        $input = $request->all();
        if(isset($input['getlist'])) {
            $listtype = $input['listtype'];
            $listjob = $input['listjob'];


            $popUrl = 'https://api.themoviedb.org/3/movie/' . $listtype . '?api_key=' . $apiKey;

            $page = 1;
            $total_pages = 1000;




            while ($page <= $total_pages) {


                $pageurl = $popUrl . "&page=" . $page;
                $cont = getTmdbData($pageurl);
                if ($cont != '') {
                    ECHO $pageurl . "<br><br>";
                    $pagecont = json_decode($cont);

                    if ($pagecont->total_pages != '') {
                        $total_pages = $pagecont->total_pages;
                    }
                    foreach ($pagecont->results as $movie) {
                        $MovieExists = DB::table('movie')->where('tmdbId', $movie->id)->get();
                        if (!isset($MovieExists[0]) && $listjob == 'import') {
//                        return $MovieExists;
                            movieImport($movie->id);
                        } elseif ($listjob == 'update') {
                            movieUpdate($movie->id);
//                        echo $movie->title." already exists<br>";
                        }
                    }
                }
//            return $cont;
                $page++;
            }
        }
        if(isset($input['getall'])) {
            $alljob = $input['alljob'];


         if($alljob=='updateall'){

             $movies=DB::table('movie')->get();
             foreach($movies as $movie){
                 movieUpdate($movie->tmdbId);
             }
         }else{
             $latesturl="https://api.themoviedb.org/3/movie/latest?api_key=$apiKey";
             $cont = getTmdbData($latesturl);
             $pagecont = json_decode($cont);
             $lastid=$pagecont->id;
             $currentid=1;
             while($lastid>=$currentid) {
                 $MovieExists = DB::table('movie')->where('tmdbId', $currentid)->get();
                 if (!isset($MovieExists[0]) ) {
                     movieImport($currentid);
                 }
             }
         }
        }
        if(isset($input['editmovie']) || isset($input['editsubmit'])){
            $editmov='1';
            $allgenres=Movie::getAllGenres();
            $dbid=$input['dbid'];
            $movie=Movie::getAll($dbid);
            if(count($movie)>0 ){
                $backgrounds = $movie['wallpapers'];
                $title = $movie['title'];
                $backgrounds = json_decode($backgrounds, True);
                if(isset($_POST['editsubmit'])){
//                    $input = $request->all();
//                    return $input;

                    DB::table('movie')
                        ->where('idMovie', $input['dbid'])
                        ->update([
                            'title' =>  $input['title'],
                            'tmdbId' =>  $input['tmdbid'],
                            'rating' =>  $input['rating'],
                            'popularity' =>  $input['popularity'],
                            'releaseDate' =>  $input['releasedate'],
                            'poster' =>  $input['poster'],
                            'description' =>  $input['description'],
                        ]);
                    DB::table('movie_genre')->where('genreMovieId',$input['dbid'])->delete;

                    foreach($input['movie_genre'] as $genre){
                        DB::table('movie')
                            ->insert([
                                'genreMovieId' =>  $input['dbid'],
                                'genreName' =>  $input['$genre'],

                            ]);
                    }
                    $movie=Movie::getAll($dbid);
                }
            }else{
                $error=1;

                $errortxt.="No Movie found with ID = $dbid";
            }
           
        }
        if(isset($input['updatemovie'])){
            $updatemov='1';
            $tmdbid=DB::table('movie')->where('idMovie',$input['dbid'])->value('tmdbId');
            // $tmdb= $tmdbid;
            $movie=DB::table('movie')->where('tmdbId', '=', $tmdbid)->get();
            if(count($movie)==1){

                movieUpdate($tmdbid);
            }elseif(count($movie)==0){

                movieImport($tmdbid);
            }
            $movie=DB::table('movies')->where('tmdbId', '=', $tmdbid)->get();
        }
        if(isset($input['deletemovie'])){
            $deletemov='1';
            $dbid=$input['dbid'];
            $movie=DB::table('movie')->where('dbid', '=', $dbid)->get();
            //   return $movie;
            if(count($movie)>0){
                DB::table('movie')->where('dbid', '=', $dbid)->delete();

            }else{
                $error=1;
                $errortxt="No movie found with ID = $dbid";
            }
            //  return $deletemov;
        }
        if(isset($_POST['updatefromto']) || isset($_POST['importfromto'])){
            $uidatefrom=$_POST['uidatefrom'];
            $uidateto=$_POST['uidateto'];
            $action='';
            if(isset($_POST['updatefromto'])){ $action='update';}elseif(isset($_POST['importfromto'])){ $action='import';}

            $urlpage=1;
            $urlmaxpage=2;
            $content='';

            while($urlpage<=$urlmaxpage){
                $dateserurl= "http://api.themoviedb.org/3/discover/movie?api_key=$apiKey&primary_release_date.gte=$uidatefrom&primary_release_date.lte=$uidateto&sort_by=primary_release_date.asc&page=$urlpage";

                $content=getTmdbData($dateserurl);
                //  return $content;
                if($content!=''){
                    $pageinfo= json_decode($content);
                    if($urlmaxpage<$pageinfo->total_pages){
                        $urlmaxpage=$pageinfo->total_pages;
                    }
                    foreach ($pageinfo->results as $result){
                        if(isset($result->id)){
                            $tmdbid=$result->id;
                            $movie=DB::table('movie')->where('tmdbId', '=', $tmdbid)->get();
                            // return $action;
                            if($action=='update'){
                                if(isset($movie[0])){
                                    movieUpdate($tmdbid);

                                    echo "<center>Movie [$tmdbid] \"".$result->title."\" ---->Updated</center>";
                                }else{

                                    echo "<center>Movie [$tmdbid] \"".$result->title."\" Not Found in Database</center>";
                                    }
                            }elseif($action=='import'){
                                if(!isset($movie[0])){
                                    movieImport($tmdbid);

                                }else{
                                    echo "<center>Movie [$tmdbid] \"".$movie[0]->title."\" (".substr($movie[0]->releaseDate,0,4).") already exists</center>";
                                }
                            }

                        }
                    }
                }
                $urlpage++;
            }
        }
        return view('back.editmovies.index', compact('editmov','updatemov','deletemov','movie','dbid','title','year','error','errortxt','backgrounds','allgenres'));
    }

    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->privilages_level < 3) {
                return redirect(route('admin.editmovies'));
            }else{
                return response()->view('notFound', [], 404);
            }
        }else{
            return response()->view('notFound', [], 404);
        }
    }

    public function comments(Request $request){

        if(Auth::user()) {
            $title='';
            $username='';
            $type='';
             $input = $request->all();
            if (isset($input['delete'])) {
                DB::table('comments')->where('idComment', $input['commentid'])->delete();
            }
            $latestComments = Comment::getAllComments();
            if (isset($input['showcomments'])) {
                if($input['movieid']!='' && $input['userid']!=''){
                    $type='Both';
                    $latestComments=Comment::getUserMovieComments($input['userid'],$input['movieid']);
                }elseif ($input['type'] == 'Movie') {
                    $type='Movie';
                      $latestComments = Comment::getMovieComments($input['movieid']);
                     $title=Movie::where('idMovie',$input['movieid'])->value('title');
                } else if ($input['type'] == 'User') {
                    $type='User';
                      $latestComments = Comment::getUserComments($input['userid']);
                    $username=User::where('idUser',$input['userid'])->value('username');
                }
            }
              $latestComments= paginate($latestComments,25);
            return view('back.comments.index', compact('latestComments','type','title','username'));
        }else{
            return response()->view('notFound', [], 404);
        }
    }

    public function useredit(Request $request)
    {

        if(Auth::user()){
       $input=$request->all();

            if(isset($input['deleteuser'])){

                $userid=$input['userid'];
                $deluserdb = DB::table('users')->where([
                    ['idUser', $userid],
                ])->value('name');
                if ($deluserdb!=false) {
                    DB::table('users')->where('idUser', $userid)->delete();
                }
            }

            if(isset($input['edituser'])){
                $userid=$input['userid'];
                   $user=User::getUser($userid);
                if (isset($user[0])) {
                    $user = $user[0];
                }else{
                    \Session::flash('flash_message', 'No user found with id '.$userid);
                    return \Redirect::back();
                }
            }
            if(isset($input['newprev'])) {
                $userid = $input['userid'];

                DB::table('users')->where([
                    ['idUser', $userid],
                ])->update([
                    'privilages_level' => $input['newprev']
                ]);
                $user = User::getUser($userid);
                if (isset($user[0])) {
                    $user = $user[0];
                }else{
                    \Session::flash('flash_message', 'No user found with id '.$userid);
                    return \Redirect::back();
                }
            }

            return view('back.user.index', compact('user'));
        }else{
            return response()->view('notFound', [], 404);
        }
    }
}
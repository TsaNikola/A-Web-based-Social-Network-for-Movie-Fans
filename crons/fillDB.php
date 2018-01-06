<?php

$apiKey='ca6195d93c2383688c52a44efc497f26';
$movieUrl='https://api.themoviedb.org/3/movie/';
$personUrl='https://api.themoviedb.org/3/person/';
$popUrl='https://api.themoviedb.org/3/movie/popular?api_key='.$apiKey;
$page=1;
$totlal_pages=1000;


function getTmdbData($url){
    $i=0;
    $results="";
    while($results=="" && $i<=20){
        $results=file_get_contents($url);
        $i++;
        if($results=='') {
            sleep(5);
        }
    }
    return $results;
}


function movieImport($tmdbid){
    $errortxt='';
    $url="http://api.themoviedb.org/3/movie/$tmdbid?api_key=ca6195d93c2383688c52a44efc497f26";

    $content=getTmdbData($url);
    if($content!=''){
        $movieInfo= json_decode($content);
        $title=$movieInfo->title;
        if($title===NULL){
            $title='';
        }
        $description=$movieInfo->overview;
        if($description===NULL){
            $storyline='';
        }
        $poster=$movieInfo->poster_path;

        if($poster===NULL){
            $poster='';
        }


        $rating=$movieInfo->vote_average;
        if($rating===NULL){
            $rating='';
        }
        $popularity= $movieInfo->popularity;
        if($popularity===NULL){
            $popularity='';
        }
        $releaseDate=$movieInfo->release_date;


        DB::table('movie')->insert([
            'tmdbId' =>$tmdbid,
            'description' =>$description,
            'poster' => $poster,
            'title'=>$title,
            'releaseDate'=>$releaseDate,
            'rating'=>$rating,
            'popularity' => $popularity,
        ]);
        $movieDbId=DB::table('movie')->where('tmdbId',$tmdbid)->value('idMovie');

        $wurl="http://api.themoviedb.org/3/movie/$tmdbid/images?api_key=ca6195d93c2383688c52a44efc497f26";
        $content=getTmdbData($wurl);
        if($content!=''){
            $wallpapers=json_decode($content);
            foreach($wallpapers->backdrops as $wallpaper){
                $wallpaperExists= DB::table('wallpaper')->where('filename',$wallpaper->file_path)->get();
                if(!isset($wallpaperExists[0])) {
                    DB::table('wallpaper')->insert([
                        'filename' => $wallpaper->file_path,
                        'movieWallpaperId' => $movieDbId
                    ]);
                }
            }

        }else{
            if($errortxt==''){$errortxt='<center>';}
            $errortxt.="Failed to get TMDB data about images for $tmdbid<br>";
        }

        $purl="http://api.themoviedb.org/3/movie/$tmdbid/credits?api_key=8bd247a8ea746fe24d32b57de4256438";
        $content=getTmdbData($purl);
        if($content!=''){
            $people=json_decode($content);
            foreach($people->cast as $actor){
                $personExists= DB::table('person')->where('tmdbid',$actor->id)->get();
                if(!isset($personExists[0])){
                    personImport($actor->id);
                }
                $personDbId= DB::table('person')->where('tmdbid',$actor->id)->value('idPerson');
                if($personDbId!='') {
                    DB::table('movie_person')->insert([
                        'moviePersonId' => $movieDbId,
                        'personMovieId' => $personDbId,
                        'part' => 'cast',
                        'character' => $actor->character,
                    ]);
                }
            }
            foreach($people->crew as $member){
                $personExists= DB::table('person')->where('tmdbid',$member->id)->get();
                if(!isset($personExists[0])) {
                    personImport($member->id);
                }
                $personDbId= DB::table('person')->where('tmdbid',$member->id)->value('idPerson');
                if($personDbId!='') {
                    DB::table('movie_person')->insert([
                        'moviePersonId' => $movieDbId,
                        'personMovieId' => $personDbId,
                        'part' => 'crew',
                        'character' => $member->job,
                    ]);
                }
            }
        }else{
            if($errortxt==''){$errortxt='
           ';}
            $errortxt.="Failed to get TMDB data about cast for $tmdbid
             ";
        }

        foreach($movieInfo->genres as $genre){

            DB::table('movie_genre')->insert([
                'genreMovieId' =>$movieDbId,
                'genreName' =>$genre->name,
            ]);
        }

        $url="http://api.themoviedb.org/3/movie/$tmdbid/videos?api_key=8bd247a8ea746fe24d32b57de4256438";
        $content=getTmdbData($url);
        if($content!=''){
            $trailers=json_decode($content);
            foreach($trailers->results as $trailer){
                if($trailer->site=="YouTube" && $trailer->type=="Trailer"){
                    DB::table('trailer')->insert([
                        'movieTrailerId' =>$movieDbId,
                        'filename' =>$trailer->key,
                        'tag' =>$trailer->name,
                    ]);
                }
            }
        }else{
            if($errortxt==''){$errortxt='
        ';}
            $errortxt.="Failed to get TMDB data about trailers for $tmdbid
             ";
        }
    }else{

        if($errortxt==''){$errortxt='<center>';}
        $errortxt.="Failed to get TMDB data in general<br>";
    }
    return $errortxt;
}


function movieUpdate($tmdbid){

    $errortxt='';
    $movieDbId=DB::table('movie')->where('tmdbId',$tmdbid)->value('idMovie');
    $url="http://api.themoviedb.org/3/movie/$tmdbid?api_key=ca6195d93c2383688c52a44efc497f26";
    $content=getTmdbData($url);
    if($content!=''){
        $movieInfo= json_decode($content);
        $title=$movieInfo->title;

        if($title===NULL){
            $title='';
        }

        $description=$movieInfo->overview;
        if($description===NULL){
            $description='';
        }
        $poster=$movieInfo->poster_path;
        if($poster===NULL){
            $poster='';
        }


        $url="http://api.themoviedb.org/3/movie/$tmdbid/images?api_key=ca6195d93c2383688c52a44efc497f26";
        $wallpapers='';
        $content='';
        $content=getTmdbData($url);
        if($content!=''){
            $wallpapers=json_decode($content);
            foreach($wallpapers->backdrops as $wallpaper){
                $wallpaperExists= DB::table('wallpaper')->where('filename',$wallpaper->file_path)->get();
                if(empty($wallpaperExists)) {
                    DB::table('wallpaper')->insert([
                        'filename' =>$wallpaper->file_path,
                        'movieWallpaperId' =>$movieDbId
                    ]);
                }
            }
        }else{

            if($errortxt==''){$errortxt='
        ';}
            $errortxt.="Failed to get TMDB data about images for $tmdbid
             ";
        }
        $url="http://api.themoviedb.org/3/movie/$tmdbid/credits?api_key=ca6195d93c2383688c52a44efc497f26";

        $content=getTmdbData($url);
        if($content!=''){
            $people=json_decode($content);

            foreach($people->cast as $actor){
                $personExists= DB::table('person')->where('tmdbid',$actor->id)->get();
                if(empty($personExists)){
                    personImport($actor->id);
                }else{
                    personUpdate($actor->id);
                }
                $personDbId= DB::table('person')->where('tmdbid',$actor->id)->value('idPerson');
                $personMovie= DB::table('movie_merson')->where([
                    ['personMovieId',$personDbId],
                    ['moviePersonId',$tmdbid],
                ])->get();
                if(empty($personMovie)){
                    DB::table('movie_person')->insert([
                        'moviePersonId' => $movieDbId,
                        'personMovieId' => $personDbId,
                        'part' => 'cast',
                        'character' => $actor->character,
                    ]);
                }
            }
            foreach($people->crew as $member){
                $personExists= DB::table('person')->where('tmdbid',$member->id)->get();
                if(empty($personExists)) {
                    personImport($member->id);
                }else{
                    personUpdate($member->id);
                }
                $personDbId= DB::ctable('person')->where('tmdbid',$member->id)->value('idPerson');

                $personMovie= DB::table('movie_merson')->where([
                    ['personMovieId',$personDbId],
                    ['moviePersonId',$tmdbid],
                ])->get();

                if(empty($personMovie)) {
                    DB::table('movie_person')->insert([
                        'moviePersonId' => $movieDbId,
                        'personMovieId' => $personDbId,
                        'part' => 'crew',
                        'character' => $member->job,
                    ]);
                }
            }
        }else{

            if($errortxt==''){$errortxt='
        ';}
            $errortxt.="Failed to get TMDB data for cast
             ";
        }
        if($movieInfo->genres !='') {
            foreach ($movieInfo->genres as $genre) {
                $genreExists = DB::table('movie_genre')->where([
                    'genreMovieId', $movieDbId,
                    'genreName', $genre->name,
                ])->get();
                if (empty($genreExists)) {
                    DB::table('movie_genre')->insert([
                        'genreMovieId' => $movieDbId,
                        'genreName' => $genre->name,
                    ]);
                }
            }
        }


        $votes=$movieInfo->vote_count;
        if($votes===NULL){
            $votes=0;
        }

        $rating=$movieInfo->vote_average;
        if($rating===NULL){
            $rating=0;
        }

        $popularity= $movieInfo->popularity;
        if($popularity===NULL){
            $popularity=0;
        }


        $year=$movieInfo->release_date;
        if($year===NULL){
            $year=0;
        }

        $url="http://api.themoviedb.org/3/movie/$tmdbid/videos?api_key=8bd247a8ea746fe24d32b57de4256438";
        $content=getTmdbData($url);
        if($content!=''){
            $trailers=json_decode($content);
            foreach($trailers->results as $trailer){
                if($trailer->site=="YouTube" && $trailer->type=="Trailer"){
                    $trailerExists= DB::table('trailer')->where([
                        'movieTrailerId', $movieDbId,
                        'filename', $trailer->key,
                        'tag', $trailer->name,
                    ])->get();
                    if(empty($trailerExists)){
                        DB::table('trailer')->insert([
                            'movieTrailerId' => $movieDbId,
                            'filename' => $trailer->key,
                            'tag' => $trailer->name,
                        ]);
                    }
                }
            }
        }else{
            if($errortxt==''){$errortxt='
        ';}
            $errortxt.="Failed to get TMDB data about trailers for $tmdbid
             ";
        }

        if($title!=''){
            DB::table('movie')
                ->where([
                    ['idMovie', $movieDbId],
                ])->update([
                    'title' => $title,
                ]);
        }

        DB::table('movie')
            ->where([
                ['idMovie', $movieDbId],
            ])->update([
                'tmdbId'=> $tmdbid,
                'poster' => $poster,
                'year'=>$year,
                'wallpapers' =>$wallpapers,
                'votes'=>$votes,
                'rating'=>$rating,
                'popularity' => $popularity,
            ]);

    }else{

        if($errortxt==''){$errortxt='
        ';}
        $errortxt.="Failed to get TMDB data in general
             ";
    }

    // if($errortxt!=''){$errortxt.='</center>';}
    return $errortxt;

}


function personImport($id)
{

    $url = "http://api.themoviedb.org/3/person/$id?api_key=ca6195d93c2383688c52a44efc497f26";

    $content = getTmdbData($url);

    if ($content != '') {
        $personInfo = json_decode($content);
        $name = $personInfo->name;
        $birthplace = $personInfo->place_of_birth;
        $picture = $personInfo->profile_path;
        $biography = $personInfo->biography;
        $website = $personInfo->homepage;

        DB::table('person')->insert([
            'tmdbId' => $id,
            'name' => $name,
            'birthplace' => $birthplace,
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
        $birthplace=$personInfo->place_of_birth;
        $picture=$personInfo->profile_path;
        $biography=$personInfo->biography;
        $website=$personInfo->homepage;

        DB::table('person')  ->where([
            ['idMovie', $personDbId],
        ])->update([
            'tmdbId' =>$id,
            'name' =>$name,
            'birthplace' =>$birthplace,
            'biography' =>$biography,
            'picture' =>$picture,
            'website' =>$website,
        ]);

    }


}


while($page<=$totlal_pages) {


    $pageurl = $popUrl . "&page=" . $page;
    $cont = getTmdbData($pageurl);
    if ($cont != '') {
        $pagecont = json_decode($cont);
        if ($pagecont->total_pages != '') {
            $totlal_pages = $pagecont->total_pages;
        }
        foreach ($pagecont->results as $movie) {
            $MovieExists = DB::table('movie')->where('tmdbid', $movie->id)->get();
            if (empty($MovieExists)) {
                movieImport($movie->id);
            } else {
                movieUpdate($movie->id);
            }
        }
    }
    $page++;
}

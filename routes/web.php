<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Σημείωση:
// 'Oτι βρίσκεται μέσα σε {} είναι wild cards και αντικαθιστούνται με οποιαδήποτε τιμή στο URL
//To όνομα της κάθε wild card (π.χ το όνομα της {id) είναι "id") θα είναι το όνομα της μεταβλητής που θα περάσει ως παράμετρος στην αντίστοιχη function


//Το route για την Αρχική. Καλεί την function home που βρίσκεται στον IndexController και το route μπορεί να αναγνωριστεί με την ονομασία home
Route::get('/', ['uses'=>'IndexController@home', 'as'=>'home']);

//Αυτό το route παίρνει ακέραιες τιμές στην θέση του "{from}" και του "{to}" και διαβάζει τις αντίστοιχες
// σελίδες του API και καταχωρει τα δεδομενα που διάβασε στην βάση
Route::get('filldb/frompage{from}/topage{to}', ['uses'=>'DashboardController@fillDB', 'as'=>'fillDB']);

//Το route για την αναζήτηση στο μενου. Είναι post επειδή δέχεται αυτή την μέθοδο από την φόρμα. Δεν θα ανοίξει κάτι αν πληκτρολογηθεί το συγκεκριμένο URL στον περιηγητη
//Καλεί την function menuSearch που βρίσκεται στον SearchController και το route μπορεί να αναγνωριστεί με την ονομασία menusearch
Route::post('/menu-search', ['uses'=>'SearchController@menuSearch', 'as'=>'menusearch']);

//Route::get('/menu-search/{search}', ['uses'=>'SearchController@menuSearchg', 'as'=>'menusearchg']);


//Το route για την σελίδα εμφάνισης δεδομένων της ταινίας. Στην θέση του {id} μπαίνει το αντίστοιχο id της ταινίας
//Καλεί την function movie που βρίσκεται στον MoviesController και το route μπορεί να αναγνωριστεί με την ονομασία movie
Route::get('/movie/{id}', ['uses'=>'MoviesController@movie', 'as'=>'movie']);

//Το route για να ακολουθήσει μια ταινία κάποιος χρήστης.
// Στην θέση του {id} μπαίνει το αντίστοιχο id της ταινίας και στην θέση του {user} μπαίνει το αντίστοιχο id του χρήστη
//Καλεί την function followmovie που βρίσκεται στον UsersController και το route μπορεί να αναγνωριστεί με την ονομασία followmovie
Route::post('/followmovie/{id}/{user}', ['uses'=>'UsersController@followmovie', 'as'=>'followmovie']);

//Το route για να σχολιάσει μια ταινία κάποιος χρήστης.
// Στην θέση του {id} μπαίνει το αντίστοιχο id της ταινίας και στην θέση του {user} μπαίνει το αντίστοιχο id του χρήστη
//Καλεί την function commentmovie που βρίσκεται στον UsersController και το route μπορεί να αναγνωριστεί με την ονομασία commentmovie
Route::post('/commentmovie/{id}/{user}', ['uses'=>'UsersController@commentmovie', 'as'=>'commentmovie']);

//Το route για την σελίδα εμφάνισης δεδομένων της ταινίας. Στην θέση του {id} μπαίνει το αντίστοιχο id του χρήστη
//Καλεί την function user που βρίσκεται στον UsersController και το route μπορεί να αναγνωριστεί με την ονομασία user
Route::get('/user/{id}', ['uses'=>'UsersController@user', 'as'=>'user']);

//Το route για να ακολουθήσει ένας χρήστης κάποιον άλλο χρήστη.
// Στην θέση του {id} μπαίνει το αντίστοιχο id του χρήστη που θα ακολουθήσει τον άλλον χρήστη, ενώ στην θέση του {user} μπαίνει id του χρήστη που θα ακολουθηθεί από τον πρώτο
//Καλεί την function followuser που βρίσκεται στον UsersController και το route μπορεί να αναγνωριστεί με την ονομασία followmovie
Route::post('/followuser/{id}/{user}', ['uses'=>'UsersController@followuser', 'as'=>'followuser']);

//Το route για την σελίδα εμφάνισης δεδομένων των συντελεστών μιας ταινίας. Στην θέση του {id} μπαίνει το αντίστοιχο id του συντελεστή.
//Καλεί την function credit που βρίσκεται στον CreditsController και το route μπορεί να αναγνωριστεί με την ονομασία credit
Route::get('/credit/{id}', ['uses'=>'CreditsController@credit', 'as'=>'credit']);

Route::get('/popular', ['uses'=>'MoviesController@popular', 'as'=>'popular']);
Route::get('/toprated', ['uses'=>'MoviesController@toprated', 'as'=>'toprated']);
Route::get('/latest', ['uses'=>'MoviesController@latest', 'as'=>'latest']);
Route::get('/upcomming', ['uses'=>'MoviesController@upcomming', 'as'=>'upcomming']);
Route::get('/allmovies', ['uses'=>'MoviesController@allmovies', 'as'=>'allmovies']);

Route::post('/popular', ['uses'=>'MoviesController@postMovielist', 'as'=>'postpopular']);
Route::post('/toprated', ['uses'=>'MoviesController@postMovielist', 'as'=>'posttoprated']);
Route::post('/latest', ['uses'=>'MoviesController@postMovielist', 'as'=>'postlatest']);
Route::post('/upcomming', ['uses'=>'MoviesController@postMovielist', 'as'=>'postupcomming']);
Route::post('/allmovies', ['uses'=>'MoviesController@postMovielist', 'as'=>'postallmovies']);


Route::get('/cast/{firstChar}', ['uses'=>'CreditsController@allcast', 'as'=>'allcast']);
Route::get('/crew/{firstChar}', ['uses'=>'CreditsController@allcrew', 'as'=>'allcrew']);
Route::get('/users/{userid}', ['uses'=>'UsersController@user', 'as'=>'user']);
Route::post('/users/{userid}', ['uses'=>'UsersController@postuser', 'as'=>'postuser']);
Route::get('/users', ['uses'=>'UsersController@allusers', 'as'=>'allusers']);
Route::get('/users/profile', ['uses'=>'UsersController@profile', 'as'=>'profile']);
Route::post('/users/profile', ['uses'=>'UsersController@postprofile', 'as'=>'postprofile']);
//Με την παρακάτω εντολή δηλώνονται αυτόματα όλα τα routes που χρειάζονται για τις βασικές λειτουργίες εγγραφής και σύνδεσης και αποσύνδεσης του χρήστη
Auth::routes();

//Route::get('/logout', ['uses'=>'SearchController@menuSearchg', 'as'=>'credit']);



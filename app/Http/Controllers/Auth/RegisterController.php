<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {


        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'aboutme' => 'string',
            'userimage' => 'image',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $fileName = null;
        if(isset($data['userimage'])){
        $image = $data['userimage'];
        if ($image->isValid()) {
            $destinationPath = public_path('uploads/users/images');
            $extension = $image->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;

            $image->move($destinationPath, $fileName);
        }
        }
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'image' =>  $fileName,
            'info' =>  $data['aboutme'],
            'password' => bcrypt($data['password']),
        ]);
    }
}

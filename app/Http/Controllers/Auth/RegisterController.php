<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
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
    //public $email;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
   // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_hp'=> 'required|string|max:13|unique:users'
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
       // $email = $data['email'];
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'kode' => str_random(5),

        ]);
    }



    public function registerApi(Request $request)
    {
        $data = array();
        $status = 202;
        if (User::where('email', '=', $request['email'])->count() > 0) {
            $data = array(
            'data'=>null,
            'status_code'=>202,
            'message'=>"Email");
            return \Response::json($data, 202);
        }

        if ( User::where('no_hp', '=', $request['no_hp'])->count() > 0) {
            $data = array(
            'data'=>null,
            'status_code'=>202,
            'message'=>"Phone");
            return \Response::json($data, 202);
        }


        $kode =strtolower(str_random(5));

        $emailSender = new LoginController();
        try{
            $emailSender->sendEmail($request['email'], $kode);
            $status = 200;

            $data = array(
                'data'=>null,
                'status_code'=>$status,
                'message'=>"Success");
        }
        catch(\Exception $e){

            $data = array(
                'data'=>null,
                'status_code'=>201,
                'message'=>"failed to send email");
            return  \Response::json($data, 201);


        }



        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'no_hp' => $request['no_hp'],
            'kode' => bcrypt ($kode),
            'token' => 'byan'
        ]);

        $data = array(
                'data'=>null,
                'status_code'=>$status,
                'message'=>"Success");


        return  \Response::json($data, $status);

    }
}

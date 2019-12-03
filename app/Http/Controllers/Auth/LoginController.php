<?php

namespace App\Http\Controllers\Auth;
use App\User;
use Mail;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function index(){
        return view('backend.auth.login');
    }

    public function login(Request $request){
        if ( \Auth::attempt(['email' => $request['email'], 'password' => $request['kode'] ])){
            if(\Auth::user()->id_role == 3){
                return redirect('/backend/transaksi/index');
            }
        }

        return redirect()->back()->withErrors(['errors' => 'These credentials do not match our records. ']);

    }


    public function loginAPI(Request $request)
    {

        $data = array();
        $respon = array();
        $status = 200;
        $message = "Success login";

            if (\Auth::attempt(['email' => $request['email'], 'password' => $request['kode']])) {
                // Authentication passed...
                    $token = \Auth::getSession()->getId();
                    $user = User::where('email','=',$request['email'])->update([
                    'token' => $token

                     ]);
                    $dataku = User::where('email','=',$request['email'])->first();

                     $respon = array(
                        'id_user' =>$dataku['id_user'],
                        'name' => $dataku['name'],
                        'email' => $dataku['email'],
                        'no_hp' => $dataku['no_hp'],
                        'alamat' => $dataku['alamat'],
                        'no_darurat' => $dataku['no_darurat'],
                        'pesan' => $dataku['pesan'],
                        'path' =>$dataku['photo_path'],
                        'pinAlamat' =>$dataku['pin_alamat']
                    );

            }
            else
            {
                $message = "Wrong Code";
                $status = 202;
            }
            $data['data'] = $respon;
            $data['message'] = $token;
            $data['status_code'] = $status;

        return \Response::json($data, $status);
    }






    public function loginEmail(Request $request)
    {
        $data = array();
        $respon = null;
        $status = 200;
        $message = "Success to send email";
        $kode = strtolower(str_random(5));

        if(User::where('email', '=', $request['email'])->count() > 0 )
        {
             $cek = User::where('email', '=', $request['email'])->first();
                if($cek->status ==1 && $cek->id_role!=3)
                {

                    $user = User::where('email','=',$request['email'])->update(['kode'=>bcrypt($kode)]);
                    $emailKirim = $request['email'];

                    try{
                         $this->sendEmail($emailKirim, $kode);
                    }
                    catch (\Exception $e)
                    {
                        $status = 202;
                        $message = "Failed to send email";


                    }
                }
                else
                {
                    $message = "Akun Diblokir";
                    $status = 206;
                }

        }
        else
        {
            $status = 203;
            $message = "User not found";
        }


        $data = array(
                  'data' =>$kode,
                  'status_code' => $status,
                  'message'     => $message,
                );
       return \Response::json($data, $status);
    }



    public function sendEmail(String $emailmu, String $kodemu)
    {


        $data = array(
        'email' => $emailmu,
        'kode' => $kodemu,
         );
        //dd($data['email']);


        Mail::send('welcome', $data, function ($message) use($data) {

            $message->from('rescueidsby@gmail.com', 'Verifikasi tanggapps');

            $message->to($data['email'])->subject('Kode verifikasi untuk login tanggapps');

            });


        }
}

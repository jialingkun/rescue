<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\User;
use App\Ambulan;
use App\Review;
use App\TransactionHelper;

class ReviewController extends Controller
{
    //

	public function reviewDariPengguna(Request $request)
	{
		$respon = null;
        $status = 200;
        $message = "Success";
        if(User::where('token', '=', $request['token'])->count() > 0 )
        {
        	if(Review::where('id_transaksi', '=', $request['id_transaksi'])->count() >0)
        	{

        		$review = Review::where('id_transaksi','=', $request['id_transaksi'])->update([
        					'id_pengguna' => $request['id_pengguna'],
				            'review_pengguna' => $request['review_pengguna'],
				            'rating_pengguna' => $request['rating_pengguna'],
        			]);
        	}
        	else
        	{
        		$review = Review::create([
				            'id_transaksi' => $request['id_transaksi'],
				            'id_pengguna' => $request['id_pengguna'],
				            'review_pengguna' => $request['review_pengguna'],
				            'rating_pengguna' => $request['rating_pengguna'],
        					]);
        		$review = Review::where('id_transaksi','=', $request['id_transaksi'])->update([
        					'id_pengguna' => $request['id_pengguna'],
				            'review_pengguna' => $request['review_pengguna'],
				            'rating_pengguna' => $request['rating_pengguna'],
        			]);
        	}
            $message = "Success fill account";
        }
        else
        {
        	 $status = 202;
            $message = "Your account signed in another device";
        }




        $data = array(
                   'data' =>$respon,
                  'status_code' =>$status,
                  'message'     => $message,
                );
        return \Response::json($data, $status);
	}

	public function reviewDariAmbulan(Request $request)
	{
		$respon = null;
        $status = 200;
        $message = "Success";

        if(Ambulan::where('token', '=', $request['token'])->count() > 0 )
        {
        	if(Review::where('id_transaksi', '=', $request['id_transaksi'])->count() >0)
        	{

        		$review = Review::where('id_transaksi','=', $request['id_transaksi'])->update([
        					'id_ambulan' => $request['id_ambulan'],
				            'review_ambulan' => $request['review_ambulan'],
				            'rating_ambulan' => $request['rating_ambulan'],
        			]);


        	}
        	else
        	{

        		$review = Review::create([
				            'id_transaksi' => $request['id_transaksi'],
				            'id_ambulan' => $request['id_ambulan'],
				            'review_ambulan' => $request['review_ambulan'],
				            'rating_ambulan' => $request['rating_ambulan'],

        					]);
        	}
            $message = "Success fill account";
        }
        else
        {
        	 $status = 202;
            $message = "Your account signed in another device";
        }






        $data = array(
                   'data' =>$respon,
                  'status_code' =>$status,
                  'message'     => $message,
                );
        return \Response::json($data, $status);
	}

    public function listReviewPengguna(Request $request)
    {
         $respon = null;
        $status = 200;
        $message = "Success";


        if(User::where('token', '=', $request['token'])->count() > 0 )
        {

                $user = User::where('token', '=', $request['token'])->first();

                // $users = \DB::table('users','transaksis')
                //              ->select(\DB::raw('transaksis.id_penolong, users.alamat'))
                //              ->where('id_user', '=', 2)
                //              ->get();

                $respon = array();


                if($request['pasien'] === true)
                {
                    $helperTrx = Transaksi::where('id_korban', $user->id_user)->get();
                    foreach ($helperTrx as $key => $item) {
                        $respon = array_merge($respon,array(array($item)));
                    }
                }else
                {
                    $helperTrx = TransactionHelper::with('transaction')->where('user_id', $user->id_user)->get();
                    foreach ($helperTrx as $key => $item) {
                        $findTrx = Transaksi::where('id_transaksi', $item['transaction_id'])->get();
                        $respon = array_merge($respon,array($findTrx));
                    }
                }

                // $query = "SELECT t.id_penolong, t.id_transaksi, t.tipe_transaksi, t.lokasi, t.created_at, r.id_review, r.rating_pengguna, r.review_pengguna FROM transaksis t, reviews r WHERE r.id_transaksi = t.id_transaksi AND t.id_penolong =".$user->id_user .";";
                // $respon = \DB::select(\DB::raw($query));

        }
        else
        {
             $status = 202;
            $message = "Your account signed in another device";
        }

        $data = array(
                   'data' =>$respon,
                  'status_code' =>$status,
                  'message'     => $message,
                );
        return \Response::json($data, $status);
    }



    public function listReviewAmbulan(Request $request)
    {

        $respon = null;
        $status = 200;
        $message = "Success";


        if(Ambulan::where('token', '=', $request['token'])->count() > 0 )
            {

                $ambulan = Ambulan::where('token', '=', $request['token'])->first();
                $transaksi = Transaksi::where('id_ambulan', '=', $ambulan->id_ambulan)->get();



                $query = "SELECT t.id_ambulan, t.id_transaksi, t.tipe_transaksi, t.lokasi, t.created_at, r.id_review, r.rating_ambulan, r.review_ambulan FROM transaksis t, reviews r WHERE r.id_transaksi = t.id_transaksi AND t.id_ambulan =".$ambulan->id_ambulan .";";
                $respon = \DB::select(\DB::raw($query));

                // $users = \DB::table('transaksis')
                //             ->leftJoin('ambulans', 'ambulans.id_ambulan', '=', 'transaksi.id_transaksi')
                //             ->select([
                //                 'transaksis.id_transaksi as id_transaksi',
                //                 'transaksis.lokasi as lokasi',
                //                 'ambulans.id_ambulan as id_ambulan'
                //             ]);

         }
        else
        {
             $status = 202;
            $message = "Your account signed in another device";
        }



        $data = array(
                   'data' =>$respon,
                  'status_code' =>$status,
                  'message'     => $message,
                );
        return \Response::json($data, $status);
    }




}

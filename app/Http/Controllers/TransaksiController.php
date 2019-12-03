<?php

namespace App\Http\Controllers;



use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Transaksi;
use App\User;
use App\Review;
use App\StatusTransaksi;
use App\TransactionHelper;
use App\Ambulan;
use App\Hospital;
use App\Aed;
use App\Service\DataTableService;
use App\Http\Controllers\FirebaseController;
use App\Events\TransactionAdded;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\Topics;
use FCM;
use Google\Cloud\Firestore\FirestoreClient;
use Bodunde\GoogleGeocoder\Geocoder;

class TransaksiController extends Controller
{
  protected $dataTableService;
  public function __construct(DataTableService $dataTableService)
  {
    $this->dataTableService     = $dataTableService;
  }

	public function uploadTransaksi(Request $request, Geocoder $geocoder)
    {

        $data = array();
        $respon = null;
        $status = 200;
        $message = "Success";

        $time = Carbon::now()->toDateTimeString();

        if(!$request->has('id_transaksi')){

          if($request['tipe_transaksi'] == 2)
          {

          $foto = $request['file'];
          $foto->move('foto', $foto->getClientOriginalName());

          $transaksibaru = Transaksi::create([
              'id_penolong' => $request['id_penolong'],
              'latitude' => $request['latitude'],
              'longitude' => $request['longitude'],
              'lokasi' => $request['lokasi'],
              'foto' => $request['foto'],
              'tipe_transaksi' => $request['tipe_transaksi'],
              'id_status' => "2",
              'waktu_pertolongan_awam' => $time,
              'range_id' => $request['tipe_range'],
              ]);

          }else
          {
          $transaksibaru = Transaksi::create([
              'id_korban' => $request['id_penolong'],
              'latitude' => $request['latitude'],
              'longitude' => $request['longitude'],
              'lokasi' => $request['lokasi'],
              'tipe_transaksi' => $request['tipe_transaksi'],
              'range_id' => $request['tipe_range'],
              ]);
          }

          $review = Review::create([
              'id_transaksi' => $transaksibaru->id_transaksi,
          ]);

        } else{
          
          $transaksibaru = Transaksi::findOrFail($request['id_transaksi']);
          $transaksibaru->range_id = $request['tipe_range'];
          $transaksibaru->save();

        }

        // $realtimeData = Transaksi::with('ambulanTrx', 'statusTrx', 'korban', 'penolong')->first();
        $realtimeData = Transaksi::with('ambulanTrx', 'statusTrx', 'korban', 'range')
        ->where('transaksis.id_transaksi', $transaksibaru->id_transaksi)->first();
        

        // -----------------------

        // putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/FirebaseKey.json');
        // $db = new FirestoreClient();

        // $collection = $db->collection('trackLocation');
        // $snapshot = $collection->documents();
        // foreach ($snapshot as $document) {

        //   if(isset($document['tokenfcm'])){

        //     // get distance between two locations
        //     $location1 = [
        //       "lat" => $transaksibaru['latitude'],
        //       "lng" => $transaksibaru['longitude
        //       ']
        //     ];

        //     $userLocation = [
        //         "lat" => $document['latitude'],
        //         "lng" => $document['longitude']
        //     ];
        //     $distance = $geocoder->getDistanceBetween($location1, $userLocation);
            
        //     if($distance >= $transaksibaru['range']->start && $distance <= $transaksibaru['range']->end){

        //       $optionBuilder = new OptionsBuilder();
              
        //       $notificationBuilder = new PayloadNotificationBuilder($transaksibaru['korban']->name . ' needs help about ' . $distance . ' meters!');
        //       $notificationBuilder->setBody('Please open the apps!')->setSound('default');
              
        //       $dataBuilder = new PayloadDataBuilder();
        //       $dataBuilder->addData(['params' => '#'.
        //           $transaksibaru['id_korban'].'#'.
        //           $transaksibaru['id_transaksi'].'#'.
        //           $transaksibaru['latitude'].'#'.
        //           $transaksibaru['longitude'].'#'.
        //           $transaksibaru['range_id'].'#']);
              
        //       $option = $optionBuilder->build();
        //       $notification = $notificationBuilder->build();
        //       $data = $dataBuilder->build();
              
        //       $downstreamResponse = FCM::sendTo($document['tokenfcm'], $option, $notification, $data);
              
        //       $downstreamResponse->numberSuccess();
        //       $downstreamResponse->numberFailure();
        //       $downstreamResponse->numberModification();
              
        //       //return Array - you must remove all this tokens in your database
        //       $downstreamResponse->tokensToDelete();
              
        //       //return Array (key : oldToken, value : new token - you must change the token in your database )
        //       $downstreamResponse->tokensToModify();
              
        //       //return Array - you should try to resend the message to the tokens in the array
        //       $downstreamResponse->tokensToRetry();
              
        //     }
            
        //   }

        // }

        // -----------------------



        event(new TransactionAdded(json_encode($realtimeData)));

        $respon = array(
          'id_transaksi' => $transaksibaru->id_transaksi
        );

        // $firebaseController->notifTest(array('name' => 'testing'));
        
        try{
            $this->sendNotification($transaksibaru->id_transaksi, $request['tipe_transaksi']);
        }
        catch (\Exception $e)
        {
            $status = 202;
            $message = "Failed to send Notification";
        }

        $data = array(
                  'data' => $respon,
                  'status_code' =>$status,
                  'message'     => $message,
                );
        return \Response::json($data, $status);
    }


	public function sendNotification(String $id_transaksi, String $tipe )
	{
		$transaksi = Transaksi::find($id_transaksi);


    $foto = "default";
    // if($tipe=="1")
    // {

    //     //->where('id_user', '!=', $transaksi->id_korban)
		// $users = User::where('FCMToken', '!=', null)->where('id_user', '!=', $transaksi->id_korban)->get();
    // }
    // else if($tipe =="2")
    // {
     $users = Ambulan::where('FCMToken', '!=', null)->get();
    // }

		$penolongs = array();
		$distance = array();

		foreach($users as $user)
		{
					array_push($penolongs, $user->FCMToken);
		}


    $accepted = 'no';
		$body = array();
		$data = array(
				'id_transaksi' => $transaksi->id_transaksi,
				'latitude' => $transaksi->latitude,
				'longitude' => $transaksi->longitude,
				'lokasi' => $transaksi->lokasi,
        'tipe' => $transaksi->tipe_transaksi,
        'accepted'=>$accepted,
        'foto'=>$transaksi->foto
			);


		//$API_ACCESS_KEY = "AAAAhQaY0i8:APA91bE8vSvRlBoux5bgE2mmG2MkU_kXWTa_99d2J11s71gpJS72jPECBcOEQv9VPyswAui8US_kua5i2m9Y2RHWjstsMMxYJp8MyrNS5YVJhZIa9RHYN9lPxhWCmX8JYoxV11dK8yz0";
		$API_ACCESS_KEY = "AAAAQsY-uTg:APA91bGG64Wu66fuSwzrjuhn7kz09cGEdn8O6uit3dWiGSEvx49vNFYhBABezb6pwda0kyPYQUzrKLHKStHDkCTLB1VCkneOyF1d7D4jNn9nNu6PULVOEKiEyowWOeDhYXIorl6Y_CNM";
		$body = array(
                   'registration_ids' => $penolongs,
                  'data' => $data,

                );

		$header = array(
                   'Authorization: key='. $API_ACCESS_KEY,
                  'Content-Type: application/json',

                );




		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $header );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $body ) );
		$result = curl_exec($ch );
		curl_close( $ch );

		// $body = array(
		//     'registration_ids'	=> $request['id'],
		//     'data'	=> "Byan",
		//     );
	}
  public function senddnotif(Request $request)
  {

    $transaksi = Transaksi::find($request['id_transaksi']);

    $user = User::where('FCMToken', '!=', null)->where('id_user', '=', $transaksi->id_korban)->first();

    $penolongs = array();
		$distance = array();

    array_push($penolongs, "fBLqIzUnU1M:APA91bF6TX4t5jG8L3AtA71NeDfBTdNusipWbylvUY2fdGdDC5goKWX2XcG3_jFdrwF2IBw1880hg_E0ETBDx6wYgX0sKXg_HcfoAbnfCCwqghP2bsjiouVIZf5xVnlG2nIRRhAPon25");

    $accepted = 'yes';

    $body = array();
    $data = array(
        'id_transaksi' => $transaksi->id_transaksi,
        'latitude' => $transaksi->latitude,
        'longitude' => $transaksi->longitude,
        'lokasi' => $penolongs,
        'tipe' => $transaksi->tipe_transaksi,
        'accepted'=>$accepted,
      );





    $API_ACCESS_KEY = "AAAAhQaY0i8:APA91bE8vSvRlBoux5bgE2mmG2MkU_kXWTa_99d2J11s71gpJS72jPECBcOEQv9VPyswAui8US_kua5i2m9Y2RHWjstsMMxYJp8MyrNS5YVJhZIa9RHYN9lPxhWCmX8JYoxV11dK8yz0";
    $body = array(
                   'registration_ids' => $penolongs,
                  'data' => $data,

                );

    $header = array(
                   'Authorization: key='. $API_ACCESS_KEY,
                  'Content-Type: application/json',

                );
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $header );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $body ) );
    $result = curl_exec($ch );
    curl_close( $ch );

    // $body = array(
    //     'registration_ids'	=> $request['id'],
    //     'data'	=> "Byan",
    //     );
    $status = 200;
    $message = "success";
    $data = array(
               'data' =>$data,
              'status_code' =>$status,
              'message'     => $message,
            );
    return \Response::json($data, $status);
  }

  public function haha(Request $request)
	{
		// $transaksi = Transaksi::find($id_transaksi);
    //


    // if($tipe=="1")
    // {
    //
    //     //->where('id_user', '!=', $transaksi->id_korban)
		// $users = User::where('FCMToken', '!=', null)->where('id_user', '!=', $transaksi->id_korban)->get();
    // }
    // else if($tipe =="2")
    // {
    //  $users = Ambulan::where('FCMToken', '!=', null)->get();
    // }
		$penolongs = array();
		$distance = array();

    array_push($penolongs, "fBLqIzUnU1M:APA91bF6TX4t5jG8L3AtA71NeDfBTdNusipWbylvUY2fdGdDC5goKWX2XcG3_jFdrwF2IBw1880hg_E0ETBDx6wYgX0sKXg_HcfoAbnfCCwqghP2bsjiouVIZf5xVnlG2nIRRhAPon25");

		// foreach($users as $user)
		// {
		// 			array_push($penolongs, $user->FCMToken);
		// }


    $accepted = 'no';
		$body = array();
		$data = array(
				'id_transaksi' => $penolongs,
			);





		$API_ACCESS_KEY = "AAAAhQaY0i8:APA91bE8vSvRlBoux5bgE2mmG2MkU_kXWTa_99d2J11s71gpJS72jPECBcOEQv9VPyswAui8US_kua5i2m9Y2RHWjstsMMxYJp8MyrNS5YVJhZIa9RHYN9lPxhWCmX8JYoxV11dK8yz0";
		$body = array(
                   'registration_ids' => $penolongs,
                  'data' => $data,

                );

		$header = array(
                   'Authorization: key='. $API_ACCESS_KEY,
                  'Content-Type: application/json',

                );




		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $header );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $body ) );
		$result = curl_exec($ch );
		curl_close( $ch );

        return \Response::json($data, 200);

		// $body = array(
		//     'registration_ids'	=> $request['id'],
		//     'data'	=> "Byan",
		//     );
	}

	public function terimaTransaksi(Request $request)
	{
		    $respon = null;
        $status = 200;
        $message = "Success";
        $queue = 0;

        $user = User::where('token', $request['token'])->first();

        if(User::where('token', '=', $request['token'])->count() > 0 )
        {

            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();
            $dataHelper = TransactionHelper::where('transaction_id', $request['id_transaksi'])->get();

           	if(COUNT($dataHelper) < 3)
           	{
               foreach ($dataHelper as $key => $value) {
                 if($value->user_id == $user->id_user){

                  $data = array(
                    'data' => $respon,
                    'status_code' => 205,
                    'message'     => 'You already as a helper',
                  );
                  return \Response::json($data, $status);

                 }
               }
               if(COUNT($dataHelper) == 0)
               {
                	$transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->update(['id_status' => "3"]);
                  $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();

                  $message = "Success fill account";
                  try{
                       $this->sendAcceptNotification($transaksi->id_transaksi, "1");
                  }
                  catch (\Exception $e)
                  {
                       $status = 204;
                       $message = "Failed to send Notification";
                  }
               }

               $helperTrx = new TransactionHelper;
               $helperTrx->transaction_id = $request['id_transaksi'];
               $helperTrx->user_id = $user->id_user;
               $helperTrx->save();
               event(new TransactionAdded(json_encode($transaksi)));
               $queue = COUNT($dataHelper) + 1;

           	}
           	else
           	{
           		$status = 201;
           		$message = "Helper reached limit";
           	}

        }
        else
        {
            $status = 202;
            $message = "Your account signed in another device";
        }
        
        $data = array(
                  'data' => $respon,
                  'status_code' =>$status,
                  'message'     => $message,
                  'queue'   => $queue
                );
        return \Response::json($data, $status);
	}

	public function verifTransaksi(Request $request)
	{
		    $respon = null;
        $status = 200;
        $message = "Success";
        $time = Carbon::now()->toDateTimeString();

        if(User::where('token', '=', $request['token'])->count() > 0 )
        {
        	$transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->update([
                                    'id_status' => "4",
                                    'id_penolong' => $request['id_penolong'],
                                    'waktu_pertolongan_awam' => $time,

                                     ]);

          $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();
          event(new TransactionAdded(json_encode($transaksi)));
          $tipe = "2";
          try{
                $this->sendNotification($request['id_transaksi'], $tipe);
              //  $this->sendAcceptNotification($request['id_transaksi']);
            }
            catch (\Exception $e)
            {
                $status = 202;
                $message = "Failed to send Notification";


            }

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
  //String $id_transaksi
  public function sendAcceptNotification(String $id_transaksi, String $tipe)
  {

    $transaksi = Transaksi::find($id_transaksi);
    $helper = 'user';
    $user = User::where('FCMToken', '!=', null)->where('id_user', '=', $transaksi->id_korban)->first();
    if($tipe=="1")
    {

    }
    else
    {
      $helper = 'ambulan';
    }
    // $penolongs = $user->FCMToken;
    // $distance = array();
    // $accepted = 'yes';

    $penolongs = array();
		$distance = array();

    array_push($penolongs,$user->FCMToken);
    $accepted = 'yes';

    $body = array();
    $data = array(
        'id_transaksi' => $transaksi->id_transaksi,
        'latitude' => $transaksi->latitude,
        'longitude' => $transaksi->longitude,
        'lokasi' => $transaksi->lokasi,
        'tipe' => $transaksi->tipe_transaksi,
        'accepted'=>$accepted,
        'foto'=>$transaksi->foto,
        'by'=> $helper,
    );

    $API_ACCESS_KEY = "AAAAhQaY0i8:APA91bE8vSvRlBoux5bgE2mmG2MkU_kXWTa_99d2J11s71gpJS72jPECBcOEQv9VPyswAui8US_kua5i2m9Y2RHWjstsMMxYJp8MyrNS5YVJhZIa9RHYN9lPxhWCmX8JYoxV11dK8yz0";
    $body = array(
                  'registration_ids' => $penolongs,
                  'data' => $data,
                );

    $header = array(
                   'Authorization: key='. $API_ACCESS_KEY,
                  'Content-Type: application/json',
                );

    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $header );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $body ) );
    $result = curl_exec($ch );
    curl_close( $ch );

    // $body = array(
    //     'registration_ids'	=> $request['id'],
    //     'data'	=> "Byan",
    //     );
    $status = 200;
    $message = "success";
    $data = array(
              'data' =>$data,
              'status_code' =>$status,
              'message'     => $message,
            );
    // return \Response::json($data, $status);
  }

  public function ambulanTerima(Request $request)
  {
        $respon = null;
        $status = 200;
        $message = "Success";


        if(Ambulan::where('token', '=', $request['token'])->count() > 0 )
        {

            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();

            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();
            event(new TransactionAdded(json_encode($transaksi)));

            if($transaksi->id_ambulan==null)
            {

              try {
                $this->sendAcceptNotification($transaksi->id_transaksi, "2");
              } catch (\Exception $e) {

              }

              $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->update([


                                    'id_status' => "5",

                                     ]);
            $message = "Success fill account";



            }
            else
            {
              $status = 201;
              $message = "Sudah ada yang menolong";
            }

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

  public function ambulanVerifikasi(Request $request)
  {
        $respon = null;
        $status = 200;
        $message = "Success";
        $time = Carbon::now()->toDateTimeString();


        if(Ambulan::where('token', '=', $request['token'])->count() > 0 )
        {

            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();






            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->update([
                                    'id_ambulan' => $request['id_ambulan'],
                                    'id_status' => "6",
                                    'waktu_pertolongan_ambulan' => $time,

                                     ]);
            event(new TransactionAdded(json_encode($transaksi)));
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

  public function ambulanSelesai(Request $request)
  {
    $respon = null;
        $status = 200;
        $message = "Success";
        $time = Carbon::now()->toDateTimeString();


        if(Ambulan::where('token', '=', $request['token'])->count() > 0 )
        {

            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();
            event(new TransactionAdded(json_encode($transaksi)));



            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->update([
                                    'id_status' => "7",
                                    'followup'  =>  $request['followup'],
                                    'waktu_selesai' => $time

                                     ]);
            // $review = Review::create([
            //         'id_transaksi' => $request['id_transaksi'],
            //       ]);

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

  public function transaksiPalsu(Request $request)
  {
        $respon = null;
        $status = 200;
        $message = "Success";

        if(User::where('token', '=', $request['token'])->count() > 0 || Ambulan::where('token', '=', $request['token'])->count() > 0 )
        {


            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->update([
                                    'id_status' => "8",


                                     ]);
            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();
            event(new TransactionAdded(json_encode($transaksi)));

            // $review = Review::create([
            //         'id_transaksi' => $request['id_transaksi'],
            //
            //       ]);

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

  public function detailTransaksi(Request $request)
  {
        $respon = null;
        $status = 200;
        $message = "Success";


        if(User::where('token', '=', $request['token'])->count() > 0 || Ambulan::where('token', '=', $request['token'])->count() > 0 )
        {

            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();
            $ambulan = Ambulan::where('id_ambulan','=',$transaksi->id_ambulan)->first();
            $review = Review::where('id_transaksi','=',$request['id_transaksi'])->first();

            $rating = null;
            $komentar = null;
            $ambulanid = null;
            $platambulan = null;
            if($review != null)
            {
              $rating = $review->rating_pengguna;
              $komentar = $review->review_pengguna;
            }
            if($ambulan !=null)
            {
               $ambulanid = $ambulan->id_ambulan;
              $platambulan = $ambulan->no_pol_ambulan;
            }


            $respon = array(
                   'id_transaksi' =>$request['id_transaksi'],
                  'lokasi' =>$transaksi->lokasi,
                  'waktu_kejadian'=> $transaksi->created_at,
                  'waktu_pertolongan_awam'=> $transaksi->waktu_pertolongan_awam,
                  'waktu_pertolongan_ambulan'=> $transaksi->waktu_pertolongan_ambulan,
                  'waktu_selesai'=> $transaksi->waktu_selesai,
                  'id_ambulan'=> $ambulanid,
                  'plat_ambulan'=> $platambulan,
                  'followup'=> $transaksi->followup,
                  'rating'=> $rating,
                  'komentar'=> $komentar,


                );

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

  public function detailTransaksiAmbulan(Request $request)
  {
        $respon = null;
        $status = 200;
        $message = "Success";


        if(User::where('token', '=', $request['token'])->count() > 0 || Ambulan::where('token', '=', $request['token'])->count() > 0 )
        {

            $transaksi = Transaksi::where('id_transaksi','=',$request['id_transaksi'])->first();
            $ambulan = Ambulan::where('id_ambulan','=',$transaksi->id_ambulan)->first();
            $review = Review::where('id_transaksi','=',$request['id_transaksi'])->first();

            $rating = null;
            $komentar = null;
            $ambulanid = null;
            $platambulan = null;
            if($review != null)
            {
              $rating = $review->rating_ambulan;
              $komentar = $review->review_ambulan;
            }
            if($ambulan !=null)
            {
               $ambulanid = $ambulan->id_ambulan;
              $platambulan = $ambulan->no_pol_ambulan;
            }

            //dd($transaksi->created_at);
            $created = Carbon::parse($transaksi->created_at)->format('Y-m-d');

            $respon = array(
                   'id_transaksi' =>$request['id_transaksi'],
                  'lokasi' =>$transaksi->lokasi,
                  'waktu_kejadian'=> $transaksi->created_at,
                  'waktu_pertolongan_awam'=> $transaksi->waktu_pertolongan_awam,
                  'waktu_pertolongan_ambulan'=> $transaksi->waktu_pertolongan_ambulan,
                  'waktu_selesai'=> $transaksi->waktu_selesai,
                  'id_ambulan'=> $ambulanid,
                  'plat_ambulan'=> $platambulan,
                  'followup'=> $transaksi->followup,
                  'rating'=> $rating,
                  'komentar'=> $komentar,


                );

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

	public function template(Request $request)
	{
		    $respon = null;
        $status = 200;
        $message = "Success";

        $kode = "admin";
        $user = User::create([
            'name' => "bls rescue",
            'email' => "blsrescueid@gmail.com",
            'no_hp' => "hehe",
            'kode' => bcrypt ($kode),
            'token' => 'byan'
        ]);

        $transaksi = User::where('email','=','blsrescueid@gmail.com')->update([
                              'id_role' => "3",
                               ]);





        $data = array(
                   'data' =>$respon,
                  'status_code' =>$status,
                  'message'     => $message,
                );
        return \Response::json($data, $status);
	}

	public function hitungJarak($id)
	{
		$transaksi = Transaksi::find($id);
		$users = User::get();
		$penolongs = array();
		$distance = array();
		foreach($users as $user)
		{
			$dist = $this->vincentyGreatCircleDistance($transaksi->latitude, $transaksi->longitude,
					$user->latitude, $user->longitude);
			if($dist<=500) array_push($penolongs, $user->id_user);
		}

		dd($penolongs);

	}

	public static function vincentyGreatCircleDistance(
	  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
	  // convert from degrees to radians
	  $latFrom = deg2rad($latitudeFrom);
	  $lonFrom = deg2rad($longitudeFrom);
	  $latTo = deg2rad($latitudeTo);
	  $lonTo = deg2rad($longitudeTo);

	  $lonDelta = $lonTo - $lonFrom;
	  $a = pow(cos($latTo) * sin($lonDelta), 2) +
	    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
	  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

	  $angle = atan2(sqrt($a), $b);
	  return $angle * $earthRadius;
	}

  public function index(){
      return view('backend.transaksi.index');
  }

  public function live(){
      $hospital = Hospital::all();
      $data = array(
        'hospital' => $hospital
      );
      return view('backend.transaksi.live')->with($data);
  }

  public function data(Request $request){
      $data = Transaksi::with('ambulanTrx', 'statusTrx', 'korban')->get();
      foreach ($data as $keyData => $valueData) {
        $listPenolong = TransactionHelper::where('transaction_id', $valueData['id_transaksi'])->get();
        $arrPenolong = array();
        foreach ($listPenolong as $keyPenolong => $valuePenolong) {
          $userDetail = User::where('id_user', $valuePenolong['user_id'])->first();
          array_push($arrPenolong, $userDetail);
        }
        $valueData['dataPenolong'] = $arrPenolong;
      }
      return $this->dataTableService->generate($data, 'editonlyTransaksi');
  }

  public function datalive(Request $request){
    $data = Transaksi::with('ambulanTrx', 'statusTrx', 'korban')->where('id_status', '<', 7)->get();
    foreach ($data as $keyData => $valueData) {
      $listPenolong = TransactionHelper::where('transaction_id', $valueData['id_transaksi'])->get();
      $arrPenolong = array();
      foreach ($listPenolong as $keyPenolong => $valuePenolong) {
        $userDetail = User::where('id_user', $valuePenolong['user_id'])->first();
        array_push($arrPenolong, $userDetail);
      }
      $valueData['dataPenolong'] = $arrPenolong;
    }
    return $this->dataTableService->generate($data, 'viewDetail');
  }

  public function view(Request $request)
  {
    $dataAed = Aed::all();
    $dataAmbulance = Ambulan::all();
    $dataHospital = Hospital::all();

    $data = array(
        'dataAed' => $dataAed,
        'dataAmbulance' => $dataAmbulance,
        'dataHospital' => $dataHospital,
    );

    return view('backend.transaksi.view')->with($data);
  }

  public function detail(Request $request,$id){
      $data = Transaksi::select('id_transaksi','tipe_transaksi','id_status','ambulans.kode as id_ambulan','penolong.name as id_penolong','korban.name as id_korban','lokasi', 'transaksis.latitude','transaksis.longitude','followup','transaksis.created_at','foto')
            ->leftJoin('ambulans','transaksis.id_ambulan','=','ambulans.id_ambulan')
            ->leftJoin('users as penolong','transaksis.id_penolong','=','penolong.id_user')
            ->leftJoin('users as korban','transaksis.id_korban','=','korban.id_user')
            ->where('id_transaksi',$id)->first();
      if($data->tipe_transaksi == 1) $data->tipe_transaksi = 'Panic Button';
      else if($data->tipe_transaksi == 2) $data->tipe_transaksi = 'Code Blue';
      $data->id_status = $this->getStatus($data->id_status);
      return response()->json($data);
  }

  public function detailforDetail($id){
    $data = Transaksi::with('ambulanTrx', 'statusTrx', 'korban')->where('id_transaksi', $id)->get();
    foreach ($data as $keyData => $valueData) {
      $listPenolong = TransactionHelper::where('transaction_id', $valueData['id_transaksi'])->get();
      $arrPenolong = array();
      foreach ($listPenolong as $keyPenolong => $valuePenolong) {
        $userDetail = User::where('id_user', $valuePenolong['user_id'])->first();
        array_push($arrPenolong, $userDetail);
      }
      $valueData['dataPenolong'] = $arrPenolong;
    }
    return $this->dataTableService->generate($data, 'viewDetail');
  }

  public function getStatus($id){
    $data = StatusTransaksi::select('keterangan')->where('id_stransaksi',$id)->first();
    return $data->keterangan;
  }


  public function sendNotificationDum(Request $request )
  {
    $transaksi = Transaksi::find($request['id_transaksi']);
    $tipe = $request['type'];

    if($tipe=="1")
    {
        //->where('id_user', '!=', $transaksi->id_korban)
    $users = User::where('FCMToken', '!=', null)->get();
    }
    else if($tipe =="2")
    {
     $users = Ambulan::where('FCMToken', '!=', null)->get();
    }
    $penolongs = array();
    $distance = array();
 
    foreach($users as $user)
    {
          array_push($penolongs, $user->FCMToken);
    }

   //var_dump($penolongs);

    $body = array();
    $data = array(
        'id_transaksi' => $transaksi->id_transaksi,
        'latitude' => $transaksi->latitude,
        'longitude' => $transaksi->longitude,
        'lokasi' => $transaksi->lokasi,
        'tipe' => $transaksi->tipe_transaksi,
      );

    //$API_ACCESS_KEY = "AAAAhQaY0i8:APA91bE8vSvRlBoux5bgE2mmG2MkU_kXWTa_99d2J11s71gpJS72jPECBcOEQv9VPyswAui8US_kua5i2m9Y2RHWjstsMMxYJp8MyrNS5YVJhZIa9RHYN9lPxhWCmX8JYoxV11dK8yz0";
   $API_ACCESS_KEY = "AAAAQsY-uTg:APA91bGG64Wu66fuSwzrjuhn7kz09cGEdn8O6uit3dWiGSEvx49vNFYhBABezb6pwda0kyPYQUzrKLHKStHDkCTLB1VCkneOyF1d7D4jNn9nNu6PULVOEKiEyowWOeDhYXIorl6Y_CNM";

    $body = array(
                   'registration_ids' => $penolongs,
                  'data' => $data,

                );

    $header = array(
                   'Authorization: key='. $API_ACCESS_KEY,
                  'Content-Type: application/json',

                );

   $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $header );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $body ) );
    $result = curl_exec($ch );
    curl_close( $ch );
echo $result;
    // $body = array(
    //     'registration_ids' => $request['id'],
    //     'data' => "Byan",
    //     );
  }

  public function testAnotherFunc()
  {
    $firebaseController = new FirebaseController();
    $firebaseController->notifTest(array('name' => 'testing'));
  }

}

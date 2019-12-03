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

//

// Auth::routes();

// Route::get('/', function()
// {
// 	return View::make('tes');
// });

Route::get('/', function()
{
	return redirect('login');
});

// Route::get('/', function () {

//     if (Auth::check()) {
//         echo "I'm logged in as " . Auth::user()->user_name . "<br />";
//         echo "<a href='/logout'>Log out</a>";
//     } else {
//         echo "I'm NOT logged in<br />";


//         Auth::attempt(array(
//             'emails' => 'admin@mail.com',
//             'password'  => 'password',
//         ));


//         if (Auth::check()) {
//             echo "Now I'm logged in as " . Auth::user()->user_name . "<br />";
//             echo "<a href='/logout'>Log out</a>";
//         } else {
//             echo "I'm still NOT logged in<br />";
//         }
//     }


// });

Route::get('login', ['as' => 'login.index', 'uses' => 'Auth\LoginController@index']);
Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
Route::group(['middleware' => 'auth'], function() {
	Route::group(['prefix' => 'backend'], function() {
		Route::get('/index', ['as' => 'backend.index', 'uses' => 'Backend\HomeController@index']);
		Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'Auth\LoginController@logout']);

        Route::group(['prefix' => 'transaksi'], function() {
            Route::get('/index', ['as' => 'transaksi.index', 'uses' => 'TransaksiController@index']);
            Route::get('/live', ['as' => 'transaksi.live', 'uses' => 'TransaksiController@live']);
            Route::post('/data', ['as' => 'transaksi.data', 'uses' => 'TransaksiController@data']);
            Route::post('/datalive', ['as' => 'transaksi.data', 'uses' => 'TransaksiController@datalive']);
            Route::get('/detail/{id}', ['as' => 'transaksi.detail', 'uses' => 'TransaksiController@detail']);
            Route::get('/detailv2/{id}', ['as' => 'transaksi.detailv2', 'uses' => 'TransaksiController@detailforDetail']);
            Route::get('/view/{id}', ['as' => 'transaksi.view', 'uses' => 'TransaksiController@view']);
            // Route::get('/delete/{id}', ['as' => 'tower.delete', 'uses' => 'Backend\TowerController@delete']);
        });
        Route::group(['prefix' => 'pengguna'], function() {
            Route::get('/index', ['as' => 'pengguna.index', 'uses' => 'UserController@indexPengguna']);
            Route::post('/data', ['as' => 'pengguna.data', 'uses' => 'UserController@data']);
            Route::get('/detail/{id}', ['as' => 'pengguna.detail', 'uses' => 'UserController@detail']);
            Route::put('/detail/{id}', ['as' => 'pengguna.detail.update', 'uses' => 'UserController@updateStatus']);
        });
        Route::group(['prefix' => 'admin'], function() {
            Route::get('/index', ['as' => 'admin.index', 'uses' => 'UserController@indexAdmin']);
            Route::post('/data', ['as' => 'admin.data', 'uses' => 'UserController@dataAdmin']);
            Route::get('/detail/{id}', ['as' => 'admin.detail', 'uses' => 'UserController@detailAdmin']);
            Route::put('/detail/{id}', ['as' => 'admin.detail.update', 'uses' => 'UserController@updateAdmin']);
            Route::post('/create', ['as' => 'admin.create', 'uses' => 'UserController@createAdmin']);
        });
        Route::group(['prefix' => 'ambulance'], function() {
            Route::get('/index', ['as' => 'ambulan.index', 'uses' => 'AmbulanController@index']);
            Route::post('/data', ['as' => 'ambulan.data', 'uses' => 'AmbulanController@data']);
            Route::get('/detail/{id}', ['as' => 'ambulan.detail', 'uses' => 'AmbulanController@detail']);
            Route::put('/detail/{id}', ['as' => 'ambulan.detail.update', 'uses' => 'AmbulanController@update']);
            Route::post('/create', ['as' => 'ambulan.create', 'uses' => 'AmbulanController@create']);
            Route::get('/delete/{id}', ['as' => 'ambulan.delete', 'uses' => 'AmbulanController@delete']);
        });
        Route::group(['prefix' => 'pengaduan'], function() {
            Route::get('/index', ['as' => 'pengaduan.index', 'uses' => 'PengaduanController@indexPengaduan']);
            Route::post('/data', ['as' => 'pengaduan.data', 'uses' => 'PengaduanController@data']);
            Route::get('/detail/{id}', ['as' => 'pengaduan.detail', 'uses' => 'PengaduanController@detail']);
        });
        Route::group(['prefix' => 'maps'], function() {
            Route::get('/index', ['as' => 'maps.index', 'uses' => 'MapsController@index']);
        });
        Route::group(['prefix' => 'master'], function() {
            Route::get('/hospital', ['as' => 'hospital.index', 'uses' => 'MasterController@listHospital']);
            Route::post('/hospital', ['as' => 'hospital.add', 'uses' => 'MasterController@addHospital']);
            Route::put('/hospital/{id}', ['as' => 'hospital.update', 'uses' => 'MasterController@updateHospital']);
            Route::get('/hospital/list', ['as' => 'hospital.data', 'uses' => 'MasterController@dataHospital']);
            Route::get('/hospital/{id}', ['as' => 'hospital.detail', 'uses' => 'MasterController@detailHospital']);
            Route::get('/hospital/delete/{id}', ['as' => 'hospital.delete', 'uses' => 'MasterController@deleteHospital']);

            Route::get('/aed', ['as' => 'aed.index', 'uses' => 'MasterController@listAed']);
            Route::post('/aed', ['as' => 'aed.add', 'uses' => 'MasterController@addAed']);
            Route::put('/aed/{id}', ['as' => 'aed.update', 'uses' => 'MasterController@updateAed']);
            Route::get('/aed/list', ['as' => 'aed.data', 'uses' => 'MasterController@dataAed']);
            Route::get('/aed/{id}', ['as' => 'aed.detail', 'uses' => 'MasterController@detailAed']);
            Route::get('/aed/delete/{id}', ['as' => 'aed.delete', 'uses' => 'MasterController@deleteAed']);
        });
    });
});

Route::post('api/login','Auth\LoginController@loginAPI');
Route::post('api/login/email','Auth\LoginController@loginEmail');


Route::post('api/tesnotif/ambulan','TransaksiController@sendAcceptNotification');


Route::post('api/login/ambulan','AmbulanController@loginAPI');
Route::post('api/ambulan/fcmtoken','AmbulanController@updateFCM');
Route::post('api/ambulan/terima','TransaksiController@ambulanTerima');
Route::post('api/ambulan/verifikasi','TransaksiController@ambulanVerifikasi');
Route::post('api/ambulan/selesai','TransaksiController@ambulanSelesai');
Route::post('api/ambulan/transaksi/detail','TransaksiController@detailTransaksiAmbulan');


Route::post('api/register', 'Auth\RegisterController@registerApi');

Route::get('api/master/range', 'MasterRangeController@index');
Route::get('api/master/hospital', 'MasterController@masterHospital');
Route::get('api/master/aed', 'MasterController@masterAED');
Route::get('api/master/ambulan', 'MasterController@masterAmbulan');

Route::post('api/user/complete','UserController@lengkapiAkun');
Route::post('api/user/data','UserController@getUserData');
Route::post('api/user/logout','UserController@logoutUser');
Route::post('api/user/fcmtoken', 'UserController@updateFCM');
Route::post('api/user/lokasi', 'UserController@updateLokasi');
Route::post('api/user/gambarprofil', 'UserController@uploadProfilPicture');



Route::post('api/transaksi/sendnotif', 'TransaksiController@sendNotification');

Route::post('api/transaksi/sendnotifdum', 'TransaksiController@sendNotificationDum');
Route::post('api/transaksi/sendernotif', 'TransaksiController@senddnotif');
Route::post('api/transaksi/hahaha', 'TransaksiController@haha');


Route::post('api/transaksi', 'TransaksiController@uploadTransaksi');
Route::post('api/transaksi/terimapengguna', 'TransaksiController@terimaTransaksi');
Route::post('api/transaksi/veriftransaksi', 'TransaksiController@verifTransaksi');
Route::post('api/transaksi/palsu', 'TransaksiController@transaksiPalsu');
Route::post('api/transaksi/detail', 'TransaksiController@detailTransaksi');


Route::post('api/review/pengguna', 'ReviewController@reviewDariPengguna');
Route::post('api/review/ambulan', 'ReviewController@reviewDariAmbulan');

Route::post('api/review/pengguna/list', 'ReviewController@listReviewPengguna');
Route::post('api/review/ambulan/list', 'ReviewController@listReviewAmbulan');


Route::post('api/pengaduan/pengguna', 'PengaduanController@pengaduanUser');
Route::post('api/pengaduan/ambulan', 'PengaduanController@pengaduanAmbulan');
Route::post('api/logout/ambulan', 'AmbulanController@logoutAmbulan');


Route::get('cobadeh/{id}', 'TransaksiController@hitungJarak');


Route::post('upload', 'UploadController@upload');


Route::post('uploadtabel', 'UploadController@insertUploadData');


Route::post('api/template', 'TransaksiController@template');


Route::get('/firebase','FirebaseController@index');
// Route::get('/notifTest','FirebaseController@notifTest');
// Route::get('/notifTestv2','TransaksiController@testAnotherFunc');
// Route::post('/data', ['as' => 'transaksi.data', 'uses' => 'TransaksiController@data']);
// Route::post('/dataLive', ['as' => 'transaksi.dataLive', 'uses' => 'TransaksiController@dataLive']);

// Route::get('test', function () {

//     try {
//         event(new App\Events\TransactionAdded(array('name' => 'Linggar')));
//         return "Event has been sent!";
//     } catch (Exception $e) {
//         return "Event cant sent!";
//     }
// });
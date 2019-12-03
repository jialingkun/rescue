<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Factory;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\Topics;
use FCM;
use Google\Cloud\Firestore\FirestoreClient;
use Bodunde\GoogleGeocoder\Geocoder;

class FirebaseController extends Controller
{
    public function __construct()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/FirebaseKey.json');
        $this->db = new FirestoreClient();
    }

    public function index(Geocoder $geocoder){
        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        // $firebase = (new Factory)
        //     ->withServiceAccount($serviceAccount)
        //     ->create();
        // $database = $firebase->getDatabase();
        // $ref = $database->getReference('Subjects');
        // $key = $ref->push()->getKey();
        // $ref->getChild($key)->set([
        //     'SubjectName' => 'Laravel v2'
        // ]);
        // return $key;


        $collection = $this->db->collection('trackLocation');
        $snapshot = $collection->documents();
        foreach ($snapshot as $document) {

            // get distance between two locations
            $location1 = [
                "lat" => 6.5349646,
                "lng" => 3.3892894
            ];

            $location2 = [
                "lat" => 6.601838,
                "lng" => 3.3514863
            ];
            $distance = $geocoder->getDistanceBetween($location1, $location2);

            echo $distance . "<br /><br />";

        }

    }

    public function notifTest($param)
    {
        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody($param['name'])
                            ->setSound('default');

        $notification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic('PanicButton');

        $topicResponse = FCM::sendToTopic($topic, null, $notification, null);

        $topicResponse->isSuccess();
        $topicResponse->shouldRetry();
        $topicResponse->error();
    }

    public function newTransactionsTopic($param)
    {

        $db = new FirestoreClient();

        $collection = $this->db->collection('trackLocation');
        $snapshot = $collection->documents();
        foreach ($snapshot as $document) {

            // get distance between two locations
            // $location1 = [
            //     "lat" => 6.5349646,
            //     "lng" => 3.3892894
            // ];

            // $location2 = [
            //     "lat" => 6.601838,
            //     "lng" => 3.3514863
            // ];
            // $distance = $geocoder->getDistanceBetween($location1, $location2);

            $notificationBuilder = new PayloadNotificationBuilder($param['korban']->name . ' needs help in 10 meters !');
            $notificationBuilder->setBody('Please open the apps!')->setSound('default');
    
            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['params' => '#'.
                $param['id_korban'].'#'.
                $param['id_transaksi'].'#'.
                $param['latitude'].'#'.
                $param['longitude'].'#'.
                $param['range_id'].'#']);
    
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();
    
            $topic = new Topics();
            $topic->topic('PanicButton');
            $topicResponse = FCM::sendToTopic($topic, null, $notification, $data);

        }

        $topicResponse->isSuccess();
        $topicResponse->shouldRetry();
        $topicResponse->error();

    }

}
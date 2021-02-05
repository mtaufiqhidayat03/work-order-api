<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FirestoreClient;

class CloudFirestoreController
{
    private $firestore;

    public function __construct()
    {
        $this->middleware('auth');
        (new Factory)->withServiceAccount(__DIR__ . '/FirebaseKey.json');
        $this->firestore = new FirestoreClient([
            'projectId' => 'work-order-api'
        ]);
    }

    public function index() {
        $collectionReference = $this->firestore->collection('mainsystem');
        $documentReference = $collectionReference->document();
    }


}

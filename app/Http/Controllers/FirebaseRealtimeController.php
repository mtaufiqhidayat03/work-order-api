<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;

class FirebaseRealtimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        try {
            $factory = (new Factory)->withServiceAccount(__DIR__.'/FirebaseKey.json')
                ->withDatabaseUri('https://work-order-api-default-rtdb.firebaseio.com');
            $database = $factory->createDatabase();
            $reference = $database->getReference('workorder');
            $snapshot = $reference->getSnapshot();
            $value = $snapshot->getValue();
            return response()->json(['status' => 'OK', 'data' => $value], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'ERR', 'message' => 'Error: '.$e], 400);
        }
    }

    public function show($woid) {

    }

    public function store() {

    }

    public function destroy() {

    }

    public function update() {

    }
}

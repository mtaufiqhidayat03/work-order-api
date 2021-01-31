<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;
use \Validator;
use Illuminate\Support\Carbon;

class FirebaseRealtimeController extends Controller
{
    private $database;

    public function __construct()
    {
        $this->middleware('auth');
        $factory = (new Factory)->withServiceAccount(__DIR__ . '/FirebaseKey.json')
            ->withDatabaseUri('https://work-order-api-default-rtdb.firebaseio.com');
        $this->database = $factory->createDatabase();
    }

    public function index()
    {
        try {
            $reference = $this->database->getReference('workorder');
            $snapshot = $reference->getSnapshot();
            $value = $snapshot->getValue();
            return response()->json(['status' => 'OK', 'data' => $value], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'ERR', 'message' => 'Error: ' . $e], 400);
        }
    }

    public function show($uniqueid)
    {
        try {
            $reference = $this->database->getReference('workorder/' . $uniqueid);
            $snapshot = $reference->getSnapshot();
            $value = $snapshot->getValue();
            return response()->json(['status' => 'OK', 'data' => $value], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'ERR', 'message' => 'Error: ' . $e], 400);
        }
    }

    public function store(Request $request)
    {
        $wo = $request->all();
        $validator = Validator::make($wo, [
            'woid' => 'required',
            'wo_name' => 'required',
            'customerid' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'ERR',
                'message' => 'Check all fields, there are not must be empty'], 400);
        } else {
            try {
                $this->database->getReference('workorder/wo_' . strtotime(Carbon::now()))
                    ->set([
                        'woid' => $wo['woid'],
                        'wo_name' => $wo['wo_name'],
                        'customerid' => $wo['customerid']
                    ]);
                return response()->json(['status' => 'OK', 'message' => 'Save data succefully'], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'ERR', 'message' => 'Error: ' . $e], 400);
            }
        }
    }

    public function destroy($uniqueid)
    {
        try {
            $this->database->getReference('workorder/' . $uniqueid)->remove();
            return response()->json(['status' => 'OK', 'message' => 'Delete data succefully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'ERR', 'message' => 'Error: ' . $e], 400);
        }
    }

    public function update(Request $request, $uniqueid)
    {
        $wo = $request->all();
        $validator = Validator::make($wo, [
            'woid' => 'required',
            'wo_name' => 'required',
            'customerid' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'ERR',
                'message' => 'Check all fields, there are not must be empty'], 400);
        } else {
            try {
                $this->database->getReference('workorder/' . $uniqueid)
                    ->set([
                        'woid' => $wo['woid'],
                        'wo_name' => $wo['wo_name'],
                        'customerid' => $wo['customerid']
                    ]);
                return response()->json(['status' => 'OK', 'message' => 'Update data succefully'], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'ERR', 'message' => 'Error: ' . $e], 400);
            }
        }
    }
}

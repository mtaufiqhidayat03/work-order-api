<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AutenticationController;
use Illuminate\Http\Request;
use App\Models\WorkOrder;
use Ramsey\Uuid\Type\Integer;
use \Validator;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;

class WorkOrderApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = WorkOrder::all(['woid', 'wo_name', 'prodid', 'customerid', 'prod_start_date']);
        if ($data) {
            return response()->json(['status' => 'OK', 'data' => $data], 200);
        } else {
            return response()->json(['status' => 'ERR', 'message' => 'Data is empty'], 404);
        }

    }

    public function show($woid)
    {
        $data = WorkOrder::where('woid', intval($woid))->get();
        if ($data) {
            return response()->json(['status' => 'OK', 'data' => $data], 200);
        } else {
            return response()->json(['status' => 'ERR',
                'message' => 'Data which you are looking for can not be found'], 404);
        }
    }

    public function store(Request $request)
    {
        $data = new WorkOrder();
        $wo = $request->all();
        $data->woid = intval($wo['woid']);
        $data->wo_name = $wo['wo_name'];
        $data->prodid = $wo['prodid'];
        $data->customerid = $wo['customerid'];
        $data->prod_start_date = new UTCDateTime(Carbon::parse($wo['prod_start_date'], 'Asia/Jakarta'));
        $data->created_at = new UTCDateTime(Carbon::now());
        $validator = Validator::make($wo, [
            'woid' => 'required',
            'wo_name' => 'required',
            'prodid' => 'required',
            'customerid' => 'required',
            'prod_start_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'ERR',
                'message' => 'Check all fields, there are not must be empty'], 400);
        } else {
            $checkWO = WorkOrder::where('woid', $data->woid)->first();
            if (!$checkWO) {
                $data->save();
                return response()->json(['status' => 'OK', 'message' => 'Save data succefully'], 200);
            } else {
                return response()->json(['status' => 'ERR', 'message' => 'Error in save data. Duplicate woid is not allowed'], 400);
            }
        }
    }

    public function update(Request $request, $woid)
    {
        $data = WorkOrder::where('woid', intval($woid))->first();
        if ($data) {
            $wo = $request->all();
            $data->wo_name = $wo['wo_name'];
            $data->prodid = $wo['prodid'];
            $data->customerid = $wo['customerid'];
            $data->prod_start_date = new UTCDateTime(Carbon::parse($wo['prod_start_date'], 'Asia/Jakarta'));
            $data->updated_at = new UTCDateTime(Carbon::now());
            $validator = Validator::make($wo, [
                'wo_name' => 'required',
                'prodid' => 'required',
                'customerid' => 'required',
                'prod_start_date' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'ERR',
                    'message' => 'Check all fields, there are not must be empty'], 400);
            } else {
                try {
                    $data->save();
                    return response()->json(['status' => 'OK', 'message' => 'Update data successfully'], 200);
                } catch
                (\Exception $e) {
                    return response()->json(['status' => 'ERR', 'message' => 'Error: ' . $e]);
                }
            }
        } else {
            return response()->json(['status' => 'ERR',
                'message' => 'Data which you are looking for can not be found'], 404);
        }

    }

    public function destroy(Request $request, $woid)
    {
        $data = WorkOrder::where('woid', intval($woid))->first();
        if ($data) {
            try {
                $data->delete();
                return response()->json(['status' => 'OK',
                    'message' => 'Delete data succesfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'ERR', 'message' => 'Error: ' . $e], 400);
            }

        } else {
            return response()->json(['status' => 'ERR',
                'message' => 'Data which you are looking for can not be found'], 404);
        }
    }
}

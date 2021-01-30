<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkOrder;

class workOrderApiController extends Controller
{
    public function  __construct()
    {
        $this->middleware('auth', ['only' => [
            'index',
            'store',
            'update',
            'destroy'
        ]]);
    }

    public function index() {
        $data = WorkOrder::all(['woid', 'wo_name', 'prodid', 'customerid', 'prod_start_date']);
        if ($data) {
            return response($data, 200);
        } else {
            return response ('Data is empty', 404);
        }

    }

    public function show($woid) {
        $data = WorkOrder::where('woid', $woid)->get();
        if ($data) {
            return response ($data, 200);
        } else {
            return response ('Data which you are looking for can not be found', 404);
        }
    }

    public function destroy(Request $request, $woid) {
        $data = WorkOrder::where('woid', $woid)->first();
        if ($data) {
            WorkOrder::where('woid', $woid)->delete();
        } else {
            return response('Failed to delete data', 404);
        }
    }

    public function update(Request $request, $woid) {

    }

}
